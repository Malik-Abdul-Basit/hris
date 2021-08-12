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
                                                            <div class="col-md-6">
                                                                <h3 class="font-size-lg text-dark-75 font-weight-bold mb-10">
                                                                    Employee Information:</h3>
                                                                <div class="row">
                                                                    <div class="col-md-12">
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
                                                                    <div class="col-md-12">
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
                                                                    <div class="col-md-12">
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
                                                                    <div class="col-md-12">
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
                                                            <div class="col-md-6">
                                                                <div class="row">
                                                                    <div class="col-md-12 text-center mt-2">
                                                                        Minimum Image Size Should Be 400x400
                                                                    </div>
                                                                </div>
                                                                <div id="upload-demo"
                                                                     class="upload-employee-image-preview"></div>
                                                                <input type="file" id="select_file" accept="image/*">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <button type="button" onclick="selectImage()"
                                                                class="btn btn-success font-weight-bold mr-2 float-left"
                                                                id="select_image">Select Image
                                                        </button>
                                                        <button type="button" onclick="saveFORM()"
                                                                class="btn btn-primary font-weight-bold mr-2 float-left">
                                                            <?php echo config('lang.button.title.save'); ?>
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
    <script src="<?php echo $base_url ?>assets/croppie_assets/js/croppie.js"></script>
    <script type="text/javascript">
        $uploadCrop = $('#upload-demo').croppie({
            enableExif: true,
            viewport: {
                width: 350,
                height: 350,
                circle: false,
                type: 'canvas'
                //type: 'circle'
            },
            boundary: {
                width: 350,
                height: 350
            }
        });

        $('#select_file').on('change', function () {
            var reader = new FileReader();
            reader.onload = function (e) {
                $uploadCrop.croppie('bind', {
                    url: e.target.result
                }).then(function () {
                    //console.log('jQuery bind complete');
                });
            }
            reader.readAsDataURL(this.files[0]);
        });

        function selectImage() {
            document.getElementById("select_file").click();
        }

        function saveFORM() {
            var employee_code = document.getElementById('employee_code');
            //var emp_email = document.getElementById('emp_email');
            //var full_name = document.getElementById('full_name');
            //var emp_pseudo_name = document.getElementById('emp_pseudo_name');
            var select_file = document.getElementById("select_file");

            //var select_image = document.getElementById("select_image");
            var errorMessageEmployeeCode = document.getElementById('errorMessageEmployeeCode');
            var responseMessageWrapper = document.getElementById('responseMessageWrapper');
            var responseMessage = document.getElementById('responseMessage');
            //var image_preview = document.getElementsByClassName('cr-image')[0];

            employee_code.style.borderColor = '#E4E6EF';
            errorMessageEmployeeCode.innerText = responseMessage.innerText = "";
            responseMessageWrapper.style.display = "none";

            if (employee_code.value == '') {
                employee_code.style.borderColor = '#F00';
                errorMessageEmployeeCode.innerText = "Employee Code field is required.";
                return false;
            } else if (isNaN(employee_code.value) === true || employee_code.value < 1 || employee_code.value.length > 20) {
                employee_code.style.borderColor = '#F00';
                errorMessageEmployeeCode.innerText = "Invalid Employee Code.";
                return false;
            } else if (select_file.value == '') {
                responseMessageWrapper.style.display = "block";
                responseMessage.innerText = "Please select an Image";
                return false;
            } else {
                $uploadCrop.croppie('result', {
                    type: 'canvas',
                    size: 'viewport'
                }).then(function (imageBase64) {
                    loader(true);
                    var postData = {"imageBase64": imageBase64, "employee_code": employee_code.value, "user_right_title": '<?php echo $user_right_title; ?>'};
                    $.ajax({
                        type: "POST", url: "ajax/employee_image.php",
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
                });
            }
        }

        function getEmployee(code) {
            loader(true);
            var employee_code = document.getElementById('employee_code');
            var emp_email = document.getElementById('emp_email');
            var full_name = document.getElementById('full_name');
            var emp_pseudo_name = document.getElementById('emp_pseudo_name');
            var select_image = document.getElementById("select_image");
            var select_file = document.getElementById("select_file");

            var errorMessageEmployeeCode = document.getElementById('errorMessageEmployeeCode');
            var responseMessageWrapper = document.getElementById('responseMessageWrapper');
            var responseMessage = document.getElementById('responseMessage');

            employee_code.style.borderColor = '#E4E6EF';

            errorMessageEmployeeCode.innerText = emp_email.value = full_name.value = emp_pseudo_name.value = select_file.value = responseMessage.innerText = '';
            responseMessageWrapper.style.display = select_image.style.display = "none";

            var image_preview = document.getElementsByClassName('cr-image')[0];
            image_preview.removeAttribute('src');
            image_preview.removeAttribute('style');
            var cr_overlay = document.getElementsByClassName('cr-overlay')[0];
            cr_overlay.removeAttribute('style');
            var cr_slider = document.getElementsByClassName('cr-slider')[0];
            cr_slider.removeAttribute('min');
            cr_slider.removeAttribute('max');

            var postData = {"code": code};
            $.ajax({
                type: "POST", url: "ajax/common.php",
                data: {'postData': postData, 'getEmployee': true, "R": "employee_image"},
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
                                image_preview.setAttribute("style", "opacity: 1; transform: translate3d(1px, 0px, 0px) scale(1); transform-origin: 174px 174px;");
                                cr_overlay.setAttribute("style", "width: 350px; height: 350px; top: 1px; left: 2px;");
                                cr_slider.min = '1.0000';
                                cr_slider.max = '1.5000';
                                cr_slider.value = '0';
                                image_preview.src = employee_info.image;
                                select_image.style.display = "block";
                                loader(false);
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