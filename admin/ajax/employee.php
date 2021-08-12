<?php
include_once('../../includes/connection.php');

if (isset($_POST['postData'])) {
    $object = (object)$_POST['postData'];

    $id = $object->id;
    $employee_code = $object->employee_code;
    $department_id = $object->department_id;
    $team_id = $object->team_id;
    $designation_id = $object->designation_id;
    $shift_id = $object->shift_id;
    $evaluation_type_id = $object->evaluation_type_id;
    $status = $object->status;
    $title = $object->title;
    $first_name = trim($object->first_name);
    $last_name = trim($object->last_name);
    $pseudo_name = trim($object->pseudo_name);
    $father_name = trim($object->father_name);
    $email = $object->email;
    $official_email = $object->official_email;
    $gender = $object->gender;
    $blood_group = $object->blood_group;
    $dob = $object->dob;
    $pob = trim($object->pob);
    $cnic = $object->cnic;
    $cnic_expiry = $object->cnic_expiry;
    $old_cnic = $object->old_cnic;
    $country_id = $object->country_id;
    $state_id = $object->state_id;
    $city_id = $object->city_id;
    $phone = $object->phone;
    $dial_code = $object->dial_code;
    $mobile = $object->mobile;
    $iso = $object->iso;
    $o_dial_code = $object->o_dial_code;
    $other_mobile = $object->other_mobile;
    $o_iso = $object->o_iso;
    $relation = $object->relation;
    $marital_status = $object->marital_status;
    $religion = $object->religion;
    $sect = $object->sect;
    $address = trim($object->address);
    $permanent_address = trim($object->permanent_address);
    $personal_history = trim($object->personal_history);

    $guardian_name = trim($object->guardian_name);
    $guardian_dial_code = $object->guardian_dial_code;
    $guardian_mobile = $object->guardian_mobile;
    $guardian_iso = $object->guardian_iso;
    $guardian_cnic = $object->guardian_cnic;
    $guardian_relation = $object->guardian_relation;

    $joining_date = $object->joining_date;
    $contract_start_date = $object->contract_start_date;
    $contract_end_date = $object->contract_end_date;
    $leaving_date = $object->leaving_date;
    $salary = $object->salary;
    $user_right_title = $object->user_right_title;

    $status_array = array_values(config('employees.status.value'));
    $title_array = array_values(config('employee_basic_infos.title.value'));
    $gender_array = array_values(config('employee_basic_infos.gender.value'));
    $blood_group_array = array_values(config('employee_basic_infos.blood_group.value'));
    $marital_status_array = array_values(config('employee_basic_infos.marital_status.value'));
    $relation_array = array_values(config('employee_basic_infos.relation.value'));

    if ((empty($id) || $id == 0) && (!hasRight($user_right_title, 'add'))) {
        echo json_encode(["code" => 405, "toasterClass" => 'warning', "responseMessage" => 'Sorry! You have no right to add record.']);
    } else if (!empty($id) && is_numeric($id) && $id > 0 && !hasRight($user_right_title, 'edit')) {
        echo json_encode(["code" => 405, "toasterClass" => 'warning', "responseMessage" => 'Sorry! You have no right to update record.']);
    } else if (empty($employee_code)) {
        echo json_encode(['code' => 422, 'errorField' => 'employee_code', 'errorDiv' => 'errorMessageEmployeeCode', 'errorMessage' => 'Employee Code field is required.']);
    } else if (!is_numeric($employee_code) || strlen($employee_code) > 20) {
        echo json_encode(['code' => 422, 'errorField' => 'employee_code', 'errorDiv' => 'errorMessageEmployeeCode', 'errorMessage' => 'Invalid Employee Code.']);
    } else if (empty($department_id)) {
        echo json_encode(['code' => 422, 'errorField' => 'department_id', 'errorDiv' => 'errorMessageDepartment', 'errorMessage' => 'Department field is required.']);
    } else if (!is_numeric($department_id) || strlen($department_id) > 10 || $department_id <= 0) {
        echo json_encode(['code' => 422, 'errorField' => 'department_id', 'errorDiv' => 'errorMessageDepartment', 'errorMessage' => 'Please select a valid option.']);
    } else if (!empty($team_id) && (!is_numeric($team_id) || strlen($team_id) > 10 || $team_id <= 0)) {
        echo json_encode(['code' => 422, 'errorField' => 'team_id', 'errorDiv' => 'errorMessageTeam', 'errorMessage' => 'Please select a valid option.']);
    } else if (empty($designation_id)) {
        echo json_encode(['code' => 422, 'errorField' => 'designation_id', 'errorDiv' => 'errorMessageDesignation', 'errorMessage' => 'Designation field is required.']);
    } else if (!is_numeric($designation_id) || strlen($designation_id) > 10 || $designation_id <= 0) {
        echo json_encode(['code' => 422, 'errorField' => 'designation_id', 'errorDiv' => 'errorMessageDesignation', 'errorMessage' => 'Please select a valid option.']);
    } else if (empty($shift_id)) {
        echo json_encode(['code' => 422, 'errorField' => 'shift_id', 'errorDiv' => 'errorMessageShift', 'errorMessage' => 'Shift field is required.']);
    } else if (!is_numeric($shift_id) || strlen($shift_id) > 10 || $shift_id <= 0) {
        echo json_encode(['code' => 422, 'errorField' => 'shift_id', 'errorDiv' => 'errorMessageShift', 'errorMessage' => 'Please select a valid option.']);
    } else if (empty($evaluation_type_id)) {
        echo json_encode(['code' => 422, 'errorField' => 'evaluation_type_id', 'errorDiv' => 'errorMessageShift', 'errorMessage' => 'Evaluation Type field is required.']);
    } else if (!is_numeric($evaluation_type_id) || strlen($evaluation_type_id) > 10 || $evaluation_type_id <= 0) {
        echo json_encode(['code' => 422, 'errorField' => 'evaluation_type_id', 'errorDiv' => 'errorMessageShift', 'errorMessage' => 'Please select a valid option.']);
    } else if ($status == '') {
        echo json_encode(['code' => 422, 'errorField' => 'status', 'errorDiv' => 'errorMessageStatus', 'errorMessage' => 'Status field is required.']);
    } else if (!in_array($status, $status_array) || strlen($status) !== 1) {
        echo json_encode(['code' => 422, 'errorField' => 'status', 'errorDiv' => 'errorMessageStatus', 'errorMessage' => 'Please select a valid option.']);
    } else if (empty($title)) {
        echo json_encode(['code' => 422, 'errorField' => 'title', 'errorDiv' => 'errorMessageTitle', 'errorMessage' => 'Title field is required.']);
    } else if (!in_array($title, $title_array) || strlen($title) > 5) {
        echo json_encode(['code' => 422, 'errorField' => 'title', 'errorDiv' => 'errorMessageTitle', 'errorMessage' => 'Please select a valid option.']);
    } else if (empty($first_name)) {
        echo json_encode(['code' => 422, 'errorField' => 'first_name', 'errorDiv' => 'errorMessageFirstName', 'errorMessage' => 'First Name field is required.']);
    } else if (!validName($first_name)) {
        echo json_encode(['code' => 422, 'errorField' => 'first_name', 'errorDiv' => 'errorMessageFirstName', 'errorMessage' => 'Special Characters are not Allowed.']);
    } else if (strlen($first_name) > 50) {
        echo json_encode(['code' => 422, 'errorField' => 'first_name', 'errorDiv' => 'errorMessageFirstName', 'errorMessage' => 'Length should not exceed 50.']);
    } /*else if (empty($last_name)) {
        echo json_encode(['code' => 422, 'errorField' => 'last_name', 'errorDiv' => 'errorMessageLastName', 'errorMessage' => 'Last Name field is required.']);
    }*/ else if (!empty($last_name) && !validName($last_name)) {
        echo json_encode(['code' => 422, 'errorField' => 'last_name', 'errorDiv' => 'errorMessageLastName', 'errorMessage' => 'Special Characters are not Allowed.']);
    } else if (!empty($last_name) && strlen($last_name) > 50) {
        echo json_encode(['code' => 422, 'errorField' => 'last_name', 'errorDiv' => 'errorMessageLastName', 'errorMessage' => 'Length should not exceed 50.']);
    } else if (!empty($pseudo_name) && !validName($pseudo_name)) {
        echo json_encode(['code' => 422, 'errorField' => 'pseudo_name', 'errorDiv' => 'errorMessagePseudoName', 'errorMessage' => 'Special Characters are not Allowed.']);
    } else if (!empty($pseudo_name) && strlen($pseudo_name) > 50) {
        echo json_encode(['code' => 422, 'errorField' => 'pseudo_name', 'errorDiv' => 'errorMessagePseudoName', 'errorMessage' => 'Length should not exceed 50.']);
    } else if (empty($father_name)) {
        echo json_encode(['code' => 422, 'errorField' => 'father_name', 'errorDiv' => 'errorMessageFatherName', 'errorMessage' => 'father Name field is required.']);
    } else if (!validName($father_name)) {
        echo json_encode(['code' => 422, 'errorField' => 'father_name', 'errorDiv' => 'errorMessageFatherName', 'errorMessage' => 'Special Characters are not Allowed.']);
    } else if (strlen($father_name) > 50) {
        echo json_encode(['code' => 422, 'errorField' => 'father_name', 'errorDiv' => 'errorMessageFatherName', 'errorMessage' => 'Length should not exceed 50.']);
    } else if (empty($email)) {
        echo json_encode(['code' => 422, 'errorField' => 'email', 'errorDiv' => 'errorMessageEmail', 'errorMessage' => 'Email field is required.']);
    } else if (!validEmail($email)) {
        echo json_encode(['code' => 422, 'errorField' => 'email', 'errorDiv' => 'errorMessageEmail', 'errorMessage' => 'Invalid Email Address.']);
    } else if (empty($official_email)) {
        echo json_encode(['code' => 422, 'errorField' => 'official_email', 'errorDiv' => 'errorMessageOfficialEmail', 'errorMessage' => 'Official Email field is required.']);
    } else if (!validEmail($official_email)) {
        echo json_encode(['code' => 422, 'errorField' => 'official_email', 'errorDiv' => 'errorMessageOfficialEmail', 'errorMessage' => 'Invalid Email Address.']);
    } else if (empty($gender)) {
        echo json_encode(['code' => 422, 'errorField' => 'gender', 'errorDiv' => 'errorMessageGender', 'errorMessage' => 'Gender field is required.']);
    } else if (!in_array($gender, $gender_array) || strlen($gender) !== 1) {
        echo json_encode(['code' => 422, 'errorField' => 'gender', 'errorDiv' => 'errorMessageGender', 'errorMessage' => 'Please select a valid option.']);
    } else if (empty($blood_group)) {
        echo json_encode(['code' => 422, 'errorField' => 'blood_group', 'errorDiv' => 'errorMessageBloodGroup', 'errorMessage' => 'Blood Group field is required.']);
    } else if (!in_array($blood_group, $blood_group_array) || strlen($blood_group) > 5) {
        echo json_encode(['code' => 422, 'errorField' => 'blood_group', 'errorDiv' => 'errorMessageBloodGroup', 'errorMessage' => 'Please select a valid option.']);
    } else if (empty($dob)) {
        echo json_encode(['code' => 422, 'errorField' => 'dob', 'errorDiv' => 'errorMessagedob', 'errorMessage' => 'Date of Birth field is required.']);
    } else if (!validDate($dob) || strlen($dob) !== 10) {
        echo json_encode(['code' => 422, 'errorField' => 'dob', 'errorDiv' => 'errorMessagedob', 'errorMessage' => 'Please select a valid date.']);
    } else if (!empty($pob) && !validName($pob)) {
        echo json_encode(['code' => 422, 'errorField' => 'pob', 'errorDiv' => 'errorMessagepob', 'errorMessage' => 'Special Characters are not Allowed.']);
    } else if (!empty($pob) && strlen($pob) > 50) {
        echo json_encode(['code' => 422, 'errorField' => 'pob', 'errorDiv' => 'errorMessagepob', 'errorMessage' => 'Length should not exceed 50.']);
    } else if (empty($cnic)) {
        echo json_encode(['code' => 422, 'errorField' => 'cnic', 'errorDiv' => 'errorMessageCNIC', 'errorMessage' => 'CNIC field is required.']);
    } else if (!validCNIC($cnic) || strlen($cnic) !== 15) {
        echo json_encode(['code' => 422, 'errorField' => 'dob', 'errorDiv' => 'errorMessagedob', 'errorMessage' => 'CNIC number is incorrect.']);
    } else if (!empty($cnic_expiry) && (!validDate($cnic_expiry) || strlen($cnic_expiry) !== 10)) {
        echo json_encode(['code' => 422, 'errorField' => 'cnic_expiry', 'errorDiv' => 'errorMessageCNICExpiry', 'errorMessage' => 'Please select a valid date.']);
    } else if (!empty($old_cnic) && (!validCNIC($old_cnic) || strlen($old_cnic) !== 15)) {
        echo json_encode(['code' => 422, 'errorField' => 'old_cnic', 'errorDiv' => 'errorMessageOldCNIC', 'errorMessage' => 'CNIC number is incorrect.']);
    } else if (empty($country_id)) {
        echo json_encode(['code' => 422, 'errorField' => 'country_id', 'errorDiv' => 'errorMessageCountry', 'errorMessage' => 'Country field is required.']);
    } else if (!is_numeric($country_id) || strlen($country_id) > 10) {
        echo json_encode(['code' => 422, 'errorField' => 'country_id', 'errorDiv' => 'errorMessageCountry', 'errorMessage' => 'Please select a valid option.']);
    } else if (empty($state_id)) {
        echo json_encode(['code' => 422, 'errorField' => 'state_id', 'errorDiv' => 'errorMessageState', 'errorMessage' => 'State field is required.']);
    } else if (!is_numeric($state_id) || strlen($state_id) > 10) {
        echo json_encode(['code' => 422, 'errorField' => 'state_id', 'errorDiv' => 'errorMessageState', 'errorMessage' => 'Please select a valid option.']);
    } else if (empty($city_id)) {
        echo json_encode(['code' => 422, 'errorField' => 'city_id', 'errorDiv' => 'errorMessageCity', 'errorMessage' => 'City field is required.']);
    } else if (!is_numeric($city_id) || strlen($city_id) > 10) {
        echo json_encode(['code' => 422, 'errorField' => 'city_id', 'errorDiv' => 'errorMessageCity', 'errorMessage' => 'Please select a valid option.']);
    } else if (!empty($phone) && (!validPhoneNumber($phone) || strlen($phone) !== 14)) {
        echo json_encode(['code' => 422, 'errorField' => 'phone', 'errorDiv' => 'errorMessagePhone', 'errorMessage' => 'Invalid Phone number.']);
    } else if (empty($dial_code) || !is_numeric($dial_code) || strlen($dial_code) > 9) {
        echo json_encode(['code' => 422, 'errorField' => 'mobile', 'errorDiv' => 'errorMessageMobile', 'errorMessage' => 'Invalid country dial code.']);
    } else if (empty($mobile)) {
        echo json_encode(['code' => 422, 'errorField' => 'mobile', 'errorDiv' => 'errorMessageMobile', 'errorMessage' => 'Mobile No field is required.']);
    } else if (!validMobileNumber($mobile) || strlen($mobile) !== 12) {
        echo json_encode(['code' => 422, 'errorField' => 'mobile', 'errorDiv' => 'errorMessageMobile', 'errorMessage' => 'Invalid Mobile number.']);
    } else if (empty($iso) || !validName($iso) || strlen($iso) > 3) {
        echo json_encode(['code' => 422, 'errorField' => 'mobile', 'errorDiv' => 'errorMessageMobile', 'errorMessage' => 'Invalid country iso.']);
    } else if (empty($o_dial_code) || !is_numeric($o_dial_code) || strlen($o_dial_code) > 9) {
        echo json_encode(['code' => 422, 'errorField' => 'other_mobile', 'errorDiv' => 'errorMessageOtherMobile', 'errorMessage' => 'Invalid country dial code.']);
    } else if (empty($other_mobile)) {
        echo json_encode(['code' => 422, 'errorField' => 'other_mobile', 'errorDiv' => 'errorMessageOtherMobile', 'errorMessage' => 'Other Mobile field is required.']);
    } else if (!validMobileNumber($other_mobile) || strlen($other_mobile) !== 12) {
        echo json_encode(['code' => 422, 'errorField' => 'other_mobile', 'errorDiv' => 'errorMessageOtherMobile', 'errorMessage' => 'Invalid Other Mobile number.']);
    } else if (empty($o_iso) || !validName($o_iso) || strlen($o_iso) > 3) {
        echo json_encode(['code' => 422, 'errorField' => 'other_mobile', 'errorDiv' => 'errorMessageOtherMobile', 'errorMessage' => 'Invalid country iso.']);
    } else if (empty($relation)) {
        echo json_encode(['code' => 422, 'errorField' => 'relation', 'errorDiv' => 'errorMessageRelation', 'errorMessage' => 'Relation field is required.']);
    } else if (!in_array($relation, $relation_array) || strlen($relation) > 2) {
        echo json_encode(['code' => 422, 'errorField' => 'relation', 'errorDiv' => 'errorMessageRelation', 'errorMessage' => 'Please select a valid option.']);
    } else if (empty($marital_status)) {
        echo json_encode(['code' => 422, 'errorField' => 'marital_status', 'errorDiv' => 'errorMessageMaritalStatus', 'errorMessage' => 'Marital Status field is required.']);
    } else if (!in_array($marital_status, $marital_status_array) || strlen($marital_status) > 2) {
        echo json_encode(['code' => 422, 'errorField' => 'marital_status', 'errorDiv' => 'errorMessageMaritalStatus', 'errorMessage' => 'Please select a valid option.']);
    } else if (!empty($religion) && !validName($religion)) {
        echo json_encode(['code' => 422, 'errorField' => 'religion', 'errorDiv' => 'errorMessageReligion', 'errorMessage' => 'Special Characters are not Allowed.']);
    } else if (!empty($religion) && strlen($religion) > 50) {
        echo json_encode(['code' => 422, 'errorField' => 'religion', 'errorDiv' => 'errorMessageReligion', 'errorMessage' => 'Length should not exceed 50.']);
    } else if (!empty($sect) && !validName($sect)) {
        echo json_encode(['code' => 422, 'errorField' => 'sect', 'errorDiv' => 'errorMessageSect', 'errorMessage' => 'Special Characters are not Allowed.']);
    } else if (!empty($sect) && strlen($sect) > 50) {
        echo json_encode(['code' => 422, 'errorField' => 'sect', 'errorDiv' => 'errorMessageSect', 'errorMessage' => 'Length should not exceed 50.']);
    } else if (empty($address)) {
        echo json_encode(['code' => 422, 'errorField' => 'address', 'errorDiv' => 'errorMessageAddress', 'errorMessage' => 'Address field is required.']);
    } else if (!validAddress($address)) {
        echo json_encode(['code' => 422, 'errorField' => 'address', 'errorDiv' => 'errorMessageAddress', 'errorMessage' => 'Special Characters are not Allowed.']);
    } else if (!empty($permanent_address) && !validAddress($permanent_address)) {
        echo json_encode(['code' => 422, 'errorField' => 'permanent_address', 'errorDiv' => 'errorMessagePermanentAddress', 'errorMessage' => 'Special Characters are not Allowed.']);
    } else if (!empty($personal_history) && !validAddress($personal_history)) {
        echo json_encode(['code' => 422, 'errorField' => 'personal_history', 'errorDiv' => 'errorMessagePersonalHistory', 'errorMessage' => 'Special Characters are not Allowed.']);
    } else if (!empty($guardian_name) && !validName($guardian_name)) {
        echo json_encode(['code' => 422, 'errorField' => 'guardian_name', 'errorDiv' => 'errorMessageGuardianName', 'errorMessage' => 'Special Characters are not Allowed.']);
    } else if (!empty($guardian_name) && strlen($guardian_name) > 50) {
        echo json_encode(['code' => 422, 'errorField' => 'guardian_name', 'errorDiv' => 'errorMessageGuardianName', 'errorMessage' => 'Length should not exceed 50 characters.']);
    } else if (!empty($guardian_mobile) && (!validMobileNumber($guardian_mobile) || strlen($guardian_mobile) !== 12)) {
        echo json_encode(['code' => 422, 'errorField' => 'guardian_mobile', 'errorDiv' => 'errorMessageGuardianMobile', 'errorMessage' => "Invalid Guardian's Mobile No."]);
    } else if (!empty($guardian_cnic) && (!validCNIC($guardian_cnic) || strlen($guardian_cnic) !== 15)) {
        echo json_encode(['code' => 422, 'errorField' => 'guardian_cnic', 'errorDiv' => 'errorMessageGuardianCNIC', 'errorMessage' => "Invalid Guardian's CNIC."]);
    } else if ((!empty($guardian_name) && empty($guardian_relation)) || (!empty($guardian_mobile) && empty($guardian_relation)) || (!empty($guardian_cnic) && empty($guardian_relation))) {
        echo json_encode(['code' => 422, 'errorField' => 'guardian_relation', 'errorDiv' => 'errorMessageGuardianRelation', 'errorMessage' => 'If you put any guardian info then "Guardian Relation" field is required.']);
    } else if (!empty($guardian_relation) && (!in_array($guardian_relation, $relation_array) || strlen($guardian_relation) > 2)) {
        echo json_encode(['code' => 422, 'errorField' => 'guardian_relation', 'errorDiv' => 'errorMessageGuardianRelation', 'errorMessage' => "Please select a valid option."]);
    } else if (!empty($guardian_relation) && empty($guardian_name)) {
        echo json_encode(['code' => 422, 'errorField' => 'guardian_name', 'errorDiv' => 'errorMessageGuardianName', 'errorMessage' => 'If you select "Guardian Relation" then "Guardian\'s Name" field is required.']);
    } else if (empty($joining_date)) {
        echo json_encode(['code' => 422, 'errorField' => 'joining_date', 'errorDiv' => 'errorMessageJoiningDate', 'errorMessage' => 'Joining Date field is required.']);
    } else if (!empty($joining_date) && (!validDate($joining_date) || strlen($joining_date) != 10)) {
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
    } else if (empty($salary)) {
        echo json_encode(['code' => 422, 'errorField' => 'salary', 'errorDiv' => 'errorMessageGuardianRelation', 'errorMessage' => 'Salary field is required.']);
    } else if (!empty($salary) && (!is_numeric($salary) || $salary < 1 || strlen($salary) > 9)) {
        echo json_encode(['code' => 422, 'errorField' => 'salary', 'errorDiv' => 'errorMessageGuardianRelation', 'errorMessage' => 'Invalid amount of Salary.']);
    } else {
        $company_id = $_SESSION['company_id'];
        $branch_id = $_SESSION['branch_id'];
        $user_id = $_SESSION['user_id'];

        $select = "SELECT e.id 
        FROM 
            employees AS e
        INNER JOIN
            employee_basic_infos AS eb 
            ON e.id=eb.employee_id 
        WHERE e.company_id='{$company_id}' AND e.id!='{$id}' AND (e.employee_code='{$employee_code}' OR eb.official_email='{$official_email}') AND e.deleted_at IS NULL";
        $query = mysqli_query($db, $select);
        if (mysqli_num_rows($query) > 0) {
            echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'This employee already exist.']);
        } else {
            $employee_code = html_entity_decode(stripslashes(strip_tags($employee_code)));
            $team_id = empty($team_id) ? 0 : html_entity_decode(stripslashes(strip_tags($team_id)));
            $first_name = $db->real_escape_string(html_entity_decode(stripslashes(strip_tags($first_name))));
            $last_name = $db->real_escape_string(html_entity_decode(stripslashes(strip_tags($last_name))));
            $pseudo_name = $db->real_escape_string(html_entity_decode(stripslashes(strip_tags($pseudo_name))));
            $father_name = $db->real_escape_string(html_entity_decode(stripslashes(strip_tags($father_name))));
            $email = html_entity_decode(stripslashes(strip_tags($email)));
            $official_email = html_entity_decode(stripslashes(strip_tags($official_email)));
            $dob = html_entity_decode(stripslashes(date('Y-m-d', strtotime($dob))));
            $pob = html_entity_decode(stripslashes(strip_tags($pob)));
            $cnic = html_entity_decode(stripslashes(strip_tags($cnic)));
            $cnic_expiry = empty($cnic_expiry) ? '0000-00-00' : html_entity_decode(stripslashes(date('Y-m-d', strtotime($cnic_expiry))));
            $old_cnic = html_entity_decode(stripslashes(strip_tags($old_cnic)));
            $country_id = html_entity_decode(stripslashes(strip_tags($country_id)));
            $state_id = html_entity_decode(stripslashes(strip_tags($state_id)));
            $city_id = html_entity_decode(stripslashes(strip_tags($city_id)));
            $phone = html_entity_decode(stripslashes(strip_tags($phone)));
            $dial_code = html_entity_decode(stripslashes(strip_tags($dial_code)));
            $mobile = html_entity_decode(stripslashes(strip_tags($mobile)));
            $iso = html_entity_decode(stripslashes(strip_tags($iso)));
            $o_dial_code = html_entity_decode(stripslashes(strip_tags($o_dial_code)));
            $other_mobile = html_entity_decode(stripslashes(strip_tags($other_mobile)));
            $o_iso = html_entity_decode(stripslashes(strip_tags($o_iso)));
            $religion = html_entity_decode(stripslashes(strip_tags($religion)));
            $sect = html_entity_decode(stripslashes(strip_tags($sect)));
            $address = $db->real_escape_string(html_entity_decode(stripslashes(strip_tags($address))));
            $permanent_address = $db->real_escape_string(html_entity_decode(stripslashes(strip_tags($permanent_address))));
            $personal_history = $db->real_escape_string(html_entity_decode(stripslashes(strip_tags($personal_history))));
            $guardian_name = $db->real_escape_string(html_entity_decode(stripslashes(strip_tags($guardian_name))));
            $salary = encode(html_entity_decode(stripslashes(strip_tags($salary))));

            $JoiningDate = $ContractStartDate = $ContractEndDate = $LeavingDate = NULL;
            $PayrollEntry = false;

            if (!empty($joining_date)) {
                $JoiningDate = html_entity_decode(stripslashes(strip_tags(date('Y-m-d', strtotime($joining_date)))));
                $PayrollEntry = true;
            }
            if (!empty($contract_start_date)) {
                $ContractStartDate = html_entity_decode(stripslashes(strip_tags(date('Y-m-d', strtotime($contract_start_date)))));
                $PayrollEntry = true;
            }
            if (!empty($contract_end_date)) {
                $ContractEndDate = html_entity_decode(stripslashes(strip_tags(date('Y-m-d', strtotime($contract_end_date)))));
                $PayrollEntry = true;
            }
            if (!empty($leaving_date)) {
                $LeavingDate = html_entity_decode(stripslashes(strip_tags(date('Y-m-d', strtotime($leaving_date)))));
                $PayrollEntry = true;
            }
            if (!empty($salary)) {
                $PayrollEntry = true;
            }


            if (!empty($id) && $id > 0) {
                $update = "UPDATE `employees` SET `employee_code`='{$employee_code}',`department_id`='{$department_id}',`team_id`='{$team_id}',`designation_id`='{$designation_id}',`shift_id`='{$shift_id}',`evaluation_type_id`='{$evaluation_type_id}',`status`='{$status}',`updated_by`='{$user_id}' WHERE `company_id`='{$company_id}' AND `branch_id`='{$branch_id}' AND `id`='{$id}'";
                if (mysqli_query($db, $update)) {
                    $query = "UPDATE `employee_basic_infos` SET `title`='{$title}',`first_name`='{$first_name}',`last_name`='{$last_name}',`pseudo_name`='{$pseudo_name}',`father_name`='{$father_name}',`email`='{$email}',`official_email`='{$official_email}',`gender`='{$gender}',`blood_group`='{$blood_group}',`dob`='{$dob}',`pob`='{$pob}',`cnic`='{$cnic}',`cnic_expiry`='{$cnic_expiry}',`old_cnic`='{$old_cnic}',`country_id`='{$country_id}',`state_id`='{$state_id}',`city_id`={$city_id},`phone`='{$phone}',`dial_code`='{$dial_code}',`mobile`='{$mobile}',`iso`='{$iso}',`o_dial_code`='{$o_dial_code}',`other_mobile`='{$other_mobile}',`o_iso`='{$o_iso}',`relation`='{$relation}',`marital_status`='{$marital_status}',`religion`='{$religion}',`sect`='{$sect}',`address`='{$address}',`permanent_address`='{$permanent_address}',`personal_history`='{$personal_history}',`guardian_name`='{$guardian_name}',`guardian_dial_code`='{$guardian_dial_code}',`guardian_mobile`='{$guardian_mobile}',`guardian_iso`='{$guardian_iso}',`guardian_cnic`='{$guardian_cnic}',`guardian_relation`='{$guardian_relation}',`updated_by`='{$user_id}' WHERE `employee_id`='{$id}'";
                    if (mysqli_query($db, $query)) {
                        mysqli_query($db, "UPDATE `users` SET `email`='{$official_email}', `email_verified_at`= NULL, `updated_by`='{$user_id}' WHERE `employee_id`='{$id}'");
                        if ($PayrollEntry) {
                            $check = mysqli_query($db, "SELECT `id` FROM `employee_payrolls` WHERE `employee_id`='{$id}'");
                            if (mysqli_num_rows($check) > 0) {
                                mysqli_query($db, "UPDATE `employee_payrolls` SET `joining_date`='{$JoiningDate}',`contract_start_date`='{$ContractStartDate}',`contract_end_date`='{$ContractEndDate}',`leaving_date`='{$LeavingDate}',`salary`='{$salary}',`updated_by`='{$user_id}' WHERE `employee_id`='{$id}'");
                            } else {
                                mysqli_query($db, "INSERT INTO `employee_payrolls`(`id`,`employee_id`,`joining_date`,`contract_start_date`,`contract_end_date`,`leaving_date`,`salary`, `added_by`) VALUES (NULL,'{$id}','{$JoiningDate}','{$ContractStartDate}','{$ContractEndDate}','{$LeavingDate}','{$salary}','{$user_id}')");
                            }
                        }
                        echo json_encode(["code" => 200, "toasterClass" => 'success', "responseMessage" => 'Record successfully saved.']);
                    } else {
                        echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'Unexpected error.']);
                    }
                }
            } else {
                $insert = "INSERT INTO `employees`(`id`, `employee_code`, `department_id`, `team_id`, `designation_id`, `shift_id`, `evaluation_type_id`, `company_id`, `branch_id`, `status`, `added_by`) VALUES (NULL, '{$employee_code}', '{$department_id}', '{$team_id}', '{$designation_id}', '{$shift_id}', '{$evaluation_type_id}', '{$company_id}', '{$branch_id}', '{$status}','{$user_id}')";
                mysqli_query($db, $insert);
                $insert_id = mysqli_insert_id($db);
                if ($insert_id > 0) {
                    $query = "INSERT INTO `employee_basic_infos`(`id`, `employee_id`, `title`, `first_name`, `last_name`, `pseudo_name`, `father_name`, `email`, `official_email`, `gender`, `blood_group`, `dob`, `pob`, `cnic`, `cnic_expiry`, `old_cnic`, `country_id`, `state_id`, `city_id`, `phone`, `dial_code`, `mobile`, `iso`, `o_dial_code`, `other_mobile`, `o_iso`, `relation`, `marital_status`, `religion`, `sect`, `address`, `permanent_address`, `personal_history`, `guardian_name`, `guardian_dial_code`, `guardian_mobile`, `guardian_iso`, `guardian_cnic`, `guardian_relation`, `added_by`) VALUES (NULL,'{$insert_id}','{$title}','{$first_name}','{$last_name}','{$pseudo_name}','{$father_name}','{$email}','{$official_email}','{$gender}','{$blood_group}','{$dob}','{$pob}','{$cnic}','{$cnic_expiry}','{$old_cnic}','{$country_id}','{$state_id}','{$city_id}','{$phone}','{$dial_code}','{$mobile}','{$iso}','{$o_dial_code}','{$other_mobile}','{$o_iso}','{$relation}','{$marital_status}','{$religion}','{$sect}','{$address}','{$permanent_address}','{$personal_history}','{$guardian_name}','{$guardian_dial_code}','{$guardian_mobile}','{$guardian_iso}','{$guardian_cnic}','{$guardian_relation}','{$user_id}')";
                    if (mysqli_query($db, $query)) {
                        $password = md5($insert_id . '_medcaremso');
                        $st = config('users.status.value.pending');
                        $ty = config('users.type.value.resource');

                        mysqli_query($db, "INSERT INTO `users`(`id`, `employee_id`, `email`, `password`, `email_verified_at`, `status`, `type`, `added_by`) VALUES (NULL, '{$insert_id}', '{$official_email}', '{$password}', NULL, '{$st}', '{$ty}','{$user_id}')");
                        if ($PayrollEntry) {
                            mysqli_query($db, "INSERT INTO `employee_payrolls`(`id`,`employee_id`,`joining_date`,`contract_start_date`,`contract_end_date`,`leaving_date`,`salary`, `added_by`) VALUES (NULL,'{$insert_id}','{$JoiningDate}','{$ContractStartDate}','{$ContractEndDate}','{$LeavingDate}','{$salary}','{$user_id}')");
                        }
                        echo json_encode(["code" => 200, "toasterClass" => 'success', "responseMessage" => 'Record successfully saved.', 'form_reset' => true]);
                    } else {
                        echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'Unexpected error.']);
                    }
                }
            }
        }
    }
}
?>