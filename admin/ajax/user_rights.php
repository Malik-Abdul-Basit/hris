<?php
include_once('../../includes/connection.php');

if (isset($_POST['postData'])) {
    $object = (object)$_POST['postData'];

    $employee_code = $object->employee_code;
    $id = $object->u_id;
    $employee_id = $object->e_id;
    $type = $object->type;
    $status = $object->status;
    $branches = $object->branch_id;
    $user_right_title = $object->user_right_title;

    $type_array = array_values(config('users.type.value'));
    unset($type_array['super_admin']);
    $status_array = array_values(config('users.status.value'));

    if (!hasRight($user_right_title, 'assign_rights') && !hasRight($user_right_title, 'assign_multi_rights')) {
        echo json_encode(["code" => 405, "toasterClass" => 'warning', "responseMessage" => 'Sorry! You have no right to assign user rights.']);
    } else if (empty($employee_code)) {
        echo json_encode(['code' => 422, 'errorField' => 'employee_code', 'errorDiv' => 'errorMessageEmployeeCode', 'errorMessage' => 'Employee Code field is required.']);
    } else if (!is_numeric($employee_code) || $employee_code < 1 || strlen($employee_code) > 20) {
        echo json_encode(['code' => 422, 'errorField' => 'employee_code', 'errorDiv' => 'errorMessageEmployeeCode', 'errorMessage' => 'Please type a valid Employee Code.']);
    } else if (empty($type)) {
        echo json_encode(['code' => 422, 'errorField' => 'type', 'errorDiv' => 'errorMessageType', 'errorMessage' => 'Roles field is required.']);
    } else if (!in_array($type, $type_array) || !is_numeric($type) || $type < 1 || strlen($type) > 2) {
        echo json_encode(['code' => 422, 'errorField' => 'type', 'errorDiv' => 'errorMessageType', 'errorMessage' => 'Please select a valid option of Role.']);
    } else if ($status == '') {
        echo json_encode(['code' => 422, 'errorField' => 'status', 'errorDiv' => 'errorMessageStatus', 'errorMessage' => 'Status field is required.']);
    } else if (!in_array($status, $status_array) || !is_numeric($status) || $status < 0 || strlen($status) > 2) {
        echo json_encode(['code' => 422, 'errorField' => 'status', 'errorDiv' => 'errorMessageStatus', 'errorMessage' => 'Please select a valid option of Status.']);
    } else if (empty($branches)) {
        echo json_encode(['code' => 422, 'errorField' => 'branch_id', 'errorDiv' => 'errorMessageBranch', 'errorMessage' => 'Branch is required.']);
    } else if (!is_array($branches) || count($branches) < 1) {
        echo json_encode(['code' => 422, 'errorField' => 'branch_id', 'errorDiv' => 'errorMessageBranch', 'errorMessage' => 'Please select a valid option of Branch.']);
    } else {
        $user_id = $_SESSION['user_id'];
        $company_id = $_SESSION['company_id'];
        $update = "UPDATE `users` SET `status`='{$status}', `type`='{$type}', `updated_by`='{$user_id}' WHERE `id`='{$id}' AND `employee_id`='{$employee_id}'";
        if (mysqli_query($db, $update)) {
            if (isset($object->data) && !empty($object->data) && is_array($object->data) && sizeof($object->data) > 0) {
                foreach ($branches as $branch_id) {
                    mysqli_query($db, "DELETE FROM `user_rights` WHERE `user_id`='{$id}' AND `company_id`='{$company_id}' AND `branch_id`='{$branch_id}'");
                    foreach ($object->data as $data) {
                        $insert = "INSERT INTO `user_rights`(`id`, `user_id`, `main_menu_id`, `sub_menu_id`, `child_menu_id`, `action`, `company_id`, `branch_id`, `added_by`) VALUES (NULL, '{$id}', '{$data['main_menu_id']}', '{$data['sub_menu_id']}', '{$data['child_menu_id']}', '{$data['action']}', '{$company_id}', '{$branch_id}', '{$user_id}')";
                        mysqli_query($db, $insert);
                    }
                }
                echo json_encode(["code" => 200, "toasterClass" => 'success', "responseMessage" => 'Record successfully saved.']);
            } else {
                echo json_encode(["code" => 200, "toasterClass" => 'success', "responseMessage" => 'Record successfully saved.']);
            }
        } else {
            echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'Unexpected error.']);
        }

    }


}
?>