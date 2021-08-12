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
                                                    echo 'Edit ' . ucwords(str_replace("_", " ", $page));
                                                    $id = htmlentities($_GET['id']);
                                                    $Q = "SELECT * FROM `designations` WHERE `id`='{$id}' AND `company_id`='{$global_company_id}' AND `branch_id`='{$global_branch_id}' AND `deleted_at` IS NULL";
                                                    $Qry = mysqli_query($db, $Q);
                                                    $Rows = mysqli_num_rows($Qry);
                                                    if ($Rows != 1) {
                                                        header('Location: ' . $page_not_found_url);
                                                        exit();
                                                    } else {
                                                        $Result = mysqli_fetch_object($Qry);
                                                        $name = html_entity_decode(stripslashes($Result->name));
                                                        $designation_id = html_entity_decode(stripslashes($Result->report_to_designation_id));
                                                        $department_id = html_entity_decode(stripslashes($Result->department_id));
                                                        $salary_grade_id = html_entity_decode(stripslashes($Result->salary_grade_id));
                                                        $salary_grade_detail_id = html_entity_decode(stripslashes($Result->salary_grade_detail_id));
                                                        $is_hod = html_entity_decode(stripslashes($Result->is_hod));
                                                        $sort_by = html_entity_decode(stripslashes($Result->sort_by));
                                                    }
                                                } else {
                                                    echo 'Add ' . ucwords(str_replace("_", " ", $page));
                                                    $id = $designation_id = $department_id = $salary_grade_id = $salary_grade_detail_id = $is_hod = 0;
                                                    $name = $sort_by = '';
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
                                                <div class="mb-3">
                                                    <div class="mb-2">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>* Name:</label>
                                                                            <input maxlength="50" id="name"
                                                                                   value="<?php echo $name; ?>" <?php echo $TAttrs . $onblur; ?>
                                                                                   placeholder="Name"/>
                                                                            <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageName"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>* Report to Designation:</label>
                                                                            <select id="designation_id" <?php echo $TAttrs; ?>>
                                                                                <option selected="selected" value="-1">
                                                                                    Select
                                                                                </option>
                                                                                <?php
                                                                                $select = "SELECT `id`,`name` FROM `designations` WHERE `company_id`='{$global_company_id}' AND `branch_id`='{$global_branch_id}' AND `deleted_at` IS NULL ORDER BY `sort_by`,`report_to_designation_id` ASC";
                                                                                $query = mysqli_query($db, $select);
                                                                                if (mysqli_num_rows($query) > 0) {
                                                                                    while ($result = mysqli_fetch_object($query)) {
                                                                                        $selected = '';
                                                                                        if ($designation_id == $result->id) {
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
                                                                              id="errorMessageDesignation"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>* Department:</label>
                                                                            <select id="department_id" <?php echo $TAttrs . $onblur; ?>> <!-- onchange="getRelatedSalaryBands(this.value)" -->
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
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>* Sort By:</label>
                                                                            <input maxlength="9"
                                                                                   onkeypress="allowNumberOnly(event)"
                                                                                   id="sort_by"
                                                                                   value="<?php echo $sort_by; ?>" <?php echo $TAttrs . $onblur; ?>
                                                                                   placeholder="Sort By"/>
                                                                            <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageSortBy"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!--<div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>* Salary Band:</label>
                                                                            <select id="salary_grade_id" <?php //echo $TAttrs . $onblur; ?>
                                                                                    onchange="getRelatedSalaryGrades(this.value)">
                                                                                <?php
                                                                                /*if (!empty($department_id)) {
                                                                                    echo getRelatedSalaryBands($department_id, $salary_grade_id, $global_company_id, $global_branch_id);
                                                                                } else {
                                                                                    echo '<option selected="selected" value="">Select
                                                                        </option>';
                                                                                }*/
                                                                                ?>
                                                                            </select>
                                                                            <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageSalaryGradeId"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>* Salary Grade:</label>
                                                                            <select id="salary_grade_detail_id" <?php //echo $TAttrs . $onblur; ?>>
                                                                                <?php
                                                                                /*if (!empty($department_id) && !empty($salary_grade_id)) {
                                                                                    echo getRelatedSalaryGrades($salary_grade_id, $salary_grade_detail_id);
                                                                                } else {
                                                                                    echo '<option selected="selected" value="">Select
                                                                        </option>';
                                                                                }*/
                                                                                ?>
                                                                            </select>
                                                                            <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageSalaryGradeDetailId"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>-->

                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="checkbox-inline">
                                                                            <label class="checkbox checkbox-outline checkbox-outline-2x checkbox-primary">
                                                                                <input type="checkbox"
                                                                                       name="is_hod"
                                                                                       id="is_hod"
                                                                                    <?php echo !empty($is_hod) ? 'checked="checked"' : ''; ?>
                                                                                ><!--checked="checked"-->
                                                                                <span></span>
                                                                                Department Head
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--<div class="separator separator-dashed my-10"></div>-->
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

            var checkValidName = /[^a-zA-Z0-9-.@_&' ]/;
            var id = document.getElementById('id');
            var name = document.getElementById('name');
            var designation_id = document.getElementById('designation_id');
            var select2_designation_id_container = document.querySelector("[aria-labelledby='select2-designation_id-container']");
            var department_id = document.getElementById('department_id');
            var select2_department_id_container = document.querySelector("[aria-labelledby='select2-department_id-container']");
            var sort_by = document.getElementById('sort_by');

            /*var salary_grade_id = document.getElementById('salary_grade_id');
            var select2_salary_grade_id_container = document.querySelector("[aria-labelledby='select2-salary_grade_id-container']");
            var salary_grade_detail_id = document.getElementById('salary_grade_detail_id');
            var select2_salary_grade_detail_id_container = document.querySelector("[aria-labelledby='select2-salary_grade_detail_id-container']");
            */

            var is_hod_check = document.getElementById("is_hod");
            var is_hod = is_hod_check.checked == true ? "1" : "0";

            var errorMessageName = document.getElementById('errorMessageName');
            var errorMessageDesignation = document.getElementById('errorMessageDesignation');
            var errorMessageDepartment = document.getElementById('errorMessageDepartment');
            var errorMessageSortBy = document.getElementById('errorMessageSortBy');
            /*var errorMessageSalaryGradeId = document.getElementById('errorMessageSalaryGradeId');
            var errorMessageSalaryGradeDetailId = document.getElementById('errorMessageSalaryGradeDetailId');*/


            name.style.borderColor = select2_designation_id_container.style.borderColor = select2_department_id_container.style.borderColor = sort_by.style.borderColor = '#E4E6EF';/*select2_salary_grade_id_container.style.borderColor = select2_salary_grade_detail_id_container.style.borderColor = */
            errorMessageName.innerText = errorMessageDesignation.innerText = errorMessageDepartment.innerText = errorMessageSortBy.innerText = "";/*errorMessageSalaryGradeId.innerText = errorMessageSalaryGradeDetailId.innerText = */

            if (name.value == '') {
                name.style.borderColor = '#F00';
                errorMessageName.innerText = "Name field is required.";
                return false;
            } else if (checkValidName.test(name.value)) {
                name.style.borderColor = '#F00';
                errorMessageName.innerText = "Special Characters are not Allowed.";
                return false;
            } else if (name.value.length > 50) {
                name.style.borderColor = '#F00';
                errorMessageName.innerText = "Length should not exceed 50 characters.";
                return false;
            } else if (designation_id.value == '') {
                select2_designation_id_container.style.borderColor = '#F00';
                errorMessageDesignation.innerText = "Report to Designation field is required.";
                return false;
            } else if (isNaN(designation_id.value) === true || designation_id.value.length > 10 || designation_id.value < 0) {
                select2_designation_id_container.style.borderColor = '#F00';
                errorMessageDesignation.innerText = "Please select a valid option.";
                return false;
            } else if (department_id.value == '') {
                select2_department_id_container.style.borderColor = '#F00';
                errorMessageDepartment.innerText = "Department field is required.";
                return false;
            } else if (isNaN(department_id.value) === true || department_id.value.length > 10 || department_id.value < 0) {
                select2_department_id_container.style.borderColor = '#F00';
                errorMessageDepartment.innerText = "Please select a valid option.";
                return false;
            } else if (sort_by.value == '') {
                sort_by.style.borderColor = '#F00';
                errorMessageSortBy.innerText = "Sort By field is required.";
                return false;
            } else if (isNaN(sort_by.value) === true) {
                sort_by.style.borderColor = '#F00';
                errorMessageSortBy.innerText = "Sort By field should contain only numeric.";
                return false;
            } else if (sort_by.value.length > 9) {
                sort_by.style.borderColor = '#F00';
                errorMessageSortBy.innerText = "Length should not exceed 9 digits.";
                return false;
            } /*else if (salary_grade_id.value == '') {
                select2_salary_grade_id_container.style.borderColor = '#F00';
                errorMessageSalaryGradeId.innerText = "Salary Band field is required.";
                return false;
            } else if (isNaN(salary_grade_id.value) === true || salary_grade_id.value.length > 10 || salary_grade_id.value < 0) {
                select2_salary_grade_id_container.style.borderColor = '#F00';
                errorMessageSalaryGradeId.innerText = "Please select a valid option.";
                return false;
            } else if (salary_grade_detail_id.value == '') {
                select2_salary_grade_detail_id_container.style.borderColor = '#F00';
                errorMessageSalaryGradeDetailId.innerText = "Salary Grade field is required.";
                return false;
            } else if (isNaN(salary_grade_detail_id.value) === true || salary_grade_detail_id.value.length > 10 || salary_grade_detail_id.value < 0) {
                select2_salary_grade_detail_id_container.style.borderColor = '#F00';
                errorMessageSalaryGradeDetailId.innerText = "Please select a valid option.";
                return false;
            }*/ else {
                loader(true);
                var postData = {
                    "id": id.value,
                    "name": name.value,
                    "designation_id": designation_id.value,
                    "department_id": department_id.value,
                    /*"salary_grade_id": salary_grade_id.value,
                    "salary_grade_detail_id": salary_grade_detail_id.value,*/
                    "sort_by": sort_by.value,
                    "is_hod": is_hod
                };
                $.ajax({
                    type: "POST", url: "ajax/designation.php",
                    data: {'postData': postData},
                    success: function (resPonse) {
                        if (resPonse !== undefined && resPonse != '') {
                            var obj = JSON.parse(resPonse);
                            if (obj.code === 200 || obj.code === 405 || obj.code === 422) {
                                var title = '';
                                if (obj.code === 422) {
                                    if (obj.errorField !== undefined && obj.errorField != '' && obj.errorDiv !== undefined && obj.errorDiv != '' && obj.errorMessage !== undefined && obj.errorMessage != '') {
                                        if (obj.errorField == 'designation_id') {
                                            select2_designation_id_container.style.borderColor = '#F00';
                                        } else if (obj.errorField == 'department_id') {
                                            select2_department_id_container.style.borderColor = '#F00';
                                        } else if (obj.errorField == 'salary_grade_id') {
                                            select2_salary_grade_id_container.style.borderColor = '#F00';
                                        } else if (obj.errorField == 'salary_grade_detail_id') {
                                            select2_salary_grade_detail_id_container.style.borderColor = '#F00';
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
                                            var select2_departmentId_container = document.getElementById("select2-department_id-container");
                                            var select2_designationId_container = document.getElementById("select2-designation_id-container");

                                            /*var select2_salary_gradeId_container = document.getElementById("select2-salary_grade_id-container");
                                            var select2_salary_grade_detailId_container = document.getElementById("select2-salary_grade_detail_id-container");*/

                                            if (select2_departmentId_container) {
                                                select2_departmentId_container.removeAttribute("title");
                                                select2_departmentId_container.innerHTML = '<span class="select2-selection__placeholder">Select</span>';
                                            }
                                            if (select2_designationId_container) {
                                                select2_designationId_container.removeAttribute("title");
                                                select2_designationId_container.innerHTML = '<span class="select2-selection__placeholder">Select</span>';
                                            }
                                            /*if (select2_salary_gradeId_container) {
                                                select2_salary_gradeId_container.removeAttribute("title");
                                                select2_salary_gradeId_container.innerHTML = '<span class="select2-selection__placeholder">Select</span>';
                                            }
                                            if (select2_salary_grade_detailId_container) {
                                                select2_salary_grade_detailId_container.removeAttribute("title");
                                                select2_salary_grade_detailId_container.innerHTML = '<span class="select2-selection__placeholder">Select</span>';
                                            }
                                             document.getElementById('salary_grade_id').innerHTML = document.getElementById('salary_grade_detail_id').innerHTML = '';*/
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

        function getRelatedSalaryGrades(id) {
            var salary_grade_detail_id = document.getElementById('salary_grade_detail_id');
            salary_grade_detail_id.innerHTML = '';
            loader(true);
            var postData = {
                "salary_grade_id": id
            };
            $.ajax({
                type: "POST", url: "ajax/common.php",
                data: {'postData': postData, 'getRelatedSalaryGrades': true},
                success: function (resPonse) {
                    if (resPonse !== undefined && resPonse != '') {
                        var obj = JSON.parse(resPonse);
                        if (obj.code === 200) {
                            salary_grade_detail_id.innerHTML = obj.data;
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