<?php
namespace gsnc\controllers\admin;

use gsnc\controllers\GsncController;
use yii\db\Query;


class SiteController extends GsncController
{
    public function actionIndex(){

        //Số lượng user
        $users = (new Query())
            ->select('COUNT(*)')
            ->from('user')
            ->column();

        //Số lượng điểm ô nhiễm
        $vtonhiems = (new Query())
            ->select('COUNT(*)')
            ->from('vt_onhiem')
            ->column();

        //Số lượng vị trí khảo sát
        $vtkhaosats = (new Query())
            ->select('COUNT(*)')
            ->from('vt_khaosat')
            ->column();

        //Số lượng mẫu nước
        $maunuocs = (new Query())
            ->select('COUNT(*)')
            ->from('maunc')
            ->column();

        $activity = (new Query())
            ->select('causer_id, MAX(created_at) AS time_login')
            ->from('activity_log')
            ->where(['description' => 'Đăng nhập hệ thống'])
            ->groupBy(['activity_log.causer_id']);

        $activity_log = (new Query())
            ->select('activity.*, fullname')
            ->from(['activity' => $activity])
            ->leftJoin('user_info', 'user_info.user_id  = activity.causer_id')
            ->orderBy('activity.time_login DESC')
            ->limit('10')
            ->all();

        for($i = 0; $i < count($activity_log); $i++) {
            $recent_time_login = $this->calcRecentTimeLogin($activity_log[$i]['time_login']);
            $activity_log[$i] += ["recent_time" => $recent_time_login];

            if(!$activity_log[$i]['fullname']) {
                $activity_log[$i]['fullname'] = 'Unknown';
            }
        }

        /*
         * Chart
         */
        $q_maunc = (new Query)
            ->select('COUNT(*) as count, hl_vs')
            ->from('maunc')
            ->groupBy('hl_vs')
            ->all();

        $q_benhvien = (new Query)
            ->select('COUNT(*) as count, hl_vs')
            ->from('poi_benhvien')
            ->groupBy('hl_vs')
            ->all();

        $dataProvider = [];

        $data_mnc = [
            'loai_nuoc' => 'Mẫu nước',
            'dat'       => 0,
            'khongdat'  => 0,
        ];
        foreach($q_maunc as $value) {
            if($value['hl_vs'] == 1) {
                $data_mnc['dat'] += $value['count'];
            } else {
                $data_mnc['khongdat'] += $value['count'];
            }
        }

        array_push($dataProvider, $data_mnc);

        $data_bv = [
            'loai_nuoc' => 'Nước thải Bệnh viện',
            'dat'       => 0,
            'khongdat'  => 0,
        ];
        foreach($q_benhvien as $value) {
            if($value['hl_vs'] == 1) {
                $data_bv['dat'] += $value['count'];
            } else {
               $data_bv['khongdat'] += $value['count'];
            }
        }

        array_push($dataProvider, $data_bv);

        return $this->render('index', [
            'activity_log' => $activity_log,
            'users' => $users,
            'vtonhiems' => $vtonhiems,
            'vtkhaosats' => $vtkhaosats,
            'maunuocs' => $maunuocs,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionChangelog(){
        return $this->render('changelog');
    }

    public function actionContact() {
        return $this->render('contact');
    }

    public function calcRecentTimeLogin($time_login){
        $curr_time = date('Y-m-d H:i:s');
        $time = strtotime($curr_time) - strtotime($time_login);
        $seconds = $time;
        $minutes = round($time / 60 );
        $hours = round($time / 3600);
        $days = round($time / 86400 );
        $weeks = round($time / 604800);
        $months = round($time / 2600640 );
        $years = round($time / 31207680 );
        // Seconds
        if($seconds <= 60)
        {
            return  $seconds." giây trước";
        }
        //Minutes
        else if($minutes <=60)
        {
            return  $minutes." phút trước";
        }
        //Hours
        else if($hours <=24)
        {
            return  $hours." giờ trước";
        }
        //Days
        else if($days <= 7)
        {
            return  $days." ngày trước";
        }
        //Weeks
        else if($weeks <= 4.3)
        {
            return  $weeks." tuần trước";
        }
        //Months
        else if($months <=12)
        {
            return  $months." tháng trước";
        }
        //Years
        else if($years >= 1)
        {
            return  $years." năm trước";
        }
        return "Vừa xong";
    }

    public function actionDocGuide()
    {
        $url = '/gsnc/storage/docs/HDSD.pdf';
        return $this->render('doc_guide', compact('url'));
    }
    public function actionVideoGuide()
    {
        $media = [
            ['title' => 'Nhập excel mẫu nước', 'content' => 'Hướng dẫn nhập dữ liệu excel mẫu nước vào CSDL.', 'url' => asset('/storage/video/importMaunuoc.mp4')],
            ['title' => 'Nhập excel vị trí khảo sát', 'content' => 'Hướng dẫn nhập dữ liệu excel vị trí khảo sát vào CSDL.', 'url' => asset('/storage/video/importVtKhaosat.mp4')],
            ['title' => 'Lấy dữ liệu từ máy GPS', 'content' => 'Hướng dẫn lấy dữ liệu từ máy GPS.', 'url' => asset('/storage/video/Lay du lieu tu may GPS.mp4')],
            ['title' => 'Định vị bằng máy GPS', 'content' => 'Hướng dẫn Định vị bằng máy GPS.', 'url' => asset('/storage/video/Dinh vi bang may GPS.mp4')],
        ];

        return $this->render('video_guide', compact('media'));
    }
}