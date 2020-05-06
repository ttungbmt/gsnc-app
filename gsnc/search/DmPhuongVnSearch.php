<?php

namespace gsnc\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use gsnc\models\DmPhuongVn;

/**
 * DmPhuongVnSearch represents the model behind the search form about `gsnc\models\DmPhuongVn`.
 */
class DmPhuongVnSearch extends DmPhuongVn
{

    public function rules()
    {
        return [
            [['gid', 'soho'], 'integer'],
            [['ma', 'ten', 'ten_en', 'cap', 'ma_quan', 'ten_quan', 'ma_tinh', 'ten_tinh', 'phuong_en', 'quan_en', 'tinh_en', 'ma_phuong', 'geom', 'v_geom'], 'safe'],
            [['danso_2016', 'danso_tt', 'mucchitieu', 'dientich_tt'], 'number'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
                $query = DmPhuongVn::find();
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query
            ->andFilterSearch(['ilike', 'ten_tinh', $this->ten_tinh])
            ->andFilterSearch(['ilike', 'ten_quan', $this->ten_quan])
            ->andFilterDate(['ilike', 'ma_quan', $this->ma_quan])
            ->andFilterSearch(['ilike', 'ten', $this->ten])
            ->andFilterDate(['ilike', 'ma_phuong', $this->ma_phuong]);
        
        return $dataProvider;
    }
}
