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
                                                //$DateInput = ' type="text" class="form-control DMY_dateOnly" maxlength="10" ';
                                                $DateInput = '  type="text" class="DatePicker e-input form-control" onkeypress="openCalendar(event)" onfocus="openCalendar(event)" onclick="openCalendar(event)" maxlength="10" data-format="dd-MM-yyyy" ';
                                                $disable = ' type="text" class="form-control form-control-solid" disabled readonly style="cursor: not-allowed" ';
                                                $onblur = ' onblur="change_color(this.value, this.id)" ';
                                                $emp_code = '';
                                                if (isset($_GET['emp_code']) && is_numeric($_GET['emp_code']) && !empty($_GET['emp_code'])) {
                                                    $emp_code = $_GET['emp_code'];
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
                                                        Previous Experience Information:</h3>
                                                    <div class="mb-2">

                                                        <div id="Data_Holder_Parent_Div">
                                                            <div class="row">
                                                                <div class="col-md-1 column text-center"><b>Sr.</b>
                                                                </div>
                                                                <div class="col-md-2 column"><b>* Company Name</b></div>
                                                                <div class="col-md-2 column"><b>* Designation</b></div>
                                                                <div class="col-md-2 column"><b>* Date of Joining</b>
                                                                </div>
                                                                <div class="col-md-2 column"><b>* Date of Leaving </b>
                                                                </div>
                                                                <div class="col-md-3 column"><b>* Reason of Leaving </b>
                                                                </div>
                                                            </div>

                                                            <div id="Data_Holder_Child_Div" style="max-height: 100%" class="mt-7 mb-7">
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
                                                                                       id="company_name<?php echo $i; ?>"
                                                                                       value="" <?php echo $TAttrs . $onblur; ?>
                                                                                       placeholder="Company Name"/>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2 column">
                                                                            <div class="form-group">
                                                                                <input maxlength="50"
                                                                                       id="designation<?php echo $i; ?>"
                                                                                       value="" <?php echo $TAttrs . $onblur; ?>
                                                                                       placeholder="Designation"/>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2 column">
                                                                            <div class="form-group">
                                                                                <input <?php echo $DateInput . $onblur; ?>
                                                                                        id="date_of_joining<?php echo $i; ?>"
                                                                                        value=""
                                                                                        placeholder="Date Of Joining">
                                                                                <span class="e-clear-icon e-clear-icon-hide"
                                                                                      aria-label="close"
                                                                                      role="button"></span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2 column">
                                                                            <div class="form-group">
                                                                                <input <?php echo $DateInput . $onblur; ?>
                                                                                        id="date_of_resigning<?php echo $i; ?>"
                                                                                        value=""
                                                                                        placeholder="Date Of Leaving">
                                                                                <span class="e-clear-icon e-clear-icon-hide"
                                                                                      aria-label="close"
                                                                                      role="button"></span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3 column">
                                                                            <div class="form-group">
                                                                                <textarea rows="1" id="reason_of_leaving<?php echo $i; ?>" placeholder="Reason Of Leaving" <?php echo $TAttrs . $onblur; ?> ></textarea>
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
            var validAddress = /[^a-zA-Z0-9+-._,@&#/' ]/;

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
            var message = 'Please provide at least one previous experience information.';
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
                        var company_name = document.getElementById('company_name' + checkedValue);
                        var designation = document.getElementById('designation' + checkedValue);
                        var date_of_joining = document.getElementById('date_of_joining' + checkedValue);
                        var date_of_resigning = document.getElementById('date_of_resigning' + checkedValue);
                        var reason_of_leaving = document.getElementById('reason_of_leaving' + checkedValue);
                        if (company_name.value == '') {
                            company_name.style.borderColor = '#F00';
                            message = 'Company Name field is required, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (validName.test(company_name.value)) {
                            company_name.style.borderColor = '#F00';
                            message = 'Special Characters are not Allowed in Company Name field, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (designation.value == '') {
                            designation.style.borderColor = '#F00';
                            message = 'Designation field is required, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (validName.test(designation.value)) {
                            designation.style.borderColor = '#F00';
                            message = 'Special Characters are not Allowed in Designation field, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (date_of_joining.value == '') {
                            date_of_joining.style.borderColor = '#F00';
                            message = 'Date of Joining field is required, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (!(validDate.test(date_of_joining.value)) || date_of_joining.value.length !== 10) {
                            date_of_joining.style.borderColor = '#F00';
                            message = 'Please select a valid date of joining, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (date_of_resigning.value == '') {
                            date_of_resigning.style.borderColor = '#F00';
                            message = 'Date of Leaving field is required, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (!(validDate.test(date_of_resigning.value)) || date_of_resigning.value.length !== 10) {
                            date_of_resigning.style.borderColor = '#F00';
                            message = 'Please select a valid Date of Leaving, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (reason_of_leaving.value == '') {
                            reason_of_leaving.style.borderColor = '#F00';
                            message = 'Reason of leaving field is required, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (validAddress.test(reason_of_leaving.value.trim())) {
                            reason_of_leaving.style.borderColor = '#F00';
                            message = 'Special Characters are not Allowed, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else {
                            var obj = {};
                            obj = {
                                "company_name": company_name.value,
                                "designation": designation.value,
                                "date_of_joining": date_of_joining.value,
                                "date_of_resigning": date_of_resigning.value,
                                "reason_of_leaving": reason_of_leaving.value
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
                        type: "POST", url: "ajax/employee_experience.php",
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
                                                var redirect = <?php echo isset($_GET['emp_code']) && is_numeric($_GET['emp_code']) && !empty($_GET['emp_code']) ? '"' . $admin_url . 'experience_overview?emp_id="' : '""'; ?>;
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
                data: {'postData': postData, 'getEmployee': true, "R": "employee_experience"},
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
                                getEmployeeExperience(employee_info.id);
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

        function getEmployeeExperience(id) {

            var postData = {"id": id};
            $.ajax({
                type: "POST", url: "ajax/common.php",
                data: {'postData': postData, 'getEmployeeExperience': true},
                success: function (resPonse) {
                    if (resPonse !== undefined && resPonse != '') {
                        var obj = JSON.parse(resPonse);
                        if (obj.code !== undefined && obj.code != '') {
                            if (obj.code === 200 && obj.data !== undefined) {
                                console.log(obj.data);
                                var r_rows = 0;
                                for (const key in obj.data) {
                                    r_rows++;
                                    Ele = document.getElementById('lineRepresentativeBox' + r_rows);
                                    if (Ele) {
                                        Ele.checked = true;
                                        document.getElementById('company_name' + r_rows).value = obj.data[key].company_name;
                                        document.getElementById('designation' + r_rows).value = obj.data[key].designation;
                                        document.getElementById('date_of_joining' + r_rows).value = obj.data[key].joining_date;
                                        document.getElementById('date_of_resigning' + r_rows).value = obj.data[key].resigning_date;
                                        document.getElementById('reason_of_leaving' + r_rows).value = obj.data[key].reason_of_leaving;
                                    } else {
                                        var innerHTml_c = '';
                                        innerHTml_c += '<div class="row">';
                                        innerHTml_c += '<div class="col-md-1 column"><div class="form-group text-center mt-3"><label class="checkbox checkbox-outline checkbox-success d-inline-block"><input type="checkbox" class="lineRepresentativeBox" value="' + r_rows + '" name="lineRepresentativeBox[]" id="lineRepresentativeBox' + r_rows + '" checked="checked"><b class="float-left mr-2">' + r_rows + '.</b><span class="float-left"></span></label></div></div>';
                                        innerHTml_c += '<div class="col-md-2 column"><div class="form-group"><input maxlength="50" id="company_name' + r_rows + '" value="' + obj.data[key].company_name + '" <?php echo $TAttrs . $onblur; ?> placeholder="Company Name"/></div></div>';
                                        innerHTml_c += '<div class="col-md-2 column"><div class="form-group"><input maxlength="50" id="designation' + r_rows + '" value="' + obj.data[key].designation + '" <?php echo $TAttrs . $onblur; ?> placeholder="Designation"/></div></div>';
                                        innerHTml_c += '<div class="col-md-2 column"><div class="form-group">';
                                        innerHTml_c += '<input <?php echo $DateInput . $onblur; ?> id="date_of_joining' + r_rows + '" value="' + obj.data[key].joining_date + '" placeholder="Date Of Joining"/>';
                                        innerHTml_c += '<span class="e-clear-icon e-clear-icon-hide" aria-label="close" role="button"></span>';
                                        innerHTml_c += '</div></div>';
                                        innerHTml_c += '<div class="col-md-2 column"><div class="form-group">';
                                        innerHTml_c += '<input <?php echo $DateInput . $onblur; ?> id="date_of_resigning' + r_rows + '" value="' + obj.data[key].resigning_date + '" placeholder="Date Of Leaving"/>';
                                        innerHTml_c += '<span class="e-clear-icon e-clear-icon-hide" aria-label="close" role="button"></span>';
                                        innerHTml_c += '</div></div>';
                                        innerHTml_c += '<div class="col-md-3 column"><div class="form-group">';
                                        innerHTml_c += '<textarea rows="1" id="reason_of_leaving' + r_rows + '" placeholder="Reason Of Leaving" <?php echo $TAttrs . $onblur; ?> >' + obj.data[key].reason_of_leaving + '</textarea>';
                                        innerHTml_c += '</div></div>';
                                        innerHTml_c += '</div>';
                                        $("#Data_Holder_Child_Div").append(innerHTml_c);
                                        document.getElementById('r_rows').value = r_rows;
                                        loadCalendar({"d": ['date_of_joining' + r_rows, 'date_of_resigning' + r_rows]});
                                    }
                                }
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
            innerHTml_c += '<div class="col-md-2 column"><div class="form-group"><input maxlength="50" id="company_name' + r_rows + '" value="" <?php echo $TAttrs . $onblur; ?> placeholder="Company Name"/></div></div>';
            innerHTml_c += '<div class="col-md-2 column"><div class="form-group"><input maxlength="50" id="designation' + r_rows + '" value="" <?php echo $TAttrs . $onblur; ?> placeholder="Designation"/></div></div>';
            innerHTml_c += '<div class="col-md-2 column"><div class="form-group">';
            innerHTml_c += '<input <?php echo $DateInput . $onblur; ?> id="date_of_joining' + r_rows + '" value="" placeholder="Date Of Joining"/>';
            innerHTml_c += '<span class="e-clear-icon e-clear-icon-hide" aria-label="close" role="button"></span>';
            innerHTml_c += '</div></div>';
            innerHTml_c += '<div class="col-md-2 column"><div class="form-group">';
            innerHTml_c += '<input <?php echo $DateInput . $onblur; ?> id="date_of_resigning' + r_rows + '" value="" placeholder="Date Of Leaving"/>';
            innerHTml_c += '<span class="e-clear-icon e-clear-icon-hide" aria-label="close" role="button"></span>';
            innerHTml_c += '</div></div>';
            innerHTml_c += '<div class="col-md-3 column"><div class="form-group">';
            innerHTml_c += '<textarea rows="1" id="reason_of_leaving' + r_rows + '" placeholder="Reason Of Leaving" <?php echo $TAttrs . $onblur; ?> ></textarea>';
            innerHTml_c += '</div></div>';
            innerHTml_c += '</div>';
            $("#Data_Holder_Child_Div").append(innerHTml_c);
            objDiv.scrollTop = objDiv.scrollHeight;
            last_row_number.value = r_rows;
            loadCalendar({"d": ['date_of_joining' + r_rows, 'date_of_resigning' + r_rows]});
        }

        <?php
        if (isset($_GET['emp_code']) && is_numeric($_GET['emp_code']) && !empty($_GET['emp_code'])) {
            echo 'getEmployee(' . $_GET['emp_code'] . ')';
        }
        ?>

    </script>
<?php include_once("../includes/endTags.php"); ?>