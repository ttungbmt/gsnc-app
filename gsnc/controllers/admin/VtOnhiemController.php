<?php

namespace gsnc\controllers\admin;

use gsnc\controllers\GsncController;
use gsnc\models\VtOnhiem;
use gsnc\search\VtOnhiemSearch;
use common\controllers\MyController;
use yii\helpers\Html;
use Yii;

class VtOnhiemController extends GsncController
{
    protected $modelClass = 'gsnc\models\VtOnhiem';

    public function actionIndex()
    {    
        $searchModel = new VtOnhiemSearch();
        $dataProvider = $searchModel->search(request()->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->renderRest(['view', 'model' => $this->findModel($id)], [
            'title' => lang('Chi tiết ').'Vị trí ô nhiễm #'.$id,
        ]);
    }

    public function actionCreate()
    {
        $model = new VtOnhiem();
        return $this->renderRest(['create', 'model' => $model], [
            'title' => lang('Thêm ').'Vị trí ô nhiễm',
        ]);
    }

    public function actionUpdate($id)
    {

        $model = $this->findModel($id);
        return $this->renderRest(['update', 'model' => $model], [
            'title' => lang('Cập nhật ').'Vị trí ô nhiễm #'.$model->gid,'goBack' => true
        ]);
//         return $this->goBack();
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
