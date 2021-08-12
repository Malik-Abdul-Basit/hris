<?php
include_once('includes/connection.php');
if (isset($_SESSION['company_id'],
        $_SESSION['branch_id'],
        $_SESSION['employee_id'],
        $_SESSION['user_id'])
    && !empty($_SESSION['company_id'])
    && !empty($_SESSION['branch_id'])
    && !empty($_SESSION['employee_id'])
    && !empty($_SESSION['user_id'])) {
    header("location:admin/dashboard");
    exit();
}
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
                     style="background-position-y: calc(100% + 5rem); background-image: url(<?php echo $ct_assets; ?>images/login_page_bg.png)">
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
                            <input type="hidden" id="action" name="action" value="login">
                            <!--begin::Title-->
                            <div>
                                <h3 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">Sign In</h3>
                            </div>
                            <div class="error_alert_wrapper" id="accessDeniedMessage"
                                 style="height:50px !important;"></div>
                            <!--end::Title-->

                            <div class="form_full_line">
                                <div class="form-group fv-plugins-icon-container">
                                    <label class="font-size-h6 font-weight-bolder text-dark"> Email</label>
                                    <input tabindex="5" type="email" id="email"
                                           class="form-control h-auto py-7 px-6 rounded-lg user-inputs"
                                           name="email" autocomplete="off"
                                           onblur="change_color(this.value, this.id)"
                                           placeholder=" Email">
                                    <div class="error_wrapper">
                                        <span class="text-danger" id="errorMessageEmail"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="form_full_line">
                                <div class="form-group fv-plugins-icon-container">
                                    <div class="d-flex justify-content-between mt-n5">
                                        <label class="font-size-h6 font-weight-bolder text-dark pt-5"> Password</label>
                                        <a href="<?php echo $base_url; ?>forgot_password"
                                           class="text-primary font-size-h6 font-weight-bolder text-hover-primary pt-5">
                                            Forgot Password ?
                                        </a>
                                    </div>

                                    <input tabindex="10" type="password" id="password"
                                           class="form-control h-auto py-7 px-6 rounded-lg user-inputs"
                                           onblur="change_color(this.value, this.id)"
                                           placeholder="Password"
                                           name="password" autocomplete="off">
                                    <div class="error_wrapper">
                                        <span class="text-danger" id="errorMessagePassword"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="form_full_line ">
                                <button type="button" onclick="saveFORM()" id="kt_login_forgot_form_submit_button"
                                        class="btn btn-success float-right font-weight-bolder font-size-h6 px-6 py-4">
                                    Submit
                                </button>
                            </div>
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

        var input = document.getElementById("password");

        // Execute a function when the user releases a key on the keyboard
        input.addEventListener("keyup", function (event) {
            // Number 13 is the "Enter" key on the keyboard
            if (event.keyCode === 13) {
                // Cancel the default action, if needed
                event.preventDefault();
                // Trigger the button element with a click
                saveFORM();
                //document.getElementById("myBtn").click();
            }
        });

        function saveFORM() {
            var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

            var email = document.getElementById('email');
            var password = document.getElementById('password');
            var action = document.getElementById('action');

            var errorMessageEmail = document.getElementById('errorMessageEmail');
            var errorMessagePassword = document.getElementById('errorMessagePassword');
            var accessDeniedMessage = document.getElementById('accessDeniedMessage');

            email.style.borderColor = password.style.borderColor = '#d1d1d1';
            errorMessageEmail.innerText = errorMessagePassword.innerText = accessDeniedMessage.innerHTML = "";


            if (email.value == '') {
                email.style.borderColor = '#F00';
                errorMessageEmail.innerText = "Email field is required.";
                return false;
            } else if (reg.test(email.value) == false) {
                email.style.borderColor = '#F00';
                errorMessageEmail.innerText = "Invalid Email Address.";
                return false;
            } else if (password.value == '') {
                password.style.borderColor = '#F00';
                errorMessagePassword.innerText = "Password field is required.";
                return false;
            } else {
                loader(true);
                var postData = {"email": email.value, "password": password.value, "action": action.value};
                $.ajax({
                    type: "POST", url: "ajax/login.php",
                    data: {'postData': postData},
                    success: function (resPonse) {
                        if (resPonse !== undefined && resPonse != '') {
                            var obj = JSON.parse(resPonse);
                            if (obj.code === 422) {
                                if (obj.errorMessageEmail !== undefined && obj.errorMessageEmail != '') {
                                    email.style.borderColor = '#F00';
                                    errorMessageEmail.innerText = obj.errorMessageEmail;
                                } else if (obj.errorMessagePassword !== undefined && obj.errorMessagePassword != '') {
                                    password.style.borderColor = '#F00';
                                    errorMessagePassword.innerText = obj.errorMessagePassword;
                                }
                                loader(false);
                            } else if (obj.code === 405) {
                                if (obj.accessDeniedMessage !== undefined && obj.accessDeniedMessage != '') {
                                    accessDeniedMessage.innerHTML = '<span class="danger_alert d-block">' + obj.accessDeniedMessage + '</span>';
                                }
                                loader(false);
                            } else if (obj.code === 200) {
                                window.location = obj.page;
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

        function change_color(value, id) {
            if (value == '') {
                document.getElementById(id).style.borderColor = '#F00';
            } else {
                document.getElementById(id).style.borderColor = '#d1d1d1';
            }
        }
    </script>
<?php
include_once("includes/endTags.php");
?>