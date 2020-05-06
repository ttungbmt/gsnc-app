<?php

namespace gsnc\models;

use common\models\MyModel;
use Yii;

/**
 * This is the model class for table "dm_quan".
 *
 * @property int $gid
 * @property string $tenquan
 * @property string $maquan
 * @property string $caphc
 * @property string $soho
 * @property string $geom
 * @property string $tenquan_en
 * @property int $order
 */
class DmQuan extends MyModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dm_quan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['soho'], 'number'],
            [['geom'], 'string'],
            [['order'], 'default', 'value' => null],
            [['order'], 'integer'],
            [['tenquan'], 'string', 'max' => 20],
            [['maquan', 'caphc'], 'string', 'max' => 50],
            [['tenquan_en'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'gid' => Yii::t('app', 'Gid'),
            'tenquan' => Yii::t('app', 'Tên quận'),
            'maquan' => Yii::t('app', 'Mã quận'),
            'caphc' => Yii::t('app', 'Cấp hành chính'),
            'soho' => Yii::t('app', 'Số hộ dân'),
            'geom' => Yii::t('app', 'Geom'),
            'tenquan_en' => Yii::t('app', 'Tên quận tiếng anh'),
            'order' => Yii::t('app', 'Order'),
        ];
    }

    public function getDmPhuongs()
    {
        return $this->hasMany(DmPhuong::className(), ['maquan' => 'maquan']);
    }
}
