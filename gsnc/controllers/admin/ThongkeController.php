<?php

namespace gsnc\controllers\admin;

use common\models\MyQuery;
use common\models\Query;
use gsnc\controllers\GsncController;
use gsnc\forms\ThongkeForm;
use gsnc\models\Benhvien;
use gsnc\models\DmChitieu;
use gsnc\models\DmPhuong;
use gsnc\models\DmQuan;
use gsnc\models\Maunc;
use gsnc\models\QlChitieu;
use gsnc\models\VtKhaosat;
use yii\db\Expression;

class ThongkeController extends GsncController
{
    public $tb;

    public function actionIndex()
    {
        $model = new ThongkeForm([
            'entity_type' => Maunc::className(),
            'loai_bc'     => 1,
        ]);

        if ($_POST && $model->load(request()->all())) {
            switch ($model->entity_type) {
                case Maunc::className():
                    $this->tb = 'sv_maunc';
                    break;
                case VtKhaosat::className():
                    $this->tb = 'sv_vt_khaosat';
                    break;
                case Benhvien::className():
                    $this->tb = 'sv_benhvien';
                    break;
                default:
                    break;
            }

            if ($model->loai_bc == 2) {
                return $this->_tkChitieu($model);
            } else {
                return $this->_tkChung($model);
            }

        }
        return $this->render('index', ['model' => $model]);
    }

    protected function _tkChitieu(ThongkeForm $model)
    {
        $model->scenario = ThongkeForm::SCENARIO_CHITIEU;
        if ($model->validate()) {
            if ($model->maquan) {
                if ($model->maphuong) {
                    $location = DmPhuong::findOne(['maphuong' => $model->maphuong]);
                    $location = data_get($location, 'tenphuong');
                } else {
                    $location = DmQuan::findOne(['maquan' => $model->maquan]);
                    $location = data_get($location, 'tenquan');
                }
            } else {
                $location = 'TP. HCM';
            }

            if ($model->entity_type == VtKhaosat::className()) {
                $q = (new Query())->select('gid')->from ('vt_khaosat')
                    ->andFilterWhere(['donvikhaosat' => $model->donvilaymau])
                    ->andFilterWhere(['maquan' => $model->maquan])
                    ->andFilterWhere(['maphuong' => $model->maphuong])
                    ->andFilterDate(['ngaykhaosat' => [$model->date_from, $model->date_to]])
//                    ->andFilterWhere(['qcvn_id' => $model->qcvn_id])
                ;
                $q_ct = (new Query())
                    ->select(['vt_khaosat_id', 'ct' => new Expression('m.json->>\'f1\''), 'check_cond_qcvn_ks(m.json) dat'])
                    ->andWhere(new Expression("m.json->>'f1' IN ('33', '34', '35', '14', '15')"))
                    ->andWhere(['in', 'vt_khaosat_id', $q])
                    ->from(['m' => 'v_meta_ykien'])
                ;
                $query = (new Query())->select('ct, count(*), sum(dat) dat')->from(['meta_ct' => $q_ct])->groupBy(['ct']);
                $resp = collect($query->all());
                $build_ct = function ($id, $name, $label) use($resp){
                    $ct = $resp->firstWhere('ct', $id);
                    if($ct) return ['tenchitieu' => $label, 'name' => $name, 'count' => $ct['count'], 'dat' => $ct['dat'], 'kdat' =>  $ct['count']-$ct['dat'], 'tyle' => $ct['dat'] == 0 ? 0 : number_format($ct['dat']/$ct['count'], 2)];
                    return ['tenchitieu' => $label, 'name' => $name, 'count' => 0, 'dat' => 0, 'kdat' => 0, 'tyle' => 0];
                };
                $data = collect([
                    $build_ct('34', 'ph', 'pH'),
                    $build_ct('35', 'do_duc', 'Độ đục (NTU)'),
                    $build_ct('33', 'clo_du', 'Clo dư (mg/l)'),
                    $build_ct('14', 'mau', 'Màu sắc'),
                    $build_ct('15', 'muivi', 'Mùi vị'),
                ]);
                return $this->renderPartial('_chitieu', ['location' => $location, 'data' => $data]);
            }

            $ct_ids = DmChitieu::find()->where([
                'qcvn_id' => $model->qcvn_id,
            ])->pluck('id')->all();

            $q0 = (new Query())->select(new Expression('chitieu_id, check_cond_chitieu(ct.*) dat'))->from(['ct' => 'ql_chitieu'])
                ->leftJoin(['tb' => $this->tb], 'tb.id = ct.entity_id')
                ->andFilterWhere(['ct.entity_type' => $model->entity_type])
                ->andFilterWhere(['chitieu_id' => $ct_ids])
                ->andFilterWhere(['tb.donvilaymau' => $model->donvilaymau])
                ->andFilterWhere(['tb.maquan' => $model->maquan])
                ->andFilterWhere(['tb.maphuong' => $model->maphuong])
                ->andFilterWhere(['tb.loaimau_id' => $model->loaimau_id])
                ->andFilterDate(['tb.ngaylaymau' => [$model->date_from, $model->date_to]])
                ->andFilterWhere(['tb.qcvn_id' => $model->qcvn_id]);

            $q = (new Query())
                ->select([
                    'chitieu_id',
                    'count' => 'COUNT(*)',
                    'dat'   => 'sum(dat)',
                    'kdat'  => 'COUNT(dat = 0 OR NULL)',
                ])
                ->from(['ct' => $q0])
                ->groupBy(['chitieu_id']);

            $q1 = (new Query())
                ->select([
                    'id',
                    'tenchitieu',
                    'count',
                    'dat',
                    'kdat',
                ])
                ->from(['dm' => 'dm_chitieu'])
                ->leftJoin(['ct' => $q], 'ct.chitieu_id = dm.id')
                ->orderBy('order, id')
                ->andFilterWhere(['qcvn_id' => $model->qcvn_id, 'status' => 1]);

            //$count = (clone $q0)->select('entity_id')->groupBy('entity_id')->count();


            $data = collect($q1->all());


            return $this->renderPartial('_chitieu', ['location' => $location, 'data' => $data]);
        }

        return $this->renderPartial('_message', ['model' => $model]);
    }


