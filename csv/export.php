<?php

function genrateCSV(array &$array)
{
    if (count($array) == 0)
        return null;

    ob_start();
    $df = fopen("php://output", 'w');
    fputcsv($df, array_keys(reset($array)));
    foreach ($array as $row) {
        fputcsv($df, $row);
    }
    fclose($df);
    return ob_get_clean();
}

function setHeaders($filename)
{
    // disable caching
    $now = gmdate("D, d M Y H:i:s");
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
    header("Last-Modified: {$now} GMT");

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-type: application/csv');

    // force download
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");

    // disposition / encoding on response body
    header("Content-Disposition: attachment;filename={$filename}");
    header("Content-Transfer-Encoding: binary");
}

include_once('../includes/connection.php');

$global_company_id = $_SESSION['company_id'];
$global_branch_id = $_SESSION['branch_id'];
$global_employee_id = $_SESSION['employee_id'];
$global_user_id = $_SESSION['user_id'];
$global_employee_info = getEmployeeInfoFromId($global_employee_id);
$user_status = $global_employee_info->user_status;
$user_type = $global_employee_info->user_type;

if (isset($global_company_id, $global_branch_id, $global_employee_id, $global_user_id)
    && is_numeric($global_company_id) && $global_company_id > 0
    && is_numeric($global_branch_id) && $global_branch_id > 0
    && is_numeric($global_employee_id) && $global_employee_id > 0
    && is_numeric($global_user_id) && $global_user_id > 0
    && $user_status == config('users.status.value.activated')
    && in_array($user_type, [config('users.type.value.super_admin'), config('users.type.value.admin'), config('users.type.value.manager')])) {

    $select = "SELECT
        emp.employee_code AS Employee_Code,
        dep.name AS Department,
        team.name AS Team,
        deg.name AS Designation,
        shift.name AS Shift,
        /*salary_grade.name AS Salary_Band,
        salary_gradeD.grade_name AS Salary_Grade,*/
        evaluation_type.name AS Evaluation_Type,
        empb.title,empb.first_name,empb.last_name,empb.pseudo_name,empb.father_name,empb.email,empb.official_email,empb.gender,empb.blood_group,empb.dob,empb.pob,empb.cnic,
        empb.cnic_expiry,empb.mobile,
        empb.other_mobile AS Emergency_Mobile_No,empb.relation AS Relation_With_Emergency_No,empb.phone,empb.marital_status,empb.religion,empb.sect,
        empb.address,empb.permanent_address,empb.personal_history,empb.guardian_name,empb.guardian_mobile,empb.guardian_cnic,empb.guardian_relation,
        payroll.joining_date, payroll.contract_start_date, payroll.contract_end_date AS contract_renewal_date,payroll.leaving_date,payroll.salary,
        emp_img.name AS Image
        FROM
            employees AS emp
        INNER JOIN 
            employee_basic_infos AS empb
            ON emp.id = empb.employee_id
        INNER JOIN 
            departments AS dep
            ON dep.id = emp.department_id
        INNER JOIN 
            designations AS deg
            ON deg.id = emp.designation_id
        INNER JOIN
            shifts AS shift
            ON shift.id = emp.shift_id
        /*INNER JOIN 
            salary_grades AS salary_grade
            ON salary_grade.id = emp.salary_grade_id
        INNER JOIN 
            salary_grade_details AS salary_gradeD
            ON salary_gradeD.id = emp.salary_grade_detail_id*/   
        INNER JOIN 
            evaluation_types AS evaluation_type
            ON evaluation_type.id = emp.evaluation_type_id
        LEFT JOIN 
            teams AS team
            ON team.id = emp.team_id
        LEFT JOIN 
            employee_payrolls AS payroll
            ON payroll.employee_id = emp.id
        LEFT JOIN 
            employee_images AS emp_img
            ON emp_img.employee_id = emp.id
        WHERE emp.company_id='{$global_company_id}' AND emp.branch_id='{$global_branch_id}' AND emp.deleted_at IS NULL AND emp_img.deleted_at IS NULL
        ORDER BY emp.employee_code ASC";
    $query = $db->query($select);

    if ($query->num_rows > 0) {
        $array = $r = [];
        while ($row = $query->fetch_assoc()) {
            $salary = decode($row['salary']);
            $row['salary'] = $salary;
            $row['gender'] = config('employee_basic_infos.gender.title.'.$row['gender']);
            $row['blood_group'] = config('employee_basic_infos.blood_group.title.'.$row['blood_group']);
            if(!empty($row['Relation_With_Emergency_No'])){
                $row['Relation_With_Emergency_No'] = config('employee_basic_infos.relation.title.'.$row['Relation_With_Emergency_No']);
            }
            if(!empty($row['marital_status'])){
                $row['marital_status'] = config('employee_basic_infos.marital_status.title.'.$row['marital_status']);
            }
            if(!empty($row['guardian_relation'])){
                $row['guardian_relation'] = config('employee_basic_infos.relation.title.'.$row['guardian_relation']);
            }
            $array [] = $row;
        }

        setHeaders("Employee-List (" . date("Y-M-d his") . ").csv");
        echo genrateCSV($array);
        die();
    }
    else{
        header('Location: ' . $admin_url.'employee_list');
    }
}
else{
    header('Location: ' . $page_not_found_url);
}

?>