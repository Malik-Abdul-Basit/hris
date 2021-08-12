<?php

class employee_qualification_infos
{
    public $return = [
        "employee_qualification_infos" => [
            "grade" => [
                "title" => [
                    'a+' => 'A+',
                    'a' => 'A',
                    'b' => 'B',
                    'c' => 'C',
                    'd' => 'D',
                    //'e' => 'E',
                ],
                "value" => [
                    'a+' => 'a+',
                    'a' => 'a',
                    'b' => 'b',
                    'c' => 'c',
                    'd' => 'd',
                    //'e' => 'e',
                ],
            ],
            "status" => [
                "title" => [
                    'c' => 'Completed',
                    'b' => 'Continue',
                ],
                "value" => [
                    'completed' => 'c',
                    'continue' => 'b',
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