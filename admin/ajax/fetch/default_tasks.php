<?php
include_once('../../../includes/connection.php');

$global_company_id = $_SESSION['company_id'];
$global_branch_id = $_SESSION['branch_id'];

if (isset($_POST['filters']) && !empty($_POST['filters'])) {
    $filters = (object)$_POST['filters'];

    $pageNo = 1;
    $perPage = 10;
    $sortColumn = 'edq.id';
    $sortOrder = 'ASC';
    $condition = " WHERE edq.company_id='{$global_company_id}' AND edq.branch_id='{$global_branch_id}' AND edq.deleted_at IS NULL ";
    if (isset($filters->SearchQuery) && !empty($filters->SearchQuery) && strlen($filters->SearchQuery) > 0) {
        $condition .= " AND (edq.id LIKE '%{$filters->SearchQuery}%' OR dep.name LIKE '%{$filters->SearchQuery}%' OR des.name LIKE '%{$filters->SearchQuery}%') ";
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

    $total = 0;
    $data = '';
    $sql = mysqli_query($db, "SELECT count(edq.id) AS total FROM evaluation_default_questions AS edq INNER JOIN departments AS dep ON dep.id=edq.department_id INNER JOIN designations AS des ON des.id=edq.designation_id  " . $condition);
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
            $h_col = '<div class="col-md-4"><b>Department</b></div><div class="col-md-4"><b>Designations</b></div><div class="col-md-2"><b>Action</b></div>';
            $right = true;
        } else {
            $h_col = '<div class="col-md-5"><b>Department</b></div><div class="col-md-5"><b>Designations</b></div>';
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
                                <div class="col-md-2"><b>ID</b></div>' . $h_col . '
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
        $select = "SELECT edq.id,
        dep.name AS department_name,
        des.name AS designation_name
        FROM 
            evaluation_default_questions AS edq 
        INNER JOIN 
            departments AS dep 
        ON dep.id=edq.department_id 
        INNER JOIN 
            designations AS des 
        ON des.id=edq.designation_id " . $condition . $sort . $number_of_record;

        $query = mysqli_query($db, $select);
        if (mysqli_num_rows($query) > 0) {
            $row_number = 0;
            while ($result = mysqli_fetch_object($query)) {
                $row_number++;
                $evenOrOdd = ($row_number % 2) == 1 ? 'odd' : 'even';

                $data .= '<tr style="left:0" data-row="' . $row_number . '" class="datatable-row  datatable-row-' . $evenOrOdd . '"><td>';
                $data .= '<div class="collapse-card-outer-wrapper">
                    <div class="collapse-card">
                        <div class="card-pane success">
                            <div class="row">
                                <div class="col-md-2 text-vertical-align-center">' . $result->id . '</div>';
                if ($right) {
                    $data .= ' <div class="col-md-4 text-vertical-align-center">' . $result->department_name . '</div>
                                <div class="col-md-4 text-vertical-align-center">' . $result->designation_name . '</div>
                                <div class="col-md-2 text-vertical-align-center">';
                    if (hasRight($filters->L, 'edit')){
                        $data .= '<a href="' . $admin_url . 'evaluation_tasks?id=' . $result->id . '" class="btn btn-sm btn-light-primary font-weight-bolder text-uppercase mr-2" style="font-size: 10px" title="Edit">
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
                    $data .= ' <div class="col-md-5 text-vertical-align-center">' . $result->department_name . '</div>
                                <div class="col-md-5 text-vertical-align-center">' . $result->designation_name . '</div>';
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
                $query_tasks = mysqli_query($db, "SELECT `id`,`task_heading`,`task_weight` FROM `evaluation_default_tasks` WHERE `eval_default_question_id`='{$result->id}' ORDER BY `eval_default_question_id` ASC");
                if (mysqli_num_rows($query_tasks) > 0) {
                    while ($result_tasks = mysqli_fetch_object($query_tasks)) {
                        $data .= '<div class="row"><div class="col-md-12"><div class="card card-custom m-5">
                        <div class="card-header font-weight-bolder bg-success px-2 py-5" style="border:none; color: #fff !important; min-height: auto !important;">
                            <div class="col-md-8 p-2 mb-3" style="border-bottom:1px solid #fff;"><b>Task Heading : </b> ' . $result_tasks->task_heading . '</div>
                            <div class="col-md-4 p-2 mb-3" style="border-bottom:1px solid #fff;"><b>Task Weight : </b>  ' . $result_tasks->task_weight . '%</div>
                            <div class="col-md-2">Sr.</div>
                            <div class="col-md-10">Task Description</div>
                        </div>
                        <div class="card-body p-0" style="border: 1px solid #f0f0f0">';
                        $query_taskd = mysqli_query($db, "SELECT `task_description` FROM `evaluation_default_task_details` WHERE `eval_default_task_id`='{$result_tasks->id}' ORDER BY `id` ASC");
                        if (mysqli_num_rows($query_taskd) > 0) {
                            $row_number = 0;
                            while ($result_taskd = mysqli_fetch_object($query_taskd)) {
                                $row_number++;
                                $evenOrOdd = ($row_number % 2) == 1 ? ' odd-line ' : ' even-line ';
                                $data .= '<div class="row m-0 px-2 py-4 ' . $evenOrOdd . '">
                                        <div class="col-md-2 column">' . $row_number . '</div>
                                        <div class="col-md-10 column">' . $result_taskd->task_description . '</div>
                                    </div>';
                            }
                        }
                        $data .= '</div></div></div></div>';
                    }
                }
                $data .= '  </div>
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