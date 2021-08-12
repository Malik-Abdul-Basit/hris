<?php
include_once('../../includes/connection.php');

$company_id = $_SESSION['company_id'];
$branch_id = $_SESSION['branch_id'];
$global_employee_id = $_SESSION['employee_id'];
$global_user_id = $_SESSION['user_id'];
global $db;

if (isset($_POST['postData'], $_POST['getStates']) && $_POST['getStates'] == true) {
    $object = (object)$_POST['postData'];
    $country_id = $object->country_id;
    $state_id = 0;
    $states = getStates($country_id, $state_id);
    echo json_encode(["code" => 200, "StatesList" => $states]);
}

if (isset($_POST['postData'], $_POST['getCities']) && $_POST['getCities'] == true) {
    $object = (object)$_POST['postData'];

    $state_id = $object->state_id;
    $city_id = 0;
    $cities = getCities($state_id, $city_id);
    echo json_encode(["code" => 200, "CitiesList" => $cities]);
}

if (isset($_POST['postData'], $_POST['getTeamsAndDesignations']) && $_POST['getTeamsAndDesignations'] == true) {

    $object = (object)$_POST['postData'];

    $departmentId = $object->departmentId;
    $teamId = $designationId = 0;
    //$teams = getTeams($departmentId, $teamId, $company_id, $branch_id);
    $designations = getDesignations($departmentId, $designationId, $company_id, $branch_id);
    echo json_encode(["code" => 200, "DesignationsList" => $designations]);
    //echo json_encode(["code" => 200, "TeamsList" => $teams, "DesignationsList" => $designations]);
}

if (isset($_POST['postData'], $_POST['getEmployee'], $_POST['R']) && !empty($_POST['R']) && $_POST['getEmployee'] == true) {
    $object = (object)$_POST['postData'];
    $employee_code = $object->code;
    $right_title = $_POST['R'];

    $select = "SELECT eb.employee_id, eb.official_email, eb.pseudo_name, u.id AS user_id, 
    CONCAT(eb.first_name,' ',eb.last_name) AS full_name 
    FROM
        employees AS e
    INNER JOIN
        employee_basic_infos AS eb
        ON e.id = eb.employee_id
   INNER JOIN
        users AS u
        ON e.id = u.employee_id
    WHERE e.employee_code='{$employee_code}' AND e.company_id='{$company_id}' 
    AND e.branch_id='{$branch_id}' AND e.deleted_at IS NULL 
    AND u.deleted_at IS NULL ORDER BY e.id ASC LIMIT 1";
    $query = mysqli_query($db, $select);
    if (mysqli_num_rows($query) > 0) {
        if ($result = mysqli_fetch_object($query)) {
            $hasRight = false;
            $code = 405;
            $checkImage = getUserImage($result->employee_id);
            $image_path = $checkImage['image_path'];
            $employee_info = ["id" => $result->employee_id, "u_id" => $result->user_id, "full_name" => $result->full_name, "pseudo_name" => $result->pseudo_name, "email" => $result->official_email, "image" => $image_path];

            if ($right_title == 'users') {
                if (hasRight($right_title, 'assign_rights')) {
                    $hasRight = true;
                    $code = 200;
                }
            } else if ($right_title == 'employee_image') {
                if (hasRight($right_title, 'add') && $checkImage['default']) {
                    $hasRight = true;
                    $code = 200;
                } else if (hasRight($right_title, 'edit') && !$checkImage['default']) {
                    $hasRight = true;
                    $code = 200;
                }
            } else if ($right_title == 'employee_qualification') {
                $query = mysqli_query($db, "SELECT `id` FROM `employee_qualification_infos` WHERE `employee_id`='{$result->employee_id}' ORDER BY `employee_id` ASC LIMIT 1");
                if (hasRight($right_title, 'add') && mysqli_num_rows($query) == 0) {
                    $hasRight = true;
                    $code = 200;
                } else if (hasRight($right_title, 'edit') && mysqli_num_rows($query) > 0) {
                    $hasRight = true;
                    $code = 200;
                }
            } else if ($right_title == 'employee_experience') {
                $query = mysqli_query($db, "SELECT `id` FROM `employee_experience_infos` WHERE `employee_id`='{$result->employee_id}' ORDER BY `employee_id` ASC LIMIT 1");
                if (hasRight($right_title, 'add') && mysqli_num_rows($query) == 0) {
                    $hasRight = true;
                    $code = 200;
                } else if (hasRight($right_title, 'edit') && mysqli_num_rows($query) > 0) {
                    $hasRight = true;
                    $code = 200;
                }
            } else if ($right_title == 'employee_payroll') {
                $query = mysqli_query($db, "SELECT `id` FROM `employee_payrolls` WHERE `employee_id`='{$result->employee_id}' ORDER BY `employee_id` ASC LIMIT 1");
                if (hasRight($right_title, 'add') && mysqli_num_rows($query) == 0) {
                    $hasRight = true;
                    $code = 200;
                } else if (hasRight($right_title, 'edit') && mysqli_num_rows($query) > 0) {
                    $hasRight = true;
                    $code = 200;
                }
            }


            echo json_encode(["code" => $code, 'employee_info' => $employee_info, 'hasRight' => $hasRight]);
        }
    } else {
        echo json_encode(["code" => 404, "responseMessage" => 'Employee not found with ' . $employee_code . ' employee code.']);
    }
}

