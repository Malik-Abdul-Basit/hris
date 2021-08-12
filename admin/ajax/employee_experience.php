<?php
include_once('../../includes/connection.php');

if (isset($_POST['postData'])) {

    $object = (object)$_POST['postData'];
    $employee_code = $object->employee_code;
    $user_right_title = $object->user_right_title;

    if (empty($employee_code)) {
        echo json_encode(['code' => 422, 'errorField' => 'employee_code', 'errorDiv' => 'errorMessageEmployeeCode', 'errorMessage' => 'Employee Code field is required.']);
    } else if (!is_numeric($employee_code) || strlen($employee_code) > 20) {
        echo json_encode(['code' => 422, 'errorField' => 'employee_code', 'errorDiv' => 'errorMessageEmployeeCode', 'errorMessage' => 'Invalid Employee Code.']);
    } else if (empty($object->data) || sizeof($object->data) < 1) {
        echo json_encode(['code' => 405, "toasterClass" => 'error', 'responseMessage' => 'Please provide at least one qualification information.']);
    } else {
        $continueProcessing = false;
        $message = '';
        foreach ($object->data as $row => $data) {
            $row++;
            if (empty($data['company_name'])) {
                $message = 'Company Name field is required, At line no ' . $row;
                $continueProcessing = false;
                break;
            } else if (!validName($data['company_name'])) {
                $message = 'Special Characters are not Allowed in Company Name field, At line no ' . $row;
                $continueProcessing = false;
                break;
            } else if (empty($data['designation'])) {
                $message = 'Designation field is required, At line no ' . $row;
                $continueProcessing = false;
                break;
            } else if (!validName($data['designation'])) {
                $message = 'Special Characters are not Allowed in Designation field, At line no ' . $row;
                $continueProcessing = false;
                break;
            } else if (empty($data['date_of_joining'])) {
                $message = 'Date of Joining field is required, At line no ' . $row;
                $continueProcessing = false;
                break;
            } else if (!validDate($data['date_of_joining']) || strlen($data['date_of_joining']) !== 10) {
                $message = 'Please select a valid date of joining, At line no ' . $row;
                $continueProcessing = false;
                break;
            } else if (strtotime($data['date_of_joining']) >= strtotime(date("d-m-Y"))) {
                $message = 'Your Joining date must be before Current date, At line no ' . $row;
                $continueProcessing = false;
                break;
            } else if (empty($data['date_of_resigning'])) {
                $message = 'Date of Resigning field is required, At line no ' . $row;
                $continueProcessing = false;
                break;
            } else if (!validDate($data['date_of_resigning']) || strlen($data['date_of_resigning']) !== 10) {
                $message = 'Please select a valid date of resigning, At line no ' . $row;
                $continueProcessing = false;
                break;
            } else if (strtotime($data['date_of_resigning']) >= strtotime(date("d-m-Y"))) {
                $message = 'Your Resigning date must be before Current date, At line no ' . $row;
                $continueProcessing = false;
                break;
            } else if (strtotime($data['date_of_resigning']) <= strtotime($data['date_of_joining'])) {
                $message = 'Your Resigning date must be after Joining date, At line no ' . $row;
                $continueProcessing = false;
                break;
            } else if (empty($data['reason_of_leaving'])) {
                $message = 'Reason of leaving field is required, At line no ' . $row;
                $continueProcessing = false;
                break;
            } else if (!validAddress($data['reason_of_leaving'])) {
                $message = 'Special characters are not allowed in "Reason of leaving" field , At line no ' . $row;
                $continueProcessing = false;
                break;
            } else {
                $continueProcessing = true;
            }
        }

        if ($continueProcessing === false) {
            echo json_encode(['code' => 405, "toasterClass" => 'error', 'responseMessage' => $message]);
        } else {
            $company_id = $_SESSION['company_id'];
            $branch_id = $_SESSION['branch_id'];
            $user_id = $_SESSION['user_id'];

            $select = "SELECT `id` FROM `employees` WHERE `employee_code`='{$employee_code}' AND `company_id`='{$company_id}' AND `branch_id`='{$branch_id}' AND `deleted_at` IS NULL";
            $query = mysqli_query($db, $select);
            if (mysqli_num_rows($query) > 0) {
                $result = mysqli_fetch_object($query);
                $employee_id = html_entity_decode(stripslashes($result->id));
                $sel = "SELECT `added_by` FROM `employee_experience_infos` WHERE `employee_id` = '{$employee_id}'";
                $sql = mysqli_query($db, $sel);

                if (mysqli_num_rows($sql) > 0) {
                    if (hasRight($user_right_title, 'edit')) {
                        $res = mysqli_fetch_object($sql);
                        $added_by = html_entity_decode(stripslashes($res->added_by));
                        $updated_by = $user_id;
                        mysqli_query($db, "DELETE FROM `employee_experience_infos` WHERE `employee_id` = '{$employee_id}'");
                        foreach ($object->data as $row => $data) {
                            $company_name = html_entity_decode(stripslashes(strip_tags($data["company_name"])));
                            $designation = html_entity_decode(stripslashes(strip_tags($data["designation"])));
                            $date_of_joining = html_entity_decode(stripslashes(strip_tags(date('Y-m-d', strtotime($data["date_of_joining"])))));
                            $date_of_resigning = html_entity_decode(stripslashes(strip_tags(date('Y-m-d', strtotime($data["date_of_resigning"])))));
                            $reason_of_leaving = $db->real_escape_string(html_entity_decode(stripslashes(strip_tags($data["reason_of_leaving"]))));

                            $insert = "INSERT INTO `employee_experience_infos`(`id`, `employee_id`, `company_name`, `designation`, `date_of_joining`, `date_of_resigning`, `reason_of_leaving`, `added_by`, `updated_by`) VALUES (NULL,'{$employee_id}','{$company_name}','{$designation}','{$date_of_joining}','{$date_of_resigning}','{$reason_of_leaving}','{$added_by}','{$updated_by}')";
                            if (mysqli_query($db, $insert)) {
                                $insert_true = true;
                            } else {
                                $insert_true = false;
                            }
                        }
                        if ($insert_true) {
                            echo json_encode(['code' => 200, "toasterClass" => 'success', 'responseMessage' => 'Record successfully saved.', 'employee_id' => $employee_id]);
                        } else {
                            echo json_encode(['code' => 405, "toasterClass" => 'error', 'responseMessage' => 'Unexpected error.']);
                        }
                    } else {
                        echo json_encode(["code" => 405, "toasterClass" => 'warning', "responseMessage" => 'Sorry! You have no right to update record.']);
                    }
                } else {
                    if (hasRight($user_right_title, 'add')) {
                        $added_by = $user_id;
                        $updated_by = NULL;
                        foreach ($object->data as $row => $data) {
                            $company_name = html_entity_decode(stripslashes(strip_tags($data["company_name"])));
                            $designation = html_entity_decode(stripslashes(strip_tags($data["designation"])));
                            $date_of_joining = html_entity_decode(stripslashes(strip_tags(date('Y-m-d', strtotime($data["date_of_joining"])))));
                            $date_of_resigning = html_entity_decode(stripslashes(strip_tags(date('Y-m-d', strtotime($data["date_of_resigning"])))));
                            $reason_of_leaving = $db->real_escape_string(html_entity_decode(stripslashes(strip_tags($data["reason_of_leaving"]))));

                            $insert = "INSERT INTO `employee_experience_infos`(`id`, `employee_id`, `company_name`, `designation`, `date_of_joining`, `date_of_resigning`, `reason_of_leaving`, `added_by`, `updated_by`) VALUES (NULL,'{$employee_id}','{$company_name}','{$designation}','{$date_of_joining}','{$date_of_resigning}','{$reason_of_leaving}','{$added_by}','{$updated_by}')";
                            if (mysqli_query($db, $insert)) {
                                $insert_true = true;
                            } else {
                                $insert_true = false;
                            }
                        }
                        if ($insert_true) {
                            echo json_encode(['code' => 200, "toasterClass" => 'success', 'responseMessage' => 'Record successfully saved.', 'employee_id' => $employee_id]);
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
}
?>