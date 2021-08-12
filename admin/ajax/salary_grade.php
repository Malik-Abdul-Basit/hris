<?php
include_once('../../includes/connection.php');

if (isset($_POST['postData'])) {

    $object = (object)$_POST['postData'];
    $id = $object->id;
    $name = $object->name;
    $department_id = $object->department_id;
    $user_right_title = $object->user_right_title;

    if ((empty($id) || $id == 0) && (!hasRight($user_right_title, 'add'))) {
        echo json_encode(["code" => 405, "toasterClass" => 'warning', "responseMessage" => 'Sorry! You have no right to add record.']);
    } else if (!empty($id) && is_numeric($id) && $id > 0 && !hasRight($user_right_title, 'edit')) {
        echo json_encode(["code" => 405, "toasterClass" => 'warning', "responseMessage" => 'Sorry! You have no right to update record.']);
    } else if (empty($name)) {
        echo json_encode(['code' => 422, 'errorField' => 'name', 'errorDiv' => 'errorMessageName', 'errorMessage' => 'Salary Band Name field is required.']);
    } else if (strlen($name) > 50) {
        echo json_encode(['code' => 422, 'errorField' => 'name', 'errorDiv' => 'errorMessageName', 'errorMessage' => 'Length should not exceed 50 characters.']);
    } else if (!validName($name)) {
        echo json_encode(['code' => 422, 'errorField' => 'name', 'errorDiv' => 'errorMessageName', 'errorMessage' => 'Special Characters are not Allowed.']);
    } else if ($department_id == '') {
        echo json_encode(['code' => 422, 'errorField' => 'department_id', 'errorDiv' => 'errorMessageDepartment', 'errorMessage' => 'Department field is required.']);
    } else if (!is_numeric($department_id) || strlen($department_id) > 10) {
        echo json_encode(['code' => 422, 'errorField' => 'department_id', 'errorDiv' => 'errorMessageDepartment', 'errorMessage' => 'Please select a valid option.']);
    } else if (empty($object->data) || sizeof($object->data) < 1) {
        echo json_encode(['code' => 405, "toasterClass" => 'error', 'responseMessage' => 'Please checked at least one Salary Grades.']);
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
                if (empty($data['grade_name'])) {
                    $message = 'Grade Name field is required, At line no ' . $row;
                    $continueProcessing = false;
                    break;
                } else if (strlen($data['grade_name']) > 50) {
                    $message = 'Length should not exceed 50 characters, At line no ' . $row;
                    $continueProcessing = false;
                    break;
                } else if (!validName($data['grade_name'])) {
                    $message = 'Special Characters are not Allowed in Grade Name field, At line no ' . $row;
                    $continueProcessing = false;
                    break;
                } else if ($data['from'] == '') {
                    $message = 'Amount From field is required, At line no ' . $row;
                    $continueProcessing = false;
                    break;
                } else if (!is_numeric($data['from'])) {
                    $message = 'Amount From field should contain only numeric characters, At line no ' . $row;
                    $continueProcessing = false;
                    break;
                } else if (strlen($data['from']) > 9) {
                    $message = 'Length of "Amount From" field should not exceed 9 digits, At line no ' . $row;
                    $continueProcessing = false;
                    break;
                } else if ($data['from'] <= 0) {
                    $message = 'Amount From field should greater-than 0, At line no ' . $row;
                    $continueProcessing = false;
                    break;
                } else if ($data['to'] == '') {
                    $message = 'Amount To field is required, At line no ' . $row;
                    $continueProcessing = false;
                    break;
                } else if (!is_numeric($data['to'])) {
                    $message = 'Amount To field should contain only numeric characters, At line no ' . $row;
                    $continueProcessing = false;
                    break;
                } else if (strlen($data['to']) > 9) {
                    $message = 'Length of "Amount To" field should not exceed 9 digits, At line no ' . $row;
                    $continueProcessing = false;
                    break;
                } else if ($data['to'] <= 0) {
                    $message = 'Amount To field should greater-than 0, At line no ' . $row;
                    $continueProcessing = false;
                    break;
                } else if ($data['to'] < $data['from']) {
                    $message = '"Amount To" should not less-than "Amount From" At line no ' . $row;
                    $continueProcessing = false;
                    break;
                } else {
                    $continueProcessing = true;
                }
            }

            if ($continueProcessing === false) {
                echo json_encode(['code' => 405, "toasterClass" => 'error', 'responseMessage' => $message]);
            } else {
                $SelectOld = "SELECT `id` FROM `salary_grades` WHERE `id`!='{$id}' AND `name`='{$name}' AND `department_id`='{$depart_id}' AND `company_id`='{$company_id}' AND `branch_id`='{$branch_id}' AND `deleted_at` IS NULL";
                $QueryOld = mysqli_query($db, $SelectOld);
                if ($QueryOld && mysqli_num_rows($QueryOld) > 0) {
                    echo json_encode(['code' => 405, "toasterClass" => 'error', 'responseMessage' => "This Salary Bands (Grades) for selected department already exist."]);
                } else {
                    if ($id > 0) {
                        mysqli_query($db, "DELETE FROM `salary_grade_details` WHERE `salary_grade_id`='{$id}'");
                        $update = "UPDATE `salary_grades` SET `name`='{$name}', `department_id`='{$depart_id}', `updated_by`='{$user_id}' WHERE `id`='{$id}' AND `company_id`='{$company_id}' AND `branch_id`='{$branch_id}'";
                        mysqli_query($db, $update);
                        foreach ($object->data as $row => $data) {
                            $insert = "INSERT INTO `salary_grade_details`(`id`, `salary_grade_id`, `grade_name`, `to`, `from`) VALUES (NULL, '{$id}', '{$data["grade_name"]}', '{$data["to"]}', '{$data["from"]}')";
                            mysqli_query($db, $insert);
                        }
                        $form_reset = false;
                    } else {
                        $insert = "INSERT INTO `salary_grades`(`id`, `name`, `department_id`, `company_id`, `branch_id`, `added_by`) VALUES (NULL, '{$name}', '{$depart_id}', '{$company_id}', '{$branch_id}', '{$user_id}')";
                        mysqli_query($db, $insert);
                        $insert_id = mysqli_insert_id($db);
                        foreach ($object->data as $row => $data) {
                            $insert = "INSERT INTO `salary_grade_details`(`id`, `salary_grade_id`, `grade_name`, `to`, `from`) VALUES (NULL, '{$insert_id}', '{$data["grade_name"]}', '{$data["to"]}', '{$data["from"]}')";
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