if (isset($_POST['postData'], $_POST['getUserRights']) && $_POST['getUserRights'] == true) {
    $object = (object)$_POST['postData'];
    $employee_id = $object->id;
    $u_id = $object->u_id;
    $branch_id = $object->branch_id;

    $select = "SELECT `status`,`type` FROM `users` WHERE `id`='{$u_id}' AND `employee_id`='{$employee_id}' AND `deleted_at` IS NULL ORDER BY `id` ASC LIMIT 1";
    $query = mysqli_query($db, $select);
    if (mysqli_num_rows($query) > 0) {
        $result = mysqli_fetch_object($query);
        $html = getUserRightsHTML($u_id, $branch_id);
        echo json_encode(["code" => 200, "status" => $result->status, "type" => $result->type, "html" => $html]);
    }
}

if (isset($_POST['postData'], $_POST['getEmployeeQualification']) && $_POST['getEmployeeQualification'] == true) {
    $object = (object)$_POST['postData'];
    $employee_id = $object->id;

    $select = "SELECT * FROM `employee_qualification_infos` WHERE `employee_id`='{$employee_id}' ORDER BY `id` ASC";
    $query = mysqli_query($db, $select);
    if (mysqli_num_rows($query) > 0) {
        //$data = [];
        $data = '';
        $i = 0;
        $TAttrs = ' type="text" class="form-control" ';
        $onblur = ' onblur="change_color(this.value, this.id)" ';
        while ($result = mysqli_fetch_assoc($query)) {
            $degree = $result['degree'];
            $institute = $result['institute'];
            $date_of_completion = date_create($result['date_of_completion']);
            $year_of_completion = date_format($date_of_completion, "Y");
            $grade = $result['grade'];
            $status = $result['status'];
            $total_marks = $result['total_marks'];
            $obtaining_marks = $result['obtaining_marks'];
            $min = round(date('Y') - (60));
            $max = date('Y');
            $i++;
            $data .= '<div class="row">
                <div class="col-md-1 column">
                    <div class="form-group text-center mt-3">
                        <label class="checkbox checkbox-outline checkbox-success d-inline-block">
                            <input type="checkbox"
                                   class="lineRepresentativeBox"
                                   checked="checked"
                                   value="' . $i . '"
                                   name="lineRepresentativeBox[]"
                                   id="lineRepresentativeBox' . $i . '"/>
                            <b class="float-left mr-2">' . $i . '
                                . </b>
                            <span class="float-left"></span>
                        </label>
                    </div>
                </div>
                <div class="col-md-2 column">
                    <div class="form-group">
                        <input maxlength="50"
                               id="degree' . $i . '"
                               value="' . $degree . '" ' . $TAttrs . $onblur . '
                               placeholder="Degree"/>
                    </div>
                </div>
                <div class="col-md-2 column">
                    <div class="form-group">
                        <input maxlength="70"
                               id="institute' . $i . '"
                               value="' . $institute . '" ' . $TAttrs . $onblur . '
                               placeholder="Institute"/>
                    </div>
                </div>
                <div class="col-md-3 column">
                    <div class="form-group">
                        <input maxlength="4" ' . $TAttrs . $onblur . '
                               id="date_of_completion' . $i . '"
                               value="' . $year_of_completion . '"
                               onkeypress="allowNumberOnly(event)"
                               placeholder="Year Of Completion"
                               min="' . $min . '"
                               max="' . $max . '">
                    </div>
                </div>
                <!--<div class="col-md-2 column">
                    <div class="form-group">-->
                <input type="hidden" class="not-display"
                       maxlength="5"
                       onkeypress="allowNumberAndPoint(event)"
                       id="total_marks' . $i . '"
                       value="' . $total_marks . '"
                       placeholder="Total Marks"/>
                <!--</div>
            </div>
            <div class="col-md-2 column">
                <div class="form-group">-->
                <input type="hidden" class="not-display"
                       maxlength="5"
                       onkeypress="allowNumberAndPoint(event)"
                       id="obtaining_marks' . $i . '"
                       value="' . $obtaining_marks . '"
                       placeholder="Obtaining Marks"/>
                <!--</div>
            </div>-->
                <div class="col-md-2 column">
                    <div class="form-group">
                        <select id="grade' . $i . '" ' . $TAttrs . $onblur . '>
                            <option selected="selected" value=""></option>';
            foreach (config('employee_qualification_infos.grade.title') as $key => $value) {
                $selected = $grade == $key ? 'selected="selected"' : '';
                $data .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
            }
            $data .= '
                        </select>
                    </div>
                </div>
                <div class="col-md-2 column">
                    <div class="form-group">
                        <select id="status' . $i . '" ' . $TAttrs . $onblur . '>';
            foreach (config('employee_qualification_infos.status.title') as $key => $value) {
                $selected = $status == $key ? 'selected="selected"' : '';
                $data .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
            }
            $data .= '
                        </select>
                    </div>
                </div>
            </div>';
            //$data[] = array_merge($result, ['completion_date' => date('d-m-Y', strtotime($result['date_of_completion']))]);
        }
        echo json_encode(["code" => 200, 'data' => $data, 'last_row' => $i]);
    } else {
        echo json_encode(["code" => 404]);
    }
}

