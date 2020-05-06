<?php

namespace gsnc\controllers\admin;

use gsnc\controllers\GsncController;
use gsnc\models\VtKsYkien;
use Yii;
use gsnc\models\VtKhaosat;
use gsnc\search\VtKhaosatSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * VtKhaosatController implements the CRUD actions for VtKhaosat model.
 */
class VtKhaosatController extends GsncController
{
    /**
     * @inheritdoc
     */
    public function actionIndex()
    {
        $searchModel = new VtKhaosatSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }

    public function actionView($id)
    {
        return $this->renderRest(['view', 'model' => $this->findModel($id)], [
            'title' => trans('app', 'Chi tiết ') . 'Vị trí khảo sát #' . $id,
        ]);
    }


    public function actionCreate()
    {
        $model = new VtKhaosat();
        return $this->renderRest(['create', 'model' => $model], [
            'title' => trans('app', 'Create ') . 'Vị trí khảo sát',
        ]);

    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        return $this->renderRest(['update', 'model' => $model], [
            'title' => trans('app', 'Update ') . 'Vị trí khảo sát #' . $model->id,'goBack' => true
        ]);
    }

    public function restSave(&$model)
    {
        $VtKsYkien = collect(request('VtKsYkien', []))->filter(function ($item){return $item['giatri'] !== '';})->all();
        if($model->lng && $model->lat){
            $model->geom = [$model->lng, $model->lat];
        }
        $model->save();
        $model->sync('dmYkien', $VtKsYkien);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->deleteRecursive(['ykiens']);
        return $this->renderRest(['index']);
    }

    protected function findModel($id)
    {
        if (($model = VtKhaosat::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
