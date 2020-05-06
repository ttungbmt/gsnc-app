<?php
/**
 * Created by PhpStorm.
 * User: NGOCLOI
 * Date: 2018-04-02
 * Time: 9:49 SA
 */

namespace gsnc\forms;

use yii\base\DynamicModel;

class VtOnhiemImportForm extends DynamicModel
{

    private $_attributes = [];
    protected $_dynamicFormAttrs = [];

    public function __construct(array $attributes = [], $config = [])
    {
        foreach ($attributes as $name => $value) {
            $this->_attributes[$name] = $value;
        }
        parent::__construct($config);
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->_attributes)) {
            return $this->_attributes[$name];
        }

        return parent::__get($name);
    }

    public function attributes()
    {
        return $this->_attributes;
    }

    public function formAttrs()
    {
        foreach($this->_attributes as $k => $value) {
//            if($this->_attributes["lat"]){
//                $this->_dynamicFormAttrs +=  [ $k=>['width'=>'1200px']];
//
//            } else {
//                $this->_dynamicFormAttrs +=  [$k => ['label' => $k]];
//            }
            $this->_dynamicFormAttrs +=  [$k => ['label' => $k]];


        }

        return $this->_dynamicFormAttrs;
    }
}