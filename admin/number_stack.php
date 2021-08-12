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
                                                    if(!hasRight($user_right_title,'edit')){
                                                        header('Location: ' . $page_not_found_url);
                                                        exit();
                                                    }
                                                    echo 'Edit ' . ucwords(str_replace("_", " ", $page));
                                                    $id = htmlentities($_GET['id']);
                                                    $Q = "SELECT `id`, `evaluation_id` FROM `evaluation_number_stacks` WHERE `id`='{$id}' AND `company_id`='{$global_company_id}' AND `branch_id`='{$global_branch_id}' AND `deleted_at` IS NULL";
                                                    $Qry = mysqli_query($db, $Q);
                                                    $Rows = mysqli_num_rows($Qry);
                                                    if ($Rows != 1) {
                                                        header('Location: ' . $page_not_found_url);
                                                        exit();
                                                    } else {
                                                        $Result = mysqli_fetch_object($Qry);
                                                        $evaluation_id = html_entity_decode(stripslashes($Result->evaluation_id));
                                                    }
                                                } else {
                                                    if(!hasRight($user_right_title,'add')){
                                                        header('Location: ' . $page_not_found_url);
                                                        exit();
                                                    }
                                                    echo 'Add ' . ucwords(str_replace("_", " ", $page));
                                                    $id = $evaluation_id = 0;
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
                                                                            <label>* Evaluation:</label>
                                                                            <select id="evaluation_id" <?php echo $TAttrs; ?>>
                                                                                <option value=""> Select</option>
                                                                                <?php
                                                                                $select = "SELECT ev.id, ev.date, evt.name FROM evaluations as ev INNER JOIN evaluation_types AS evt ON ev.evaluation_type_id=evt.id WHERE ev.company_id='{$global_company_id}' AND ev.branch_id='{$global_branch_id}' AND ev.deleted_at IS NULL AND evt.deleted_at IS NULL ORDER BY ev.date ASC";
                                                                                $query = mysqli_query($db, $select);
                                                                                if (mysqli_num_rows($query) > 0) {
                                                                                    while ($result = mysqli_fetch_object($query)) {
                                                                                        $selected = '';
                                                                                        if ($evaluation_id == $result->id) {
                                                                                            $selected = 'selected="selected"';
                                                                                        }
                                                                                        ?>
                                                                                        <option <?php echo $selected; ?>
                                                                                                value="<?php echo $result->id; ?>">
                                                                                            <?php echo date('d-M-Y', strtotime($result->date)); ?>
                                                                                            -
                                                                                            <?php echo $result->name; ?>
                                                                                        </option>
                                                                                        <?php
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                            <div class="error_wrapper">
                                                                                <span class="text-danger"
                                                                                      id="errorMessageEvaluation"></span>
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
                                                        Stack Name & Value:</h3>
                                                    <div class="mb-2">
                                                        <div id="Data_Holder_Parent_Div">
                                                            <div class="row">
                                                                <div class="col-md-1 column text-center"><b>Sr.</b>
                                                                </div>
                                                                <div class="col-md-3 column"><b>Name</b></div>
                                                                <div class="col-md-1 column"><b>Condition</b></div>
                                                                <div class="col-md-3 column">
                                                                    <b>
                                                                        Value
                                                                        <small> (In Numbers) </small>
                                                                    </b>
                                                                </div>
                                                                <div class="col-md-4 column"><b>Description</b></div>
                                                            </div>

                                                            <div id="Data_Holder_Child_Div" style="max-height: 100%" class="mt-7 mb-7">
                                                                <?php
                                                                $i = 1;
                                                                if (!empty($id)) {
                                                                    $query_gpd = mysqli_query($db, "SELECT * FROM `evaluation_number_stack_details` WHERE `gp_id`='{$id}' ORDER BY `gp_value` DESC");
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
                                                                                <div class="col-md-3 column">
                                                                                    <div class="form-group">
                                                                                        <input maxlength="50"
                                                                                               id="gp_name<?php echo $i; ?>"
                                                                                               value="<?php echo $result_gpd->gp_name; ?>" <?php echo $TAttrs . $onblur; ?>
                                                                                               placeholder="Name"/>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-1 column text-center pt-3">
                                                                                    =
                                                                                </div>
                                                                                <div class="col-md-3 column">
                                                                                    <div class="input-group">
                                                                                        <input maxlength="6"
                                                                                               onkeypress="allowNumberAndPointLess(event)"
                                                                                               id="gp_value<?php echo $i; ?>"
                                                                                               value="<?php echo $result_gpd->gp_value; ?>" <?php echo $TAttrs . $onblur; ?>
                                                                                               placeholder="Value"/>
                                                                                        <div class="input-group-append">
                                                                                    <span class="input-group-text">
                                                                                        <i class="fab fa-neos"></i>
                                                                                        <!--<i class="icon-2x text-dark-50 flaticon2-percentage"></i>-->
                                                                                    </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4 column">
                                                                                    <div class="form-group">
                                                                                <textarea rows="1"
                                                                                          id="gp_description<?php echo $i; ?>" <?php echo $TAttrs . $onblur; ?> placeholder="Description"><?php echo $result_gpd->gp_description; ?></textarea>
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
                                                                                       id="gp_name<?php echo $i; ?>"
                                                                                       value="" <?php echo $TAttrs . $onblur; ?>
                                                                                       placeholder="Name"/>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-1 column text-center pt-3">
                                                                            =
                                                                        </div>
                                                                        <div class="col-md-3 column">
                                                                            <div class="input-group">
                                                                                <input maxlength="6"
                                                                                       onkeypress="allowNumberAndPointLess(event)"
                                                                                       id="gp_value<?php echo $i; ?>"
                                                                                       value="0" <?php echo $TAttrs . $onblur; ?>
                                                                                       placeholder="Value"/>
                                                                                <div class="input-group-append">
                                                                                    <span class="input-group-text">
                                                                                        <i class="fab fa-neos"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4 column">
                                                                            <div class="form-group">
                                                                                <textarea rows="1"
                                                                                          id="gp_description<?php echo $i; ?>" <?php echo $TAttrs . $onblur; ?> placeholder="Description"></textarea>
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

            var validName = /[^a-zA-Z0-9+-._,@&#/)(' ]/;
            var id = document.getElementById('id');
            var A = '<?php echo hasRight($user_right_title, 'add') ?>';
            var E = '<?php echo hasRight($user_right_title, 'edit') ?>';

            var evaluation_id = document.getElementById('evaluation_id');
            var select2_evaluation_id_container = document.querySelector("[aria-labelledby='select2-evaluation_id-container']");

            var errorMessageEvaluation = document.getElementById('errorMessageEvaluation');
            var responseMessageWrapper = document.getElementById('responseMessageWrapper');
            var responseMessage = document.getElementById('responseMessage');

            evaluation_id.style.borderColor = select2_evaluation_id_container.style.borderColor = '#E4E6EF';
            errorMessageEvaluation.innerText = responseMessage.innerText = '';
            responseMessageWrapper.style.display = "none";

            var checkedValue = null;
            var continueProcessing = false;
            var data = [];
            var message = 'Please provide at least one Grading Policy.';
            var inputElements = document.getElementsByClassName('lineRepresentativeBox');


            if (id.value == 0 && A == '') {
                toasterTrigger('warning', 'Sorry! You have no right to add record.');
            } else if (id.value > 0 && E == '') {
                toasterTrigger('warning', 'Sorry! You have no right to update record.');
            } else if (evaluation_id.value == '') {
                select2_evaluation_id_container.style.borderColor = '#F00';
                errorMessageEvaluation.innerText = "Evaluation field is required.";
                return false;
            } else if (evaluation_id.value < 1 || isNaN(evaluation_id.value) === true || evaluation_id.value.length > 10) {
                select2_evaluation_id_container.style.borderColor = '#F00';
                errorMessageEvaluation.innerText = "Please select a valid option.";
                return false;
            } else {
                for (var i = 0; inputElements[i]; ++i) {
                    if (inputElements[i].checked) {
                        checkedValue = inputElements[i].value;
                        var gp_name = document.getElementById('gp_name' + checkedValue);
                        var gp_value = document.getElementById('gp_value' + checkedValue);
                        var gp_description = document.getElementById('gp_description' + checkedValue);

                        if (gp_name.value == '') {
                            gp_name.style.borderColor = '#F00';
                            message = 'Name field is required, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (gp_name.value.length > 50) {
                            gp_name.style.borderColor = '#F00';
                            message = 'Length should not exceed 50 characters, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (validName.test(gp_name.value)) {
                            gp_name.style.borderColor = '#F00';
                            message = 'Special Characters are not Allowed in Name field, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (gp_value.value == '') {
                            gp_value.style.borderColor = '#F00';
                            message = 'Value field is required, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (gp_value.value.length > 6) {
                            gp_value.style.borderColor = '#F00';
                            message = 'Length should not exceed 6 characters, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (gp_value.value < 0) {
                            gp_value.style.borderColor = '#F00';
                            message = 'Value should greater-than 0, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (isNaN(gp_value.value) === true) {
                            gp_value.style.borderColor = '#F00';
                            message = 'Value field should contain only numeric characters, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (gp_description.value == '') {
                            gp_description.style.borderColor = '#F00';
                            message = 'Description field is required, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (validName.test(gp_description.value)) {
                            gp_description.style.borderColor = '#F00';
                            message = 'Special Characters are not Allowed in Description field, At line no ' + checkedValue;
                            continueProcessing = false;
                        } else {
                            var obj = {};
                            obj = {
                                "gp_name": gp_name.value,
                                "gp_value": gp_value.value,
                                "gp_description": gp_description.value
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
                        "evaluation_id": evaluation_id.value,
                        "user_right_title": '<?php echo $user_right_title; ?>',
                        "data": data
                    };
                    $.ajax({
                        type: "POST", url: "ajax/number_stack.php",
                        data: {"postData": postData},
                        success: function (resPonse) {
                            if (resPonse !== undefined && resPonse != '') {
                                var obj = JSON.parse(resPonse);
                                if (obj.code === 200 || obj.code === 405 || obj.code === 422) {
                                    var title = '';
                                    if (obj.code === 422) {
                                        if (obj.errorField !== undefined && obj.errorField != '' && obj.errorDiv !== undefined && obj.errorDiv != '' && obj.errorMessage !== undefined && obj.errorMessage != '') {
                                            if (obj.errorField == 'evaluation_id') {
                                                select2_evaluation_id_container.style.borderColor = '#F00';
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
                                                var select2_evaluation_idContainer = document.getElementById("select2-evaluation_id-container");
                                                if (select2_evaluation_idContainer) {
                                                    select2_evaluation_idContainer.removeAttribute("title");
                                                    select2_evaluation_idContainer.innerHTML = '<span class="select2-selection__placeholder">Select</span>';
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
            innerHTml_c += '<div class="col-md-3 column"><div class="form-group"><input maxlength="50" id="gp_name' + r_rows + '" value="" <?php echo $TAttrs . $onblur; ?> placeholder="Name"/></div></div>';
            innerHTml_c += '<div class="col-md-1 column text-center pt-3"> = </div>';
            innerHTml_c += '<div class="col-md-3 column"><div class="input-group"><input maxlength="6" onkeypress="allowNumberAndPointLess(event)" id="gp_value' + r_rows + '" value="0" <?php echo $TAttrs . $onblur; ?> placeholder="Value"/><div class="input-group-append"><span class="input-group-text"><i class="fab fa-neos"></i></span></div></div></div>';
            innerHTml_c += '<div class="col-md-4 column"><div class="form-group"><textarea rows="1" id="gp_description' + r_rows + '" <?php echo $TAttrs . $onblur; ?> placeholder="Description"></textarea></div></div>';
            innerHTml_c += '</div>';
            $("#Data_Holder_Child_Div").append(innerHTml_c);
            objDiv.scrollTop = objDiv.scrollHeight;
            last_row_number.value = r_rows;
        }
    </script>
<?php include_once("../includes/endTags.php"); ?>