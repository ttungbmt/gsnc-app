<?php

namespace gsnc\controllers\admin;

use gsnc\models\DmQcvn;
use gsnc\search\DmQcvnSearch;
use gsnc\controllers\GsncController;
use yii\helpers\Html;

class DmQcvnController extends GsncController
{
    protected $modelClass = 'gsnc\models\DmQcvn';

    public function actionIndex()
    {    
        $searchModel = new DmQcvnSearch();
        $dataProvider = $searchModel->search(request()->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->renderRest(['view', 'model' => $this->findModel($id)], [
            'title' => lang('Details').' QCVN #'.$id,
        ]);
    }

    public function actionCreate()
    {
        $model = new DmQcvn();
        return $this->renderRest(['create', 'model' => $model], [
            'title' => lang('Create').' QCVN',
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        return $this->renderRest(['update', 'model' => $model], [
            'title' => lang('Update').' QCVN #'.$model->id,
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
