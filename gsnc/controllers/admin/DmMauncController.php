<?php

namespace gsnc\controllers\admin;

use gsnc\controllers\GsncController;
use gsnc\models\DmMaunc;
use gsnc\search\DmMauncSearch;

class DmMauncController extends GsncController
{
    protected $modelClass = 'gsnc\models\DmMaunc';

    public function actionIndex()
    {    
        $searchModel = new DmMauncSearch();
        $dataProvider = $searchModel->search(request()->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->renderRest(['view', 'model' => $this->findModel($id)], [
            'title' => lang('Chi tiết ').'Loại mẫu #'.$id,
        ]);
    }

    public function actionCreate()
    {
        $model = new DmMaunc();
        return $this->renderRest(['create', 'model' => $model], [
            'title' => lang('Thêm mới ').'Loại mẫu',
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        return $this->renderRest(['update', 'model' => $model], [
            'title' => lang( 'Cập nhật ').'Loại mẫu #'.$model->id,
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
