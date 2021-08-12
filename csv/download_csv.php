<?php
include_once('../includes/connection.php');

if (isset($_POST['download']) && $_POST['download']=='employees') {
    echo $base_url.'csv/export.php';
}



?>