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
        $sql = mysqli_query($db, "SELECT * FROM `employee_payrolls` WHERE `employee_id`='{$filters->employee_id}' ORDER BY `joining_date` DESC LIMIT 1");
        $object = mysqli_fetch_object($sql);
        if ((hasRight('employee_payroll', 'add') && mysqli_num_rows($sql) == 0) || (hasRight('employee_payroll', 'delete') && mysqli_num_rows($sql) > 0) || (hasRight('employee_payroll', 'edit') && mysqli_num_rows($sql) > 0)) {
            $actionButtons .= '<div class="dropdown dropdown-inline mt-3">
                <a href="javascript:;" class="btn btn-clean btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="ki ki-bold-more-hor"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                    <ul class="navi navi-hover py-1">
                        <li class="navi-item">';
            if (hasRight('employee_payroll', 'add') && mysqli_num_rows($sql) == 0) {
                $actionButtons .= ' <a href="' . $admin_url . 'employee_payroll?emp_code=' . $filters->employee_code . '" class="navi-link">
                    <span class="navi-icon"><i class="la la-plus"></i></span>
                    <span class="navi-text">Add</span>
                </a>';
            } else if (hasRight('employee_payroll', 'edit') && mysqli_num_rows($sql) > 0) {
                $actionButtons .= ' <a href="' . $admin_url . 'employee_payroll?id=' . $filters->employee_id . '&emp_code=' . $filters->employee_code . '"
                   class="navi-link">
                    <span class="navi-icon"><i class="flaticon2-pen"></i></span>
                    <span class="navi-text">Edit</span>
                </a>';
            }
            if(hasRight('employee_payroll', 'delete') && mysqli_num_rows($sql) > 0){
                $actionButtons .= ' <a href="javascript:;" class="navi-link" onclick="entryDelete('.$object->id.', '.$object->employee_id.')">
                    <span class="navi-icon"><i class="la la-trash"></i></span>
                    <span class="navi-text">Delete</span>
                </a>';
            }

            $actionButtons .= '</li>
                    </ul>
                </div>
            </div>';
        }
        if (mysqli_num_rows($sql) > 0) {
            if ($object) {
                $leaving_date = !empty($object->leaving_date) && $object->leaving_date != '0000-00-00' ? date('d M Y', strtotime($object->leaving_date)) : '-';
                $contract_start_date = !empty($object->contract_start_date) && $object->contract_start_date != '0000-00-00' ? date('d M Y', strtotime($object->contract_start_date)) : '-';
                $contract_end_date = !empty($object->contract_end_date) && $object->contract_end_date != '0000-00-00' ? date('d M Y', strtotime($object->contract_end_date)) : '-';
                $ntn = !empty($object->ntn) ? $object->ntn : '-';
                $eobi_no = !empty($object->eobi_no) ? $object->eobi_no : '-';
                $pf_no = !empty($object->pf_no) ? $object->pf_no : '-';
                $salary = !empty($object->salary) ? number_format(decode($object->salary), 2) : '-';
                $pf = !empty($object->pf) ? number_format($object->pf, 2) : '-';
                $eobi = !empty($object->eobi) ? number_format($object->eobi, 2) : '-';
                $special_allowences = !empty($object->special_allowences) ? number_format($object->special_allowences, 2) : '-';
                $reimburse_value = !empty($object->reimburse_value) ? number_format($object->reimburse_value, 2) : '-';
                $deduct_pf = !empty($object->deduct_pf) ? number_format($object->deduct_pf, 2) : '-';
                $deduct_eobi = !empty($object->deduct_eobi) ? number_format($object->deduct_eobi, 2) : '-';
                $deduct_tax = !empty($object->deduct_tax) ? number_format($object->deduct_tax, 2) : '-';

                $data .= '<div class="row mb-2">
                    <div class="col-xl-12">
                        <h3 class="font-size-lg text-dark-75 font-weight-bold mb-8">Joining Detail:</h3>
                    </div>
                </div>';

                $data .= '<div class="row mb-2">
                    <div class="col-xl-6 col-lg-6">
                        <div class="row">
                            <label class="col-xl-6 col-lg-6"><b>Joining Date</b></label>
                            <div class="col-xl-6 col-lg-6">' . date('d M Y', strtotime($object->joining_date)) . '</div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        <div class="row">
                            <label class="col-xl-6 col-lg-6"><b>Leaving Date</b></label>
                            <div class="col-xl-6 col-lg-6">' . $leaving_date . '</div>
                        </div>
                    </div>
                </div>';

                $data .= '<div class="row mb-2">
                    <div class="col-xl-6 col-lg-6">
                        <div class="row">
                            <label class="col-xl-6 col-lg-6"><b>Contract Start Date</b></label>
                            <div class="col-xl-6 col-lg-6">' . $contract_start_date . '</div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        <div class="row">
                            <label class="col-xl-6 col-lg-6"><b>Contract Renewal Date</b></label>
                            <div class="col-xl-6 col-lg-6">' . $contract_end_date . '</div>
                        </div>
                    </div>
                </div>';

                $data .= '<div class="row mb-2">
                    <div class="col-lg-12">
                        <div class="separator separator-dashed my-10"></div>
                    </div>
                    <div class="col-lg-12">
                        <h3 class="font-size-lg text-dark-75 font-weight-bold mb-8">Payroll Detail:</h3>
                    </div>
                </div>';

                $data .= '<div class="row mb-2">
                    <div class="col-xl-6 col-lg-6">
                        <div class="row">
                            <label class="col-xl-6 col-lg-6"><b>NTN</b> <small>(National Tax Number)</small></label>
                            <div class="col-xl-6 col-lg-6">' . $ntn . '</div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        <div class="row">
                            <label class="col-xl-6 col-lg-6"><b>EOBI No.</b></label>
                            <div class="col-xl-6 col-lg-6">' . $eobi_no . '</div>
                        </div>
                    </div>
                </div>';

                $data .= '<div class="row mb-2">
                    <div class="col-xl-6 col-lg-6">
                        <div class="row">
                            <label class="col-xl-6 col-lg-6"><b>Provident Fund No.</b></label>
                            <div class="col-xl-6 col-lg-6">' . $pf_no . '</div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        <div class="row">
                            <label class="col-xl-6 col-lg-6"><b>Salary</b></label>
                            <div class="col-xl-6 col-lg-6">' . $salary . '</div>
                        </div>
                    </div>
                </div>';

                $data .= '<div class="row mb-2">
                    <div class="col-xl-6 col-lg-6">
                        <div class="row">
                            <label class="col-xl-6 col-lg-6"><b>Provident Fund</b></label>
                            <div class="col-xl-6 col-lg-6">' . $pf . '</div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        <div class="row">
                            <label class="col-xl-6 col-lg-6"><b>EOBI</b> <small>(Employees Old-Age Benefits Institution)</small></label>
                            <div class="col-xl-6 col-lg-6">' . $eobi . '</div>
                        </div>
                    </div>
                </div>';

                $data .= '<div class="row mb-2">
                    <div class="col-xl-6 col-lg-6">
                        <div class="row">
                            <label class="col-xl-6 col-lg-6"><b>Special Allowences</b></label>
                            <div class="col-xl-6 col-lg-6">' . $special_allowences . '</div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        <div class="row">
                            <label class="col-xl-6 col-lg-6"><b>Reimburse Value</b></label>
                            <div class="col-xl-6 col-lg-6">' . $reimburse_value . '</div>
                        </div>
                    </div>
                </div>';

                $data .= '<div class="row mb-2">
                    <div class="col-lg-12">
                        <div class="separator separator-dashed my-10"></div>
                    </div>
                    <div class="col-lg-12">
                        <h3 class="font-size-lg text-dark-75 font-weight-bold mb-8">
                            Deduction Detail:
                        </h3>
                    </div>
                </div>';

                $data .= '<div class="row mb-2">
                    <div class="col-xl-4 col-lg-4">
                        <div class="row">
                            <label class="col-xl-6 col-lg-6"><b>Provident Fund</b></label>
                            <div class="col-xl-6 col-lg-6">' . $deduct_pf . '</div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4">
                        <div class="row">
                            <label class="col-xl-6 col-lg-6"><b>EOBI</b></label>
                            <div class="col-xl-6 col-lg-6">' . $deduct_eobi . '</div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4">
                        <div class="row">
                            <label class="col-xl-6 col-lg-6"><b>Tax</b></label>
                            <div class="col-xl-6 col-lg-6">' . $deduct_tax . '</div>
                        </div>
                    </div>
                </div>';
            }
        } else {
            $a = '';
            if (hasRight('employee_payroll', 'add')) {
                $a = ' add information click <a href="' . $admin_url . 'employee_payroll?emp_code=' . $filters->employee_code . '">here.</a>';
            }
            $data .= '<div class="row mb-2">
                <div class="col-xl-12 text-center alert  alert-custom alert-light-danger">
                    <div class="alert-text">
                    Detail not found.' . $a . '
                    </div>
                </div>
            </div>';
        }
    }
    echo json_encode(['code' => 200, 'actionButtons' => $actionButtons, 'data' => $data]);
}
?>