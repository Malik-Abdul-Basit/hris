<?php

class evaluation_details
{
    public $return = [
        "evaluation_details" => [
            "status" => [
                "title" => [
                    'p' => 'Pending',
                    'c' => 'Complete',
                    'cl' => 'Close'
                ],
                "value" => [
                    'pending' => 'p',
                    'complete' => 'c',
                    'close' => 'cl',
                ],
                "class" => [
                    'c' => 'label-success',
                    'cl' => 'label-danger',
                    'p' => 'label-warning',
                    'd' => 'label-primary',
                ]
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