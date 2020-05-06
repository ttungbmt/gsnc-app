<?php
namespace gsnc\forms;

use common\models\DynamicImportForm;
use gsnc\models\Maunc;
use Illuminate\Support\Arr;

class MaunuocImportForm extends DynamicImportForm
{
    public $qcvn_id;
    public $dm_quan;
    public $dm_phuong;
    public $dm_chitieu;
    public $dm_maunc;

    public function attributeLabels(){
        return [
            'donvilaymau' => 'Đơn vị lấy mẫu',
            'maphuong' => 'Mã phường',
            'maquan' => 'Mã quận',
            'diachi' => 'Địa chỉ',
            'loaimau_id' => 'Loại mẫu',
            'ngaylaymau' => 'Ngày lấy mẫu',
            'mamau' => 'Mã mẫu',
        ];
    }

    public function rules()
    {
        $rules = [
            [['donvilaymau', 'maquan', 'maphuong', 'diachi', 'loaimau_id', 'mamau', 'lat', 'lng'],  'filter', 'filter' => 'trim'],
            [['loaimau_id'], 'in', 'range' => $this->dm_maunc],
            [['donvilaymau', 'maquan', 'maphuong', 'loaimau_id'], 'required'],
            [['donvilaymau'], 'in', 'range' => Arr::pluck($this->dm_quan, 'tenquan')],
            [['maquan'], 'in', 'range' => Arr::pluck($this->dm_quan, 'tenquan')],
            [['maphuong'], 'in', 'range' => Arr::pluck($this->dm_phuong, 'tenphuong')],
            [['ngaylaymau'], 'date', 'format' => 'DD/MM/YYYY'],
            [$this->dm_chitieu, 'filter', 'filter' => function($v){return $this->filterChitieu($v);}],
            [['qcvn_id'], 'integer'],
            [['vs', 'hl_mt', 'hl_xn', 'hl_vs'], 'in', 'range' => ['Đ', 'K']],
            [['lat', 'lng'], 'number']
        ];

        // validate chi tieu
        $ct_num = collect($this->dm_chitieu)->filter(function ($i){ return $i !== 'muivi';})->all();
        $rules[] = [$ct_num, 'number'];
        $rules[] = ['muivi', 'in', 'range' => ['Đ', 'K']];
        return $rules;
    }

    public function fields(){
        $data = collect();

        $f_danhgia = collect(['vs', 'hl_mt', 'hl_xn', 'hl_vs'])->mapWithKeys(function ($i){
            return [$i => function() use($i){
                return is_null($this->{$i}) ? null : data_get(['Đ' => 1, 'K' => 0], $this->{$i});
            }];
        })->all();

        $f0 = collect([
            'donvilaymau' => $this->dm_quan,
            'maquan' => $this->dm_quan,
            'maphuong' => $this->dm_phuong,
            'loaimau_id' => $this->dm_maunc,
        ])->map(function ($dm, $k){
            return function($model, $field) use($dm, $k){
                $val = $this->arr_where($dm, $field);
                return in_array($k, ['maphuong', 'maquan', 'donvilaymau', 'loaimau_id']) ? (string)$val : $val;
            };
        })->all();

        $f1 = collect(['loaimau_id' => $this->dm_maunc])->map(function ($dm, $k){
            return function($model, $field) use($dm, $k){
                $val = array_search($this->{$field}, $dm);
                return in_array($k, ['loaimau_id']) ? (string)$val : $val;
            };
        })->all();

        $data->push([
            'diachi',
            'qcvn_id',
            'ngaylaymau',
            'mamau',
        ]);
        $data->push($f0);
        $data->push($f_danhgia);
        $data->push($f1);

        $data->push([
            'chitieus' => function($model){
                return collect($model)->only($this->dm_chitieu)
                    ->filter(function ($i){ return !is_null($i);})
                    ->map(function ($val, $name){
                        return [
                            'chitieu_id' => array_search($name, $this->dm_chitieu),
                            'giatri' => $val,
                            'entity_type' => Maunc::className(),
                        ];
                    })->values();
            },
            'geom' => function($model, $field){
                if($model->lng && $model->lat){
                    return [$model->lng, $model->lat];
                }
            },
        ]);

        return $data->collapse()->all();
    }
}