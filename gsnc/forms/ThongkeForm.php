<?php
namespace gsnc\forms;
use common\forms\Form;

class ThongkeForm extends Form
{
    const SCENARIO_GENERAL = 'general';
    const SCENARIO_CHITIEU = 'chitieu';

    public $entity_type;
    public $date_from;
    public $date_to;
    public $donvilaymau;
    public $maquan;
    public $maphuong;
    public $qcvn_id;
    public $loaimau_id;
    public $loai_bc;
    public $loai_bv;
    public $bv_id;

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CHITIEU] = ['qcvn_id'];
        return $scenarios;
    }

    public function rules()
    {
        return [
             [['maphuong', 'maquan', 'entity_type', 'donvilaymau'], 'string'],
             [['qcvn_id', 'loaimau_id', 'loai_bc', 'bv_id', 'loai_bv'], 'integer'],
             [['date_to', 'date_from'], 'date'],
            [['qcvn_id'], 'required', 'on' => [self::SCENARIO_CHITIEU]],
        ];
    }

    public function attributeLabels()
    {
        return [
            'entity_type'     => 'Loại dữ liệu',
            'maquan'     => 'Quận',
            'maphuong'   => 'Phường',
            'qcvn_id'    => 'QCVN',
            'loaimau_id' => 'Loại mẫu',
            'loai_bc'    => 'Loại báo cáo',
            'loai_bv'    => 'Loại bệnh viện',
            'bv_id'    => 'Bệnh viện',
        ];
    }
}