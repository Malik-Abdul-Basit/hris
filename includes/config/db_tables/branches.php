<?php

class branches
{
    public $return = [
        "branches" => [
            "status" => [
                "title" => [
                    0 => 'Close',
                    1 => 'Working',
                ],
                "value" => [
                    'close' => '0',
                    'working' => '1',
                ],
                "label" => [
                    0 => '<span class="label label-sm font-weight-bold label-light-danger label-inline">Close</span>',
                    1 => '<span class="label label-sm font-weight-bold label-light-success label-inline">Working</span>',
                ],
            ],
            "type" => [
                "title" => [
                    'o' => 'Operations Office',
                    'h' => 'Head Office',
                ],
                "value" => [
                    'operations_office' => 'o',
                    'head_office' => 'h',
                ],
                "label" => [
                    'o' => '<span class="label label-sm font-weight-bold label-light-primary label-inline">Operations Office</span>',
                    'h' => '<span class="label label-sm font-weight-bold label-light-default label-inline">Head Office</span>',
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