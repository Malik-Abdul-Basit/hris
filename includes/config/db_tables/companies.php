<?php

class companies
{
    public $return = [
        "companies" => [
            "status" => [
                "title" => [
                    0 => 'Close',
                    1 => 'Working',
                ],
                "value" => [
                    'working' => '1',
                    'close' => '0'
                ],
                "class" => [
                    0 => 'label-light-danger',
                    1 => 'label-light-success',
                    2 => 'label-light-primary',
                    3 => 'label-light-info',
                    4 => 'label-light-warning',
                    5 => 'label-light-defalult'
                ],
            ],
        ],
    ];

    /**
     * @return array
     */
    public function getArray()
    {
        return $this->return;
    }

}


?>