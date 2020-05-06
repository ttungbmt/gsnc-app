<?php

namespace gsnc\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use gsnc\models\Dmloaibv;

/**
 * DmloaibvSearch represents the model behind the search form of `gsnc\models\Dmloaibv`.
 */
class DmLoaibvSearch extends Dmloaibv
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['ten','maloai', 'mota', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Dmloaibv::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['ilike', 'ten', $this->ten])
            ->andFilterWhere(['ilike', 'maloai', $this->maloai])
            ->andFilterWhere(['ilike', 'mota', $this->mota]);

        return $dataProvider;
    }
}
