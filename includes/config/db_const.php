<?php
include_once("db_tables/lang.php");
include_once("db_tables/main_menus.php");
include_once("db_tables/sub_menus.php");
include_once("db_tables/child_menus.php");
include_once("db_tables/companies.php");
include_once("db_tables/branches.php");
include_once("db_tables/designations.php");
include_once("db_tables/users.php");
include_once("db_tables/employees.php");
include_once("db_tables/employee_basic_infos.php");
include_once("db_tables/employee_qualification_infos.php");
include_once("db_tables/evaluation_details.php");
include_once("db_tables/evaluation_results.php");
include_once("db_tables/notifications.php");

/*function GetFiles() {
    $parent_dir = '../includes/config/db_tables';
    $dir = new DirectoryIterator($parent_dir);
    $returnArr = [];
    foreach($dir as $files ){
        $offset=100;
        $filename = substr($files,0,$offset);
        $explodedata = explode('.', $filename);
        if(end($explodedata) == 'php'){
            $returnArr[] = 'db_tables/'.$filename;
        }
    }
    return $returnArr;
}

$segmentArray = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$secondLastSegment = count($segmentArray) - 2;

if($segmentArray[$secondLastSegment] == 'admin'){
    if (!empty(GetFiles()) && sizeof(GetFiles()) > 0 && is_array(GetFiles())) {
        foreach (GetFiles() as $f) {
            include_once($f);
        }
    }
}*/

function config($n)
{
    $explodedRequest = explode('.', $n);
    $table = $explodedRequest[0];
    $tableObject = new $table;
    $return = $tableObject->getArray();

    if (!empty($return) && is_array($return) && sizeof($return) > 0) {
        foreach ($explodedRequest as $r) {
            if (is_array($return) && key_exists($r, $return)) {
                $return = $return[$r];
            } else {
                break;
            }
        }

    }
    return $return;
}

?>