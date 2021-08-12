<?php
include_once('../../includes/connection.php');

if (isset($_POST['postData'])) {

    $object = (object)$_POST['postData'];
    $id = $object->id;
    $evaluation_type_id = $object->evaluation_type_id;
    $department_id = $object->department_id;
    $salary_grade_id = $object->salary_grade_id;
    $user_right_title = $object->user_right_title;

    if ((empty($id) || $id == 0) && (!hasRight($user_right_title, 'add'))) {
        echo json_encode(["code" => 405, "toasterClass" => 'warning', "responseMessage" => 'Sorry! You have no right to add record.']);
    } else if (!empty($id) && is_numeric($id) && $id > 0 && !hasRight($user_right_title, 'edit')) {
        echo json_encode(["code" => 405, "toasterClass" => 'warning', "responseMessage" => 'Sorry! You have no right to update record.']);
    } else if (empty($evaluation_type_id)) {
        echo json_encode(['code' => 422, 'errorField' => 'evaluation_type_id', 'errorDiv' => 'errorMessageEvaluationType', 'errorMessage' => 'Evaluation Type field is required.']);
    } else if (!is_numeric($evaluation_type_id) || strlen($evaluation_type_id) > 10) {
        echo json_encode(['code' => 422, 'errorField' => 'evaluation_type_id', 'errorDiv' => 'errorMessageEvaluationType', 'errorMessage' => 'Please select a valid option.']);
    } else if ($department_id == '') {
        echo json_encode(['code' => 422, 'errorField' => 'department_id', 'errorDiv' => 'errorMessageDepartment', 'errorMessage' => 'Department field is required.']);
    } else if (!is_numeric($department_id) || strlen($department_id) > 10) {
        echo json_encode(['code' => 422, 'errorField' => 'department_id', 'errorDiv' => 'errorMessageDepartment', 'errorMessage' => 'Please select a valid option.']);
    } else if (empty($salary_grade_id)) {
        echo json_encode(['code' => 422, 'errorField' => 'salary_grade_id', 'errorDiv' => 'errorMessageSalaryGradeId', 'errorMessage' => 'Salary Band field is required.']);
    } else if (!is_numeric($salary_grade_id) || strlen($salary_grade_id) > 10) {
        echo json_encode(['code' => 422, 'errorField' => 'salary_grade_id', 'errorDiv' => 'errorMessageSalaryGradeId', 'errorMessage' => 'Please select a valid option.']);
    } else if (empty($object->data) || sizeof($object->data) < 1) {
        echo json_encode(['code' => 405, "toasterClass" => 'error', 'responseMessage' => 'Please provide at least one Grading Policy.']);
    } else {
        $company_id = $_SESSION['company_id'];
        $branch_id = $_SESSION['branch_id'];
        $user_id = $_SESSION['user_id'];
        $department = $continueProcessing = false;
        $message = '';
        if ($department_id > 0) {
            $select = "SELECT `id` FROM `departments` WHERE `id`='{$department_id}' AND `company_id`='{$company_id}' AND `branch_id`='{$branch_id}' AND `deleted_at` IS NULL ORDER BY `sort_by` ASC LIMIT 1";
            $query = mysqli_query($db, $select);
            if (mysqli_num_rows($query) > 0) {
                $depart_id = $department_id;
                $department = true;
            }
        } else {
            $depart_id = $department_id;
            $department = true;
        }

        if ($department) {
            foreach ($object->data as $row => $data) {
                $row++;

                if (empty($data['gp_name'])) {
                    $message = 'Title field is required, At line no ' . $row;
                    $continueProcessing = false;
                    break;
                } else if (strlen($data['gp_name']) > 50) {
                    $message = 'Title field should not exceed 50 letters, At line no ' . $row;
                    $continueProcessing = false;
                    break;
                } else if (!validAddress($data['gp_name'])) {
                    $message = 'Special Characters are not Allowed in Title field, At line no ' . $row;
                    $continueProcessing = false;
                    break;
                } else if (empty($data['percentage_from'])) {
                    $message = 'Percentage From field is required, At line no ' . $row;
                    $continueProcessing = false;
                    break;
                } else if (!is_numeric($data['percentage_from'])) {
                    $message = 'Percentage From field should contain only numeric characters, At line no ' . $row;
                    $continueProcessing = false;
                    break;
                } else if ($data['percentage_from'] > 100) {
                    $message = 'Percentage From should not exceed 100%, At line no ' . $row;
                    $continueProcessing = false;
                    break;
                } else if (empty($data['percentage_to'])) {
                    $message = 'Percentage To field is required, At line no ' . $row;
                    $continueProcessing = false;
                    break;
                } else if (!is_numeric($data['percentage_to'])) {
                    $message = 'Percentage To field should contain only numeric characters, At line no ' . $row;
                    $continueProcessing = false;
                    break;
                } else if ($data['percentage_to'] > 100) {
                    $message = 'Percentage To should not exceed 100%, At line no ' . $row;
                    $continueProcessing = false;
                    break;
                } else if ($data['percentage_to'] < $data['percentage_from']) {
                    $message = '"Percentage To" should not less-than "Percentage From", At line no ' . $row;
                    $continueProcessing = false;
                    break;
                } else if ($data['amount_from'] != '' && !is_numeric($data['amount_from'])) {
                    $message = 'Amount From field should contain only numeric characters, At line no ' . $row;
                    $continueProcessing = false;
                    break;
                } else if ($data['amount_from'] != '' && strlen($data['amount_from']) > 10) {
                    $message = 'Amount From field should not exceed 10 digits, At line no ' . $row;
                    $continueProcessing = false;
                    break;
                } else if ($data['amount_to'] != '' && !is_numeric($data['amount_to'])) {
                    $message = 'Amount To field should contain only numeric characters, At line no ' . $row;
                    $continueProcessing = false;
                    break;
                } else if ($data['amount_to'] != '' && strlen($data['amount_to']) > 10) {
                    $message = 'Amount To field should not exceed 10 digits, At line no ' . $row;
                    $continueProcessing = false;
                    break;
                } else if ($data['amount_to'] != '' && $data['amount_to'] > 0 && empty($data['amount_from'])) {
                    $message = 'Amount From field is required, At line no ' . $row;
                    $continueProcessing = false;
                    break;
                } else if ($data['amount_from'] != '' && $data['amount_from'] > 0 && empty($data['amount_to'])) {
                    $message = 'Amount To field is required, At line no ' . $row;
                    $continueProcessing = false;
                    break;
                } else if ($data['amount_from'] != '' && $data['amount_to'] != '' && ($data['amount_to'] < $data['amount_from'])) {
                    $message = '"Amount To" should not greater-than "Amount From", At line no ' . $row;
                    $continueProcessing = false;
                    break;
                } else if (empty($data['amount_from']) && empty($data['amount_to']) && empty($data['gp_action'])) {
                    $message = 'Action field is required, At line no ' . $row;
                    $continueProcessing = false;
                    break;
                } else if ($data['gp_action'] != '' && !validAddress($data['gp_action'])) {
                    $message = 'Special Characters are not Allowed in Action field, At line no ' . $row;
                    $continueProcessing = false;
                    break;
                } else {
                    $continueProcessing = true;
                }
            }

            if ($continueProcessing === false) {
                echo json_encode(['code' => 405, "toasterClass" => 'error', 'responseMessage' => $message]);
            } else {
                $SelectOld = "SELECT `id` FROM `evaluation_grading_policies` WHERE `id`!='{$id}' AND `evaluation_type_id`='{$evaluation_type_id}' AND `department_id`='{$depart_id}' AND `salary_grade_id`='{$salary_grade_id}' AND `company_id`='{$company_id}' AND `branch_id`='{$branch_id}'";
                $QueryOld = mysqli_query($db, $SelectOld);
                if ($QueryOld && mysqli_num_rows($QueryOld) > 0) {
                    echo json_encode(['code' => 405, "toasterClass" => 'error', 'responseMessage' => "Grading Policy of selected department already exist."]);
                } else {
                    if ($id > 0) {
                        mysqli_query($db, "DELETE FROM `evaluation_grading_policy_details` WHERE `gp_id`='{$id}'");
                        $update = "UPDATE `evaluation_grading_policies` SET `evaluation_type_id`='{$evaluation_type_id}', `department_id`='{$depart_id}', `salary_grade_id`='{$salary_grade_id}', `updated_by`='{$user_id}' WHERE `id`='{$id}' AND `company_id`='{$company_id}' AND `branch_id`='{$branch_id}'";
                        mysqli_query($db, $update);
                        foreach ($object->data as $row => $data) {
                            $insert = "INSERT INTO `evaluation_grading_policy_details`(`id`, `gp_id`, `gp_name`, `percentage_from`, `percentage_to`, `amount_from`, `amount_to`, `gp_action`) VALUES (NULL, '{$id}', '{$data["gp_name"]}', '{$data["percentage_from"]}', '{$data["percentage_to"]}', '{$data["amount_from"]}', '{$data["amount_to"]}', '{$data["gp_action"]}')";
                            mysqli_query($db, $insert);
                        }
                        $form_reset = false;
                    } else {
                        $insert = "INSERT INTO `evaluation_grading_policies`(`id`, `evaluation_type_id`, `department_id`, `salary_grade_id`, `company_id`, `branch_id`, `added_by`) VALUES (NULL, '{$evaluation_type_id}', '{$depart_id}', '{$salary_grade_id}', '{$company_id}', '{$branch_id}', '{$user_id}')";
                        mysqli_query($db, $insert);
                        $insert_id = mysqli_insert_id($db);
                        foreach ($object->data as $row => $data) {
                            $insert = "INSERT INTO `evaluation_grading_policy_details`(`id`, `gp_id`, `gp_name`, `percentage_from`, `percentage_to`, `amount_from`, `amount_to`, `gp_action`) VALUES (NULL, '{$insert_id}', '{$data["gp_name"]}', '{$data["percentage_from"]}', '{$data["percentage_to"]}', '{$data["amount_from"]}', '{$data["amount_to"]}', '{$data["gp_action"]}')";
                            mysqli_query($db, $insert);
                        }
                        $form_reset = true;
                    }
                    echo json_encode(['code' => 200, "toasterClass" => 'success', "responseMessage" => 'Record successfully saved.', 'form_reset' => $form_reset]);
                }
            }
        } else {
            echo json_encode(['code' => 405, "toasterClass" => 'error', 'responseMessage' => 'Department doesn\'t exist.']);
        }
    }
}
?>