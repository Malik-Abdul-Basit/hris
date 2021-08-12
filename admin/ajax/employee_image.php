<?php
include_once('../../includes/connection.php');

if (isset($_POST['postData'])) {
    $object = (object)$_POST['postData'];
    $imageBase64 = $data = $object->imageBase64;
    $employee_code = $object->employee_code;
    $user_right_title = $object->user_right_title;

    if (empty($employee_code)) {
        echo json_encode(['code' => 422, 'errorField' => 'employee_code', 'errorDiv' => 'errorMessageEmployeeCode', 'errorMessage' => 'Employee Code field is required.']);
    } else if (!is_numeric($employee_code) || strlen($employee_code) > 20) {
        echo json_encode(['code' => 422, 'errorField' => 'employee_code', 'errorDiv' => 'errorMessageEmployeeCode', 'errorMessage' => 'Invalid Employee Code.']);
    } else {
        $company_id = $_SESSION['company_id'];
        $branch_id = $_SESSION['branch_id'];
        $user_id = $_SESSION['user_id'];

        $select = "SELECT `id` FROM `employees` WHERE `employee_code`='{$employee_code}' AND `company_id`='{$company_id}' AND `branch_id`='{$branch_id}' AND `deleted_at` IS NULL";
        $query = mysqli_query($db, $select);
        if (mysqli_num_rows($query) > 0) {
            $result = mysqli_fetch_object($query);

            $employee_id = html_entity_decode(stripslashes($result->id));
            $employee_code = html_entity_decode(stripslashes(strip_tags($employee_code)));

            list($type, $imageBase64) = explode(';', $imageBase64);
            list(, $imageBase64) = explode(',', $imageBase64);

            $image = base64_decode($imageBase64);
            $imageName = $employee_code . '_' . generatePassword('35', TRUE) . '.png';

            $sql = mysqli_query($db, "SELECT `id`,`name` FROM `employee_images` WHERE `employee_id`='{$employee_id}' AND `deleted_at` IS NULL ORDER BY `id` ASC LIMIT 1");

            if (mysqli_num_rows($sql) > 0) {
                if (hasRight($user_right_title, 'edit')) {
                    $res = mysqli_fetch_object($sql);
                    if (!empty($res->name) && file_exists('../../storage/emp_images/' . $res->name)) {
                        unlink('../../storage/emp_images/' . $res->name);
                    }
                    $query = "UPDATE `employee_images` SET `name`='{$imageName}',`updated_by`='{$user_id}' WHERE `employee_id`='{$employee_id}'";
                    $form_reset = false;
                    if (mysqli_query($db, $query)) {
                        file_put_contents('../../storage/emp_images/' . $imageName, $image);
                        echo json_encode(["code" => 200, "toasterClass" => 'success', "responseMessage" => 'Record successfully saved.', "form_reset" => $form_reset]);
                    } else {
                        echo json_encode(['code' => 405, "toasterClass" => 'error', 'responseMessage' => 'Unexpected error.']);
                    }
                } else {
                    echo json_encode(["code" => 405, "toasterClass" => 'warning', "responseMessage" => 'Sorry! You have no right to update record.']);
                }
            } else {
                if (hasRight($user_right_title, 'add')) {
                    $query = "INSERT INTO `employee_images`(`id`, `employee_id`, `name`, `added_by`) VALUES (NULL,'{$employee_id}','{$imageName}','{$user_id}')";
                    $form_reset = false;
                    if (mysqli_query($db, $query)) {
                        file_put_contents('../../storage/emp_images/' . $imageName, $image);
                        echo json_encode(["code" => 200, "toasterClass" => 'success', "responseMessage" => 'Record successfully saved.', "form_reset" => $form_reset]);
                    } else {
                        echo json_encode(['code' => 405, "toasterClass" => 'error', 'responseMessage' => 'Unexpected error.']);
                    }
                } else {
                    echo json_encode(["code" => 405, "toasterClass" => 'warning', "responseMessage" => 'Sorry! You have no right to add record.']);
                }
            }
        } else {
            echo json_encode(['code' => 405, "toasterClass" => 'error', 'responseMessage' => 'Employee not found with ' . $employee_code . ' employee code.']);
        }
    }

}
?>