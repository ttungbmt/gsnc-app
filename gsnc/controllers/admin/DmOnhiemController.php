<?php

namespace gsnc\controllers\admin;

use gsnc\models\DmOnhiem;
use gsnc\search\DmOnhiemSearch;
use gsnc\controllers\GsncController;
use yii\helpers\Html;

class DmOnhiemController extends GsncController
{
    protected $modelClass = 'gsnc\models\DmOnhiem';

    public function actionIndex()
    {    
        $searchModel = new DmOnhiemSearch();
        $dataProvider = $searchModel->search(request()->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->renderRest(['view', 'model' => $this->findModel($id)], [
            'title' => trans('app', 'Chi tiết ').'Loại ô nhiễm #'.$id,
        ]);
    }

    public function actionCreate()
    {
        $model = new DmOnhiem();
        return $this->renderRest(['create', 'model' => $model], [
            'title' => trans('app', 'Thêm mới ').'Loại ô nhiễm',
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        return $this->renderRest(['update', 'model' => $model], [
            'title' => trans('app', 'Cập nhật ').'Loại ô nhiễm #'.$model->id,
        ]);
    }

    public function restSave(&$model)
    {
        $model->save();
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->renderRest();
    }
}
