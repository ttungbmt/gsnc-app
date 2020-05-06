<?php

namespace gsnc\models;
use gsnc\models\DmChitieu;
use common\models\MyModel;
use Yii;

/**
 * This is the model class for table "ql_chitieubv".
 *
 * @property int $id
 * @property int $chitieu_id
 * @property double $giatri
 * @property int $benhvien_id
 * @property string $created_at
 * @property string $updated_at
 */
class QlChitieubv extends MyModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ql_chitieubv';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['chitieu_id', 'benhvien_id'], 'default', 'value' => null],
            [['chitieu_id', 'benhvien_id'], 'integer'],
            [['giatri'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'chitieu_id' => 'Chitieu ID',
            'giatri' => 'Giatri',
            'benhvien_id' => 'Benhvien ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    public function getChitieu()
    {
        return $this->hasOne(DmChitieu::className(),['id'=>'chitieu_id']);
    }
    public function getBenhvien(){
        return $this->hasOne(Benhvien::className(),['gid'=>'benhvien_id']);
    }
}
