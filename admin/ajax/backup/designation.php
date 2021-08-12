<?php
include_once('../../includes/connection.php');

if (isset($_POST['postData'])) {
    $object = (object)$_POST['postData'];

    $id = $object->id;
    $name = $object->name;
    $designation_id = $object->designation_id;
    $department_id = $object->department_id;
    //$salary_grade_id = $object->salary_grade_id;
    //$salary_grade_detail_id = $object->salary_grade_detail_id;

    $salary_grade_id = 1;
    $salary_grade_detail_id = 1;

    $sort_by = $object->sort_by;
    $is_hod = $object->is_hod;

    if (empty($name)) {
        echo json_encode(['code' => 422, 'errorField' => 'name', 'errorDiv' => 'errorMessageName', 'errorMessage' => 'Name field is required.']);
    } else if (!validName($name)) {
        echo json_encode(['code' => 422, 'errorField' => 'name', 'errorDiv' => 'errorMessageName', 'errorMessage' => 'Special Characters are not Allowed.']);
    } else if (strlen($name) > 50) {
        echo json_encode(['code' => 422, 'errorField' => 'name', 'errorDiv' => 'errorMessageName', 'errorMessage' => 'Length should not exceed 50 characters.']);
    } else if (empty($designation_id)) {
        echo json_encode(['code' => 422, 'errorField' => 'designation_id', 'errorDiv' => 'errorMessageDesignation', 'errorMessage' => 'Report to Designation field is required.']);
    } else if (!is_numeric($designation_id) || strlen($designation_id) > 10) {
        echo json_encode(['code' => 422, 'errorField' => 'designation_id', 'errorDiv' => 'errorMessageDesignation', 'errorMessage' => 'Please select a valid option.']);
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
    } else if (empty($salary_grade_id)) {
        echo json_encode(['code' => 422, 'errorField' => 'salary_grade_id', 'errorDiv' => 'errorMessageSalaryGradeId', 'errorMessage' => 'Salary Band field is required.']);
    } else if (!is_numeric($salary_grade_id) || strlen($salary_grade_id) > 10) {
        echo json_encode(['code' => 422, 'errorField' => 'salary_grade_id', 'errorDiv' => 'errorMessageSalaryGradeId', 'errorMessage' => 'Please select a valid option.']);
    } else if (empty($salary_grade_detail_id)) {
        echo json_encode(['code' => 422, 'errorField' => 'salary_grade_detail_id', 'errorDiv' => 'errorMessageSalaryGradeDetailId', 'errorMessage' => 'Salary Grade field is required.']);
    } else if (!is_numeric($salary_grade_detail_id) || strlen($salary_grade_detail_id) > 10) {
        echo json_encode(['code' => 422, 'errorField' => 'salary_grade_detail_id', 'errorDiv' => 'errorMessageSalaryGradeDetailId', 'errorMessage' => 'Please select a valid option.']);
    } else {
        $company_id = $_SESSION['company_id'];
        $branch_id = $_SESSION['branch_id'];
        $user_id = $_SESSION['user_id'];
        $name = $db->real_escape_string(html_entity_decode(stripslashes(strip_tags($name))));
        $designation_id = html_entity_decode(stripslashes(strip_tags($designation_id)));
        $department_id = html_entity_decode(stripslashes(strip_tags($department_id)));
        $sort_by = html_entity_decode(stripslashes(strip_tags($sort_by)));
        $is_hod = html_entity_decode(stripslashes(strip_tags($is_hod)));

        $checkExist = mysqli_query($db, "SELECT `id` FROM `designations` WHERE `name`='{$name}' AND `department_id`='{$department_id}' AND `company_id`='{$company_id}' AND `branch_id`='{$branch_id}' AND `id`!='{$id}'");
        if (mysqli_num_rows($checkExist) > 0) {
            echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'This Designation already exist.']);
        } else {
            if (!empty($id) && $id > 0) {
                $query = "UPDATE `designations` SET `name`='{$name}',`report_to_designation_id`='{$designation_id}',`department_id`='{$department_id}',`salary_grade_id`='{$salary_grade_id}',`salary_grade_detail_id`='{$salary_grade_detail_id}',`is_hod`='{$is_hod}',`sort_by`='{$sort_by}',`updated_by`='{$user_id}' WHERE `company_id`='{$company_id}' AND `branch_id`='{$branch_id}' AND `id`='{$id}'";
                $form_reset = false;
            } else {
                $query = "INSERT INTO `designations`(`id`, `name`, `report_to_designation_id`, `department_id`, `salary_grade_id`, `salary_grade_detail_id`, `is_hod`, `sort_by`, `company_id`, `branch_id`, `added_by`) VALUES (NULL, '{$name}', '{$designation_id}', '{$department_id}', '{$salary_grade_id}', '{$salary_grade_detail_id}', '{$is_hod}', '{$sort_by}', '{$company_id}', '{$branch_id}', '{$user_id}')";
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