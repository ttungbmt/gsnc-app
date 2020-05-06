<?php
/**
 * Created by PhpStorm.
 * User: THANHTUNG
 * Date: 23-Dec-17
 * Time: 8:22 AM
 */

namespace gsnc\controllers;

class MapController extends GsncController
{
    public $layout = '@common/themes/admin/layouts/map';

    public function actionIndex(){
        return $this->render('index');
    }
}