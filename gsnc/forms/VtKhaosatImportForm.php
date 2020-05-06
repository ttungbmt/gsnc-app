<?php
namespace gsnc\forms;

use common\models\DynamicImportForm;
use Illuminate\Support\Arr;

class VtKhaosatImportForm extends DynamicImportForm
{
    public $qcvn_id;
    public $dm_quan;
    public $dm_phuong;
    public $dm_chitieu;

    public function attributeLabels()
    {
        return [
            'donvikhaosat' => 'Đơn vị khảo sát (donvikhaosat)',
            'tenchuho' => 'Tên chủ hộ (tenchuho)',
            'maquan' => 'Mã quận (maquan)',
            'maphuong' => 'Mã phường (maphuong)',
            'diachi' => 'Mã phường (maphuong)',
            'ngaykhaosat' => 'Ngày khảo sát (ngaykhaosat)',
        ];
    }

    public function rules()
    {
        return [
            [['donvikhaosat', 'maquan', 'maphuong', 'diachi', 'tenchuho', 'lat', 'lng'],  'filter', 'filter' => 'trim'],
            [['donvikhaosat', 'maquan', 'maphuong'], 'required'],
            [['donvikhaosat'], 'in', 'range' => Arr::pluck($this->dm_quan, 'tenquan')],
            [['maquan'], 'in', 'range' => Arr::pluck($this->dm_quan, 'tenquan')],
            [['maphuong'], 'in', 'range' => Arr::pluck($this->dm_phuong, 'tenphuong')],
            [['ngaykhaosat'], 'date', 'format' => 'DD/MM/YYYY'],
            [$this->dm_chitieu, 'filter', 'filter' => function($v){return $this->filterChitieu($v);}],
            [['qcvn_id'], 'integer'],
//            [['vs', 'hl_mt', 'hl_xn', 'hl_vs'], 'in', 'range' => ['Đ', 'K']],
            [['lat', 'lng'], 'number']
        ];
    }

    public function fields(){
        $data = collect();

//        $f_danhgia = collect(['vs', 'hl_mt', 'hl_xn', 'hl_vs'])->mapWithKeys(function ($i){
//            return [$i => function() use($i){
//                return is_null($this->{$i}) ? null : data_get(['Đ' => 1, 'K' => 0], $this->{$i});
//            }];
//        })->all();

        $f0 = collect([
            'donvikhaosat' => $this->dm_quan,
            'maquan' => $this->dm_quan,
            'maphuong' => $this->dm_phuong,
        ])->map(function ($dm, $k){
            return function($model, $field) use($dm, $k){
                $val = $this->arr_where($dm, $field);
                $val = $val ? $val : "error:".$this->{$field};
                return in_array($k, ['maphuong', 'maquan', 'donvikhaosat']) ? (string)$val : $val;
            };
        })->all();

        $data->push([
            'diachi',
            'qcvn_id',
            'tenchuho',
            'ngaykhaosat',
        ]);
        $data->push($f0);
//        $data->push($f_danhgia);

        $data->push([
            'chitieus' => function($model){
                return collect($model)->only($this->dm_chitieu)
                    ->filter(function ($i){ return !is_null($i);})
                    ->map(function ($i, $name){
                        return [
                            'meta_ykien_id' => $name,
                            'giatri' => $i,
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