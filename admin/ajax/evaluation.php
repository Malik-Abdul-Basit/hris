<?php
include_once('../../includes/connection.php');

if (isset($_POST['postData'])) {

    $object = (object)$_POST['postData'];
    $id = $object->id;
    $name = $object->name;
    $date = $object->date;
    $evaluation_type_id = $object->evaluation_type_id;
    $department_id = $object->department_id;
    $designation_id = $object->designation_id;
    $user_right_title = $object->user_right_title;

    if ((empty($id) || $id == 0) && (!hasRight($user_right_title, 'add'))) {
        echo json_encode(["code" => 405, "toasterClass" => 'warning', "responseMessage" => 'Sorry! You have no right to add record.']);
    } else if (!empty($id) && is_numeric($id) && $id > 0 && !hasRight($user_right_title, 'edit')) {
        echo json_encode(["code" => 405, "toasterClass" => 'warning', "responseMessage" => 'Sorry! You have no right to update record.']);
    } else if (empty($name)) {
        echo json_encode(['code' => 422, "toasterClass" => 'warning', 'errorField' => 'name', 'errorDiv' => 'errorMessageName', 'errorMessage' => 'Name field is required.']);
    } else if (!validAddress($name)) {
        echo json_encode(['code' => 422, "toasterClass" => 'warning', 'errorField' => 'name', 'errorDiv' => 'errorMessageName', 'errorMessage' => 'Special Characters are not allowed in Name field.']);
    } else if (strlen($name) > 50) {
        echo json_encode(['code' => 422, "toasterClass" => 'warning', 'errorField' => 'name', 'errorDiv' => 'errorMessageName', 'errorMessage' => 'Length should not exceed 50 characters.']);
    } else if (empty($date)) {
        echo json_encode(['code' => 422, "toasterClass" => 'warning', 'errorField' => 'date', 'errorDiv' => 'errorMessageDate', 'errorMessage' => 'Date field is required.']);
    } else if (!validDate($date) || strlen($date) !== 10) {
        echo json_encode(['code' => 422, "toasterClass" => 'warning', 'errorField' => 'date', 'errorDiv' => 'errorMessageDate', 'errorMessage' => 'Length should not exceed 50 characters.']);
    } else if (empty($evaluation_type_id)) {
        echo json_encode(['code' => 422, "toasterClass" => 'warning', 'errorField' => 'evaluation_type_id', 'errorDiv' => 'errorMessageEvaluationType', 'errorMessage' => 'Evaluation Type field is required.']);
    } else if (!is_numeric($evaluation_type_id) || strlen($evaluation_type_id) > 10) {
        echo json_encode(['code' => 422, "toasterClass" => 'warning', 'errorField' => 'evaluation_type_id', 'errorDiv' => 'errorMessageEvaluationType', 'errorMessage' => 'Please select a valid option.']);
    } else if (empty($department_id)) {
        echo json_encode(['code' => 422, "toasterClass" => 'warning', 'errorField' => 'department_id', 'errorDiv' => 'errorMessageDepartment', 'errorMessage' => 'Department field is required.']);
    } else if (!is_numeric($department_id) || strlen($department_id) > 10) {
        echo json_encode(['code' => 422, "toasterClass" => 'warning', 'errorField' => 'department_id', 'errorDiv' => 'errorMessageDepartment', 'errorMessage' => 'Please select a valid option.']);
    } else if (empty($designation_id)) {
        echo json_encode(['code' => 422, "toasterClass" => 'warning', 'errorField' => 'designation_id', 'errorDiv' => 'errorMessageDesignation', 'errorMessage' => 'Designation field is required.']);
    } else if (!is_numeric($designation_id) || strlen($designation_id) > 10 || $designation_id <= 0) {
        echo json_encode(['code' => 422, "toasterClass" => 'warning', 'errorField' => 'designation_id', 'errorDiv' => 'errorMessageDesignation', 'errorMessage' => 'Please select a valid option.']);
    } else if (empty($object->employee_ids) || !is_array($object->employee_ids) || sizeof($object->employee_ids) < 1) {
        echo json_encode(['code' => 405, "toasterClass" => 'error', 'responseMessage' => 'Please select at least one Employee.']);
    } else if (empty($object->data) || !is_array($object->data) || sizeof($object->data) < 1) {
        echo json_encode(['code' => 405, "toasterClass" => 'error', 'responseMessage' => 'Please checked at least one Target section.']);
    } else {
        $company_id = $_SESSION['company_id'];
        $branch_id = $_SESSION['branch_id'];
        $user_id = $_SESSION['user_id'];
        $continueProcessing = true;
        $date = date('Y-m-d', strtotime($date));

        /*echo '<pre>';
        print_r($object->employee_ids);
        echo '</pre>';
        exit();*/

        /*echo '<pre>';
        print_r($object->data);
        echo '</pre>';*/

        $select = "SELECT `id` FROM `departments` WHERE `id`='{$department_id}' AND `company_id`='{$company_id}' AND `branch_id`='{$branch_id}' AND `deleted_at` IS NULL ORDER BY `sort_by` ASC LIMIT 1";
        $query = mysqli_query($db, $select);
        if (mysqli_num_rows($query) > 0) {
            $section_row = $total_task_weight = 0;
            $employee = $parent = true;

            $select_des = "SELECT `id` FROM `designations` WHERE `id`='{$designation_id}' AND `department_id`='{$department_id}' AND `company_id`='{$company_id}' AND `branch_id`='{$branch_id}' AND `deleted_at` IS NULL ORDER BY `sort_by` ASC LIMIT 1";
            $query_des = mysqli_query($db, $select_des);
            if (mysqli_num_rows($query_des) > 0) {

                foreach ($object->employee_ids as $employee_info) {
                    $employee_id = $employee_info['employee_id'];
                    $team_id = $employee_info['team_id'];
                    if (!is_numeric($employee_id) || $employee_id <= 0 || strlen($employee_id) > 10 || !is_numeric($team_id) || strlen($team_id) > 10) {
                        $employee = false;
                        break;
                    } else if (empty(getReportEmpId($employee_id))) {
                        $parent = false;
                        $employeeInfoFromId = getEmployeeInfoFromId($employee_id);
                        break;
                    }
                }

                if ($employee === true && $parent === true) {
                    foreach ($object->data as $data) {
                        $section_row++;
                        $task_heading = $data["task_heading"];
                        $task_weight = $data["task_weight"];

                        if (empty($task_heading)) {
                            $continueProcessing = false;
                            echo json_encode(['code' => 422, 'errorField' => 'task_heading_' . $section_row, "toasterClass" => 'error', 'errorMessage' => 'Task Heading ( ' . $section_row . ' ) field is required.']);
                            break;
                        } else if (!validAddress($task_heading)) {
                            $continueProcessing = false;
                            echo json_encode(['code' => 422, 'errorField' => 'task_heading_' . $section_row, "toasterClass" => 'error', 'errorMessage' => 'Special Characters are not Allowed in Task Heading ( ' . $section_row . ' ) field.']);
                            break;
                        } else if (empty($task_weight)) {
                            $continueProcessing = false;
                            echo json_encode(['code' => 422, 'errorField' => 'task_weight_' . $section_row, "toasterClass" => 'error', 'errorMessage' => 'The Task Weight field is required.']);
                            break;
                        } else if (!is_numeric($task_weight)) {
                            $continueProcessing = false;
                            echo json_encode(['code' => 422, 'errorField' => 'task_weight_' . $section_row, "toasterClass" => 'error', 'errorMessage' => 'The Task Weight field should contain only numeric characters.']);
                            break;
                        } else if ($task_weight > 100) {
                            $continueProcessing = false;
                            echo json_encode(['code' => 422, 'errorField' => 'task_weight_' . $section_row, "toasterClass" => 'error', 'errorMessage' => 'The Task Weight field should not greater than 100.']);
                            break;
                        } else if ($task_weight <= 0) {
                            $continueProcessing = false;
                            echo json_encode(['code' => 422, 'errorField' => 'task_weight_' . $section_row, "toasterClass" => 'error', 'errorMessage' => 'The Task Weight field should greater than 0.']);
                            break;
                        } else if (strlen($task_weight) > 6) {
                            $continueProcessing = false;
                            echo json_encode(['code' => 422, 'errorField' => 'task_weight_' . $section_row, "toasterClass" => 'error', 'errorMessage' => 'Length should not exceed 6 characters.']);
                            break;
                        } else if (empty($data["tasks"]) || sizeof($data["tasks"]) < 1) {
                            $continueProcessing = false;
                            echo json_encode(['code' => 405, "toasterClass" => 'error', 'responseMessage' => 'Please checked at least one Task under section ' . $section_row]);
                            break;
                        } else {
                            $success = $errorField = $responseMessage = true;
                            $task_row = 0;

                            foreach ($data["tasks"] as $tasks) {
                                $task_row++;
                                $task_description = $tasks['task_description'];
                                //$total_marks = $tasks['total_marks'];

                                if (empty($task_description)) {
                                    $errorField = 'task_description_' . $section_row . '_' . $task_row;
                                    $responseMessage = 'Task Description field is required, At line no ' . $task_row;
                                    $success = false;
                                    break;
                                } else if (!validAddress($task_description)) {
                                    $errorField = 'task_description_' . $section_row . '_' . $task_row;
                                    $responseMessage = 'Special Characters are not Allowed in Task Description field, At line no ' . $task_row;
                                    $success = false;
                                    break;
                                }/* else if ($total_marks == '') {
                                    $errorField = 'total_marks_' . $section_row . '_' . $task_row;
                                    $responseMessage = 'The Measure field is required, At line no ' . $task_row;
                                    $success = false;
                                    break;
                                } else if (!is_numeric($total_marks)) {
                                    $errorField = 'total_marks_' . $section_row . '_' . $task_row;
                                    $responseMessage = 'Measure field should contain only numeric characters, At line no ' . $task_row;
                                    $success = false;
                                    break;
                                } else if ($total_marks > 100) {
                                    $errorField = 'total_marks_' . $section_row . '_' . $task_row;
                                    $responseMessage = 'The Measure field should not greater than 100, At line no ' . $task_row;
                                    $success = false;
                                    break;
                                } else if ($total_marks <= 0) {
                                    $errorField = 'total_marks_' . $section_row . '_' . $task_row;
                                    $responseMessage = 'The Measure field should greater than 0, At line no ' . $task_row;
                                    $success = false;
                                    break;
                                } else if (strlen($total_marks) > 6) {
                                    $errorField = 'total_marks_' . $section_row . '_' . $task_row;
                                    $responseMessage = 'Length should not exceed 6 characters, At line no ' . $task_row;
                                    $success = false;
                                    break;
                                }*/
                            }

                            if ($success === false) {
                                $continueProcessing = false;
                                echo json_encode(['code' => 422, 'errorField' => $errorField, "toasterClass" => 'error', 'errorMessage' => $responseMessage]);
                                break;
                            } else {
                                $total_task_weight = round(round($total_task_weight, 2) + round($task_weight, 2), 2);
                            }
                        }
                    }

                    if ($total_task_weight != 100) {
                        echo json_encode(['code' => 405, "toasterClass" => 'error', 'responseMessage' => 'Total of "Task Weight" fields should be 100%.']);
                    } else if (isset($success) && $continueProcessing === true && $success === true) {
                        if ($id > 0) {
                            $form_reset = false;
                            $evaluation_id = $id;
                            $update_evaluations = "UPDATE `evaluations` SET `name`='{$name}', `evaluation_type_id`='{$evaluation_type_id}', `date`='{$date}', `department_id`='{$department_id}', `designation_id`='{$designation_id}', `updated_by`='{$user_id}' WHERE `id`='{$evaluation_id}'";
                            mysqli_query($db, $update_evaluations);
                            $delete = "DELETE FROM `evaluation_details` WHERE `evaluation_id`='{$evaluation_id}'";
                            mysqli_query($db, $delete);
                            $delete = "DELETE FROM `evaluation_task_details` WHERE `evaluation_task_id` IN (SELECT id FROM `evaluation_tasks` WHERE `evaluation_id`='{$evaluation_id}')";
                            mysqli_query($db, $delete);
                            $delete = "DELETE FROM `evaluation_tasks` WHERE `evaluation_id`='{$evaluation_id}'";
                            mysqli_query($db, $delete);
                        } else {
                            $insert_evaluations = "INSERT INTO `evaluations`(`id`, `name`, `evaluation_type_id`, `date`, `department_id`, `designation_id`, `company_id`, `branch_id`, `added_by`) VALUES (NULL,'{$name}','{$evaluation_type_id}','{$date}','{$department_id}','{$designation_id}','{$company_id}','{$branch_id}','{$user_id}')";
                            mysqli_query($db, $insert_evaluations);
                            $evaluation_id = mysqli_insert_id($db);
                            $form_reset = true;
                        }
                        if ($evaluation_id > 0) {

                            $notification_status = config('notifications.status.value.pending');
                            $notification_type = config('notifications.type.value.evaluation_start');

                            foreach ($object->employee_ids as $employeeInfo) {
                                $employeeid = $employeeInfo['employee_id'];
                                $teamid = $employeeInfo['team_id'];
                                $employeeInfoFromId = getEmployeeInfoFromId($employeeid);

                                //get parent id
                                $parent_id = getReportEmpId($employeeid);
                                $signed_url = generatePassword('65', TRUE);

                                deleteNotification($notification_type, $evaluation_id, $company_id, $branch_id, $employeeid, $parent_id);

                                $insert_evaluation_details = "INSERT INTO `evaluation_details`(`id`, `evaluation_id`, `team_id`, `parent_id`, `employee_id`, `status`, `signed_url`, `added_by`) VALUES (NULL,'{$evaluation_id}','{$teamid}','{$parent_id}','{$employeeid}','p','{$signed_url}','{$user_id}')";
                                mysqli_query($db, $insert_evaluation_details);
                                $evaluation_detail_id = mysqli_insert_id($db);

                                $notification_body = getNotificationBody($notification_type, ['{employeeName}' => $employeeInfoFromId->full_name]);
                                $link = $admin_url . 'view_evaluation?signature=' . $signed_url . '&ev=' . $evaluation_id . '&evd=' . $evaluation_detail_id . '&emp=' . $employeeid . '&p=' . $parent_id;
                                insertNotification($notification_type, $employeeid, $parent_id, $evaluation_id, $notification_body['message'], $link, $notification_status, $company_id, $branch_id, $user_id);
                            }
                            $insert_data_time = 0;
                            foreach ($object->data as $data) {
                                $insert_data_time++;
                                $task_heading = $db->real_escape_string(html_entity_decode(stripslashes(strip_tags($data["task_heading"]))));
                                $task_weight = $data["task_weight"];

                                $insert_evaluation_tasks = "INSERT INTO `evaluation_tasks`(`id`, `task_heading`, `task_weight`, `evaluation_id`, `company_id`, `branch_id`, `added_by`) VALUES (NULL,'{$task_heading}','{$task_weight}','{$evaluation_id}','{$company_id}','{$branch_id}','{$user_id}')";
                                mysqli_query($db, $insert_evaluation_tasks);
                                $evaluation_task_id = mysqli_insert_id($db);

                                foreach ($data["tasks"] as $tasks) {
                                    $task_description = $db->real_escape_string(html_entity_decode(stripslashes(strip_tags($tasks["task_description"]))));
                                    //$total_marks = $tasks['total_marks'];
                                    $insert_evaluation_task_details = "INSERT INTO `evaluation_task_details`(`id`, `task_description`, `evaluation_task_id`, `added_by`) VALUES (NULL,'{$task_description}','{$evaluation_task_id}','{$user_id}')";
                                    mysqli_query($db, $insert_evaluation_task_details);
                                }
                            }

                            if (sizeof($object->data) == $insert_data_time) {
                                echo json_encode(['code' => 200, "toasterClass" => 'success', "responseMessage" => 'Record successfully saved.', 'form_reset' => $form_reset]);
                            }
                        } else {
                            echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'Unexpected error.']);
                        }
                    }
                } elseif ($parent === false) {
                    echo json_encode(['code' => 405, "toasterClass" => 'error', 'responseMessage' => 'Selected user "' . $employeeInfoFromId->full_name . '" has not report.']);
                } elseif ($employee === false) {
                    echo json_encode(['code' => 405, "toasterClass" => 'error', 'responseMessage' => 'Invalid user selected.']);
                }

            } else {
                echo json_encode(['code' => 405, "toasterClass" => 'error', 'responseMessage' => 'Designation doesn\'t exist.']);
            }
        } else {
            echo json_encode(['code' => 405, "toasterClass" => 'error', 'responseMessage' => 'Department doesn\'t exist.']);
        }

    }
}
?>