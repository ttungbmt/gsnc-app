<?php
namespace gsnc\resources;

use common\models\ModelApiTrait;
use common\supports\data\ActiveDataProvider;
use gsnc\models\VtKhaosat;
use yii\web\Link;
use yii\web\Linkable;

class VtKhaosatResource extends VtKhaosat implements Linkable
{
    use ModelApiTrait;
    public $date_from;
    public $date_to;

    public static function tableName()
    {
        return 'v_vt_khaosat';
    }

    public static function primaryKey()
    {
        return ['gid'];
    }

    public function rules()
    {
        return [
            [['diachi', 'tenchuho', 'ngaykhaosat'], 'safe'],
            [['date_from', 'date_to', 'geometry'], 'safe'],
            [['maquan', 'maphuong'], 'string'],
        ];
    }

    public function fields()
    {
        $parent = parent::fields();
        unset($parent['geom']);
        return $parent;
    }


    public function extraFields()
    {
        return [
            'geometry' => function ($item) {
                if($item->geom) {
                    return [
                        'type'        => $item->geometryType,
                        'coordinates' => $item->geom,
                    ];
                }
            }
        ];
    }

    public function getLinks()
    {
        return [
            Link::REL_SELF => url(['/admin/vt-khaosat/view', 'id' => $this->getId()], true),
            'edit' => url(['/admin/vt-khaosat/update', 'id' => $this->getId()], true),
            'index' => url(['/admin/vt-khaosat'], true),
        ];
    }


    public function search($params)
    {
        $query = $this->find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'params' => $params,
                'pageSize' => 20,
            ],
        ]);

        $this->load($params, 'form');

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([

            'maquan' => $this->maquan,
            'maphuong' => $this->maphuong,

        ]);
        $query
            ->andFilterSearch(['ilike', 'tenchuho', $this->tenchuho])
            ->andFilterSearch(['ilike', 'diachi', $this->diachi])
            ->andFilterDate(['ngaykhaosat' => [$this->date_from, $this->date_to]])
        ;

        $query->whereIntersect($this->geometry);

        return $dataProvider;
    }

    public function getName(){
        return $this->tenchuho;
    }

    public function getAddress(){
        return "{$this->diachi} - {$this->tenphuong} - {$this->tenquan}";
    }
}







