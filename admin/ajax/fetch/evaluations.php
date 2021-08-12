<?php
include_once('../../../includes/connection.php');

$global_company_id = $_SESSION['company_id'];
$global_branch_id = $_SESSION['branch_id'];
$global_employee_id = $_SESSION['employee_id'];

if (isset($_POST['filters']) && !empty($_POST['filters'])) {
    $filters = (object)$_POST['filters'];

    $pageNo = 1;
    $perPage = 10;
    $sortColumn = 'ev.date';
    $sortOrder = 'ASC';
    $condition = " WHERE ev.company_id='{$global_company_id}' AND ev.branch_id='{$global_branch_id}' AND ev.deleted_at IS NULL ";
    if (isset($filters->SearchQuery) && !empty($filters->SearchQuery) && strlen($filters->SearchQuery) > 0) {
        $condition .= " AND (ev.id LIKE '%{$filters->SearchQuery}%' OR des.name LIKE '%{$filters->SearchQuery}%' OR dep.name LIKE '%{$filters->SearchQuery}%') ";
    }

    if (!empty($filters->Filter) && isset($filters->Filter) && count($filters->Filter) > 0) {
        $queryFilter = (object)$filters->Filter;
        foreach ($queryFilter as $filterRow) {
            $filterCol = $filterRow['field'];
            $filterVal = $filterRow['value'];
            if ($filterVal != '' && $filterVal != '-1') {
                $condition .= " AND " . $filterCol . " = '" . $filterVal . "'";
            }
        }
    }

    if (isset($filters->DateRange) && !empty($filters->DateRange) && sizeof($filters->DateRange) > 0) {
        $range_object = (object)$filters->DateRange;
        if (!empty($range_object->rangeStart)) {
            $rangeStart = $range_object->rangeStart;
            $rangeEnd = !empty($range_object->rangeEnd) ? $range_object->rangeEnd : date('Y-m-d');
            //Date between '2011/02/25' and '2011/02/27'
            $condition .= " AND ev.date BETWEEN '" . $rangeStart . "' and '" . $rangeEnd . "'";
            //$condition .= " AND " . $filterCol . " = '" . $filterVal . "'";
        }
    }

    $total = 0;
    $data = '';
    $employee_info = getEmployeeInfoFromId($global_employee_id);

    if ($employee_info->user_type == config('users.type.value.supervisor') || $employee_info->user_type == config('users.type.value.resource')) {
        if ($employee_info->user_type == config('users.type.value.supervisor')) {
            $ids = join("','", getReporteesEmployees($global_employee_id));
        } else if ($employee_info->user_type == config('users.type.value.resource')) {
            $ids = join("','", getSiblings($global_employee_id, $employee_info->team_id));
        }
        $sql = mysqli_query($db, "SELECT `evaluation_id` FROM `evaluation_details` WHERE `employee_id` IN ('$ids') GROUP BY `evaluation_id`");
        if (mysqli_num_rows($sql) > 0) {
            $ids = [];
            while ($fetch = mysqli_fetch_object($sql)) {
                $ids[] = $fetch->evaluation_id;
            }
            $ids = array_unique($ids);
            $ids = join("','", $ids);
            $condition .= " AND ev.id IN ('$ids')";
        }
    }

    $sql = mysqli_query($db, "SELECT count(ev.id) AS total FROM evaluations AS ev INNER JOIN evaluation_types AS evt ON ev.evaluation_type_id=evt.id INNER JOIN departments AS dep ON ev.department_id=dep.id INNER JOIN designations AS des ON ev.designation_id=des.id " . $condition);
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

    if (isset($filters->L)) {
        if (hasRight($filters->L, 'edit') || hasRight($filters->L, 'delete')) {
            $h_col = '<div class="col-md-3"><b>Department</b></div><div class="col-md-2"><b>Designation</b></div><div class="col-md-2"><b>Action</b></div>';
            $right = true;
        } else {
            $h_col = '<div class="col-md-4"><b>Department</b></div><div class="col-md-3"><b>Designation</b></div>';
            $right = false;
        }
    }

    $data .= '<table class="datatable-table d-block" style="overflow:visible">
        <thead class="datatable-head">
            <tr style="left:0" class="datatable-row">
                <th>
                    <div class="collapse-card-outer-wrapper">
                        <div class="table-header">
                            <div class="row">
                                <div class="col-md-1"><b>ID</b></div>
                                <div class="col-md-2"><b>Evaluation Date</b></div>
                                <div class="col-md-2"><b>Evaluation Type</b></div>' . $h_col . '
                            </div>
                        </div>
                    </div>
                </th>
            </tr>
        </thead>
        <tbody class="datatable-body">';
    $not_found = '<tr style="left:0" data-row="1" class="datatable-row datatable-row-odd"><td class="datatable-cell-center datatable-cell"><div class="card card-custom gutter-b"><div class="card-body">Record Not Found.</div></div></td></tr></tbody></table>';

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
        $select = "SELECT ev.id, ev.department_id, ev.name AS evaluation_name, ev.date,
        evt.name AS evaluation_type,
        dep.name AS department_name,
        des.name AS designation_name
        FROM
            evaluations AS ev
        INNER JOIN
            evaluation_types AS evt
            ON ev.evaluation_type_id=evt.id
        INNER JOIN 
            departments AS dep
            ON ev.department_id=dep.id
        INNER JOIN 
            designations AS des 
            ON ev.designation_id=des.id " . $condition . $sort . $number_of_record;

        $query = mysqli_query($db, $select);
        if (mysqli_num_rows($query) > 0) {
            $row_number = 0;
            while ($result = mysqli_fetch_object($query)) {
                $row_number++;
                $evenOrOdd = ($row_number % 2) == 1 ? 'odd' : 'even';
                $department_name = $result->department_name;

                $data .= '<tr style="left:0" data-row="' . $row_number . '" class="datatable-row  datatable-row-' . $evenOrOdd . '"><td>';
                $data .= '<div class="collapse-card-outer-wrapper">
                    <div class="collapse-card">
                        <div class="card-pane success">
                            <div class="row">
                                <div class="col-md-1 text-vertical-align-center">' . $result->id . '</div>
                                <div class="col-md-2 text-vertical-align-center">' . html_entity_decode(stripslashes(date('d-m-Y', strtotime($result->date)))) . '</div>
                                <div class="col-md-2 text-vertical-align-center">' . $result->evaluation_type . '</div>';
                if ($right) {
                    $data .= '<div class="col-md-3 text-vertical-align-center">' . $department_name . '</div>
                                <div class="col-md-2 text-vertical-align-center">' . $result->designation_name . '</div>
                                <div class="col-md-2 text-vertical-align-center">';
                    if (hasRight($filters->L, 'edit')) {
                        $data .= '<a href="' . $admin_url . 'start_evaluation?id=' . $result->id . '" class="btn btn-sm btn-light-primary font-weight-bolder text-uppercase mr-2" style="font-size: 10px" title="Edit">
                                        <span class="navi-icon"><i class="flaticon2-pen" style="font-size: 12px"></i></span> Edit
                                    </a>';
                    }
                    if (hasRight($filters->L, 'delete')) {
                        $data .= '<button type="button" onclick="entryDelete(' . $result->id . ')" class="btn btn-sm btn-danger font-weight-bolder text-uppercase" style="font-size: 10px" title="Delete">
                                        <span class="navi-icon"><i class="flaticon-delete" style="font-size: 12px"></i></span> Delete
                                    </button>';
                    }
                    $data .= '</div>';
                } else {
                    $data .= '<div class="col-md-4 text-vertical-align-center">' . $department_name . '</div>
                                <div class="col-md-3 text-vertical-align-center">' . $result->designation_name . '</div>';
                }
                $data .= '</div>
                            <a aria-controls="collapse_' . $result->id . '" href="#collapse_' . $result->id . '"
                            aria-expanded="true" data-open="true"
                            data-toggle="collapse"
                            role="button"
                            class="card-collapse collapsed">
                                <i id="target_' . $result->id . '" data-open="false"
                                class="fas fa-chevron-up"></i>
                            </a>
                        </div>
                        <div id="collapse_' . $result->id . '" class="collapse">
                            <div class="card-section">';
                $queryd = mysqli_query($db, "SELECT evd.id, evd.evaluation_id, evd.parent_id, evd.employee_id, evd.status, evd.signed_url,
                emp.employee_code,
                CONCAT(eb.first_name,' ',eb.last_name) AS full_name, eb.email, eb.official_email,
                pemp.employee_code AS p_employee_code,
                CONCAT(peb.first_name,' ',peb.last_name) AS p_full_name, peb.email AS p_email, peb.official_email AS p_official_email,
                des.name AS designation_name
                FROM 
                    evaluation_details AS evd 
                INNER JOIN
                    employees AS emp
                    ON evd.employee_id = emp.id 
                INNER JOIN
                    employee_basic_infos AS eb
                    ON eb.employee_id = emp.id
                    
                INNER JOIN
                    employees AS pemp
                    ON evd.parent_id = pemp.id 
                INNER JOIN
                    employee_basic_infos AS peb
                    ON peb.employee_id = evd.parent_id
                INNER JOIN
                    designations AS des
                    ON emp.designation_id = des.id
                 WHERE evd.evaluation_id='{$result->id}' AND emp.deleted_at IS NULL");
                if (mysqli_num_rows($queryd) > 0) {
                    $data .= '<div class="card-section-title mb-4"><div class="card-section-title-inner"><div class="row mb-2">';
                    if ($employee_info->user_type == config('users.type.value.resource')) {
                        $data .= '<div class="col-md-5 column"><b>Appraise Info</b></div>
                        <div class="col-md-5 column"><b>Appraiser Info</b></div>
                        <div class="col-md-2 column"><b>Status</b></div>';

                    } else {
                        $data .= '<div class="col-md-4 column"><b>Appraise Info</b></div>
                        <div class="col-md-4 column"><b>Appraiser Info</b></div>
                        <div class="col-md-2 column"><b>Status</b></div>
                        <div class="col-md-2 column"><b>Action</b></div>';
                    }
                    $data .= '</div></div></div>';
                    $sr = 0;
                    while ($resultd = mysqli_fetch_object($queryd)) {
                        $sr++;
                        $url = $admin_url . 'view_evaluation?signature=' . $resultd->signed_url . '&ev=' . $resultd->evaluation_id . '&evd=' . $resultd->id . '&emp=' . $resultd->employee_id . '&p=' . $resultd->parent_id;
                        $data .= '<div class="card-section-body"><div class="row mt-5">';
                        if ($employee_info->user_type == config('users.type.value.resource')) {
                            $data .= '
                            <div class="col-md-5 column">
                                <b>Code:</b>
                                ' . $resultd->employee_code . '
                                <br><b>Full Name:</b>
                                ' . $resultd->full_name . '
                                <br><b>Official Email:</b>
                                ' . $resultd->official_email . '
                                </div>
                            <div class="col-md-5 column">
                                <b>Code:</b>
                                ' . $resultd->p_employee_code . '
                                <br><b>Full Name:</b>
                                ' . $resultd->p_full_name . '
                                <br><b>Official Email:</b>
                                ' . $resultd->p_official_email . '
                                </div>
                            <div class="col-md-2 column">
                                <span style="width:110px">
                                    <span class="label label-lg font-weight-bold label-inline ' . config('evaluation_details.status.class.' . $resultd->status) . '">' . config('evaluation_details.status.title.' . $resultd->status) . '</span>
                                </span>
                            </div>';
                        } else {
                            $data .= '<div class="col-md-4 column">
                                <b>Code:</b>
                                ' . $resultd->employee_code . '
                                <br><b>Full Name:</b>
                                ' . $resultd->full_name . '
                                <br><b>Official Email:</b>
                                ' . $resultd->official_email . '
                                </div>
                                <div class="col-md-4 column">
                                <b>Code:</b>
                                ' . $resultd->p_employee_code . '
                                <br><b>Full Name:</b>
                                ' . $resultd->p_full_name . '
                                <br><b>Official Email:</b>
                                ' . $resultd->p_official_email . '
                                </div>
                                <div class="col-md-2 column">
                                    <span style="width:110px">
                                        <span class="label label-lg font-weight-bold label-inline ' . config('evaluation_details.status.class.' . $resultd->status) . '">' . config('evaluation_details.status.title.' . $resultd->status) . '</span>
                                    </span>
                                </div>';

                            if ($employee_info->user_type == config('users.type.value.supervisor')) {
                                $data .= '<div class="col-md-2 column">
                                    <a href="' . $url . '" class="btn font-weight-bold btn-link-primary" title="View">View</a>
                                </div>';
                            } else {
                                $data .= '<div class="col-md-2 column">
                                    <a href="' . $url . '" class="btn font-weight-bold btn-link-primary" title="View">View</a>
                                    <button type="button" onclick="removeEmployeeFromEvaluation(' . $resultd->evaluation_id . ',' . $resultd->id . ')" class="btn font-weight-bold btn-link-danger ml-2" title="Remove">
                                    Remove
                                    </button>
                                    <button type="button" onclick="SendEmail(\'' . $url . '\',' . $resultd->employee_id . ',' . $resultd->parent_id . ')" class="btn font-weight-bold btn-link-success ml-2" title="Send E-Mail">
                                    Send E-Mail
                                    </button>
                                </div>';
                            }
                        }


                        $data .= '</div></div>';
                    }
                }

                $data .= '
                            </div>
                        </div>
                        <div class="card-footer-info">
                            <div class="d-block float-left overflow-hidden">
                                &nbsp;
                            </div>
                        </div>
                    </div>
                </div>';
                $data .= '</td></tr>';
            }
            $data .= '<input type="hidden" id="BG_SortColumn" value="' . $sortColumn . '"><input type="hidden" id="BG_SortOrder" value="' . $sortOrder . '"></tbody></table>';
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