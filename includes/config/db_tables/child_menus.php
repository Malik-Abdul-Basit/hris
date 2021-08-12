<?php

class child_menus
{
    public $return = [
        "child_menus" => [
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
            "menu_link" => [
                "title" => [
                    0 => 'Not Display',
                    1 => 'Display',
                ],
                "value" => [
                    'not_display' => '0',
                    'display' => '1',
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