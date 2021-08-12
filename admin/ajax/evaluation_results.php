<?php
include_once('../../includes/connection.php');

if (isset($_POST['postData'])) {

    $object = (object)$_POST['postData'];
    $signed_url = $object->signature;
    $employeeid = $object->emp;
    $p = $object->p;
    $evaluation_id = $object->evaluation_id;
    $evaluation_detail_id = $object->evaluation_detail_id;
    $evaluation_number_stack_id = $object->evaluation_number_stack_id;
    $number_stack_is_default = $object->number_stack_is_default;
    $id = $message = '';

    if (empty($evaluation_id) || !is_numeric($evaluation_id) || empty($evaluation_detail_id) || !is_numeric($evaluation_detail_id)) {
        echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'Unexpected error.']);
    } else if ($evaluation_number_stack_id == '' || !is_numeric($evaluation_number_stack_id) || $number_stack_is_default == '' || !is_numeric($number_stack_is_default)) {
        echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'Unexpected error.']);
    } else {
        foreach ($object->data as $row => $data) {

            /*$row_id = $data['row_id'];
            $evaluation_task_id = $data['evaluation_task_id'];
            $evaluation_task_detail_id = $data['evaluation_task_detail_id'];
            $task_description = $data['task_description'];
            $measure_number = $data['measure_number'];
            $obtaining_number = $data['obtaining_number'];*/

            if (empty($data['evaluation_task_id']) || !is_numeric($data['evaluation_task_id']) || $data['evaluation_task_id'] <= 0 || !is_numeric($data['evaluation_task_detail_id'])) {
                $message = 'Unexpected error.';
                $id = 'task_description_' . $data['row_id'];
                $continueProcessing = false;
                break;
            } else if ($data['task_description'] == '') {
                $message = 'Task Description field is required.';
                $id = 'task_description_' . $data['row_id'];
                $continueProcessing = false;
                break;
            } else if (!validAddress($data['task_description'])) {
                $message = 'Special Characters are not Allowed in Task Description field.';
                $id = 'task_description_' . $data['row_id'];
                $continueProcessing = false;
                break;
            } else if ($data['measure_number'] <= 0 || $data['measure_number'] == '') {
                $message = 'Measure Number field is required.';
                $id = 'measure_number_' . $data['row_id'];
                $continueProcessing = false;
                break;
            } else if (!is_numeric($data['measure_number']) || strlen($data['measure_number']) > 6) {
                $message = 'Please select a valid option.';
                $id = 'measure_number_' . $data['row_id'];
                $continueProcessing = false;
                break;
            } else if ($data['obtaining_number'] < 0 || $data['obtaining_number'] == '') {
                $message = 'Achieved Number field is required.';
                $id = 'obtaining_number_' . $data['row_id'];
                $continueProcessing = false;
                break;
            } else if (!is_numeric($data['obtaining_number']) || strlen($data['obtaining_number']) > 6) {
                $message = 'Please select a valid option.';
                $id = 'obtaining_number_' . $data['row_id'];
                $continueProcessing = false;
                break;
            } else if ($data['obtaining_number'] > $data['measure_number']) {
                $message = 'Please select a valid option.';
                $id = 'obtaining_number_' . $data['row_id'];
                $continueProcessing = false;
                break;
            } else {
                $continueProcessing = true;
            }
        }

        if ($continueProcessing === false) {
            echo json_encode(['code' => 422, "toasterClass" => 'error', 'errorMessage' => $message, 'errorField' => $id]);
        } else {
            /*echo '<pre>';
            print_r($object);
            echo '</pre>';
            exit();*/

            $user_id = $_SESSION['user_id'];
            $company_id = $_SESSION['company_id'];
            $branch_id = $_SESSION['branch_id'];
            $complete = config("evaluation_details.status.value.complete");

            $notification_status = config('notifications.status.value.pending');
            $notification_type = config('notifications.type.value.evaluation_result_add');

            $check = mysqli_query($db, "SELECT `added_by` FROM `evaluation_results` WHERE `evaluation_id`='{$evaluation_id}' AND `evaluation_detail_id`='{$evaluation_detail_id}' ORDER BY `id` ASC LIMIT 1");
            if ($check && mysqli_num_rows($check) > 0) {
                $fetch = mysqli_fetch_object($check);
                $added_by = $fetch->added_by;
                mysqli_query($db, "DELETE FROM `evaluation_results` WHERE `evaluation_id`='{$evaluation_id}' AND `evaluation_detail_id`='{$evaluation_detail_id}'");

                deleteNotification($notification_type, $evaluation_detail_id, $company_id, $branch_id);

                foreach ($object->data as $row => $data) {
                    $evaluation_task_detail_id = $data['evaluation_task_detail_id'];
                    $task_description = $db->real_escape_string(html_entity_decode(stripslashes(strip_tags($data["task_description"]))));
                    if (empty($data['evaluation_task_detail_id'])) {
                        $check1 = mysqli_query($db, "SELECT `id` FROM `evaluation_task_details` WHERE `evaluation_task_id`='{$data['evaluation_task_id']}' AND `task_description`='{$task_description}' ORDER BY `id` ASC LIMIT 1");
                        if ($check1 && mysqli_num_rows($check1) > 0) {
                            //$fetch1 = mysqli_fetch_object($check1);
                            //$evaluation_task_detail_id = $fetch1->id;
                            $evaluation_task_detail_id = 0;
                        } else {
                            mysqli_query($db, "INSERT INTO `evaluation_task_details`(`id`, `task_description`, `evaluation_task_id`, `added_by`) VALUES (NULL,'{$task_description}','{$data['evaluation_task_id']}', '{$user_id}')");
                            $evaluation_task_detail_id = mysqli_insert_id($db);
                        }
                    }
                    if (!empty($evaluation_task_detail_id)) {
                        $query = "INSERT INTO `evaluation_results`(`id`, `evaluation_id`, `evaluation_detail_id`, `evaluation_task_detail_id`, `evaluation_number_stack_id`, `number_stack_is_default`, `total_number`, `obtaining_number`, `added_by`, `updated_by`) VALUES (NULL, '{$evaluation_id}', '{$evaluation_detail_id}', '{$evaluation_task_detail_id}', '{$evaluation_number_stack_id}', '{$number_stack_is_default}', '{$data['measure_number']}', '{$data['obtaining_number']}', '{$added_by}', '{$user_id}')";
                        mysqli_query($db, $query);
                    }
                }
            } else {
                foreach ($object->data as $row => $data) {
                    $evaluation_task_detail_id = $data['evaluation_task_detail_id'];
                    $task_description = $db->real_escape_string(html_entity_decode(stripslashes(strip_tags($data["task_description"]))));
                    if (empty($data['evaluation_task_detail_id'])) {
                        $check1 = mysqli_query($db, "SELECT `id` FROM `evaluation_task_details` WHERE `evaluation_task_id`='{$data['evaluation_task_id']}' AND `task_description`='{$task_description}' ORDER BY `id` ASC LIMIT 1");
                        if ($check1 && mysqli_num_rows($check1) > 0) {
                            //$fetch1 = mysqli_fetch_object($check1);
                            //$evaluation_task_detail_id = $fetch1->id;
                            $evaluation_task_detail_id = 0;
                        } else {
                            mysqli_query($db, "INSERT INTO `evaluation_task_details`(`id`, `task_description`, `evaluation_task_id`, `added_by`) VALUES (NULL,'{$task_description}','{$data['evaluation_task_id']}', '{$user_id}')");
                            $evaluation_task_detail_id = mysqli_insert_id($db);
                        }
                    }
                    if (!empty($evaluation_task_detail_id)) {
                        $query = "INSERT INTO `evaluation_results`(`id`, `evaluation_id`, `evaluation_detail_id`, `evaluation_task_detail_id`, `evaluation_number_stack_id`, `number_stack_is_default`, `total_number`, `obtaining_number`, `added_by`) VALUES (NULL, '{$evaluation_id}', '{$evaluation_detail_id}', '{$evaluation_task_detail_id}', '{$evaluation_number_stack_id}', '{$number_stack_is_default}', '{$data['measure_number']}', '{$data['obtaining_number']}', '{$user_id}')";
                        if (mysqli_query($db, $query)) {
                            mysqli_query($db, "UPDATE `evaluation_details` SET `status`='{$complete}', `updated_by`='{$user_id}' WHERE `id`='{$evaluation_detail_id}'");
                        }
                    }
                }
            }

            $parent_id = getReportEmpId($user_id);
            $appraiseInfo = getEmployeeInfoFromId($employeeid);
            $notification_body= getNotificationBody($notification_type, ['{employeeName}' => $appraiseInfo->full_name]);

            $link = $admin_url.'view_evaluation?signature=' . $signed_url . '&ev=' . $evaluation_id . '&evd=' . $evaluation_detail_id . '&emp=' . $employeeid . '&p=' . $p;
            insertNotification($notification_type, $user_id, $parent_id, $evaluation_detail_id, $notification_body['message'], $link, $notification_status, $company_id, $branch_id, $user_id);

            if( $admins = getAdmin($company_id, $branch_id) ){
                while ($admin_obj = mysqli_fetch_object($admins)){
                    $mailToName = $admin_obj->full_name;
                    $mailTo = $admin_obj->email;
                    $mail_body = getMailBody($notification_type, ['{mailToName}' => $mailToName, '{mailTo}' => $mailTo, '{ResourceName}' => $appraiseInfo->full_name, '{link}' => $link]);
                    $parameters = [
                        'subject' => $notification_type,
                        'data' => [
                            'email_body' => $mail_body['html'],
                            'message' => $mail_body['message'],
                        ],
                        'mailTo' => [
                            'email' => $mailTo,
                            'name' => $mailToName,
                        ],
                    ];
                    sendEmail($parameters);
                }
            }
            echo json_encode(["code" => 200, "toasterClass" => 'success', "responseMessage" => 'Record successfully saved.', 'form_reset' => 'false']);
        }

    }

}
?>