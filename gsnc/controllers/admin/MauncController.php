<?php
namespace gsnc\controllers\admin;

use Yii;
use gsnc\models\Maunc;
use gsnc\search\MauncSearch;
use gsnc\controllers\GsncController;
use yii\helpers\ArrayHelper;

class MauncController extends GsncController
{
    protected $modelClass = 'gsnc\models\Maunc';

    public function actionIndex()
    {
        $searchModel = new MauncSearch();
        $dataProvider = $searchModel->search(request()->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->renderRest(['view', 'model' => $model], [
            'title' => trans('app', 'Details ') . 'Mẫu nước #' . $id,
        ]);
    }

    public function actionCreate()
    {
        $model = new Maunc();
        return $this->renderRest(['create', 'model' => $model], [
            'title' => trans('app', 'Create ') . 'Mẫu nước',
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        return $this->renderRest(['update', 'model' => $model], [
            'title' => trans('app', 'Update ') . 'Mẫu nước #' . $model->id, 'goBack' => true
        ]);

    }

    public function restSave(&$model)
    {
        $diachi = Yii::$app->request->post('Maunc')['diachi'];
        $ngaylaymau = Yii::$app->request->post('Maunc')['ngaylaymau'];

        if ($model->lng && $model->lat) {
            $model->geom = [$model->lng, $model->lat];
        }
        $model->save();

        $chitieus = collect(request('chitieu', []))
            ->filter(function ($item) {
                return $item['giatri'] !== '';
            })
            ->map(function ($item, $k) use ($model) {
                return array_merge($item, ['entity_type' => Maunc::className(), 'entity_id' => $model->gid]);
            })
            ->all();

        $model->sync('dmChitieu', $chitieus);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->deleteRecursive(['chitieus']);
        return $this->renderRest(['index']);
    }

    public function actionQcvn($id)
    {
        $models = (new Maunc())->getMetaChitieu($id);
        return $this->asJson(ArrayHelper::toArray($models));
//        return $this->renderPartial('_qcvn', compact('models'));
    }
}
