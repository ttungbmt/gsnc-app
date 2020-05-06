<?php

namespace gsnc\models;

use common\models\MyModel;
use common\supports\MyActiveRecord;
use gsnc\models\DmChitieu;
use gsnc\models\Maunc;
use Illuminate\Support\Str;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "ql_chitieu".
 *
 * @property int    $id
 * @property int    $chitieu_id
 * @property double $giatri
 * @property int    $entity_id
 * @property string $created_at
 * @property string $updated_at
 * @property int    $maunuoc_gid
 */
class QlChitieu extends MyModel
{
//    protected $with = ['chitieu'];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ql_chitieu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['chitieu_id', 'entity_id'], 'default', 'value' => null],
            [['chitieu_id', 'entity_id'], 'integer'],
            [['entity_type'], 'string'],
            [['giatri'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'chitieu_id'  => 'Chitieu ID',
            'entity_type'  => 'Entyty Type',
            'giatri'      => 'Chỉ tiêu',
            'entity_id'   => 'Maunc Gid',
            'created_at'  => 'Created At',
            'updated_at'  => 'Updated At',
        ];
    }

    public function getChitieu()
    {
        return $this->hasOne(DmChitieu::className(), ['id' => 'chitieu_id']);
    }

    public function getMaunc()
    {
        return $this->hasOne(Maunc::className(), ['gid' => 'entity_id']);
    }

    public function getChitieuable()
    {
        return $this->morphTo('entity');
    }
}
