<?php

namespace gsnc\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use gsnc\models\Benhvien;

/**
 * BenhvienSearch represents the model behind the search form of `gsnc\models\Benhvien`.
 */
class BenhvienSearch extends Benhvien
{
    public $tenquan;
    public $tenphuong;
    public $loaimau;
    public $from_ngaylaymau;
    public $to_ngaylaymau;

    public function rules()
    {
        return [
            [['from_ngaylaymau', 'to_ngaylaymau'], 'date', 'format' => 'DD/MM/YYYY'],
            [['ten'], 'safe'],
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
        $query = $this->find()->alias('u')->select([
            'u.id',
            'u.ten',
            'm.mamau',
            'u.diachi', 'u.ngaylaymau', 'u.qcvn_id','u.hl_vs',
            'm.mamau loaimau',
            ])->joinPhuong()
            ->leftJoin(['m' => 'dm_maunc'], 'u.loaimau_id = m.id')
//            ->where(['u.status' => 1])
        ;
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 10,
            ],
            'sort'=> ['defaultOrder' => ['id' => SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
             $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'u.ten' => $this->ten,
            'u.id' => $this->id,
            'u.maquan' => $this->maquan,
            'u.maphuong' => $this->maphuong,
            'u.hl_vs' => $this->hl_vs,
            'u.qcvn_id' => $this->qcvn_id,
            'u.loaimau_id' => $this->loaimau_id,
        ]);

        $query->andFilterWhere(['ilike', 'u.diachi', $this->diachi])
            ->andFilterWhere(['ilike', 'u.ten', $this->ten])

            ->andFilterWhere(['between', 'u.ngaylaymau', $this->from_ngaylaymau, $this->to_ngaylaymau]);
//        dd($query->createCommand()->getRawSql());
        return $dataProvider;
    }
}
