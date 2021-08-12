<?php
include_once("header/check_login.php");
include_once("../includes/head.php");
include_once("../includes/mobile_menu.php");
?>
    <!--begin::Main-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="d-flex flex-row flex-column-fluid page">
            <!--begin::Aside-->
            <?php include_once("../includes/main_menu.php"); ?>
            <!--end::Aside-->
            <!--begin::Wrapper-->
            <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
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
                                <div class="col-lg-12">
                                    <div class="card card-custom">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                                <?php
                                                if (isset($_GET['id'])) {
                                                    if (!hasRight($user_right_title, 'edit')) {
                                                        header('Location: ' . $page_not_found_url);
                                                        exit();
                                                    }
                                                    echo 'Edit ' . ucwords(str_replace("_", " ", $page));
                                                    $id = htmlentities($_GET['id']);
                                                    $Q = "SELECT * FROM `evaluations` WHERE `id`='{$id}'  AND `company_id`='{$global_company_id}' AND `branch_id`='{$global_branch_id}' AND `deleted_at` IS NULL";
                                                    $Qry = mysqli_query($db, $Q);
                                                    $Rows = mysqli_num_rows($Qry);
                                                    if ($Rows != 1) {
                                                        header('Location: ' . $page_not_found_url);
                                                        exit();
                                                    } else {
                                                        $Result = mysqli_fetch_object($Qry);
                                                        $name = html_entity_decode(stripslashes($Result->name));
                                                        $evaluation_type_id = html_entity_decode(stripslashes($Result->evaluation_type_id));
                                                        $date = html_entity_decode(stripslashes(date('d-m-Y', strtotime($Result->date))));
                                                        $department_id = html_entity_decode(stripslashes($Result->department_id));
                                                        $designation_id = html_entity_decode(stripslashes($Result->designation_id));
                                                    }
                                                } else {
                                                    if (!hasRight($user_right_title, 'add')) {
                                                        header('Location: ' . $page_not_found_url);
                                                        exit();
                                                    }
                                                    echo ucwords(str_replace("_", " ", $page));
                                                    $id = $department_id = $evaluation_type_id = $designation_id = 0;
                                                    $name = 'Perform Evaluation';
                                                    $date = date('d-m-Y');
                                                }
                                                $TAttrs = ' type="text" class="form-control" ';
                                                $onblur = ' onblur="change_color(this.value, this.id)" ';
                                                $DateInput = '  type="text" class="DatePicker e-input form-control" onkeypress="openCalendar(event)" onfocus="openCalendar(event)" onclick="openCalendar(event)" maxlength="10" data-format="dd-MM-yyyy" ';
                                                ?>
                                            </h3>
                                        </div>
                                        <!--begin::Form-->
                                        <form class="form" id="myFORM" name="myFORM" method="post"
                                              enctype="multipart/form-data">
                                            <input type="hidden" name="id" id="id" value="<?php echo $id; ?>"/>
                                            <div class="card-body overflow-hidden">

                                                <div class="alert alert-custom alert-light-success overflow-hidden"
                                                     role="alert" id="responseMessageWrapper">
                                                    <div class="alert-text font-weight-bold float-left"
                                                         id="responseMessage"></div>
                                                </div>

                                                <div class="mb-3">
                                                    <div class="mb-2">
                                                        <div class="row">
                                                            <input type="hidden" class="not-display" maxlength="50"
                                                                   id="name" value="<?php echo $name; ?>"/>

                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>* Date:</label>
                                                                    <input <?php echo $DateInput; ?>
                                                                            tabindex="10"
                                                                            value="<?php echo $date; ?>"
                                                                            id="date" placeholder="Date"">
                                                                    <span class="e-clear-icon e-clear-icon-hide"
                                                                          aria-label="close" role="button"></span>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageDate"></span>
                                                                        <span class="not-display"
                                                                              id="errorMessageName"></span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>* Evaluation Type:</label>
                                                                    <select tabindex="20"
                                                                            id="evaluation_type_id" <?php echo $TAttrs . $onblur; ?>>
                                                                        <option selected="selected" value="0">
                                                                            Select
                                                                        </option>
                                                                        <?php
                                                                        $select = "SELECT `id`,`name` FROM `evaluation_types` WHERE `company_id`='{$global_company_id}' AND `branch_id`='{$global_branch_id}' AND `deleted_at` IS NULL ORDER BY `sort_by` ASC";
                                                                        $query = mysqli_query($db, $select);
                                                                        if (mysqli_num_rows($query) > 0) {
                                                                            while ($result = mysqli_fetch_object($query)) {
                                                                                $selected = '';
                                                                                if ($evaluation_type_id == $result->id) {
                                                                                    $selected = 'selected="selected"';
                                                                                }
                                                                                ?>
                                                                                <option <?php echo $selected; ?>
                                                                                        value="<?php echo $result->id; ?>"><?php echo $result->name; ?></option>
                                                                                <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageEvaluationType"></span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>* Department:</label>
                                                                    <select id="department_id"
                                                                            onchange="changeDepartment(),getTeamsAndDesignations(event)" <?php echo $TAttrs . $onblur; ?>>
                                                                        <option selected="selected" value="">
                                                                            Select
                                                                        </option>
                                                                        <?php
                                                                        $select = "SELECT `id`,`name` FROM `departments` WHERE `company_id`='{$global_company_id}' AND `branch_id`='{$global_branch_id}' AND `deleted_at` IS NULL ORDER BY `sort_by` ASC";
                                                                        $query = mysqli_query($db, $select);
                                                                        if (mysqli_num_rows($query) > 0) {
                                                                            while ($result = mysqli_fetch_object($query)) {
                                                                                $selected = '';
                                                                                if ($department_id == $result->id) {
                                                                                    $selected = 'selected="selected"';
                                                                                }
                                                                                ?>
                                                                                <option <?php echo $selected; ?>
                                                                                        value="<?php echo $result->id; ?>"><?php echo $result->name; ?></option>
                                                                                <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageDepartment"></span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>* Designation:</label>
                                                                    <select id="designation_id"
                                                                            onchange="getEmployeesTeamWise()" <?php echo $TAttrs . $onblur; ?>>
                                                                        <?php
                                                                        if (!empty($department_id)) {
                                                                            echo getDesignations($department_id, $designation_id, $global_company_id, $global_branch_id);
                                                                        } else {
                                                                            echo '<option selected="selected" value="">Select
                                                                        </option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageDesignation"></span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="teamWiseEmployees">
                                                    <?php
                                                    if (isset($id, $department_id, $designation_id) && !empty($id) && !empty($department_id) && !empty($designation_id) && $id > 0 && $department_id > 0 && $designation_id > 0) {
                                                        $return = getEmployeesTeamWise($id, $department_id, $designation_id, $global_company_id, $global_branch_id);
                                                        echo $return['data'];
                                                    }
                                                    ?>
                                                </div>

                                                <div class="separator separator-dashed my-10"></div>

                                                <div class="mb-3">
                                                    <div class="mb-2"
                                                         style="webkit-box-shadow: 0 2px 5px 0 rgba(0,0,0,0.16) !important; box-shadow: 0 2px 5px 0 rgba(0,0,0,0.16) !important;">
                                                        <div id="Targets_Holder_Parent_Div_Header">
                                                            <h3 class="font-size-lg font-weight-bold float-left"
                                                                style="margin: 10px 0 0 0 !important;">
                                                                Targets Information:
                                                            </h3>
                                                            <button type="button"
                                                                    class="btn btn-primary btn-shadow font-weight-bold float-right"
                                                                    onclick="addNewSection()">Add Section
                                                            </button>
                                                        </div>
                                                        <div id="Targets_Holder_Parent_Div" style="max-height: 100%">
                                                            <?php
                                                            $task_heading_array = [1 => 'Targets', 2 => 'Task based Competencies', 3 => 'Capabilities and Behaviors'];
                                                            $task_weight_array = [1 => '50.00', 2 => '25.00', 3 => '25.00'];

                                                            if (isset($id) && is_numeric($id) && !empty($id)) {
                                                                $query_evaluation_tasks = mysqli_query($db, "SELECT `id`, `task_heading`, `task_weight` FROM `evaluation_tasks` WHERE `evaluation_id` = '{$id}'");
                                                                if (mysqli_num_rows($query_evaluation_tasks) > 0) {
                                                                    $m = 1;
                                                                    while ($fetch_evaluation_tasks = mysqli_fetch_object($query_evaluation_tasks)) {
                                                                        ?>
                                                                        <div class="evaluation_single_task_section">
                                                                            <div class="row mt-7">
                                                                                <div class="col-md-6 column">
                                                                                    <label class="checkbox checkbox-outline checkbox-success float-left"
                                                                                           style="margin: 35px 0 0 0; width: 60px !important;">
                                                                                        <input type="checkbox"
                                                                                               class="sectionRepresentativeBox"
                                                                                               value="<?php echo $m; ?>"
                                                                                               name="sectionRepresentativeBox[]"
                                                                                               id="sectionRepresentativeBox_<?php echo $m; ?>"
                                                                                               checked="checked"/>
                                                                                        <b class="float-left mr-2"><?php echo $m; ?>
                                                                                            . </b>
                                                                                        <span class="float-left"></span>
                                                                                    </label>
                                                                                    <div class="form-group float-left m-0"
                                                                                         style="width: calc(100% - 61px) !important">
                                                                                        <label>
                                                                                            * Task Heading
                                                                                            <small>( <?php echo $m; ?>
                                                                                                )
                                                                                            </small>
                                                                                        </label>
                                                                                        <input <?php echo $TAttrs . $onblur; ?>
                                                                                                id="task_heading_<?php echo $m; ?>"
                                                                                                value="<?php echo $fetch_evaluation_tasks->task_heading; ?>"
                                                                                                placeholder="Task Heading">
                                                                                        <div class="error_wrapper">
                                                                            <span class="text-danger"
                                                                                  id="errorMessageTaskHeading_<?php echo $m; ?>"></span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6 column">
                                                                                    <label> * Task Weight </label>
                                                                                    <div class="input-group">
                                                                                        <input <?php echo $TAttrs . $onblur; ?>
                                                                                                maxlength="6"
                                                                                                onkeypress="allowNumberAndPointLess(event)"
                                                                                                id="task_weight_<?php echo $m; ?>"
                                                                                                value="<?php echo $fetch_evaluation_tasks->task_weight; ?>"
                                                                                                placeholder="Task Weight">
                                                                                        <div class="input-group-append">
                                                                                    <span class="input-group-text">
                                                                                        <i class="fas fa-percent icon-md"></i>
                                                                                    </span>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="error_wrapper">
                                                                                <span class="text-danger"
                                                                                      id="errorMessageTaskWeight_<?php echo $m; ?>"></span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="Targets_Holder_Child_Div"
                                                                                 id="Targets_Holder_Child_Div_<?php echo $m; ?>">
                                                                                <div class="row mt-5 mb-5">
                                                                                    <div class="col-md-1 column text-center">
                                                                                        <b>Sr.</b>
                                                                                    </div>
                                                                                    <div class="col-md-11 column">
                                                                                        <b>Task Description</b>
                                                                                    </div>
                                                                                </div>
                                                                                <?php
                                                                                $query_evaluation_task_details = mysqli_query($db, "SELECT `id`, `task_description` FROM `evaluation_task_details` WHERE `evaluation_task_id` = '{$fetch_evaluation_tasks->id}'");
                                                                                if (mysqli_num_rows($query_evaluation_task_details) > 0) {
                                                                                    $i = 1;
                                                                                    while ($fetch_evaluation_task_details = mysqli_fetch_object($query_evaluation_task_details)) {
                                                                                        ?>
                                                                                        <div class="row">
                                                                                            <div class="col-md-1 column">
                                                                                                <div class="form-group text-center mt-3">
                                                                                                    <label class="checkbox checkbox-outline checkbox-success d-inline-block">
                                                                                                        <input type="checkbox"
                                                                                                               class="lineRepresentativeBox<?php echo $m; ?>"
                                                                                                               value="<?php echo $i; ?>"
                                                                                                               name="lineRepresentativeBox[]"
                                                                                                               id="lineRepresentativeBox_<?php echo $m; ?>_<?php echo $i; ?>"
                                                                                                               checked="checked"/>
                                                                                                        <b class="float-left mr-2"><?php echo $i; ?>
                                                                                                            . </b>
                                                                                                        <span class="float-left"></span>
                                                                                                    </label>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-11 column">
                                                                                                <div class="form-group">
                                                                                <textarea rows="2"
                                                                                          id="task_description_<?php echo $m; ?>_<?php echo $i; ?>" <?php echo $TAttrs . $onblur; ?> placeholder="Task Description"><?php echo $fetch_evaluation_task_details->task_description; ?></textarea>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <?php
                                                                                        $i++;
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </div>
                                                                            <input type="hidden" name="r_row[]"
                                                                                   id="r_row<?php echo $m; ?>"
                                                                                   value="<?php echo --$i; ?>">
                                                                            <button type="button"
                                                                                    class="btn btn-success float-right"
                                                                                    onclick="addNewTask(<?php echo $m; ?>)">
                                                                                <?php echo config('lang.button.title.add'); ?>
                                                                            </button>
                                                                        </div>
                                                                        <?php
                                                                        $m++;
                                                                    }
                                                                }
                                                            } else {
                                                                for ($m = 1; $m <= 0; $m++) {
                                                                    ?>
                                                                    <div class="evaluation_single_task_section">
                                                                        <div class="row mt-7">
                                                                            <div class="col-md-6 column">
                                                                                <label class="checkbox checkbox-outline checkbox-success float-left"
                                                                                       style="margin: 35px 0 0 0; width: 60px !important;">
                                                                                    <input type="checkbox"
                                                                                           class="sectionRepresentativeBox"
                                                                                           value="<?php echo $m; ?>"
                                                                                           name="sectionRepresentativeBox[]"
                                                                                           id="sectionRepresentativeBox_<?php echo $m; ?>"
                                                                                           checked="checked"/>
                                                                                    <b class="float-left mr-2"><?php echo $m; ?>
                                                                                        . </b>
                                                                                    <span class="float-left"></span>
                                                                                </label>
                                                                                <div class="form-group float-left m-0"
                                                                                     style="width: calc(100% - 61px) !important">
                                                                                    <label>
                                                                                        * Task Heading
                                                                                        <small>( <?php echo $m; ?>
                                                                                            )
                                                                                        </small>
                                                                                    </label>
                                                                                    <input <?php echo $TAttrs . $onblur; ?>
                                                                                            id="task_heading_<?php echo $m; ?>"
                                                                                            value="<?php echo $task_heading_array[$m]; ?>"
                                                                                            placeholder="Task Heading">
                                                                                    <div class="error_wrapper">
                                                                            <span class="text-danger"
                                                                                  id="errorMessageTaskHeading_<?php echo $m; ?>"></span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6 column">
                                                                                <label> * Task Weight </label>
                                                                                <div class="input-group">
                                                                                    <input <?php echo $TAttrs . $onblur; ?>
                                                                                            maxlength="6"
                                                                                            onkeypress="allowNumberAndPointLess(event)"
                                                                                            id="task_weight_<?php echo $m; ?>"
                                                                                            value="<?php echo $task_weight_array[$m]; ?>"
                                                                                            placeholder="Task Weight">
                                                                                    <div class="input-group-append">
                                                                                    <span class="input-group-text">
                                                                                        <i class="fas fa-percent icon-md"></i>
                                                                                    </span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="error_wrapper">
                                                                                <span class="text-danger"
                                                                                      id="errorMessageTaskWeight_<?php echo $m; ?>"></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="Targets_Holder_Child_Div"
                                                                             id="Targets_Holder_Child_Div_<?php echo $m; ?>">
                                                                            <div class="row mt-5 mb-5">
                                                                                <div class="col-md-1 column text-center">
                                                                                    <b>Sr.</b>
                                                                                </div>
                                                                                <div class="col-md-11 column">
                                                                                    <b>Task Description</b>
                                                                                </div>
                                                                            </div>
                                                                            <?php
                                                                            for ($i = 1; $i <= 3; $i++) {
                                                                                ?>
                                                                                <div class="row">
                                                                                    <div class="col-md-1 column">
                                                                                        <div class="form-group text-center mt-3">
                                                                                            <label class="checkbox checkbox-outline checkbox-success d-inline-block">
                                                                                                <input type="checkbox"
                                                                                                       class="lineRepresentativeBox<?php echo $m; ?>"
                                                                                                       value="<?php echo $i; ?>"
                                                                                                       name="lineRepresentativeBox[]"
                                                                                                       id="lineRepresentativeBox_<?php echo $m; ?>_<?php echo $i; ?>"/>
                                                                                                <b class="float-left mr-2"><?php echo $i; ?>
                                                                                                    . </b>
                                                                                                <span class="float-left"></span>
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-11 column">
                                                                                        <div class="form-group">
                                                                                <textarea rows="2"
                                                                                          id="task_description_<?php echo $m; ?>_<?php echo $i; ?>" <?php echo $TAttrs . $onblur; ?> placeholder="Task Description"></textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                        <input type="hidden" name="r_row[]"
                                                                               id="r_row<?php echo $m; ?>"
                                                                               value="<?php echo --$i; ?>">
                                                                        <button type="button"
                                                                                class="btn btn-success float-right"
                                                                                onclick="addNewTask(<?php echo $m; ?>)">
                                                                            <?php echo config('lang.button.title.add'); ?>
                                                                        </button>
                                                                    </div>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                        <input type="hidden" id="last_section"
                                                               value="<?php echo --$m; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <button type="button" onclick="saveFORM()"
                                                                class="btn btn-primary font-weight-bold mr-2"><?php echo config('lang.button.title.save'); ?>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <!--end::Form-->
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
    <script type='text/javascript'>

        function addNewTask(s) {
            var r_rows = document.getElementById('r_row' + s).value;
            r_rows++;
            var innerHTml_c = '';
            innerHTml_c += '<div class="row">';
            innerHTml_c += '<div class="col-md-1 column"><div class="form-group text-center mt-3"><label class="checkbox checkbox-outline checkbox-success d-inline-block"><input type="checkbox" class="lineRepresentativeBox' + s + '" value="' + r_rows + '" name="lineRepresentativeBox[]" id="lineRepresentativeBox_' + s + '_' + r_rows + '" checked="checked"><b class="float-left mr-2">' + r_rows + '.</b><span class="float-left"></span></label></div></div>';
            innerHTml_c += '<div class="col-md-11 column"><div class="form-group"><textarea rows="2" id="task_description_' + s + '_' + r_rows + '" <?php echo $TAttrs . $onblur; ?> placeholder="Task Description"></textarea></div></div>';
            innerHTml_c += '</div>';
            $("#Targets_Holder_Child_Div_" + s).append(innerHTml_c);
            document.getElementById('r_row' + s).value = r_rows;
        }

        function addNewSection() {
            var s = document.getElementById('last_section').value;
            s++;
            var innerHTML = '<div class="evaluation_single_task_section">';
            innerHTML += '<div class="row mt-7"><div class="col-md-6 column">';
            innerHTML += '<label class="checkbox checkbox-outline checkbox-success float-left" style="margin: 35px 0 0 0; width: 60px !important;">';
            innerHTML += '<input type="checkbox" class="sectionRepresentativeBox" value="' + s + '" name="sectionRepresentativeBox[]" id="sectionRepresentativeBox_' + s + '" checked="checked"/>';
            innerHTML += '<b class="float-left mr-2">' + s + '. </b><span class="float-left"></span>';
            innerHTML += '</label>';
            innerHTML += '<div class="form-group float-left m-0" style="width: calc(100% - 61px) !important">';
            innerHTML += '<label>* Task Heading <small>( ' + s + ' )</small> </label>';
            innerHTML += '<input <?php echo $TAttrs . $onblur; ?> id="task_heading_' + s + '" value="" placeholder="Task Heading">';
            innerHTML += '<div class="error_wrapper"><span class="text-danger" id="errorMessageTaskHeading_' + s + '"></span></div>';
            innerHTML += '</div></div>';
            innerHTML += '<div class="col-md-6 column">';
            innerHTML += '<label>* Task Weight </label>';
            innerHTML += '<div class="input-group"><input <?php echo $TAttrs . $onblur; ?> maxlength="6" onkeypress="allowNumberAndPointLess(event)" id="task_weight_' + s + '" value="" placeholder="Task Weight"><div class="input-group-append">';
            innerHTML += '<span class="input-group-text"><i class="fas fa-percent icon-md"></i></span>';
            innerHTML += '</div></div>';
            innerHTML += '<div class="error_wrapper"><span class="text-danger" id="errorMessageTaskWeight_' + s + '"></span></div>';
            innerHTML += '</div></div>';
            innerHTML += '<div class="Targets_Holder_Child_Div" id="Targets_Holder_Child_Div_' + s + '">';
            innerHTML += '<div class="row mt-5 mb-5">';
            innerHTML += '<div class="col-md-1 column text-center"><b>Sr.</b></div>';
            innerHTML += '<div class="col-md-11 column"><b>* Task Description</b></div>';
            innerHTML += '</div>';
            for (i = 1; i <= 3; i++) {
                innerHTML += '<div class="row">';
                innerHTML += '<div class="col-md-1 column"><div class="form-group text-center mt-3"><label class="checkbox checkbox-outline checkbox-success d-inline-block"><input type="checkbox" class="lineRepresentativeBox' + s + '" value="' + i + '" name="lineRepresentativeBox[]" id="lineRepresentativeBox_' + s + '_' + i + '" checked="checked"><b class="float-left mr-2">' + i + '.</b><span class="float-left"></span></label></div></div>';
                innerHTML += '<div class="col-md-11 column"><div class="form-group"><textarea rows="2" id="task_description_' + s + '_' + i + '" <?php echo $TAttrs . $onblur; ?> placeholder="Task Description"></textarea></div></div>';
                innerHTML += '</div>';
            }
            innerHTML += '</div>';
            innerHTML += '<input type="hidden" name="r_row[]" id="r_row' + s + '" value="' + --i + '">';
            innerHTML += '<button type="button" class="btn btn-success float-right" onclick="addNewTask(' + s + ')">Add Task</button>';
            innerHTML += '</div>';
            $("#Targets_Holder_Parent_Div").append(innerHTML);
            document.getElementById('last_section').value = s;
            var objDiv = document.getElementById('Targets_Holder_Parent_Div');
            objDiv.scrollTop = objDiv.scrollHeight;
        }

        function changeDepartment() {
            document.getElementById('designation_id').value = '';
            getEmployeesTeamWise();
        }

        function getEmployeesTeamWise() {
            document.getElementById('teamWiseEmployees').innerHTML = '';
            var department_id = document.getElementById('department_id').value;
            var designation_id = document.getElementById('designation_id').value;
            if (department_id != '' && department_id > 0 && designation_id != '' && designation_id > 0) {
                loader(true);
                var postData = {
                    "evaluation_id": <?php echo $id; ?>,
                    "department_id": department_id,
                    "designation_id": designation_id,
                };
                $.ajax({
                    type: "POST", url: "ajax/common.php",
                    data: {'postData': postData, 'getEmployeesTeamWise': true},
                    success: function (resPonse) {
                        if (resPonse !== undefined && resPonse != '') {
                            var obj = JSON.parse(resPonse);
                            if (obj.code !== undefined && obj.code != '' && (obj.code === 200 || obj.code === 404)) {
                                if (obj.data !== undefined && obj.data != '') {
                                    document.getElementById('teamWiseEmployees').innerHTML = obj.data;
                                    toasterTrigger(obj.toasterClass, obj.responseMessage);
                                    loader(false);
                                } else {
                                    loader(false);
                                }
                            } else {
                                loader(false);
                            }
                        }
                    }
                });
                getCommonJD(department_id, designation_id);
            }
        }

        function getCommonJD(department_id, designation_id) {
            var postData = {
                "department_id": department_id,
                "designation_id": designation_id,
            };
            $.ajax({
                type: "POST", url: "ajax/common.php",
                data: {'postData': postData, 'getCommonJD': true},
                success: function (resPonse) {
                    if (resPonse !== undefined && resPonse != '') {
                        var obj = JSON.parse(resPonse);
                        if (obj.code !== undefined && obj.code != '' && (obj.code === 200 || obj.code === 404)) {
                            if (obj.data !== undefined && obj.data != '' && obj.last_section !== undefined && obj.last_section > 0) {
                                //console.log(obj);
                                document.getElementById('Targets_Holder_Parent_Div').innerHTML = obj.data;
                                //loader(false);
                            } else {
                                //loader(false);
                            }
                        } else {
                            //loader(false);
                        }
                    }
                }
            });
        }

        function saveFORM() {

            var checkValidName = /[^a-zA-Z0-9+-._,@&#/)(’' ]/;
            var validDate = /^(0[1-9]|1\d|2\d|3[01])\-(0[1-9]|1[0-2])\-(19|20)\d{2}$/;

            var id = document.getElementById('id');
            var A = '<?php echo hasRight($user_right_title, 'add') ?>';
            var E = '<?php echo hasRight($user_right_title, 'edit') ?>';

            var name = document.getElementById('name');
            var date = document.getElementById('date');
            var evaluation_type_id = document.getElementById('evaluation_type_id');
            var department_id = document.getElementById('department_id');
            var select2_department_id_container = document.querySelector("[aria-labelledby='select2-department_id-container']");

            var designation_id = document.getElementById('designation_id');
            var select2_designation_id_container = document.querySelector("[aria-labelledby='select2-designation_id-container']");

            var errorMessageName = document.getElementById('errorMessageName');
            var errorMessageDate = document.getElementById('errorMessageDate');
            var errorMessageEvaluationType = document.getElementById('errorMessageEvaluationType');
            var errorMessageDepartment = document.getElementById('errorMessageDepartment');
            var errorMessageDesignation = document.getElementById('errorMessageDesignation');
            var responseMessageWrapper = document.getElementById('responseMessageWrapper');
            var responseMessage = document.getElementById('responseMessage');

            name.style.borderColor = evaluation_type_id.style.borderColor = date.style.borderColor = select2_department_id_container.style.borderColor = select2_designation_id_container.style.borderColor = '#E4E6EF';
            errorMessageName.innerText = errorMessageEvaluationType.innerText = errorMessageDate.innerText = errorMessageDepartment.innerText = errorMessageDesignation.innerText = "";

            if (id.value == 0 && A == '') {
                toasterTrigger('warning', 'Sorry! You have no right to add record.');
            } else if (id.value > 0 && E == '') {
                toasterTrigger('warning', 'Sorry! You have no right to update record.');
            } else if (name.value == '') {
                name.style.borderColor = '#F00';
                var msg = "Name field is required.";
                errorMessageName.innerText = msg;
                toasterTrigger('error', msg);
                return false;
            } else if (checkValidName.test(name.value)) {
                name.style.borderColor = '#F00';
                msg = "Special Characters are not allowed in Name field.";
                errorMessageName.innerText = msg;
                toasterTrigger('error', msg);
                return false;
            } else if (name.value.length > 50) {
                name.style.borderColor = '#F00';
                msg = "Length should not exceed 50 characters.";
                errorMessageName.innerText = msg;
                toasterTrigger('error', msg);
                return false;
            } else if (date.value == '') {
                date.style.borderColor = '#F00';
                msg = "Date field is required.";
                errorMessageDate.innerText = msg;
                toasterTrigger('error', msg);
                return false;
            } else if (!(validDate.test(date.value)) || date.value.length !== 10) {
                date.style.borderColor = '#F00';
                msg = "Please select a valid date.";
                errorMessageDate.innerText = msg;
                toasterTrigger('error', msg);
                return false;
            } else if (evaluation_type_id.value <= 0) {
                evaluation_type_id.style.borderColor = '#F00';
                msg = "Evaluation Type field is required.";
                errorMessageEvaluationType.innerText = msg;
                toasterTrigger('error', msg);
                return false;
            } else if (evaluation_type_id.value == '' || isNaN(evaluation_type_id.value) === true || evaluation_type_id.value.length > 10) {
                evaluation_type_id.style.borderColor = '#F00';
                msg = "Please select a valid option.";
                errorMessageEvaluationType.innerText = msg;
                toasterTrigger('error', msg);
                return false;
            } else if (department_id.value == '') {
                select2_department_id_container.style.borderColor = '#F00';
                msg = "Department field is required.";
                errorMessageDepartment.innerText = msg;
                toasterTrigger('error', msg);
                return false;
            } else if (isNaN(department_id.value) === true || department_id.value.length > 10 || department_id.value <= 0) {
                select2_department_id_container.style.borderColor = '#F00';
                msg = "Please select a valid option.";
                errorMessageDepartment.innerText = msg;
                toasterTrigger('error', msg);
                return false;
            } else if (designation_id.value == '') {
                select2_designation_id_container.style.borderColor = '#F00';
                msg = "Designation field is required.";
                errorMessageDesignation.innerText = msg;
                toasterTrigger('error', msg);
                return false;
            } else if (isNaN(designation_id.value) === true || designation_id.value.length > 10 || designation_id.value <= 0) {
                select2_designation_id_container.style.borderColor = '#F00';
                msg = "Please select a valid option.";
                errorMessageDesignation.innerText = msg;
                toasterTrigger('error', msg);
                return false;
            } else {
                var employee_ids = [];
                var employeeCheckboxes = document.getElementsByClassName('employeeCheckboxes');

                for (var j = 0; employeeCheckboxes[j]; ++j) {
                    if (employeeCheckboxes[j].checked) {
                        var employee_id = employeeCheckboxes[j].value;
                        var team_id = employeeCheckboxes[j].dataset.team_id;
                        if (isNaN(employee_id) === false && isNaN(team_id) === false && employee_id > 0 && employee_id.length <= 10 && team_id.length <= 10) {
                            var employee_obj = {};
                            employee_obj = {
                                "employee_id": employee_id,
                                'team_id': team_id,
                            };
                            employee_ids.push(employee_obj);
                        }
                    }
                }

                if (employee_ids !== undefined && employee_ids.length > 0) {
                    var data = [];
                    var continueProcessing = false;
                    var message = 'Please checked at least one Target section.';
                    var sectionHeaderValue = null;

                    var sectionRepresentativeBox = document.getElementsByClassName('sectionRepresentativeBox');

                    for (var m = 0; sectionRepresentativeBox[m]; ++m) {
                        if (sectionRepresentativeBox[m].checked) {
                            sectionHeaderValue = sectionRepresentativeBox[m].value;

                            var task_heading = document.getElementById('task_heading_' + sectionHeaderValue);
                            var task_weight = document.getElementById('task_weight_' + sectionHeaderValue);

                            if (task_heading.value == '') {
                                task_heading.style.borderColor = '#F00';
                                message = 'Task Heading ( ' + sectionHeaderValue + ' ) field is required.';
                                continueProcessing = false;
                                break;
                            } else if (checkValidName.test(task_heading.value)) {
                                task_heading.style.borderColor = '#F00';
                                message = 'Special Characters are not Allowed in Task Heading ( ' + sectionHeaderValue + ' ) field.';
                                continueProcessing = false;
                                break;
                            } else if (task_weight.value == '') {
                                task_weight.style.borderColor = '#F00';
                                message = 'The Task Weight field is required.';
                                continueProcessing = false;
                                break;
                            } else if (isNaN(task_weight.value) === true) {
                                task_weight.style.borderColor = '#F00';
                                message = 'The Task Weight field should contain only numeric characters.';
                                continueProcessing = false;
                                break;
                            } else if (task_weight.value.length > 6) {
                                task_weight.style.borderColor = '#F00';
                                message = 'Length should not exceed 6 characters.';
                                continueProcessing = false;
                                break;
                            } else if (task_weight.value <= 0) {
                                task_weight.style.borderColor = '#F00';
                                message = 'The Task Weight field should greater than 0.';
                                continueProcessing = false;
                                break;
                            } else if (task_weight.value > 100) {
                                task_weight.style.borderColor = '#F00';
                                message = 'The Task Weight field should not greater than 100.';
                                continueProcessing = false;
                                break;
                            } else {
                                continueProcessing = true;

                                var lineRepresentativeBox = document.getElementsByClassName('lineRepresentativeBox' + sectionHeaderValue);
                                var tasks = [];
                                var continueTask = false;
                                var innerMessage = 'Please checked at least one Task under section ' + sectionHeaderValue;
                                var checkedTask = null;

                                for (var i = 0; lineRepresentativeBox[i]; ++i) {
                                    if (lineRepresentativeBox[i].checked) {
                                        checkedTask = lineRepresentativeBox[i].value;
                                        var task_description = document.getElementById('task_description_' + sectionHeaderValue + '_' + checkedTask);
                                        //var total_marks = document.getElementById('total_marks_' + sectionHeaderValue + '_' + checkedTask);

                                        if (task_description.value == '') {
                                            task_description.style.borderColor = '#F00';
                                            innerMessage = 'Task Description field is required, At line no ' + checkedTask;
                                            continueTask = false;
                                            break;
                                        } else if (checkValidName.test(task_description.value)) {
                                            task_description.style.borderColor = '#F00';
                                            innerMessage = 'Special Characters are not Allowed in Task Description field, At line no ' + checkedTask;
                                            continueTask = false;
                                            break;
                                        }/* else if (total_marks.value == '') {
                                            total_marks.style.borderColor = '#F00';
                                            innerMessage = 'The Measure field is required, At line no ' + checkedTask;
                                            continueTask = false;
                                            break;
                                        } else if (isNaN(total_marks.value) === true) {
                                            total_marks.style.borderColor = '#F00';
                                            innerMessage = 'Measure field should contain only numeric characters, At line no ' + checkedTask;
                                            continueTask = false;
                                            break;
                                        } else if (total_marks.value.length > 6) {
                                            total_marks.style.borderColor = '#F00';
                                            innerMessage = 'Length should not exceed 6 characters, At line no ' + checkedTask;
                                            continueTask = false;
                                            break;
                                        } else if (total_marks.value <= 0) {
                                            total_marks.style.borderColor = '#F00';
                                            innerMessage = 'The Measure field should greater than 0, At line no ' + checkedTask;
                                            continueTask = false;
                                            break;
                                        } else if (total_marks.value > 100) {
                                            total_marks.style.borderColor = '#F00';
                                            innerMessage = 'The Measure field should not greater than 100, At line no ' + checkedTask;
                                            continueTask = false;
                                            break;
                                        }*/ else {
                                            continueTask = true;
                                            var tasks_obj = {};
                                            tasks_obj = {
                                                "task_description": task_description.value,
                                                /*"total_marks": total_marks.value,*/
                                            };
                                            tasks.push(tasks_obj);
                                        }
                                    }
                                }

                                if (tasks !== undefined && tasks.length > 0 && continueTask === true) {
                                    var target_obj = {};
                                    target_obj = {
                                        "task_heading": task_heading.value,
                                        "task_weight": task_weight.value,
                                        "tasks": tasks
                                    };
                                    data.push(target_obj);
                                } else {
                                    toasterTrigger('error', innerMessage);
                                    break;
                                }

                            }
                        }
                    }

                    if (continueProcessing === false) {
                        toasterTrigger('error', message);
                        return false;
                    } else if (continueProcessing === true && continueTask === true && data.length > 0 && employee_ids.length > 0) {
                        loader(true);
                        var postData = {
                            "id": id.value,
                            "name": name.value,
                            "date": date.value,
                            "evaluation_type_id": evaluation_type_id.value,
                            "department_id": department_id.value,
                            "designation_id": designation_id.value,
                            "employee_ids": employee_ids,
                            "user_right_title": '<?php echo $user_right_title; ?>',
                            "data": data
                        };
                        $.ajax({
                            type: "POST", url: "ajax/evaluation.php",
                            data: {"postData": postData},
                            success: function (resPonse) {
                                if (resPonse !== undefined && resPonse != '') {
                                    var obj = JSON.parse(resPonse);
                                    if (obj.code === 200 || obj.code === 405 || obj.code === 406 || obj.code === 422) {
                                        if (obj.code === 422) {
                                            if (obj.errorField !== undefined && obj.errorField != '' && obj.errorMessage !== undefined && obj.errorMessage != '' && obj.toasterClass !== undefined && obj.toasterClass != '') {
                                                if (obj.errorField == 'department_id') {
                                                    select2_department_id_container.style.borderColor = '#F00';
                                                } else {
                                                    document.getElementById(obj.errorField).style.borderColor = '#F00';
                                                }
                                                loader(false);
                                                toasterTrigger(obj.toasterClass, obj.errorMessage);
                                            } else {
                                                loader(false);
                                            }
                                        } else if (obj.code === 405 || obj.code === 200) {
                                            if (obj.responseMessage !== undefined && obj.responseMessage != '') {
                                                if (obj.form_reset !== undefined && obj.form_reset) {
                                                    document.getElementById("myFORM").reset();
                                                    var select2_department_idContainer = document.getElementById("select2-department_id-container");
                                                    var select2_designation_idContainer = document.getElementById("select2-designation_id-container");

                                                    if (select2_department_idContainer) {
                                                        select2_department_idContainer.removeAttribute("title");
                                                        select2_department_idContainer.innerHTML = '<span class="select2-selection__placeholder">Select</span>';
                                                    }
                                                    if (select2_designation_idContainer) {
                                                        select2_designation_idContainer.removeAttribute("title");
                                                        select2_designation_idContainer.innerHTML = '<span class="select2-selection__placeholder">Select</span>';
                                                    }
                                                    document.getElementById('teamWiseEmployees').innerHTML = '';
                                                    document.getElementById('Targets_Holder_Parent_Div').innerHTML = '';
                                                    document.getElementById('designation_id').innerHTML = '';
                                                    document.getElementById('designation_id').value = '';
                                                }
                                                loader(false);
                                                toasterTrigger(obj.toasterClass, obj.responseMessage);
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
                } else {
                    toasterTrigger('error', "Please select at least one Employee.");
                    return false;
                }
            }
        }

    </script>

<?php include_once("../includes/endTags.php"); ?>