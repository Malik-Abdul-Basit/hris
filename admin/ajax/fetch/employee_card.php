<?php
include_once('../../../includes/connection.php');

if (isset($_POST['previewEmployeeCard']) && !empty($_POST['previewEmployeeCard']) && is_numeric($_POST['previewEmployeeCard'])) {
    echo json_encode(getEmployeeCardHTML($_POST['previewEmployeeCard']));
}
?>