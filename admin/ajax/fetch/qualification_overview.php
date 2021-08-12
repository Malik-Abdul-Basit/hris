<?php
include_once('../../../includes/connection.php');

$global_company_id = $_SESSION['company_id'];
$global_branch_id = $_SESSION['branch_id'];
global $admin_url;

if (isset($_POST['filters']) && !empty($_POST['filters'])) {
    $filters = (object)$_POST['filters'];
    $actionButtons = '';
    $data = '';
    if (isset($filters->employee_id, $filters->employee_code) && !empty($filters->employee_id) && !empty($filters->employee_code)) {
        $sql = mysqli_query($db, "SELECT * FROM `employee_qualification_infos` WHERE `employee_id`='{$filters->employee_id}' ORDER BY `date_of_completion` DESC");
        if ((hasRight('employee_qualification', 'add') && mysqli_num_rows($sql) == 0) || (hasRight('employee_qualification', 'edit') && mysqli_num_rows($sql) > 0)) {
            $actionButtons .= '<div class="dropdown dropdown-inline mt-3">
                <a href="javascript:;" class="btn btn-clean btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="ki ki-bold-more-hor"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                    <ul class="navi navi-hover py-1">
                        <li class="navi-item">';
            if (hasRight('employee_qualification', 'add') && mysqli_num_rows($sql) == 0) {
                $actionButtons .= ' <a href="'.$admin_url.'employee_qualification?emp_code='.$filters->employee_code.'" class="navi-link">
                    <span class="navi-icon"><i class="la la-plus"></i></span>
                    <span class="navi-text">Add</span>
                </a>';
            } else if (hasRight('employee_qualification', 'edit') && mysqli_num_rows($sql) > 0) {
                $actionButtons .= ' <a href="'.$admin_url.'employee_qualification?id='.$filters->employee_id.'&emp_code='.$filters->employee_code.'"
                   class="navi-link">
                    <span class="navi-icon"><i class="flaticon2-pen"></i></span>
                    <span class="navi-text">Edit</span>
                </a>';
            }

            $actionButtons .= '</li>
                    </ul>
                </div>
            </div>';
        }
        if (mysqli_num_rows($sql) > 0) {
            $data .= '<div class="row mb-8">
                <div class="col-md-3">
                    <h3 class="font-size-lg text-dark-75 font-weight-bold mb-2">Degree</h3>
                </div>
                <div class="col-md-4">
                    <h3 class="font-size-lg text-dark-75 font-weight-bold mb-2">Institute</h3>
                </div>
                <div class="col-md-3">
                    <h3 class="font-size-lg text-dark-75 font-weight-bold mb-2">Year of Completion</h3>
                </div>
                <div class="col-md-2">
                    <h3 class="font-size-lg text-dark-75 font-weight-bold mb-2">Grade</h3>
                </div>
            </div>';
            while ($object = mysqli_fetch_object($sql)) {
                $grade = empty($object->grade) ? '-' : config('employee_qualification_infos.grade.title.' . $object->grade);
                $data .= '<div class="row mb-4 position-relative">
                    <div class="col-md-3">'.$object->degree.'</div>
                    <div class="col-md-4">'.$object->institute.'</div>
                    <div class="col-md-3">'.date('Y', strtotime($object->date_of_completion)).'</div>
                    <div class="col-md-2">'.$grade.'</div>';

                if (hasRight('employee_qualification', 'delete'))
                    $data .= '<button type="button" title="Delete" class="btn btn-outline-danger delete-small-button" onclick="entryDelete(' . $object->id . ', ' . $filters->employee_id . ')">Delete</button>';

                $data .= '</div>';
            }
        }
        else {
            $a ='';
            if (hasRight('employee_qualification', 'add')) {
                $a =' add information click <a href="'.$admin_url.'employee_qualification?emp_code='.$filters->employee_code.'">here.</a>';
            }
            $data .= '<div class="row mb-2">
                <div class="col-xl-12 text-center alert  alert-custom alert-light-danger">
                    <div class="alert-text">
                    Detail not found.'.$a.'
                    </div>
                </div>
            </div>';
        }
    }
    echo json_encode(['code' => 200, 'actionButtons' => $actionButtons, 'data' => $data]);
}
?>