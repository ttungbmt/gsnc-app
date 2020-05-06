<script>
    $(function() {
        let selector = 'select[name="<?=$selector?>"]'
        let depdrop = window[$(selector).data('krajeeDepdrop')]
        $('#<?=$pjaxContainer?>').on('pjax:complete', () => {
            let query = URI(window.history.state.url).query()
            let params = URI.parseQuery(query)
            let maphuong = _.get(params, '<?=$selector?>')

            let depdropOptions = Object.assign({}, depdrop, {
                ajaxSettings: {data: {value: maphuong}},
                initialize: true,
            })

            let $el = $(selector)
            !$el.data('depdrop') || $el.depdrop('destroy')
            $el.depdrop(depdropOptions);
        })
    });
</script>