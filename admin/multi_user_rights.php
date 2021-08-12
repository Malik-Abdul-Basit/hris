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
                                                if (!hasRight($user_right_title, 'assign_rights')) {
                                                    header('Location: ' . $page_not_found_url);
                                                    exit();
                                                }
                                                echo ucwords(str_replace("_", " ", $page));
                                                $TAttrs = ' type="text" class="form-control" ';
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
                                                                            <input tabindex="10" maxlength="20"
                                                                                   id="employee_code"
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
                                                            <input type="hidden" class="not-display" id="e_id">
                                                            <input type="hidden" class="not-display" id="u_id">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="separator separator-dashed my-10"></div>

                                                <div class="mb-3">
                                                    <div class="row">

                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label><b>* Roles:</b></label>
                                                                <select tabindex="20"
                                                                        id="type" <?php echo $TAttrs . $onblur; ?>>
                                                                    <option selected="selected" value="">Select
                                                                    </option>
                                                                    <?php
                                                                    $role_array = config("users.type.title");
                                                                    unset($role_array[1]);
                                                                    foreach ($role_array as $key => $value) {
                                                                        echo '<option value="' . $key . '">' . $value . '</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                                <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageType"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label><b>* Status:</b></label>
                                                                <select tabindex="30"
                                                                        id="status" <?php echo $TAttrs . $onblur; ?>>
                                                                    <option selected="selected" value="">Select
                                                                    </option>
                                                                    <?php
                                                                    foreach (config("users.status.title") as $key => $value) {
                                                                        echo '<option value="' . $key . '">' . $value . '</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                                <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageStatus"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="separator separator-dashed my-10"></div>

                                                <div class="mb-3">
                                                    <h3 class="font-size-lg text-dark-75 font-weight-bold mb-4">
                                                        Assign Rights:</h3>

                                                    <div class="mb-2">
                                                        <div id="Data_Holder_Parent_Div" style="overflow: visible">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label><b>* Branch:</b></label>
                                                                        <select <?php echo $onblur; ?>
                                                                                tabindex="40"
                                                                                class="form-control selectpicker"
                                                                                multiple data-actions-box="true"
                                                                                id="branches">
                                                                            <?php
                                                                            $working = config('branches.status.value.working');
                                                                            $select = "SELECT `id`,`name` FROM `branches` WHERE `company_id`='{$global_company_id}' AND `status`='{$working}' AND `deleted_at` IS NULL ORDER BY `id` ASC";
                                                                            $query = mysqli_query($db, $select);
                                                                            if (mysqli_num_rows($query) > 0) {
                                                                                while ($result = mysqli_fetch_object($query)) {
                                                                                    echo '<option value="' . $result->id . '">' . $result->name . '</option>';
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                        <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageBranch"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded"
                                                                 id="dataListingWrapper">
                                                            </div>

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

            var u_id = document.getElementById('u_id');
            var e_id = document.getElementById('e_id');
            var type = document.getElementById('type');
            var status = document.getElementById('status');
            var branch_ids = $('#branches').val();
            var employee_code = document.getElementById('employee_code');
            var A = '<?php echo hasRight($user_right_title, 'assign_multi_rights') ?>';
            var typeArray = [<?php $role_array = config('users.type.value'); unset($role_array['super_admin']); echo '"' . implode('","', array_values($role_array)) . '"' ?>];
            var statusArray = [<?php echo '"' . implode('","', array_values(config('users.status.value'))) . '"' ?>];

            var errorMessageEmployeeCode = document.getElementById('errorMessageEmployeeCode');
            var errorMessageType = document.getElementById('errorMessageType');
            var errorMessageStatus = document.getElementById('errorMessageStatus');
            var errorMessageBranch = document.getElementById('errorMessageBranch');
            var responseMessageWrapper = document.getElementById('responseMessageWrapper');
            var responseMessage = document.getElementById('responseMessage');

            employee_code.style.borderColor = type.style.borderColor = status.style.borderColor = '#E4E6EF';
            errorMessageEmployeeCode.innerText = errorMessageType.innerText = errorMessageStatus.innerText = errorMessageBranch.innerText = responseMessage.innerText = '';
            responseMessageWrapper.style.display = "none";
            var error = '';

            var checkedItem = null;
            var data = [];
            var inputElements = document.getElementsByClassName('rightRepresentativeBox');

            if (A == '') {
                toasterTrigger('warning', 'Sorry! You have no right to assign user rights.');
            } else if (employee_code.value == '') {
                employee_code.style.borderColor = '#F00';
                error = "Employee Code field is required.";
                errorMessageEmployeeCode.innerText = error;
                toasterTrigger('error', error);
                return false;
            } else if (isNaN(employee_code.value) === true || employee_code.value < 1 || employee_code.value.length > 20) {
                employee_code.style.borderColor = '#F00';
                error = "Invalid Employee Code.";
                errorMessageEmployeeCode.innerText = error;
                toasterTrigger('error', error);
                return false;
            } else if (type.value == '') {
                type.style.borderColor = '#F00';
                error = "Roles field is required.";
                errorMessageType.innerText = error;
                toasterTrigger('error', error);
                return false;
            } else if (isNaN(type.value) === true || type.value < 1) {
                type.style.borderColor = '#F00';
                error = "Please select a valid option of Role.";
                errorMessageType.innerText = error;
                toasterTrigger('error', error);
                return false;
            } else if (typeArray.includes(type.value) == false || type.value.length > 2) {
                type.style.borderColor = '#F00';
                error = "Please select a valid option.";
                errorMessageType.innerText = error;
                toasterTrigger('error', error);
                return false;
            } else if (status.value == '') {
                status.style.borderColor = '#F00';
                error = "Status field is required.";
                errorMessageStatus.innerText = error;
                toasterTrigger('error', error);
                return false;
            } else if (isNaN(status.value) === true || status.value < 0) {
                status.style.borderColor = '#F00';
                error = "Please select a valid option of Status.";
                errorMessageStatus.innerText = error;
                toasterTrigger('error', error);
                return false;
            } else if (statusArray.includes(status.value) == false || status.value.length > 2) {
                status.style.borderColor = '#F00';
                error = "Please select a valid option.";
                errorMessageStatus.innerText = error;
                toasterTrigger('error', error);
                return false;
            } else if (branch_ids == '') {
                error = "Branch is required.";
                errorMessageBranch.innerText = error;
                toasterTrigger('error', error);
                return false;
            } else {
                for (var i = 0; inputElements[i]; ++i) {
                    if (inputElements[i].checked) {
                        checkedItem = inputElements[i];

                        var main_menu_id = checkedItem.dataset.main_menu_id;
                        var sub_menu_id = checkedItem.dataset.sub_menu_id;
                        var child_menu_id = checkedItem.dataset.child_menu_id;
                        var action = checkedItem.value;

                        var obj = {};
                        obj = {
                            "main_menu_id": main_menu_id,
                            "sub_menu_id": sub_menu_id,
                            "child_menu_id": child_menu_id,
                            "action": action
                        }
                        data.push(obj);
                    }
                }
                loader(true);
                var postData = {
                    "employee_code": employee_code.value,
                    "u_id": u_id.value,
                    "e_id": e_id.value,
                    "type": type.value,
                    "status": status.value,
                    "branch_id": branch_ids,
                    "user_right_title": '<?php echo $user_right_title; ?>',
                    "data": data
                };

                $.ajax({
                    type: "POST", url: "ajax/user_rights.php",
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

        function getEmployee(code) {
            loader(true);
            var employee_code = document.getElementById('employee_code');
            var e_id = document.getElementById('e_id');
            var u_id = document.getElementById('u_id');
            var emp_email = document.getElementById('emp_email');
            var full_name = document.getElementById('full_name');
            var emp_pseudo_name = document.getElementById('emp_pseudo_name');

            var dataListingWrapper = document.getElementById('dataListingWrapper');
            var errorMessageEmployeeCode = document.getElementById('errorMessageEmployeeCode');
            var employeeImageWrapper = document.getElementById('employee_image_wrapper');
            var responseMessageWrapper = document.getElementById('responseMessageWrapper');
            var responseMessage = document.getElementById('responseMessage');

            emp_email.value = full_name.value = emp_pseudo_name.value = e_id.value = u_id.value = errorMessageEmployeeCode.innerText = employeeImageWrapper.innerHTML = dataListingWrapper.innerHTML = responseMessage.innerText = '';
            responseMessageWrapper.style.display = "none";

            var postData = {"code": code};
            $.ajax({
                type: "POST", url: "ajax/common.php",
                data: {'postData': postData, 'getEmployee': true, "R": "users"},
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
                                e_id.value = employee_info.id;
                                u_id.value = employee_info.u_id;
                                getUserRights();
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

        function getUserRights() {
            loader(true);
            var id = document.getElementById('e_id').value;
            var u_id = document.getElementById('u_id').value;
            var branch_id = document.getElementById('branches').value;
            var dataListingWrapper = document.getElementById('dataListingWrapper');
            dataListingWrapper.innerHTML = '';

            var postData = {"id": id, "u_id": u_id, "branch_id": branch_id};
            $.ajax({
                type: "POST", url: "ajax/common.php",
                data: {'postData': postData, 'getUserRights': true},
                success: function (resPonse) {
                    if (resPonse !== undefined && resPonse != '') {
                        var obj = JSON.parse(resPonse);
                        if (obj.code !== undefined && obj.code != '') {
                            if (obj.code === 200 && obj.type !== undefined && obj.status !== undefined && obj.html !== undefined) {
                                document.getElementById('type').value = obj.type;
                                document.getElementById('status').value = obj.status;
                                dataListingWrapper.innerHTML = obj.html;
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

        <?php
        if (isset($_GET['emp_code']) && is_numeric($_GET['emp_code']) && !empty($_GET['emp_code'])) {
            echo 'getEmployee(' . $_GET['emp_code'] . ')';
        }
        ?>

    </script>
<?php include_once("../includes/endTags.php"); ?>