<?php

namespace gsnc\controllers\admin;

use gsnc\controllers\GsncController;
use gsnc\forms\VtOnhiemImportForm;
use gsnc\models\DmPhuong;
use gsnc\models\DmOnhiem;
use gsnc\models\VtOnhiem;
use common\forms\UploadForm;
use common\libs\excel\Excel;
use yii\data\ArrayDataProvider;
use yii\base\Model;
use yii\helpers\Html;

class VtOnhiemImportController extends GsncController
{
    public $enableCsrfValidation = false;

    protected $modelClass = 'gsnc\forms\VtOnhiemImportForm';

    protected $sampleFile = 'storage/samples/vt-onhiem-import.xlsx';
    public $validateHeader = ['maquan', 'maphuong', 'diachi', 'ten', 'onhiem_id','ghichu', 'lat', 'lng'];
    public function actionIndex()
    {
        $model = new UploadForm();
        $excel = new Excel();

        if ($model->load(request()->post())) {

            if ($model->validateForm()) {

                list($fileName, $type) = [$model->file->tempName, request('type')];

                /**
                 * Check format column of file Excel input
                 **/

                $header = $excel->readSheetHeader($fileName, 4);
//                $excel->headers = $header;

                /**
                 * Compare file excel with array validateHeader to check format header of file excel
                 **/

                $diff = array_diff($this->validateHeader, array_values($header));

                if (!empty($diff)) {
                    $this->data['models'] = "Excel k đúng định dạng. Phải tồn tại các cột: <b>" . implode(', ', $this->validateHeader) . "</b>";

                    return $this->renderJson([
                        'html' => $this->renderAjax('_errors', $this->data)
                    ]);
                }

                $data = collect($excel->import($fileName, 4))->map(function ($item) {
                    return (new $this->modelClass($item));
                })->all();

                $models = $data;

                $this->data['page'] = request()->post('page', 0);
                $this->data['dataProvider'] = new ArrayDataProvider([
                    'allModels'  => $models,
                    'pagination' => [
                        'pageSize' => 20,
                        'page'     => $this->data['page']
                    ]
                ]);
                $passes = Model::validateMultiple($models);

                $this->data['models'] = $models;

                switch ($type) {
                    case 'preview':
                        $pages = explode(',', request()->post('pages', null));
                        $pages = collect(explode(',', request()->post('pages', null)))->filter(function ($item) {
                            return $item !== '';
                        })->all();

                        if (in_array($this->data['page'], $pages)) {
                            $this->data['message'] = 'Dữ liệu đã được nhập';
                            $this->data['hideBtnImport'] = true;
                        }
                        break;
                    case 'save':
                        $models = $this->data['dataProvider']->getModels();

                        $name = class_basename(new $this->modelClass);
                        if (Model::loadMultiple($models, request()->all(), $name) && Model::validateMultiple($models)) {
                            $this->saveModels($models);
                        }

                        break;

                    case 'save-all':
                        if ($passes) {
                            $this->saveModels($models);
                        }
                        break;
                }
                return $this->renderJson([
                    'html' => $this->renderAjax('_preview', $this->data)
                ]);

            } else {

                $this->data['models'] = [$model];

                return $this->renderJson([
                    'html' => $this->renderAjax('_errors', $this->data)
                ]);
            }
        }

        return $this->render('index', [

            'model'      => $model,
            'sampleFile' => asset($this->sampleFile)
        ]);
    }
    protected function saveModels($models)
    {
        if ($this->validateModels($models, new VtOnhiem())) {

            $count = count($models);
            $this->data['message'] = 'Đã lưu thành công ' . Html::a($count . ' đối tượng', '#', ['class' => 'alert-link']);
            $this->data['page'] = request('page');
        }
    }

    protected function validateModels(&$data, $vtOnhiem)
    {
        $data = collect($data)->map(function ($item) {
            return $item->attributes();
        })->values()->all();

        foreach ($data as $k => $row) {
            $list_loaionhiem = DmOnhiem::find()->select('id, maloai')->asArray()->all();
            $dm_phuong = DmPhuong::find()->select('maphuong, maquan, tenphuong_en, tenquan_en')->asArray()->all();

            foreach ($row as $key => $value) {

                foreach ($list_loaionhiem as $loaionhiem) {
                    if ($row['onhiem_id'] === $loaionhiem['maloai']) {
                        $row['onhiem_id'] = $loaionhiem['id'];
                    }
                }
                /**
                 * Convert 'maquan', 'maphuong' from name to key
                 * Ex: Cần Giờ => 787, Bình Chánh => 78727667
                 **/
                $tenquan = $row['maquan'];
                foreach ($dm_phuong as $p) {
                    if(str_slug($tenquan) == str_slug($p['tenquan_en'])) {
                        $row['maquan'] = $p['maquan'];
                    }
                    if (str_slug($tenquan) == str_slug($p['tenquan_en'])
                        && str_slug($row['maphuong']) == str_slug($p['tenphuong_en'])) {
                        $row['maphuong'] = $p['maphuong'];
                    }
                }
            }
            $data[$k] = $row;
        }

        $modelsVtOnhiem = array_fill(0, count($data), $vtOnhiem);

        if (Model::loadMultiple($modelsVtOnhiem, $data, '') && Model::validateMultiple($modelsVtOnhiem)) {

            foreach ($data as $row) {

                $vtOnhiem = new VtOnhiem();
                $vtOnhiem->setAttributes($row);
                if($vtOnhiem->lng && $vtOnhiem->lat){
                    $vtOnhiem->geom = [$vtOnhiem->lng, $vtOnhiem->lat];
                }
                $vtOnhiem->save();


            }
            return true;
        }

        $this->data['errors'] = $modelsVtOnhiem;

        return false;
    }
    public function vn_to_str ($str){
        $str = trim($str);
        $unicode = array(
            'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
            'd'=>'đ',
            'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'i'=>'í|ì|ỉ|ĩ|ị',
            'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
            'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'D'=>'Đ',
            'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
            'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        );

        foreach($unicode as $nonUnicode=>$uni){
            $str = preg_replace("/($uni)/i", $nonUnicode, $str);
        }
        $str = str_replace(' ','_',$str);

        return strtoupper($str);
    }
}
