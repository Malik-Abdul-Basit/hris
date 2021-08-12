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
                                                    $Q = "SELECT * FROM `branches` WHERE `id`='{$id}' AND `company_id`='{$global_company_id}' AND `deleted_at` IS NULL";
                                                    $Qry = mysqli_query($db, $Q);
                                                    $Rows = mysqli_num_rows($Qry);
                                                    if ($Rows != 1) {
                                                        header('Location: ' . $page_not_found_url);
                                                        exit();
                                                    } else {
                                                        $Result = mysqli_fetch_object($Qry);
                                                        $name = html_entity_decode(stripslashes($Result->name));
                                                        $company_email = html_entity_decode(stripslashes($Result->company_email));
                                                        $hr_email = html_entity_decode(stripslashes($Result->hr_email));
                                                        $other_email = html_entity_decode(stripslashes($Result->other_email));
                                                        $dial_code = html_entity_decode(stripslashes($Result->dial_code));
                                                        $mobile = html_entity_decode(stripslashes($Result->mobile));
                                                        $iso = html_entity_decode(stripslashes($Result->iso));
                                                        $phone = html_entity_decode(stripslashes($Result->phone));
                                                        $fax = html_entity_decode(stripslashes($Result->fax));
                                                        $web = html_entity_decode(stripslashes($Result->web));
                                                        $address = html_entity_decode(stripslashes($Result->address));
                                                        $status = html_entity_decode(stripslashes($Result->status));
                                                        $type = html_entity_decode(stripslashes($Result->type));
                                                        $company_id = html_entity_decode(stripslashes($Result->company_id));
                                                        $country_id = html_entity_decode(stripslashes($Result->country_id));
                                                        $state_id = html_entity_decode(stripslashes($Result->state_id));
                                                        $city_id = html_entity_decode(stripslashes($Result->city_id));
                                                    }
                                                } else {
                                                    if (!hasRight($user_right_title, 'add')) {
                                                        header('Location: ' . $page_not_found_url);
                                                        exit();
                                                    }
                                                    echo 'Add ' . ucwords(str_replace("_", " ", $page));
                                                    $id = $country_id = $state_id = $city_id = 0;
                                                    $name = $company_email = $hr_email = $other_email = '';
                                                    $mobile = $phone = $fax = $web = $address = $type = '';
                                                    $dial_code = '92';
                                                    $iso = 'pk';

                                                    $status = config('branches.status.value.working');
                                                }
                                                $mobile_no_flag = '<img class="mr-1" src="' . $ct_assets . 'images/flags/' . $iso . '.png">+' . $dial_code;
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
                                                                    <input tabindex="5" maxlength="50" id="name"
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
                                                                    <label>* Company Email:</label>
                                                                    <input tabindex="10" id="company_email"
                                                                           value="<?php echo $company_email; ?>" <?php echo $TAttrs . $onblur; ?>
                                                                           placeholder="Company Email"/>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageCompanyEmail"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>* HR Email:</label>
                                                                    <input tabindex="15" id="hr_email"
                                                                           value="<?php echo $hr_email; ?>" <?php echo $TAttrs . $onblur; ?>
                                                                           placeholder="HR Email"/>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageHREmail"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label> Other Email:</label>
                                                                    <input tabindex="20" id="other_email"
                                                                           value="<?php echo $other_email; ?>" <?php echo $TAttrs; ?>
                                                                           placeholder="Other Email"/>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageOtherEmail"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>* Select Country:</label>
                                                                    <select tabindex="25" onchange="getStates(event)"
                                                                            id="country_id" <?php echo $TAttrs . $onblur; ?>>
                                                                        <option selected="selected" value="">Select
                                                                        </option>
                                                                        <?php
                                                                        $select = "SELECT * FROM `countries`";
                                                                        $query = mysqli_query($db, $select);
                                                                        if (mysqli_num_rows($query) > 0) {
                                                                            while ($result = mysqli_fetch_object($query)) {
                                                                                $selected = '';
                                                                                if ($country_id == $result->id) {
                                                                                    $selected = 'selected="selected"';
                                                                                }
                                                                                ?>
                                                                                <option data-dial_code="<?php echo $result->dial_code; ?>"
                                                                                        data-iso="<?php echo strtolower($result->iso); ?>" <?php echo $selected; ?>
                                                                                        value="<?php echo $result->id; ?>"><?php echo $result->country_name; ?></option>
                                                                                <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageCountry"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>* Select State:</label>
                                                                    <select tabindex="30" onchange="getCities(event)"
                                                                            id="state_id" <?php echo $TAttrs . $onblur; ?>>
                                                                        <?php
                                                                        if (!empty($country_id)) {
                                                                            echo getStates($country_id, $state_id);
                                                                        } else {
                                                                            echo '<option selected="selected" value="">Select
                                                                        </option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageState"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>* Select City:</label>
                                                                    <select tabindex="35"
                                                                            id="city_id" <?php echo $TAttrs . $onblur; ?>>
                                                                        <?php
                                                                        if (!empty($country_id) && !empty($state_id)) {
                                                                            echo getCities($state_id, $city_id);
                                                                        } else {
                                                                            echo '<option selected="selected" value="">Select
                                                                        </option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageCity"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>* Mobile No:
                                                                        <small>
                                                                            <a href="javascript:;">Example 300 777
                                                                                8888</a>
                                                                        </small>
                                                                    </label>
                                                                    <input tabindex="-1" id="dial_code"
                                                                           class="not-display" type="hidden"
                                                                           value="<?php echo $dial_code; ?>">
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend"><span
                                                                                    class="input-group-text"
                                                                                    id="mobile_no_flag"><?php echo $mobile_no_flag; ?></span>
                                                                        </div>
                                                                        <input tabindex="40" maxlength="12" id="mobile"
                                                                               value="<?php echo $mobile; ?>" <?php echo $TAttrs . $onblur; ?>
                                                                               placeholder="Mobile No"/>
                                                                    </div>
                                                                    <input tabindex="-2" id="iso" class="not-display"
                                                                           type="hidden"
                                                                           value="<?php echo $iso; ?>">
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageMobile"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>Phone No:
                                                                        <small>
                                                                            <a href="javascript:;">Example (041)
                                                                                233-3333</a>
                                                                        </small>
                                                                    </label>

                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend"><span
                                                                                    class="input-group-text"><i
                                                                                        class="la la-phone"></i></span>
                                                                        </div>
                                                                        <input tabindex="45" maxlength="14" id="phone"
                                                                               value="<?php echo $phone; ?>" <?php echo $TAttrs; ?>
                                                                               placeholder="Phone No"/>
                                                                    </div>

                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessagePhone"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>Fax:
                                                                        <small>
                                                                            <a href="javascript:;">Example (041)
                                                                                233-3333</a>
                                                                        </small>
                                                                    </label>

                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend"><span
                                                                                    class="input-group-text"><i
                                                                                        class="fas fa-fax"></i></span>
                                                                        </div>

                                                                        <input tabindex="50" maxlength="14" id="fax"
                                                                               value="<?php echo $fax; ?>" <?php echo $TAttrs; ?>
                                                                               placeholder="Fax"/>
                                                                    </div>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageFax"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Web:</label>
                                                                    <input tabindex="55" id="web"
                                                                           value="<?php echo $web; ?>" <?php echo $TAttrs; ?>
                                                                           placeholder="Web"/>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageWeb"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>* Status:</label>
                                                                    <select tabindex="60"
                                                                            id="status" <?php echo $TAttrs . $onblur; ?>>
                                                                        <option selected="selected" value="">Select
                                                                        </option>
                                                                        <?php
                                                                        foreach (config('branches.status.title') as $key => $value) {
                                                                            $selected = '';
                                                                            if ($status == $key) {
                                                                                $selected = 'selected="selected"';
                                                                            }
                                                                            ?>
                                                                            <option <?php echo $selected; ?>
                                                                                    value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageStatus"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>* Type:</label>
                                                                    <select tabindex="65"
                                                                            id="type" <?php echo $TAttrs . $onblur; ?>>
                                                                        <option selected="selected" value="">Select
                                                                        </option>
                                                                        <?php
                                                                        foreach (config('branches.type.title') as $key => $value) {
                                                                            $selected = '';
                                                                            if ($type == $key) {
                                                                                $selected = 'selected="selected"';
                                                                            }
                                                                            ?>
                                                                            <option <?php echo $selected; ?>
                                                                                    value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageType"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>* Address:</label>
                                                                    <textarea tabindex="75" rows="10"
                                                                              id="address" <?php echo $TAttrs . $onblur; ?> placeholder="Address"><?php echo $address; ?></textarea>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageAddress"></span>
                                                                    </div>
                                                                </div>
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

            var checkValidName = /[^a-zA-Z0-9-.@_&' ]/;
            var validEmail = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
            var validContactNumber = /^[\-)( ]*([0-9]{3})[\-)( ]*([0-9]{3})[\-)( ]*([0-9]{4})$/;
            var validURL = /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i;
            var validAddress = /[^a-zA-Z0-9+-._,@&#' ]/;
            var statusArray = [<?php echo '"'.implode('","', array_values(config('branches.status.value'))).'"' ?>];
            var typeArray = [<?php echo '"'.implode('","', array_values(config('branches.type.value'))).'"' ?>];

            var id = document.getElementById('id');
            var A = '<?php echo hasRight($user_right_title, 'add') ?>';
            var E = '<?php echo hasRight($user_right_title, 'edit') ?>';
            var name = document.getElementById('name');
            var company_email = document.getElementById('company_email');
            var hr_email = document.getElementById('hr_email');
            var other_email = document.getElementById('other_email');
            var country_id = document.getElementById('country_id');
            var state_id = document.getElementById('state_id');
            var city_id = document.getElementById('city_id');
            var dial_code = document.getElementById('dial_code');
            var mobile = document.getElementById('mobile');
            var iso = document.getElementById('iso');
            var phone = document.getElementById('phone');
            var fax = document.getElementById('fax');
            var web = document.getElementById('web');
            var status = document.getElementById('status');
            var type = document.getElementById('type');
            var address = document.getElementById('address');

            var errorMessageName = document.getElementById('errorMessageName');
            var errorMessageCompanyEmail = document.getElementById('errorMessageCompanyEmail');
            var errorMessageHREmail = document.getElementById('errorMessageHREmail');
            var errorMessageOtherEmail = document.getElementById('errorMessageOtherEmail');
            var errorMessageCountry = document.getElementById('errorMessageCountry');
            var errorMessageState = document.getElementById('errorMessageState');
            var errorMessageCity = document.getElementById('errorMessageCity');
            var errorMessageMobile = document.getElementById('errorMessageMobile');
            var errorMessagePhone = document.getElementById('errorMessagePhone');
            var errorMessageFax = document.getElementById('errorMessageFax');
            var errorMessageWeb = document.getElementById('errorMessageWeb');
            var errorMessageStatus = document.getElementById('errorMessageStatus');
            var errorMessageType = document.getElementById('errorMessageType');
            var errorMessageAddress = document.getElementById('errorMessageAddress');

            name.style.borderColor = company_email.style.borderColor = hr_email.style.borderColor = other_email.style.borderColor = '#E4E6EF';
            country_id.style.borderColor = state_id.style.borderColor = city_id.style.borderColor = '#E4E6EF';
            mobile.style.borderColor = phone.style.borderColor = fax.style.borderColor = web.style.borderColor = '#E4E6EF';
            status.style.borderColor = type.style.borderColor = address.style.borderColor = '#E4E6EF';

            errorMessageName.innerText = errorMessageCompanyEmail.innerText = errorMessageHREmail.innerText = errorMessageOtherEmail.innerText = "";
            errorMessageCountry.innerText = errorMessageState.innerText = errorMessageCity.innerText = "";
            errorMessageMobile.innerText = errorMessagePhone.innerText = errorMessageFax.innerText = "";
            errorMessageWeb.innerText = errorMessageStatus.innerText = errorMessageType.innerText = errorMessageAddress.innerText = "";

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
            } else if (company_email.value == '') {
                company_email.style.borderColor = '#F00';
                errorMessageCompanyEmail.innerText = "Company Email field is required.";
                return false;
            } else if (validEmail.test(company_email.value) == false) {
                company_email.style.borderColor = '#F00';
                errorMessageCompanyEmail.innerText = "Invalid Email Address.";
                return false;
            } else if (hr_email.value == '') {
                hr_email.style.borderColor = '#F00';
                errorMessageHREmail.innerText = "HR Email field is required.";
                return false;
            } else if (validEmail.test(hr_email.value) == false) {
                hr_email.style.borderColor = '#F00';
                errorMessageHREmail.innerText = "Invalid Email Address.";
                return false;
            } else if (other_email.value != '' && validEmail.test(other_email.value) == false) {
                other_email.style.borderColor = '#F00';
                errorMessageOtherEmail.innerText = "Invalid Email Address.";
                return false;
            } else if (country_id.value == '') {
                country_id.style.borderColor = '#F00';
                errorMessageCountry.innerText = "Country field is required.";
                return false;
            } else if (isNaN(country_id.value) === true || country_id.value < 1 || country_id.value.length > 10) {
                country_id.style.borderColor = '#F00';
                errorMessageCountry.innerText = "Please select a valid option.";
                return false;
            } else if (state_id.value == '') {
                state_id.style.borderColor = '#F00';
                errorMessageState.innerText = "State field is required.";
                return false;
            } else if (isNaN(state_id.value) === true || state_id.value < 1 || state_id.value.length > 10) {
                state_id.style.borderColor = '#F00';
                errorMessageState.innerText = "Please select a valid option.";
                return false;
            } else if (city_id.value == '') {
                city_id.style.borderColor = '#F00';
                errorMessageCity.innerText = "City field is required.";
                return false;
            } else if (isNaN(city_id.value) === true || city_id.value < 1 || city_id.value.length > 10) {
                city_id.style.borderColor = '#F00';
                errorMessageCity.innerText = "Please select a valid option.";
                return false;
            } else if (mobile.value == '') {
                mobile.style.borderColor = '#F00';
                errorMessageMobile.innerText = "Mobile field is required.";
                return false;
            } else if (validContactNumber.test(mobile.value) == false || mobile.value.length != 12) {
                mobile.style.borderColor = '#F00';
                errorMessageMobile.innerText = "Invalid Mobile No.";
                return false;
            } else if (phone.value != '' && (validContactNumber.test(phone.value) == false || phone.value.length != 14)) {
                phone.style.borderColor = '#F00';
                errorMessagePhone.innerText = "Invalid Phone number.";
                return false;
            } else if (fax.value != '' && (validContactNumber.test(fax.value) == false || fax.value.length != 14)) {
                fax.style.borderColor = '#F00';
                errorMessageFax.innerText = "Invalid Fax number.";
                return false;
            } else if (web.value != '' && validURL.test(web.value) == false) {
                web.style.borderColor = '#F00';
                errorMessageWeb.innerText = "Invalid Web link.";
                return false;
            } else if (status.value == '') {
                status.style.borderColor = '#F00';
                errorMessageStatus.innerText = "Status field is required.";
                return false;
            } else if (statusArray.includes(status.value) == false || status.value.length > 2) {
                status.style.borderColor = '#F00';
                errorMessageStatus.innerText = "Please select a valid option.";
                return false;
            } else if (type.value == '') {
                type.style.borderColor = '#F00';
                errorMessageType.innerText = "Type field is required.";
                return false;
            } else if (typeArray.includes(type.value) == false || type.value.length > 2) {
                type.style.borderColor = '#F00';
                errorMessageType.innerText = "Please select a valid option.";
                return false;
            } else if (address.value == '') {
                address.style.borderColor = '#F00';
                errorMessageAddress.innerText = "Address field is required.";
                return false;
            } else if (validAddress.test(address.value)) {
                address.style.borderColor = '#F00';
                errorMessageAddress.innerText = "Special Characters are not Allowed.";
                return false;
            } else {
                loader(true);
                var postData = {
                    "id": id.value,
                    "name": name.value,
                    "company_email": company_email.value,
                    "hr_email": hr_email.value,
                    "other_email": other_email.value,
                    "country_id": country_id.value,
                    "state_id": state_id.value,
                    "city_id": city_id.value,
                    "dial_code": dial_code.value,
                    "mobile": mobile.value,
                    "iso": iso.value,
                    "phone": phone.value,
                    "fax": fax.value,
                    "web": web.value,
                    "status": status.value,
                    "type": type.value,
                    "address": address.value,
                    "user_right_title": '<?php echo $user_right_title; ?>'
                };
                $.ajax({
                    type: "POST", url: "ajax/branch.php",
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
                                    }
                                } else if (obj.code === 405 || obj.code === 200) {
                                    if (obj.responseMessage !== undefined && obj.responseMessage != '') {
                                        if (obj.form_reset !== undefined && obj.form_reset) {
                                            document.getElementById("myFORM").reset();
                                            var select2_country_id_container = document.getElementById("select2-country_id-container");
                                            var select2_state_id_container = document.getElementById("select2-state_id-container");
                                            var select2_city_id_container = document.getElementById("select2-city_id-container");
                                            if (select2_country_id_container && select2_state_id_container && select2_city_id_container) {
                                                select2_country_id_container.removeAttribute("title");
                                                select2_state_id_container.removeAttribute("title");
                                                select2_city_id_container.removeAttribute("title");
                                                select2_country_id_container.innerHTML = select2_state_id_container.innerHTML = select2_city_id_container.innerHTML = '<span class="select2-selection__placeholder">Select</span>';
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
    </script>
<?php include_once("../includes/endTags.php"); ?>