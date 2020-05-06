<?php

namespace gsnc\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use gsnc\models\Mangluoinuoc;

/**
 * MangluoinuocSearch represents the model behind the search form about `gsnc\models\Mangluoinuoc`.
 */
class MangluoinuocSearch extends Mangluoinuoc
{

    public $tenquan;
    public $tenphuong;

    public function rules()
    {
        return [
            [['gid', 'huongdongc', 'vatlieu', 'tieuchuan', 'hieu', 'nuocsanxua', 'tinhtrang', 'capong', 'loaiongnuo', 'id'], 'integer'],
            [['objectid', 'chieudai', 'donhamthuc', 'aplucthiet', 'namlapdat', 'dosau', 'dodoc', 'donhamdanh', 'alhoatdong', 'dktrong', 'dkngoai', 'coong', 'shape_leng', 'shape_le_1'], 'number'],
            [['idmaduongo', 'idcapnuoc', 'vitrilapda', 'geom', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Mangluoinuoc::find();
        
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

        
        
        return $dataProvider;
    }
}
