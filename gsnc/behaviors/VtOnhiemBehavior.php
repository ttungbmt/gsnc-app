<?php

namespace gsnc\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use Yii;
use yii\helpers\Url;
use yii\base\ModelEvent;

class VtOnhiemBehavior extends Behavior
{

    protected $url = "";

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeInsert',
            ActiveRecord::EVENT_AFTER_INSERT => 'afterInsert',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeUpdate',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterUpdate',
            ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete',
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
        ];
    }

    public function beforeInsert($event){}

    public function afterInsert($event)
    {
       $id = $event->sender->id;
       $this->setUrl($id);

       activity('vt_onhiem')
           ->causedBy(user()->identity)
           ->performedOn($event->sender)
           ->withProperty("url", $this->url)
           ->log('Thêm mới vị trí ô nhiễm #'.$id);

       Yii::$app->session->setFlash('success', 'Đã thêm mới vị trí ô nhiễm #'.$id);
    }

    public function beforeUpdate($event){}

    public function afterUpdate($event){
        $id = $event->sender->id;
        $this->setUrl($id);

        if($event->sender->status == 1) {

            activity('vt_onhiem')
                ->causedBy(user()->identity)
                ->performedOn($event->sender)
                ->withProperty("url", $this->url)
                ->log('Cập nhật vị trí ô nhiễm #'.$id);
            Yii::$app->session->setFlash('success', 'Đã cập nhật vị trí ô nhiễm #'.$id);
        } else if($event->sender->status == 0) {
            activity('vị trí ô nhiễm')
                ->causedBy(user()->identity)
                ->performedOn($event->sender)
                ->log('Xóa vị trí ô nhiễm #'.$id);

            Yii::$app->session->setFlash('success', 'Đã xóa vị trí ô nhiễm #'.$id);
        }
    }

    public function beforeDelete($event){}

    public function afterDelete($event){
        $id = $event->sender->id;
        $this->setUrl($id);

        activity('vt_onhiem')
            ->causedBy(user()->identity)
            ->performedOn($event->sender)
            ->log('Xóa vị trí ô nhiễm #'.$id);

        Yii::$app->session->setFlash('success', 'Đã xóa vị trí ô nhiễm #'.$id);
    }

    public function setUrl($id)
    {
        $this->url = "/admin/vt-onhiem/view?id=".$id;
    }
}