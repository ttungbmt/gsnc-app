<?php

namespace gsnc\models;

use Yii;

/**
 * This is the model class for table "dm_phuong_vn".
 *
 * @property int $gid
 * @property string $ma
 * @property string $ten
 * @property string $ten_en
 * @property string $cap
 * @property string $ma_quan
 * @property string $ten_quan
 * @property string $ma_tinh
 * @property string $ten_tinh
 * @property string $danso_2016
 * @property string $danso_tt
 * @property string $phuong_en
 * @property string $quan_en
 * @property string $tinh_en
 * @property int $soho
 * @property string $mucchitieu
 * @property string $dientich_tt
 * @property string $ma_phuong
 * @property string $geom
 * @property string $v_geom
 */
class DmPhuongVn extends \common\models\MyModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dm_phuong_vn';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['danso_2016', 'danso_tt', 'mucchitieu', 'dientich_tt'], 'number'],
            [['soho'], 'default', 'value' => null],
            [['soho'], 'integer'],
            [['geom', 'v_geom'], 'string'],
            [['ma', 'ten', 'ten_en', 'cap', 'ma_quan', 'ten_quan', 'ma_tinh', 'ten_tinh'], 'string', 'max' => 254],
            [['phuong_en', 'quan_en', 'tinh_en', 'ma_phuong'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'gid' => Yii::t('app', 'Gid'),
            'ma' => Yii::t('app', 'Mã phường'),
            'ten' => Yii::t('app', 'Tên phường'),
            'ten_en' => Yii::t('app', 'Tên tiếng anh'),
            'cap' => Yii::t('app', 'Cấp hành chính'),
            'ma_quan' => Yii::t('app', 'Mã quận'),
            'ten_quan' => Yii::t('app', 'Tên quận'),
            'ma_tinh' => Yii::t('app', 'Mã tỉnh'),
            'ten_tinh' => Yii::t('app', 'Tên tỉnh'),
            'danso_2016' => Yii::t('app', 'Dân số 2016'),
            'danso_tt' => Yii::t('app', 'Danso Tt'),
            'phuong_en' => Yii::t('app', 'Phuong En'),
            'quan_en' => Yii::t('app', 'Quan En'),
            'tinh_en' => Yii::t('app', 'Tinh En'),
            'soho' => Yii::t('app', 'Soho'),
            'mucchitieu' => Yii::t('app', 'Mucchitieu'),
            'dientich_tt' => Yii::t('app', 'Dientich Tt'),
            'ma_phuong' => Yii::t('app', 'Mã phường'),
            'geom' => Yii::t('app', 'Geom'),
            'v_geom' => Yii::t('app', 'V Geom'),
        ];
    }
}
