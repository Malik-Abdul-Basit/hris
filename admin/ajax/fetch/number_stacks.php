<?php
include_once('../../../includes/connection.php');

$global_company_id = $_SESSION['company_id'];
$global_branch_id = $_SESSION['branch_id'];

if (isset($_POST['filters']) && !empty($_POST['filters'])) {
    $filters = (object)$_POST['filters'];

    $pageNo = 1;
    $perPage = 10;
    $sortColumn = 'gp.id';
    $sortOrder = 'ASC';
    $condition = " WHERE gp.company_id='{$global_company_id}' AND gp.branch_id='{$global_branch_id}' AND gp.deleted_at IS NULL ";
    if (isset($filters->SearchQuery) && !empty($filters->SearchQuery) && strlen($filters->SearchQuery) > 0) {
        $condition .= " AND (gp.id LIKE '%{$filters->SearchQuery}%' OR dep.name LIKE '%{$filters->SearchQuery}%' OR ev.name LIKE '%{$filters->SearchQuery}%') ";
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
            $condition .= " AND ev.date BETWEEN '".$rangeStart."' and '".$rangeEnd."'";
            //$condition .= " AND " . $filterCol . " = '" . $filterVal . "'";
        }
    }

    $total = 0;
    $data = '';
    $sql = mysqli_query($db, "SELECT count(gp.id) AS total FROM evaluation_number_stacks AS gp INNER JOIN evaluations AS ev ON gp.evaluation_id=ev.id INNER JOIN departments AS dep ON dep.id=ev.department_id " . $condition);
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
            $h_col = '<div class="col-md-3"><b>Department</b></div><div class="col-md-3"><b>Evaluation Date</b></div><div class="col-md-2"><b>Action</b></div>';
            $right = true;
        } else {
            $h_col = '<div class="col-md-4"><b>Department</b></div><div class="col-md-4"><b>Evaluation Date</b></div>';
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
                                <div class="col-md-3"><b>Evaluation Name</b></div>'.$h_col.'
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
        $select = "SELECT gp.id, ev.department_id, dep.name,
        ev.name AS evaluation_name,ev.date
        FROM
            evaluation_number_stacks AS gp
        INNER JOIN 
            evaluations AS ev 
            ON gp.evaluation_id=ev.id 
        INNER JOIN 
            departments AS dep
            ON dep.id=ev.department_id " . $condition . $sort . $number_of_record;

        $query = mysqli_query($db, $select);
        if (mysqli_num_rows($query) > 0) {
            $row_number = 0;
            while ($result = mysqli_fetch_object($query)) {
                $row_number++;
                $evenOrOdd = ($row_number % 2) == 1 ? 'odd' : 'even';
                $department_name = empty($result->name) ? 'All Departments' : $result->name;

                $data .= '<tr style="left:0" data-row="' . $row_number . '" class="datatable-row  datatable-row-' . $evenOrOdd . '"><td>';
                $data .= '<div class="collapse-card-outer-wrapper">
                    <div class="collapse-card">
                        <div class="card-pane success">
                            <div class="row">
                                <div class="col-md-1 text-vertical-align-center">' . $result->id . '</div>
                                <div class="col-md-3 text-vertical-align-center">' . $result->evaluation_name . '</div>';
                if ($right) {
                    $data .= ' <div class="col-md-3 text-vertical-align-center">' . $department_name . '</div>
                                <div class="col-md-3 text-vertical-align-center">' . html_entity_decode(stripslashes(date('d-m-Y', strtotime($result->date)))) . '</div>
                                <div class="col-md-2 text-vertical-align-center">';
                    if (hasRight($filters->L, 'edit')) {
                        $data .= '<a href="' . $admin_url . 'number_stack?id=' . $result->id . '" class="btn btn-sm btn-light-primary font-weight-bolder text-uppercase mr-2" style="font-size: 10px" title="Edit">
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
                                <div class="col-md-4 text-vertical-align-center">' . html_entity_decode(stripslashes(date('d-m-Y', strtotime($result->date)))) . '</div>';
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
                $query_gpd = mysqli_query($db, "SELECT * FROM `evaluation_number_stack_details` WHERE `gp_id`='{$result->id}' ORDER BY `gp_value` DESC");
                if (mysqli_num_rows($query_gpd) > 0) {

                    $data .= '<div class="card-section-title mb-4">
                        <div class="card-section-title-inner">
                            <div class="row mb-2">
                                <div class="col-md-1 column"><b>Sr.</b></div>
                                <div class="col-md-3 column"><b>Name</b></div>
                                <div class="col-md-2 column text-center"><b>Condition</b></div>
                                <div class="col-md-2 column"><b>Value </b><small>In Numbers</small></div>
                                <div class="col-md-4 column"><b>Description</b></div>
                            </div>
                        </div>
                    </div>';
                    $sr = 0;
                    while ($result_gpd = mysqli_fetch_object($query_gpd)) {
                        $sr++;
                        $data .= '<div class="card-section-body">
                            <div class="row mt-5">
                                <div class="col-md-1 column">' . $sr . '</div>
                                <div class="col-md-3 column">' . $result_gpd->gp_name . '</div>
                                <div class="col-md-2 column text-center"> = </div>
                                <div class="col-md-2 column">' . $result_gpd->gp_value . '</div>
                                <div class="col-md-4 column">' . $result_gpd->gp_description . '</div>
                            </div>
                        </div>';
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