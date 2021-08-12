<?php

class designations
{
    public $return = [
        "designations" => [
            "is_hod" => [
                "title" => [
                    0 => 'Not HOD',
                    1 => 'HOD',
                ],
                "value" => [
                    'not_hod' => '0',
                    'hod' => '1',
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