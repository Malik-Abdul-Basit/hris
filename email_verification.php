<?php
include_once('includes/connection.php');
if (!isset($_SESSION['company_id']) || !isset($_SESSION['employee_id']) || empty($_SESSION['company_id']) || empty($_SESSION['employee_id'])) {
    header("location:login");
} else {
    $employee_id = $_SESSION['employee_id'];
    $employeeInfo = getEmployeeInfoFromId($employee_id);

    if(!empty($employeeInfo->email_verified_at)){
        header("location:login");
        exit();
    }

    $verified = false;
    $message = '';

    if (isset($_GET['signature'], $_GET['code'], $_GET['ei'])
        && !empty($_GET['signature'])
        && !empty($_GET['code'])
        && !empty($_GET['ei'])
        && !empty($employeeInfo->signed_url)
        && !empty($employeeInfo->verification_code)
        && $employeeInfo->signed_url == $_GET['signature']
        && $employeeInfo->verification_code == $_GET['code']
        && $employee_id == $_GET['ei']
    ) {
        if (empty($employeeInfo->email_verified_at)) {
            $now = date('Y-m-d H:i:s');
            mysqli_query($db, "UPDATE `users` SET `email_verified_at`='{$now}' WHERE `id`='{$employeeInfo->user_id}'");
            mysqli_query($db, "UPDATE `email_verification_details` SET `deleted_at`='{$now}' WHERE `id`='{$employeeInfo->email_verification_detail_id}'");
            $verified = true;
            $message = 'Your email successfully verified.';
        } else {
            $verified = true;
            $message = 'Your email already verified.';
        }
    }
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
                     style="background-position-y: calc(100% + 5rem); background-image: url(<?php echo $ct_assets; ?>images/email_verification_page_bg.png)">
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
                            <input type="hidden" id="action" name="action" value="email_verification">
                            <!--begin::Title-->
                            <div>
                                <h3 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">Confirm Your
                                    Email</h3>
                                <p class="text-muted font-weight-bold m-0">Please check your inbox for confirmation
                                    email. Click the link in the email to confirm your email address.</p>
                            </div>
                            <div class="error_alert_wrapper" id="accessDeniedMessage"
                                 style="height:50px !important;">
                                <?php
                                if($verified){
                                    echo '<span class="success_alert d-block">'.$message.'</span>';
                                }
                                ?>

                            </div>
                            <!--end::Title-->

                            <!--begin::Form group-->

                            <div class="form_full_line ">
                                <?php
                                if($verified === false ){
                                    ?>
                                    <button type="button" onclick="resendEmail()"
                                            id="kt_email_verification_resend_email_button"
                                            class="btn btn-success float-right font-weight-bolder font-size-h6 px-6 py-4">
                                        Resend Email &nbsp; <i class="icon-md far fa-paper-plane"></i>
                                    </button>
                                    <?php
                                }
                                ?>

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
        function resendEmail() {
            var emp_id = '<?php echo $_SESSION['employee_id']; ?>';
            if (emp_id != '' && isNaN(emp_id) === false && emp_id > 0) {
                loader(true);
                var postData = {"employee_id": emp_id};
                $.ajax({
                    type: "POST", url: "ajax/email_verification.php",
                    data: {'postData': postData, 'resendEmail': true},
                    success: function (resPonse) {
                        if (resPonse !== undefined && resPonse != '') {
                            var obj = JSON.parse(resPonse);
                            if (obj.code !== undefined && obj.code != '' && obj.code == 200) {
                                toasterTrigger('success', obj.successMessage);
                            } else if (obj.code !== undefined && obj.code != '' && obj.code == 405) {
                                toasterTrigger('success', obj.accessDeniedMessage);
                            }
                            loader(false);
                        } else {
                            window.location = 'login';
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
                document.getElementById(id).style.borderColor = '#e2e2e2';
            }
        }
    </script>
<?php
include_once("includes/endTags.php");
?>