<?php
ob_start();
session_start();

if ($_SERVER['HTTP_HOST'] == "carehris.com") {
    $db = mysqli_connect('localhost', 'careadwj_hris_hr47_user', 'eT!iQPOp~myMB6?Rp@UDYeijA6', 'careadwj_hris_hr47_db') or die(mysql_error());
} else if ($_SERVER['HTTP_HOST'] == "hris.medcaremso.com") {
    $db = mysqli_connect('localhost', 'medcarem_hr47Usr', '6mQieMBT@5dvf4i6*7pe45P?O^ipRejA', 'medcarem_hris_hr47_db') or die(mysql_error());
} else {
    $db = mysqli_connect('localhost', 'root', '', 'hr47_mso') or die(mysql_error());
}

function trimSpaces($str)
{
    $pattern = '/ /i';
    $remove = preg_replace($pattern, " ", $str);
    $trim = trim($remove);
    return html_entity_decode(stripslashes(strip_tags($trim)));
}

function getDepartments($company_id, $branch_id)
{
    global $db;
    $return = [];

    $select = "SELECT `id`, `name` FROM `departments` WHERE `company_id`='{$company_id}' AND `branch_id`='{$branch_id}'";
    $query = mysqli_query($db, $select);
    if (mysqli_num_rows($query) > 0) {
        while ($fetch = mysqli_fetch_object($query)) {
            $name = trimSpaces($fetch->name);
            $return[$name] = $fetch->id;
        }
    }
    return $return;
}

function getTeams($company_id, $branch_id)
{
    global $db;
    $return = [];

    $select = "SELECT `id`, `name` FROM `teams` WHERE `company_id`='{$company_id}' AND `branch_id`='{$branch_id}'";
    $query = mysqli_query($db, $select);
    if (mysqli_num_rows($query) > 0) {
        while ($fetch = mysqli_fetch_object($query)) {
            $name = trimSpaces($fetch->name);
            $return[$name] = $fetch->id;
        }
    }
    return $return;
}

function getDesignations($company_id, $branch_id)
{
    global $db;
    $return = [];

    $select = "SELECT `id`, `name`,`department_id` FROM `designations` WHERE `company_id`='{$company_id}' AND `branch_id`='{$branch_id}'";
    $query = mysqli_query($db, $select);
    if (mysqli_num_rows($query) > 0) {
        while ($fetch = mysqli_fetch_object($query)) {
            $name = trimSpaces($fetch->name);
            $return[$name . '_' . $fetch->department_id] = $fetch->id;
        }
    }
    return $return;
}

function getShifts($company_id, $branch_id)
{
    global $db;
    $return = [];

    $select = "SELECT `id`, `name` FROM `shifts` WHERE `company_id`='{$company_id}' AND `branch_id`='{$branch_id}'";
    $query = mysqli_query($db, $select);
    if (mysqli_num_rows($query) > 0) {
        while ($fetch = mysqli_fetch_object($query)) {
            $name = trimSpaces($fetch->name);
            $return[$name] = $fetch->id;
        }
    }
    return $return;
}

function getEvaluationTypes($company_id, $branch_id)
{
    global $db;
    $return = [];

    $select = "SELECT `id`, `name` FROM `evaluation_types` WHERE `company_id`='{$company_id}' AND `branch_id`='{$branch_id}'";
    $query = mysqli_query($db, $select);
    if (mysqli_num_rows($query) > 0) {
        while ($fetch = mysqli_fetch_object($query)) {
            $name = trimSpaces($fetch->name);
            $return[$name] = $fetch->id;
        }
    }
    return $return;
}

function getSalaryGrades($company_id, $branch_id)
{
    global $db;
    $return = [];

    $select = "SELECT `id`, `name` FROM `salary_grades` WHERE `company_id`='{$company_id}' AND `branch_id`='{$branch_id}'";
    $query = mysqli_query($db, $select);
    if (mysqli_num_rows($query) > 0) {
        while ($fetch = mysqli_fetch_object($query)) {
            $name = trimSpaces($fetch->name);
            $return[$name] = $fetch->id;
        }
    }
    return $return;
}