if (isset($_POST['postData'], $_POST['getEmployeeExperience']) && $_POST['getEmployeeExperience'] == true) {
    $object = (object)$_POST['postData'];
    $employee_id = $object->id;

    $select = "SELECT * FROM `employee_experience_infos` WHERE `employee_id`='{$employee_id}' ORDER BY `id` ASC";
    $query = mysqli_query($db, $select);
    if (mysqli_num_rows($query) > 0) {
        $data = [];
        while ($result = mysqli_fetch_assoc($query)) {
            $data[] = array_merge($result, [
                'joining_date' => date('d-m-Y', strtotime($result['date_of_joining'])),
                'resigning_date' => date('d-m-Y', strtotime($result['date_of_resigning']))
            ]);
        }
        echo json_encode(["code" => 200, 'data' => $data]);
    } else {
        echo json_encode(["code" => 404]);
    }
}

if (isset($_POST['postData'], $_POST['getPayrollInfo']) && $_POST['getPayrollInfo'] == true) {
    $object = (object)$_POST['postData'];
    $employee_id = $object->id;

    $select = "SELECT * FROM `employee_payrolls` WHERE `employee_id`='{$employee_id}' ORDER BY `id` ASC LIMIT 1";
    $query = mysqli_query($db, $select);
    if (mysqli_num_rows($query) > 0) {
        $data = [];
        if ($result = mysqli_fetch_assoc($query)) {
            $contract_start_date = $result['contract_start_date'] != '0000-00-00' && !empty($result['contract_start_date']) ? date('d-m-Y', strtotime($result['contract_start_date'])) : '';
            $contract_end_date = $result['contract_end_date'] != '0000-00-00' && !empty($result['contract_end_date']) ? date('d-m-Y', strtotime($result['contract_end_date'])) : '';
            $leaving_date = $result['leaving_date'] != '0000-00-00' && !empty($result['leaving_date']) ? date('d-m-Y', strtotime($result['leaving_date'])) : '';
            $salary = decode($result['salary']);
            $data[] = array_merge($result, ['joining_date' => date('d-m-Y', strtotime($result['joining_date'])), 'contract_start_date' => $contract_start_date, 'contract_end_date' => $contract_end_date, 'leaving_date' => $leaving_date, 'salary' => $salary]);
            echo json_encode(["code" => 200, 'data' => $data]);
        } else {
            echo json_encode(["code" => 404]);
        }
    } else {
        echo json_encode(["code" => 404]);
    }
}

