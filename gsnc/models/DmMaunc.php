<?php

namespace gsnc\models;

use common\models\MyModel;
use Yii;

/**
 * This is the model class for table "dm_maunc".
 *
 * @property int $id id
 * @property string $mamau Mã mẫu
 * @property string $ghichu Ghi chú
 * @property string $ten Tên mẫu
 * @property string $created_at Ngày tạo
 * @property string $updated_at Ngày cập nhật
 * @property int $status Tình trạng
 */
class DmMaunc extends MyModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dm_maunc';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mamau'], 'required'],
            [['mamau'], 'unique'],
            [['ghichu'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['status'], 'default', 'value' => 1],
            [['status'], 'integer'],
            [['mamau', 'ten'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mamau' => 'Mã mẫu',
            'ghichu' => 'Ghi chú',
            'ten' => 'Tên mẫu',
            'created_at' => 'Ngày tạo',
            'updated_at' => 'Ngày cập nhật',
            'status' => 'Tình trạng',
        ];
    }
}
