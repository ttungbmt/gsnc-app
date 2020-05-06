<?php

namespace gsnc\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use gsnc\models\PoiBenhvien;

/**
 * PoiBenhvienBenhvienSearch represents the model behind the search form of `gsnc\models\PoiBenhvien`.
 */
class PoiBenhvienBenhvienSearch extends PoiBenhvien
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gid', 'onhiem_id', 'loaibv_id', 'status', 'vs', 'hl', 'hl_vs', 'qcvn_id', 'loaimau_id', 'hl_xn', 'hl_mt'], 'integer'],
            [['ten', 'diachi', 'sonha', 'tenduong', 'maquan', 'maphuong', 'lat', 'lng', 'loaibv', 'dienthoai', 'website', 'lichlamviec', 'thamkhao', 'gioithieu', 'check', 'geom', 'created_at', 'updated_at', 'ngaylaymau', 'mamau'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = PoiBenhvien::find();

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
            'gid' => $this->gid,
            'onhiem_id' => $this->onhiem_id,
            'loaibv_id' => $this->loaibv_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
            'vs' => $this->vs,
            'hl' => $this->hl,
            'hl_vs' => $this->hl_vs,
            'qcvn_id' => $this->qcvn_id,
            'ngaylaymau' => $this->ngaylaymau,
            'loaimau_id' => $this->loaimau_id,
            'hl_xn' => $this->hl_xn,
            'hl_mt' => $this->hl_mt,
        ]);

        $query->andFilterWhere(['ilike', 'ten', $this->ten])
            ->andFilterWhere(['ilike', 'diachi', $this->diachi])
            ->andFilterWhere(['ilike', 'sonha', $this->sonha])
            ->andFilterWhere(['ilike', 'tenduong', $this->tenduong])
            ->andFilterWhere(['ilike', 'maquan', $this->maquan])
            ->andFilterWhere(['ilike', 'maphuong', $this->maphuong])
            ->andFilterWhere(['ilike', 'lat', $this->lat])
            ->andFilterWhere(['ilike', 'lng', $this->lng])
            ->andFilterWhere(['ilike', 'loaibv', $this->loaibv])
            ->andFilterWhere(['ilike', 'dienthoai', $this->dienthoai])
            ->andFilterWhere(['ilike', 'website', $this->website])
            ->andFilterWhere(['ilike', 'lichlamviec', $this->lichlamviec])
            ->andFilterWhere(['ilike', 'thamkhao', $this->thamkhao])
            ->andFilterWhere(['ilike', 'gioithieu', $this->gioithieu])
            ->andFilterWhere(['ilike', 'check', $this->check])
            ->andFilterWhere(['ilike', 'geom', $this->geom])
            ->andFilterWhere(['ilike', 'mamau', $this->mamau]);

        return $dataProvider;
    }
}
