<?php
include_once('includes/connection.php');
include_once("includes/head.php");
?>
    <div class="d-flex flex-column flex-root">
        <!--begin::Login-->
        <div class="login login-3 wizard d-flex flex-column flex-lg-row flex-column-fluid">
            <!--begin::Aside-->
            <div class="login-aside d-flex flex-column flex-row-auto">
                <!--begin::Aside Top-->
                <div class="d-flex flex-column-auto flex-column pt-lg-15 pt-15">
                    <!--begin::Aside Header-->
                    <a href="https://medcaremso.com/" class="login-logo text-center pt-20 pb-3">
                        <img src="<?php echo $ct_assets; ?>images/MedcareLogo.png" class="max-h-120px"
                             alt=""/>
                    </a>
                    <!--end::Aside Header-->

                    <!--begin::Aside Title-->
                    <h3 class="font-weight-bolder text-center font-size-h4 text-dark-50  line-height-xl">
                        <!--User Experience & Interface Design<br/>
                        Strategy SaaS Solutions-->
                    </h3>
                    <!--end::Aside Title-->
                </div>
                <!--end::Aside Top-->

                <!--begin::Aside Bottom-->
                <div class="aside-img d-flex flex-row-fluid bgi-no-repeat bgi-position-x-center"
                     style="background-position-y: calc(100% + 5rem); background-image: url(<?php echo $ct_assets; ?>images/forgot_password_page_bg.png)">
                </div>
                <!--end::Aside Bottom-->
            </div>
            <!--begin::Aside-->

            <!--begin::Content-->
            <div class="login-content flex-column-fluid d-flex flex-column p-10">

                <!--begin::Wrapper-->
                <div class="d-flex flex-row-fluid flex-center">
                    <!--begin::Forgot-->
                    <div class="login-form">
                        <!--begin::Form-->
                        <form class="form" id="kt_login_forgot_form">
                            <input type="hidden" id="action" name="action" value="request_password_reset">
                            <!--begin::Title-->
                            <div>
                                <h3 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">Forgotten Password
                                    ?</h3>
                                <p class="text-muted font-weight-bold m-0">Enter your email to reset your
                                    password</p>
                            </div>
                            <div class="error_alert_wrapper" id="accessDeniedMessage"
                                 style="height:50px !important;"></div>
                            <!--end::Title-->

                            <!--begin::Form group-->
                            <div class="form-group">
                                <input type="email" id="email"
                                       class="form-control h-auto py-7 px-6 rounded-lg font-size-h6 user-inputs"
                                       onblur="change_color(this.value, this.id)"
                                       placeholder="Type your Email" name="email" autocomplete="off">
                                <div class="error_wrapper">
                                    <span class="text-danger" id="errorMessageEmail"></span>
                                </div>
                            </div>
                            <!--end::Form group-->

                            <!--begin::Form group-->

                            <div class="form_full_line ">
                                <button type="button" onclick="saveFORM()" id="kt_login_forgot_form_submit_button"
                                        class="btn btn-success float-right font-weight-bolder font-size-h6 px-6 py-4">
                                    Submit
                                </button>
                                <a href="<?php echo $base_url; ?>login" id="kt_login_forgot_cancel"
                                   class="btn btn-light-primary float-left font-weight-bolder font-size-h6 px-6 py-4 mr-2">
                                    ↩ Back to Login Page
                                </a>
                            </div>
                            <!--end::Form group-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Forgot-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Login-->
    </div>
<?php
include_once("includes/footer_script.php");
?>
    <script type="text/javascript">
        function saveFORM() {

            var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

            var email = document.getElementById('email');
            var action = document.getElementById('action');

            var errorMessageEmail = document.getElementById('errorMessageEmail');
            var accessDeniedMessage = document.getElementById('accessDeniedMessage');

            email.style.borderColor = '#d1d1d1';
            errorMessageEmail.innerText = accessDeniedMessage.innerHTML = "";


            if (email.value == '') {
                email.style.borderColor = '#F00';
                errorMessageEmail.innerText = "Email field is required.";
                return false;
            } else if (reg.test(email.value) == false) {
                email.style.borderColor = '#F00';
                errorMessageEmail.innerText = "Invalid Email Address.";
                return false;
            } else {
                loader(true);
                var postData = {"email": email.value, "action": action.value};
                $.ajax({
                    type: "POST", url: "ajax/request_password_reset.php",
                    data: {'postData': postData},
                    success: function (resPonse) {
                        if (resPonse !== undefined && resPonse != '') {
                            var obj = JSON.parse(resPonse);
                            if (obj.code === 422) {
                                if (obj.errorMessageEmail !== undefined && obj.errorMessageEmail != '') {
                                    email.style.borderColor = '#F00';
                                    errorMessageEmail.innerText = obj.errorMessageEmail;
                                }
                                loader(false);
                            } else if (obj.code === 405) {
                                if (obj.accessDeniedMessage !== undefined && obj.accessDeniedMessage != '') {
                                    accessDeniedMessage.innerHTML = '<span class="danger_alert d-block" >' + obj.accessDeniedMessage + '</span>';
                                }
                                loader(false);
                            } else if (obj.code === 200) {
                                if (obj.successMessage !== undefined && obj.successMessage != '') {
                                    accessDeniedMessage.innerHTML = '<span class="success_alert d-block" >' + obj.successMessage + '</span>';
                                    toasterTrigger('success', obj.successMessage);
                                }
                                loader(false);
                            }
                        } else {
                            loader(false);
                        }
                    }
                });
            }
        }

        function change_color(value, id) {
            if (value == '') {
                document.getElementById(id).style.borderColor = '#F00';
            } else {
                document.getElementById(id).style.borderColor = '#e2e2e2';
            }
        }
    </script>
<?php
include_once("includes/endTags.php");
?>