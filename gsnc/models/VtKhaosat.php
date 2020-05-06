<?php
namespace gsnc\models;
use Yii;
use yii\helpers\Html;
use yii\base\DynamicModel;
use gsnc\behaviors\VtKhaosatBehavior;

/**
 * This is the model class for table "vt_khaosat".
 *
 * @property int $gid
 * @property string $diachi Địa chỉ
 * @property string $tenchuho Tên chủ hộ
 * @property string $ngaykhaosat Ngày khảo sát
 * @property string $maquan Quận
 * @property string $maphuong Phường
 * @property string $created_at
 * @property string $updated_at
 * @property string $lat
 * @property string $lng
 * @property string $geom
 * @property string $ghichu Ghi chú
 */
class VtKhaosat extends Gsnc
{
    protected $timestamps = true;
    protected $blameables = true;
    protected $dates = ['ngaykhaosat'];
    public $data_cts;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vt_khaosat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['diachi'], 'string'],
            [['donvikhaosat', 'ngaykhaosat', 'created_at', 'updated_at', 'geom', 'lat', 'lng'], 'safe'],
            [['tenchuho', 'maquan', 'maphuong', 'ghichu'], 'string', 'max' => 255],
            [['maquan'], 'roleHc'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gid' => 'Gid',
            'donvikhaosat' => 'Đơn vị khảo sát',
            'diachi' => 'Địa chỉ',
            'tenchuho' => 'Tên chủ hộ',
            'ngaykhaosat' => 'Ngày khảo sát',
            'maquan' => 'Quận',
            'maphuong' => 'Phường',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'lat' => 'Lat',
            'lng' => 'Lng',
            'geom' => 'Geom',
            'ghichu' => 'Ghichu',
        ];
    }

    public function getYkiens(){
        return $this->hasMany(VtKsYkien::className(), ['vt_khaosat_id' => 'gid']);
    }

    public function getDmYkien(){
        return $this->hasMany(MetaYkien::className(), ['id' => 'meta_ykien_id'])->viaTable('vt_ks_ykien', ['vt_khaosat_id' => 'gid']);
    }

    public function getMetaYkien(){
        $query = $this->getDmYkien();
        $dm_ykien = (new $query->modelClass)::find()->indexBy('id')->orderBy('id')->asArray()->all();
        $ykien = $this->getYkiens()->indexBy('meta_ykien_id')->all();

        foreach ($dm_ykien as $k => $item){
            $giatri = data_get($ykien, "{$k}.giatri");
            $highlight = is_null($giatri) ? '' : 'danger';
            $model = new DynamicModel(array_merge($item, compact('giatri', 'highlight')));
            $dm_ykien[$k] = $model;
        }
        return array_values($dm_ykien);
    }

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'log' => [
                'class' => VtKhaosatBehavior::className(),
            ]
        ]);
    }
}