function getSalaryGradeDetails()
{
    global $db;
    $return = [];

    $select = "SELECT id, grade_name AS name FROM `salary_grade_details`";
    $query = mysqli_query($db, $select);
    if (mysqli_num_rows($query) > 0) {
        while ($fetch = mysqli_fetch_object($query)) {
            $name = trimSpaces($fetch->name);
            $return[$name] = $fetch->id;
        }
    }
    return $return;
}


if (isset($_FILES['csv_file']['name'])) {

    $company_id = $branch_id = $status = $user_id = 1;

    $department_array = getDepartments($company_id, $branch_id);
    $team_array = getTeams($company_id, $branch_id);
    $designation_array = getDesignations($company_id, $branch_id);
    $shift_array = getShifts($company_id, $branch_id);
    $salary_grade_array = getSalaryGrades($company_id, $branch_id);
    $salary_grade_detail_array = getSalaryGradeDetails();
    $evaluation_types_array = getEvaluationTypes($company_id, $branch_id);

    $filename = $_FILES['csv_file']['tmp_name'];
    $handle = fopen($filename, "r");
    for ($i = 1; ($data = fgetcsv($handle, 10000, ",")) !== FALSE; $i++) {
        if ($i == 1) {
            continue;
        } else {
            $employee_code = $data[0];

            if (array_key_exists(trimSpaces($data[1]), $department_array)) {
                $department_id = $department_array[trimSpaces($data[1])];

                /*if (array_key_exists(trimSpaces($data[2]), $team_array)) {
                    $team_id = $team_array[trimSpaces($data[2])];
                } else {
                    $team_id=0;
                }*/
                $team_id=0;


                if (array_key_exists(trimSpaces($data[3]) . '_' . $department_id, $designation_array)) {
                    $designation_id = $designation_array[trimSpaces($data[3]) . '_' . $department_id];
                    if (array_key_exists(trimSpaces($data[4]), $shift_array)) {
                        $shift_id = $shift_array[trimSpaces($data[4])];
                        if (array_key_exists(trimSpaces($data[5]), $salary_grade_array)) {
                            $salary_grade_id = $salary_grade_array[trimSpaces($data[5])];
                            if (array_key_exists(trimSpaces($data[6]), $salary_grade_detail_array)) {
                                $salary_grade_detail_id = $salary_grade_detail_array[trimSpaces($data[6])];
                                if (array_key_exists(trimSpaces($data[7]), $evaluation_types_array)) {
                                    $evaluation_type_id = $evaluation_types_array[trimSpaces($data[7])];

                                    $title = trimSpaces($data[8]);
                                    $first_name = trimSpaces($data[9]);
                                    $last_name = trimSpaces($data[10]);
                                    $pseudo_name = trimSpaces($data[11]);
                                    $father_name = trimSpaces($data[12]);
                                    $email = trimSpaces($data[13]);
                                    $official_email = trimSpaces($data[14]);
                                    $gender = trimSpaces($data[15]);
                                    $blood_group = str_replace(' ', '', strtolower($data[16]));
                                    $dob = date('Y-m-d', strtotime(trimSpaces($data[17])));
                                    $pob = trimSpaces($data[18]);
                                    $cnic = trimSpaces($data[19]);
                                    $cnic_expiry = empty(trimSpaces($data[20])) ? '0000-00-00' : date('Y-m-d', strtotime(trimSpaces($data[20])));
                                    $old_cnic = '';
                                    $country_id = '166';
                                    $state_id = '2728';
                                    $city_id = '31360';
                                    $dial_code = $o_dial_code = $guardian_dial_code = '92';
                                    $mobile = trimSpaces($data[21]);
                                    $iso = $o_iso = $guardian_iso = 'pk';
                                    $other_mobile = trimSpaces($data[22]);
                                    $relation = trimSpaces($data[23]);
                                    $phone = trimSpaces($data[24]);
                                    $marital_status = trimSpaces($data[25]);
                                    $religion = trimSpaces($data[26]);
                                    $sect = trimSpaces($data[27]);
                                    $address = trimSpaces($data[28]);
                                    $permanent_address = trimSpaces($data[29]);
                                    $personal_history = trimSpaces($data[30]);
                                    $guardian_name = trimSpaces($data[31]);
                                    $guardian_mobile = trimSpaces($data[32]);
                                    $guardian_cnic = trimSpaces($data[33]);
                                    $guardian_relation = trimSpaces($data[34]);
                                    $salary = $data[39];
                                    $JoiningDate = $ContractStartDate = $ContractEndDate = $LeavingDate = '0000-00-00';

                                    $PayrollEntry = false;
                                    if (!empty($data[35]) && $data[35] != '0000-00-00') {
                                        $JoiningDate = date('Y-m-d', strtotime(trimSpaces($data[35])));
                                        $PayrollEntry = true;
                                    }
                                    if (!empty($data[36]) && $data[36] != '0000-00-00') {
                                        $ContractStartDate = date('Y-m-d', strtotime(trimSpaces($data[36])));
                                        $PayrollEntry = true;
                                    }
                                    if (!empty($data[36]) && $data[36] != '0000-00-00' && (empty($data[37]) || $data[37] == '0000-00-00')) {
                                        /*
                                         * date('Y-m-d', strtotime('+5 years'));
                                         *
                                         * $date = '05/06/2011';
                                         * $date = strtotime($date);
                                         * $new_date = strtotime('+ 1 year', $date);
                                         *
                                         * $date = "2019-11-30";
                                         * echo date('Y-m-d', strtotime($date. ' + 7 days'));
                                         *
                                         * $date = date_create('2000-01-01');
                                         * date_add($date, date_interval_create_from_date_string('10 days'));
                                         * echo date_format($date, 'Y-m-d');
                                         */

                                        $date = date_create($data[36]);
                                        date_add($date, date_interval_create_from_date_string('1 year'));
                                        $ContractEndDate = date_format($date, 'Y-m-d');
                                        $PayrollEntry = true;
                                    } else if (!empty($data[37]) && $data[37] != '0000-00-00' ) {
                                        $ContractEndDate = date('Y-m-d', strtotime(trimSpaces($data[37])));
                                        $PayrollEntry = true;
                                    }
                                    if (!empty($data[38]) && $data[38] != '0000-00-00' ) {
                                        $LeavingDate = date('Y-m-d', strtotime(trimSpaces($data[38])));
                                        $PayrollEntry = true;
                                    }
                                    if (!empty($data[39])) {
                                        $salary = base64_encode(trimSpaces($data[39]));
                                        $PayrollEntry = true;
                                    }

                                    $select = "SELECT `id` FROM `employees` WHERE `employee_code`='{$employee_code}' AND `company_id`='{$company_id}' AND `branch_id`='{$branch_id}' LIMIT 1";
                                    $query = mysqli_query($db, $select);
                                    if (mysqli_num_rows($query) > 0) {
                                        $fetch = mysqli_fetch_object($query);
                                        $id = $fetch->id;

                                        $update = "UPDATE `employees` SET `employee_code`='{$employee_code}',`department_id`='{$department_id}',`team_id`='{$team_id}',`designation_id`='{$designation_id}',`shift_id`='{$shift_id}',`evaluation_type_id`='{$evaluation_type_id}',`status`='{$status}',`updated_by`='{$user_id}' WHERE `company_id`='{$company_id}' AND `branch_id`='{$branch_id}' AND `id`='{$id}'";
                                        if (mysqli_query($db, $update)) {
                                            $query = "UPDATE `employee_basic_infos` SET `title`='{$title}',`first_name`='{$first_name}',`last_name`='{$last_name}',`pseudo_name`='{$pseudo_name}',`father_name`='{$father_name}',`email`='{$email}',`official_email`='{$official_email}',`gender`='{$gender}',`blood_group`='{$blood_group}',`dob`='{$dob}',`pob`='{$pob}',`cnic`='{$cnic}',`cnic_expiry`='{$cnic_expiry}',`old_cnic`='{$old_cnic}',`country_id`='{$country_id}',`state_id`='{$state_id}',`city_id`={$city_id},`phone`='{$phone}',`dial_code`='{$dial_code}',`mobile`='{$mobile}',`iso`='{$iso}',`o_dial_code`='{$o_dial_code}',`other_mobile`='{$other_mobile}',`o_iso`='{$o_iso}',`relation`='{$relation}',`marital_status`='{$marital_status}',`religion`='{$religion}',`sect`='{$sect}',`address`='{$address}',`permanent_address`='{$permanent_address}',`personal_history`='{$personal_history}',`guardian_name`='{$guardian_name}',`guardian_dial_code`='{$guardian_dial_code}',`guardian_mobile`='{$guardian_mobile}',`guardian_iso`='{$guardian_iso}',`guardian_cnic`='{$guardian_cnic}',`guardian_relation`='{$guardian_relation}',`updated_by`='{$user_id}' WHERE `employee_id`='{$id}'";
                                            if (mysqli_query($db, $query)) {
                                                mysqli_query($db, "UPDATE `users` SET `email`='{$official_email}', `email_verified_at`=NULL, `updated_by`='{$user_id}' WHERE `employee_id`='{$id}'");
                                                if ($PayrollEntry) {
                                                    $check = mysqli_query($db, "SELECT `id` FROM `employee_payrolls` WHERE `employee_id`='{$id}'");
                                                    if (mysqli_num_rows($check) > 0) {
                                                        mysqli_query($db, "UPDATE `employee_payrolls` SET `joining_date`='{$JoiningDate}',`contract_start_date`='{$ContractStartDate}',`contract_end_date`='{$ContractEndDate}',`leaving_date`='{$LeavingDate}',`salary`='{$salary}',`updated_by`='{$user_id}' WHERE `employee_id`='{$id}'");
                                                    } else {
                                                        mysqli_query($db, "INSERT INTO `employee_payrolls`(`id`,`employee_id`,`joining_date`,`contract_start_date`,`contract_end_date`,`leaving_date`,`salary`, `added_by`) VALUES (NULL,'{$id}','{$JoiningDate}','{$ContractStartDate}','{$ContractEndDate}','{$LeavingDate}','{$salary}','{$user_id}')");
                                                    }
                                                }
                                            }
                                        }

                                    } else {
                                        $insert_employee = "INSERT INTO `employees`(`id`, `employee_code`, `department_id`, `team_id`, `designation_id`, `shift_id`, `evaluation_type_id`, `company_id`, `branch_id`, `status`, `added_by`) VALUES (NULL, '{$employee_code}', '{$department_id}', '{$team_id}', '{$designation_id}', '{$shift_id}', '{$evaluation_type_id}', '{$company_id}', '{$branch_id}', '{$status}','{$user_id}')";
                                        if (mysqli_query($db, $insert_employee)) {
                                            $insert_id = mysqli_insert_id($db);
                                            $basic_info = "INSERT INTO `employee_basic_infos`(`id`, `employee_id`, `title`, `first_name`, `last_name`, `pseudo_name`, `father_name`, `email`, `official_email`, `gender`, `blood_group`, `dob`, `pob`, `cnic`, `cnic_expiry`, `old_cnic`, `country_id`, `state_id`, `city_id`, `phone`, `dial_code`, `mobile`, `iso`, `o_dial_code`, `other_mobile`, `o_iso`, `relation`, `marital_status`, `religion`, `sect`, `address`, `permanent_address`, `personal_history`, `guardian_name`, `guardian_dial_code`, `guardian_mobile`, `guardian_iso`, `guardian_cnic`, `guardian_relation`, `added_by`) VALUES (NULL,'{$insert_id}','{$title}','{$first_name}','{$last_name}','{$pseudo_name}','{$father_name}','{$email}','{$official_email}','{$gender}','{$blood_group}','{$dob}','{$pob}','{$cnic}','{$cnic_expiry}','{$old_cnic}','{$country_id}','{$state_id}','{$city_id}','{$phone}','{$dial_code}','{$mobile}','{$iso}','{$o_dial_code}','{$other_mobile}','{$o_iso}','{$relation}','{$marital_status}','{$religion}','{$sect}','{$address}','{$permanent_address}','{$personal_history}','{$guardian_name}','{$guardian_dial_code}','{$guardian_mobile}','{$guardian_iso}','{$guardian_cnic}','{$guardian_relation}','{$user_id}')";
                                            if (mysqli_query($db, $basic_info)) {

                                                $password = md5($insert_id . '@medcareMSO');

                                                if ($employee_code == '1001') {
                                                    $user_status = '1';
                                                    $user_type = '1';
                                                } else if ($employee_code == '1006') {
                                                    $user_status = '1';
                                                    $user_type = '1';
                                                    $password = md5('hrm@12345');
                                                } else if ($employee_code == '1115') {
                                                    $user_status = '1';
                                                    $user_type = '1';
                                                } else if ($employee_code == '1581') {
                                                    $user_status = '1';
                                                    $user_type = '1';
                                                    $password = md5('medcaremso');
                                                } else if ($employee_code == '1682') {
                                                    $user_status = '1';
                                                    $user_type = '1';
                                                    $password = md5('Admin@123');
                                                } else {
                                                    $user_status = '0';
                                                    $user_type = '5';
                                                }

                                                $insert_user = "INSERT INTO `users`(`id`, `employee_id`, `email`, `password`, `email_verified_at`, `status`, `type`, `added_by`) VALUES (NULL, '{$insert_id}', '{$official_email}', '{$password}', NULL, '{$user_status}', '{$user_type}','{$user_id}')";
                                                mysqli_query($db, $insert_user);
                                                if ($PayrollEntry) {
                                                    $insert_payroll = "INSERT INTO `employee_payrolls`(`id`,`employee_id`,`joining_date`,`contract_start_date`,`contract_end_date`,`leaving_date`,`salary`, `added_by`) VALUES (NULL,'{$insert_id}','{$JoiningDate}','{$ContractStartDate}','{$ContractEndDate}','{$LeavingDate}','{$salary}','{$user_id}')";
                                                    mysqli_query($db, $insert_payroll);
                                                }
                                            }
                                        }
                                    }

                                } else {
                                    echo 'Evaluation Type "' . $data[7] . '" not exist at line no ' . $i . '<br>';
                                }
                            } else {
                                echo 'Salary Grade Detail "' . $data[6] . '" not exist at line no ' . $i . '<br>';
                            }
                        } else {
                            echo 'Salary Grade "' . $data[5] . '" not exist at line no ' . $i . '<br>';
                        }
                    } else {
                        echo 'Shift "' . $data[4] . '" not exist at line no ' . $i . '<br>';
                    }
                } else {
                    echo 'Designation "' . $data[3] . '" not exist at line no ' . $i . '<br>';
                }
            } else {
                echo 'Department "' . $data[1] . '" not exist at line no ' . $i . '<br>';
            }
        }
    }
    fclose($handle);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Upload CSV</title>
</head>
<body class="skin-blue">
<form method="post" enctype="multipart/form-data">
    <input type="file" name="csv_file"/>
    <br>
    <input type="submit" name="Insert Data">
</form>
</body>
</html>

