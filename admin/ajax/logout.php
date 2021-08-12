<?php
session_start();
if (isset($_POST['postData'])) {
    $object = (object)$_POST['postData'];
    if ($object->logout_co == $_SESSION['company_id'] &&
        $object->logout_br == $_SESSION['branch_id'] &&
        $object->logout_em == $_SESSION['employee_id'] &&
        $object->logout_us == $_SESSION['user_id']) {
        $_SESSION['company_id'] = $_SESSION['branch_id'] = $_SESSION['employee_id'] = $_SESSION['user_id'] = '';
        session_destroy();
        echo true;
    }
}
?>