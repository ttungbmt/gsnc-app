<?php

namespace gsnc\models;

use Yii;
use common\models\MyModel;

/**
 * This is the model class for table "poi_thugomrac".
 *
 * @property int $gid
 * @property string $ten Tên đơn vị
 * @property string $diachi Địa chỉ
 * @property string $lat
 * @property string $lng
 * @property int $onhiem_id
 * @property string $maquan Phường
 * @property string $maphuong Quận
 * @property string $geom
 * @property string $sonha
 * @property string $tenduong
 * @property string $check
 */
class PoiThugomrac extends MyModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'poi_thugomrac';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'lat', 'lng', 'geom', 'sonha'], 'safe'],
            [['diachi'], 'string'],
            [['onhiem_id'], 'default', 'value' => null],
            [['onhiem_id'], 'integer'],
            [['ten', 'tenduong', 'check'], 'string', 'max' => 255],
            [['maquan', 'maphuong'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gid' => Yii::t('app', 'Gid'),
            'ten' => Yii::t('app', 'Tên đơn vị'),
            'diachi' => Yii::t('app', 'Địa chỉ'),
            'lat' => Yii::t('app', 'Lat'),
            'lng' => Yii::t('app', 'Lng'),
            'onhiem_id' => Yii::t('app', 'Ô nhiễm'),
            'maquan' => Yii::t('app', 'Phường'),
            'maphuong' => Yii::t('app', 'Quận'),
            'geom' => Yii::t('app', 'Geom'),
            'sonha' => Yii::t('app', 'Số nhà'),
            'tenduong' => Yii::t('app', 'Tên đường'),
            'check' => Yii::t('app', 'Check'),
        ];
    }


}
