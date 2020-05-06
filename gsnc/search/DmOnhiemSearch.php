<?php

namespace gsnc\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use gsnc\models\DmOnhiem;

/**
 * DmOnhiemSearch represents the model behind the search form about `gsnc\models\DmOnhiem`.
 */
class DmOnhiemSearch extends DmOnhiem
{

    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['ten','maloai', 'mota', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
                    $query = DmOnhiem::find();
        
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

        $query->andFilterWhere(['like', 'ten', $this->ten])
            ->andFilterWhere(['like', 'maloai', $this->maloai])
            ->andFilterWhere(['like', 'mota', $this->mota]);

        return $dataProvider;
    }
}
