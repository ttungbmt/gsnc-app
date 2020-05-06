<?php

namespace gsnc\models;

use common\models\MyModel;
use Yii;

/**
 * This is the model class for table "vt_ks_ykien".
 *
 * @property int $id
 * @property int $vt_khaosat_id
 * @property int $vt_ykien_id
 * @property string $value
 */
class VtKsYkien extends MyModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vt_ks_ykien';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vt_khaosat_id', 'meta_ykien_id'], 'default', 'value' => null],
            [['vt_khaosat_id', 'meta_ykien_id'], 'integer'],
            [['giatri'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'vt_khaosat_id' => Yii::t('app', 'Vt Khaosat ID'),
            'meta_ykien_id' => Yii::t('app', 'Meta Ykien ID'),
            'giatri' => Yii::t('app', 'Giá trị'),
        ];
    }

    public function getMeta()
    {
        return $this->hasOne(MetaYkien::className(), ['id' => 'meta_ykien_id']);
    }

    public function getVtKhaosat(){
        return $this->hasOne(VtKhaosat::className(), ['gid' => 'vt_khaosat_id']);
    }

}
