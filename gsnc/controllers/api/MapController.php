<?php
namespace gsnc\controllers\api;


use common\controllers\MyApiController;
use common\models\Query;
use common\models\User;
use gsnc\models\Maunc;
use yii\db\Expression;

class MapController extends MyApiController
{
    public function actionConfig()
    {
        $data = [];

        $userId = user()->id;
        $user = User::findOne($userId);
        if ($user) {
            $data['user'] = array_merge($user->info->toArray(), ['username' => $user->username]);
            $data['roles'] = array_keys(auth()->getRolesByUser($userId));
            $data['permissions'] = array_keys(auth()->getPermissionsByUser($userId));
        }

        $data['layer_tree'] = api('layer_tree');

        $data['nav_links'] = api('nav_links');
        $data['app'] = [
            'title' => params('app_name'),
            'logo_url' => params('assets.logo')
        ];


        $data['categories'] = [
        ];

        return $data;
    }

    public function actionHeatmap(){
        $q = collect((new Query())->select([
            'ct.entity_id', 
            'ct.giatri', 
            'geometry' => new Expression('ST_AsGeoJSON(mn.geom)')
        ])->from(['ct' => 'ql_chitieu'])
            ->leftJoin(['mn' => 'maunc'], 'mn.gid = ct.entity_id')
            ->andFilterWhere([
                'ct.entity_type' => Maunc::className(),
                'ct.chitieu_id' => request('chitieu_id'),
            ])
            ->andFilterDate(['mn.ngaylaymau' => [request('date_from'), request('date_to')]])
            ->andWhere('mn.geom IS NOT NULL')->all())
            ->map(function ($i) {
                $geometry = json_decode($i['geometry'], true);
                return [
                    data_get($geometry, 'coordinates.1'), data_get($geometry, 'coordinates.0'), $i['giatri']
                ];
            })
        ;

        return [
            'items' => $q
        ];
    }

}