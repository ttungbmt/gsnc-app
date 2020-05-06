<?php

namespace gsnc\models;

use kartik\helpers\Html;
use oxyaction\behaviors\RelatedPolymorphicBehavior;
use yii\base\DynamicModel;
use gsnc\behaviors\MauncBehavior;

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
class Maunc extends Gsnc
{
    public $tenquan_en;
    public $tenphuong_en;
    public $data_cts;

    protected $dates = ['ngaylaymau'];

    protected $timestamps = true;

    protected $blameables = true;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'maunc';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $dsQuan = DmPhuong::find()->select('DISTINCT(tenphuong_en)')->where(['maphuong' => $this->tenquan_en])->asArray()->column();
        $dsPhuong = DmQuan::find()->select('DISTINCT(tenquan_en)')->where(['maquan' => $this->tenphuong_en])->asArray()->column();

        return [
            [['ngaylaymau', 'created_at', 'updated_at', 'mamau', 'lat', 'lng'], 'safe'],
            [['vs', 'hl_xn', 'hl_vs', 'loaimau_id', 'qcvn_id', 'check', 'id_excel'], 'default', 'value' => null],
            [['vs', 'hl_xn', 'hl_vs', 'hl_xn', 'hl_mt', 'loaimau_id', 'qcvn_id', 'check', 'id_excel'], 'integer'],
            [['geom'], 'safe'],
            [['diachi', 'donvilaymau', 'maquan', 'maphuong', 'tenmau', 'nguoilaymau'], 'string', 'max' => 255],
            ['tenquan_en', 'in', 'range' => $dsQuan],
            ['tenphuong_en', 'in', 'range' => $dsPhuong],
//            [[ 'ngaylaymau', 'loaimau_id'], 'unique', 'targetAttribute' => ['ngaylaymau', 'loaimau_id']],
        ];
    }

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'log' => [
                'class' => MauncBehavior::className(),
            ],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gid'          => 'Gid',
            'mamau'        => 'Mã mẫu',
            'ngaylaymau'   => 'Ngày lấy mẫu',
            'diachi'       => 'Địa chỉ',
            'maquan'       => 'Quận',
            'maphuong'     => 'Phường',
            'vs'           => 'Vs',
            'hl_xn'           => 'Hl',
            'hl_vs'        => 'Hl Vs',
            'created_at'   => 'Created At',
            'updated_at'   => 'Updated At',
            'lat'          => 'Lat',
            'lng'          => 'Lng',
            'loaimau_id'   => 'Loại mẫu',
            'geom'         => 'Geom',
            'qcvn_id'      => 'QCVN',
            'check'        => 'Check',
            'id_excel'     => 'Id Excel',
            'tenmau'       => 'Tên mẫu',
            'nguoilaymau'  => 'Người lấy mẫu',
            'tenquan_en'   => 'Mã quận',
            'tenphuong_en' => 'Mã phường',
        ];
    }

    public function getChitieus(){
        return $this->morphMany(QlChitieu::className(), 'entity');
    }

    public function getDmChitieu()
    {
        return $this->hasMany(DmChitieu::className(), ['id' => 'chitieu_id'])->viaTable('ql_chitieu', ['entity_id' => 'id']);
    }

    public function getMetaChitieu($qcvn_id)
    {
        $query = $this->getDmChitieu();

        $dm_ct = (new $query->modelClass)::find()->where(['qcvn_id' => $qcvn_id])->indexBy('id')->asArray()->all();
        $ct = $this->getChitieus()->orderBy('id')->indexBy('chitieu_id')->all();

        $limitFunc = function ($from, $to) {
            if (!is_null($from) && !is_null($to)) {
                return $from . ' - ' . $to;
            } elseif (!is_null($from) && is_null($to)) {
                return '&ge; ' . $from;
            } elseif (is_null($from) && !is_null($to)) {
                return '&le; ' . $to;
            }
            return null;
        };

        foreach ($dm_ct as $k => $item) {
            $giatri = data_get($ct, "{$k}.giatri");
            $highlight = is_null($giatri) ? '' : (($giatri >= $item['val_from'] & $giatri <= $item['val_to']) ? '' : 'danger');
            $limit = Html::tag('b', $limitFunc($item['val_from'], $item['val_to'])) . Html::tag('span', $item['unit'] ? '(' . $item['unit'] . ')' : '');
            $model = new DynamicModel(array_merge($item, compact('giatri', 'highlight', 'limit')));
            $dm_ct[$k] = $model;
        }

        return array_values($dm_ct);
    }
}