if (isset($_POST['postData'], $_POST['getEmployeesTeamWise']) && $_POST['getEmployeesTeamWise'] == true) {
    $object = (object)$_POST['postData'];
    $evaluation_id = $object->evaluation_id;
    $department_id = $object->department_id;
    $designation_id = $object->designation_id;

    $return = getEmployeesTeamWise($evaluation_id, $department_id, $designation_id, $company_id, $branch_id);

    echo json_encode(["code" => $return['code'], "data" => $return['data'], "toasterClass" => $return['toasterClass'], "responseMessage" => $return['responseMessage']]);
}

if (isset($_POST['postData'], $_POST['getCommonJD']) && $_POST['getCommonJD'] == true) {
    $object = (object)$_POST['postData'];
    $department_id = $object->department_id;
    $designation_id = $object->designation_id;

    $TAttrs = ' type="text" class="form-control" ';
    $onblur = ' onblur="change_color(this.value, this.id)" ';

    $data = '';
    $m = 0;

    if (isset($department_id, $designation_id) && is_numeric($department_id) && !empty($department_id) && is_numeric($designation_id) && !empty($designation_id)) {
        $select = "SELECT  edt.id, edt.task_heading, edt.task_weight
        FROM
            evaluation_default_tasks AS edt 
        INNER JOIN
            evaluation_default_questions AS edq
        ON edt.eval_default_question_id = edq.id
        WHERE edq.department_id='{$department_id}' AND edq.designation_id='{$designation_id}' 
        AND edq.company_id='{$company_id}' AND edq.branch_id='{$branch_id}' AND edq.deleted_at IS NULL ORDER BY edt.id ASC";
        $query_evaluation_tasks = mysqli_query($db, "$select");
        if (mysqli_num_rows($query_evaluation_tasks) > 0) {
            while ($fetch_evaluation_tasks = mysqli_fetch_object($query_evaluation_tasks)) {
                $inner_data = '';
                $m++;

                $query_evaluation_task_details = mysqli_query($db, "SELECT `id`, `task_description` FROM `evaluation_default_task_details` WHERE `eval_default_task_id` = '{$fetch_evaluation_tasks->id}'");
                if (mysqli_num_rows($query_evaluation_task_details) > 0) {
                    $i = 1;
                    while ($fetch_evaluation_task_details = mysqli_fetch_object($query_evaluation_task_details)) {
                        $inner_data .= '
                        <div class="row">
                            <div class="col-md-1 column">
                                <div class="form-group text-center mt-3">
                                    <label class="checkbox checkbox-outline checkbox-success d-inline-block">
                                        <input type="checkbox"
                                               class="lineRepresentativeBox' . $m . '"
                                               value="' . $i . '"
                                               name="lineRepresentativeBox[]"
                                               id="lineRepresentativeBox_' . $m . '_' . $i . '"
                                               checked="checked"/>
                                        <b class="float-left mr-2">' . $i . '. </b>
                                        <span class="float-left"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-11 column">
                                <div class="form-group">
                                    <textarea rows="2" id="task_description_' . $m . '_' . $i . '" ' . $TAttrs . $onblur . ' placeholder="Task Description">' . $fetch_evaluation_task_details->task_description . '</textarea>
                                </div>
                            </div>
                        </div>';
                        $i++;
                    }
                }

                $data .= '
                <div class="evaluation_single_task_section">
                    <div class="row mt-7">
                        <div class="col-md-6 column">
                            <label class="checkbox checkbox-outline checkbox-success float-left"
                                   style="margin: 35px 0 0 0; width: 60px !important;">
                                <input type="checkbox"
                                       class="sectionRepresentativeBox"
                                       value="' . $m . '"
                                       name="sectionRepresentativeBox[]"
                                       id="sectionRepresentativeBox_' . $m . '"
                                       checked="checked"/>
                                <b class="float-left mr-2">' . $m . '. </b>
                                <span class="float-left"></span>
                            </label>
                            <div class="form-group float-left m-0"
                                 style="width: calc(100% - 61px) !important">
                                <label>
                                    * Task Heading
                                    <small>(' . $m . ')</small>
                                </label>
                                <input ' . $TAttrs . $onblur . '
                                    id="task_heading_' . $m . '"
                                    value="' . $fetch_evaluation_tasks->task_heading . '"
                                    placeholder="Task Heading">
                                <div class="error_wrapper">
                                    <span class="text-danger" id="errorMessageTaskHeading_' . $m . '"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 column">
                            <label> * Task Weight </label>
                            <div class="input-group">
                                <input ' . $TAttrs . $onblur . '
                                    maxlength="6"
                                    onkeypress="allowNumberAndPointLess(event)"
                                    id="task_weight_' . $m . '"
                                    value="' . $fetch_evaluation_tasks->task_weight . '"
                                    placeholder="Task Weight">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="fas fa-percent icon-md"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="error_wrapper">
                                <span class="text-danger" id="errorMessageTaskWeight_' . $m . '"></span>
                            </div>
                        </div>
                    </div>
                    <div class="Targets_Holder_Child_Div"
                         id="Targets_Holder_Child_Div_' . $m . '">
                        <div class="row mt-5 mb-5">
                            <div class="col-md-1 column text-center">
                                <b>Sr.</b>
                            </div>
                            <div class="col-md-11 column">
                                <b>* Task Description</b>
                            </div>
                        </div>
                        ' . $inner_data . '
                    </div>
                    <input type="hidden" name="r_row[]"
                           id="r_row' . $m . '"
                           value="' . --$i . '">
                    <button type="button"
                            class="btn btn-success float-right"
                            onclick="addNewTask(' . $m . ')">' . config("lang.button.title.add") . '</button>
                </div>';
            }
        } else {
            $task_heading_array = [1 => 'Targets', 2 => 'Task based Competencies', 3 => 'Capabilities and Behaviors'];
            $task_weight_array = [1 => '50.00', 2 => '25.00', 3 => '25.00'];
            for ($m = 1; $m <= 3; $m++) {
                $inner_data = '';
                for ($i = 1; $i <= 3; $i++) {
                    $inner_data .= '
                        <div class="row">
                            <div class="col-md-1 column">
                                <div class="form-group text-center mt-3">
                                    <label class="checkbox checkbox-outline checkbox-success d-inline-block">
                                        <input type="checkbox"
                                               class="lineRepresentativeBox' . $m . '"
                                               value="' . $i . '"
                                               name="lineRepresentativeBox[]"
                                               id="lineRepresentativeBox_' . $m . '_' . $i . '"/>
                                        <b class="float-left mr-2">' . $i . '. </b>
                                        <span class="float-left"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-11 column">
                                <div class="form-group">
                                    <textarea rows="2" id="task_description_' . $m . '_' . $i . '" ' . $TAttrs . $onblur . ' placeholder="Task Description"></textarea>
                                </div>
                            </div>
                        </div>';
                }

                $data .= '
                <div class="evaluation_single_task_section">
                    <div class="row mt-7">
                        <div class="col-md-6 column">
                            <label class="checkbox checkbox-outline checkbox-success float-left"
                                   style="margin: 35px 0 0 0; width: 60px !important;">
                                <input type="checkbox"
                                       class="sectionRepresentativeBox"
                                       value="' . $m . '"
                                       name="sectionRepresentativeBox[]"
                                       id="sectionRepresentativeBox_' . $m . '"
                                       checked="checked"/>
                                <b class="float-left mr-2">' . $m . '. </b>
                                <span class="float-left"></span>
                            </label>
                            <div class="form-group float-left m-0"
                                 style="width: calc(100% - 61px) !important">
                                <label>
                                    * Task Heading
                                    <small>(' . $m . ')</small>
                                </label>
                                <input ' . $TAttrs . $onblur . '
                                    id="task_heading_' . $m . '"
                                    value="' . $task_heading_array[$m] . '"
                                    placeholder="Task Heading">
                                <div class="error_wrapper">
                                    <span class="text-danger" id="errorMessageTaskHeading_' . $m . '"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 column">
                            <label> * Task Weight </label>
                            <div class="input-group">
                                <input ' . $TAttrs . $onblur . '
                                    maxlength="6"
                                    onkeypress="allowNumberAndPointLess(event)"
                                    id="task_weight_' . $m . '"
                                    value="' . $task_weight_array[$m] . '"
                                    placeholder="Task Weight">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="fas fa-percent icon-md"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="error_wrapper">
                                <span class="text-danger" id="errorMessageTaskWeight_' . $m . '"></span>
                            </div>
                        </div>
                    </div>
                    <div class="Targets_Holder_Child_Div"
                         id="Targets_Holder_Child_Div_' . $m . '">
                        <div class="row mt-5 mb-5">
                            <div class="col-md-1 column text-center">
                                <b>Sr.</b>
                            </div>
                            <div class="col-md-11 column">
                                <b>* Task Description</b>
                            </div>
                        </div>
                        ' . $inner_data . '
                    </div>
                    <input type="hidden" name="r_row[]"
                           id="r_row' . $m . '"
                           value="' . --$i . '">
                    <button type="button"
                            class="btn btn-success float-right"
                            onclick="addNewTask(' . $m . ')">' . config("lang.button.title.add") . '</button>
                </div>';
            }
        }
    }
    echo json_encode(["code" => 200, "data" => $data, 'last_section' => $m, "toasterClass" => 'success', "responseMessage" => 'This is Message']);
}

