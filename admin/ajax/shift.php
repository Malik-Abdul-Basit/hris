<?php
include_once('../../includes/connection.php');

if (isset($_POST['postData'])) {
    $object = (object)$_POST['postData'];

    $id = $object->id;
    $name = $object->name;
    $from = $object->from;
    $to = $object->to;
    $sort_by = $object->sort_by;
    $user_right_title = $object->user_right_title;

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
    } else if (empty($from)) {
        echo json_encode(['code' => 422, 'errorField' => 'shift_from', 'errorDiv' => 'errorMessageFrom', 'errorMessage' => 'From field is required.']);
    } else if (!validTime12($from) || strlen($from) != 8) {
        echo json_encode(['code' => 422, 'errorField' => 'shift_from', 'errorDiv' => 'errorMessageFrom', 'errorMessage' => 'Please select a valid Time.']);
    } else if (empty($to)) {
        echo json_encode(['code' => 422, 'errorField' => 'shift_to', 'errorDiv' => 'errorMessageTo', 'errorMessage' => 'To field is required.']);
    } else if (!validTime12($to) || strlen($to) != 8) {
        echo json_encode(['code' => 422, 'errorField' => 'shift_to', 'errorDiv' => 'errorMessageTo', 'errorMessage' => 'Please select a valid Time.']);
    } else if (empty($sort_by)) {
        echo json_encode(['code' => 422, 'errorField' => 'sort_by', 'errorDiv' => 'errorMessageSortBy', 'errorMessage' => 'Sort By field is required.']);
    } else if (!is_numeric($sort_by)) {
        echo json_encode(['code' => 422, 'errorField' => 'sort_by', 'errorDiv' => 'errorMessageSortBy', 'errorMessage' => 'Sort By field should contain only numeric.']);
    } else if (strlen($sort_by) > 9) {
        echo json_encode(['code' => 422, 'errorField' => 'sort_by', 'errorDiv' => 'errorMessageSortBy', 'errorMessage' => 'Length should not exceed 9 characters.']);
    } else {
        $company_id = $_SESSION['company_id'];
        $branch_id = $_SESSION['branch_id'];
        $user_id = $_SESSION['user_id'];

        $name = $db->real_escape_string(html_entity_decode(stripslashes(strip_tags($name))));
        $sort_by = html_entity_decode(stripslashes(strip_tags($sort_by)));
        $from = date('H:i:s', strtotime($from));
        $to = date('H:i:s', strtotime($to));

        $checkExist = mysqli_query($db, "SELECT `id` FROM `shifts` WHERE `from`='{$from}' AND `to`='{$to}' AND `company_id`='{$company_id}' AND `branch_id`='{$branch_id}' AND `id`!='{$id}' AND `deleted_at` IS NULL");
        if (mysqli_num_rows($checkExist) > 0) {
            echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'This Shift already exist.']);
        } else {
            if (!empty($id) && $id > 0) {
                $query = "UPDATE `shifts` SET `name`='{$name}',`from`='{$from}',`to`='{$to}',`sort_by`='{$sort_by}',`updated_by`='{$user_id}' WHERE `id`='{$id}'";
                $form_reset = false;
            } else {
                $query = "INSERT INTO `shifts`(`id`, `name`, `from`, `to`, `sort_by`, `company_id`, `branch_id`, `added_by`) VALUES (NULL, '{$name}', '{$from}', '{$to}', '{$sort_by}', '{$company_id}', '{$branch_id}', '{$user_id}')";
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