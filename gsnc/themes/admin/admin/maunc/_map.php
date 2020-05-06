<script src=<?='/libs/bower/leaflet/dist/leaflet-src.js'?>></script>
<link rel="stylesheet" href=<?= '/libs/bower/leaflet/dist/leaflet.css' ?>/>

<script src=<?='/libs/bower/leaflet-draw/dist/leaflet.draw.js'?>></script>
<link rel="stylesheet" href=<?= '/libs/bower/leaflet-draw/dist/leaflet.draw.css'?>/>

<script src=<?='/libs/bower/leaflet.contextmenu/dist/leaflet.contextmenu.js'?>></script>
<link rel="stylesheet" href=<?='/libs/bower/leaflet.contextmenu/dist/leaflet.contextmenu.css'?>/>

<script src=<?='/libs/bower/leaflet-google-places-autocomplete/src/js/leaflet-gplaces-autocomplete.js'?>></script>
<link rel="stylesheet" href=<?='/libs/bower/leaflet-google-places-autocomplete/src/css/leaflet-gplaces-autocomplete.css'?>/>

<style>
    .leaflet-gac-wrapper{
        position: relative;
        height: 40px;
    }
    .leaflet-control-container .leaflet-gac-control{
        height: 40px;
    }
    .leaflet-gac-wrapper .icon-cross2 {
        position: absolute;
        right: 2%;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
    }
    .leaflet-touch .leaflet-left .leaflet-bar{
        border: none;
    }

    #predictions{
        position: absolute;
        bottom: 0;
        left: 0;
        max-height: 400px;
        width: 320px;
        z-index: 1000;
        transition: .3s ease;
    }

    .toggle-result{
        width: 20px;
        height: 40px;
        right: -20px;
        bottom: 10px;
        position: absolute;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: rgba(255, 255, 255, 0.7);
        border: 1px solid #ddd;
        border-left: none;
        box-shadow: 2px 2px 5px #eee;
        transition: .3s ease;
        cursor: pointer;
    }
    .toggle-result>span{
        color: #222;
    }

    .behide-search-box{
        background-color: #4285F4;
        height: 60px;
        width: 100%;
        position: relative;
    }
    #results:before{
        box-shadow: 0 2px 2px rgba(0, 0, 0, 0.3);
        z-index: 1;
        content: '';
        width: 100%;
        height: 3px;
        margin-top: -3px;
        position: absolute;
    }

    #results {
        background-color: #fff;
        overflow-y: scroll;
        overflow-x: hidden;
        height: 340px;
        padding-left: 0px;
    }

    /* width */
    #results::-webkit-scrollbar {
        width: 7px;
    }
    /* Track */
    #results::-webkit-scrollbar-track {
        background: #f0f0f0;
    }
    /* Handle */
    #results::-webkit-scrollbar-thumb {
        background: #888;
    }
    /* Handle on hover */
    #results::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
    .section-result-content {
        padding: 10px 20px;
        border-bottom: 1px solid #ccc;
        cursor: pointer;
    }
    .section-result-content:hover {
        background-color: #f0f0f0;
    }
    .txt-header {
        font-size: 15px;
        font-weight: 600;
    }
    .txt-address {
        font-size: 13px;
        font-weight: 300;
        font-style: italic;
    }
</style>

<div style="position: relative;">
    <div id="predictions" style="display: none;">
        <div class="behide-search-box"></div>
        <ul id="results"></ul>
        <div class="toggle-result">
            <span class="glyphicon glyphicon-triangle-left"></span>
        </div>
    </div>
    <div id="map" style="height: 400px; width: 100%"></div>
