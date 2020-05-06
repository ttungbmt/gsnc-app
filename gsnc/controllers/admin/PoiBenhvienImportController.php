<?php

namespace gsnc\controllers\admin;

use common\controllers\ImportTrait;
use common\forms\UploadForm;
use common\libs\excel\Excel;
use common\models\DynamicImportForm;
use gsnc\controllers\GsncController;
use gsnc\models\Dmchitieu;
use gsnc\models\DmLoaibv;
use gsnc\models\DmMaunc;
use gsnc\models\DmOnhiem;
use gsnc\models\DmPhuong;
use gsnc\models\Benhvien;
use gsnc\models\PoiBenhvien;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;
use yii\base\Model;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use gsnc\models\DmQcvn;

class PoiBenhvienImportController extends GsncController
{
    use ImportTrait;

    public $enableCsrfValidation = false;
    protected $modelImportClass = 'gsnc\forms\BenhvienImportForm';
    protected $modelClass = 'gsnc\models\Benhvien';

    protected function options()
    {

        return [
            'header' => ['stt', 'donvilaymau', 'ten', 'maquan', 'maphuong', 'diachi', 'loaimau_id', 'ngaylaymau', 'onhiem_id', 'dienthoai', 'website', 'gioithieu', 'loaibv_id', 'mamau', 'vs', 'hl_xn', 'hl_mt', 'hl_vs', 'lat', 'lng'],
            'sample' => '/gsnc/storage/samples/benhvien-import.xlsx'
        ];
    }

    protected function extraHeader()
    {
        return DmChitieu::find()->orderBy('id ASC')->where(['qcvn_id' => request('qcvn_id')])->pluck('ma', 'id')->all();
    }

    protected function prepareData()
    {
        $this->data['dm_quan'] = api('dm/quan-en');
        $this->data['dm_phuong'] = api('dm/phuong-en');
        $this->data['dm_loaibv'] = DmLoaibv::pluck('maloai', 'id');
        $this->data['dm_bv'] = PoiBenhvien::pluck('ten', 'gid');
        $this->data['dm_maunc'] = api('dm/maunc');
        $this->data['dm_chitieu'] = DmChitieu::find()->orderBy('id ASC')->where(['qcvn_id' => request('qcvn_id')])->pluck('ma', 'id')->all();
    }

    protected function rules(&$model)
    {
        $model->dm_quan = $this->data_get('dm_quan');
        $model->dm_phuong = $this->data_get('dm_phuong');
        $model->dm_chitieu = $this->data['dm_chitieu'];
        $model->dm_maunc = array_values($this->data_get('dm_maunc'));
        $model->dm_loaibv = $this->data_get('dm_loaibv');
        $model->dm_bv = $this->data_get('dm_bv');
        $model->qcvn_id = request('qcvn_id');
    }

    protected function validateModels($exModels)
    {
        $data = [];
        $models = [];

        foreach ($exModels as $k => $i) {
            $data[$k] = $i->toArray();
            unset($data[$k]['donvilaymau']);

            $models[$k] = new Benhvien();
            $models[$k]->data_cts = data_get($data[$k], 'chitieus', []);
            $models[$k]->bv_id = data_get($data[$k], 'loaibv_id');
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
                    $v['chitieu_id'],
                    $v['giatri'],
                    $this->modelClass,
                    $m->id
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