    protected function _tkChung($model)
    {
        $query = (new Query());
        $view = '_main';

        $tb_hc = 'dm_quan';
        $f_hc = 'maquan';
        $t_hc = 'tenquan';
        $maphuong = $model->maphuong;

        if ($maquan = $model->maquan) {
            $tb_hc = 'dm_phuong';
            $f_hc = 'maphuong';
            $t_hc = 'tenphuong';
        } elseif ($model->entity_type == Benhvien::className()) {
            $query->andFilterWhere([
                'loai_bv' => $model->loai_bv,
                'bv_id'   => $model->bv_id,
            ]);
        } elseif ($model->entity_type == Maunc::className()) {
            $query->andFilterWhere([
                'loaimau_id' => $model->loaimau_id,
            ]);
        }

        $query->andFilterWhere([
            'donvilaymau' => $model->donvilaymau,
            'maquan'      => $maquan,
            'maphuong'    => $maphuong,
            'qcvn_id'     => $model->qcvn_id,
        ]);

        $tdate = $model->entity_type == VtKhaosat::className() ? 'ngaykhaosat' : 'ngaylaymau';
        $query->andFilterDate([$tdate => [$model->date_from, $model->date_to]]);


        if ($model->entity_type !== VtKhaosat::className()) {
            $q0 = $query
                ->select([
                    'maquan'         => 'maquan',
                    'somau'          => 'COUNT(*)',
                    'vs_dat'         => 'SUM (vs)',
                    'vs_kdat'        => 'COUNT (*) - SUM (vs)',
                    'tyle_vs_dat'    => 'round(CAST((CAST(SUM (vs) as FLOAT)/COUNT (vs))*100 as NUMERIC), 2)',
                    'hl_dat'         => 'SUM (hl)',
                    'hl_kdat'        => 'COUNT (*) - SUM (hl)',
                    'tyle_hl_dat'    => 'round(CAST((CAST(SUM (hl) as FLOAT)/COUNT (hl))*100 as NUMERIC), 2)',
                    'hl_vs_dat'      => 'SUM (hl_vs)',
                    'hl_vs_kdat'     => 'COUNT (*) - SUM (hl_vs)',
                    'tyle_hl_vs_dat' => 'round(CAST((CAST(SUM (hl_vs) as FLOAT)/COUNT (hl_vs))*100 as NUMERIC), 2)'
                ])
                ->from(['tb' => $this->tb])
                ->groupBy(['maquan']);

            $query = (new Query())->select(['e.*', 'dm.tenquan', "dm.{$t_hc}"])->from(['e' => $q0])
                ->leftJoin(['dm' => $tb_hc], "dm.{$f_hc} = e.{$f_hc}")
                ->orderBy('dm.order');

            if ($maquan) {
                $q0->addSelect(['maphuong', 'tenphuong']);
                $q0->addGroupBy(['maphuong', 'tenphuong']);
                $q0->andFilterWhere(['maphuong' => $maphuong]);
                $query->andFilterWhere(['e.maphuong' => $maphuong]);
            }
            $data = collect($query->all());
        } else {
            $view = '_main_vtks';
            $data = $this->queryTkVtKhaosat($model, $query, $tb_hc, $f_hc, $t_hc);
        }

        return $this->renderPartial($view, ['model' => $model, 'data' => $data]);

    }