</div>
<script>
    $(function(){
        mbUrl = 'https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibGFtcXVhbmdoYSIsImEiOiJjaXJwemptcjYwZzh5dGNua2JnOHQ0eTJrIn0.GkBjp6wN-55lY1UiHDLqjw';

        /**
         * Create map
         **/
        let map = L.map('map', {
            contextmenu: true,
            drawControl: false,
            zoomControl: false,
            contextmenuWidth: 140,
            contextmenuItems: [{
                text: 'Đặt làm vị trí',
                callback: function(e){
                    addMaker(e.latlng.lat, e.latlng.lng);
                },
            }]
        }).setView([10.762622, 106.660172], 11);

        /**
         * Create zoonControl to bottomright
         **/

        L.control.zoom({
            position:'bottomright'
        }).addTo(map);

        /**
         * Create tile layer
         **/

        let googleLayer = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',{
            subdomains:['mt0','mt1','mt2','mt3']
        }).addTo(map);
        let mapboxLayer = L.tileLayer(mbUrl, {id: 'mapbox.streets'});
        let hcmgisLayer = L.tileLayer.wms('http://pcd.hcmgis.vn/geoserver/gwc/service/wms', {
            layers: 'hcm_map:hcm_map_all',
            format: 'image/png',
            transparent: true,
            attribution: "HCMGIS"
        });

        /**
         * Add google place autocomplete to map
         * Search and add marker for address
         **/

        new L.Control.GPlaceAutocomplete({
            position: 'topleft',
            callback: function(place){
                let loc = place.geometry.location;
                map.setView( [loc.lat(), loc.lng()], 18);
                addMaker(loc.lat(), loc.lng());
            }
        }).addTo(map);

        /**
         * Add control layer to map
         **/

        let baseLayer = {
            "Google": googleLayer,
            "Mapbox": mapboxLayer,
            "HCMGIS": hcmgisLayer,
        }

        L.control.layers(baseLayer).addTo(map);

        /**
         * Add new marker to map
         * Remove marker if exist
         * Enable Drag marker
         **/

        let marker = {},
            flag = <?=$model->isNewRecord ? 1 : 0 ?>;

        if(!flag) {
            let lat = <?=$model->lat ? $model->lat : var_dump("null" == NULL) ?>;
            let lng = <?=$model->lng ? $model->lng : var_dump("null" == NULL) ?>;
            if(lat && lng){
                addMaker(lat, lng);
                map.setView( [lat, lng], 18);
            }
        }

        function addMaker (lat, lng) {

            $('#maunc-lat').val(lat);
            $('#maunc-lng').val(lng);

            if(marker != undefined) {
                map.removeLayer(marker)
            }

            marker = new L.marker([lat, lng], {
                contextmenu: true,
                contextmenuWidth: 140,
                contextmenuItems: [{
                        text: 'Xóa vị trí',
                        index: 0,
                        callback: removeMaker
                    },{
                        text: 'Gán địa chỉ',
                        index: 1,
                        callback: addAddress,
                    },{
                        separator: true,
                        index: 2
                    }],
                draggable: 'true'
            });

            marker.on('dragend', function ondragend() {
                let m = marker.getLatLng();
                $('#maunc-lat').val(m.lat);
                $('#maunc-lng').val(m.lng);
            });

            map.addLayer(marker);
        }

        function removeMaker() {
            $('#maunc-lat').val(null);
            $('#maunc-lng').val(null);
            map.removeLayer(marker)
        }

        function addAddress(e) {
            let geocoder = new google.maps.Geocoder;

            geocoder.geocode({'location': e.latlng}, function(results, status) {
                if (status === google.maps.GeocoderStatus.OK) {
                    if (results[1]) {
                        getPlaceDetail(results[1].place_id, function(detail) {
                            $('#maunc-diachi').val(detail.formatted_address);
                        });
                      } else {
                        window.alert('Không thể lấy được địa chỉ của vị trí');
                      }
                } else {
                  window.alert('Không thể lấy được địa chỉ của vị trí, Lỗi: ' + status);
                }
              });
        }

        /**
         * If enter key down, use prediction
        **/
        $(".leaflet-gac-control").keypress(function (e) {
            let keycode = (e.keyCode ? e.keyCode : e.which);
            if (keycode == '13' && $(this).val()) {
                let keysearch = $(".leaflet-gac-control").val();
                initService(keysearch);

                $(".leaflet-gac-control").blur();
                $("#predictions").css('display', 'block');

                let btn_control = $(".toggle-result span");
                if (btn_control.hasClass('glyphicon-triangle-right')){
                    $('#predictions').css('width', '320px');
                    btn_control.removeClass('glyphicon-triangle-right');
                    btn_control.addClass('glyphicon-triangle-left');
                }
            }
        })

        /**
         * If delete all text in search input, hidden prediction table
        **/
        $(".leaflet-gac-control").on('input', function (e) {
            let value = e.target.value;
            if (value.length === 0) {
                $("#predictions").css('display', 'none');
            }
        })


        /**
         * Get prediction return and dislay to prediction table
        **/
        function initService(keysearch) {
            let displaySuggestions = function(predictions, status) {

                if (status != google.maps.places.PlacesServiceStatus.OK) {
                    alert(status);
                    return;
                }

                $("#results").empty();
                predictions.forEach(function(prediction) {
                    getPlaceDetail(prediction.place_id, function(detail) {
                        let li = document.createElement('li');
                        li.innerHTML =  '<div class="section-result-content">' +
                                            '<div class="txt-header">' + detail.name + '</div>' +
                                            '<div class="txt-address">' + detail.formatted_address + '</div>' +
                                        '</div>';

                        document.getElementById('results').appendChild(li);
                        li.addEventListener('click', function(){
                            /**
                             * Add marker to map
                            **/
                            let loc = detail.geometry.location;
                            map.setView( [loc.lat(), loc.lng()], 18);
                            addMaker(loc.lat(), loc.lng());
                        }, false);
                    });

                })
            };

            let service = new google.maps.places.AutocompleteService();
            service.getQueryPredictions({
                input: keysearch
            }, displaySuggestions);
        }

        /**
         * Get place detail from place id
        **/
        function getPlaceDetail(placeId, fn) {
            let placeDetail;
            let service = new google.maps.places.PlacesService(document.createElement('div'));
            service.getDetails({
              placeId
            }, function(place, status) {
              if (status === google.maps.places.PlacesServiceStatus.OK) {
                fn(place);
              }
            });
        }

        $(".toggle-result span").click(function (){
            /**
             * If visible, hidden it
             **/
            if ($(this).hasClass('glyphicon-triangle-left')){
                $('#predictions').css('width', 0);
                $(this).removeClass('glyphicon-triangle-left');
                $(this).addClass('glyphicon-triangle-right');
            }
            /**
             * If hidden, visible it
             **/
            else if ($(this).hasClass('glyphicon-triangle-right')){
                $('#predictions').css('width', '320px');
                $(this).removeClass('glyphicon-triangle-right');
                $(this).addClass('glyphicon-triangle-left');
            }

        })

        /**
         * Add icon close to input
         **/
        let btnDelete = '<span class="icon-cross2" id="close-result"></span>';
        $('.leaflet-gac-wrapper').append(btnDelete);

        $('#close-result').click(function (){
            $('#predictions').css('display', 'none');
            $('.leaflet-gac-control').val(null);
        })

    })
</script>