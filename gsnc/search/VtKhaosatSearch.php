<?php
namespace gsnc\search;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use gsnc\models\VtKhaosat;

/**
 * VtKhaosatSearch represents the model behind the search form of `gsnc\models\VtKhaosat`.
 */
class VtKhaosatSearch extends VtKhaosat
{
    public $tenquan;
    public $tenphuong;
    public $date_from;
    public $date_to;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gid'], 'integer'],
            [['diachi', 'tenchuho', 'ngaykhaosat', 'maquan', 'maphuong', 'created_at', 'updated_at', 'lat', 'lng', 'geom', 'ghichu'], 'safe'],
            [['date_from', 'date_to'], 'date', 'format' => 'DD/MM/YYYY'],
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
        $query = $this->find()
            ->alias('u')
            ->select(['u.*'])
            ->joinPhuong()
            ->where(['u.status' => 1]);

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

        if(role('quan')){
            $this->maquan = userInfo()->ma_quan;
        }

        $query->andFilterWhere([
            'u.gid' => $this->gid,
            'u.maquan' => $this->maquan,
            'u.maphuong' => $this->maphuong,
        ]);


        $query
            ->andFilterWhere(['ilike', 'diachi', $this->diachi])
            ->andFilterWhere(['ilike', 'tenchuho', $this->tenchuho])
            ->andFilterDate(['u.ngaykhaosat' => [$this->date_from, $this->date_to]]);

        return $dataProvider;
    }
}
