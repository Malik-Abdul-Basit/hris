<?php

class main_menus
{
    public $return = [
        "main_menus" => [
            "status" => [
                "title" => [
                    0 => 'Inactive',
                    1 => 'Active',
                ],
                "value" => [
                    'inactive' => '0',
                    'active' => '1',
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