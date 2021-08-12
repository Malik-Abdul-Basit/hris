<?php
include_once('../../../includes/connection.php');

$global_company_id = $_SESSION['company_id'];
$global_branch_id = $_SESSION['branch_id'];

if (isset($_POST['filters']) && !empty($_POST['filters'])) {
    $filters = (object)$_POST['filters'];

    $pageNo = 1;
    $perPage = 10;
    $sortColumn = 'sort_by';
    $sortOrder = 'ASC';
    $condition = " WHERE `company_id`='{$global_company_id}' AND `branch_id`='{$global_branch_id}' AND `deleted_at` IS NULL";
    if (isset($filters->SearchQuery) && !empty($filters->SearchQuery) && strlen($filters->SearchQuery) > 0) {
        $condition .= " AND (`id` LIKE '%{$filters->SearchQuery}%' OR `name` LIKE '%{$filters->SearchQuery}%' OR `sort_by` LIKE '%{$filters->SearchQuery}%') ";
    }

    $total = 0;
    $data = '';
    $sql = mysqli_query($db, "SELECT count(id) AS total FROM `shifts`" . $condition);
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

    if (isset($filters->Numbering) && !empty($filters->Numbering) && sizeof($filters->Numbering) > 0) {
        $sr = (object)$filters->Numbering;
        $sr_classes = 'datatable-cell';
        $dSortOrder = $sortIcon = $setSort = '';
        if (isset($sr->sort) && $sr->sort === "true" && $total > 1) {
            $sr_classes .= ' datatable-cell-sort';
            $setSort = ' onclick="setSort(event)"';
            if ($sortColumn == $sr->field) {
                $sr_classes .= ' datatable-cell-sorted';
                $dSortOrder = ' data-sort="' . $sortOrder . '"';
                $sortIcon = ($sortOrder == 'ASC' || $sortOrder == 'asc') ? ' class="flaticon2-arrow-up sortIcon"' : ' class="flaticon2-arrow-down sortIcon"';
            }
        }
        $sr_classes .= (isset($sr->text) && !empty($sr->text)) ? ' datatable-cell-' . $sr->text : '';
        $sr_style = (isset($sr->style) && !empty($sr->style)) ? $sr->style : '';
        $data .= '<th data-field="' . $sr->field . '" class="' . $sr_classes . '"' . $dSortOrder . $setSort . '>';
        $data .= '<span ' . $sr_style . $sortIcon . ' data-field="' . $sr->field . '"' . $dSortOrder . '>' . $sr->title . '</span>';
        $data .= '</th>';
    }

    foreach ($filters->Header as $key => $value) {
        $c = (object)$value;
        $col_classes = 'datatable-cell';
        $dSortOrder = $sortIcon = $setSort = '';
        if (isset($c->sort) && $c->sort === "true" && $total > 1) {
            $col_classes .= ' datatable-cell-sort';
            $setSort = ' onclick="setSort(event)"';
            if ($sortColumn == $c->field) {
                $col_classes .= ' datatable-cell-sorted';
                $dSortOrder = ' data-sort="' . $sortOrder . '"';
                $sortIcon = ($sortOrder == 'ASC' || $sortOrder == 'asc') ? ' class="flaticon2-arrow-up sortIcon"' : ' class="flaticon2-arrow-down sortIcon"';
            }
        }
        $col_classes .= (isset($c->text) && !empty($c->text)) ? ' datatable-cell-' . $c->text : '';
        $col_style = (isset($c->style) && !empty($c->style)) ? $c->style : '';

        $data .= '<th data-field="' . $c->field . '" class="' . $col_classes . '"' . $dSortOrder . $setSort . '>';
        $data .= '<span ' . $col_style . $sortIcon . ' data-field="' . $c->field . '"' . $dSortOrder . '>' . $c->title . '</span>';
        $data .= '</th>';
    }

    if (isset($filters->L)) {
        if (hasRight($filters->L, 'edit') || hasRight($filters->L, 'delete')) {
            if (isset($filters->Actions) && !empty($filters->Actions) && sizeof($filters->Actions) > 0) {
                $ac = (object)$filters->Actions;
                $ac_classes = 'datatable-cell';
                $setSort = ' onclick="setSort(event)"';
                $dSortOrder = $sortIcon = $setSort = '';
                if (isset($ac->sort) && $ac->sort === "true" && $total > 1) {
                    $ac_classes .= ' datatable-cell-sort';
                    if ($sortColumn == $ac->field) {
                        $ac_classes .= ' datatable-cell-sorted';
                        $dSortOrder = ' data-sort="' . $sortOrder . '"';
                        $sortIcon = ($sortOrder == 'ASC' || $sortOrder == 'asc') ? '<i class="flaticon2-arrow-up"></i>' : '<i class="flaticon2-arrow-down"></i>';
                    }
                }
                $ac_classes .= (isset($ac->text) && !empty($ac->text)) ? ' datatable-cell-' . $ac->text : '';
                $ac_style = (isset($ac->style) && !empty($ac->style)) ? $ac->style : '';

                $data .= '<th data-field="' . $ac->field . '" class="' . $ac_classes . '"' . $dSortOrder . $setSort . '>';
                $data .= '<span ' . $ac_style . '>' . $ac->title . $sortIcon . '</span>';
                $data .= '</th>';
            }
        }
    }

    $data .= '</tr></thead>';
    $not_found = '</table><div style="display:block;font-size:13px;font-weight:bold;padding:15px;text-align:center;width:100%">Record Not Found.</div>';

    if ($total > 0) {

        if (isset($filters->PageNumber) && !empty($filters->PageNumber) && strlen($filters->PageNumber) > 0) {
            $pageNo = $filters->PageNumber;
        }
        if (isset($filters->PageSize) && !empty($filters->PageSize) && strlen($filters->PageSize) > 0) {
            $perPage = $filters->PageSize;
        }

        $offset = round(round($pageNo) * round($perPage)) - round($perPage);
        $sort = " ORDER BY `" . $sortColumn . "` " . $sortOrder;
        if ($total <= $offset) {
            $number_of_record = " LIMIT 0, " . $total;
            $pageNo = 1;
        } else {
            $number_of_record = " LIMIT " . $offset . ", " . $perPage;
        }

        $select = "SELECT `id`,`name`,`from`,`to`,`sort_by` FROM `shifts`" . $condition . $sort . $number_of_record;

        $query = mysqli_query($db, $select);
        if (mysqli_num_rows($query) > 0) {
            $row_number = 0;
            $data .= '<tbody class="datatable-body">';
            while ($result = mysqli_fetch_assoc($query)) {
                $row_number++;
                $evenOrOdd = ($row_number % 2) == 1 ? 'odd' : 'even';
                $data .= '<tr style="left:0" data-row="' . $row_number . '" class="datatable-row  datatable-row-' . $evenOrOdd . '">';
                if (isset($filters->Numbering) && !empty($filters->Numbering) && sizeof($filters->Numbering) > 0) {
                    $sr = (object)$filters->Numbering;
                    $sr_text = (isset($sr->text) && !empty($sr->text)) ? ' datatable-cell-' . $sr->text : '';
                    $sr_style = (isset($sr->style) && !empty($sr->style)) ? $sr->style : '';
                    $data .= '<td data-field="' . $sr->field . '" class="datatable-cell' . $sr_text . '">';
                    $data .= '<span ' . $sr_style . '>' . $row_number . '</span>';
                    $data .= '</td>';
                }
                foreach ($filters->Header as $key => $value) {
                    $c = (object)$value;
                    $f = $c->field;
                    if ($f == 'from' || $f == 'to') {
                        $res = date('h:i A', strtotime($result[$f]));
                    } else {
                        $res = $result[$f];
                    }
                    $c_text = (isset($c->text) && !empty($c->text)) ? ' datatable-cell-' . $c->text : '';
                    $c_style = (isset($c->style) && !empty($c->style)) ? $c->style : '';
                    $data .= '<td data-field="' . $c->field . '" class="datatable-cell' . $c_text . '">';
                    $data .= '<span ' . $c_style . '>' . $res . '</span>';
                    $data .= '</td>';
                }

                if (isset($filters->L)) {
                    if (hasRight($filters->L, 'edit') || hasRight($filters->L, 'delete')) {
                        if (isset($filters->Actions) && !empty($filters->Actions) && sizeof($filters->Actions) > 0) {
                            $ac = (object)$filters->Actions;
                            $ac_text = (isset($ac->text) && !empty($ac->text)) ? ' datatable-cell-' . $ac->text : '';
                            $ac_style = (isset($ac->style) && !empty($ac->style)) ? $ac->style : '';
                            $data .= '<td data-field="' . $ac->field . '" class="datatable-cell' . $ac_text . '">';
                            $data .= '<span ' . $ac_style . '>';
                            if (hasRight($filters->L, 'edit'))
                                $data .= '<a href="' . $admin_url . 'shift?id=' . $result['id'] . '" class="btn btn-sm btn-clean btn-icon" title="Edit"><i class="la la-edit"></i></a>';

                            if (hasRight($filters->L, 'delete'))
                                $data .= '<button type="button" onclick="entryDelete(' . $result['id'] . ')" class="btn btn-sm btn-clean btn-icon" title="Delete"><i class="la la-trash"></i></button>';

                            $data .= '</span></td>';
                        }
                    }
                }

                $data .= '</tr>';
            }
            $data .= '</tbody></table>';
            $data .= '<input type="hidden" id="BG_SortColumn" value="' . $sortColumn . '"><input type="hidden" id="BG_SortOrder" value="' . $sortOrder . '">';
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