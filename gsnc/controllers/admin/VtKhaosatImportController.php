<?php
namespace gsnc\controllers\admin;

use common\controllers\ImportTrait;
use gsnc\controllers\GsncController;
use gsnc\models\DmPhuong;
use gsnc\models\DmQuan;
use gsnc\models\MetaYkien;
use gsnc\models\VtKhaosat;
use yii\base\Model;

class VtKhaosatImportController extends GsncController
{
    use ImportTrait;

    public $enableCsrfValidation = false;
    protected $modelImportClass = 'gsnc\forms\VtKhaosatImportForm';
    protected $modelClass = 'gsnc\models\VtKhaosat';

    protected function options()
    {
        return [
            'header' => array_merge(['stt', 'donvikhaosat',  'maquan', 'maphuong', 'diachi', 'tenchuho', 'ngaykhaosat', 'vs', 'hl_xn', 'hl_mt', 'hl_vs', 'lat', 'lng'], range(1, 41)),
            'sample' => '/gsnc/storage/samples/vt-khaosat-import.xlsx'
        ];
    }
    protected function prepareData()
    {
        $this->data['dm_quan'] = DmQuan::find()->select(['tenquan' => 'tenquan_en', 'maquan'])->asArray()->indexBy('maquan')->all();
        $this->data['dm_phuong'] = DmPhuong::find()->select([
            'maquan',
            'tenquan' => 'tenquan_en',
            'maphuong',
            'tenphuong' => 'tenphuong_en'
        ])->asArray()->indexBy('maphuong')->all();
        $this->data['dm_chitieu'] = MetaYkien::find()->pluck('id')->all();
    }

    protected function rules(&$model)
    {
        $model->dm_quan = $this->data_get('dm_quan');
        $model->dm_phuong = $this->data_get('dm_phuong');
        $model->dm_chitieu = $this->data_get('dm_chitieu');
        $model->qcvn_id = 1;
    }

    protected function validateModels($exModels)
    {
        $data = [];
        $models = [];

        foreach ($exModels as $k => $i) {
            $data[$k] = $i->toArray();
            $models[$k] = new VtKhaosat();

            $models[$k]->data_cts = data_get($data[$k], 'chitieus', []);
        }

        // Validate model and relation 2rd
        if (
            Model::loadMultiple($models, $data, '') &&
            Model::validateMultiple($models)
        ) {
            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
                $this->saveModels($models, $data, $connection);
                $transaction->commit();
                return true;
            } catch (\Exception $e) {
                $transaction->rollback();
                dd($e);
            }
            return true;
        }

        $this->data['models'] = $models;
        return false;
    }

    protected function saveModels($models, $data, $connection)
    {
        $chitieus = [];
        foreach ($models as $m){
            $m->save();
            foreach ($m->data_cts as $v){
                $chitieus[] = [
                    $m->id,
                    $v['meta_ykien_id'],
                    $v['giatri'],
                ];
            }
        }

        $connection->createCommand()->batchInsert('vt_ks_ykien', ['vt_khaosat_id', 'meta_ykien_id', 'giatri'], $chitieus)->execute();
    }

