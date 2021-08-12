<?php
include_once('../../includes/connection.php');

if (isset($_POST['postData'])) {
    $object = (object)$_POST['postData'];

    $id = $object->id;
    $name = $object->name;
    $department_id = $object->department_id;
    $sort_by = $object->sort_by;
    $is_hod = $object->is_hod;
    $user_right_title = $object->user_right_title;

    $is_hod_array = array_values(config('designations.is_hod.value'));

    if ((empty($id) || $id == 0) && (!hasRight($user_right_title, 'add'))) {
        echo json_encode(["code" => 405, "toasterClass" => 'warning', "responseMessage" => 'Sorry! You have no right to add record.']);
    } else if (!empty($id) && is_numeric($id) && $id > 0 && !hasRight($user_right_title, 'edit')) {
        echo json_encode(["code" => 405, "toasterClass" => 'warning', "responseMessage" => 'Sorry! You have no right to update record.']);
    } else if (empty($name)) {
        echo json_encode(['code' => 422, 'errorField' => 'name', 'errorDiv' => 'errorMessageName', 'errorMessage' => 'Name field is required.']);
    } else if (!validName($name)) {
        echo json_encode(['code' => 422, 'errorField' => 'name', 'errorDiv' => 'errorMessageName', 'errorMessage' => 'Special Characters are not Allowed.']);
    } else if (strlen($name) > 50) {
        echo json_encode(['code' => 422, 'errorField' => 'name', 'errorDiv' => 'errorMessageName', 'errorMessage' => 'Length should not exceed 50 characters.']);
    } else if (empty($department_id)) {
        echo json_encode(['code' => 422, 'errorField' => 'department_id', 'errorDiv' => 'errorMessageName', 'errorMessage' => 'Department field is required.']);
    } else if (!is_numeric($department_id) || strlen($department_id) > 10) {
        echo json_encode(['code' => 422, 'errorField' => 'department_id', 'errorDiv' => 'errorMessageName', 'errorMessage' => 'Please select a valid option.']);
    } else if (empty($sort_by)) {
        echo json_encode(['code' => 422, 'errorField' => 'sort_by', 'errorDiv' => 'errorMessageSortBy', 'errorMessage' => 'Sort By field is required.']);
    } else if (!is_numeric($sort_by)) {
        echo json_encode(['code' => 422, 'errorField' => 'sort_by', 'errorDiv' => 'errorMessageSortBy', 'errorMessage' => 'Sort By field should contain only numeric.']);
    } else if (strlen($sort_by) > 9) {
        echo json_encode(['code' => 422, 'errorField' => 'sort_by', 'errorDiv' => 'errorMessageSortBy', 'errorMessage' => 'Length should not exceed 9 digits.']);
    } else if ($is_hod == '' || !in_array($is_hod, $is_hod_array) || strlen($is_hod) != 1) {
        echo json_encode(['code' => 422, 'errorField' => 'is_hod', 'errorDiv' => 'errorMessageIsHOD', 'errorMessage' => 'You selected an invalid value of Department Head']);
    } else {
        $company_id = $_SESSION['company_id'];
        $branch_id = $_SESSION['branch_id'];
        $user_id = $_SESSION['user_id'];
        $name = $db->real_escape_string(html_entity_decode(stripslashes(strip_tags($name))));
        $is_hod = html_entity_decode(stripslashes(strip_tags($is_hod)));

        $checkExist = mysqli_query($db, "SELECT `id` FROM `designations` WHERE `name`='{$name}' AND `department_id`='{$department_id}' AND `company_id`='{$company_id}' AND `branch_id`='{$branch_id}' AND `id`!='{$id}' AND `deleted_at` IS NULL");
        if (mysqli_num_rows($checkExist) > 0) {
            echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'This Designation already exist.']);
        } else {
            if (!empty($id) && $id > 0) {
                $query = "UPDATE `designations` SET `name`='{$name}',`department_id`='{$department_id}',`is_hod`='{$is_hod}',`sort_by`='{$sort_by}',`updated_by`='{$user_id}' WHERE `company_id`='{$company_id}' AND `branch_id`='{$branch_id}' AND `id`='{$id}'";
                $form_reset = false;
            } else {
                $query = "INSERT INTO `designations`(`id`, `name`, `department_id`, `is_hod`, `sort_by`, `company_id`, `branch_id`, `added_by`) VALUES (NULL, '{$name}', '{$department_id}', '{$is_hod}', '{$sort_by}', '{$company_id}', '{$branch_id}', '{$user_id}')";
                $form_reset = true;
            }

            if (mysqli_query($db, $query)) {
                echo json_encode(["code" => 200, "toasterClass" => 'success', "responseMessage" => 'Record successfully saved.', 'form_reset' => $form_reset]);
            } else {
                echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'Unexpected error.', 'form_reset' => $form_reset]);
            }
        }
    }
}
?>