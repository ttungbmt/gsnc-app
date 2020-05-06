<?php

namespace gsnc\models;

use gsnc\behaviors\VtKhaosatBehavior;
use gsnc\behaviors\VtOnhiemBehavior;
use Yii;
use common\models\MyModel;
/**
 * This is the model class for table "vt_onhiem".
 *
 * @property int $gid
 * @property string $ten Tên vị trí ô nhiễm
 * @property string $diachi Địa chỉ
 * @property string $ghichu Ghi chú
 * @property string $lat Vĩ độ
 * @property string $lng Kinh độ
 * @property int $onhiem_id Loại ô nhiễm
 * @property int $maphuong Phường
 * @property int $maquan Quận
 * @property string $geom
 * @property string $created_at
 * @property string $updated_at
 */
class VtOnhiem extends MyModel
{

    public static function tableName()
    {
        return 'vt_onhiem';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['diachi'], 'string'],
            [['onhiem_id', 'maphuong', 'maquan'], 'default', 'value' => null],
            [['onhiem_id', 'maphuong', 'maquan'], 'integer'],
            [['created_at', 'updated_at', 'ghichu', 'lat', 'lng', 'geom'], 'safe'],
            [['ten'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gid' => 'ID',
            'ten' => 'Tên vị trí',
            'diachi' => 'Địa chỉ',
            'ghichu' => 'Ghi chú',
            'lat' => 'Lat',
            'lng' => 'Lng',
            'onhiem_id' => 'Onhiem ID',
            'maphuong' => 'Phường',
            'maquan' => 'Quận',
            'geom' => 'Geom',
            'created_at' => 'Ngày tạo',
            'updated_at' => 'Ngày cập nhật',
        ];
    }
    public function getPhuong()
    {
        return $this->hasOne(DmPhuong::className(), ['maphuong' => 'maphuong']);
    }

    public function getLoaionhiem()
    {
        return $this->hasOne(DmOnhiem::className(), ['id' => 'onhiem_id']);
    }
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'log' => [
                'class' => VtOnhiemBehavior::className(),

            ]
        ]);
    }
}
