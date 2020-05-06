<?php
namespace gsnc\models;

use common\models\MyModel;

class Gsnc extends MyModel
{
    public function roleHc($attribute, $params, $validator)
    {
        if (role('quan') && userInfo()->ma_quan != $this->$attribute) {
            $this->addError($attribute, 'Chọn quận đúng với quyền được cấp');
        }
    }
}