<?php

namespace gsnc\controllers\admin;

use gsnc\models\Mangluoinuoc;
use gsnc\search\MangluoinuocSearch;
use gsnc\controllers\GsncController;
use yii\helpers\Html;

class MangluoinuocController extends GsncController
{
    protected $modelClass = 'gsnc\models\Mangluoinuoc';

    public function actionIndex()
    {    
        $searchModel = new MangluoinuocSearch();
        $dataProvider = $searchModel->search(request()->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->renderRest(['view', 'model' => $this->findModel($id)], [
            'title' => lang('Details ').'Mạng lưới nước #'.$id,
        ]);
    }

    public function actionCreate()
    {
        $model = new Mangluoinuoc();
        return $this->renderRest(['create', 'model' => $model], [
            'title' => lang('Create ').'Mạng lưới nước',
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        return $this->renderRest(['update', 'model' => $model], [
            'title' => lang('Update ').'Mạng lưới nước #'.$model->id,
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
