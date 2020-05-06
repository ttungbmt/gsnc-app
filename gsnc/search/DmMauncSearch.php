<?php

namespace gsnc\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use gsnc\models\DmMaunc;

/**
 * DmMauncSearch represents the model behind the search form about `gsnc\models\DmMaunc`.
 */
class DmMauncSearch extends DmMaunc
{

    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['mamau', 'ghichu', 'ten', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
                    $query = DmMaunc::find();
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        
        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'mamau', $this->mamau])
            ->andFilterWhere(['like', 'ghichu', $this->ghichu])
            ->andFilterWhere(['like', 'ten', $this->ten]);

        return $dataProvider;
    }
}
