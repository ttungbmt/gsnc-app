<?php

namespace gsnc\models;

use Yii;
use common\models\MyModel;

/**
 * This is the model class for table "mangluoinuoc".
 *
 * @property int $gid
 * @property string $objectid
 * @property string $idmaduongo Mã đường ống
 * @property string $idcapnuoc
 * @property int $huongdongc
 * @property string $chieudai Chiều dài
 * @property int $vatlieu Vật liệu
 * @property int $tieuchuan Tiêu chuẩn
 * @property int $hieu
 * @property int $nuocsanxua
 * @property string $donhamthuc
 * @property string $aplucthiet
 * @property string $namlapdat
 * @property string $vitrilapda
 * @property string $dosau
 * @property string $dodoc
 * @property string $donhamdanh
 * @property int $tinhtrang
 * @property string $alhoatdong
 * @property string $dktrong
 * @property string $dkngoai
 * @property string $coong
 * @property int $capong Cấp ống
 * @property int $loaiongnuo
 * @property string $shape_leng
 * @property string $shape_le_1
 * @property string $geom
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 */
class Mangluoinuoc extends MyModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mangluoinuoc';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['objectid', 'chieudai', 'donhamthuc', 'aplucthiet', 'namlapdat', 'dosau', 'dodoc', 'donhamdanh', 'alhoatdong', 'dktrong', 'dkngoai', 'coong', 'shape_leng', 'shape_le_1'], 'number'],
            [['huongdongc', 'vatlieu', 'tieuchuan', 'hieu', 'nuocsanxua', 'tinhtrang', 'capong', 'loaiongnuo'], 'default', 'value' => null],
            [['huongdongc', 'vatlieu', 'tieuchuan', 'hieu', 'nuocsanxua', 'tinhtrang', 'capong', 'loaiongnuo'], 'integer'],
            [['geom'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['idmaduongo', 'idcapnuoc'], 'string', 'max' => 10],
            [['vitrilapda'], 'string', 'max' => 254],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gid' => Yii::t('app', 'Gid'),
            'objectid' => Yii::t('app', 'Objectid'),
            'idmaduongo' => Yii::t('app', 'Mã đường ống'),
            'idcapnuoc' => Yii::t('app', 'ID cấp nước'),
            'huongdongc' => Yii::t('app', 'Huongdongc'),
            'chieudai' => Yii::t('app', 'Chiều dài'),
            'vatlieu' => Yii::t('app', 'Vật liệu'),
            'tieuchuan' => Yii::t('app', 'Tiêu chuẩn'),
            'hieu' => Yii::t('app', 'Hiệu'),
            'nuocsanxua' => Yii::t('app', 'Nuocsanxua'),
            'donhamthuc' => Yii::t('app', 'Donhamthuc'),
            'aplucthiet' => Yii::t('app', 'Aplucthiet'),
            'namlapdat' => Yii::t('app', 'Năm lắp đặt'),
            'vitrilapda' => Yii::t('app', 'Vị trí lắp đặt'),
            'dosau' => Yii::t('app', 'Độ sâu'),
            'dodoc' => Yii::t('app', 'Dodoc'),
            'donhamdanh' => Yii::t('app', 'Donhamdanh'),
            'tinhtrang' => Yii::t('app', 'Tình trạng'),
            'alhoatdong' => Yii::t('app', 'Alhoatdong'),
            'dktrong' => Yii::t('app', 'Dktrong'),
            'dkngoai' => Yii::t('app', 'Dkngoai'),
            'coong' => Yii::t('app', 'Coong'),
            'capong' => Yii::t('app', 'Cấp ống'),
            'loaiongnuo' => Yii::t('app', 'Loại ống nước'),
            'shape_leng' => Yii::t('app', 'Shape Leng'),
            'shape_le_1' => Yii::t('app', 'Shape Le 1'),
            'geom' => Yii::t('app', 'Geom'),
            'id' => Yii::t('app', 'ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}
