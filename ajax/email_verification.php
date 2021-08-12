<?php
include_once('../includes/connection.php');

$company_id = $_SESSION['company_id'];
$branch_id = $_SESSION['branch_id'];
$global_employee_id = $_SESSION['employee_id'];
global $db;

if (isset($_POST['postData'], $_POST['resendEmail']) && $_POST['resendEmail'] == true) {
    $object = (object)$_POST['postData'];
    $employee_id = $object->employee_id;

    if($employee_id == $global_employee_id){
        $select = "SELECT u.id AS user_id, email_verified_at
        FROM
            users AS u
        INNER JOIN 
            employees AS e
            ON u.employee_id = e.id
        WHERE e.id='{$employee_id}' AND e.company_id='{$company_id}' ORDER BY u.id DESC LIMIT 1";
        $sql = mysqli_query($db, $select);
        if (mysqli_num_rows($sql) > 0) {
            if ($fetch = mysqli_fetch_object($sql)) {
                if(empty($fetch->email_verified_at)){
                    echo sendEmailVerificationEmail($employee_id);
                }
            }
        }
    }

}


?>