<?php

namespace gsnc\controllers\admin;

use gsnc\controllers\GsncController;
use gsnc\models\DmPhuongVn;
use gsnc\search\DmPhuongVnSearch;

class DmPhuongVnController extends GsncController
{
    protected $modelClass = 'gsnc\models\DmPhuongVn';

    public function actionIndex()
    {    
        $searchModel = new DmPhuongVnSearch();
        $dataProvider = $searchModel->search(request()->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->renderRest(['view', 'model' => $this->findModel($id)], [
            'title' => lang('Chi tiết ').'Phường #'.$id,
        ]);
    }

//    public function actionCreate()
//    {
//        $model = new DmPhuongVn();
//        return $this->renderRest(['create', 'model' => $model], [
//            'title' => lang('Create ').'dm_phuong_vn',
//        ]);
//    }
//
//    public function actionUpdate($id)
//    {
//        $model = $this->findModel($id);
//        return $this->renderRest(['update', 'model' => $model], [
//            'title' => lang('Update ').'dm_phuong_vn #'.$model->id,
//        ]);
//    }

//    public function restSave(&$model)
//    {
//        $model->save();
//    }
//
//    public function actionDelete($id)
//    {
//        $this->findModel($id)->delete();
//        return $this->renderRest();
//    }
}
