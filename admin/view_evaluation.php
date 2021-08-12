<?php
//include_once("header/check_login.php");
include_once('../includes/connection.php');
if (isset($_GET['signature'], $_GET['ev'], $_GET['evd'], $_GET['emp'], $_GET['p'])
    && validName($_GET['signature']) && !empty($_GET['signature'])
    && is_numeric($_GET['ev']) && !empty($_GET['ev'])
    && is_numeric($_GET['evd']) && !empty($_GET['evd'])
    && is_numeric($_GET['emp']) && !empty($_GET['emp'])
    && is_numeric($_GET['p']) && !empty($_GET['p'])
) {
    $global_company_id = $global_branch_id = $_SESSION['company_id'] = $_SESSION['branch_id'] = 1;

    $signed_url = $_GET['signature'];
    $evaluation_id = $_GET['ev'];
    $evaluation_detail_id = $_GET['evd'];
    $employee_id = $_GET['emp'];
    $parent_id = $_GET['p'];
    $sel = "SELECT e.department_id, e.date
    FROM 
        evaluations AS e
    INNER JOIN
        evaluation_details AS ed
        ON e.id = ed.evaluation_id
    WHERE e.id='{$evaluation_id}' AND e.company_id='{$global_company_id}' AND e.branch_id='{$global_branch_id}' AND e.deleted_at IS NULL
    AND ed.id='{$evaluation_detail_id}' AND ed.evaluation_id='{$evaluation_id}' AND ed.parent_id='{$parent_id}' 
    AND ed.employee_id='{$employee_id}' AND ed.signed_url='{$signed_url}' ORDER BY e.id ASC LIMIT 1";
    $sql = mysqli_query($db, $sel);
    if (mysqli_num_rows($sql) > 0) {
        $data = mysqli_fetch_object($sql);
        $number_stacks = getNumberStacksOfEvaluation($global_company_id, $global_branch_id, $evaluation_id, $data->department_id);
        if (!empty($number_stacks) && is_array($number_stacks) && sizeof($number_stacks) > 0) {
            $appraiseInfo = getEmployeeInfoFromId($employee_id);
            $appraiserInfo = $global_employee_info = getEmployeeInfoFromId($parent_id);
            $evaluationResult = getEvaluationResult($evaluation_id, $evaluation_detail_id);
            $measure = $number_stacks['total'];

            if (empty($_SESSION['company_id']) || empty($_SESSION['branch_id']) || empty($_SESSION['employee_id']) || empty($_SESSION['user_id'])) {
                $global_employee_id = $parent_id;
                $global_user_id = $_SESSION['user_id'] = $appraiserInfo->user_id;
                date_default_timezone_set($global_employee_info->time_zone);
                $checkLogin = FALSE;
            } else {
                $global_company_id = $_SESSION['company_id'];
                $global_branch_id = $_SESSION['branch_id'];
                $global_employee_id = $_SESSION['employee_id'];
                $global_user_id = $_SESSION['user_id'];
                $global_employee_info = getEmployeeInfoFromId($global_employee_id);
                date_default_timezone_set($global_employee_info->time_zone);
                $checkLogin = TRUE;
            }

            $select_current_page = "SELECT child.id AS child_menu_id, child.display_name AS child_menu_name, child.sub_menu_id,
    sub.name AS sub_menu_name, sub.main_menu_id, main.name AS main_menu_name,
    child.status AS child_status, sub.status AS sub_status, main.status AS main_status
    FROM 
    child_menus AS child 
    INNER JOIN 
    sub_menus AS sub
    ON child.sub_menu_id = sub.id
    INNER JOIN 
    main_menus AS main
    ON sub.main_menu_id = main.id
    WHERE child.file_name='{$page}' ORDER BY child.id ASC LIMIT 1";
            $query_current_page = mysqli_query($db, $select_current_page);
            if (mysqli_num_rows($query_current_page) > 0) {
                $query_current_page = mysqli_fetch_object($query_current_page);
                if ($query_current_page->child_status == '1' && $query_current_page->sub_status == '1' && $query_current_page->main_status == '1') {
                    $child_menu_id = $query_current_page->child_menu_id;
                    $child_menu_name = $query_current_page->child_menu_name;
                    $sub_menu_id = $query_current_page->sub_menu_id;
                    $sub_menu_name = $query_current_page->sub_menu_name;
                    $main_menu_id = $query_current_page->main_menu_id;
                    $main_menu_name = $query_current_page->main_menu_name;
                } else {
                    header('Location: ' . $page_not_found_url);
                }
            } else {
                if ($page != 'dashboard') {
                    header('Location: ' . $page_not_found_url);
                }
                $child_menu_id = $child_menu_name = $sub_menu_id = $sub_menu_name = $main_menu_id = $main_menu_name = '';
            }


        } else {
            header('Location: ' . $page_not_found_url);
        }
    } else {
        header('Location: ' . $page_not_found_url);
    }
} else {
    header('Location: ' . $page_not_found_url);
}


