<?php
namespace gsnc\forms;

use common\models\DynamicImportForm;
use Illuminate\Support\Str;


class BenhvienImportForm extends DynamicImportForm {
    public $qcvn_id;
    public $bv_id;
    public $dm_quan;
    public $dm_phuong;
    public $dm_chitieu;
    public $dm_maunc;
    public $dm_loaibv;
    public $dm_bv;

    public function attributeLabels() {
        return [
            'diachi'   => 'Địa chỉ (diachi)',
            'ten'      => 'Tên (ten)',
            'maquan'   => 'Mã quận (maquan)',
            'maphuong' => 'Mã phường (maphuong)',
        ];
    }

    public function rules() {
        return [
            [['donvilaymau', 'ten', 'diachi', 'maquan', 'maphuong', 'loaimau_id', 'mamau'], 'filter', 'filter' => 'trim'],
            [['maquan'], 'in', 'range' => $this->dm_quan],
            [['maphuong'], 'in', 'range' => $this->dm_phuong],
            [['ten'], 'in', 'range' => $this->dm_bv],
            [['ngaylaymau'], 'date', 'format' => 'DD/MM/YYYY'],
            [$this->dm_chitieu, 'filter', 'filter' => function ($v) {
                return $this->filterChitieu($v);
            }],
            [$this->dm_chitieu, 'number'],
            [['qcvn_id'], 'integer'],
            [['vs', 'hl_mt', 'hl_xn', 'hl_vs'], 'in', 'range' => ['Đ', 'K', '1', '0']],
            [['lat', 'lng'], 'number'],
            [['dm_bv'], 'safe']
        ];
    }

    protected function filterChitieu($inp) {
        if (is_string($inp)) {
            $v = trim($inp);
            if (strpos($v, ',')) {
                $arr = collect(explode(',', $v))->map(function ($i) {
                    return trim($i);
                });
                return $arr->count() <= 2 ? $arr->implode('.') : $arr->implode('');
            };
            if ($v == "" or $v == "-") return null;
        }
        return $inp;
    }

    public function arr_where($cat, $field) {
        $item = collect($cat)->map(function($v, $k){
            return ['code' => $k, 'text' =>  trim(Str::lower($v))];
        })->values()->firstWhere('text', trim(Str::lower($this->{$field})));
        return data_get($item, 'code');
    }

    public function fields() {
        $data = collect();

        $f_danhgia = collect(['vs', 'hl_mt', 'hl_xn', 'hl_vs'])->mapWithKeys(function ($i) {
            return [$i => function () use ($i) {
                return data_get(['Đ' => 1, 'K' => 0, '1' => 1, '0' => 0], $this->{$i});
            }];
        })->all();


        $f0 = collect([
            'donvilaymau' => $this->dm_quan,
            'maquan'      => $this->dm_quan,
            'maphuong'    => $this->dm_phuong,
            'loaimau_id'  => $this->dm_maunc,
        ])->map(function ($dm, $k) {
            return function ($model, $field) use ($dm, $k) {
                $val = $this->arr_where($dm, $field);
                return in_array($k, ['maphuong', 'maquan', 'donvilaymau', 'loaimau_id']) ? (string)$val : $val;
            };
        })->all();

        $f = collect([
            'bv_id'   => $this->dm_bv,
        ])->map(function ($dm, $k) {
            return function ($model, $field) use ($dm, $k) {
                $val = $this->arr_where($dm, 'ten');
                dd($val, $dm, $this->$field);
                return in_array($k, ['dm_bv']) ? (string)$val : $val;
            };
        })->all();

        $data->push([
            'ten',
            'qcvn_id',
            'ngaylaymau',
            'diachi',
        ]);
        $data->push($f0);
        $data->push($f);
        $data->push($f_danhgia);

        $data->push([
            'chitieus' => function ($model) {
                return collect($model)->only($this->dm_chitieu)
                    ->filter(function ($i) {
                        return !is_null($i);
                    })
                    ->map(function ($i, $name) {
                        return [
                            'chitieu_id' => $this->arr_search($this->dm_chitieu, $name),
                            'giatri'     => $i,
                        ];
                    })->values();
            },
            'geom'     => function ($model, $field) {
                if ($model->lng && $model->lat) {
                    return [$model->lng, $model->lat];
                }
            },
        ]);

        return $data->collapse()->all();
    }


}