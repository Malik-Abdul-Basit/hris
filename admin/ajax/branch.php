<?php
include_once('../../includes/connection.php');

if (isset($_POST['postData'])) {
    $object = (object)$_POST['postData'];

    $id = $object->id;
    $name = $object->name;
    $company_email = $object->company_email;
    $hr_email = $object->hr_email;
    $other_email = $object->other_email;
    $country_id = $object->country_id;
    $state_id = $object->state_id;
    $city_id = $object->city_id;
    $dial_code = $object->dial_code;
    $mobile = $object->mobile;
    $iso = $object->iso;
    $phone = $object->phone;
    $fax = $object->fax;
    $web = $object->web;
    $status = $object->status;
    $type = $object->type;
    $address = $object->address;
    $user_right_title = $object->user_right_title;

    $status_array = array_values(config('branches.status.value'));
    $type_array = array_values(config('branches.type.value'));

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
    } else if (empty($company_email)) {
        echo json_encode(['code' => 422, 'errorField' => 'company_email', 'errorDiv' => 'errorMessageCompanyEmail', 'errorMessage' => 'Company Email field is required.']);
    } else if (!validEmail($company_email)) {
        echo json_encode(['code' => 422, 'errorField' => 'company_email', 'errorDiv' => 'errorMessageCompanyEmail', 'errorMessage' => 'Invalid Email Address.']);
    } else if (empty($hr_email)) {
        echo json_encode(['code' => 422, 'errorField' => 'hr_email', 'errorDiv' => 'errorMessageHREmail', 'errorMessage' => 'HR Email field is required.']);
    } else if (!validEmail($hr_email)) {
        echo json_encode(['code' => 422, 'errorField' => 'hr_email', 'errorDiv' => 'errorMessageHREmail', 'errorMessage' => 'Invalid Email Address.']);
    } else if (!empty($other_email) && !validEmail($other_email)) {
        echo json_encode(['code' => 422, 'errorField' => 'other_email', 'errorDiv' => 'errorMessageOtherEmail', 'errorMessage' => 'Invalid Email Address.']);
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
    } else if (empty($mobile)) {
        echo json_encode(['code' => 422, 'errorField' => 'mobile', 'errorDiv' => 'errorMessageMobile', 'errorMessage' => 'Mobile field is required.']);
    } else if (!validMobileNumber($mobile) || strlen($mobile) != 12) {
        echo json_encode(['code' => 422, 'errorField' => 'mobile', 'errorDiv' => 'errorMessageMobile', 'errorMessage' => 'Invalid Mobile number.']);
    } else if (!empty($phone) && (!validPhoneNumber($phone) || strlen($phone) != 14)) {
        echo json_encode(['code' => 422, 'errorField' => 'phone', 'errorDiv' => 'errorMessagePhone', 'errorMessage' => 'Invalid Phone number.']);
    } else if (!empty($fax) && (!validPhoneNumber($fax) || strlen($fax) != 14)) {
        echo json_encode(['code' => 422, 'errorField' => 'fax', 'errorDiv' => 'errorMessageFax', 'errorMessage' => 'Special Characters are not Allowed.']);
    } else if (!empty($web) && !validURL($web)) {
        echo json_encode(['code' => 422, 'errorField' => 'web', 'errorDiv' => 'errorMessageWeb', 'errorMessage' => 'Invalid Web link.']);
    } else if ($status == '') {
        echo json_encode(['code' => 422, 'errorField' => 'status', 'errorDiv' => 'errorMessageStatus', 'errorMessage' => 'Status field is required.']);
    } else if (!in_array($status, $status_array) || strlen($status) > 2) {
        echo json_encode(['code' => 422, 'errorField' => 'status', 'errorDiv' => 'errorMessageStatus', 'errorMessage' => 'Please select a valid option.']);
    } else if (empty($type)) {
        echo json_encode(['code' => 422, 'errorField' => 'type', 'errorDiv' => 'errorMessageType', 'errorMessage' => 'Type field is required.']);
    } else if (!in_array($type, $type_array) || strlen($type) > 2) {
        echo json_encode(['code' => 422, 'errorField' => 'type', 'errorDiv' => 'errorMessageType', 'errorMessage' => 'Please select a valid option.']);
    } else if (empty($address)) {
        echo json_encode(['code' => 422, 'errorField' => 'address', 'errorDiv' => 'errorMessageAddress', 'errorMessage' => 'Address field is required.']);
    } else if (!validAddress($address)) {
        echo json_encode(['code' => 422, 'errorField' => 'address', 'errorDiv' => 'errorMessageAddress', 'errorMessage' => 'Special Characters are not Allowed.']);
    } else {
        $company_id = $_SESSION['company_id'];
        $user_id = $_SESSION['user_id'];
        $name = $db->real_escape_string(html_entity_decode(stripslashes(strip_tags($name))));
        $hr_email = html_entity_decode(stripslashes(strip_tags($hr_email)));
        $address = $db->real_escape_string(html_entity_decode(stripslashes(strip_tags($address))));

        $checkExist = mysqli_query($db, "SELECT `id` FROM `branches` WHERE `company_id`='{$company_id}' AND `name`='{$name}' AND `id`!='{$id}' AND `deleted_at` IS NULL");
        if (mysqli_num_rows($checkExist) > 0) {
            echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'This Branch already exist.']);
        } else {
            if (!empty($id) && $id > 0) {
                $query = "UPDATE `branches` SET `name`='{$name}',`company_email`='{$company_email}',`hr_email`='{$hr_email}',`other_email`='{$other_email}',`dial_code`='{$dial_code}',`mobile`='{$mobile}',`iso`='{$iso}',`phone`='{$phone}',`fax`='{$fax}',`web`='{$web}',`address`='{$address}',`status`='{$status}',`type`='{$type}',`country_id`='{$country_id}',`state_id`='{$state_id}',`city_id`='{$city_id}',`updated_by`='{$user_id}' WHERE `company_id`='{$company_id}' AND `id`='{$id}'";
                $form_reset = false;
            } else {
                $query = "INSERT INTO `branches`(`id`, `name`, `company_email`, `hr_email`, `other_email`, `dial_code`, `mobile`, `iso` , `phone`, `fax`, `web`, `address`, `status`, `type`, `company_id`, `country_id`, `state_id`, `city_id`, `added_by`) VALUES (NULL,'{$name}','{$company_email}','{$hr_email}','{$other_email}','{$dial_code}','{$mobile}','{$iso}','{$phone}','{$fax}','{$web}','{$address}','{$status}','{$type}','{$company_id}','{$country_id}','{$state_id}','{$city_id}','{$user_id}')";
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