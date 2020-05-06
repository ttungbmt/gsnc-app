<?php

namespace gsnc\models;

use common\models\MyModel;
use Yii;

/**
 * This is the model class for table "meta_ykien".
 *
 * @property int $id
 * @property string $group_id
 * @property string $ten
 * @property int $vtkhaosat_gid
 */
class MetaYkien extends MyModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'meta_ykien';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vtkhaosat_gid'], 'default', 'value' => null],
            [['vtkhaosat_gid'], 'integer'],
            [['group_id', 'ten'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'group_id' => Yii::t('app', 'Group Column'),
            'ten' => Yii::t('app', 'Ten'),
            'vtkhaosat_gid' => Yii::t('app', 'Vtkhaosat Gid'),
        ];
    }
}
