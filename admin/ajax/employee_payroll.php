<?php
include_once('../../includes/connection.php');

if (isset($_POST['postData'])) {
    $object = (object)$_POST['postData'];

    $employee_code = $object->employee_code;
    $joining_date = $object->joining_date;
    $contract_start_date = $object->contract_start_date;
    $contract_end_date = $object->contract_end_date;
    $leaving_date = $object->leaving_date;
    $ntn = $object->ntn;
    $eobi_no = $object->eobi_no;
    $pf_no = $object->pf_no;
    $salary = $object->salary;
    $pf = $object->pf;
    $eobi = $object->eobi;
    $special_allowences = $object->special_allowences;
    $reimburse_value = $object->reimburse_value;
    $deduct_pf = $object->deduct_pf;
    $deduct_eobi = $object->deduct_eobi;
    $deduct_tax = $object->deduct_tax;
    $user_right_title = $object->user_right_title;

    if (empty($employee_code)) {
        echo json_encode(['code' => 422, 'errorField' => 'employee_code', 'errorDiv' => 'errorMessageEmployeeCode', 'errorMessage' => 'Employee Code field is required.']);
    } else if (!is_numeric($employee_code) || strlen($employee_code) > 20) {
        echo json_encode(['code' => 422, 'errorField' => 'employee_code', 'errorDiv' => 'errorMessageEmployeeCode', 'errorMessage' => 'Invalid Employee Code.']);
    } else if (empty($joining_date)) {
        echo json_encode(['code' => 422, 'errorField' => 'joining_date', 'errorDiv' => 'errorMessageJoiningDate', 'errorMessage' => 'Joining Date field is required.']);
    } else if (!validDate($joining_date) || strlen($joining_date) != 10) {
        echo json_encode(['code' => 422, 'errorField' => 'joining_date', 'errorDiv' => 'errorMessageJoiningDate', 'errorMessage' => 'Please select a valid date.']);
    } else if (!empty($contract_start_date) && (!validDate($contract_start_date) || strlen($contract_start_date) != 10)) {
        echo json_encode(['code' => 422, 'errorField' => 'contract_start_date', 'errorDiv' => 'errorMessageContractStartDate', 'errorMessage' => 'Please select a valid date.']);
    } else if (!empty($contract_end_date) && (!validDate($contract_end_date) || strlen($contract_end_date) != 10)) {
        echo json_encode(['code' => 422, 'errorField' => 'contract_end_date', 'errorDiv' => 'errorMessageContractEndDate', 'errorMessage' => 'Please select a valid date.']);
    } else if (!empty($contract_end_date) && empty($contract_start_date)) {
        echo json_encode(['code' => 422, 'errorField' => 'contract_start_date', 'errorDiv' => 'errorMessageContractStartDate', 'errorMessage' => 'If you select "Contract End Date" then "Contract Start Date" field is required.']);
    } else if (!empty($contract_start_date) && empty($contract_end_date)) {
        echo json_encode(['code' => 422, 'errorField' => 'contract_end_date', 'errorDiv' => 'errorMessageContractEndDate', 'errorMessage' => 'If you select "Contract Start Date" then "Contract End Date" field is required.']);
    } else if (!empty($contract_start_date) && !empty($contract_end_date) && (strtotime($contract_end_date) <= strtotime($contract_start_date))) {
        echo json_encode(['code' => 422, 'errorField' => 'contract_end_date', 'errorDiv' => 'errorMessageContractEndDate', 'errorMessage' => 'Contract End Date must be after Contract Start Date.']);
    } else if (!empty($leaving_date) && (!validDate($leaving_date) || strlen($leaving_date) != 10)) {
        echo json_encode(['code' => 422, 'errorField' => 'leaving_date', 'errorDiv' => 'errorMessageLeavingDate', 'errorMessage' => 'Please select a valid date.']);
    } else if (!empty($joining_date) && !empty($leaving_date) && (strtotime($leaving_date) <= strtotime($joining_date))) {
        echo json_encode(['code' => 422, 'errorField' => 'leaving_date', 'errorDiv' => 'errorMessageLeavingDate', 'errorMessage' => 'Leaving Date must be after Joining Date.']);
    } else if (!empty($ntn) && (!is_numeric($ntn) || strlen($ntn) > 9)) {
        echo json_encode(['code' => 422, 'errorField' => 'ntn', 'errorDiv' => 'errorMessageNTN', 'errorMessage' => 'Invalid National Tax Number.']);
    } else if (!empty($eobi_no) && (!is_numeric($eobi_no) || strlen($eobi_no) > 9)) {
        echo json_encode(['code' => 422, 'errorField' => 'eobi_no', 'errorDiv' => 'errorMessageEOBINo', 'errorMessage' => 'Invalid Employees Old-Age Benefits Institution Number.']);
    } else if (!empty($pf_no) && (!is_numeric($pf_no) || strlen($pf_no) > 9)) {
        echo json_encode(['code' => 422, 'errorField' => 'pf_no', 'errorDiv' => 'errorMessagePFNo', 'errorMessage' => 'Invalid Provident Fund Number.']);
    } else if (empty($salary)) {
        echo json_encode(['code' => 422, 'errorField' => 'salary', 'errorDiv' => 'errorMessageSalary', 'errorMessage' => 'Salary field is required.']);
    } else if (!is_numeric($salary) || strlen($salary) > 9) {
        echo json_encode(['code' => 422, 'errorField' => 'salary', 'errorDiv' => 'errorMessageSalary', 'errorMessage' => 'Invalid amount of Salary.']);
    } else if (!empty($pf) && (!is_numeric($pf) || strlen($pf) > 9)) {
        echo json_encode(['code' => 422, 'errorField' => 'pf', 'errorDiv' => 'errorMessagePF', 'errorMessage' => 'Invalid amount of Provident Fund.']);
    } else if (!empty($eobi) && (!is_numeric($eobi) || strlen($eobi) > 9)) {
        echo json_encode(['code' => 422, 'errorField' => 'eobi', 'errorDiv' => 'errorMessageEOBI', 'errorMessage' => 'Invalid amount of Employees Old-Age Benefits Institution.']);
    } else if (!empty($special_allowences) && (!is_numeric($special_allowences) || strlen($special_allowences) > 9)) {
        echo json_encode(['code' => 422, 'errorField' => 'special_allowences', 'errorDiv' => 'errorMessageSpecialAllowences', 'errorMessage' => 'Invalid amount of Special Allowences.']);
    } else if (!empty($reimburse_value) && (!is_numeric($reimburse_value) || strlen($reimburse_value) > 9)) {
        echo json_encode(['code' => 422, 'errorField' => 'reimburse_value', 'errorDiv' => 'errorMessageReimburseValue', 'errorMessage' => 'Invalid amount of Reimburse Value.']);
    } else if (!empty($deduct_pf) && (!is_numeric($deduct_pf) || strlen($deduct_pf) > 9)) {
        echo json_encode(['code' => 422, 'errorField' => 'deduct_pf', 'errorDiv' => 'errorMessageDeductPF', 'errorMessage' => 'Invalid amount of Provident Fund.']);
    } else if (!empty($deduct_eobi) && (!is_numeric($deduct_eobi) || strlen($deduct_eobi) > 9)) {
        echo json_encode(['code' => 422, 'errorField' => 'deduct_eobi', 'errorDiv' => 'errorMessageDeductEOBI', 'errorMessage' => 'Invalid amount of Employees Old-Age Benefits Institution.']);
    } else if (!empty($deduct_tax) && (!is_numeric($deduct_tax) || strlen($deduct_tax) > 9)) {
        echo json_encode(['code' => 422, 'errorField' => 'deduct_tax', 'errorDiv' => 'errorMessageTaxRate', 'errorMessage' => 'Invalid amount of Tax.']);
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
            $joining_date = html_entity_decode(stripslashes(strip_tags(date('Y-m-d', strtotime($joining_date)))));
            $contract_start_date = empty($contract_start_date) ? NULL : html_entity_decode(stripslashes(strip_tags(date('Y-m-d', strtotime($contract_start_date)))));
            $contract_end_date = empty($contract_end_date) ? NULL : html_entity_decode(stripslashes(strip_tags(date('Y-m-d', strtotime($contract_end_date)))));
            $leaving_date = empty($leaving_date) ? NULL : html_entity_decode(stripslashes(strip_tags(date('Y-m-d', strtotime($leaving_date)))));
            $ntn = html_entity_decode(stripslashes(strip_tags($ntn)));
            $eobi_no = html_entity_decode(stripslashes(strip_tags($eobi_no)));
            $pf_no = html_entity_decode(stripslashes(strip_tags($pf_no)));
            $salary = encode(html_entity_decode(stripslashes(strip_tags($salary))));
            $pf = html_entity_decode(stripslashes(strip_tags($pf)));
            $eobi = html_entity_decode(stripslashes(strip_tags($eobi)));
            $special_allowences = html_entity_decode(stripslashes(strip_tags($special_allowences)));
            $reimburse_value = html_entity_decode(stripslashes(strip_tags($reimburse_value)));
            $deduct_pf = html_entity_decode(stripslashes(strip_tags($deduct_pf)));
            $deduct_eobi = html_entity_decode(stripslashes(strip_tags($deduct_eobi)));
            $deduct_tax = html_entity_decode(stripslashes(strip_tags($deduct_tax)));

            $sql = mysqli_query($db, "SELECT `id` FROM `employee_payrolls` WHERE `employee_id`='{$employee_id}'");

            if (mysqli_num_rows($sql) > 0) {
                if (hasRight($user_right_title, 'edit')) {
                    $query = "UPDATE `employee_payrolls` SET `joining_date`='{$joining_date}',`contract_start_date`='{$contract_start_date}',`contract_end_date`='{$contract_end_date}',`leaving_date`='{$leaving_date}',`ntn`='{$ntn}',`eobi_no`='{$eobi_no}',`pf_no`='{$pf_no}',`salary`='{$salary}',`pf`='{$pf}',`eobi`='{$eobi}',`special_allowences`='{$special_allowences}',`reimburse_value`='{$reimburse_value}',`deduct_pf`='{$deduct_pf}',`deduct_eobi`='{$deduct_eobi}',`deduct_tax`='{$deduct_tax}',`updated_by`='{$user_id}' WHERE `employee_id`='{$employee_id}'";
                    $form_reset = false;
                    if (mysqli_query($db, $query)) {
                        echo json_encode(['code' => 200, "toasterClass" => 'success', 'responseMessage' => 'Record successfully saved.', "form_reset" => $form_reset, 'employee_id' => $employee_id]);
                    } else {
                        echo json_encode(['code' => 405, "toasterClass" => 'error', 'responseMessage' => 'Unexpected error.']);
                    }
                } else {
                    echo json_encode(["code" => 405, "toasterClass" => 'warning', "responseMessage" => 'Sorry! You have no right to update record.']);
                }
            } else {
                if (hasRight($user_right_title, 'add')) {
                    $query = "INSERT INTO `employee_payrolls`(`id`, `employee_id`,`joining_date`,`contract_start_date`,`contract_end_date`,`leaving_date`,`ntn`, `eobi_no`, `pf_no`, `salary`, `pf`, `eobi`, `special_allowences`, `reimburse_value`, `deduct_pf`, `deduct_eobi`, `deduct_tax`, `added_by`) VALUES (NULL,'{$employee_id}','{$joining_date}','{$contract_start_date}','{$contract_end_date}','{$leaving_date}','{$ntn}','{$eobi_no}','{$pf_no}','{$salary}','{$pf}','{$eobi}','{$special_allowences}','{$reimburse_value}','{$deduct_pf}','{$deduct_eobi}','{$deduct_tax}','{$user_id}')";
                    $form_reset = true;
                    if (mysqli_query($db, $query)) {
                        echo json_encode(['code' => 200, "toasterClass" => 'success', 'responseMessage' => 'Record successfully saved.', "form_reset" => $form_reset, 'employee_id' => $employee_id]);
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