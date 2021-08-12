<?php
include_once('../../includes/connection.php');

if (isset($_POST['postData'])) {
    $object = (object)$_POST['postData'];

    $id = $object->id;
    $name = $object->name;
    $status = $object->status;
    $user_right_title = $object->user_right_title;

    $status_array = array_values(config('companies.status.value'));

    if ((empty($id) || $id == 0) && (!hasRight($user_right_title, 'add'))) {
        echo json_encode(["code" => 405, "toasterClass" => 'warning', "responseMessage" => 'Sorry! You have no right to add record.']);
    } else if (!empty($id) && is_numeric($id) && $id > 0 && !hasRight($user_right_title, 'edit')) {
        echo json_encode(["code" => 405, "toasterClass" => 'warning', "responseMessage" => 'Sorry! You have no right to update record.']);
    } else if (empty($name)) {
        echo json_encode(['code' => 422, 'errorField' => 'name', 'errorDiv' => 'errorMessageName', 'errorMessage' => 'Name field is required.']);
    } else if (!validName($name)) {
        echo json_encode(['code' => 422, 'errorField' => 'name', 'errorDiv' => 'errorMessageName', 'errorMessage' => 'Special characters not allowed.']);
    } else if (strlen($name) > 50) {
        echo json_encode(['code' => 422, 'errorField' => 'name', 'errorDiv' => 'errorMessageName', 'errorMessage' => 'Length should not exceed 50 characters.']);
    } else if ($status == '') {
        echo json_encode(['code' => 422, 'errorField' => 'status', 'errorDiv' => 'errorMessageStatus', 'errorMessage' => 'Status field is required.']);
    } else if (!in_array($status, $status_array) || strlen($status) > 2) {
        echo json_encode(['code' => 422, 'errorField' => 'status', 'errorDiv' => 'errorMessageStatus', 'errorMessage' => 'Please select a valid option.']);
    } else {
        $user_id = $_SESSION['user_id'];
        $name = $db -> real_escape_string(html_entity_decode(stripslashes(strip_tags($name))));

        $checkExist = mysqli_query($db, "SELECT `id` FROM `companies` WHERE `name`='{$name}' AND `id`!='{$id}' AND `deleted_at` IS NULL");
        if (mysqli_num_rows($checkExist) > 0) {
            echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'This Company already exist.']);
        } else {
            $status = html_entity_decode(stripslashes(strip_tags($status)));
            if (!empty($id) && $id > 0) {
                $query = "UPDATE `companies` SET `name`='{$name}',`status`='{$status}',`updated_by`='{$user_id}' WHERE `id`='{$id}'";
                $form_reset = false;
            } else {
                $query = "INSERT INTO `companies`(`id`, `name`, `status`, `image_name`, `added_by`) VALUES (NULL, '{$name}', '{$status}', '{$status}', '{$user_id}')";
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