<?php

class notifications
{
    public $return = [
        "notifications" => [
            "status" => [
                "title" => [
                    'p' => 'Pending',
                    'u' => 'Unread',
                    'r' => 'Read',
                ],
                "value" => [
                    'pending' => 'p',
                    'unread' => 'u',
                    'read' => 'r',
                ],
            ],
            "type" => [
                "title" => [
                    'password_reset' => 'Password Reset',
                    'evaluation_start' => 'Evaluation Start',
                    'evaluation_result_add' => 'Evaluation Result Add',
                    'evaluation_complete' => 'Evaluation Complete',
                ],
                "value" => [
                    'password_reset' => 'password_reset',
                    'evaluation_start' => 'evaluation_start',
                    'evaluation_result_add' => 'evaluation_result_add',
                    'evaluation_complete' => 'evaluation_complete',
                ],
                "model" => [
                    'password_reset' => 'users',
                    'evaluation_start' => 'evaluations',
                    'evaluation_result_add' => 'evaluation_details',
                    'evaluation_complete' => 'evaluation_details',
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