if (isset($_POST['postData'], $_POST['getRelatedSalaryBands']) && $_POST['getRelatedSalaryBands'] == true) {
    $object = (object)$_POST['postData'];
    $department_id = $object->department_id;
    $salary_grade_id = 0;
    $data = getRelatedSalaryBands($department_id, $salary_grade_id, $company_id, $branch_id);
    echo json_encode(["code" => 200, "data" => $data]);
}

if (isset($_POST['postData'], $_POST['getRelatedSalaryGrades']) && $_POST['getRelatedSalaryGrades'] == true) {
    $object = (object)$_POST['postData'];
    $salary_grade_id = $object->salary_grade_id;
    $salary_grade_detail_id = 0;
    $data = getRelatedSalaryGrades($salary_grade_id, $salary_grade_detail_id);
    echo json_encode(["code" => 200, "data" => $data]);
}

if (isset($_POST['postData'], $_POST['readNotification']) && $_POST['readNotification'] == true) {

    $object = (object)$_POST['postData'];
    $status = config('notifications.status.value.read');

    if (isset($object->id) && !empty($object->id) && is_numeric($object->id) && $object->id > 0) {
        mysqli_query($db, "UPDATE `notifications` SET `status`='{$status}' WHERE `id`='{$object->id}' AND `company_id`='{$company_id}' AND `branch_id`='{$branch_id}'");
        $data = getNotification($global_employee_id);
        echo json_encode(["code" => 200, "data" => $data]);
    }
}

