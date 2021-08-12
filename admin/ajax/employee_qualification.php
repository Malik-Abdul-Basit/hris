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
        $gradeArray = array_values(config('employee_qualification_infos.grade.value'));
        $statusArray = array_values(config('employee_qualification_infos.status.value'));

        $continueProcessing = false;
        $message = '';
        $min = round(date('Y') - (60));
        $max = date('Y');
        foreach ($object->data as $row => $data) {
            $row++;
            if (empty($data['degree'])) {
                $message = 'Degree field is required, At line no ' . $row;
                $continueProcessing = false;
                break;
            } else if (!validName($data['degree'])) {
                $message = 'Special Characters are not Allowed in Degree field, At line no ' . $row;
                $continueProcessing = false;
                break;
            } else if (empty($data['institute'])) {
                $message = 'Institute field is required, At line no ' . $row;
                $continueProcessing = false;
                break;
            } else if (!validName($data['institute'])) {
                $message = 'Special Characters are not Allowed in Institute field, At line no ' . $row;
                $continueProcessing = false;
                break;
            } else if (strlen($data['institute']) > 70) {
                $message = 'Length should not exceed 70 characters, At line no ' . $row;
                $continueProcessing = false;
                break;
            } else if (empty($data['date_of_completion'])) {
                $message = 'Year of Completion field is required, At line no ' . $row;
                $continueProcessing = false;
                break;
            } else if ($data['date_of_completion'] < $min || $data['date_of_completion'] > $max) {
                $message = 'Given Year of Completion is invalid, At line no ' . $row;
                $continueProcessing = false;
                break;
            } /*else if (!validDate($data['date_of_completion']) || strlen($data['date_of_completion']) !== 10) {
                $message = 'Please select a valid date, At line no ' . $row;
                $continueProcessing = false;
                break;
            } else if (empty($data['total_marks'])) {
                $message = 'Total Marks field is required, At line no ' . $row;
                $continueProcessing = false;
                break;
            }*/ else if ($data['total_marks'] != '' && (!is_numeric($data['total_marks']) || strlen($data['total_marks']) > 5)) {
                $message = 'Please type valid Total Marks, At line no ' . $row;
                $continueProcessing = false;
                break;
            } else if (!empty($data['obtaining_marks']) && is_numeric($data['obtaining_marks']) && $data['total_marks'] == '') {
                $message = 'Total Marks field is required, At line no ' . $row;
                $continueProcessing = false;
                break;
            } /*else if (empty($data['obtaining_marks'])) {
                $message = 'Obtaining Marks field is required, At line no ' . $row;
                $continueProcessing = false;
                break;
            }*/ else if ($data['obtaining_marks'] != '' && (!is_numeric($data['obtaining_marks']) || strlen($data['obtaining_marks']) > 5)) {
                $message = 'Please type valid Obtaining Marks, At line no ' . $row;
                $continueProcessing = false;
                break;
            } else if (!empty($data['total_marks']) && is_numeric($data['total_marks']) && $data['obtaining_marks'] == '') {
                $message = 'Total Marks field is required, At line no ' . $row;
                $continueProcessing = false;
                break;
            } else if (round($data['obtaining_marks']) > round($data['total_marks'])) {
                $message = "Obtaining Marks shouldn't be greater than Total Marks, At line no " . $row;
                $continueProcessing = false;
                break;
            } /*else if (empty($data['grade'])) {
                $message = 'Grade field is required, At line no ' . $row;
                $continueProcessing = false;
                break;
            }*/ else if (!empty($data['grade']) && (!in_array($data['grade'], $gradeArray) || strlen($data['grade']) > 2)) {
                $message = 'Please select a valid Grade, At line no ' . $row;
                $continueProcessing = false;
                break;
            } else if (empty($data['status'])) {
                $message = 'Status field is required, At line no ' . $row;
                $continueProcessing = false;
                break;
            } else if (!in_array($data['status'], $statusArray) || strlen($data['status']) !== 1) {
                $message = 'Please select a valid Status, At line no ' . $row;
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
                $sel = "SELECT `added_by` FROM `employee_qualification_infos` WHERE `employee_id` = '{$employee_id}'";
                $sql = mysqli_query($db, $sel);
                
                if (mysqli_num_rows($sql) > 0) {
                    if (hasRight($user_right_title, 'edit')) {
                        $res = mysqli_fetch_object($sql);
                        $added_by = html_entity_decode(stripslashes($res->added_by));
                        $updated_by = $user_id;
                        mysqli_query($db, "DELETE FROM `employee_qualification_infos` WHERE `employee_id` = '{$employee_id}'");
                        foreach ($object->data as $row => $data) {
                            $date_of_completion = $data["date_of_completion"] . '-01-01';
                            $degree = html_entity_decode(stripslashes(strip_tags($data["degree"])));
                            $institute = html_entity_decode(stripslashes(strip_tags($data["institute"])));
                            $date_of_completion = html_entity_decode(stripslashes(strip_tags(date('Y-m-d', strtotime($date_of_completion)))));
                            $total_marks = html_entity_decode(stripslashes(strip_tags($data["total_marks"])));
                            $obtaining_marks = html_entity_decode(stripslashes(strip_tags($data["obtaining_marks"])));
                            $grade = html_entity_decode(stripslashes(strip_tags($data["grade"])));
                            $status = html_entity_decode(stripslashes(strip_tags($data["status"])));

                            $insert = "INSERT INTO `employee_qualification_infos`(`id`, `employee_id`, `degree`, `institute`, `date_of_completion`, `total_marks`, `obtaining_marks`, `grade`, `status`, `added_by`, `updated_by`) VALUES (NULL,'{$employee_id}','{$degree}','{$institute}','{$date_of_completion}','{$total_marks}','{$obtaining_marks}','{$grade}','{$status}','{$added_by}','{$updated_by}')";
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
                            $date_of_completion = $data["date_of_completion"] . '-01-01';
                            $degree = html_entity_decode(stripslashes(strip_tags($data["degree"])));
                            $institute = html_entity_decode(stripslashes(strip_tags($data["institute"])));
                            $date_of_completion = html_entity_decode(stripslashes(strip_tags(date('Y-m-d', strtotime($date_of_completion)))));
                            $total_marks = html_entity_decode(stripslashes(strip_tags($data["total_marks"])));
                            $obtaining_marks = html_entity_decode(stripslashes(strip_tags($data["obtaining_marks"])));
                            $grade = html_entity_decode(stripslashes(strip_tags($data["grade"])));
                            $status = html_entity_decode(stripslashes(strip_tags($data["status"])));

                            $insert = "INSERT INTO `employee_qualification_infos`(`id`, `employee_id`, `degree`, `institute`, `date_of_completion`, `total_marks`, `obtaining_marks`, `grade`, `status`, `added_by`, `updated_by`) VALUES (NULL,'{$employee_id}','{$degree}','{$institute}','{$date_of_completion}','{$total_marks}','{$obtaining_marks}','{$grade}','{$status}','{$added_by}','{$updated_by}')";
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