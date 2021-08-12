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
                                                    $Q = "SELECT `id`, `name`, `department_id` FROM `salary_grades` WHERE `id`='{$id}' AND `company_id`='{$global_company_id}' AND `branch_id`='{$global_branch_id}' AND `deleted_at` IS NULL";
                                                    $Qry = mysqli_query($db, $Q);
                                                    $Rows = mysqli_num_rows($Qry);
                                                    if ($Rows != 1) {
                                                        header('Location: ' . $page_not_found_url);
                                                        exit();
                                                    } else {
                                                        $Result = mysqli_fetch_object($Qry);
                                                        $name = html_entity_decode(stripslashes($Result->name));
                                                        $department_id = html_entity_decode(stripslashes($Result->department_id));
                                                    }
                                                } else {
                                                    if (!hasRight($user_right_title, 'add')) {
                                                        header('Location: ' . $page_not_found_url);
                                                        exit();
                                                    }
                                                    echo 'Add ' . ucwords(str_replace("_", " ", $page));
                                                    $id = $department_id = 0;
                                                    $name = '';
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
                                                                            <label>Department:</label>
                                                                            <select id="department_id" <?php echo $TAttrs; ?>>
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
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="separator separator-dashed my-10"></div>

                                                <div class="mb-3">
                                                    <h3 class="font-size-lg text-dark-75 font-weight-bold mb-10"> Set
                                                        Salary Grades & Value:</h3>
                                                    <div class="mb-2">
                                                        <div id="Data_Holder_Parent_Div">
                                                            <div class="row">
                                                                <div class="col-md-1 column text-center"><b>Sr.</b>
                                                                </div>
                                                                <div class="col-md-3 column"><b> * Grade Name</b></div>
                                                                <div class="col-md-4 column">
                                                                    <b>
                                                                        * Amount
                                                                        <small> (From) </small>
                                                                    </b>
                                                                </div>
                                                                <div class="col-md-4 column">
                                                                    <b>
                                                                        * Amount
                                                                        <small> (To) </small>
                                                                    </b>
                                                                </div>
                                                            </div>

                                                            <div id="Data_Holder_Child_Div" style="max-height: 100%"
                                                                 class="mt-7 mb-7">
                                                                <?php
                                                                $i = 1;
                                                                if (!empty($id)) {
                                                                    $query_detail = mysqli_query($db, "SELECT * FROM `salary_grade_details` WHERE `salary_grade_id`='{$id}' ORDER BY `id` ASC");
                                                                    if (mysqli_num_rows($query_detail) > 0) {
                                                                        while ($result_detail = mysqli_fetch_object($query_detail)) {
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
                                                                                <div class="col-md-3 column">
                                                                                    <div class="form-group">
                                                                                        <input maxlength="50"
                                                                                               id="grade_name<?php echo $i; ?>"
                                                                                               value="<?php echo $result_detail->grade_name; ?>" <?php echo $TAttrs . $onblur; ?>
                                                                                               placeholder="Grade Name"/>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4 column">
                                                                                    <div class="form-group">
                                                                                        <input maxlength="9"
                                                                                               onkeypress="allowNumberAndPoint(event)"
                                                                                               id="from<?php echo $i; ?>"
                                                                                               value="<?php echo $result_detail->from; ?>" <?php echo $TAttrs . $onblur; ?>
                                                                                               placeholder="Amount From"/>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4 column">
                                                                                    <div class="form-group">
                                                                                        <input maxlength="9"
                                                                                               onkeypress="allowNumberAndPoint(event)"
                                                                                               id="to<?php echo $i; ?>"
                                                                                               value="<?php echo $result_detail->to; ?>" <?php echo $TAttrs . $onblur; ?>
                                                                                               placeholder="Amount To"/>
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
                                                                        <div class="col-md-3 column">
                                                                            <div class="form-group">
                                                                                <input maxlength="50"
                                                                                       id="grade_name<?php echo $i; ?>"
                                                                                       value="" <?php echo $TAttrs . $onblur; ?>
                                                                                       placeholder="Grade Name"/>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4 column">
                                                                            <div class="form-group">
                                                                                <input maxlength="9"
                                                                                       onkeypress="allowNumberAndPoint(event)"
                                                                                       id="from<?php echo $i; ?>"
                                                                                       value="0" <?php echo $TAttrs . $onblur; ?>
                                                                                       placeholder="Amount From"/>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4 column">
                                                                            <div class="form-group">
                                                                                <input maxlength="9"
                                                                                       onkeypress="allowNumberAndPoint(event)"
                                                                                       id="to<?php echo $i; ?>"
                                                                                       value="0" <?php echo $TAttrs . $onblur; ?>
                                                                                       placeholder="Amount To"/>
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
            var validDescription = /[^a-zA-Z0-9+-._,@&#/' ]/;
            var id = document.getElementById('id');
            var A = '<?php echo hasRight($user_right_title, 'add') ?>';
            var E = '<?php echo hasRight($user_right_title, 'edit') ?>';

            var name = document.getElementById('name');

            var department_id = document.getElementById('department_id');
            var select2_department_id_container = document.querySelector("[aria-labelledby='select2-department_id-container']");

            var errorMessageName = document.getElementById('errorMessageName');
            var errorMessageDepartment = document.getElementById('errorMessageDepartment');
            var responseMessageWrapper = document.getElementById('responseMessageWrapper');
            var responseMessage = document.getElementById('responseMessage');

            name.style.borderColor = department_id.style.borderColor = select2_department_id_container.style.borderColor = '#E4E6EF';
            errorMessageName.innerText = errorMessageDepartment.innerText = responseMessage.innerText = '';
            responseMessageWrapper.style.display = "none";

            var checkedValue = null;
            var continueProcessing = false;
            var data = [];
            var message = 'Please checked at least one Salary Grades.';
            var inputElements = document.getElementsByClassName('lineRepresentativeBox');

            if (id.value == 0 && A == '') {
                toasterTrigger('warning', 'Sorry! You have no right to add record.');
            } else if (id.value > 0 && E == '') {
                toasterTrigger('warning', 'Sorry! You have no right to update record.');
            } else if (name.value == '') {
                name.style.borderColor = '#F00';
                errorMessageName.innerText = "Salary Band Name field is required.";
                return false;
            } else if (name.value.length > 50) {
                name.style.borderColor = '#F00';
                errorMessageName.innerText = "Length should not exceed 50 characters.";
                return false;
            } else if (validName.test(name.value)) {
                name.style.borderColor = '#F00';
                errorMessageName.innerText = "Special Characters are not Allowed.";
                return false;
            } else if (department_id.value == '') {
                select2_department_id_container.style.borderColor = '#F00';
                errorMessageDepartment.innerText = "Please select a valid option.";
                return false;
            } else if (department_id.value != '' && (isNaN(department_id.value) === true || department_id.value.length > 10)) {
                select2_department_id_container.style.borderColor = '#F00';
                errorMessageDepartment.innerText = "Please select a valid option.";
                return false;
            } else {
                for (var i = 0; inputElements[i]; ++i) {
                    if (inputElements[i].checked) {
                        checkedValue = inputElements[i].value;
                        var grade_name = document.getElementById('grade_name' + checkedValue);
                        var from = document.getElementById('from' + checkedValue);
                        var to = document.getElementById('to' + checkedValue);

                        if (grade_name.value == '') {
                            grade_name.style.borderColor = '#F00';
                            message = 'Grade Name field is required, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (grade_name.value.length > 50) {
                            grade_name.style.borderColor = '#F00';
                            message = 'Length should not exceed 50 characters, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (validName.test(grade_name.value)) {
                            grade_name.style.borderColor = '#F00';
                            message = 'Special Characters are not Allowed in Grade Name field, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (from.value == '') {
                            from.style.borderColor = '#F00';
                            message = 'Amount From field is required, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (isNaN(from.value) === true) {
                            from.style.borderColor = '#F00';
                            message = 'Amount From field should contain only numeric characters, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (from.value.length > 9) {
                            from.style.borderColor = '#F00';
                            message = 'Length of "Amount From" field should not exceed 9 digits, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (from.value <= 0) {
                            from.style.borderColor = '#F00';
                            message = 'Amount From field should greater-than 0, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (to.value == '') {
                            to.style.borderColor = '#F00';
                            message = 'Amount To field is required, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (isNaN(to.value) === true) {
                            to.style.borderColor = '#F00';
                            message = 'Amount To field should contain only numeric characters, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (to.value.length > 9) {
                            to.style.borderColor = '#F00';
                            message = 'Length of "Amount To" field should not exceed 9 digits, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (to.value <= 0) {
                            to.style.borderColor = '#F00';
                            message = 'Amount To field should greater-than 0, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (parseInt(to.value) < parseInt(from.value)) {
                            to.style.borderColor = '#F00';
                            message = '"Amount To" should not less-than "Amount From" At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else {
                            var obj = {};
                            obj = {
                                "grade_name": grade_name.value,
                                "from": from.value,
                                "to": to.value
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
                        "id": id.value,
                        "name": name.value,
                        "department_id": department_id.value,
                        "user_right_title": '<?php echo $user_right_title; ?>',
                        "data": data
                    };
                    $.ajax({
                        type: "POST", url: "ajax/salary_grade.php",
                        data: {"postData": postData},
                        success: function (resPonse) {
                            if (resPonse !== undefined && resPonse != '') {
                                var obj = JSON.parse(resPonse);
                                if (obj.code === 200 || obj.code === 405 || obj.code === 422) {
                                    var title = '';
                                    if (obj.code === 422) {
                                        if (obj.errorField !== undefined && obj.errorField != '' && obj.errorDiv !== undefined && obj.errorDiv != '' && obj.errorMessage !== undefined && obj.errorMessage != '') {
                                            if (obj.errorField == 'department_id') {
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
                                                if (select2_department_idContainer) {
                                                    select2_department_idContainer.setAttribute("title", 'All');
                                                    select2_department_idContainer.innerHTML = '<span class="select2-selection__clear" title="Remove all items" data-select2-id="3">×</span>All';
                                                }
                                                department_id.value = "0";
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
            innerHTml_c += '<div class="col-md-3 column"><div class="form-group"><input maxlength="50" id="grade_name' + r_rows + '" value="" <?php echo $TAttrs . $onblur; ?> placeholder="Grade Name"/></div></div>';
            innerHTml_c += '<div class="col-md-4 column"><div class="form-group"><input maxlength="9" onkeypress="allowNumberAndPoint(event)" id="from' + r_rows + '" value="0" <?php echo $TAttrs . $onblur; ?> placeholder="Amount From"/></div></div>';
            innerHTml_c += '<div class="col-md-4 column"><div class="form-group"><input maxlength="9" onkeypress="allowNumberAndPoint(event)" id="to' + r_rows + '" value="0" <?php echo $TAttrs . $onblur; ?> placeholder="Amount To"/></div></div>';
            innerHTml_c += '</div>';
            $("#Data_Holder_Child_Div").append(innerHTml_c);
            objDiv.scrollTop = objDiv.scrollHeight;
            last_row_number.value = r_rows;
        }
    </script>
<?php include_once("../includes/endTags.php"); ?>