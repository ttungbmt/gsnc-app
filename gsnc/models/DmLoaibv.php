<?php

namespace gsnc\models;
use common\models\MyModel;
use Yii;

/**
 * This is the model class for table "dm_loaibv".
 *
 * @property int $id
 * @property string    $maloai
 * @property string $ten Tên loại bệnh viện
 * @property string $mota Mô tả
 * @property string $created_at
 * @property string $updated_at
 * @property int $status Tình trạng
 */
class DmLoaibv extends MyModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dm_loaibv';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ten'], 'required'],
            [['maloai'], 'required'],
            [['mota'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['status'], 'default', 'value' => null],
            [['status'], 'integer'],
            [['ten'], 'string', 'max' => 255],
            [['maloai'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'maloai' => 'Mã loại bệnh viện',
            'ten' => 'Bệnh viện',
            'mota' => 'Mô tả',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }
}
