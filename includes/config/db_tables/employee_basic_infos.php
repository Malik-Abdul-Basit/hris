<?php

class employee_basic_infos
{
    public $return = [
        "employee_basic_infos" => [
            "title" => [
                "title" => [
                    'sir'=>'Sir.',
                    'dr'=>'Dr.',
                    'prof'=>'Prof.',
                    'mr'=>'Mr.',
                    'mrs'=>'Mrs.',
                    'miss'=>'Miss.',
                ],
                "value" => [
                    'sir'=>'sir',
                    'dr'=>'dr',
                    'prof'=>'prof',
                    'mr'=>'mr',
                    'mrs'=>'mrs',
                    'miss'=>'miss',
                ],
            ],
            "gender" => [
                "title" => [
                    'm'=>'Male',
                    'f'=>'Female',
                    'o'=>'Other',
                ],
                "value" => [
                    'male'=>'m',
                    'female'=>'f',
                    'other'=>'o',
                ],
            ],
            "blood_group" => [
                "title" => [
                    'a+'=>'A+Ve',
                    'a-'=>'A-Ve',
                    'b+'=>'B+Ve',
                    'b-'=>'B-Ve',
                    'ab+'=>'AB+Ve',
                    'ab-'=>'AB-Ve',
                    'o+'=>'O+Ve',
                    'o-'=>'O-Ve',
                ],
                "value" => [
                    'a_p'=>'a+',
                    'a_n'=>'a-',
                    'b_p'=>'b+',
                    'b_n'=>'b-',
                    'ab_p'=>'ab+',
                    'ab_n'=>'ab-',
                    'o_p'=>'o+',
                    'o_n'=>'o-',
                ],
            ],
            "marital_status" => [
                "title" => [
                    's'=>'Single',
                    'm'=>'Married',
                    'e'=>'Engaged',
                    'se'=>'Separated',
                    'd'=>'Divorced',
                    'w'=>'Widowed',
                ],
                "value" => [
                    'single'=>'s',
                    'married'=>'m',
                    'engaged'=>'e',
                    'separated'=>'se',
                    'divorced'=>'d',
                    'widowed'=>'w',
                ],
            ],
            "relation" => [
                "title" => [
                    'f' => 'Father',
                    'm' => 'Mother',
                    'b' => 'Brother',
                    's' => 'Sister',
                    'sp' => 'Spouse',
                    /*'h' => 'Husband',
                    'u' => 'Uncle',
                    'o' => 'Other',*/
                ],
                "value" => [
                    'father' => 'f',
                    'mother' => 'm',
                    'brother' => 'b',
                    'sister' => 's',
                    'spouse' => 'sp',
                    /*'husband' => 'h',
                    'uncle' => 'u',
                    'other' => 'o',*/
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