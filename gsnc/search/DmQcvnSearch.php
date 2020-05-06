<?php

namespace gsnc\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use gsnc\models\DmQcvn;

/**
 * DmQcvnSearch represents the model behind the search form about `gsnc\models\DmQcvn`.
 */
class DmQcvnSearch extends DmQcvn
{

    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['tenqc', 'ghichu', 'created_at', 'updated_at', 'type', 'mota'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = DmQcvn::find()->with(['chitieus']);

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
        ]);

        $query->andFilterWhere(['like', 'tenqc', $this->tenqc])
            ->andFilterWhere(['like', 'ghichu', $this->ghichu])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'mota', $this->mota]);

        return $dataProvider;
    }
}
