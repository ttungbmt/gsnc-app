<?php

namespace gsnc\controllers\admin;

use gsnc\controllers\GsncController;
use gsnc\models\PoiThugomrac;
use gsnc\search\PoiThugomracSearch;

class PoiThugomracController extends GsncController
{
    protected $modelClass = 'gsnc\models\PoiThugomrac';

    public function actionIndex()
    {    
        $searchModel = new PoiThugomracSearch();
        $dataProvider = $searchModel->search(request()->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->renderRest(['view', 'model' => $this->findModel($id)], [
            'title' => lang('Details ').'Đơn vị thu gom rác #'.$id,
        ]);
    }

    public function actionCreate()
    {
        $model = new PoiThugomrac();
        return $this->renderRest(['create', 'model' => $model], [
            'title' => lang('Create ').'Đơn vị thu gom rác',
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        return $this->renderRest(['update', 'model' => $model], [
            'title' => lang('Update ').'Đơn vị thu gom rác #'.$model->id,
            'goBack' => true
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
