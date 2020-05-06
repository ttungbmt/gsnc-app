<?php

namespace gsnc\controllers\admin;

use common\controllers\ImportTrait;
use common\forms\UploadForm;
use common\libs\excel\Excel;
use gsnc\controllers\GsncController;
use gsnc\models\Dmchitieu;
use gsnc\models\DmMaunc;
use gsnc\models\DmPhuong;
use gsnc\models\DmQuan;
use gsnc\models\Maunc;
use yii\base\Model;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use gsnc\models\DmQcvn;

class MaunuocImportController extends GsncController
{
    use ImportTrait;
    public $enableCsrfValidation = false;
    protected $modelImportClass = 'gsnc\forms\MaunuocImportForm';
    protected $modelClass = 'gsnc\models\Maunc';

    protected function options()
    {
        return [
            'header' => ['stt', 'donvilaymau', 'maquan', 'maphuong', 'mamau', 'diachi', 'loaimau_id', 'ngaylaymau', 'vs', 'hl_xn', 'hl_mt', 'hl_vs', 'lat', 'lng'],
            'sample' => '/gsnc/storage/samples/vt-khaosat-import.xlsx',
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
        $this->data['qcvn_id'] = request('qcvn', 1);
        $this->data['dm_chitieu'] = DmChitieu::find()->orderBy('id ASC')->where(['qcvn_id' => $this->data_get('qcvn_id')])->pluck('ma', 'id')->all();
        $this->data['dm_maunc'] = DmMaunc::pluck('mamau', 'id')->all();
    }

    protected function extraHeader()
    {
        return array_values($this->data_get('dm_chitieu'));
    }
   

    protected function rules(&$model)
    {
        $model->dm_quan = $this->data_get('dm_quan');
        $model->dm_phuong = $this->data_get('dm_phuong');
        $model->qcvn_id = $this->data_get('qcvn_id');
        $model->dm_chitieu = $this->data_get('dm_chitieu');
        $model->dm_maunc = $this->data_get('dm_maunc');
    }

    protected function validateModels($excelModels)
    {
        $data = [];
        $models = [];

        foreach ($excelModels as $k => $i) {
            $data[$k] = $i->toArray();
            $models[$k] = new Maunc();

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
        foreach ($models as $m) {
            $m->save();
            foreach ($m->data_cts as $v) {
                $chitieus[] = [
                    $v['chitieu_id'],
                    $v['giatri'],
                    $v['entity_type'],
                    $m->gid,
                ];
            }
        }

        $connection->createCommand()->batchInsert('ql_chitieu', ['chitieu_id', 'giatri', 'entity_type', 'entity_id'], $chitieus)->execute();
    }

    public function actionDschitieu($id)
    {
        $dschitieu = DmChitieu::find()->orderBy('id ASC')->where(['qcvn_id' => $id])->pluck('tenchitieu', 'ma')->all();
        $tenQcvn = DmQcvn::find()->select('tenqc')->where(['id' => $id])->column();

        return $this->renderPartial('_tablechitieu', [
            'dschitieu' => $dschitieu,
            'qcvn'      => $tenQcvn[0],
        ]);
    }
}