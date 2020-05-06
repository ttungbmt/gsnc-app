<?php
namespace gsnc\models;

use common\models\MyModel;
use Yii;

/**
 * This is the model class for table "dm_chitieu".
 *
 * @property int    $id
 * @property string $ma         Mã
 * @property string $tenchitieu Tên chỉ tiêu
 * @property double $val_from   GTGH từ
 * @property double $val_to     GTGH đến
 * @property int    $qcvn_id    Quy chuẩn
 * @property string $color
 * @property string $created_at
 * @property string $updated_at
 * @property string $unit
 */
class DmChitieu extends MyModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dm_chitieu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['qcvn_id', 'ma', 'tenchitieu'], 'required'],
            [['tenchitieu'], 'string'],
            [['val_from', 'val_to'], 'number'],
            [['qcvn_id'], 'default', 'value' => null],
            [['qcvn_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['ma', 'color', 'unit', 'danhgia'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'ma'         => 'Mã',
            'tenchitieu' => 'Tên chỉ tiêu',
            'val_from'   => 'Giá trị từ',
            'val_to'     => 'Giá trị đến',
            'qcvn_id'    => 'QCVN',
            'color'      => 'Màu',
            'created_at' => 'Ngày tạo',
            'updated_at' => 'Ngày chỉnh sửa',
            'unit'       => 'ĐVT',
            'danhgia'   => 'Đánh giá'
        ];
    }

    public function getQcvn()
    {
        return $this->hasOne(DmQcvn::className(), ['id' => 'qcvn_id']);
    }
}
