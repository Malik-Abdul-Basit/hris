<?php

if ($_SERVER['HTTP_HOST'] == "localhost") {
    $live_db = mysqli_connect('localhost', 'root', '', 'careadwj_hris_hr47_db') or die(mysql_error());
    $local_db = mysqli_connect('localhost', 'root', '', 'hr47_mso') or die(mysql_error());
}

$select_old = "SELECT edq.id, d.name AS department_name, des.name AS designation_name
 FROM evaluation_default_questions AS edq 
 INNER JOIN departments AS d 
 ON d.id=edq.department_id
 INNER JOIN designations AS des
ON des.id=edq.designation_id
 ORDER BY edq.id ASC";
$sql_old = mysqli_query($live_db, $select_old);
if (mysqli_num_rows($sql_old) > 0) {
    while ($fetch_old = mysqli_fetch_object($sql_old)){
        $select_new = "SELECT id,name FROM departments WHERE `name`='{$fetch_old->department_name}' ORDER BY id ASC LIMIT 1";
        $sql_new = mysqli_query($local_db, $select_new);
        if (mysqli_num_rows($sql_new) > 0) {
            $fetch_department = mysqli_fetch_object($sql_new);
            $department_id = $fetch_department->id;
            $department_name = $fetch_department->name;
            //echo $department_name;echo '<br>';
            $sql_designation = mysqli_query($local_db, "SELECT `id`,`name` FROM designations WHERE `name`='{$fetch_old->designation_name}' ORDER BY id ASC LIMIT 1");
            if (mysqli_num_rows($sql_designation) > 0) {
                $fetch_designation = mysqli_fetch_object($sql_designation);
                $designation_id = $fetch_designation->id;
                $designation_name = $fetch_designation->name;
                $now = date('Y-m-d');
                mysqli_query($local_db,"INSERT INTO `evaluation_default_questions`(`id`, `department_id`, `designation_id`, `company_id`, `branch_id`, `added_by`, `created_at`, `updated_at`) VALUES (NULL, '{$department_id}', '{$designation_id}', '1', '1', '1', '{$now}', '{$now}')");
            }
            else{
                echo $fetch_old->department_name.' designation not found.';
                echo '<br>';
            }
        }
        else{
            echo 'department not found.';
            echo '<br>';
        }
    }
}


?>