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
                                                    $Q = "SELECT `id`,`evaluation_type_id`,`department_id`,`salary_grade_id` FROM `evaluation_grading_policies` WHERE `id`='{$id}' AND `company_id`='{$global_company_id}' AND `branch_id`='{$global_branch_id}' AND `deleted_at` IS NULL";
                                                    $Qry = mysqli_query($db, $Q);
                                                    $Rows = mysqli_num_rows($Qry);
                                                    if ($Rows != 1) {
                                                        header('Location: ' . $page_not_found_url);
                                                        exit();
                                                    } else {
                                                        $Result = mysqli_fetch_object($Qry);
                                                        $evaluation_type_id = html_entity_decode(stripslashes($Result->evaluation_type_id));
                                                        $department_id = html_entity_decode(stripslashes($Result->department_id));
                                                        $salary_grade_id = html_entity_decode(stripslashes($Result->salary_grade_id));
                                                    }
                                                } else {
                                                    if (!hasRight($user_right_title, 'add')) {
                                                        header('Location: ' . $page_not_found_url);
                                                        exit();
                                                    }
                                                    echo 'Add ' . ucwords(str_replace("_", " ", $page));
                                                    $id = $evaluation_type_id = $department_id = $salary_grade_id = 0;
                                                }
                                                $TAttrs = ' type="text" class="form-control" ';
                                                $onblur = ' onblur="change_color(this.value, this.id)" ';
                                                ?>
                                            </h3>
                                        </div>
                                        <!--begin::Form-->
                                        <form class="form" id="myFORM" name="myFORM" method="post"
                                              enctype="multipart/form-data">
                                            <input type="hidden" name="id" id="id" value="<?php echo $id; ?>"/>
                                            <div class="card-body">
                                                <div class="alert alert-custom alert-light-danger overflow-hidden"
                                                     role="alert" id="responseMessageWrapper">
                                                    <div class="alert-text font-weight-bold float-left"
                                                         id="responseMessage">
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="mb-2">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>* Evaluation Type:</label>
                                                                            <select id="evaluation_type_id" <?php echo $TAttrs . $onblur; ?>>
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
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>* Department:</label>
                                                                            <select id="department_id" <?php echo $TAttrs . $onblur; ?>
                                                                                    onchange="getRelatedSalaryBands(this.value)">
                                                                                <option value="0">
                                                                                    All
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
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>* Salary Band:</label>
                                                                            <select id="salary_grade_id" <?php echo $TAttrs . $onblur; ?>>
                                                                                <?php
                                                                                echo getRelatedSalaryBands($department_id, $salary_grade_id, $global_company_id, $global_branch_id);
                                                                                ?>
                                                                            </select>
                                                                            <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageSalaryGradeId"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="separator separator-dashed my-10"></div>

                                                <div class="mb-3">
                                                    <h3 class="font-size-lg text-dark-75 font-weight-bold mb-10"> Set
                                                        Grading Policy:</h3>
                                                    <div class="mb-2">
                                                        <div id="Data_Holder_Parent_Div">
                                                            <div class="row">
                                                                <div class="col-md-1 column text-center"><b>Sr.</b>
                                                                </div>
                                                                <div class="col-md-2 column">
                                                                    <b>* Title</b>
                                                                </div>
                                                                <div class="col-md-2 column">
                                                                    <b>
                                                                        * Percentage
                                                                        <small> (From) </small>
                                                                    </b>
                                                                </div>
                                                                <div class="col-md-2 column">
                                                                    <b>
                                                                        * Percentage
                                                                        <small> (To) </small>
                                                                    </b>
                                                                </div>
                                                                <div class="col-md-1 column">
                                                                    <b>
                                                                        * Amount
                                                                        <small> (From) </small>
                                                                    </b>
                                                                </div>
                                                                <div class="col-md-1 column">
                                                                    <b>
                                                                        * Amount
                                                                        <small> (To) </small>
                                                                    </b>
                                                                </div>
                                                                <div class="col-md-3 column"><b>* Action</b></div>
                                                            </div>

                                                            <div id="Data_Holder_Child_Div" class="mt-7 mb-7"
                                                                 style="max-height: 100%">
                                                                <?php
                                                                $i = 1;
                                                                if (!empty($id)) {
                                                                    $query_gpd = mysqli_query($db, "SELECT * FROM `evaluation_grading_policy_details` WHERE `gp_id`='{$id}' ORDER BY `percentage_from` ASC");
                                                                    if (mysqli_num_rows($query_gpd) > 0) {
                                                                        while ($result_gpd = mysqli_fetch_object($query_gpd)) {
                                                                            ?>
                                                                            <div class="row">
                                                                                <div class="col-md-1 column">
                                                                                    <div class="form-group text-center mt-3">
                                                                                        <label class="checkbox checkbox-outline checkbox-success d-inline-block">
                                                                                            <input type="checkbox"
                                                                                                   class="lineRepresentativeBox"
                                                                                                   value="<?php echo $i; ?>"
                                                                                                   name="lineRepresentativeBox[]"
                                                                                                   checked="checked"
                                                                                                   id="lineRepresentativeBox<?php echo $i; ?>"/>
                                                                                            <b class="float-left mr-2"><?php echo $i; ?>
                                                                                                . </b>
                                                                                            <span class="float-left"></span>
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-2 column">
                                                                                    <div class="form-group">
                                                                                        <input maxlength="50"
                                                                                               id="gp_name<?php echo $i; ?>"
                                                                                               value="<?php echo $result_gpd->gp_name; ?>" <?php echo $TAttrs . $onblur; ?>
                                                                                               placeholder="Title"/>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-2 column">
                                                                                    <div class="input-group">
                                                                                        <input maxlength="6"
                                                                                               onkeypress="allowNumberAndPointLess(event)"
                                                                                               id="percentage_from<?php echo $i; ?>"
                                                                                               value="<?php echo $result_gpd->percentage_from; ?>" <?php echo $TAttrs . $onblur; ?>
                                                                                               placeholder="From"/>
                                                                                        <div class="input-group-append">
                                                                                    <span class="input-group-text">
                                                                                        <i class="fa fa-percent"
                                                                                           style="font-size: 12px;"></i>
                                                                                    </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-2 column">
                                                                                    <div class="input-group">
                                                                                        <input maxlength="6"
                                                                                               onkeypress="allowNumberAndPointLess(event)"
                                                                                               id="percentage_to<?php echo $i; ?>"
                                                                                               value="<?php echo $result_gpd->percentage_to; ?>" <?php echo $TAttrs . $onblur; ?>
                                                                                               placeholder="To"/>
                                                                                        <div class="input-group-append">
                                                                                    <span class="input-group-text">
                                                                                        <i class="fa fa-percent"
                                                                                           style="font-size: 12px;"></i>
                                                                                    </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-1 column">
                                                                                    <div class="form-group">
                                                                                        <input maxlength="10"
                                                                                               onkeypress="allowNumberAndPoint(event)"
                                                                                               id="amount_from<?php echo $i; ?>"
                                                                                               value="<?php echo $result_gpd->amount_from; ?>" <?php echo $TAttrs . $onblur; ?>
                                                                                               placeholder="From"/>
                                                                                        <!--<div class="input-group-append">
                                                                                    <span class="input-group-text">
                                                                                        <i class="fab fa-neos"></i>
                                                                                    </span>
                                                                                        </div>-->
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-1 column">
                                                                                    <div class="form-group">
                                                                                        <input maxlength="10"
                                                                                               onkeypress="allowNumberAndPoint(event)"
                                                                                               id="amount_to<?php echo $i; ?>"
                                                                                               value="<?php echo $result_gpd->amount_to; ?>" <?php echo $TAttrs . $onblur; ?>
                                                                                               placeholder="To"/>
                                                                                        <!--<div class="input-group-append">
                                                                                    <span class="input-group-text">
                                                                                        <i class="fab fa-neos"></i>
                                                                                    </span>
                                                                                        </div>-->
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3 column">
                                                                                    <div class="form-group">
                                                                                <textarea rows="1"
                                                                                          id="gp_action<?php echo $i; ?>" <?php echo $TAttrs . $onblur; ?> placeholder="Action"><?php echo $result_gpd->gp_action; ?></textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <?php
                                                                            $i++;
                                                                        }
                                                                    }
                                                                }
                                                                for ($i; $i <= 1; $i++) {
                                                                    ?>
                                                                    <div class="row">
                                                                        <div class="col-md-1 column">
                                                                            <div class="form-group text-center mt-3">
                                                                                <label class="checkbox checkbox-outline checkbox-success d-inline-block">
                                                                                    <input type="checkbox"
                                                                                           class="lineRepresentativeBox"
                                                                                           value="<?php echo $i; ?>"
                                                                                           name="lineRepresentativeBox[]"
                                                                                           id="lineRepresentativeBox<?php echo $i; ?>"/>
                                                                                    <b class="float-left mr-2"><?php echo $i; ?>
                                                                                        . </b>
                                                                                    <span class="float-left"></span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2 column">
                                                                            <div class="form-group">
                                                                                <input maxlength="50"
                                                                                       id="gp_name<?php echo $i; ?>"
                                                                                       value="" <?php echo $TAttrs . $onblur; ?>
                                                                                       placeholder="Title"/>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2 column">
                                                                            <div class="input-group">
                                                                                <input maxlength="6"
                                                                                       onkeypress="allowNumberAndPointLess(event)"
                                                                                       id="percentage_from<?php echo $i; ?>"
                                                                                       value="0" <?php echo $TAttrs . $onblur; ?>
                                                                                       placeholder="From"/>
                                                                                <div class="input-group-append">
                                                                                    <span class="input-group-text">
                                                                                        <!--<i class="icon-2x text-dark-50 flaticon2-percentage"></i>-->
                                                                                        <i class="fa fa-percent"
                                                                                           style="font-size: 12px;"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2 column">
                                                                            <div class="input-group">
                                                                                <input maxlength="6"
                                                                                       onkeypress="allowNumberAndPointLess(event)"
                                                                                       id="percentage_to<?php echo $i; ?>"
                                                                                       value="0" <?php echo $TAttrs . $onblur; ?>
                                                                                       placeholder="To"/>
                                                                                <div class="input-group-append">
                                                                                    <span class="input-group-text">
                                                                                        <!--<i class="icon-2x text-dark-50 flaticon2-percentage"></i>-->
                                                                                        <i class="fa fa-percent"
                                                                                           style="font-size: 12px;"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-1 column">
                                                                            <div class="form-group">
                                                                                <input maxlength="10"
                                                                                       onkeypress="allowNumberAndPoint(event)"
                                                                                       id="amount_from<?php echo $i; ?>"
                                                                                       value="0" <?php echo $TAttrs . $onblur; ?>
                                                                                       placeholder="From"/>
                                                                                <!--<div class="input-group-append">
                                                                                    <span class="input-group-text">
                                                                                        <i class="fab fa-neos"></i>
                                                                                    </span>
                                                                                </div>-->
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-1 column">
                                                                            <div class="form-group">
                                                                                <input maxlength="10"
                                                                                       onkeypress="allowNumberAndPoint(event)"
                                                                                       id="amount_to<?php echo $i; ?>"
                                                                                       value="0" <?php echo $TAttrs . $onblur; ?>
                                                                                       placeholder="To"/>
                                                                                <!--<div class="input-group-append">
                                                                                    <span class="input-group-text">
                                                                                        <i class="fab fa-neos"></i>
                                                                                    </span>
                                                                                </div>-->
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3 column">
                                                                            <div class="form-group">
                                                                                <textarea rows="1"
                                                                                          id="gp_action<?php echo $i; ?>" <?php echo $TAttrs . $onblur; ?> placeholder="Action"></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </div>
                                                            <input type="hidden" name="r_rows" id="r_rows"
                                                                   value="<?php echo --$i; ?>">
                                                            <button type="button" class="btn btn-success float-right"
                                                                    onclick="addNewRow()"><?php echo config('lang.button.title.add'); ?>
                                                            </button>
                                                        </div>
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
    <script>

        function saveFORM() {
            var validDescription = /[^a-zA-Z0-9+-._,@&#/' ]/;
            var id = document.getElementById('id');
            var A = '<?php echo hasRight($user_right_title, 'add') ?>';
            var E = '<?php echo hasRight($user_right_title, 'edit') ?>';

            var evaluation_type_id = document.getElementById('evaluation_type_id');

            var department_id = document.getElementById('department_id');
            var select2_department_id_container = document.querySelector("[aria-labelledby='select2-department_id-container']");

            var salary_grade_id = document.getElementById('salary_grade_id');
            var select2_salary_grade_id_container = document.querySelector("[aria-labelledby='select2-salary_grade_id-container']");

            var errorMessageEvaluationType = document.getElementById('errorMessageEvaluationType');
            var errorMessageDepartment = document.getElementById('errorMessageDepartment');
            var errorMessageSalaryGradeId = document.getElementById('errorMessageSalaryGradeId');
            var responseMessageWrapper = document.getElementById('responseMessageWrapper');
            var responseMessage = document.getElementById('responseMessage');

            evaluation_type_id.style.borderColor = select2_department_id_container.style.borderColor = select2_salary_grade_id_container.style.borderColor = '#E4E6EF';
            errorMessageEvaluationType.innerText = errorMessageDepartment.innerText = errorMessageSalaryGradeId.innerText = responseMessage.innerText = '';
            responseMessageWrapper.style.display = "none";

            var checkedValue = null;
            var continueProcessing = false;
            var data = [];
            var message = 'Please checked at least one Grading Policy.';
            var inputElements = document.getElementsByClassName('lineRepresentativeBox');


            if (id.value == 0 && A == '') {
                toasterTrigger('warning', 'Sorry! You have no right to add record.');
            } else if (id.value > 0 && E == '') {
                toasterTrigger('warning', 'Sorry! You have no right to update record.');
            } else if (evaluation_type_id.value == '') {
                evaluation_type_id.style.borderColor = '#F00';
                errorMessageEvaluationType.innerText = "Evaluation Type field is required.";
                return false;
            } else if (isNaN(evaluation_type_id.value) === true || evaluation_type_id.value.length > 10) {
                evaluation_type_id.style.borderColor = '#F00';
                errorMessageEvaluationType.innerText = "Please select a valid option.";
                return false;
            } else if (evaluation_type_id.value < 1) {
                evaluation_type_id.style.borderColor = '#F00';
                errorMessageEvaluationType.innerText = "Evaluation Type field is required.";
                return false;
            } else if (department_id.value == '') {
                select2_department_id_container.style.borderColor = '#F00';
                errorMessageDepartment.innerText = "Department field is required.";
                return false;
            } else if (department_id.value != '' && (isNaN(department_id.value) === true || department_id.value.length > 10)) {
                select2_department_id_container.style.borderColor = '#F00';
                errorMessageDepartment.innerText = "Please select a valid option.";
                return false;
            } else if (salary_grade_id.value == '') {
                select2_salary_grade_id_container.style.borderColor = '#F00';
                errorMessageSalaryGradeId.innerText = "Salary Band field is required.";
                return false;
            } else if (salary_grade_id.value < 1 || isNaN(salary_grade_id.value) === true || salary_grade_id.value.length > 10) {
                select2_salary_grade_id_container.style.borderColor = '#F00';
                errorMessageSalaryGradeId.innerText = "Please select a valid option.";
                return false;
            } else {
                for (var i = 0; inputElements[i]; ++i) {
                    if (inputElements[i].checked) {
                        checkedValue = inputElements[i].value;
                        var gp_name = document.getElementById('gp_name' + checkedValue);
                        var percentage_from = document.getElementById('percentage_from' + checkedValue);
                        var percentage_to = document.getElementById('percentage_to' + checkedValue);
                        var amount_from = document.getElementById('amount_from' + checkedValue);
                        var amount_to = document.getElementById('amount_to' + checkedValue);
                        var gp_action = document.getElementById('gp_action' + checkedValue);
                        var prev_id = parseInt(checkedValue) - 1;

                        if (gp_name.value == '') {
                            gp_name.style.borderColor = '#F00';
                            message = 'Title field is required, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (gp_name.value.length > 50) {
                            gp_name.style.borderColor = '#F00';
                            message = 'Title field should not exceed 50 letters, At line no ' + checkedValue;
                            continueProcessing = false;
                        } else if (validDescription.test(gp_name.value)) {
                            gp_name.style.borderColor = '#F00';
                            message = 'Special Characters are not Allowed in Title field, At line no ' + checkedValue;
                            continueProcessing = false;
                        } else if (percentage_from.value == '' || percentage_from.value == 0) {
                            percentage_from.style.borderColor = '#F00';
                            message = 'Percentage From field is required, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (isNaN(percentage_from.value) === true) {
                            percentage_from.style.borderColor = '#F00';
                            message = 'Percentage From field should contain only numeric characters, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (percentage_from.value > 100) {
                            percentage_from.style.borderColor = '#F00';
                            message = 'Percentage From should not exceed 100%, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (checkedValue > 1 && prev_id > 0 && (Number(document.getElementById('percentage_to' + prev_id).value) >= Number(percentage_from.value))) {
                            percentage_from.style.borderColor = '#F00';
                            message = 'Please put correct value, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (percentage_to.value == '' || percentage_to.value == 0) {
                            percentage_to.style.borderColor = '#F00';
                            message = 'Percentage To field is required, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (isNaN(percentage_to.value) === true) {
                            percentage_to.style.borderColor = '#F00';
                            message = 'Percentage To field should contain only numeric characters, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (percentage_to.value > 100) {
                            percentage_to.style.borderColor = '#F00';
                            message = 'Percentage To should not exceed 100%, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (parseInt(percentage_to.value) < parseInt(percentage_from.value)) {
                            percentage_to.style.borderColor = '#F00';
                            message = '"Percentage To" should not less-than "Percentage From", At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (amount_from.value != '' && isNaN(amount_from.value) === true) {
                            amount_from.style.borderColor = '#F00';
                            message = 'Amount From field should contain only numeric characters, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (amount_from.value != '' && amount_from.value.length > 10) {
                            amount_from.style.borderColor = '#F00';
                            message = 'Amount From field should not exceed 10 digits, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (amount_to.value != '' && isNaN(amount_to.value) === true) {
                            amount_to.style.borderColor = '#F00';
                            message = 'Amount To field should contain only numeric characters, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (amount_to.value != '' && amount_to.value.length > 10) {
                            amount_to.style.borderColor = '#F00';
                            message = 'Amount To field should not exceed 10 digits, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (amount_to.value != '' && amount_to.value > 0 && (amount_from.value == '' || amount_from.value == 0)) {
                            amount_from.style.borderColor = '#F00';
                            message = 'Amount From field is required, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (amount_from.value != '' && amount_from.value > 0 && (amount_to.value == '' || amount_to.value == 0)) {
                            amount_to.style.borderColor = '#F00';
                            message = 'Amount To field is required, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (amount_from.value != '' && amount_to.value != '' && (Math.round(amount_to.value) < Math.round(amount_from.value))) {
                            amount_to.style.borderColor = '#F00';
                            message = '"Amount To" should not greater-than "Amount From", At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (amount_from.value == '' && amount_to.value == '' && gp_action.value == '' || (amount_from.value == 0 && amount_to.value == 0 && gp_action.value == '')) {
                            gp_action.style.borderColor = '#F00';
                            message = 'Action field is required, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (gp_action.value != '' && validDescription.test(gp_action.value)) {
                            gp_action.style.borderColor = '#F00';
                            message = 'Special Characters are not Allowed in Action field, At line no ' + checkedValue;
                            continueProcessing = false;
                        } else {
                            var obj = {};
                            obj = {
                                "gp_name": gp_name.value,
                                "percentage_from": percentage_from.value,
                                "percentage_to": percentage_to.value,
                                "amount_from": amount_from.value,
                                "amount_to": amount_to.value,
                                "gp_action": gp_action.value,
                            }
                            data.push(obj);
                            continueProcessing = true;
                        }
                    }
                }
                if (continueProcessing === false) {
                    responseMessageWrapper.style.display = "block";
                    responseMessage.innerText = message;
                    toasterTrigger('error', message);
                    return false;
                } else if (continueProcessing === true && data.length > 0) {
                    var postData = {
                        "id": id.value,
                        "evaluation_type_id": evaluation_type_id.value,
                        "department_id": department_id.value,
                        "salary_grade_id": salary_grade_id.value,
                        "user_right_title": '<?php echo $user_right_title; ?>',
                        "data": data
                    };
                    $.ajax({
                        type: "POST", url: "ajax/grading_policy.php",
                        data: {"postData": postData},
                        success: function (resPonse) {
                            if (resPonse !== undefined && resPonse != '') {
                                var obj = JSON.parse(resPonse);
                                if (obj.code === 200 || obj.code === 405 || obj.code === 422) {
                                    var title = '';
                                    if (obj.code === 422) {
                                        if (obj.errorField !== undefined && obj.errorField != '' && obj.errorDiv !== undefined && obj.errorDiv != '' && obj.errorMessage !== undefined && obj.errorMessage != '') {
                                            if (obj.errorField == 'salary_grade_id') {
                                                select2_salary_grade_id_container.style.borderColor = '#F00';
                                            } else if (obj.errorField == 'department_id') {
                                                select2_department_id_container.style.borderColor = '#F00';
                                            } else {
                                                document.getElementById(obj.errorField).style.borderColor = '#F00';
                                            }
                                            document.getElementById(obj.errorDiv).innerText = obj.errorMessage;
                                            loader(false);
                                            toasterTrigger('warning', obj.errorMessage);
                                        }
                                    } else if (obj.code === 405 || obj.code === 200) {
                                        if (obj.responseMessage !== undefined && obj.responseMessage != '') {
                                            if (obj.form_reset !== undefined && obj.form_reset) {
                                                document.getElementById("myFORM").reset();
                                                var select2_department_idContainer = document.getElementById("select2-department_id-container");
                                                var select2_salary_grade_idContainer = document.getElementById("select2-salary_grade_id-container");
                                                if (select2_department_idContainer) {
                                                    select2_department_idContainer.setAttribute("title", 'All');
                                                    select2_department_idContainer.innerHTML = '<span class="select2-selection__clear" title="Remove all items" data-select2-id="3">×</span>All';
                                                    department_id.value = "0";
                                                }
                                                if (select2_salary_grade_idContainer) {
                                                    select2_salary_grade_idContainer.removeAttribute("title");
                                                    select2_salary_grade_idContainer.innerHTML = '<span class="select2-selection__placeholder">Select</span>';
                                                    salary_grade_id.value = "";
                                                }
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
            }
        }

        function addNewRow() {
            var last_row_number = document.getElementById('r_rows');
            var r_rows = last_row_number.value;
            var objDiv = document.getElementById("Data_Holder_Child_Div");
            var innerHTml_c = '';
            r_rows++;
            innerHTml_c += '<div class="row">';
            innerHTml_c += '<div class="col-md-1 column"><div class="form-group text-center mt-3"><label class="checkbox checkbox-outline checkbox-success d-inline-block"><input type="checkbox" class="lineRepresentativeBox" value="' + r_rows + '" name="lineRepresentativeBox[]" id="lineRepresentativeBox' + r_rows + '" checked="checked"><b class="float-left mr-2">' + r_rows + '.</b><span class="float-left"></span></label></div></div>';
            innerHTml_c += '<div class="col-md-2 column"><div class="input-group"><input maxlength="50" id="gp_name' + r_rows + '" <?php echo $TAttrs . $onblur; ?> placeholder="Title"></div></div>';
            innerHTml_c += '<div class="col-md-2 column"><div class="input-group"><input maxlength="6" onkeypress="allowNumberAndPointLess(event)" id="percentage_from' + r_rows + '" value="0" <?php echo $TAttrs . $onblur; ?> placeholder="From"/><div class="input-group-append"><span class="input-group-text"><i class="fa fa-percent" style="font-size: 12px;"></i></span></div></div></div>';
            innerHTml_c += '<div class="col-md-2 column"><div class="input-group"><input maxlength="6" onkeypress="allowNumberAndPointLess(event)" id="percentage_to' + r_rows + '" value="0" <?php echo $TAttrs . $onblur; ?> placeholder="To"/><div class="input-group-append"><span class="input-group-text"><i class="fa fa-percent" style="font-size: 12px;"></i></span></div></div></div>';
            innerHTml_c += '<div class="col-md-1 column"><div class="form-group"><input maxlength="10" onkeypress="allowNumberAndPoint(event)" id="amount_from' + r_rows + '" value="0" <?php echo $TAttrs . $onblur; ?> placeholder="From"/></div></div>';
            innerHTml_c += '<div class="col-md-1 column"><div class="form-group"><input maxlength="10" onkeypress="allowNumberAndPoint(event)" id="amount_to' + r_rows + '" value="0" <?php echo $TAttrs . $onblur; ?> placeholder="To"/></div></div>';
            innerHTml_c += '<div class="col-md-3 column"><div class="form-group"><textarea rows="1" id="gp_action' + r_rows + '" <?php echo $TAttrs . $onblur; ?> placeholder="Action"></textarea></div></div>';
            innerHTml_c += '</div>';
            $("#Data_Holder_Child_Div").append(innerHTml_c);
            objDiv.scrollTop = objDiv.scrollHeight;
            last_row_number.value = r_rows;
        }

        function getRelatedSalaryBands(department_id) {
            var salary_grade_id = document.getElementById('salary_grade_id');
            salary_grade_id.innerHTML = '';

            loader(true);
            var postData = {
                "department_id": department_id
            };
            $.ajax({
                type: "POST", url: "ajax/common.php",
                data: {'postData': postData, 'getRelatedSalaryBands': true},
                success: function (resPonse) {
                    if (resPonse !== undefined && resPonse != '') {
                        var obj = JSON.parse(resPonse);
                        if (obj.code === 200) {
                            salary_grade_id.innerHTML = obj.data;
                            loader(false);
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
    </script>
<?php include_once("../includes/endTags.php"); ?>