<?php
namespace gsnc\forms;

use gsnc\models\VtKhaosat;

class VtKhaosatTkForm extends VtKhaosat
{
    public function rules()
    {
        return [
            [['date_from', 'date_to'], 'date', 'format' => 'DD/MM/YYYY'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'date_from' => 'Từ ngày khảo sát',
            'date_to' => 'Đến ngày',
        ];
    }
}