<?php

namespace gsnc\models;

use common\models\MyModel;
use gsnc\models\QlChitieubv;
use Yii;
use yii\helpers\Html;
use yii\base\DynamicModel;
use gsnc\behaviors\BenhvienBehavior;

/**
 * This is the model class for table "poi_benhvien".
 *
 * @property int $gid ID
 * @property string $ten Tên bệnh viện
 * @property string $diachi Địa chỉ
 * @property string $sonha Số nhà
 * @property string $tenduong Tên đường
 * @property string $tenquan
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
 */
class Benhvien_backup extends MyModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'poi_benhvien';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gioithieu'], 'string'],
            [['onhiem_id', 'loaibv_id', 'vs', 'hl', 'hl_vs', 'qcvn_id', 'loaimau_id'], 'default', 'value' => null],
            [['onhiem_id', 'loaibv_id', 'vs', 'hl', 'hl_vs', 'hl_xn', 'hl_mt', 'qcvn_id', 'loaimau_id'], 'integer'],
            [['created_at', 'updated_at', 'ngaylaymau', 'geom', 'mamau', 'lat', 'lng', 'dienthoai'], 'safe'],
            [['diachi', 'ten', 'sonha', 'tenduong', 'loaibv', 'website', 'lichlamviec', 'thamkhao', 'check'], 'string', 'max' => 255],
            [['maquan', 'maphuong'], 'string', 'max' => 225],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gid' => 'Gid',
            'ten' => 'Bệnh Viện',
            'diachi' => 'Địa chỉ',
            'sonha' => 'Sonha',
            'tenduong' => 'Tenduong',
            'maquan' => 'Maquan',
            'maphuong' => 'Maphuong',
            'lat' => 'Lat',
            'lng' => 'Lng',
            'loaibv' => 'Loaibv',
            'dienthoai' => 'Điện thoại',
            'website' => 'Website',
            'lichlamviec' => 'Lichlamviec',
            'thamkhao' => 'Thamkhao',
            'gioithieu' => 'Giới thiệu',
            'check' => 'Check',
            'onhiem_id' => 'Onhiem ID',
            'geom' => 'Geom',
            'loaibv_id' => 'Loaibv ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'vs' => 'Vs',
            'hl' => 'Hl',
            'hl_vs' => 'Hl Vs',
            'qcvn_id' => 'Qcvn ID',
            'ngaylaymau' => 'Ngày lấy mẫu',
            'mamau' => 'Mã mẫu',
            'loaimau_id' => 'Loaimau ID',
        ];
    }
    public function getChitieus()
    {
        return $this->hasMany(QlChitieubv::className(), ['benhvien_id' => 'gid']);
    }

    public function getDmChitieu()
    {
        return $this->hasMany(DmChitieu::className(), ['id' => 'chitieu_id'])->viaTable('ql_chitieubv', ['benhvien_id' => 'id']);
    }

    public function getMetaChitieu($qcvn_id){
        $query = $this->getDmChitieu();

        $dm_ct = (new $query->modelClass)::find()->where(['qcvn_id' => $qcvn_id])->indexBy('id')->asArray()->all();

        $ct = $this->getChitieus()->orderBy('id')->indexBy('chitieu_id')->all();

        $limitFunc = function ($from, $to){
            if(!is_null($from) && !is_null($to)){
                return $from.' - '.$to;
            } elseif (!is_null($from) && is_null($to)){
                return '&ge; '.$from;
            } elseif (is_null($from) && !is_null($to)){
                return '&le; '.$to;
            }
            return null;
        };

        foreach ($dm_ct as $k => $item){
            $giatri = data_get($ct, "{$k}.giatri");
            $highlight = is_null($giatri) ? '' : (($giatri >= $item['val_from'] & $giatri <= $item['val_to']) ? '' : 'danger');
            $limit = Html::tag('b', $limitFunc($item['val_from'], $item['val_to'])).Html::tag('span', $item['unit'] ? '('.$item['unit'].')' : '');
            $model = new DynamicModel(array_merge($item, compact('giatri', 'highlight', 'limit')));
            $dm_ct[$k] = $model;
        }
        return array_values($dm_ct);
    }

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'log' => [
                'class' => BenhvienBehavior::className(),

            ]
        ]);
    }
}
