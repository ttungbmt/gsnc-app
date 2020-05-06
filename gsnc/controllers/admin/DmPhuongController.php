<?php

namespace gsnc\controllers\admin;

use gsnc\models\DmPhuong;
use gsnc\search\DmPhuongSearch;
use gsnc\controllers\GsncController;

class DmPhuongController extends GsncController
{
    protected $modelClass = 'gsnc\models\DmPhuong';

    public function actionIndex()
    {    
        $searchModel = new DmPhuongSearch();
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

    public function actionCreate()
    {
        $model = new DmPhuong();
        return $this->renderRest(['create', 'model' => $model], [
            'title' => lang('Thêm mới ').'Phường',
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        return $this->renderRest(['update', 'model' => $model], [
            'title' => lang('Cập nhật ').'Phường #'.$model->id,
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
