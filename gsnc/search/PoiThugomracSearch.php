<?php

namespace gsnc\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use gsnc\models\PoiThugomrac;

/**
 * PoiThugomracSearch represents the model behind the search form about `gsnc\models\PoiThugomrac`.
 */
class PoiThugomracSearch extends PoiThugomrac
{

    public $tenquan;
    public $tenphuong;
    public $onhiem_id;
    public $onhiem;

    public function rules()
    {
        return [
            [['gid', 'onhiem_id'], 'integer'],
            [['ten', 'diachi', 'lat', 'lng', 'maquan', 'maphuong', 'geom', 'sonha', 'tenduong', 'check'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = $this->find()->alias('u')->select([
            'u.gid',
            'u.ten',
            'u.diachi',
            'u.sonha',
            'u.tenduong',
            'o.ten onhiem',
            'u.maphuong',
            'u.maquan',
        ])->joinPhuong()->leftJoin(['o' => 'dm_onhiem'], 'u.onhiem_id = o.id');
//            ->where(['u.status' => 1]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 10,
            ],
            'sort'=> ['defaultOrder' => ['gid' => SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'u.gid' => $this->gid,
            'u.maquan' => $this->maquan,
            'u.maphuong' => $this->maphuong,
            'u.onhiem_id' => $this->onhiem_id,
        ]);

        $query->andFilterWhere(['ilike', 'u.diachi', $this->diachi])
            ->andFilterWhere(['ilike', 'u.ten', $this->ten]);

        return $dataProvider;
    }
}
