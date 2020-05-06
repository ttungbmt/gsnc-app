<?php

namespace gsnc\models;

use common\models\MyModel;
use Yii;
use yii\base\DynamicModel;
use yii\helpers\Html;

/**
 * This is the model class for table "benhvien".
 *
 * @property int $id
 * @property int $bv_id
 * @property string $mamau
 * @property int $loaimau_id
 * @property int $qcvn_id
 * @property int $vs
 * @property int $hl_xn
 * @property int $hl_mt
 * @property int $hl_vs
 * @property string $ngaylaymau
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $hl
 * @property string $ten
 * @property string $maquan
 * @property string $maphuong
 * @property string $diachi
 */
class Benhvien extends MyModel
{
    protected $dates = ['ngaylaymau'];
    protected $timestamps = true;
    protected $blameables = true;

    public $data_cts;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'benhvien';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['loaimau_id', 'qcvn_id', 'vs', 'hl_xn', 'hl_mt', 'hl_vs', 'created_by', 'updated_by', 'hl'], 'default', 'value' => null],
            [['bv_id', 'loaimau_id', 'qcvn_id', 'vs', 'hl_xn', 'hl_mt', 'hl_vs', 'created_by', 'updated_by', 'hl'], 'integer'],
            [['ngaylaymau', 'created_at', 'updated_at'], 'safe'],
            [['diachi', 'donvilaymau'], 'string'],
            [['ten'], 'required'],
            [['mamau', 'ten', 'maquan', 'maphuong'], 'string', 'max' => 255],
            ['data_cts', 'validateChitieus']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bv_id' => 'Bv ID',
            'mamau' => 'Mã mẫu',
            'loaimau_id' => 'Loại mẫu',
            'qcvn_id' => 'QCVN',
            'vs' => 'vs',
            'hl_xn' => 'hl xn',
            'hl_mt' => 'hl mt',
            'hl_vs' => 'hl vs',
            'ngaylaymau' => 'Ngày lấy mẫu',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'hl' => 'hl',
            'ten' => 'Ten',
            'maquan' => 'Quận',
            'maphuong' => 'Phường',
            'diachi' => 'Địa chỉ',
        ];
    }

    public function validateChitieus($attribute, $params, $validator)
    {
        foreach ($this->$attribute as $k => $v){
            $m = new QlChitieu();
            $m->load($v, '') && $m->validate();
            if($m->hasErrors()){
                $message = collect($m->getErrors())->flatten()->implode(', ') .'('.$v['giatri'].')';
                $this->addError($attribute, $message);
            }
        }
    }

    public function getMetaChitieu($qcvn_id){
        $query = $this->getDmChitieu();

        $dm_ct = (new $query->modelClass)::find()->where(['qcvn_id' => $qcvn_id])->indexBy('id')->asArray()->all();

        $ct = $this->getChitieus()->orderBy('id')->indexBy('chitieu_id')->all();

        $limitFunc = function ($from, $to){
            if(!is_null($from) && !is_null($to)){
                return $from.' - '.$to;
            } elseif (!is_null($from) && is_null($to)){
                return '&ge; '.$from;
            } elseif (is_null($from) && !is_null($to)){
                return '&le; '.$to;
            }
            return null;
        };

        foreach ($dm_ct as $k => $item){
            $giatri = data_get($ct, "{$k}.giatri");
            $highlight = is_null($giatri) ? '' : (($giatri >= $item['val_from'] & $giatri <= $item['val_to']) ? '' : 'danger');
            $limit = Html::tag('b', $limitFunc($item['val_from'], $item['val_to'])).Html::tag('span', $item['unit'] ? '('.$item['unit'].')' : '');
            $model = new DynamicModel(array_merge($item, compact('giatri', 'highlight', 'limit')));
            $dm_ct[$k] = $model;
        }
        return array_values($dm_ct);
    }

    public function getChitieus(){
        return $this->hasMany(QlChitieu::className(), ['entity_id' => 'id'])->andWhere(['entity_type' => Benhvien::className()]);
    }

    public function getDmChitieu()
    {
        return $this->hasMany(DmChitieu::className(), ['id' => 'chitieu_id'])->viaTable('ql_chitieu', ['entity_id' => 'id']);
    }
}
