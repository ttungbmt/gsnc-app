<?php

namespace gsnc\models;

use common\models\MyModel;
use Yii;

/**
 * This is the model class for table "dm_phuong".
 *
 * @property int $gid
 * @property string $caphc
 * @property string $maphuong
 * @property string $maquan
 * @property string $tenphuong
 * @property string $tenquan
 * @property string $soho
 * @property string $geom
 * @property string $tenphuong_en
 * @property string $tenquan_en
 * @property string $tenphuong_format
 * @property string $tenquan_format
 * @property int $order
 */
class DmPhuong extends MyModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dm_phuong';
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
            [['caphc', 'tenquan'], 'string', 'max' => 20],
            [['maphuong', 'maquan', 'tenphuong'], 'string', 'max' => 50],
            [['tenphuong_en', 'tenquan_en', 'tenphuong_format', 'tenquan_format'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'gid' => Yii::t('app', 'Gid'),
            'caphc' => Yii::t('app', 'Cấp hành chính'),
            'maphuong' => Yii::t('app', 'Mã phường'),
            'maquan' => Yii::t('app', 'Mã quận'),
            'tenphuong' => Yii::t('app', 'Tên phường'),
            'tenquan' => Yii::t('app', 'Tên quận'),
            'soho' => Yii::t('app', 'Số hộ dân'),
            'geom' => Yii::t('app', 'Geom'),
            'tenphuong_en' => Yii::t('app', 'Tên phường tiếng anh'),
            'tenquan_en' => Yii::t('app', 'Tên quận tiếng anh'),
            'tenphuong_format' => Yii::t('app', 'Tên phường Format'),
            'tenquan_format' => Yii::t('app', 'Tên quận Format'),
            'order' => Yii::t('app', 'Order'),
        ];
    }
}
