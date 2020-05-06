<?php

namespace gsnc\resources;

use common\models\ModelApiTrait;
use common\supports\data\ActiveDataProvider;
use gsnc\models\Maunc;
use yii\web\Link;
use yii\web\Linkable;

class MauncResource extends Maunc implements Linkable
{
    use ModelApiTrait;

    public $geometry;
    public $date_from;
    public $date_to;

    public static function tableName()
    {
        return 'v_maunc';
    }

    public static function primaryKey()
    {
        return ['gid'];
    }

    public function rules()
    {
        return [
            [['qcvn_id', 'loaimau_id', 'hl_vs'], 'integer'],
            [['date_from', 'date_to', 'geometry'], 'safe'],
            [['maquan', 'maphuong'], 'string'],
        ];
    }

    public function getLinks()
    {
        return [
            Link::REL_SELF => url(['/admin/maunc/view', 'id' => $this->getId()], true),
            'edit'         => url(['/admin/maunc/update', 'id' => $this->getId()], true),
            'index'        => url(['/admin/maunc'], true),
        ];
    }

    public function search($params)
    {
        $query = $this->find();

        $dataProvider = new ActiveDataProvider([
            'query'      => $query,
            'pagination' => [
                'params'   => $params,
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
            'loaimau_id' => $this->loaimau_id,
            'qcvn_id' => $this->qcvn_id,
            'hl_vs' => $this->hl_vs,
        ]);

        $query
//            ->andFilterSearch(['ilike', 'diachi', $model->diachi])
            ->andFilterDate(['ngaylaymau' => [$this->date_from, $this->date_to]])
        ;

        $query->whereIntersect($this->geometry);
//        dd($query->createCommand()->getRawSql());
        return $dataProvider;
    }
}