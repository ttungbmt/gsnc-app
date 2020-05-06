<?php
namespace gsnc\controllers\api;

use common\controllers\ActiveController;
use yii\web\Link;

class VtKhaosatController extends ActiveController
{
    public $modelClass = 'gsnc\resources\VtKhaosatResource';

    public function actionSearch(){
        $searchModel = new $this->modelClass;
        $dataProvider = $searchModel->search(request()->all());

        $pagination = $dataProvider->getPagination();
        $models = $dataProvider->getModels();
        $items = collect($models)->map(function ($item) {
            return $item->toArray([], ['geometry']);
        });


        $pjax_id = 'vt-khaosat-list';
        $data = [
            'pjax_id' => $pjax_id,
            'items' => $items,
            '_key'  => 'vt_khaosat',
            '_meta' => [
                'totalCount'  => $pagination->totalCount,
                'pageCount'   => $pagination->getPageCount(),
                'currentPage' => $pagination->getPage() + 1,
                'perPage'     => $pagination->getPageSize(),
            ],
            '_link' => Link::serialize($pagination->getLinks()),
        ];
        return $this->renderAjax('index', compact('dataProvider', 'items', 'data'));
    }
}