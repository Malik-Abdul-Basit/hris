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
                                                    $Q = "SELECT * FROM `evaluation_types` WHERE `id`='{$id}' AND `company_id`='{$global_company_id}' AND `branch_id`='{$global_branch_id}' AND `deleted_at` IS NULL";
                                                    $Qry = mysqli_query($db, $Q);
                                                    $Rows = mysqli_num_rows($Qry);
                                                    if ($Rows != 1) {
                                                        header('Location: ' . $page_not_found_url);
                                                        exit();
                                                    } else {
                                                        $Result = mysqli_fetch_object($Qry);
                                                        $name = html_entity_decode(stripslashes($Result->name));
                                                        $duration = html_entity_decode(stripslashes($Result->duration));
                                                        $sort_by = html_entity_decode(stripslashes($Result->sort_by));
                                                    }
                                                } else {
                                                    if (!hasRight($user_right_title, 'add')) {
                                                        header('Location: ' . $page_not_found_url);
                                                        exit();
                                                    }
                                                    echo 'Add ' . ucwords(str_replace("_", " ", $page));
                                                    $id = 0;
                                                    $name = $duration = '';
                                                    $sort_by = '';
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

                                                                <div class="form-group">
                                                                    <label>* Duration:</label>

                                                                    <select id="duration" <?php echo $TAttrs . $onblur; ?>>
                                                                        <option selected="selected" value="">
                                                                            Select
                                                                        </option>
                                                                        <?php
                                                                        for ($m = 1; $m <= 12; $m++) {
                                                                            $selected = '';
                                                                            if ($duration == $m) {
                                                                                $selected = 'selected="selected"';
                                                                            }
                                                                            echo '<option ' . $selected . ' value="' . $m . '">' . $m . ' Month</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageDuration"></span>
                                                                    </div>
                                                                </div>

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
            var A = '<?php echo hasRight($user_right_title, 'add') ?>';
            var E = '<?php echo hasRight($user_right_title, 'edit') ?>';

            var name = document.getElementById('name');
            var duration = document.getElementById('duration');
            var sort_by = document.getElementById('sort_by');

            var errorMessageName = document.getElementById('errorMessageName');
            var errorMessageDuration = document.getElementById('errorMessageDuration');
            var errorMessageSortBy = document.getElementById('errorMessageSortBy');

            name.style.borderColor = duration.style.borderColor = sort_by.style.borderColor = '#E4E6EF';
            errorMessageName.innerText = errorMessageDuration.innerText = errorMessageSortBy.innerText = "";

            if (id.value == 0 && A == '') {
                toasterTrigger('warning', 'Sorry! You have no right to add record.');
            } else if (id.value > 0 && E == '') {
                toasterTrigger('warning', 'Sorry! You have no right to update record.');
            } else if (name.value == '') {
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
            } else if (duration.value == '') {
                duration.style.borderColor = '#F00';
                errorMessageDuration.innerText = "Duration field is required.";
                return false;
            } else if (isNaN(duration.value) === true) {
                duration.style.borderColor = '#F00';
                errorMessageDuration.innerText = "Duration field should contain only numeric.";
                return false;
            } else if (duration.value <= 0 || duration.value > 12) {
                duration.style.borderColor = '#F00';
                errorMessageDuration.innerText = "Please select a valid option.";
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
            } else {
                loader(true);
                var postData = {
                    "id": id.value,
                    "name": name.value,
                    "duration": duration.value,
                    "sort_by": sort_by.value,
                    "user_right_title": '<?php echo $user_right_title; ?>'
                };
                $.ajax({
                    type: "POST", url: "ajax/evaluation_type.php",
                    data: {'postData': postData},
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
                                    } else {
                                        loader(false);
                                    }
                                } else if (obj.code === 405 || obj.code === 200) {
                                    if (obj.responseMessage !== undefined && obj.responseMessage != '') {
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
    </script>
<?php include_once("../includes/endTags.php"); ?>