include_once("../includes/head.php");
if ($checkLogin) {
    include_once("../includes/mobile_menu.php");
}
?>
    <!--begin::Main-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="d-flex flex-row flex-column-fluid page">
            <!--begin::Aside-->
            <?php
            if ($checkLogin) {
                include_once("../includes/main_menu.php");
            }
            ?>
            <!--end::Aside-->
            <!--begin::Wrapper-->
            <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper" <?php if (!$checkLogin) {
                echo 'style="padding-left:0px!important;"';
            } ?>>
                <!--begin::Header-->
                <?php include_once("../includes/header_menu.php"); ?>
                <!--end::Header-->

                <!--begin::Content-->
                <div class="content  d-flex flex-column flex-column-fluid" id="kt_content">
                    <!--begin::Breadcrumb-->
                    <?php include_once('../includes/bread_crumb.php'); ?>
                    <!--end::Breadcrumb-->

                    <!--begin::Entry-->
                    <div class="d-flex flex-column-fluid">
                        <!--begin::Container-->
                        <div class="container">
                            <!--begin::Card-->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-custom p-4">
                                        <div class="page_wrapper">
                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                    <h3 class="text-center font-weight-bolder text-capitalize">
                                                        PERFORMANCE PLANNING & EVALUATION FORM APPRAISE INFORMATION</h3>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-2">
                                                    <div class="symbol symbol-120 mr-5">
                                                        <div class="symbol-label"
                                                             style="background-image:url(<?php echo getUserImage($employee_id)['image_path']; ?>);border: 1px solid #f0f0f0;"></div>
                                                        <i class="symbol-badge <?php echo config('employees.status.class.' . $appraiseInfo->status) ?>"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-10">
                                                    <div class="row font-size-h5 my-6">
                                                        <div class="col-md-5 text-overflow-ellipsis">
                                                            <b>Name : </b> <?php echo $appraiseInfo->full_name; ?>
                                                        </div>
                                                        <div class="col-md-4 text-overflow-ellipsis">
                                                            <b>Employee Code
                                                                : </b> <?php echo $appraiseInfo->employee_code; ?>
                                                        </div>
                                                        <div class="col-md-3 text-overflow-ellipsis">
                                                            <b>Grade : </b>
                                                            <?php
                                                            if (!empty($appraiseInfo->salary)) {
                                                                $getSalaryGrade = getSalaryGrade(decode($appraiseInfo->salary), $appraiseInfo->department_id);
                                                                if (!empty($getSalaryGrade) && key_exists('salary_grade', $getSalaryGrade)) {
                                                                    echo $getSalaryGrade['salary_grade'];
                                                                } else {
                                                                    echo '<small style="ban btn-danger">Salary Grade not found.</small>';
                                                                }
                                                            } else {
                                                                echo '<small style="ban btn-danger">Salary not found.</small>';
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="row font-size-h5">
                                                        <div class="col-md-5 text-overflow-ellipsis">
                                                            <b>Designation
                                                                : </b> <?php echo $appraiseInfo->designation_name; ?>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <b>Department
                                                                : </b> <?php echo $appraiseInfo->department_name; ?>
                                                        </div>
                                                        <div class="col-md-3 text-overflow-ellipsis">&nbsp;</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                    <div class="appraiser_name alert alert-default text-center font-size-h6">
                                                        <b>Appraiser: </b> <?php echo $appraiserInfo->full_name; ?>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <b>Performance
                                                            Year: </b> <?php echo date('M Y', strtotime($data->date)); ?>
                                                        <input type="hidden" class="not-display"
                                                               id="number_stack_is_default"
                                                               value="<?php echo $number_stacks['number_stack_is_default']; ?>">
                                                        <input type="hidden" class="not-display"
                                                               id="evaluation_number_stack_id"
                                                               value="<?php echo $number_stacks['evaluation_number_stack_id']; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                    <div class="alert alert-custom alert-light-success d-block text-center font-size-h6 px-5 py-3">
                                                        <div class="d-block text-center mb-2"
                                                             style="color: #0d9c92 !important;">
                                                            <b>RATING KEY: </b> Scores can be assigned within a range
                                                            too
                                                        </div>
                                                        <div class="d-flex text-center overflow-hidden my-6">
                                                            <?php
                                                            /*echo '<pre>';
                                                            print_r($number_stacks);
                                                            echo '</pre>';*/
                                                            foreach (sortMultiDimensionalArrayDescendingByKey($number_stacks['stack'], 'gp_value') as $number_stack) {
                                                                ?>
                                                                <div class="col-1 col-md"
                                                                     style="color: #0d9c92 !important;">
                                                                    <?php echo $number_stack['gp_name'] . ' (' . $number_stack['gp_value'] . ')'; ?>
                                                                </div>
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                        <div class="d-block text-center mb-2">
                                                            <button type="button" class="btn btn-success"
                                                                    data-toggle="modal" data-target="#scoresDetail">
                                                                Detailed information about scores
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--begin::scoresDetail Modal-->
                                                <div class="modal fade" id="scoresDetail" tabindex="-1" role="dialog"
                                                     aria-labelledby="ariaLabelScoresDetail" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg"
                                                         role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="ariaLabelScoresDetail">
                                                                    Scores
                                                                    Detail</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                    <i aria-hidden="true" class="ki ki-close"></i>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <ul>
                                                                    <?php
                                                                    foreach (sortMultiDimensionalArrayDescendingByKey($number_stacks['stack'], 'gp_value') as $number_stack) {
                                                                        ?>
                                                                        <li>
                                                                            <h5><?php echo $number_stack['gp_name']; ?>
                                                                                :</h5>
                                                                            <p class="pl-6"><?php echo $number_stack['gp_description']; ?></p>
                                                                        </li>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </ul>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button"
                                                                        class="btn btn-light-primary font-weight-bold"
                                                                        data-dismiss="modal">Close
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end::scoresDetail Modal-->
                                            </div>

                                            <?php
                                            $onblur = ' onblur="change_color(this.value, this.id)" ';
                                            $select_evaluation_tasks = "SELECT `id`, `task_heading`, `task_weight` FROM `evaluation_tasks` WHERE `evaluation_id`='{$evaluation_id}' AND `company_id`='{$global_company_id}' AND `branch_id`='{$global_branch_id}' AND `deleted_at` IS NULL ORDER BY `id` ASC";
                                            $query_evaluation_tasks = mysqli_query($db, $select_evaluation_tasks);
                                            $section = 0;
                                            $total_score_percentage_of_all_sections = 0;
                                            if (mysqli_num_rows($query_evaluation_tasks) > 0) {
                                                while ($fetch_evaluation_tasks = mysqli_fetch_object($query_evaluation_tasks)) {
                                                    $section++;
                                                    echo '<div class="row mb-6"><div class="col-md-12"><div class="card card-custom">';
                                                    $total_of_measure = $total_of_achieved = 0;
                                                    ?>
                                                    <div class="card-header font-weight-bolder bg-success px-2 py-5"
                                                         style="border:none; color: #fff !important; min-height: auto !important;">
                                                        <div class="col-md-1">Sr.</div>
                                                        <div class="col-md-5"><?php echo $fetch_evaluation_tasks->task_heading; ?></div>
                                                        <div class="col-md-2">Measure</div>
                                                        <div class="col-md-2">Achieved</div>
                                                        <div class="col-md-2">Score</div>
                                                    </div>
                                                    <?php

                                                    if (isset($evaluationResult) && is_array($evaluationResult) && sizeof($evaluationResult) > 0 && !empty($evaluationResult)) {
                                                        $select_evaluation_task_details = "SELECT etd.id, etd.task_description 
                                                        FROM
                                                            evaluation_task_details AS etd
                                                        INNER JOIN
                                                             evaluation_results AS er
                                                        ON etd.id=er.evaluation_task_detail_id
                                                        WHERE etd.evaluation_task_id='{$fetch_evaluation_tasks->id}' ORDER BY etd.id ASC";
                                                    } else {
                                                        $select_evaluation_task_details = "SELECT `id`,`task_description` FROM `evaluation_task_details` WHERE `evaluation_task_id`='{$fetch_evaluation_tasks->id}' ORDER BY `id` ASC";
                                                    }
                                                    $query_evaluation_task_details = mysqli_query($db, $select_evaluation_task_details);
                                                    if (mysqli_num_rows($query_evaluation_task_details) > 0) {
                                                        $row_number = $row = 0;
                                                        echo '<div class="card-body p-0" style="border: 1px solid #f0f0f0"><div id="question_portion' . $section . '">';
                                                        while ($fetch_evaluation_task_details = mysqli_fetch_object($query_evaluation_task_details)) {
                                                            $row_number++;
                                                            $row++;
                                                            $evenOrOdd = ($row_number % 2) == 1 ? 'odd-line' : 'even-line';
                                                            //$measure = $fetch_evaluation_task_details->total_number;
                                                            $task_weight = round($fetch_evaluation_tasks->task_weight, 2);
                                                            $achieved = '0.00';
                                                            $ch = '';
                                                            $achiveATTR = ' readonly="readonly" disabled="disabled" ';
                                                            $achiveClass = ' class="form-control disable-select" ';
                                                            if (is_array($evaluationResult) && !empty($evaluationResult) && sizeof($evaluationResult) > 0 && array_key_exists($fetch_evaluation_task_details->id, $evaluationResult)) {
                                                                $achieved = $evaluationResult[$fetch_evaluation_task_details->id];
                                                                $ch = ' checked="checked" ';
                                                                $achiveATTR = '';
                                                                $achiveClass = ' class="form-control" ';
                                                                $total_of_measure = round(round($total_of_measure, 2) + round($measure, 2), 2);
                                                            }
                                                            $total_of_achieved = round(round($total_of_achieved, 2) + round($achieved, 2), 2);

                                                            ?>
                                                            <div class="row m-0 px-2 py-4 <?php echo $evenOrOdd; ?>">
                                                                <div class="col-md-1 column">
                                                                    <div class="form-group text-center mt-3 mb-0">
                                                                        <?php
                                                                        if (is_array($evaluationResult) && empty($evaluationResult)) {
                                                                            ?>
                                                                            <label class="checkbox checkbox-outline checkbox-success d-inline-block">
                                                                                <input type="hidden" class="not-display"
                                                                                       id="evaluation_task_id_<?php echo $section . '_' . $row_number; ?>"
                                                                                       value="<?php echo $fetch_evaluation_tasks->id; ?>">
                                                                                <input type="hidden" class="not-display"
                                                                                       id="evaluation_task_detail_id_<?php echo $section . '_' . $row_number; ?>"
                                                                                       value="<?php echo $fetch_evaluation_task_details->id; ?>">
                                                                                <input type="checkbox"
                                                                                       class="lineRepresentativeBox"
                                                                                       value="<?php echo $section . '_' . $row_number; ?>"
                                                                                       id="lineRepresentativeBox_<?php echo $section; ?>_<?php echo $row_number; ?>" <?php echo $ch; ?>
                                                                                       onclick="calculate(event)"
                                                                                       data-portion="<?php echo $section; ?>"
                                                                                       data-line="<?php echo $row_number; ?>"
                                                                                       data-task_weight="<?php echo $task_weight; ?>"/>
                                                                                <b class="float-left mr-2"><?php echo $row_number; ?>
                                                                                    . </b>
                                                                                <span class="float-left"></span>
                                                                            </label>
                                                                            <?php
                                                                        } else {
                                                                            echo '<b class="float-left mr-2">' . $row_number . '.</b>';
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-5 text-vertical-align-center">
                                                                    <input type="hidden" class="not-display"
                                                                           id="task_description_<?php echo $section . '_' . $row_number; ?>"
                                                                           value="<?php echo $fetch_evaluation_task_details->task_description; ?>">
                                                                    <?php echo $fetch_evaluation_task_details->task_description; ?>
                                                                </div>
                                                                <div class="col-md-2 text-vertical-align-center">
                                                                    <input type="hidden" class="not-display"
                                                                           id="measure_number_<?php echo $section . '_' . $row_number; ?>"
                                                                           value="<?php echo number_format(round($measure, 2), 2); ?>">
                                                                    <?php echo number_format(round($measure, 2), 2); ?>
                                                                </div>
                                                                <div class="col-md-2 text-vertical-align-center">
                                                                    <input type="hidden"
                                                                           id="old_obtaining_number_<?php echo $section . '_' . $row_number; ?>"
                                                                           value="<?php echo $achieved; ?>">
                                                                    <?php
                                                                    if (is_array($evaluationResult) && empty($evaluationResult)) {
                                                                        ?>
                                                                        <select <?php echo $achiveATTR . $achiveClass . $onblur; ?>
                                                                                id="obtaining_number_<?php echo $section . '_' . $row_number; ?>"
                                                                                onchange="setObtainingPercentages(this.value, <?php echo $section; ?>, <?php echo $row_number; ?>, <?php echo $task_weight; ?>)">
                                                                            <option value="0" selected="selected">Select
                                                                            </option>
                                                                            <?php
                                                                            foreach (getLessThanNumberStacks($number_stacks['stack'], $measure) as $score_stacks) {
                                                                                $obtS = round($achieved) == round($score_stacks['gp_value']) ? ' selected="selected" ' : '';
                                                                                echo '<option  value="' . $score_stacks['gp_value'] . '" ' . $obtS . '>' . $score_stacks['gp_value'] . '</option>';
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                        <?php
                                                                    } else {
                                                                        echo $achieved;
                                                                    }
                                                                    ?>
                                                                </div>
                                                                <div class="col-md-2 text-vertical-align-center"
                                                                     id="obtaining_percentage_<?php echo $section . '_' . $row_number; ?>"><?php echo number_format(round(round($achieved, 2) / round($measure, 2) * 100, 2), 2) . '%'; ?></div>
                                                            </div>
                                                            <?php
                                                        }
                                                        echo '</div>';
                                                        for ($i = 1; $i <= 3; $i++) {
                                                            $row_number++;
                                                            $evenOrOdd = ($row_number % 2) == 1 ? 'odd-line' : 'even-line';
                                                            if ($i == 1) {
                                                                ?>
                                                                <div class="row m-0 px-2 py-4 font-weight-bolder <?php echo $evenOrOdd; ?>">
                                                                    <div class="col-md-6 text-right">Total score of
                                                                        section <?php echo getAlphabetLetterByPosition($section); ?>
                                                                        out of:
                                                                    </div>
                                                                    <div class="col-md-2"
                                                                         id="total_of_measure_<?php echo $section; ?>"><?php echo number_format($total_of_measure, 2); ?></div>
                                                                    <div class="col-md-2"
                                                                         id="total_of_achieved_<?php echo $section; ?>"><?php echo number_format($total_of_achieved, 2); ?></div>
                                                                    <div class="col-md-2"
                                                                         id="average_percentage_of_section_<?php echo $section; ?>">
                                                                        <?php
                                                                        if ($total_of_achieved > 0 && $total_of_measure > 0) {
                                                                            $average_percentage = round($total_of_achieved / $total_of_measure * 100, 2);
                                                                        } else {
                                                                            $average_percentage = '0';
                                                                        }
                                                                        echo number_format($average_percentage, 2) . '%';
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                            } else if ($i == 2) {
                                                                ?>
                                                                <div class="row m-0 px-2 py-4 font-weight-bolder <?php echo $evenOrOdd; ?>">
                                                                    <div class="col-md-10 text-right">Weight</div>
                                                                    <div class="col-md-2"><?php echo number_format($task_weight, 2) . '%'; ?></div>
                                                                </div>
                                                                <?php
                                                            } else if ($i == 3) {
                                                                ?>
                                                                <div class="row m-0 px-2 py-4 font-weight-bolder <?php echo $evenOrOdd; ?>">
                                                                    <div class="col-md-10 text-right">Weighted Score
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <span class="float-left"
                                                                              id="weighted_score_of_section_<?php echo $section; ?>">
                                                                        <?php
                                                                        $obt_wdighted_percentage = round($average_percentage * $task_weight / 100, 2);
                                                                        $total_score_percentage_of_all_sections = round(round($total_score_percentage_of_all_sections, 2) + round($obt_wdighted_percentage, 2), 2);
                                                                        echo number_format(round($obt_wdighted_percentage, 2), 2);
                                                                        ?>
                                                                        </span>%
                                                                    </div>
                                                                </div>
                                                                <?php
                                                            }
                                                        }
                                                        echo '</div>';
                                                    }
                                                    echo '</div>';
                                                    if (is_array($evaluationResult) && empty($evaluationResult)) {
                                                        echo '<p class="overflow-hidden">';
                                                        echo '<input type="hidden" class="not-display" name="r_row[]" id="r_row_' . $section . '" value="' . $row . '">';
                                                        echo '<button type="button" class="btn btn-outline-primary mr-1 mt-3 btn-sm float-right" onclick="addNewRow(' . $section . ', ' . $task_weight . ', ' . $fetch_evaluation_tasks->id . ')">' . config('lang.button.title.add') . '</button>';
                                                        echo '</p>';
                                                    }
                                                    echo '</div></div>';
                                                }
                                                ?>
                                                <div class="row mb-3">
                                                    <div class="col-md-12">
                                                        <div class="alert alert-success d-block font-size-h6 px-5 py-3">
                                                            <b>Employee Grading : </b>
                                                            Weighted Score Of Section (
                                                            <?php
                                                            for ($s = 1; $s <= $section; $s++) {
                                                                $plus_sign = $s == $section ? '' : ' + ';
                                                                echo getAlphabetLetterByPosition($s) . $plus_sign;
                                                            }
                                                            ?>)
                                                            <b class="float-right">
                                                        <span id="grand_average_score">
                                                            <?php echo number_format($total_score_percentage_of_all_sections, 2); ?>
                                                        </span>%
                                                            </b>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }

                                            if (is_array($evaluationResult) && empty($evaluationResult)) {
                                                echo '
                                                <div class="row mb-3">
                                                    <div class="col-md-12">
                                                        <button type="button" onclick="saveFORM()"
                                                            class="btn btn-primary font-weight-bold btn-lg float-right">' . config('lang.button.title.save') . '
                                                        </button>
                                                    </div>
                                                </div>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Card-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Entry-->
                </div>
                <!--end::Content-->

                <!--begin::Footer-->
                <?php include_once("../includes/footer_statement.php"); ?>
                <!--end::Footer-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::Main-->
<?php
include_once("../includes/footer.php");
include_once("../includes/footer_script.php");
?>
    <script>
        function saveFORM() {

            var checkValidName = /[^a-zA-Z0-9+-._,@&#/)(’' ]/;

            var signature = '<?php echo $signed_url; ?>';
            var evaluation_id = <?php echo $evaluation_id; ?>;
            var emp = <?php echo $employee_id; ?>;
            var p = <?php echo $parent_id; ?>;
            var evaluation_detail_id = <?php echo $evaluation_detail_id; ?>;
            var evaluation_number_stack_id = <?php echo $number_stacks['evaluation_number_stack_id']; ?>;
            var number_stack_is_default = <?php echo $number_stacks['number_stack_is_default']; ?>;

            var evaluation_task_detail_id = null;
            var message = "Please checked at least one Task.";
            var continueProcessing = false;
            var data = [];
            var inputElements = document.getElementsByClassName('lineRepresentativeBox');

            for (var i = 0; inputElements[i]; ++i) {
                if (inputElements[i].checked) {
                    var row_id = inputElements[i].value;
                    var evaluation_task_id = document.getElementById('evaluation_task_id_' + row_id);
                    var evaluation_task_detail_id = document.getElementById('evaluation_task_detail_id_' + row_id);
                    var task_description = document.getElementById('task_description_' + row_id);
                    var measure_number = document.getElementById('measure_number_' + row_id);
                    var obtaining_number = document.getElementById('obtaining_number_' + row_id);

                    if (task_description.value == '') {
                        task_description.style.borderColor = '#F00';
                        message = 'Task Description field is required.';
                        continueProcessing = false;
                        break;
                    } else if (checkValidName.test(task_description.value)) {
                        task_description.style.borderColor = '#F00';
                        message = 'Special Characters are not Allowed in Task Description field.';
                        continueProcessing = false;
                        break;
                    } else if (measure_number.value <= 0 || measure_number.value == '') {
                        measure_number.style.borderColor = '#F00';
                        message = 'Measure Number field is required.';
                        continueProcessing = false;
                        break;
                    } else if (isNaN(measure_number.value) === true || measure_number.value.length > 6) {
                        measure_number.style.borderColor = '#F00';
                        message = 'Please select a valid option.';
                        continueProcessing = false;
                        break;
                    } else if (obtaining_number.value < 0 || obtaining_number.value == '') {
                        obtaining_number.style.borderColor = '#F00';
                        message = 'Achieved Number field is required.';
                        continueProcessing = false;
                        break;
                    } else if (isNaN(obtaining_number.value) === true || obtaining_number.value.length > 6) {
                        obtaining_number.style.borderColor = '#F00';
                        message = 'Please select a valid option.';
                        continueProcessing = false;
                        break;
                    } else if (Number(obtaining_number.value) > Number(measure_number.value)) {
                        obtaining_number.style.borderColor = '#F00';
                        message = 'Please select a valid option.';
                        continueProcessing = false;
                        break;
                    } else {
                        var obj = {};
                        obj = {
                            "row_id": row_id,
                            "evaluation_task_id": evaluation_task_id.value,
                            "evaluation_task_detail_id": evaluation_task_detail_id.value,
                            "task_description": task_description.value,
                            "measure_number": measure_number.value,
                            "obtaining_number": obtaining_number.value
                        }
                        data.push(obj);
                        continueProcessing = true;
                    }
                }
            }

            if (continueProcessing === false) {
                toasterTrigger('error', message);
                return false;
            } else if (continueProcessing === true && data.length > 0) {
                loader(true);
                var postData = {
                    "signature": signature,
                    "emp": emp,
                    "p": p,
                    "evaluation_id": evaluation_id,
                    "evaluation_detail_id": evaluation_detail_id,
                    "evaluation_number_stack_id": evaluation_number_stack_id,
                    "number_stack_is_default": number_stack_is_default,
                    "data": data
                };
                $.ajax({
                    type: "POST", url: "ajax/evaluation_results.php",
                    data: {'postData': postData},
                    success: function (resPonse) {
                        if (resPonse !== undefined && resPonse != '') {
                            var obj = JSON.parse(resPonse);
                            if (obj.code === 200 || obj.code === 422 || obj.code === 405) {
                                if (obj.code === 422) {
                                    if (obj.errorField !== undefined && obj.errorField != '' && obj.errorMessage !== undefined && obj.errorMessage != '') {
                                        document.getElementById(obj.errorField).style.borderColor = '#F00';
                                        loader(false);
                                        toasterTrigger(obj.toasterClass, obj.errorMessage);
                                    }
                                } else if (obj.code === 405) {
                                    if (obj.responseMessage !== undefined && obj.responseMessage != '') {
                                        loader(false);
                                        toasterTrigger(obj.toasterClass, obj.responseMessage);
                                    }
                                } else if (obj.code === 200) {
                                    if (obj.responseMessage !== undefined && obj.responseMessage != '') {
                                        loader(false);
                                        toasterTrigger(obj.toasterClass, obj.responseMessage);
                                        window.location.reload(false);
                                    } else {
                                        loader(false);
                                    }
                                }
                            } else {
                                loader(false);
                            }
                        } else {
                            loader(false);
                        }
                    },
                    error: function () {
                        loader(false);
                    }
                });
            }
        }

        /*function setMeasure(value, section, row) {
            var old_measure_ele = document.getElementById('old_measure_number_' + section + '_' + row);
            var old_measure = old_measure_ele.value;

            var total_of_measure_ele = document.getElementById('total_of_measure_' + section);
            var total_of_measure = total_of_measure_ele.innerText;
            total_of_measure_ele.innerHTML = (Number(total_of_measure) + Number(value) - Number(old_measure)).toFixed(2);
            old_measure_ele.value = value;


            document.getElementById('obtaining_number_' + section + '_' + row).value = "0.00";
            document.getElementById('obtaining_percentage_' + section + '_' + row).innerHTML = "0.00%";
        }*/

        function calculate(e) {
            //console.log(e.target.id);
            var id = e.target.value;
            var section = e.target.dataset.portion;
            var row = e.target.dataset.line;
            var task_weight = e.target.dataset.task_weight;
            var measure = document.getElementById('measure_number_' + id).value;
            var achieved_ele = document.getElementById('obtaining_number_' + id);
            var achieved = achieved_ele.value;
            var total_of_measure_ele = document.getElementById('total_of_measure_' + section);
            var total_of_measure = total_of_measure_ele.innerText;
            var total_of_achieved_ele = document.getElementById('total_of_achieved_' + section);
            var total_of_achieved = total_of_achieved_ele.innerText;

            if (e.target.checked) {
                removeAttributes(achieved_ele, 'readonly', 'disabled');
                achieved_ele.classList.remove("disable-select");
                total_of_measure_ele.innerHTML = (Number(total_of_measure) + Number(measure)).toFixed(2);
                total_of_achieved_ele.innerHTML = (Number(total_of_achieved) + Number(achieved)).toFixed(2);
            } else {
                achieved_ele.classList.add("disable-select");
                setAttributes(achieved_ele, {"readonly": "readonly", "disabled": "disabled"});
                if (total_of_measure > 0) {
                    total_of_measure_ele.innerHTML = (Number(total_of_measure) - Number(measure)).toFixed(2);
                }
                if (total_of_achieved > 0) {
                    total_of_achieved_ele.innerHTML = (Number(total_of_achieved) - Number(achieved)).toFixed(2);
                }
            }
            modifyAllCalculation(achieved, measure, task_weight, section, row);
        }

        function setObtainingPercentages(value, section, row, task_weight) {
            if (document.getElementById('lineRepresentativeBox_' + section + '_' + row).checked) {
                var measure = document.getElementById('measure_number_' + section + '_' + row).value;
                modifyAllCalculation(value, measure, task_weight, section, row);
            }
        }

        function modifyAllCalculation(value, measure, task_weight, section, row) {

            if (Number(value) > Number(measure)) {
                document.getElementById('obtaining_percentage_' + section + '_' + row).innerHTML = (Number(100)).toFixed(2) + '%';
                document.getElementById('obtaining_number_' + section + '_' + row).value = measure;
                var value = measure;
            } else {
                if (Number(value) == 0 || Number(measure) == 0) {
                    document.getElementById('obtaining_percentage_' + section + '_' + row).innerHTML = (Number(0)).toFixed(2) + '%';
                } else {
                    document.getElementById('obtaining_percentage_' + section + '_' + row).innerHTML = (Number(value) / Number(measure) * 100).toFixed(2) + '%';
                }

            }

            var element_of_old_value_of_achievement = document.getElementById('old_obtaining_number_' + section + '_' + row);
            var old_value_of_achievement = element_of_old_value_of_achievement.value;

            var element_of_total_of_achieved = document.getElementById('total_of_achieved_' + section);
            var old_total_of_achieved = element_of_total_of_achieved.innerText;
            var new_total_of_achieved = (Number(old_total_of_achieved) - Number(old_value_of_achievement) + Number(value)).toFixed(2);

            element_of_total_of_achieved.innerHTML = new_total_of_achieved;
            element_of_old_value_of_achievement.value = value;

            var total_of_measure = document.getElementById('total_of_measure_' + section).innerText;
            if (Number(new_total_of_achieved) == 0 || Number(total_of_measure) == 0) {
                var new_average_percentage_of_section = (Number(0)).toFixed(2);
            } else {
                var new_average_percentage_of_section = (Number(new_total_of_achieved) / Number(total_of_measure) * 100).toFixed(2);
            }
            document.getElementById('average_percentage_of_section_' + section).innerHTML = new_average_percentage_of_section + '%';


            if (Number(new_average_percentage_of_section) == 0 || Number(task_weight) == 0) {
                var new_weighted_score = (Number(0)).toFixed(2);
            } else {
                var new_weighted_score = (Number(new_average_percentage_of_section) * Number(task_weight) / 100).toFixed(2);
            }
            var element_of_weighted_score_of_section = document.getElementById('weighted_score_of_section_' + section);
            var old_weighted_score_of_section = element_of_weighted_score_of_section.innerText;
            element_of_weighted_score_of_section.innerHTML = new_weighted_score;

            var element_of_grand_average_score = document.getElementById('grand_average_score');
            var old_grand_average_score = element_of_grand_average_score.innerText;
            var reduce_old = (Number(old_grand_average_score) - Number(old_weighted_score_of_section)).toFixed(2);

            element_of_grand_average_score.innerHTML = (Number(reduce_old) + Number(new_weighted_score)).toFixed(2);

        }

        function removeAttributes(element, ...attrs) {
            attrs.forEach(attr => element.removeAttribute(attr))
        }

        function setAttributes(element, attrs) {
            for (var key in attrs) {
                element.setAttribute(key, attrs[key]);
            }
        }

        function addNewRow(section, weight, task_id) {
            var row = document.getElementById('r_row_' + section).value;
            row++;
            var id = section + '_' + row;

            var innerHTml_c = '<div class="row m-0 px-2 py-4 new-line">';

            innerHTml_c += '<div class="col-md-1 column"><div class="form-group text-center mt-3 mb-0">';
            innerHTml_c += '<label class="checkbox checkbox-outline checkbox-success d-inline-block">';
            innerHTml_c += '<input type="hidden" class="not-display" id="evaluation_task_id_' + id + '" value="' + task_id + '">';
            innerHTml_c += '<input type="hidden" class="not-display" id="evaluation_task_detail_id_' + id + '" value="0">';
            innerHTml_c += '<input type="checkbox" class="lineRepresentativeBox" value="' + id + '" id="lineRepresentativeBox_' + id + '" onclick="calculate(event)" data-portion="' + section + '" data-line="' + row + '" data-task_weight="' + weight + '"/>';
            innerHTml_c += '<b class="float-left mr-2">' + row + '. </b>';
            innerHTml_c += '<span class="float-left"></span>';
            innerHTml_c += '</label>';
            innerHTml_c += '</div></div>';

            innerHTml_c += '<div class="col-md-5 text-vertical-align-center">';
            innerHTml_c += '<textarea rows="1" id="task_description_' + id + '" class="form-control" <?php echo $onblur; ?> placeholder="Task Description"></textarea>';
            innerHTml_c += '</div>';

            innerHTml_c += '<div class="col-md-2 text-vertical-align-center">';
            innerHTml_c += '<input type="hidden" id="measure_number_' + id + '" value="<?php echo $measure; ?>"><?php echo $measure; ?>';
            innerHTml_c += '</div>';

            innerHTml_c += '<div class="col-md-2 text-vertical-align-center">';
            innerHTml_c += '<input type="hidden" id="old_obtaining_number_' + id + '" value="0.00">';
            innerHTml_c += '<select id="obtaining_number_' + id + '" <?php echo $achiveATTR . $achiveClass . $onblur; ?> onchange="setObtainingPercentages(this.value, ' + section + ', ' + row + ', ' + weight + ')">';
            innerHTml_c += '<option value="0" selected="selected">Select</option>';
            <?php
            foreach (getLessThanNumberStacks($number_stacks['stack']) as $score_stacks) {
                echo 'innerHTml_c += \'<option  value="' . $score_stacks['gp_value'] . '">' . $score_stacks['gp_value'] . "</option>';";
            }
            ?>
            innerHTml_c += '</select>';
            innerHTml_c += '</div>';
            innerHTml_c += '<div class="col-md-2 text-vertical-align-center" id="obtaining_percentage_' + id + '">0.00%</div>';
            innerHTml_c += '</div>';
            $("#question_portion" + section).append(innerHTml_c);
            document.getElementById('r_row_' + section).value = row;

            //var portion = document.getElementById('question_portion'+section);

        }

    </script>
<?php include_once("../includes/endTags.php"); ?>