<?php

include_once('../includes/connection.php');

if (isset($_POST['postData'])) {
    $object = (object)$_POST['postData'];

    $email = $object->email;

    if (empty($email)) {
        echo json_encode(["code" => 422, "errorMessageEmail" => 'Email field is required.']);
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["code" => 422, "errorMessageEmail" => 'Invalid Email Address.']);
    } else if (strpos($email, '*') !== false) {
        echo json_encode(["code" => 422, "errorMessageEmail" => 'special characters not allowed.']);
    } else {
        $select = "SELECT u.id, u.employee_id, u.email, u.status, u.deleted_at, emp.company_id, emp.branch_id, CONCAT( e.first_name, ' ', e.last_name) AS user_name FROM users AS u INNER JOIN employee_basic_infos AS e ON u.employee_id = e.employee_id INNER JOIN employees AS emp ON u.employee_id = emp.id WHERE u.email='{$email}' ORDER BY u.id ASC LIMIT 1";
        $query = mysqli_query($db, $select);
        if (mysqli_num_rows($query) > 0) {
            $result = mysqli_fetch_object($query);
            $user_id = $result->id;
            $employee_id = $result->employee_id;
            $email = $result->email;
            $status = $result->status;
            $deleted_at = $result->deleted_at;
            $company_id = $result->company_id;
            $branch_id = $result->branch_id;
            $user_name = $result->user_name;
            if ($status != 1 || !empty($deleted_at)) {
                echo json_encode(["code" => 405, "accessDeniedMessage" => "This account is not active so you can't change the password."]);
            } else {
                $new_password = generatePassword('15', true, true);
                $md5password = md5($new_password);
                if (mysqli_query($db, "UPDATE `users` SET `password`='{$md5password}' WHERE `id`='{$user_id}'")) {
                    $notification_type = config("notifications.type.value.password_reset");
                    $notification_status = config("notifications.status.value.pending");
                    $notification_body = getNotificationBody($notification_type);
                    insertNotification($notification_type, $employee_id, $employee_id, $user_id, $notification_body['message'], '', $notification_status, $company_id, $branch_id, $user_id);
                    $mail_body = getMailBody($notification_type, ['{mailToName}' => $user_name, '{mailTo}' => $email, '{newPassword}' => $new_password]);
                    $parameters = [
                        'subject' => $notification_type,
                        'data' => [
                            'email_body' => $mail_body['html'],
                            'message' => $mail_body['message'],
                        ],
                        'mailTo' => [
                            'email' => $email,
                            'name' => $user_name,
                        ],
                    ];
                    echo $response = sendEmail($parameters);
                } else {
                    echo json_encode(["code" => 405, "accessDeniedMessage" => 'Unexpected error.']);
                }
            }
        } else {
            echo json_encode(["code" => 405, "accessDeniedMessage" => 'The email not found.']);
        }
    }
}
?>