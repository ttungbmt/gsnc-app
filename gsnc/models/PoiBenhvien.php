<?php

namespace gsnc\models;

use Yii;

/**
 * This is the model class for table "poi_benhvien".
 *
 * @property int $gid ID
 * @property string $ten Tên bệnh viện
 * @property string $diachi Địa chỉ
 * @property string $sonha Số nhà
 * @property string $tenduong Tên đường
 * @property string $maquan Quận
 * @property string $maphuong Phường
 * @property string $lat
 * @property string $lng
 * @property string $loaibv Loại bệnh viện
 * @property string $dienthoai Điện thoại
 * @property string $website Website
 * @property string $lichlamviec Lịch làm việc
 * @property string $thamkhao Tham khảo
 * @property string $gioithieu Giới thiệu
 * @property string $check
 * @property int $onhiem_id
 * @property string $geom
 * @property int $loaibv_id Loại bệnh viện
 * @property string $created_at
 * @property string $updated_at
 * @property int $status Tình trạng
 * @property int $vs
 * @property int $hl
 * @property int $hl_vs
 * @property int $qcvn_id
 * @property string $ngaylaymau Ngày lấy mẫu
 * @property string $mamau Mã mẫu
 * @property int $loaimau_id Loại mẫu
 * @property int $hl_xn
 * @property int $hl_mt
 */
class PoiBenhvien extends \common\models\MyModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'poi_benhvien';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gioithieu', 'geom'], 'string'],
            [['onhiem_id', 'loaibv_id', 'status', 'vs', 'hl', 'hl_vs', 'qcvn_id', 'loaimau_id', 'hl_xn', 'hl_mt'], 'default', 'value' => null],
            [['onhiem_id', 'loaibv_id', 'status', 'vs', 'hl', 'hl_vs', 'qcvn_id', 'loaimau_id', 'hl_xn', 'hl_mt'], 'integer'],
            [['created_at', 'updated_at', 'ngaylaymau'], 'safe'],
            [['ten', 'diachi', 'sonha', 'tenduong', 'lat', 'lng', 'loaibv', 'dienthoai', 'website', 'lichlamviec', 'thamkhao', 'check', 'mamau'], 'string', 'max' => 255],
            [['maquan', 'maphuong'], 'string', 'max' => 225],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'gid' => Yii::t('app', 'ID'),
            'ten' => Yii::t('app', 'Tên bệnh viện'),
            'diachi' => Yii::t('app', 'Địa chỉ'),
            'sonha' => Yii::t('app', 'Số nhà'),
            'tenduong' => Yii::t('app', 'Tên đường'),
            'maquan' => Yii::t('app', 'Quận'),
            'maphuong' => Yii::t('app', 'Phường'),
            'lat' => Yii::t('app', 'Lat'),
            'lng' => Yii::t('app', 'Lng'),
            'loaibv' => Yii::t('app', 'Loại bệnh viện'),
            'dienthoai' => Yii::t('app', 'Điện thoại'),
            'website' => Yii::t('app', 'Website'),
            'lichlamviec' => Yii::t('app', 'Lịch làm việc'),
            'thamkhao' => Yii::t('app', 'Tham khảo'),
            'gioithieu' => Yii::t('app', 'Giới thiệu'),
            'check' => Yii::t('app', 'Check'),
            'onhiem_id' => Yii::t('app', 'Onhiem ID'),
            'geom' => Yii::t('app', 'Geom'),
            'loaibv_id' => Yii::t('app', 'Loại bệnh viện'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'status' => Yii::t('app', 'Tình trạng'),
            'vs' => Yii::t('app', 'Vs'),
            'hl' => Yii::t('app', 'Hl'),
            'hl_vs' => Yii::t('app', 'Hl Vs'),
            'qcvn_id' => Yii::t('app', 'Qcvn ID'),
            'ngaylaymau' => Yii::t('app', 'Ngày lấy mẫu'),
            'mamau' => Yii::t('app', 'Mã mẫu'),
            'loaimau_id' => Yii::t('app', 'Loại mẫu'),
            'hl_xn' => Yii::t('app', 'Hl Xn'),
            'hl_mt' => Yii::t('app', 'Hl Mt'),
        ];
    }
}
