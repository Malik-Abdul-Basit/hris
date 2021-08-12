<?php

class evaluation_results
{
    public $return = [
        "evaluation_results" => [
            "number_stack_is_default" => [
                "title" => [
                    0 => 'Not Default',
                    1 => 'Default',
                ],
                "value" => [
                    'not_default' => '0',
                    'default' => '1',
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