<?php

namespace gsnc\controllers\admin;

use gsnc\controllers\GsncController;
use gsnc\forms\BenhvienForm;
use gsnc\models\Benhvien;
use gsnc\search\BenhvienSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * BenhvienController implements the CRUD actions for Benhvien model.
 */
class BenhvienController extends GsncController
{
    protected $modelClass = 'gsnc\models\Benhvien';

    public function behaviors() {
        return [
            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Benhvien models.
     *
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new BenhvienSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id) {
        return $this->renderRest(['view', 'model' => $this->findModel($id)], [
            'title' => trans('app', 'Chi tiết ') . 'Mẫu nước thải Bệnh viện #' . $id,
        ]);
    }

    protected function findModel($id) {
        if (($model = BenhvienForm::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionCreate() {
        $model = new BenhvienForm();
        return $this->renderRest(['create', 'model' => $model], [
            'title' => trans('app', 'Thêm ') . 'Mẫu nước thải Bệnh viện',
        ]);
    }

    public function actionUpdate($id) {
        $model = $this->findModel($id);
        return $this->renderRest(['update', 'model' => $model], [
            'title' => trans('app', 'Cập nhật ') . 'Mẫu nước thải Bệnh viện #' . $model->id, 'goBack' => true
        ]);
    }

    public function restSave(&$model) {
        $chitieus = collect(request('chitieu', []))->filter(function ($item) {
            return $item['giatri'] !== '';
        })->all();
//        if ($model->lng && $model->lat) {
//            $model->geom = [$model->lng, $model->lat];
//        }
        $model->save();
        $model->sync('dmChitieu', $chitieus);
    }

    public function actionDelete($id) {
        $model = $this->findModel($id);
        $model->deleteRecursive(['chitieus']);
        return $this->renderRest(['index']);
    }

    public function actionQcvn($id) {
        $models = (new Benhvien())->getMetaChitieu($id);
        return $this->renderPartial('_qcvn', compact('models'));
    }
}