//
//    protected $modelClass = 'gsnc\forms\VtKhaosatImportForm';
//
//    protected $sampleFile = 'storage/samples/vt-khaosat-import.xlsx';
//
//    /**
//     * Static data, save to VtKhaosat
//     * Array will compare with header of excel file to validate
//     **/
//    public $validateHeader = ['maquan', 'maphuong', 'diachi', 'tenchuho', 'ngaykhaosat', 'lat', 'lng'];
//
//    public function actionIndex()
//    {
//        $model = new UploadForm();
//        $excel = new Excel();
//
//        $ds_ykiens = MetaYkien::find()->orderBy('id ASC')->pluck('ten', 'id')->all();
//
//        /**
//         * Add list of MetaYkien to array validateHeader
//         **/
//        foreach ($ds_ykiens as $k => $ykien) {
//            array_push($this->validateHeader, $k);
//        }
//        if ($model->load(request()->post())) {
//
//            if ($model->validateForm()) {
//
//                list($fileName, $type) = [$model->file->tempName, request('type')];
//
//                $header = $excel->readSheetHeader($fileName, 4);
//                $diff = array_diff($this->validateHeader, array_values($header));
//
//                if (!empty($diff)) {
//                    $this->data['models'] = "Excel k đúng định dạng. Phải tồn tại các cột: <b>" . implode(', ', $this->validateHeader) . "</b>";
//
//                    return $this->renderJson([
//                        'html' => $this->renderAjax('_errors', $this->data)
//                    ]);
//                }
//
//                $data = collect($excel->import($fileName, 4))->map(function ($item) {
//
//                    return (new $this->modelClass($item));
//                })->all();
//
//                $models = $data;
//
//                $this->data['page'] = request()->post('page', 0);
//                $this->data['dataProvider'] = new ArrayDataProvider([
//                    'allModels' => $models,
//                    'pagination' => [
//                        'pageSize' => 20,
//                        'page' => $this->data['page']
//                    ]
//                ]);
//                $passes = Model::validateMultiple($models);
//
//                $this->data['models'] = $models;
//
//                switch ($type) {
//                    case 'preview':
//                        $pages = explode(',', request()->post('pages', null));
//                        $pages = collect(explode(',', request()->post('pages', null)))->filter(function ($item) {
//                            return $item !== '';
//                        })->all();
//
//                        if (in_array($this->data['page'], $pages)) {
//                            $this->data['message'] = 'Dữ liệu đã được nhập';
//                            $this->data['hideBtnImport'] = true;
//                        }
//                        break;
//                    case 'save':
//                        $models = $this->data['dataProvider']->getModels();
//                        $name = class_basename(new $this->modelClass);
//                        if (Model::loadMultiple($models, request()->all(), $name) && Model::validateMultiple($models)) {
//                            $this->saveModels($models);
//                        }
//
//                        break;
//
//                    case 'save-all':
//                        if ($passes) {
//                            $this->saveModels($models);
//                        }
//                        break;
//                }
//                return $this->renderJson([
//                    'html' => $this->renderAjax('_preview', $this->data)
//                ]);
//
//            } else {
//
//                $this->data['models'] = [$model];
//
//                return $this->renderJson([
//                    'html' => $this->renderAjax('_errors', $this->data)
//                ]);
//            }
//        }
//
//        return $this->render('index', [
//            'dsykiens' => $ds_ykiens,
//            'model' => $model,
//            'sampleFile' => asset($this->sampleFile)
//        ]);
//    }
//
//    protected function saveModels($models)
//    {
//        if ($this->validateModels($models, new VtKhaosat())) {
//
//            $count = count($models);
//            $this->data['message'] = 'Đã lưu thành công ' . Html::a($count . ' đối tượng', '#', ['class' => 'alert-link']);
//            $this->data['page'] = request('page');
//        }
//    }
//
//    protected function validateModels(&$data, $vtkhaosat)
//    {
//        $data = collect($data)->map(function ($item) {
//            return $item->attributes();
//        })->values()->all();
//
//        $ykienId = MetaYkien::find()->pluck('id');
//        $dataIn = collect($data)->map(function ($i) use($ykienId) {
//            $d = collect($i);
//            $id = $d->get('stt');
//            return $d->only($ykienId)->filter(function ($j) {
//                return !is_null($j);
//            })->map(function ($v, $k) use ($id) {
//                return [
//                    'vt_khaosat_id' => $id,
//                    'meta_ykien_id' => $k,
//                    'giatri' => $v,
//                    'status' => 1,
//                    'created_at' => new Expression('NOW()'),
//                    'updated_at' => new Expression('NOW()'),
//                ];
//            })->all();
//        })->collapse()->all();
//
//        $command = Yii::$app->db->createCommand();
//        $command->batchInsert('vt_ks_ykien', [
//            'vt_khaosat_id', 'meta_ykien_id', 'giatri', 'status', 'created_at', 'updated_at'
//        ], $dataIn)->execute();
//
//        foreach ($data as $k => $row) {
//            $dm_phuong = DmPhuong::find()->select('maphuong, maquan, tenphuong_en, tenquan_en')->asArray()->all();
//
//            $tenquan = $row['maquan'];
//            foreach ($dm_phuong as $p) {
//                if(str_slug($tenquan) == str_slug($p['tenquan_en'])) {
//                    $row['maquan'] = $p['maquan'];
//                }
//                if (str_slug($tenquan) == str_slug($p['tenquan_en'])
//                    && str_slug($row['maphuong']) == str_slug($p['tenphuong_en'])) {
//                    $row['maphuong'] = $p['maphuong'];
//                }
//            }
//
//            foreach ($row as $key => $value) {
//                /**
//                 * Convert 'maquan', 'maphuong' from name to key
//                 * Ex: Cần Giờ => 787, Bình Chánh => 78727667
//                 **/
//
//            }
//            $data[$k] = $row;
//        }
//
//        $modelsVtKhaosat = array_fill(0, count($data), $vtkhaosat);
//
//        if (Model::loadMultiple($modelsVtKhaosat, $data, '') && Model::validateMultiple($modelsVtKhaosat)) {
//            foreach ($data as $row) {
//                $vtks = new VtKhaosat();
//                $vtks->setAttributes($row);
//                if ($vtks->lng && $vtks->lat) {
//                    $vtks->geom = [$vtks->lng, $vtks->lat];
//                }
//                $vtks->save();
//
//                $VtKsYkien = [];
//                foreach ($row as $key => $value) {
//                    /**
//                     * Create array to save relations: VtKsYkien
//                     **/
//                    if (is_int($key) && ($value !== null)) {
//                        $VtKsYkien[$key] = ['giatri' => $value];
//                    }
//                }
//                $vtks->sync('dmYkien', $VtKsYkien);
//            }
//            return true;
//        }
//
//        $this->data['errors'] = $modelsVtKhaosat;
//
//        return false;
//    }

}