<?php

namespace gsnc\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use gsnc\models\Maunc;

/**
 * MauncSearch represents the model behind the search form about `gsnc\models\Maunc`.
 */
class MauncSearch extends Maunc
{
    public $tenquan;
    public $tenphuong;
    public $loaimau;
    public $date_from;
    public $date_to;

    public function rules()
    {
        return [
            [['gid', 'vs', 'hl_xn', 'hl_vs', 'loaimau_id', 'qcvn_id', 'check', 'id_excel'], 'integer'],
            [['mamau', 'ngaylaymau', 'diachi', 'maquan', 'maphuong', 'created_at', 'updated_at', 'lat', 'lng', 'geom', 'tenmau', 'nguoilaymau'], 'safe'],
            [['date_from', 'date_to'], 'date', 'format' => 'DD/MM/YYYY'],
        ];
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'loaimau' => 'Loại mẫu'
        ]);
    }


    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = $this->find()->alias('u')->select([
            'u.gid',
            'u.mamau',
            'u.diachi', 'u.ngaylaymau', 'u.qcvn_id', 'hl_vs',
            'm.mamau loaimau',
        ])->joinPhuong()->leftJoin(['m' => 'dm_maunc'], 'u.loaimau_id = m.id')
            ->where(['u.status' => 1]);

        $dataProvider = new ActiveDataProvider([
            'query'      => $query,
            'pagination' => [
                'defaultPageSize' => 10,
            ],
            'sort'       => ['defaultOrder' => ['gid' => SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        if(role('quan')){
            $this->maquan = userInfo()->ma_quan;
        }

        $query->andFilterWhere([
            'u.gid'        => $this->gid,
            'u.mamau'      => $this->mamau,
            'u.maquan'     => $this->maquan,
            'u.maphuong'   => $this->maphuong,
            'u.loaimau_id' => $this->loaimau_id,
            'u.qcvn_id'    => $this->qcvn_id,
            'u.hl_vs'      => $this->hl_vs,
        ]);

        $query
            ->andFilterSearch(['ilike', 'diachi', $this->diachi])
            ->andFilterDate(['u.ngaylaymau' => [$this->date_from, $this->date_to]]);

        return $dataProvider;
    }
}
