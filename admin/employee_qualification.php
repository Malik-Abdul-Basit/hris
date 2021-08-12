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
                                                echo ucwords(str_replace("_", " ", $page));
                                                $TAttrs = ' type="text" class="form-control" ';
                                                $NAttrs = ' type="number" class="form-control" ';
                                                //$DateInput = ' type="text" class="form-control DMY_dateOnly" maxlength="10" ';
                                                $DateInput = '  type="text" class="DatePicker e-input form-control" onkeypress="openCalendar(event)" onfocus="openCalendar(event)" onclick="openCalendar(event)" maxlength="10" data-format="dd-MM-yyyy" ';
                                                $disable = ' type="text" class="form-control form-control-solid" disabled readonly style="cursor: not-allowed" ';
                                                $onblur = ' onblur="change_color(this.value, this.id)" ';
                                                $emp_code = '';
                                                if (isset($_GET['emp_code']) && is_numeric($_GET['emp_code']) && !empty($_GET['emp_code'])) {
                                                    $emp_code = $_GET['emp_code'];
                                                }
                                                function getGrade()
                                                {
                                                    $d = '';
                                                    foreach (config('employee_qualification_infos.grade.title') as $key => $value) {
                                                        $d .= '<option value="' . $key . '">' . $value . '</option>';
                                                    }
                                                    return $d;
                                                }

                                                function getStatus()
                                                {
                                                    $d = '';
                                                    foreach (config('employee_qualification_infos.status.title') as $key => $value) {
                                                        $d .= '<option value="' . $key . '">' . $value . '</option>';
                                                    }
                                                    return $d;
                                                }

                                                ?>
                                            </h3>
                                        </div>
                                        <!--begin::Form-->
                                        <form class="form" id="myFORM" name="myFORM" method="post"
                                              enctype="multipart/form-data">
                                            <div class="card-body">
                                                <div class="alert alert-custom alert-light-danger overflow-hidden"
                                                     role="alert" id="responseMessageWrapper">
                                                    <div class="alert-text font-weight-bold float-left"
                                                         id="responseMessage"></div>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="mb-2">
                                                        <div class="row">
                                                            <div class="col-md-8">
                                                                <h3 class="font-size-lg text-dark-75 font-weight-bold mb-10">
                                                                    Employee Information:</h3>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>* Employee Code:</label>
                                                                            <input maxlength="20" id="employee_code"
                                                                                   onkeypress="runScript(event)"
                                                                                   onchange="getEmployee(this.value)"
                                                                                   value="<?php echo $emp_code; ?>" <?php echo $TAttrs . $onblur; ?>
                                                                                   placeholder="Employee Code"/>
                                                                            <div class="error_wrapper">
                                                                                <span class="text-danger"
                                                                                      id="errorMessageEmployeeCode"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Employee Email:</label>
                                                                            <input id="emp_email"
                                                                                   value="" <?php echo $disable; ?>
                                                                                   placeholder="Employee Email"/>
                                                                            <div class="error_wrapper">
                                                                                <span class="text-danger"
                                                                                      id="errorMessageEmployeeEmail"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Full Name:</label>
                                                                            <input id="full_name"
                                                                                   value="" <?php echo $disable; ?>
                                                                                   placeholder="Employee Full Name"/>
                                                                            <div class="error_wrapper">
                                                                                <span class="text-danger"
                                                                                      id="errorMessageFullName"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Pseudo Name:</label>
                                                                            <input id="emp_pseudo_name"
                                                                                   value="" <?php echo $disable; ?>
                                                                                   placeholder="Pseudo Name"/>
                                                                            <div class="error_wrapper">
                                                                                <span class="text-danger"
                                                                                      id="errorMessageEmployeePseudoName"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="employee_image_wrapper"
                                                                     id="employee_image_wrapper"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="separator separator-dashed my-10"></div>

                                                <div class="mb-3">
                                                    <h3 class="font-size-lg text-dark-75 font-weight-bold mb-10">
                                                        Qualification Information:</h3>
                                                    <div class="mb-2">

                                                        <div id="Data_Holder_Parent_Div">
                                                            <div class="row">
                                                                <div class="col-md-1 column text-center"><b>Sr.</b>
                                                                </div>
                                                                <div class="col-md-2 column"><b>* Degree</b></div>
                                                                <div class="col-md-2 column"><b>* Institute</b></div>
                                                                <div class="col-md-3 column"><b>* Year of Completion</b>
                                                                </div>
                                                                <!--<div class="col-md-2 column"><b>Total Marks</b></div>
                                                                <div class="col-md-2 column"><b>Obtaining Marks</b>
                                                                </div>-->
                                                                <div class="col-md-2 column"><b>Grade</b></div>
                                                                <div class="col-md-2 column"><b>* Status</b></div>
                                                            </div>

                                                            <div id="Data_Holder_Child_Div" style="max-height: 100%"
                                                                 class="mt-7 mb-7">
                                                                <?php
                                                                for ($i = 1; $i <= 1; $i++) {
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
                                                                                       id="degree<?php echo $i; ?>"
                                                                                       value="" <?php echo $TAttrs . $onblur; ?>
                                                                                       placeholder="Degree"/>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2 column">
                                                                            <div class="form-group">
                                                                                <input maxlength="70"
                                                                                       id="institute<?php echo $i; ?>"
                                                                                       value="" <?php echo $TAttrs . $onblur; ?>
                                                                                       placeholder="Institute"/>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3 column">
                                                                            <div class="form-group">
                                                                                <input maxlength="4" <?php echo $TAttrs . $onblur; ?>
                                                                                       id="date_of_completion<?php echo $i; ?>"
                                                                                       onkeypress="allowNumberOnly(event)"
                                                                                       placeholder="Year Of Completion"
                                                                                       min="<?php echo round(date('Y') - (60)); ?>"
                                                                                       max="<?php echo date('Y'); ?>">
                                                                            </div>
                                                                        </div>
                                                                        <!--<div class="col-md-2 column">
                                                                            <div class="form-group">-->
                                                                        <input type="hidden" class="not-display"
                                                                               maxlength="5"
                                                                               onkeypress="allowNumberAndPoint(event)"
                                                                               id="total_marks<?php echo $i; ?>"
                                                                               value="0"
                                                                               placeholder="Total Marks"/>
                                                                        <!--</div>
                                                                    </div>
                                                                    <div class="col-md-2 column">
                                                                        <div class="form-group">-->
                                                                        <input type="hidden" class="not-display"
                                                                               maxlength="5"
                                                                               onkeypress="allowNumberAndPoint(event)"
                                                                               id="obtaining_marks<?php echo $i; ?>"
                                                                               value="0"
                                                                               placeholder="Obtaining Marks"/>
                                                                        <!--</div>
                                                                    </div>-->
                                                                        <div class="col-md-2 column">
                                                                            <div class="form-group">
                                                                                <select id="grade<?php echo $i; ?>" <?php echo $TAttrs . $onblur; ?>>
                                                                                    <option selected="selected"
                                                                                            value=""></option>
                                                                                    <?php echo getGrade(); ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2 column">
                                                                            <div class="form-group">
                                                                                <select id="status<?php echo $i; ?>" <?php echo $TAttrs . $onblur; ?>>
                                                                                    <?php echo getStatus(); ?>
                                                                                </select>
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

            var validName = /[^a-zA-Z0-9-.@_&' ]/;
            var validDate = /^(0[1-9]|1\d|2\d|3[01])\-(0[1-9]|1[0-2])\-(19|20)\d{2}$/;
            var gradeArray =  [<?php echo '"'.implode('","', array_values(config('employee_qualification_infos.grade.value'))).'"' ?>];
            var statusArray =  [<?php echo '"'.implode('","', array_values(config('employee_qualification_infos.status.value'))).'"' ?>];

            var employee_code = document.getElementById('employee_code');

            var errorMessageEmployeeCode = document.getElementById('errorMessageEmployeeCode');
            var responseMessageWrapper = document.getElementById('responseMessageWrapper');
            var responseMessage = document.getElementById('responseMessage');

            employee_code.style.borderColor = '#E4E6EF';
            errorMessageEmployeeCode.innerText = responseMessage.innerText = '';
            responseMessageWrapper.style.display = "none";

            var checkedValue = null;
            var continueProcessing = false;
            var data = [];
            var message = 'Please provide at least one qualification information.';
            var inputElements = document.getElementsByClassName('lineRepresentativeBox');

            if (employee_code.value == '') {
                employee_code.style.borderColor = '#F00';
                errorMessageEmployeeCode.innerText = "Employee Code field is required.";
                return false;
            } else if (isNaN(employee_code.value) === true || employee_code.value < 1 || employee_code.value.length > 20) {
                employee_code.style.borderColor = '#F00';
                errorMessageEmployeeCode.innerText = "Invalid Employee Code.";
                return false;
            } else {
                for (var i = 0; inputElements[i]; ++i) {
                    if (inputElements[i].checked) {
                        checkedValue = inputElements[i].value;
                        var degree = document.getElementById('degree' + checkedValue);
                        var institute = document.getElementById('institute' + checkedValue);
                        var date_of_completion = document.getElementById('date_of_completion' + checkedValue);
                        var total_marks = document.getElementById('total_marks' + checkedValue);
                        var obtaining_marks = document.getElementById('obtaining_marks' + checkedValue);
                        var grade = document.getElementById('grade' + checkedValue);
                        var status = document.getElementById('status' + checkedValue);
                        if (degree.value == '') {
                            degree.style.borderColor = '#F00';
                            message = 'Degree field is required, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (validName.test(degree.value)) {
                            degree.style.borderColor = '#F00';
                            message = 'Special Characters are not Allowed in Degree field, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (institute.value == '') {
                            institute.style.borderColor = '#F00';
                            message = 'Institute field is required, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (validName.test(institute.value)) {
                            institute.style.borderColor = '#F00';
                            message = 'Special Characters are not Allowed in Institute field, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (institute.value.length > 70) {
                            institute.style.borderColor = '#F00';
                            message = 'Length should not exceed 70 characters, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (date_of_completion.value == '') {
                            date_of_completion.style.borderColor = '#F00';
                            message = 'Year of Completion field is required, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        }
                        /*else if (!(validDate.test(date_of_completion.value)) || date_of_completion.value.length !== 10) {
                            date_of_completion.style.borderColor = '#F00';
                            message = 'Please select a valid date, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (total_marks.value == '') {
                            total_marks.style.borderColor = '#F00';
                            message = 'Total Marks field is required, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        }*/ else if (total_marks.value != '' && (isNaN(total_marks.value) === true || total_marks.value.length > 5)) {
                            total_marks.style.borderColor = '#F00';
                            message = 'Please type valid Total Marks, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (obtaining_marks.value != '' && isNaN(obtaining_marks.value) === false && obtaining_marks.value > 0 && total_marks.value == '') {
                            total_marks.style.borderColor = '#F00';
                            message = 'Total Marks field is required, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } /*else if (obtaining_marks.value == '') {
                            obtaining_marks.style.borderColor = '#F00';
                            message = 'Obtaining Marks field is required, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        }*/ else if (obtaining_marks.value != '' && (isNaN(obtaining_marks.value) === true || obtaining_marks.value.length > 5)) {
                            obtaining_marks.style.borderColor = '#F00';
                            message = 'Please type valid Obtaining Marks, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (total_marks.value != '' && isNaN(total_marks.value) === false && total_marks.value > 0 && obtaining_marks.value == '') {
                            obtaining_marks.style.borderColor = '#F00';
                            message = 'Obtaining Marks field is required, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (Math.round(obtaining_marks.value) > Math.round(total_marks.value)) {
                            obtaining_marks.style.borderColor = '#F00';
                            message = "Obtaining Marks shouldn't be greater than Total Marks, At line no " + checkedValue;
                            continueProcessing = false;
                            break;
                        } /*else if (grade.value == '') {
                            grade.style.borderColor = '#F00';
                            message = 'Grade field is required, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        }*/ else if (grade.value != '' && (gradeArray.includes(grade.value) == false || grade.value.length > 2)) {
                            grade.style.borderColor = '#F00';
                            message = 'Please select a valid Grade, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (status.value == '') {
                            status.style.borderColor = '#F00';
                            message = 'Status field is required, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (statusArray.includes(status.value) == false || status.value.length !== 1) {
                            status.style.borderColor = '#F00';
                            message = 'Please select a valid Status, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else {
                            var obj = {};
                            obj = {
                                "degree": degree.value,
                                "institute": institute.value,
                                "date_of_completion": date_of_completion.value,
                                "total_marks": total_marks.value,
                                "obtaining_marks": obtaining_marks.value,
                                "grade": grade.value,
                                "status": status.value
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
                    loader(true);
                    var postData = {
                        "employee_code": employee_code.value,
                        "user_right_title": '<?php echo $user_right_title; ?>',
                        "data": data
                    };
                    $.ajax({
                        type: "POST", url: "ajax/employee_qualification.php",
                        data: {"postData": postData},
                        success: function (resPonse) {
                            if (resPonse !== undefined && resPonse != '') {
                                var obj = JSON.parse(resPonse);
                                if (obj.code === 200 || obj.code === 405 || obj.code === 422) {
                                    var title = '';
                                    if (obj.code === 422) {
                                        if (obj.errorField !== undefined && obj.errorField != '' && obj.errorDiv !== undefined && obj.errorDiv != '' && obj.errorMessage !== undefined && obj.errorMessage != '') {
                                            document.getElementById(obj.errorField).style.borderColor = '#F00';
                                            document.getElementById(obj.errorDiv).innerText = obj.errorMessage;
                                            loader(false);
                                            toasterTrigger('warning', obj.errorMessage);
                                        }
                                    } else if (obj.code === 405 || obj.code === 200) {
                                        if (obj.responseMessage !== undefined && obj.responseMessage != '') {
                                            if (obj.code === 200 && obj.employee_id !== undefined && obj.employee_id != '' && isNaN(obj.employee_id) === false && obj.employee_id > 0) {
                                                var redirect = <?php echo isset($_GET['emp_code']) && is_numeric($_GET['emp_code']) && !empty($_GET['emp_code']) ? '"' . $admin_url . 'qualification_overview?emp_id="' : '""'; ?>;
                                                if (redirect != '') {
                                                    window.location = redirect + obj.employee_id;
                                                }
                                            }

                                            if (obj.form_reset !== undefined && obj.form_reset) {
                                                document.getElementById("myFORM").reset();
                                            }
                                            loader(false);
                                            toasterTrigger(obj.toasterClass, obj.responseMessage);
                                        } else {
                                            loader(false);
                                        }
                                    } else {
                                        loader(false);
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

        function getEmployee(code) {
            loader(true);
            var employee_code = document.getElementById('employee_code');
            var emp_email = document.getElementById('emp_email');
            var full_name = document.getElementById('full_name');
            var emp_pseudo_name = document.getElementById('emp_pseudo_name');

            var errorMessageEmployeeCode = document.getElementById('errorMessageEmployeeCode');
            var employeeImageWrapper = document.getElementById('employee_image_wrapper');
            var responseMessageWrapper = document.getElementById('responseMessageWrapper');
            var responseMessage = document.getElementById('responseMessage');

            emp_email.value = full_name.value = emp_pseudo_name.value = errorMessageEmployeeCode.innerText = employeeImageWrapper.innerHTML = responseMessage.innerText = '';
            responseMessageWrapper.style.display = "none";

            var postData = {"code": code};
            $.ajax({
                type: "POST", url: "ajax/common.php",
                data: {'postData': postData, 'getEmployee': true, "R": "employee_qualification"},
                success: function (resPonse) {
                    if (resPonse !== undefined && resPonse != '') {
                        var obj = JSON.parse(resPonse);
                        if (obj.code !== undefined && obj.code != '') {
                            if (obj.code === 405 && obj.hasRight === false) {
                                loader(false);
                                toasterTrigger('warning', 'Sorry! You have no right to perform this action.');
                            } else if (obj.code === 200 && obj.employee_info !== undefined && obj.employee_info != '' && obj.hasRight === true) {
                                var employee_info = obj.employee_info;
                                emp_email.value = employee_info.email;
                                full_name.value = employee_info.full_name;
                                emp_pseudo_name.value = employee_info.pseudo_name;
                                employeeImageWrapper.innerHTML = '<div class="employee_image_portion"><img src="' + employee_info.image + '" alt="' + code + '"></div>';
                                getEmployeeQualification(employee_info.id);
                            } else if (obj.code === 404) {
                                if (obj.responseMessage !== undefined && obj.responseMessage != '') {
                                    responseMessageWrapper.style.display = "block";
                                    responseMessage.innerText = errorMessageEmployeeCode.innerText = obj.responseMessage;
                                    employee_code.style.borderColor = '#F00';
                                    loader(false);
                                }
                            } else {
                                loader(false);
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

        function getEmployeeQualification(id) {
            var postData = {"id": id};
            $.ajax({
                type: "POST", url: "ajax/common.php",
                data: {'postData': postData, 'getEmployeeQualification': true},
                success: function (resPonse) {
                    if (resPonse !== undefined && resPonse != '') {
                        var obj = JSON.parse(resPonse);
                        if (obj.code !== undefined && obj.code != '') {
                            if (obj.code === 200 && obj.data !== undefined) {
                                document.getElementById('Data_Holder_Child_Div').innerHTML = obj.data;
                                document.getElementById('r_rows').value = obj.last_row;
                                loader(false);
                            } else {
                                loader(false);
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

        function runScript(e) {
            if (e.keyCode == 13 || isNaN(e.key) === false) {
                if (e.keyCode == 13) {
                    if (e.target.value !== undefined && e.target.value != '') {
                        getEmployee(e.target.value);
                    }
                }
            } else {
                e.preventDefault();
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
            innerHTml_c += '<div class="col-md-2 column"><div class="form-group"><input maxlength="50" id="degree' + r_rows + '" value="" <?php echo $TAttrs . $onblur; ?> placeholder="Degree"/></div></div>';
            innerHTml_c += '<div class="col-md-2 column"><div class="form-group"><input maxlength="50" id="institute' + r_rows + '" value="" <?php echo $TAttrs . $onblur; ?> placeholder="Institute"/></div></div>';
            innerHTml_c += '<div class="col-md-3 column"><div class="form-group">';
            innerHTml_c += '<input maxlength="4" <?php echo $TAttrs . $onblur; ?> id="date_of_completion' + r_rows + '" onkeypress="allowNumberOnly(event)" value="" min="<?php echo round(date('Y') - (60)); ?>"  max="<?php echo date('Y'); ?>" placeholder="Year Of Completion"/>';
            innerHTml_c += '</div></div>';
            //innerHTml_c += '<div class="col-md-2 column"><div class="form-group"><input maxlength="5" onkeypress="allowNumberAndPoint(event)" id="total_marks' + r_rows + '" value="0" <?php //echo $TAttrs . $onblur; ?> placeholder="Total Marks"/></div></div>';
            //innerHTml_c += '<div class="col-md-2 column"><div class="form-group"><input maxlength="5" onkeypress="allowNumberAndPoint(event)" id="obtaining_marks' + r_rows + '" value="0" <?php //echo $TAttrs . $onblur; ?> placeholder="Obtaining Marks"/></div></div>';
            innerHTml_c += '<input type="hidden" class="not-display" maxlength="5" onkeypress="allowNumberAndPoint(event)" id="total_marks' + r_rows + '" value="0" placeholder="Total Marks"/>';
            innerHTml_c += '<input type="hidden" class="not-display" maxlength="5" onkeypress="allowNumberAndPoint(event)" id="obtaining_marks' + r_rows + '" value="0" placeholder="Obtaining Marks"/>';
            innerHTml_c += '<div class="col-md-2 column"><div class="form-group"><select id="grade' + r_rows + '" <?php echo $TAttrs . $onblur; ?>><option selected="selected" value=""></option><?php echo getGrade(); ?></select></div></div>';
            innerHTml_c += '<div class="col-md-2 column"><div class="form-group"><select id="status' + r_rows + '" <?php echo $TAttrs . $onblur; ?>><?php echo getStatus(); ?></select></div></div>';
            innerHTml_c += '</div>';
            $("#Data_Holder_Child_Div").append(innerHTml_c);
            objDiv.scrollTop = objDiv.scrollHeight;
            last_row_number.value = r_rows;
            //appendScript('wrapper_date_of_completion'+r_rows, 'date_of_completion'+r_rows);
        }

        function appendScript(parent, id) {
            var parent_div = document.getElementById(parent);
            var script = document.createElement('script');
            script.type = 'text/javascript';
            script.onload = function () {
                callFunctionFromScript();
            }
            script.text = '$("#' + id + '").dateTimePicker({format: "dd-MM-yyyy"});';
            parent_div.appendChild(script);
        }

        <?php
        if (isset($_GET['emp_code']) && is_numeric($_GET['emp_code']) && !empty($_GET['emp_code'])) {
            echo 'getEmployee(' . $_GET['emp_code'] . ')';
        }
        ?>

    </script>
<?php include_once("../includes/endTags.php"); ?>