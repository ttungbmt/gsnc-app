<?php
namespace gsnc\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use gsnc\models\DmChitieu;

/**
 * DmChitieuSearch represents the model behind the search form of `gsnc\models\DmChitieu`.
 */
class DmChitieuSearch extends DmChitieu
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'qcvn_id'], 'integer'],
            [['ma', 'tenchitieu', 'color', 'created_at', 'updated_at', 'unit'], 'safe'],
            [['val_from', 'val_to'], 'number'],
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
        $query = DmChitieu::find()->with('qcvn');
//        dd($params);

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
            'id'         => $this->id,
            'val_from'   => $this->val_from,
            'val_to'     => $this->val_to,
            'qcvn_id'    => $this->qcvn_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['ilike', 'ma', $this->ma])
            ->andFilterWhere(['ilike', 'tenchitieu', $this->tenchitieu])
            ->andFilterWhere(['ilike', 'color', $this->color])
            ->andFilterWhere(['ilike', 'unit', $this->unit]);

        return $dataProvider;
    }
}
