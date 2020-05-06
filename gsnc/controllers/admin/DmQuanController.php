<?php

namespace gsnc\controllers\admin;

use gsnc\controllers\GsncController;
use gsnc\models\DmQuan;
use gsnc\search\DmQuanSearch;

class DmQuanController extends GsncController
{
    protected $modelClass = 'gsnc\models\DmQuan';

    public function actionIndex()
    {    
        $searchModel = new DmQuanSearch();
        $dataProvider = $searchModel->search(request()->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->renderRest(['view', 'model' => $this->findModel($id)], [
            'title' => lang('Details ').'Danh mục Quận #'.$id,
        ]);
    }

    public function actionCreate()
    {
        $model = new DmQuan();
        return $this->renderRest(['create', 'model' => $model], [
            'title' => lang('Create ').'Danh mục Quận',
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        return $this->renderRest(['update', 'model' => $model], [
            'title' => lang('Update ').'Danh mục Quận #'.$model->id,
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
