<?php
include_once('../../../includes/connection.php');

$global_company_id = $_SESSION['company_id'];
$global_branch_id = $_SESSION['branch_id'];
$global_employee_id = $_SESSION['employee_id'];

if (isset($_POST['filters']) && !empty($_POST['filters'])) {
    $filters = (object)$_POST['filters'];

    $pageNo = 1;
    $perPage = 10;
    $sortColumn = 'e.employee_code';
    $sortOrder = 'ASC';
    $condition = " WHERE e.company_id='{$global_company_id}' AND e.branch_id='{$global_branch_id}' AND e.deleted_at IS NULL ";// AND e.id!='{$global_employee_id}'
    if (isset($filters->SearchQuery) && !empty($filters->SearchQuery) && strlen($filters->SearchQuery) > 0) {
        $condition .= " AND (e.employee_code LIKE '%{$filters->SearchQuery}%' OR CONCAT(eb.first_name,' ',eb.last_name) LIKE '%{$filters->SearchQuery}%' OR eb.pseudo_name LIKE '%{$filters->SearchQuery}%' OR eb.email LIKE '%{$filters->SearchQuery}%' OR eb.official_email LIKE '%{$filters->SearchQuery}%' OR CONCAT('+',eb.dial_code,' ',eb.mobile) LIKE '%{$filters->SearchQuery}%' OR CONCAT('+',eb.o_dial_code,' ',eb.other_mobile) LIKE '%{$filters->SearchQuery}%' OR eb.cnic LIKE '%{$filters->SearchQuery}%') ";
    }

    if (isset($filters->Filter) && !empty($filters->Filter) && count($filters->Filter) > 0) {
        $queryFilter = (object)$filters->Filter;
        //$filter_count = count($filters->Filter);//2
        //$filter_loop_counter=0;
        foreach ($queryFilter as $filterRow) {
            $filterCol = $filterRow['field'];
            $filterVal = $filterRow['value'];
            //$filter_loop_counter++;
            if ($filterVal != '' && $filterVal != '-1') {
                $condition .= " AND " . $filterCol . " = '" . $filterVal . "'";
            }
            //if($filter_loop_counter == $filter_count){ }
        }
    }

    $employee_info = getEmployeeInfoFromId($global_employee_id);

    if ($employee_info->user_type == config('users.type.value.supervisor')) {
        $ids = join("','", getReporteesEmployees($global_employee_id));
        $condition .= " AND e.id IN ('$ids')";
    } else if ($employee_info->user_type == config('users.type.value.resource')) {
        $ids = join("','", getSiblings($global_employee_id, $employee_info->team_id));
        $condition .= " AND e.id IN ('$ids')";
    }


    $total = 0;
    $data = '';
    $sql = mysqli_query($db, "SELECT count(e.id) AS total 
    FROM 
        employees AS e 
    INNER JOIN 
        employee_basic_infos AS eb 
        ON e.id = eb.employee_id
    INNER JOIN 
        departments AS dep
        ON e.department_id = dep.id
    INNER JOIN
        designations AS desg
        ON e.designation_id = desg.id
    LEFT JOIN
        teams AS t
        ON e.team_id = t.id " . $condition);
    if (mysqli_num_rows($sql) > 0) {
        $result = mysqli_fetch_object($sql);
        $total = $result->total;
    }

    if (isset($filters->Sort) && !empty($filters->Sort) && sizeof($filters->Sort) > 0) {
        $sort_object = (object)$filters->Sort;
        if (!empty($sort_object->SortColumn)) {
            $sortColumn = $sort_object->SortColumn;
        }
        if (!empty($sort_object->SortOrder)) {
            $sortOrder = $sort_object->SortOrder;
        }
    }

    $data .= '<table class="datatable-table d-block"><thead class="datatable-head"><tr style="left:0" class="datatable-row">';
    $data .= '<th data-field="employee_code" class="datatable-cell-center"><span style="width:100%;">&nbsp;</span></th></tr></thead><tbody class="datatable-body">';

    $not_found = '<tr style="left:0" class="datatable-row"><td class="datatable-cell-center datatable-cell"><div class="card card-custom gutter-b"><div class="card-body">Record Not Found.</div></div></td></tr></tbody></table>';

    if ($total > 0) {

        if (isset($filters->PageNumber) && !empty($filters->PageNumber) && strlen($filters->PageNumber) > 0) {
            $pageNo = $filters->PageNumber;
        }
        if (isset($filters->PageSize) && !empty($filters->PageSize) && strlen($filters->PageSize) > 0) {
            $perPage = $filters->PageSize;
        }

        $offset = round(round($pageNo) * round($perPage)) - round($perPage);
        $sort = " ORDER BY " . $sortColumn . " " . $sortOrder;
        if ($total <= $offset) {
            $number_of_record = " LIMIT 0, " . $total;
            $pageNo = 1;
        } else {
            $number_of_record = " LIMIT " . $offset . ", " . $perPage;
        }

        $select = "SELECT e.id, e.employee_code, e.status,
        eb.email, eb.official_email, eb.dob, eb.cnic, eb.dial_code, eb.mobile, eb.o_dial_code, eb.other_mobile, eb.cnic_expiry,
        CONCAT(eb.first_name,' ',eb.last_name) AS full_name,
        CONCAT('+',eb.dial_code,' ',eb.mobile) AS contact_no, 
        CONCAT('+',eb.o_dial_code,' ',eb.other_mobile) AS other_contact_no,
        dep.name AS department_name, desg.name AS designation_name, t.name AS team_name
        FROM 
            employees AS e
        INNER JOIN 
            employee_basic_infos AS eb
            ON e.id = eb.employee_id
        INNER JOIN
            departments AS dep
            ON e.department_id = dep.id
        INNER JOIN
            designations AS desg
            ON e.designation_id = desg.id
        LEFT JOIN
            teams AS t
            ON e.team_id = t.id " . $condition . $sort . $number_of_record;

        $query = mysqli_query($db, $select);
        if (mysqli_num_rows($query) > 0) {
            $row_number = 0;
            while ($result = mysqli_fetch_assoc($query)) {
                $row_number++;
                $evenOrOdd = ($row_number % 2) == 1 ? 'odd' : 'even';
                $checkImage = getUserImage($result["id"]);
                $image_path = $checkImage['image_path'];
                $img = $checkImage['img'];
                $default_image = $checkImage['default'];

                $dep = !empty($result["team_name"]) ? $result["department_name"] . ' &nbsp;<small>(' . $result["team_name"] . ') </small>' : $result["department_name"];

                $data .= '<tr style="left:0" data-row="' . $row_number . '" class="datatable-row  datatable-row-' . $evenOrOdd . '"><td><div class="card card-custom gutter-b"><div class="card-body">';
                $data .= '<div class="d-flex">';
                $data .= '<div class="flex-shrink-0 mr-7 dp-wrapper"><div class="image-input image-input-outline">';
                $data .= '<a href="' . $admin_url . 'profile_overview?emp_id=' . $result["id"] . '"><div class="image-input-wrapper" style="background-image: url(' . $image_path . ')"></div></a>';
                if ($default_image) {
                    if (hasRight('employee_image', 'add'))
                        $data .= '<div class="Tool-Tip" style="padding:60px 0 0 0;position:absolute;right:0;top:0">
                            <a href="' . $admin_url . 'employee_image?emp_code=' . $result["employee_code"] . '">
                                <label class="btn btn-xs btn-icon btn-circle btn-white btn-shadow user-dp" data-action="upload-image">
                                    <i class="fa fa-pen icon-sm text-muted"></i>
                                </label>
                            </a>
                            <span class="Tool-Tip-Text Tool-White" style="margin-left:-56px;min-width:110px;">Upload Image</span>
                        </div>';
                } else {
                    if (hasRight('employee_image', 'edit'))
                        $data .= '<div class="Tool-Tip" style="padding:60px 0 0 0;position:absolute;right:0;top:0">
                            <a href="' . $admin_url . 'employee_image?emp_code=' . $result["employee_code"] . '">
                                <label class="btn btn-xs btn-icon btn-circle btn-white btn-shadow user-dp" data-action="change-image">
                                    <i class="fa fa-pen icon-sm text-muted"></i>
                                </label>
                            </a>
                            <span class="Tool-Tip-Text Tool-White" style="margin-left:-56px;min-width:110px;">Change Image</span>
                        </div>';

                    if (hasRight('employee_image', 'delete'))
                        $data .= '<div class="Tool-Tip" style="padding:20px 0 0 0;position:absolute;right:0;bottom:0">
                            <span class="btn btn-xs btn-icon btn-circle btn-white btn-shadow  user-dp-remove ki ki-bold-close icon-xs text-muted" data-action="remove" data-id="' . $result["id"] . '" data-name="' . $img . '" onclick="deleteImage(event)"></span>
                            <span class="Tool-Tip-Text Tool-White" style="margin-left:-56px;min-width:110px;">Delete Image</span>
                        </div>';
                }
                $data .= '</div></div>';

                $data .= '<div class="flex-grow-1">
                        <div class="d-flex align-items-center justify-content-between flex-wrap mt-2">
                            <div class="mr-3">';

                if (hasRight('employee_profile', 'view')) {
                    $data .= '<a href="' . $admin_url . 'profile_overview?emp_id=' . $result["id"] . '"><span class="align-items-center text-dark font-size-h5 font-weight-bold mr-3">' . $result["full_name"] . config("employees.status.icon." . $result["status"]) . '</span></a>';
                } else if (hasRight('employee_qualification', 'view') || hasRight('employee_qualification', 'edit') || hasRight('employee_qualification', 'delete')) {
                    $data .= '<a href="' . $admin_url . 'qualification_overview?emp_id=' . $result["id"] . '"><span class="align-items-center text-dark font-size-h5 font-weight-bold mr-3">' . $result["full_name"] . config("employees.status.icon." . $result["status"]) . '</span></a>';
                } else if (hasRight('employee_experience', 'view') || hasRight('employee_experience', 'edit') || hasRight('employee_experience', 'delete')) {
                    $data .= '<a href="' . $admin_url . 'experience_overview?emp_id=' . $result["id"] . '"><span class="align-items-center text-dark font-size-h5 font-weight-bold mr-3">' . $result["full_name"] . config("employees.status.icon." . $result["status"]) . '</span></a>';
                } else if (hasRight('employee_payroll', 'view') || hasRight('employee_payroll', 'edit') || hasRight('employee_payroll', 'delete')) {
                    $data .= '<a href="' . $admin_url . 'payroll_overview?emp_id=' . $result["id"] . '"><span class="align-items-center text-dark font-size-h5 font-weight-bold mr-3">' . $result["full_name"] . config("employees.status.icon." . $result["status"]) . '</span></a>';
                } else {
                    $data .= '<span><span class="align-items-center text-dark font-size-h5 font-weight-bold mr-3">' . $result["full_name"] . config("employees.status.icon." . $result["status"]) . '</span></span>';
                }

                $data .= '<div class="d-flex flex-wrap my-2">
                                    <span class="text-muted font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">
                                        <i class="icon-md fas fa-address-card float-left" style="margin:1px 5px 0 0;"></i>
                                        ' . $result["employee_code"] . '
                                    </span>
                                    <span class="text-muted font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">
                                        <i class="icon-md fas fa-envelope float-left" style="margin:2px 5px 0 0;"></i>
                                        ' . $result["official_email"] . '
                                    </span>
                                    <span class="text-muted font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">
                                        <i class="icon-md fas fa-medal float-left" style="margin:2px 5px 0 0;"></i>
                                        ' . $result["designation_name"] . '
                                    </span>
                                    <span class="text-muted font-weight-bold">
                                        <i class="icon-md fas fa-building float-left" style="margin:2px 5px 0 0;"></i>
                                        ' . $dep . '
                                    </span>
                                </div>
                            </div>';

                if (isset($filters->L) || $employee_info->user_type == config('users.type.value.super_admin') || $employee_info->user_type == config('users.type.value.admin') || $employee_info->user_type == config('users.type.value.manager')) {
                    $data .= '<div class="my-lg-0 my-1">';

                    $data .= '<button type="button" class="btn btn-sm btn-light-success font-weight-bolder text-uppercase mr-2" onclick="previewEmployeeCard(' . $result['id'] . ')">
                            Preview Card
                            </button>';

                    if (hasRight($filters->L, 'edit') || hasRight($filters->L, 'delete')) {
                        if (hasRight($filters->L, 'edit'))
                            $data .= '<a href="' . $admin_url . 'employee?id=' . $result['id'] . '" class="btn btn-sm btn-light-primary font-weight-bolder text-uppercase mr-2" title="Edit">Edit</a>';

                        if (hasRight($filters->L, 'delete'))
                            $data .= '<button type="button" onclick="entryDelete(' . $result['id'] . ')" class="btn btn-sm btn-primary font-weight-bolder text-uppercase" title="Delete">Delete</button>';

                    }
                    $data .= '</div>';
                }


                $data .= '</div>
                        <div class="d-flex align-items-center flex-wrap justify-content-between">
                            <div class="flex-grow-1 font-weight-bold text-dark-50 py-2 py-lg-2 mr-5 text-left">
                                I distinguish three main text objectives could be merely to inform people.<br>
                                A second could be persuade people. You want people to bay objective.
                            </div>
                            <div class="d-flex mt-4 mt-sm-0">
                                <span class="font-weight-bold mr-4">Progress</span>
                                <div class="progress progress-xs mt-2 mb-2 flex-shrink-0 w-150px w-xl-250px">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 63%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="font-weight-bolder text-dark ml-4">78%</span>
                            </div>
                        </div>
                    </div>';


                if (in_array($employee_info->user_type, [config('users.type.value.super_admin'), config('users.type.value.admin'), config('users.type.value.manager')])) {
                    $data .= '</div><div class="separator separator-solid my-7"></div>';
                    $data .= ' <div class="d-flex align-items-center flex-wrap">
                    <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                        <span class="mr-4">
                            <i class="icon-xl fas fas fa-phone-alt text-muted"></i>
                        </span>
                        <div class="d-flex flex-column flex-lg-fill">
                            <span class="text-dark-75 font-weight-bolder font-size-sm">Mobile No.</span>
                            <span class="font-weight-bolder font-size-h6">' . $result["contact_no"] . '</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                        <span class="mr-4">
                            <i class="flaticon-support icon-2x text-muted font-weight-bold"></i>
                        </span>
                        <div class="d-flex flex-column flex-lg-fill">
                            <span class="text-dark-75 font-weight-bolder font-size-sm">Emergency Contact</span>
                            <span class="font-weight-bolder font-size-h6">' . $result["other_contact_no"] . '</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                        <span class="mr-4">
                            <i class="flaticon-gift icon-2x text-muted font-weight-bold"></i>
                        </span>
                        <div class="d-flex flex-column text-dark-75">
                            <span class="font-weight-bolder font-size-sm">Date of Birth</span>
                            <span class="font-weight-bolder font-size-h6">
                              ' . date('d M Y', strtotime($result['dob'])) . '
                            </span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                        <span class="mr-4">
                            <i class="la la-id-card text-muted" style="font-size:2.75rem"></i>
                        </span>
                        <div class="d-flex flex-column text-dark-75">
                            <span class="font-weight-bolder font-size-sm">CNIC</span>
                            <span class="font-weight-bolder font-size-h6">
                              ' . $result['cnic'] . '
                            </span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                        <span class="mr-4">
                            <i class="flaticon-calendar-1 icon-2x text-muted font-weight-bold"></i>
                        </span>
                        <div class="d-flex flex-column">
                            <span class="text-dark-75 font-weight-bolder font-size-sm">CNIC Expiry</span>
                            <span class="font-weight-bolder font-size-h6">
                              ' . date('d M Y', strtotime($result['cnic_expiry'])) . '
                            </span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center flex-lg-fill my-1">
                        <span class="mr-4">
                            <i class="flaticon-network icon-2x text-muted font-weight-bold"></i>
                        </span>
                        <div class="symbol-group symbol-hover">
                            <div class="symbol symbol-30 symbol-circle" data-toggle="tooltip" title="" data-original-title="Mark Stone">
                                <img alt="Pic" src="../assets/theme_assets/media/users/300_25.jpg">
                            </div>
                            <div class="symbol symbol-30 symbol-circle" data-toggle="tooltip" title="" data-original-title="Charlie Stone">
                                <img alt="Pic" src="../assets/theme_assets/media/users/300_19.jpg">
                            </div>
                            <div class="symbol symbol-30 symbol-circle" data-toggle="tooltip" title="" data-original-title="Luca Doncic">
                                <img alt="Pic" src="../assets/theme_assets/media/users/300_22.jpg">
                            </div>
                            <div class="symbol symbol-30 symbol-circle" data-toggle="tooltip" title="" data-original-title="Nick Mana">
                                <img alt="Pic" src="../assets/theme_assets/media/users/300_23.jpg">
                            </div>
                            <div class="symbol symbol-30 symbol-circle" data-toggle="tooltip" title="" data-original-title="Teresa Fox">
                                <img alt="Pic" src="../assets/theme_assets/media/users/300_18.jpg">
                            </div>
                            <div class="symbol symbol-30  symbol-circle symbol-light" data-toggle="tooltip" title="" data-original-title="More users">
                                <span class="symbol-label font-weight-bold">5+</span>
                            </div>
                        </div>
                    </div>
                </div>';
                }

                $data .= '</div></div></td></tr>';
            }
            $data .= '</tbody></table>';
            //$data.='<input type="hidden" id="BG_SortColumn" value="'.$sortColumn.'"><input type="hidden" id="BG_SortOrder" value="'.$sortOrder.'">';
            //$data.='<input type="hidden" id="BG_FilterColumn" value="'.$sortColumn.'"><input type="hidden" id="BG_FilterValue" value="'.$sortOrder.'">';
            $data .= getPaginationNumbering($pageNo, $perPage, $total, $filters->PageSizeStack);
        } else {
            $data .= $not_found;
        }
    } else {
        $data .= $not_found;
    }

    echo json_encode(['code' => 200, 'data' => $data]);
}
?>