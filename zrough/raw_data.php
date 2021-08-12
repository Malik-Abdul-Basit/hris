<?php
include_once('../includes/connection.php');

/*if (!function_exists('validTime')) {
    function validTime($value)
    {
        return preg_match('/^[0-9]:[0-9] [0-9]$/', $value);
    }
}*/

/*$parameters = [
    'subject' => 'test',
    //'replyTo' => [ 'email'=>$email, 'name'=> $user_name,],
    'mailTo' => [
        'user_id' => 7,
        'name' => 'Mr. Basit Khaliq',
        'email' => 'bkhaliq@medcaremso.com',
    ],
    //'cc' => [ 'email'=>'webxperts009@gmail.com', 'name'=> 'Basit Khaliq'  ],
    //'bcc' => ['email'=>'dislam@medcaremso.com','name'=> 'danial'],
];
$response = sendEmail($parameters);
echo $response;*/

//echo config("users.status.value.suspended");

/*
$employee_id='7';
$parent_info = getParentInfoFromEmpId($employee_id);
$employee_info = getEmployeeInfoFromId($employee_id);
echo '<pre>';
//print_r($parent_info);
print_r($employee_info);
echo '</pre>';*/


/*
$result = getNumberStacksOfEvaluation('1','1','2', '6');
echo '<pre>';
print_r($result);
echo '</pre>';

echo '<pre>';
print_r(getUserImage('7', ''));
echo '</pre>';

*/

/*
$select = "SELECT e.employee_code, e.department_id, e.team_id, e.designation_id, e.shift_id,  eb.*
        FROM 
            employees AS e
        INNER JOIN 
            employee_basic_infos AS eb
        ON e.id = eb.employee_id
        WHERE e.id > 55 ORDER BY e.id ASC";
        //WHERE (e.id IN ('8','30') OR e.id > '50' ) ORDER BY e.id ASC";//e.salary_grade_id, e.salary_grade_detail_id,

$query = mysqli_query($db, $select);
if (mysqli_num_rows($query) > 0) {
    while ($result = mysqli_fetch_assoc($query)) {
        echo '<pre>';
        print_r($result);
        echo '</pre>';
    }
}
*/


/*$select = "SELECT e.id, des.name, des.salary_grade_id, des.salary_grade_detail_id FROM
            employees AS e
        INNER JOIN 
            designations AS des
        ON des.id = e.designation_id
        ORDER BY e.id ASC";

$query = mysqli_query($db, $select);
if (mysqli_num_rows($query) > 0) {
    while ($result = mysqli_fetch_object($query)) {
        mysqli_query($db, "UPDATE `employees` SET `salary_grade_id`='{$result->salary_grade_id}',`salary_grade_detail_id`='{$result->salary_grade_detail_id}' WHERE `id`='{$result->id}'");
        //echo '<pre>';
        //print_r($result);
        //echo '</pre>';
    }
}*/


/*echo '<pre>';
print_r(getUserImage(7));
echo '</pre>';

echo '<pre>';
print_r(getReportEmpId(7));
echo '</pre>';
*/
/*
if(!validTime12('09:25 AM')){
    echo 'some error';
}
else{
    echo 'Good Job';
}

echo '<pre>';
print_r(getReporteesEmployees(2));
echo '</pre>';

echo '<pre>';
print_r(getSiblings('12', '2'));
echo '</pre>';
echo '<pre>';
print_r(getEmployeeInfoFromId(54));
echo '</pre>';



echo '<pre>';
print_r(getSalaryGrade('70000', '1'));
echo '</pre>';*/




?>