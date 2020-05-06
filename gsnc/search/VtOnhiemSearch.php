<?php

namespace gsnc\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use gsnc\models\VtOnhiem;

/**
 * VtOnhiemSearch represents the model behind the search form about `gsnc\models\VtOnhiem`.
 */
class VtOnhiemSearch extends VtOnhiem
{

    public $tenquan;
    public $loaionhiem;
    public $tenphuong;

    public function rules()
    {
        return [
            [['gid', 'onhiem_id', 'maphuong', 'maquan'], 'integer'],
            [['ten', 'diachi', 'ghichu', 'lat', 'lng', 'geom', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = $this->find()
            ->alias('u')
            ->select(['u.gid','u.ten', 'u.diachi', 'u.maquan', 'u.maphuong', 'u.onhiem_id', 'm.ten loaionhiem'])
            ->joinPhuong()->leftJoin(['m' => 'dm_onhiem'], 'u.onhiem_id = m.id');;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'u.maquan' => $this->maquan,
            'u.maphuong' => $this->maphuong,
            'u.onhiem_id' => $this->onhiem_id

        ]);
        $query->andFilterWhere(['ilike', 'u.diachi', $this->diachi])
            ->andFilterWhere(['ilike', 'u.ten', $this->ten]);


        return $dataProvider;
    }
}
