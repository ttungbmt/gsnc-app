<?php

namespace gsnc\models;

use common\models\MyModel;
use Yii;

/**
 * This is the model class for table "dm_qcvn".
 *
 * @property int $id
 * @property string $tenqc Tên quy chuẩn
 * @property string $ghichu Ghi chú
 * @property int $status Tình trạng
 * @property string $created_at Ngày tạo
 * @property string $updated_at Ngày cập nhật
 * @property string $type
 * @property string $mota Mô tả
 */
class DmQcvn extends MyModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dm_qcvn';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tenqc'], 'required'],
            [['ghichu', 'mota'], 'string'],
            [['status'], 'default', 'value' => null],
            [['status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['tenqc', 'type'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tenqc' => 'Tên quy chuẩn',
            'ghichu' => 'Ghi chú',
            'status' => 'Tình trạng',
            'created_at' => 'Ngày tạo',
            'updated_at' => 'Ngày cập nhật',
            'type' => 'Type',
            'mota' => 'Mô tả',
        ];
    }

    public function getChitieus()
    {
        return $this->hasMany(DmChitieu::className(), ['qcvn_id' => 'id']);
    }

}
