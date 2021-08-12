<?php
include_once('../../includes/connection.php');

if (isset($_POST['postData'])) {

    $object = (object)$_POST['postData'];
    $id = $object->id;
    $department_id = $object->department_id;
    $user_right_title = $object->user_right_title;

    if ((empty($id) || $id == 0) && (!hasRight($user_right_title, 'add'))) {
        echo json_encode(["code" => 405, "toasterClass" => 'warning', "responseMessage" => 'Sorry! You have no right to add record.']);
    } else if (!empty($id) && is_numeric($id) && $id > 0 && !hasRight($user_right_title, 'edit')) {
        echo json_encode(["code" => 405, "toasterClass" => 'warning', "responseMessage" => 'Sorry! You have no right to update record.']);
    } else if ($department_id == '') {
        echo json_encode(['code' => 422, 'errorField' => 'department_id', 'errorDiv' => 'errorMessageDepartment', 'errorMessage' => 'Department field is required.']);
    } else if (!is_numeric($department_id) || strlen($department_id) > 10) {
        echo json_encode(['code' => 422, 'errorField' => 'department_id', 'errorDiv' => 'errorMessageDepartment', 'errorMessage' => 'Please select a valid option.']);
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
                    $message = 'Name field is required, At line no ' . $row;
                    $continueProcessing = false;
                    break;
                } else if (strlen($data['gp_name']) > 50) {
                    $message = 'Length should not exceed 50 characters, At line no ' . $row;
                    $continueProcessing = false;
                    break;
                } else if (!validAddress($data['gp_name'])) {
                    $message = 'Special Characters are not Allowed in Name field, At line no ' . $row;
                    $continueProcessing = false;
                    break;
                } else if ($data['gp_value'] == '') {
                    $message = 'Value should greater-than 0, At line no ' . $row;
                    $continueProcessing = false;
                    break;
                } else if (strlen($data['gp_value']) > 6) {
                    $message = 'Length should not exceed 6 characters, At line no ' . $row;
                    $continueProcessing = false;
                    break;
                } else if (!is_numeric($data['gp_value'])) {
                    $message = 'Value field should contain only numeric characters, At line no ' . $row;
                    $continueProcessing = false;
                    break;
                } else if (empty($data['gp_description'])) {
                    $message = 'Description field is required, At line no ' . $row;
                    $continueProcessing = false;
                    break;
                } else if (!validAddress($data['gp_description'])) {
                    $message = 'Special Characters are not Allowed in Description field, At line no ' . $row;
                    $continueProcessing = false;
                    break;
                } else {
                    $continueProcessing = true;
                }
            }
            if ($continueProcessing === false) {
                echo json_encode(['code' => 405, "toasterClass" => 'error', 'responseMessage' => $message]);
            } else {
                /*$SelectOld = "SELECT `id` FROM `evaluation_default_number_stacks` WHERE `id`!='{$id}' AND `department_id`='{$depart_id}' AND `company_id`='{$company_id}' AND `branch_id`='{$branch_id}' AND `deleted_at` IS NULL";
                $QueryOld = mysqli_query($db, $SelectOld);
                if ($QueryOld && mysqli_num_rows($QueryOld) > 0) {
                    echo json_encode(['code' => 405, "toasterClass" => 'error', 'responseMessage' => "Number Stacks for selected department already exist."]);
                } else {*/

                    if ($id > 0) {
                        $default = config('evaluation_results.number_stack_is_default.value.default');
                        if(!numberStackUsed($id, $default)){
                            mysqli_query($db, "DELETE FROM `evaluation_default_number_stack_details` WHERE `gp_id`='{$id}'");
                            $update = "UPDATE `evaluation_default_number_stacks` SET `department_id`='{$depart_id}', `updated_by`='{$user_id}' WHERE `id`='{$id}' AND `company_id`='{$company_id}' AND `branch_id`='{$branch_id}'";
                            mysqli_query($db, $update);
                            foreach ($object->data as $row => $data) {
                                $insert = "INSERT INTO `evaluation_default_number_stack_details`(`id`, `gp_id`, `gp_name`, `gp_value`, `gp_description`) VALUES (NULL, '{$id}', '{$data["gp_name"]}', '{$data["gp_value"]}', '{$data["gp_description"]}')";
                                mysqli_query($db, $insert);
                            }
                        }
                        $form_reset = false;
                    }
                    else {
                        $insert = "INSERT INTO `evaluation_default_number_stacks`(`id`, `department_id`, `company_id`, `branch_id`, `added_by`) VALUES (NULL, '{$depart_id}', '{$company_id}', '{$branch_id}', '{$user_id}')";
                        mysqli_query($db, $insert);
                        $insert_id = mysqli_insert_id($db);
                        foreach ($object->data as $row => $data) {
                            $insert = "INSERT INTO `evaluation_default_number_stack_details`(`id`, `gp_id`, `gp_name`, `gp_value`, `gp_description`) VALUES (NULL, '{$insert_id}', '{$data["gp_name"]}', '{$data["gp_value"]}', '{$data["gp_description"]}')";
                            mysqli_query($db, $insert);
                        }
                        $form_reset = true;
                    }
                    echo json_encode(['code' => 200, "toasterClass" => 'success', "responseMessage" => 'Record successfully saved.', 'form_reset' => $form_reset]);
                /*}*/
            }
        } else {
            echo json_encode(['code' => 405, "toasterClass" => 'error', 'responseMessage' => 'Department doesn\'t exist.']);
        }
    }
}
?>