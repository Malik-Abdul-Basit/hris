<?php
include_once('../../includes/connection.php');

if (isset($_POST['postData'])) {

    $object = (object)$_POST['postData'];
    $id = $object->id;
    $department_id = $object->department_id;
    $designation_id = $object->designation_id;
    $user_right_title = $object->user_right_title;

    if ((empty($id) || $id == 0) && (!hasRight($user_right_title, 'add'))) {
        echo json_encode(["code" => 405, "toasterClass" => 'warning', "responseMessage" => 'Sorry! You have no right to add record.']);
    } else if (!empty($id) && is_numeric($id) && $id > 0 && !hasRight($user_right_title, 'edit')) {
        echo json_encode(["code" => 405, "toasterClass" => 'warning', "responseMessage" => 'Sorry! You have no right to update record.']);
    } else if (empty($department_id)) {
        echo json_encode(['code' => 422, "toasterClass" => 'error', 'errorField' => 'department_id', 'errorMessage' => 'Department field is required.']);
    } else if (!is_numeric($department_id) || strlen($department_id) > 10 || $department_id <= 0) {
        echo json_encode(['code' => 422, "toasterClass" => 'error', 'errorField' => 'department_id', 'errorMessage' => 'Please select a valid option.']);
    } else if (empty($designation_id)) {
        echo json_encode(['code' => 422, "toasterClass" => 'error', 'errorField' => 'designation_id', 'errorMessage' => 'Designation field is required.']);
    } else if (!is_numeric($designation_id) || strlen($designation_id) > 10 || $designation_id <= 0) {
        echo json_encode(['code' => 422, "toasterClass" => 'error', 'errorField' => 'designation_id', 'errorMessage' => 'Please select a valid option.']);
    } else {
        $company_id = $_SESSION['company_id'];
        $branch_id = $_SESSION['branch_id'];
        $user_id = $_SESSION['user_id'];
        $continueProcessing = true;

        /*echo '<pre>';
        print_r($object->data);
        echo '</pre>';
        exit();*/

        $section_row = $total_task_weight = 0;
        $employee = $parent = true;

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
                    }
                    /*else if ($total_marks == '') {
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

            $check = "SELECT `id` FROM `evaluation_default_questions` WHERE `id` != '{$id}' AND `department_id`='{$department_id}' AND `designation_id`='{$designation_id}' AND `company_id`='{$company_id}' AND `branch_id`='{$branch_id}' AND `deleted_at` IS NULL";
            $query_check = mysqli_query($db, $check);
            if (mysqli_num_rows($query_check) > 0) {
                echo json_encode(['code' => 405, "toasterClass" => 'error', 'responseMessage' => 'Tasks (JD\'s) for selected designation already exist.']);
            } else {
                if ($id > 0) {
                    $question_id = $id;
                    $form_reset = false;
                    $update = "UPDATE `evaluation_default_questions` SET `department_id`='{$department_id}', `designation_id`='{$designation_id}', `updated_by`='{$user_id}' WHERE `id`='{$question_id}'";
                    mysqli_query($db, $update);
                    $delete = "DELETE FROM `evaluation_default_task_details` WHERE `eval_default_task_id` IN (SELECT id FROM `evaluation_default_tasks` WHERE `eval_default_question_id`='{$question_id}')";
                    mysqli_query($db, $delete);
                    $delete = "DELETE FROM `evaluation_default_tasks` WHERE `eval_default_question_id`='{$question_id}'";
                    mysqli_query($db, $delete);
                } else {
                    $insert = "INSERT INTO `evaluation_default_questions`(`id`,`department_id`,`designation_id`,`company_id`,`branch_id`,`added_by`) VALUES (NULL,'{$department_id}','{$designation_id}','{$company_id}','{$branch_id}','{$user_id}')";
                    mysqli_query($db, $insert);
                    $question_id = mysqli_insert_id($db);
                    $form_reset = true;
                }
                if ($question_id > 0) {

                    $insert_data_time = 0;
                    foreach ($object->data as $data) {
                        $insert_data_time++;
                        $task_heading = $db->real_escape_string(html_entity_decode(stripslashes(strip_tags($data["task_heading"]))));
                        $task_weight = $data["task_weight"];

                        $insert_evaluation_tasks = "INSERT INTO `evaluation_default_tasks`(`id`, `task_heading`, `task_weight`, `eval_default_question_id`, `company_id`, `branch_id`, `added_by`) VALUES (NULL,'{$task_heading}','{$task_weight}','{$question_id}','{$company_id}','{$branch_id}','{$user_id}')";
                        mysqli_query($db, $insert_evaluation_tasks);
                        $evaluation_task_id = mysqli_insert_id($db);

                        foreach ($data["tasks"] as $tasks) {
                            $task_description = $db->real_escape_string(html_entity_decode(stripslashes(strip_tags($tasks["task_description"]))));
                            //$total_marks = $tasks['total_marks'];
                            $insert_evaluation_task_details = "INSERT INTO `evaluation_default_task_details`(`id`, `task_description`, `eval_default_task_id`, `added_by`) VALUES (NULL,'{$task_description}','{$evaluation_task_id}','{$user_id}')";
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
        }


        /*$select_dep = "SELECT `id` FROM `departments` WHERE `id`='{$department_id}' AND `company_id`='{$company_id}' AND `branch_id`='{$branch_id}' AND `deleted_at` IS NULL ORDER BY `sort_by` ASC LIMIT 1";
        $query_dep = mysqli_query($db, $select_dep);
        if (mysqli_num_rows($query_dep) > 0) {
            $select_des = "SELECT `id` FROM `designations` WHERE `id`='{$designation_id}' AND `company_id`='{$company_id}' AND `branch_id`='{$branch_id}' AND `deleted_at` IS NULL ORDER BY `sort_by` ASC LIMIT 1";
            $query_des = mysqli_query($db, $select_des);
            if (mysqli_num_rows($query_des) > 0) {

                //Code here

            } else {
                echo json_encode(['code' => 405, "toasterClass" => 'error', 'responseMessage' => 'Designation doesn\'t exist.']);
            }
        } else {
            echo json_encode(['code' => 405, "toasterClass" => 'error', 'responseMessage' => 'Department doesn\'t exist.']);
        }*/

    }
}
?>