    protected function queryTkVtKhaosat($model, $query, $tb_hc, $f_hc, $t_hc)
    {
        $maquan = $model->maquan;

        $q = (new Query())
            ->select([$f_hc, 'count(*) count', 'sum(ct1) ct1', '(count(*) - sum(ct2)) ct2', 'sum(ct3) ct3', 'sum(ct4) ct4', 'sum(dat) dat'])
            ->groupBy([$f_hc])
            ->from(['ks' => $this->tb])
            ->andFilterWhere(['donvikhaosat' => $model->donvilaymau])
            ->andFilterWhere(['maquan' => $model->maquan])
            ->andFilterWhere(['maphuong' => $model->maphuong])
            ->andFilterDate(['ngaykhaosat' => [$model->date_from, $model->date_to]])
//            ->andFilterWhere(['qcvn_id' => $model->qcvn_id])
        ;

        $query = (new Query())->select(["dm.{$t_hc}", 'dm.tenquan', 'e.*',])->from(['dm' => $tb_hc])
            ->leftJoin(['e' => $q], "dm.{$f_hc} = e.{$f_hc}")
            ->orderBy('dm.order')
        ;
        if ($maquan) {
            $query->andWhere(['maquan' => $maquan]);
        }
        
        $data = collect($query->all())->map(function ($i) use ($f_hc, $t_hc) {
            return [
                $f_hc   => $i[$f_hc],
                $t_hc   => $i[$t_hc],
                'count' => $i['count'] ? $i['count'] : 0,
                'ct1'   => $i['ct1'] ? $i['ct1'] : 0,
                'ct2'   => $i['ct2'] ? $i['ct2'] : 0,
                'ct3'   => $i['ct3'] ? $i['ct3'] : 0,
                'ct4'   => $i['ct4'] ? $i['ct4'] : 0,
                'dat'   => $i['dat'] ? $i['dat'] : 0,
                'kdat'  => $i['count'] - $i['dat'],
                'tyle'  => $i['count'] == 0 ? 0 : number_format(($i['dat'] / $i['count'])*100, 2),
            ];
        });

        return $data;

//        dd($q->all());

//        $q0 = (new Query())
//            ->select([$f_hc, 'meta_ykien_id', 'count(*)'])->from(['yk' => 'vt_ks_ykien'])
//            ->leftJoin(['pt' => 'vt_khaosat'], 'pt.gid = yk.vt_khaosat_id')
//            ->groupBy([$f_hc, 'meta_ykien_id'])
//            ->andWhere(['meta_ykien_id' => [1, 9, 13, 28]])
//            ;
//
//
//        $q1 = (new Query())->select([$f_hc, 'yks' => new Expression('array_to_json(array_agg(row_to_json(meta_ct)))')])->from(['meta_ct' => $q0])->groupBy($f_hc);
//        $q2 = $query->select([
//            "ks.{$f_hc}",
//            new Expression('ct.yks::text'),
//            'soluong' => new Expression('COUNT(*)'),
//            'dat'     => new Expression('COALESCE(SUM(hl_vs), 0)'),
//        ])->from(['ks' => $this->tb])
//            ->leftJoin(['ct' => $q1], "ct.{$f_hc} = ks.{$f_hc}")
//            ->groupBy(["ks.{$f_hc}", new Expression('ct.yks::text')]);
//
//        $q3 = (new Query())->select(['e.*', "dm.{$t_hc}"])->from(['e' => $q2])
//            ->leftJoin(['dm' => $tb_hc], "dm.{$f_hc} = e.{$f_hc}")
//            ->orderBy('dm.order');
//
//        if ($maquan) {
//            $q0->andWhere(['maquan' => $maquan]);
//            $q2->andWhere(['maquan' => $maquan]);
//            $q3->andWhere(['maquan' => $maquan]);
//        }
//
//        $data = collect($query->all())->map(function ($i) use($f_hc, $t_hc) {
//            $yks = collect(json_decode($i['yks'] ? $i['yks'] : '{}', true));
//            $val = function ($i, $id) {
//                return data_get($i->firstWhere('meta_ykien_id', $id), 'count', 0);
//            };
//
//            return [
//                $f_hc        => $i[$f_hc],
//                $t_hc       => $i[$t_hc],
//                'soluong'       => $i['soluong'],
//                'nc_may'        => $val($yks, 1),
//                'nc_dangsd'     => $val($yks, 9),
//                'nc_bonchua'    => $val($yks, 13),
//                'nc_vs_bonchua' => $val($yks, 28),
//                'dat'           => $i['dat'],
//                'kdat'          => $i['soluong'] - $i['dat'],
//                'tyle'          => number_format(($i['dat'] / $i['soluong']), 2)*100,
//            ];
//        });
//
//        return $data;
    }
}

