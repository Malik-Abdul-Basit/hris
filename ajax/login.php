<?php

include_once('../includes/connection.php');

if (isset($_POST['postData'])) {
    $object = (object)$_POST['postData'];

    $email = $object->email;
    $password = $object->password;

    if (empty($email)) {
        echo json_encode(["code" => 422, "errorMessageEmail" => 'Email field is required.']);
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["code" => 422, "errorMessageEmail" => 'Invalid Email Address.']);
    } else if (strpos($email, '*') !== false) {
        echo json_encode(["code" => 422, "errorMessageEmail" => 'special characters not allowed.']);
    } else if (empty($password)) {
        echo json_encode(["code" => 422, "errorMessagePassword" => 'Password field is required.']);
    } else {
        $password = md5($password);
        $select = "
            SELECT u.id AS user_id, u.email AS user_email, u.email_verified_at, u.status, u.deleted_at AS user_delete,
            emp.id AS emp_id, emp.status AS emp_status, emp.deleted_at AS emp_delete, emp.company_id,
            dep.deleted_at AS department_delete,
            des.deleted_at AS designation_delete,
            co.deleted_at AS company_delete, co.status AS company_status
            FROM
                users AS u
            INNER JOIN 
                employees AS emp
                ON u.employee_id = emp.id
            INNER JOIN 
                departments AS dep
                ON emp.department_id = dep.id
            INNER JOIN 
                designations AS des
                ON emp.designation_id = des.id
            INNER JOIN 
                companies AS co
                ON emp.company_id = co.id
            WHERE u.email='{$email}' AND u.password='{$password}'";
        $query = mysqli_query($db, $select);
        if (mysqli_num_rows($query) > 0) {
            if ($result = mysqli_fetch_object($query)) {
                if (!empty($result->company_delete)) {
                    echo json_encode(["code" => 405, "accessDeniedMessage" => 'Your company has been deleted.']);
                } else if ($result->company_status != config("companies.status.value.working")) {
                    echo json_encode(["code" => 405, "accessDeniedMessage" => 'Your company has been closed.']);
                } else if (!empty($result->department_delete)) {
                    echo json_encode(["code" => 405, "accessDeniedMessage" => 'Attached department has been deleted.']);
                } else if (!empty($result->designation_delete)) {
                    echo json_encode(["code" => 405, "accessDeniedMessage" => 'Attached designation has been deleted.']);
                } else if (!empty($result->emp_delete)) {
                    echo json_encode(["code" => 405, "accessDeniedMessage" => 'Your employee id has been deleted.']);
                } else if ($result->emp_status != config("employees.status.value.working")) {
                    echo json_encode(["code" => 405, "accessDeniedMessage" => 'This employee has quit the job.']);
                } else if (!empty($result->user_delete)) {
                    echo json_encode(["code" => 405, "accessDeniedMessage" => 'Your account has been deleted.']);
                } else if ($result->status == config("users.status.value.pending")) {
                    echo json_encode(["code" => 405, "accessDeniedMessage" => 'Your account is under approval.']);
                } else {
                    if ($result->status == config("users.status.value.activated")) {

                        $_SESSION['company_id'] = $result->company_id;
                        $_SESSION['branch_id'] = '1';
                        $_SESSION['employee_id'] = $result->emp_id;

                        if (empty($result->email_verified_at)) {
                            $select = "SELECT `id`, `signed_url` FROM `email_verification_details` WHERE `user_id`='{$result->user_id}' AND `deleted_at` IS NULL";
                            $query = mysqli_query($db, $select);
                            if (mysqli_num_rows($query) == 0) {
                                $verification_code = generatePassword(12, true, false);
                                $signed_url = generatePassword(56, true, false);
                                $insert = "INSERT INTO `email_verification_details`(`id`, `user_id`, `verification_code`, `signed_url`) VALUES (NULL, '{$result->user_id}', '{$verification_code}', '{$signed_url}')";
                                mysqli_query($db, $insert);
                            }
                            sendEmailVerificationEmail($_SESSION['employee_id']);
                            echo json_encode(["code" => 200, "page" => 'email_confirmation']);
                        } else {
                            $_SESSION['user_id'] = $result->user_id;
                            echo json_encode(["code" => 200, "page" => 'admin/dashboard']);
                        }
                    } else {
                        echo json_encode(["code" => 405, "accessDeniedMessage" => 'Your account is ' . strtolower(config("users.status.title." . $result->status)) . '.']);
                    }
                }
            }
        } else {
            echo json_encode(["code" => 405, "accessDeniedMessage" => 'The email or password is incorrect.']);
        }
    }
}
?>