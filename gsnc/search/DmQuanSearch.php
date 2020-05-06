<?php

namespace gsnc\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use gsnc\models\DmQuan;

/**
 * DmQuanSearch represents the model behind the search form about `gsnc\models\DmQuan`.
 */
class DmQuanSearch extends DmQuan
{

    public function rules()
    {
        return [
            [['gid', 'order'], 'integer'],
            [['tenquan', 'maquan', 'caphc', 'geom', 'tenquan_en'], 'safe'],
            [['soho'], 'number'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = DmQuan::find()->orderBy('order');
        
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
            ->andFilterDate(['ilike', 'maquan', $this->maquan]);

        return $dataProvider;
    }
}
