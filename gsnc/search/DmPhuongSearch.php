<?php

namespace gsnc\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use gsnc\models\DmPhuong;

/**
 * DmPhuongSearch represents the model behind the search form about `gsnc\models\DmPhuong`.
 */
class DmPhuongSearch extends DmPhuong
{

    public function rules()
    {
        return [
            [['gid', 'order'], 'integer'],
            [['caphc', 'maphuong', 'maquan', 'tenphuong', 'tenquan', 'geom', 'tenphuong_en', 'tenquan_en', 'tenphuong_format', 'tenquan_format'], 'safe'],
            [['soho'], 'number'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = DmPhuong::find()->orderBy('order');
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query
            ->andFilterSearch(['ilike', 'tenquan', $this->tenquan])
            ->andFilterDate(['ilike', 'maquan', $this->maquan])
            ->andFilterSearch(['ilike', 'tenphuong', $this->tenphuong])
            ->andFilterDate(['ilike', 'maphuong', $this->maphuong]);
        
        return $dataProvider;
    }
}