if (isset($_POST['postData'], $_POST['sendEvaluationMail']) && $_POST['sendEvaluationMail'] == true) {
    $object = (object)$_POST['postData'];
    $url = $object->url;
    $appraise = $object->appraise;
    $appraiser = $object->appraiser;
    $appraiseInfo = getEmployeeInfoFromId($appraise);
    $appraiserInfo = getEmployeeInfoFromId($appraiser);

    $subject = 'evaluation_start';
    $mail_body = getMailBody($subject, ['{mailToName}' => $appraiserInfo->full_name, '{mailTo}' => $appraiserInfo->official_email, '{ResourceName}' => $appraiseInfo->full_name, '{link}' => $url]);
    $parameters = [
        'subject' => $subject,
        'data' => [
            'email_body' => $mail_body['html'],
            'message' => $mail_body['message'],
        ],
        'mailTo' => [
            'email' => $appraiserInfo->official_email,
            'name' => $appraiserInfo->full_name,
        ]
    ];
    echo $response = sendEmail($parameters);
}

if (isset($_POST['postData'], $_POST['resetPassword']) && $_POST['resetPassword'] == true) {

    $object = (object)$_POST['postData'];
    $oldPassword = $object->old_password;
    $newPassword = $object->new_password;
    $confirmPassword = $object->confirm_password;

    if (empty($oldPassword)) {
        echo json_encode(['code' => 422, 'errorField' => 'old_password', 'errorDiv' => 'errorMessageOldPassword', 'errorMessage' => 'Old Password field is required.']);
    } else if (empty($newPassword)) {
        echo json_encode(['code' => 422, 'errorField' => 'new_password', 'errorDiv' => 'errorMessageNewPassword', 'errorMessage' => 'New Password field is required.']);
    } else if (strlen($newPassword) <= 8) {
        echo json_encode(['code' => 422, 'errorField' => 'new_password', 'errorDiv' => 'errorMessageNewPassword', 'errorMessage' => 'Password should be more than 8 characters.']);
    } else if (lowerCaseExist($newPassword) === false) {
        echo json_encode(['code' => 422, 'errorField' => 'new_password', 'errorDiv' => 'errorMessageNewPassword', 'errorMessage' => 'Please enter at least one lowercase character. (a-z)']);
    } else if (uppercaseExist($newPassword) === false) {
        echo json_encode(['code' => 422, 'errorField' => 'new_password', 'errorDiv' => 'errorMessageNewPassword', 'errorMessage' => 'Please enter at least one uppercase character. (A-Z)']);
    } else if (numberExist($newPassword) === false) {
        echo json_encode(['code' => 422, 'errorField' => 'new_password', 'errorDiv' => 'errorMessageNewPassword', 'errorMessage' => 'Please enter at least one digit character. (0-9)']);
    } else if (specialCharactersExist($newPassword) === false) {
        echo json_encode(['code' => 422, 'errorField' => 'new_password', 'errorDiv' => 'errorMessageNewPassword', 'errorMessage' => 'Password should contain at least one special character. (!@#$%^&*)']);
    } else if ($oldPassword == $newPassword) {
        echo json_encode(['code' => 422, 'errorField' => 'new_password', 'errorDiv' => 'errorMessageNewPassword', 'errorMessage' => 'Your New Password should be different from the previous One.']);
    } else if (empty($confirmPassword)) {
        echo json_encode(['code' => 422, 'errorField' => 'confirm_password', 'errorDiv' => 'errorMessageConfirmPassword', 'errorMessage' => 'Confirm Password field is required.']);
    } else if ($confirmPassword != $newPassword) {
        echo json_encode(['code' => 422, 'errorField' => 'confirm_password', 'errorDiv' => 'errorMessageConfirmPassword', 'errorMessage' => 'Password mismatch.']);
    } else {
        $old_password = md5($oldPassword);
        $password = md5($newPassword);
        $confirm_password = md5($confirmPassword);

        if (isset($object->old_password, $object->new_password, $object->confirm_password) && !empty($object->old_password) && !empty($object->new_password) && !empty($object->confirm_password)) {
            $select = mysqli_query($db, "SELECT u.id, u.email, e.company_id, e.branch_id, CONCAT(eb.first_name,' ',eb.last_name) AS user_name FROM users AS u INNER JOIN employees AS e ON e.id=u.employee_id INNER JOIN employee_basic_infos AS eb ON e.id=eb.employee_id WHERE u.id='{$global_user_id}' AND u.employee_id='{$global_employee_id}' AND u.password='{$old_password}' AND e.company_id='{$company_id}' AND e.branch_id='{$branch_id}' ORDER BY u.id ASC LIMIT 1");
            if (mysqli_num_rows($select) > 0) {
                if ($result = mysqli_fetch_object($select)) {
                    $id = $result->id;
                    $email = $result->email;
                    $user_name = $result->user_name;
                    if (mysqli_query($db, "UPDATE `users` SET `password`='{$password}' WHERE `id`='{$id}'")) {
                        $notification_type = config("notifications.type.value.password_reset");
                        $notification_status = config("notifications.status.value.pending");
                        $notification_body = getNotificationBody($notification_type);
                        insertNotification($notification_type, $global_employee_id, $global_employee_id, $id, $notification_body['message'], '', $notification_status, $company_id, $branch_id, $id);
                        $mail_body = getMailBody($notification_type, ['{mailToName}' => $user_name, '{mailTo}' => $email, '{newPassword}' => $newPassword]);
                        $parameters = [
                            'subject' => $notification_type,
                            'data' => [
                                'email_body' => $mail_body['html'],
                                'message' => $mail_body['message'],
                            ],
                            'mailTo' => [
                                'email' => $email,
                                'name' => $user_name,
                            ],
                        ];
                        sendEmail($parameters);
                        echo json_encode(["code" => 200, "toasterClass" => 'success', "responseMessage" => 'Password successfully changed.']);
                    } else {
                        echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'Unexpected error.']);
                    }
                }
            } else {
                echo json_encode(['code' => 422, 'errorField' => 'old_password', 'errorDiv' => 'errorMessageOldPassword', 'errorMessage' => 'Old Password is incorrect.']);
            }
        }
    }
}

?>