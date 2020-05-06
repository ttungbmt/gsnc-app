<?php
namespace gsnc\models;

use common\models\MyModel;
use Yii;

/**
 * This is the model class for table "dm_onhiem".
 *
 * @property int    $id
 * @property string    $maloai
 * @property string $ten    Tên nguồn ô nhiễm
 * @property string $mota   Mô tả
 * @property string $created_at
 * @property string $updated_at
 * @property int    $status Tình trạng
 */
class DmOnhiem extends MyModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dm_onhiem';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ten'], 'required'],
            [['maloai'], 'required'],
            [['ten'], 'string', 'max' => 255],
            [['mota'], 'string'],
            [['status'], 'integer'],
            [['maloai'], 'string', 'max' => 255],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => Yii::t('app', 'ID'),
            'ten'        => Yii::t('app', 'Tên loại ô nhiễm'),
            'mota'       => Yii::t('app', 'Mô tả'),
            'created_at' => Yii::t('app', 'Ngày tạo'),
            'updated_at' => Yii::t('app', 'Ngày cập nhật'),
            'status'     => Yii::t('app', 'Tình trạng'),
            'maloai'        => Yii::t('app', 'Mã loại ô nhiễm'),
        ];
    }

    public function getVtonhiem()
    {
        return $this->hasOne(VtOnhiem::className(), ['onhiem_id' => 'id']);
    }
}
