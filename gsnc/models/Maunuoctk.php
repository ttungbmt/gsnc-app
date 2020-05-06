<?php

namespace gsnc\models;

use gsnc\models\Maunc;
use Yii;

/**
 * This is the model class for table "maunc".
 *
 * @property int    $gid
 * @property string $mamau       Mã mẫu
 * @property string $ngaylaymau  Ngày lấy mẫu
 * @property string $diachi      Địa chỉ
 * @property string $maquan      Quận
 * @property string $maphuong    Phường
 * @property int    $vs
 * @property int    $hl
 * @property int    $hl_vs
 * @property string $created_at
 * @property string $updated_at
 * @property string $lat
 * @property string $lng
 * @property int    $loaimau_id  Loại mẫu
 * @property string $geom
 * @property int    $qcvn_id     QCVN
 * @property int    $check
 * @property int    $id_excel
 * @property string $tenmau      Tên mẫu
 * @property string $nguoilaymau Người lấy mẫu
 */
class Maunuoctk extends Maunc
{
    public $date_from;
    public $date_to;
    public $chitieu_id;

    public static function tableName()
    {
        return 'maunc';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date_from', 'date_to'], 'date', 'format' => 'DD/MM/YYYY'],
            [['loaimau_id', 'qcvn_id'], 'integer'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'loaimau_id' => 'Loại mẫu',
            'qcvn_id'    => 'QCVN',
            'date_from'  => 'Từ ngày lấy mẫu',
            'date_to'    => 'Đến ngày lấy mẫu',
        ];
    }
}
