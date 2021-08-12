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
                                                    $Q = "SELECT em.*, eb.*, ep.* 
                                                        FROM 
                                                        employees AS em 
                                                        INNER JOIN 
                                                        employee_basic_infos AS eb 
                                                        ON em.id = eb.employee_id
                                                        LEFT JOIN
                                                        employee_payrolls AS  ep
                                                        ON em.id = ep.employee_id
                                                        WHERE 
                                                        em.id='{$id}' AND eb.employee_id='{$id}' AND em.company_id='{$global_company_id}' 
                                                        AND em.branch_id='{$global_branch_id}' AND em.deleted_at IS NULL";
                                                    $Qry = mysqli_query($db, $Q);
                                                    $Rows = mysqli_num_rows($Qry);
                                                    if ($Rows != 1) {
                                                        header('Location: ' . $page_not_found_url);
                                                        exit();
                                                    } else {
                                                        $Result = mysqli_fetch_object($Qry);
                                                        $employee_code = html_entity_decode(stripslashes($Result->employee_code));
                                                        $status = html_entity_decode(stripslashes($Result->status));
                                                        $department_id = html_entity_decode(stripslashes($Result->department_id));
                                                        $team_id = html_entity_decode(stripslashes($Result->team_id));
                                                        $designation_id = html_entity_decode(stripslashes($Result->designation_id));
                                                        $shift_id = html_entity_decode(stripslashes($Result->shift_id));
                                                        $evaluation_type_id = html_entity_decode(stripslashes($Result->evaluation_type_id));

                                                        $title = html_entity_decode(stripslashes($Result->title));
                                                        $first_name = html_entity_decode(stripslashes($Result->first_name));
                                                        $last_name = html_entity_decode(stripslashes($Result->last_name));
                                                        $pseudo_name = html_entity_decode(stripslashes($Result->pseudo_name));
                                                        $father_name = html_entity_decode(stripslashes($Result->father_name));
                                                        $email = html_entity_decode(stripslashes($Result->email));
                                                        $official_email = html_entity_decode(stripslashes($Result->official_email));
                                                        $gender = html_entity_decode(stripslashes($Result->gender));
                                                        $blood_group = html_entity_decode(stripslashes($Result->blood_group));
                                                        $dob = html_entity_decode(stripslashes(date('d-m-Y', strtotime($Result->dob))));
                                                        $pob = html_entity_decode(stripslashes($Result->pob));
                                                        $cnic = html_entity_decode(stripslashes($Result->cnic));
                                                        $cnic_expiry = !empty($Result->cnic_expiry) && $Result->cnic_expiry != '0000-00-00' ? html_entity_decode(stripslashes(date('d-m-Y', strtotime($Result->cnic_expiry)))) : '';
                                                        $old_cnic = html_entity_decode(stripslashes($Result->old_cnic));
                                                        $phone = html_entity_decode(stripslashes($Result->phone));
                                                        $dial_code = html_entity_decode(stripslashes($Result->dial_code));
                                                        $mobile = html_entity_decode(stripslashes($Result->mobile));
                                                        $iso = html_entity_decode(stripslashes($Result->iso));
                                                        $o_dial_code = html_entity_decode(stripslashes($Result->o_dial_code));
                                                        $other_mobile = html_entity_decode(stripslashes($Result->other_mobile));
                                                        $o_iso = html_entity_decode(stripslashes($Result->o_iso));
                                                        $relation = html_entity_decode(stripslashes($Result->relation));
                                                        $country_id = html_entity_decode(stripslashes($Result->country_id));
                                                        $state_id = html_entity_decode(stripslashes($Result->state_id));
                                                        $city_id = html_entity_decode(stripslashes($Result->city_id));
                                                        $address = html_entity_decode(stripslashes($Result->address));
                                                        $permanent_address = html_entity_decode(stripslashes($Result->permanent_address));
                                                        $personal_history = html_entity_decode(stripslashes($Result->personal_history));
                                                        $marital_status = html_entity_decode(stripslashes($Result->marital_status));
                                                        $religion = html_entity_decode(stripslashes($Result->religion));
                                                        $sect = html_entity_decode(stripslashes($Result->sect));

                                                        $guardian_name = html_entity_decode(stripslashes($Result->guardian_name));
                                                        $guardian_dial_code = html_entity_decode(stripslashes($Result->guardian_dial_code));
                                                        $guardian_mobile = html_entity_decode(stripslashes($Result->guardian_mobile));
                                                        $guardian_iso = html_entity_decode(stripslashes($Result->guardian_iso));
                                                        $guardian_cnic = html_entity_decode(stripslashes($Result->guardian_cnic));
                                                        $guardian_relation = html_entity_decode(stripslashes($Result->guardian_relation));

                                                        $joining_date = !empty($Result->joining_date) && $Result->joining_date != '0000-00-00' ? date('d-m-Y', strtotime($Result->joining_date)) : '';
                                                        $contract_start_date = !empty($Result->contract_start_date) && $Result->contract_start_date != '0000-00-00' ? date('d-m-Y', strtotime($Result->contract_start_date)) : '';
                                                        $contract_end_date = !empty($Result->contract_end_date) && $Result->contract_end_date != '0000-00-00' ? date('d-m-Y', strtotime($Result->contract_end_date)) : '';
                                                        $leaving_date = !empty($Result->leaving_date) && $Result->leaving_date != '0000-00-00' ? date('d-m-Y', strtotime($Result->leaving_date)) : '';
                                                        $salary = !empty($Result->salary) ? decode(html_entity_decode(stripslashes($Result->salary))) : '';

                                                        $mobile_no_flag = '<img class="mr-1" src="' . $ct_assets . 'images/flags/' . $iso . '.png">+' . $dial_code;
                                                        $other_mobile_no_flag = '<img class="mr-1" src="' . $ct_assets . 'images/flags/' . $o_iso . '.png">+' . $o_dial_code;
                                                        $guardian_mobile_no_flag = '<img class="mr-1" src="' . $ct_assets . 'images/flags/' . $guardian_iso . '.png">+' . $guardian_dial_code;
                                                    }
                                                } else {
                                                    if (!hasRight($user_right_title, 'add')) {
                                                        header('Location: ' . $page_not_found_url);
                                                        exit();
                                                    }
                                                    echo 'Add ' . ucwords(str_replace("_", " ", $page));

                                                    $Q = "SELECT MAX(employee_code)+1 AS employee_code FROM employees";
                                                    $Qry = mysqli_query($db, $Q);
                                                    if (mysqli_num_rows($Qry) > 0) {
                                                        $Result = mysqli_fetch_object($Qry);
                                                        $employee_code = $Result->employee_code;
                                                    } else {
                                                        $employee_code = '1';
                                                    }

                                                    $id = $department_id = $team_id = $designation_id = $shift_id = $state_id = $city_id = $evaluation_type_id = 0;
                                                    $country_id = 166;
                                                    $status = config('employees.status.value.working');

                                                    $title = $first_name = $last_name = $pseudo_name = $father_name = $email = $official_email = $gender = $blood_group = $dob = $pob = $cnic = $cnic_expiry = $old_cnic = '';
                                                    $phone = $mobile = $other_mobile = $relation = $marital_status = $religion = $sect = $address = $permanent_address = $personal_history = '';
                                                    $guardian_name = $guardian_mobile = $guardian_cnic = $guardian_relation = '';
                                                    $joining_date = $contract_start_date = $contract_end_date = $leaving_date = $salary = '';
                                                    $dial_code = $o_dial_code = $guardian_dial_code = '92';
                                                    $iso = $o_iso = $guardian_iso = 'pk';

                                                    $mobile_no_flag = $other_mobile_no_flag = $guardian_mobile_no_flag = '<img class="mr-1" src="' . $ct_assets . 'images/flags/' . $iso . '.png">+' . $dial_code;
                                                }
                                                $NAttrs = ' type="number" class="form-control" ';
                                                //$DateInput = ' type="text" class="form-control DMY_dateOnly" maxlength="10" ';
                                                $DateInput = '  type="text" class="DatePicker e-input form-control" onkeypress="openCalendar(event)" onfocus="openCalendar(event)" onclick="openCalendar(event)" maxlength="10" data-format="dd-MM-yyyy" ';
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
                                                    <h3 class="font-size-lg text-dark-75 font-weight-bold mb-10">
                                                        Account Information:</h3>
                                                    <div class="mb-2">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>* Employee Code:</label>
                                                                    <input tabindex="5" maxlength="20"
                                                                           onkeypress="allowNumberOnly(event)"
                                                                           id="employee_code"
                                                                           value="<?php echo $employee_code; ?>" <?php echo $TAttrs . $onblur; ?>
                                                                           placeholder="Employee Code"/>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageEmployeeCode"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>* Department:</label>
                                                                    <select tabindex="10" class="form-control select2"
                                                                            onchange="getTeamsAndDesignations(event)"
                                                                            id="department_id" <?php $onblur; ?>>
                                                                        <option selected="selected" value="">Select
                                                                        </option>
                                                                        <?php
                                                                        $select = "SELECT `id`, `name` FROM `departments` WHERE `company_id`='{$global_company_id}' AND `branch_id`='{$global_branch_id}' AND `deleted_at` IS NULL ORDER BY `sort_by` ASC";
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
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Team:</label>
                                                                    <select tabindex="15"
                                                                            id="team_id" <?php echo $TAttrs . $onblur; ?>>
                                                                        <?php echo getTeams($team_id, $global_company_id, $global_branch_id, 0); ?>
                                                                    </select>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageTeam"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>* Designation:</label>
                                                                    <select tabindex="20"
                                                                            id="designation_id" <?php echo $TAttrs . $onblur; ?>>
                                                                        <?php
                                                                        if (!empty($department_id)) {
                                                                            echo getDesignations($department_id, $designation_id, $global_company_id, $global_branch_id);
                                                                        } else {
                                                                            echo '<option selected="selected" value="">Select
                                                                        </option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageDesignation"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>* Shift:</label>
                                                                    <select tabindex="25"
                                                                            id="shift_id" <?php echo $TAttrs . $onblur; ?>>
                                                                        <option selected="selected" value="">Select
                                                                        </option>
                                                                        <?php
                                                                        $select = "SELECT * FROM `shifts` WHERE `company_id`='{$global_company_id}' AND `branch_id`='{$global_branch_id}' AND `deleted_at` IS NULL ORDER BY `sort_by` ASC";
                                                                        $query = mysqli_query($db, $select);
                                                                        if (mysqli_num_rows($query) > 0) {
                                                                            while ($result = mysqli_fetch_object($query)) {
                                                                                $selected = '';
                                                                                if ($shift_id == $result->id) {
                                                                                    $selected = 'selected="selected"';
                                                                                }
                                                                                ?>
                                                                                <option <?php echo $selected; ?>
                                                                                        value="<?php echo $result->id; ?>">
                                                                                    <?php echo $result->name; ?>
                                                                                    <small><?php echo date('h:i A', strtotime($result->from)); ?>
                                                                                        - <?php echo date('h:i A', strtotime($result->to)); ?></small>
                                                                                </option>
                                                                                <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageShift"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>* Status:</label>
                                                                    <select tabindex="30"
                                                                            id="status" <?php echo $TAttrs . $onblur; ?>>
                                                                        <option selected="selected" value="">Select
                                                                        </option>
                                                                        <?php
                                                                        foreach (config("employees.status.title") as $key => $value) {
                                                                            $selected = $status == $key ? 'selected="selected"' : '';
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
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>* Evaluation Type:</label>
                                                                    <select tabindex="45"
                                                                            id="evaluation_type_id" <?php echo $TAttrs . $onblur; ?>>
                                                                        <option selected="selected" value="">
                                                                            Select
                                                                        </option>
                                                                        <?php
                                                                        $select = "SELECT `id`,`name` FROM `evaluation_types` WHERE `company_id`='{$global_company_id}' AND `branch_id`='{$global_branch_id}' AND `deleted_at` IS NULL ORDER BY `sort_by` ASC";
                                                                        $query = mysqli_query($db, $select);
                                                                        if (mysqli_num_rows($query) > 0) {
                                                                            while ($result = mysqli_fetch_object($query)) {
                                                                                $selected = '';
                                                                                if ($evaluation_type_id == $result->id) {
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
                                                                              id="errorMessageEvaluationType"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="separator separator-dashed my-10"></div>

                                                <div class="mb-3">
                                                    <h3 class="font-size-lg text-dark-75 font-weight-bold mb-10"> Basic
                                                        Information:</h3>
                                                    <div class="mb-2">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>* Title:</label>
                                                                    <select tabindex="50"
                                                                            id="title" <?php echo $TAttrs . $onblur; ?>>
                                                                        <option selected="selected" value="">Select
                                                                        </option>
                                                                        <?php
                                                                        foreach (config("employee_basic_infos.title.title") as $key => $value) {
                                                                            $selected = $title == $key ? 'selected="selected"' : '';
                                                                            ?>
                                                                            <option <?php echo $selected; ?>
                                                                                    value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageTitle"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>* First Name:</label>
                                                                    <input tabindex="55" maxlength="50" id="first_name"
                                                                           value="<?php echo $first_name; ?>" <?php echo $TAttrs . $onblur; ?>
                                                                           placeholder="First Name"/>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageFirstName"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label> Last Name:</label>
                                                                    <input tabindex="60" maxlength="50" id="last_name"
                                                                           value="<?php echo $last_name; ?>" <?php echo $TAttrs; ?>
                                                                           placeholder="Last Name"/>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageLastName"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label> Pseudo Name:</label>
                                                                    <input tabindex="65" maxlength="50" id="pseudo_name"
                                                                           value="<?php echo $pseudo_name; ?>" <?php echo $TAttrs; ?>
                                                                           placeholder="Pseudo Name"/>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessagePseudoName"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>* Father's Name:</label>
                                                                    <input tabindex="70" maxlength="50" id="father_name"
                                                                           value="<?php echo $father_name; ?>" <?php echo $TAttrs . $onblur; ?>
                                                                           placeholder="Father Name"/>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageFatherName"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>* Email:</label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend"><span
                                                                                    class="input-group-text"><i
                                                                                        class="la la-at"></i></span>
                                                                        </div>
                                                                        <input tabindex="75" id="email"
                                                                               value="<?php echo $email; ?>" <?php echo $TAttrs . $onblur; ?>
                                                                               placeholder="Email"/>
                                                                    </div>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageEmail"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>
                                                                        * Official Email:
                                                                        <small>
                                                                            <a href="javascript:;"
                                                                               onclick="sameAsAbove('email','official_email')">Same
                                                                                as Email</a>
                                                                        </small>
                                                                    </label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend"><span
                                                                                    class="input-group-text"><i
                                                                                        class="la la-at"></i></span>
                                                                        </div>
                                                                        <input tabindex="80" id="official_email"
                                                                               value="<?php echo $official_email; ?>" <?php echo $TAttrs . $onblur; ?>
                                                                               placeholder="Official Email"/>
                                                                    </div>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageOfficialEmail"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>* Gender:</label>
                                                                    <select tabindex="85"
                                                                            id="gender" <?php echo $TAttrs . $onblur; ?>>
                                                                        <option selected="selected" value="">Select
                                                                        </option>
                                                                        <?php
                                                                        foreach (config("employee_basic_infos.gender.title") as $key => $value) {
                                                                            $selected = $gender == $key ? 'selected="selected"' : '';
                                                                            ?>
                                                                            <option <?php echo $selected; ?>
                                                                                    value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageGender"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label>* Blood Group:</label>
                                                                    <select tabindex="90"
                                                                            id="blood_group" <?php echo $TAttrs . $onblur; ?>>
                                                                        <option selected="selected" value="">Select
                                                                        </option>
                                                                        <?php
                                                                        foreach (config("employee_basic_infos.blood_group.title") as $key => $value) {
                                                                            $selected = $blood_group == $key ? 'selected="selected"' : '';
                                                                            ?>
                                                                            <option <?php echo $selected; ?>
                                                                                    value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageBloodGroup"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label>* Date Of Birth:</label>
                                                                    <input tabindex="95" <?php echo $DateInput; ?>
                                                                           id="dob" placeholder="Date Of Birth"
                                                                           value="<?php echo $dob; ?>">
                                                                    <span class="e-clear-icon e-clear-icon-hide"
                                                                          aria-label="close" role="button"></span>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessagedob"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>Place of Birth:</label>
                                                                    <input tabindex="100" maxlength="50" id="pob"
                                                                           value="<?php echo $pob; ?>" <?php echo $TAttrs; ?>
                                                                           placeholder="Place of Birth"/>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessagepob"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label>* CNIC:</label>
                                                                    <input tabindex="105" maxlength="15" id="cnic"
                                                                           value="<?php echo $cnic; ?>" <?php echo $TAttrs . $onblur; ?>
                                                                           placeholder="CNIC"/>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageCNIC"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label> CNIC Expiry Date:</label>
                                                                    <input tabindex="110" <?php echo $DateInput; ?>
                                                                           id="cnic_expiry"
                                                                           placeholder="CNIC Expiry Date"
                                                                           value="<?php echo $cnic_expiry; ?>">
                                                                    <span class="e-clear-icon e-clear-icon-hide"
                                                                          aria-label="close" role="button"></span>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageCNICExpiry"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <!--<div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>Old CNIC:</label>-->
                                                            <input tabindex="500" type="hidden" class="not-display"
                                                                   maxlength="15" id="old_cnic"
                                                                   value="<?php echo $old_cnic; ?>" <?php //echo $TAttrs; ?>
                                                                   placeholder="Old CNIC"/>
                                                            <div class="not-display">
                                                                        <span class="text-danger"
                                                                              id="errorMessageOldCNIC"></span>
                                                            </div>
                                                            <!--</div>
                                                        </div>-->
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>* Select Country:</label>
                                                                    <select tabindex="120"
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
                                                                    <select tabindex="125" onchange="getCities(event)"
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
                                                                    <select tabindex="130"
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
                                                            <div class="col-md-3">
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
                                                                        <input tabindex="135" maxlength="14" id="phone"
                                                                               value="<?php echo $phone; ?>" <?php echo $TAttrs; ?>
                                                                               placeholder="Phone No"/>
                                                                    </div>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessagePhone"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>* Mobile No:
                                                                        <small>
                                                                            <a href="javascript:;">Example 300-777
                                                                                8888</a>
                                                                        </small>
                                                                    </label>
                                                                    <input tabindex="510" id="dial_code"
                                                                           class="not-display" type="hidden"
                                                                           value="<?php echo $dial_code; ?>">
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend"><span
                                                                                    class="input-group-text"
                                                                                    id="mobile_no_flag"><?php echo $mobile_no_flag; ?></span>
                                                                        </div>
                                                                        <input tabindex="140" maxlength="12" id="mobile"
                                                                               value="<?php echo $mobile; ?>" <?php echo $TAttrs . $onblur; ?>
                                                                               placeholder="Mobile No"/>
                                                                    </div>
                                                                    <input tabindex="520" id="iso" class="not-display"
                                                                           type="hidden"
                                                                           value="<?php echo $iso; ?>">
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageMobile"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>* Emergency Contact:
                                                                        <small>
                                                                            <a href="javascript:;">Example 300-777
                                                                                8888</a>
                                                                        </small>
                                                                    </label>
                                                                    <input tabindex="530" id="o_dial_code"
                                                                           class="not-display" type="hidden"
                                                                           value="<?php echo $o_dial_code; ?>">
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend"><span
                                                                                    class="input-group-text"
                                                                                    id="other_mobile_no_flag"><?php echo $other_mobile_no_flag; ?></span>
                                                                        </div>
                                                                        <input tabindex="145" maxlength="12"
                                                                               id="other_mobile"
                                                                               value="<?php echo $other_mobile; ?>" <?php echo $TAttrs . $onblur; ?>
                                                                               placeholder="Other Mobile No"/>
                                                                    </div>
                                                                    <input tabindex="540" id="o_iso" class="not-display"
                                                                           type="hidden"
                                                                           value="<?php echo $o_iso; ?>">
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageOtherMobile"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>* Relation <small>(With Emergency
                                                                            Contact)</small>:</label>
                                                                    <select tabindex="146"
                                                                            id="relation" <?php echo $TAttrs . $onblur; ?>>
                                                                        <option selected="selected" value="">Select
                                                                        </option>
                                                                        <?php
                                                                        foreach (config('employee_basic_infos.relation.title') as $key => $value) {
                                                                            $selected = $relation == $key ? 'selected="selected"' : '';
                                                                            ?>
                                                                            <option <?php echo $selected; ?>
                                                                                    value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageRelation"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>* Marital Status:</label>
                                                                    <select tabindex="150"
                                                                            id="marital_status" <?php echo $TAttrs . $onblur; ?>>
                                                                        <option selected="selected" value="">Select
                                                                        </option>
                                                                        <?php
                                                                        foreach (config("employee_basic_infos.marital_status.title") as $key => $value) {
                                                                            $selected = $marital_status == $key ? 'selected="selected"' : '';
                                                                            ?>
                                                                            <option <?php echo $selected; ?>
                                                                                    value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageMaritalStatus"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label> Religion:</label>
                                                                    <input tabindex="155" maxlength="50" id="religion"
                                                                           value="<?php echo $religion; ?>" <?php echo $TAttrs; ?>
                                                                           placeholder="Religion"/>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageReligion"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label> Sect:</label>
                                                                    <input tabindex="160" maxlength="50" id="sect"
                                                                           value="<?php echo $sect; ?>" <?php echo $TAttrs; ?>
                                                                           placeholder="Sect"/>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageSect"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>* Address:</label>
                                                                    <textarea tabindex="165" rows="4"
                                                                              id="address" <?php echo $TAttrs . $onblur; ?> placeholder="Address"><?php echo $address; ?></textarea>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageAddress"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>Permanent Address:
                                                                        <small>
                                                                            <a href="javascript:;"
                                                                               onclick="sameAsAbove('address','permanent_address')">Same
                                                                                as Address</a>
                                                                        </small>
                                                                    </label>
                                                                    <textarea tabindex="170" rows="4"
                                                                              id="permanent_address" <?php echo $TAttrs . $onblur; ?> placeholder="Permanent Address"><?php echo $permanent_address; ?></textarea>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessagePermanentAddress"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>Personal History:</label>
                                                                    <textarea tabindex="175" rows="4"
                                                                              id="personal_history" <?php echo $TAttrs; ?> placeholder="Personal History"><?php echo $personal_history; ?></textarea>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessagePersonalHistory"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="separator separator-dashed my-10"></div>

                                                <div class="mb-3">
                                                    <h3 class="font-size-lg text-dark-75 font-weight-bold mb-10">
                                                        Guardian Information:
                                                    </h3>
                                                    <div class="mb-2">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label> Guardian's Name:</label>
                                                                    <input tabindex="180" maxlength="50"
                                                                           id="guardian_name"
                                                                           value="<?php echo $guardian_name; ?>" <?php echo $TAttrs . $onblur; ?>
                                                                           placeholder="Guardian Name"/>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageGuardianName"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">


                                                                <div class="form-group">
                                                                    <label> Guardian's Mobile No:
                                                                        <small>
                                                                            <a href="javascript:;">Example 300-777
                                                                                8888</a>
                                                                        </small>
                                                                    </label>

                                                                    <input tabindex="550" id="guardian_dial_code"
                                                                           class="not-display" type="hidden"
                                                                           value="<?php echo $guardian_dial_code; ?>">
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend"><span
                                                                                    class="input-group-text"
                                                                                    id="guardian_mobile_no_flag"><?php echo $guardian_mobile_no_flag; ?></span>
                                                                        </div>
                                                                        <input tabindex="185" maxlength="12"
                                                                               id="guardian_mobile"
                                                                               value="<?php echo $guardian_mobile; ?>" <?php echo $TAttrs . $onblur; ?>
                                                                               placeholder="Guardian's Mobile No"/>
                                                                    </div>
                                                                    <input tabindex="560" id="guardian_iso"
                                                                           class="not-display" type="hidden"
                                                                           value="<?php echo $guardian_iso; ?>">
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageGuardianMobile"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label> Guardian's CNIC:</label>
                                                                    <input tabindex="190" maxlength="15"
                                                                           id="guardian_cnic"
                                                                           value="<?php echo $guardian_cnic; ?>" <?php echo $TAttrs . $onblur; ?>
                                                                           placeholder="Guardian's CNIC"/>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageGuardianCNIC"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label> Guardian Relation:</label>
                                                                    <select tabindex="200"
                                                                            id="guardian_relation" <?php echo $TAttrs . $onblur; ?>>
                                                                        <option selected="selected" value="">Select
                                                                        </option>
                                                                        <?php
                                                                        foreach (config('employee_basic_infos.relation.title') as $key => $value) {
                                                                            $selected = $guardian_relation == $key ? 'selected="selected"' : '';
                                                                            ?>
                                                                            <option <?php echo $selected; ?>
                                                                                    value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageGuardianRelation"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="separator separator-dashed my-10"></div>

                                                <div class="mb-3">
                                                    <h3 class="font-size-lg text-dark-75 font-weight-bold mb-10">
                                                        Joining Information:</h3>
                                                    <div class="mb-2">
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label>* Joining Date:</label>
                                                                    <input tabindex="210" <?php echo $DateInput; ?>
                                                                           id="joining_date" placeholder="Joining Date"
                                                                           value="<?php echo $joining_date; ?>">
                                                                    <span class="e-clear-icon e-clear-icon-hide"
                                                                          aria-label="close" role="button"></span>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageJoiningDate"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label> Contract Start Date:</label>
                                                                    <input tabindex="225" <?php echo $DateInput; ?>
                                                                           id="contract_start_date"
                                                                           placeholder="Contract Start Date"
                                                                           value="<?php echo $contract_start_date; ?>">
                                                                    <span class="e-clear-icon e-clear-icon-hide"
                                                                          aria-label="close" role="button"></span>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageContractStartDate"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label> Contract Renewal Date:</label>
                                                                    <input tabindex="250" <?php echo $DateInput; ?>
                                                                           id="contract_end_date"
                                                                           placeholder="Renewal Date"
                                                                           value="<?php echo $contract_end_date; ?>">
                                                                    <span class="e-clear-icon e-clear-icon-hide"
                                                                          aria-label="close" role="button"></span>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageContractEndDate"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label> Leaving Date:</label>
                                                                    <input tabindex="275" <?php echo $DateInput; ?>
                                                                           id="leaving_date" placeholder="Leaving Date"
                                                                           value="<?php echo $leaving_date; ?>">
                                                                    <span class="e-clear-icon e-clear-icon-hide"
                                                                          aria-label="close" role="button"></span>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageLeavingDate"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label>* Salary:</label>
                                                                    <input tabindex="300"
                                                                           id="salary" <?php echo $NAttrs; ?>
                                                                           onkeypress="allowNumberOnly(event)"
                                                                           value="<?php echo $salary; ?>"
                                                                           placeholder="Salary"/>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageSalary"></span>
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

            var validName = /[^a-zA-Z0-9-.@_&' ]/;
            var validEmail = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
            var validDate = /^(0[1-9]|1\d|2\d|3[01])\-(0[1-9]|1[0-2])\-(19|20)\d{2}$/;
            var validCNIC = /^[0-9+]{5}-[0-9+]{7}-[0-9]{1}$/;
            var validContactNumber = /^[\-)( ]*([0-9]{3})[\-)( ]*([0-9]{3})[\-)( ]*([0-9]{4})$/;
            var validAddress = /[^a-zA-Z0-9+-._,@&#/' ]/;

            var statusArray = [<?php echo '"' . implode('","', array_values(config('employees.status.value'))) . '"' ?>];
            var titleArray = [<?php echo '"' . implode('","', array_values(config('employee_basic_infos.title.value'))) . '"' ?>];
            var genderArray = [<?php echo '"' . implode('","', array_values(config('employee_basic_infos.gender.value'))) . '"' ?>];
            var bloodGroupArray = [<?php echo '"' . implode('","', array_values(config('employee_basic_infos.blood_group.value'))) . '"' ?>];
            var maritalStatusArray = [<?php echo '"' . implode('","', array_values(config('employee_basic_infos.marital_status.value'))) . '"' ?>];
            var relationArray = [<?php echo '"' . implode('","', array_values(config('employee_basic_infos.relation.value'))) . '"' ?>];

            var error = '';

            var id = document.getElementById('id');
            var A = '<?php echo hasRight($user_right_title, 'add') ?>';
            var E = '<?php echo hasRight($user_right_title, 'edit') ?>';

            var employee_code = document.getElementById('employee_code');
            var department_id = document.getElementById('department_id');
            var select2_department_id_container = document.querySelector("[aria-labelledby='select2-department_id-container']");
            var team_id = document.getElementById('team_id');
            var select2_team_id_container = document.querySelector("[aria-labelledby='select2-team_id-container']");
            var designation_id = document.getElementById('designation_id');
            var select2_designation_id_container = document.querySelector("[aria-labelledby='select2-designation_id-container']");
            var shift_id = document.getElementById('shift_id');
            var select2_shift_id_container = document.querySelector("[aria-labelledby='select2-shift_id-container']");
            var status = document.getElementById('status');
            var evaluation_type_id = document.getElementById('evaluation_type_id');

            var title = document.getElementById('title');
            var first_name = document.getElementById('first_name');
            var last_name = document.getElementById('last_name');
            var pseudo_name = document.getElementById('pseudo_name');
            var father_name = document.getElementById('father_name');
            var email = document.getElementById('email');
            var official_email = document.getElementById('official_email');
            var gender = document.getElementById('gender');
            var blood_group = document.getElementById('blood_group');
            var dob = document.getElementById('dob');
            var pob = document.getElementById('pob');
            var cnic = document.getElementById('cnic');
            var cnic_expiry = document.getElementById('cnic_expiry');
            var old_cnic = document.getElementById('old_cnic');

            var country_id = document.getElementById('country_id');
            var select2_country_id_container = document.querySelector("[aria-labelledby='select2-country_id-container']");
            var state_id = document.getElementById('state_id');
            var select2_state_id_container = document.querySelector("[aria-labelledby='select2-state_id-container']");
            var city_id = document.getElementById('city_id');
            var select2_city_id_container = document.querySelector("[aria-labelledby='select2-city_id-container']");
            var phone = document.getElementById('phone');
            var dial_code = document.getElementById('dial_code');
            var mobile = document.getElementById('mobile');
            var iso = document.getElementById('iso');
            var o_dial_code = document.getElementById('o_dial_code');
            var other_mobile = document.getElementById('other_mobile');
            var o_iso = document.getElementById('o_iso');
            var relation = document.getElementById('relation');
            var marital_status = document.getElementById('marital_status');
            var religion = document.getElementById('religion');
            var sect = document.getElementById('sect');
            var address = document.getElementById('address');
            var permanent_address = document.getElementById('permanent_address');
            var personal_history = document.getElementById('personal_history');

            var guardian_name = document.getElementById('guardian_name');
            var guardian_dial_code = document.getElementById('guardian_dial_code');
            var guardian_mobile = document.getElementById('guardian_mobile');
            var guardian_iso = document.getElementById('guardian_iso');
            var guardian_cnic = document.getElementById('guardian_cnic');
            var guardian_relation = document.getElementById('guardian_relation');

            var joining_date = document.getElementById('joining_date');
            var contract_start_date = document.getElementById('contract_start_date');
            var contract_end_date = document.getElementById('contract_end_date');
            var leaving_date = document.getElementById('leaving_date');
            var salary = document.getElementById('salary');

            var errorMessageEmployeeCode = document.getElementById('errorMessageEmployeeCode');
            var errorMessageDepartment = document.getElementById('errorMessageDepartment');
            var errorMessageTeam = document.getElementById('errorMessageTeam');
            var errorMessageDesignation = document.getElementById('errorMessageDesignation');
            var errorMessageShift = document.getElementById('errorMessageShift');
            var errorMessageStatus = document.getElementById('errorMessageStatus');
            var errorMessageEvaluationType = document.getElementById('errorMessageEvaluationType');

            var errorMessageTitle = document.getElementById('errorMessageTitle');
            var errorMessageFirstName = document.getElementById('errorMessageFirstName');
            var errorMessageLastName = document.getElementById('errorMessageLastName');
            var errorMessagePseudoName = document.getElementById('errorMessagePseudoName');
            var errorMessageFatherName = document.getElementById('errorMessageFatherName');
            var errorMessageEmail = document.getElementById('errorMessageEmail');
            var errorMessageOfficialEmail = document.getElementById('errorMessageOfficialEmail');
            var errorMessageGender = document.getElementById('errorMessageGender');
            var errorMessageBloodGroup = document.getElementById('errorMessageBloodGroup');
            var errorMessagedob = document.getElementById('errorMessagedob');
            var errorMessagepob = document.getElementById('errorMessagepob');
            var errorMessageCNIC = document.getElementById('errorMessageCNIC');
            var errorMessageCNICExpiry = document.getElementById('errorMessageCNICExpiry');
            var errorMessageOldCNIC = document.getElementById('errorMessageOldCNIC');

            var errorMessageCountry = document.getElementById('errorMessageCountry');
            var errorMessageState = document.getElementById('errorMessageState');
            var errorMessageCity = document.getElementById('errorMessageCity');
            var errorMessagePhone = document.getElementById('errorMessagePhone');
            var errorMessageMobile = document.getElementById('errorMessageMobile');
            var errorMessageOtherMobile = document.getElementById('errorMessageOtherMobile');
            var errorMessageRelation = document.getElementById('errorMessageRelation');
            var errorMessageMaritalStatus = document.getElementById('errorMessageMaritalStatus');
            var errorMessageReligion = document.getElementById('errorMessageReligion');
            var errorMessageSect = document.getElementById('errorMessageSect');
            var errorMessageAddress = document.getElementById('errorMessageAddress');
            var errorMessagePermanentAddress = document.getElementById('errorMessagePermanentAddress');
            var errorMessagePersonalHistory = document.getElementById('errorMessagePersonalHistory');

            var errorMessageGuardianName = document.getElementById('errorMessageGuardianName');
            var errorMessageGuardianMobile = document.getElementById('errorMessageGuardianMobile');
            var errorMessageGuardianCNIC = document.getElementById('errorMessageGuardianCNIC');
            var errorMessageGuardianRelation = document.getElementById('errorMessageGuardianRelation');

            var errorMessageJoiningDate = document.getElementById('errorMessageJoiningDate');
            var errorMessageContractStartDate = document.getElementById('errorMessageContractStartDate');
            var errorMessageContractEndDate = document.getElementById('errorMessageContractEndDate');
            var errorMessageLeavingDate = document.getElementById('errorMessageLeavingDate');
            var errorMessageSalary = document.getElementById('errorMessageSalary');

            employee_code.style.borderColor = select2_department_id_container.style.borderColor = select2_team_id_container.style.borderColor = select2_designation_id_container.style.borderColor = select2_shift_id_container.style.borderColor = status.style.borderColor = '#E4E6EF';
            evaluation_type_id.style.borderColor = title.style.borderColor = first_name.style.borderColor = last_name.style.borderColor = pseudo_name.style.borderColor = father_name.style.borderColor = email.style.borderColor = official_email.style.borderColor = '#E4E6EF';
            gender.style.borderColor = blood_group.style.borderColor = dob.style.borderColor = pob.style.borderColor = cnic.style.borderColor = cnic_expiry.style.borderColor = old_cnic.style.borderColor = '#E4E6EF';
            select2_country_id_container.style.borderColor = select2_state_id_container.style.borderColor = select2_city_id_container.style.borderColor = phone.style.borderColor = mobile.style.borderColor = other_mobile.style.borderColor = relation.style.borderColor = '#E4E6EF';
            marital_status.style.borderColor = religion.style.borderColor = sect.style.borderColor = address.style.borderColor = permanent_address.style.borderColor = personal_history.style.borderColor = '#E4E6EF';
            guardian_name.style.borderColor = guardian_mobile.style.borderColor = guardian_cnic.style.borderColor = guardian_relation.style.borderColor = '#E4E6EF';
            joining_date.style.borderColor = contract_start_date.style.borderColor = contract_end_date.style.borderColor = leaving_date.style.borderColor = salary.style.borderColor = '#E4E6EF';

            errorMessageEmployeeCode.innerText = errorMessageDepartment.innerText = errorMessageTeam.innerText = errorMessageDesignation.innerText = errorMessageShift.innerText = errorMessageStatus.innerText = "";
            errorMessageEvaluationType.innerText = errorMessageTitle.innerText = errorMessageFirstName.innerText = errorMessageLastName.innerText = errorMessagePseudoName.innerText = errorMessageFatherName.innerText = errorMessageEmail.innerText = errorMessageOfficialEmail.innerText = "";
            errorMessageGender.innerText = errorMessageBloodGroup.innerText = errorMessagedob.innerText = errorMessagepob.innerText = errorMessageCNIC.innerText = errorMessageCNICExpiry.innerText = errorMessageOldCNIC.innerText = "";
            errorMessageCountry.innerText = errorMessageState.innerText = errorMessageCity.innerText = errorMessagePhone.innerText = errorMessageMobile.innerText = errorMessageOtherMobile.innerText = errorMessageRelation.innerText = "";
            errorMessageMaritalStatus.innerText = errorMessageReligion.innerText = errorMessageSect.innerText = errorMessageAddress.innerText = errorMessagePermanentAddress.innerText = errorMessagePersonalHistory.innerText = "";
            errorMessageGuardianName.innerText = errorMessageGuardianMobile.innerText = errorMessageGuardianCNIC.innerText = errorMessageGuardianRelation.innerText = "";
            errorMessageJoiningDate.innerText = errorMessageContractStartDate.innerText = errorMessageContractEndDate.innerText = errorMessageLeavingDate.innerText = errorMessageSalary.innerText = "";

            var redirect = <?php echo isset($_GET['emp_code'], $_GET['id']) && is_numeric($_GET['emp_code']) && is_numeric($_GET['id']) && !empty($_GET['emp_code']) && !empty($_GET['id']) ? '"' . $admin_url . 'profile_overview?emp_id=' . $_GET['id'] . '"' : '""'; ?>;

            if (id.value == 0 && A == '') {
                toasterTrigger('warning', 'Sorry! You have no right to add record.');
            } else if (id.value > 0 && E == '') {
                toasterTrigger('warning', 'Sorry! You have no right to update record.');
            } else if (employee_code.value == '') {
                employee_code.style.borderColor = '#F00';
                error = "Employee Code field is required.";
                errorMessageEmployeeCode.innerText = error;
                toasterTrigger('error', error);
                return false;
            } else if (isNaN(employee_code.value) === true || employee_code.value < 1 || employee_code.value.length > 20) {
                employee_code.style.borderColor = '#F00';
                error = "Invalid Employee Code.";
                toasterTrigger('error', error);
                errorMessageEmployeeCode.innerText = error;
                return false;
            } else if (department_id.value == '') {
                select2_department_id_container.style.borderColor = '#F00';
                error = "Department field is required.";
                toasterTrigger('error', error);
                errorMessageDepartment.innerText = error;
                return false;
            } else if (isNaN(department_id.value) === true || department_id.value <= 0 || department_id.value.length > 10) {
                select2_department_id_container.style.borderColor = '#F00';
                error = "Please select a valid option.";
                toasterTrigger('error', error);
                errorMessageDepartment.innerText = error;
                return false;
            } else if (team_id.value != '' && (isNaN(team_id.value) === true || team_id.value <= 0 || team_id.value.length > 10)) {
                select2_team_id_container.style.borderColor = '#F00';
                error = "Please select a valid option.";
                toasterTrigger('error', error);
                errorMessageTeam.innerText = error;
                return false;
            } else if (designation_id.value == '') {
                select2_designation_id_container.style.borderColor = '#F00';
                error = "Designation field is required.";
                toasterTrigger('error', error);
                errorMessageDesignation.innerText = error;
                return false;
            } else if (isNaN(designation_id.value) === true || designation_id.value <= 0 || designation_id.value.length > 10) {
                select2_designation_id_container.style.borderColor = '#F00';
                error = "Please select a valid option.";
                toasterTrigger('error', error);
                errorMessageDesignation.innerText = error;
                return false;
            } else if (shift_id.value == '') {
                select2_shift_id_container.style.borderColor = '#F00';
                error = "Shift field is required.";
                toasterTrigger('error', error);
                errorMessageShift.innerText = error;
                return false;
            } else if (isNaN(shift_id.value) === true || shift_id.value <= 0 || shift_id.value.length > 10) {
                select2_shift_id_container.style.borderColor = '#F00';
                error = "Please select a valid option.";
                toasterTrigger('error', error);
                errorMessageShift.innerText = error;
                return false;
            } else if (status.value == '') {
                status.style.borderColor = '#F00';
                error = "Status field is required.";
                toasterTrigger('error', error);
                errorMessageStatus.innerText = error;
                return false;
            } else if (statusArray.includes(status.value) == false || status.value.length !== 1) {
                status.style.borderColor = '#F00';
                error = "Please select a valid option.";
                toasterTrigger('error', error);
                errorMessageStatus.innerText = error;
                return false;
            } else if (evaluation_type_id.value == '') {
                evaluation_type_id.style.borderColor = '#F00';
                error = "Evaluation Type field is required.";
                toasterTrigger('error', error);
                errorMessageEvaluationType.innerText = error;
                return false;
            } else if (isNaN(evaluation_type_id.value) === true || evaluation_type_id.value <= 0 || evaluation_type_id.value.length > 10) {
                evaluation_type_id.style.borderColor = '#F00';
                error = "Please select a valid option.";
                toasterTrigger('error', error);
                errorMessageEvaluationType.innerText = error;
                return false;
            } else if (title.value == '') {
                title.style.borderColor = '#F00';
                error = "Title field is required.";
                toasterTrigger('error', error);
                errorMessageTitle.innerText = error;
                return false;
            } else if (titleArray.includes(title.value) == false || title.value.length > 5) {
                title.style.borderColor = '#F00';
                error = "Please select a valid option.";
                toasterTrigger('error', error);
                errorMessageTitle.innerText = error;
                return false;
            } else if (first_name.value == '') {
                first_name.style.borderColor = '#F00';
                error = "First Name field is required.";
                toasterTrigger('error', error);
                errorMessageFirstName.innerText = error;
                return false;
            } else if (validName.test(first_name.value)) {
                first_name.style.borderColor = '#F00';
                error = "Special Characters are not Allowed.";
                toasterTrigger('error', error);
                errorMessageFirstName.innerText = error;
                return false;
            } else if (first_name.value.length > 50) {
                first_name.style.borderColor = '#F00';
                error = "Length should not exceed 50 characters.";
                toasterTrigger('error', error);
                errorMessageFirstName.innerText = error;
                return false;
            } /*else if (last_name.value == '') {
                last_name.style.borderColor = '#F00';
                error = "Last Name field is required.";
                toasterTrigger('error', error);
                errorMessageLastName.innerText = error;
                return false;
            }*/ else if (last_name.value != '' && validName.test(last_name.value)) {
                last_name.style.borderColor = '#F00';
                error = "Special Characters are not Allowed.";
                toasterTrigger('error', error);
                errorMessageLastName.innerText = error;
                return false;
            } else if (last_name.value != '' && last_name.value.length > 50) {
                last_name.style.borderColor = '#F00';
                error = "Length should not exceed 50 characters.";
                toasterTrigger('error', error);
                errorMessageLastName.innerText = error;
                return false;
            } else if (pseudo_name.value != '' && validName.test(pseudo_name.value)) {
                pseudo_name.style.borderColor = '#F00';
                error = "Special Characters are not Allowed.";
                toasterTrigger('error', error);
                errorMessagePseudoName.innerText = error;
                return false;
            } else if (pseudo_name.value != '' && pseudo_name.value.length > 50) {
                pseudo_name.style.borderColor = '#F00';
                error = "Length should not exceed 50 characters.";
                toasterTrigger('error', error);
                errorMessagePseudoName.innerText = error;
                return false;
            } else if (father_name.value == '') {
                father_name.style.borderColor = '#F00';
                error = "Father Name field is required.";
                toasterTrigger('error', error);
                errorMessageFatherName.innerText = error;
                return false;
            } else if (validName.test(father_name.value)) {
                father_name.style.borderColor = '#F00';
                error = "Special Characters are not Allowed.";
                toasterTrigger('error', error);
                errorMessageFatherName.innerText = error;
                return false;
            } else if (father_name.value.length > 50) {
                father_name.style.borderColor = '#F00';
                error = "Length should not exceed 50 characters.";
                toasterTrigger('error', error);
                errorMessageFatherName.innerText = error;
                return false;
            } else if (email.value == '') {
                email.style.borderColor = '#F00';
                error = "Email field is required.";
                toasterTrigger('error', error);
                errorMessageEmail.innerText = error;
                return false;
            } else if (validEmail.test(email.value) == false) {
                email.style.borderColor = '#F00';
                error = "Invalid Email Address.";
                toasterTrigger('error', error);
                errorMessageEmail.innerText = error;
                return false;
            } else if (official_email.value == '') {
                official_email.style.borderColor = '#F00';
                error = "Official Email field is required.";
                toasterTrigger('error', error);
                errorMessageOfficialEmail.innerText = error;
                return false;
            } else if (validEmail.test(official_email.value) == false) {
                official_email.style.borderColor = '#F00';
                error = "Invalid Email Address.";
                toasterTrigger('error', error);
                errorMessageOfficialEmail.innerText = error;
                return false;
            } else if (gender.value == '') {
                gender.style.borderColor = '#F00';
                error = "Gender field is required.";
                toasterTrigger('error', error);
                errorMessageGender.innerText = error;
                return false;
            } else if (genderArray.includes(gender.value) == false || gender.value.length !== 1) {
                gender.style.borderColor = '#F00';
                error = "Please select a valid option.";
                toasterTrigger('error', error);
                errorMessageGender.innerText = error;
                return false;
            } else if (blood_group.value == '') {
                blood_group.style.borderColor = '#F00';
                error = "Blood Group field is required.";
                toasterTrigger('error', error);
                errorMessageBloodGroup.innerText = error;
                return false;
            } else if (bloodGroupArray.includes(blood_group.value) == false || blood_group.value.length > 3) {
                blood_group.style.borderColor = '#F00';
                error = "Please select a valid option.";
                toasterTrigger('error', error);
                errorMessageBloodGroup.innerText = error;
                return false;
            } else if (dob.value == '') {
                dob.style.borderColor = '#F00';
                error = "Date of Birth field is required.";
                toasterTrigger('error', error);
                errorMessagedob.innerText = error;
                return false;
            } else if (!(validDate.test(dob.value)) || dob.value.length !== 10) {
                dob.style.borderColor = '#F00';
                error = "Please select a valid date.";
                toasterTrigger('error', error);
                errorMessagedob.innerText = error;
                return false;
            } else if (pob.value != '' && validName.test(pob.value)) {
                pob.style.borderColor = '#F00';
                error = "Special Characters are not Allowed.";
                toasterTrigger('error', error);
                errorMessagepob.innerText = error;
                return false;
            } else if (pob.value != '' && pob.value.length > 50) {
                pob.style.borderColor = '#F00';
                error = "Length should not exceed 50  characters.";
                toasterTrigger('error', error);
                errorMessagepob.innerText = error;
                return false;
            } else if (cnic.value == '') {
                cnic.style.borderColor = '#F00';
                error = "CNIC field is required.";
                toasterTrigger('error', error);
                errorMessageCNIC.innerText = error;
                return false;
            } else if (validCNIC.test(cnic.value) == false || cnic.value.length !== 15) {
                cnic.style.borderColor = '#F00';
                error = "CNIC number is incorrect.";
                toasterTrigger('error', error);
                errorMessageCNIC.innerText = error;
                return false;
            } else if (cnic_expiry.value != '' && (!(validDate.test(cnic_expiry.value)) || cnic_expiry.value.length !== 10)) {
                cnic_expiry.style.borderColor = '#F00';
                error = "Please select a valid date.";
                toasterTrigger('error', error);
                errorMessageCNICExpiry.innerText = error;
                return false;
            } else if (old_cnic.value != '' && (validCNIC.test(old_cnic.value) == false || old_cnic.value.length !== 15)) {
                old_cnic.style.borderColor = '#F00';
                error = "CNIC number is incorrect.";
                toasterTrigger('error', error);
                errorMessageOldCNIC.innerText = error;
                return false;
            } else if (country_id.value == '') {
                select2_country_id_container.style.borderColor = '#F00';
                error = "Country field is required.";
                toasterTrigger('error', error);
                errorMessageCountry.innerText = error;
                return false;
            } else if (isNaN(country_id.value) === true || country_id.value <= 0 || country_id.value.length > 10) {
                select2_country_id_container.style.borderColor = '#F00';
                error = "Please select a valid option.";
                toasterTrigger('error', error);
                errorMessageCountry.innerText = error;
                return false;
            } else if (state_id.value == '') {
                select2_state_id_container.style.borderColor = '#F00';
                error = "State field is required.";
                toasterTrigger('error', error);
                errorMessageState.innerText = error;
                return false;
            } else if (isNaN(state_id.value) === true || state_id.value <= 0 || state_id.value.length > 10) {
                select2_state_id_container.style.borderColor = '#F00';
                error = "Please select a valid option.";
                toasterTrigger('error', error);
                errorMessageState.innerText = error;
                return false;
            } else if (city_id.value == '') {
                select2_city_id_container.style.borderColor = '#F00';
                error = "City field is required.";
                toasterTrigger('error', error);
                errorMessageCity.innerText = error;
                return false;
            } else if (isNaN(city_id.value) === true || city_id.value <= 0 || city_id.value.length > 10) {
                select2_city_id_container.style.borderColor = '#F00';
                error = "Please select a valid option.";
                toasterTrigger('error', error);
                errorMessageCity.innerText = error;
                return false;
            } else if (phone.value != '' && (validContactNumber.test(phone.value) == false || phone.value.length !== 14)) {
                phone.style.borderColor = '#F00';
                error = "Invalid Phone number.";
                toasterTrigger('error', error);
                errorMessagePhone.innerText = error;
                return false;
            } else if (dial_code.value == '' || isNaN(dial_code.value) === true || dial_code.value <= 0 || dial_code.value.length > 9) {
                mobile.style.borderColor = '#F00';
                error = "Invalid country dial code.";
                toasterTrigger('error', error);
                errorMessageMobile.innerText = error;
                return false;
            } else if (mobile.value == '') {
                mobile.style.borderColor = '#F00';
                error = "Mobile No field is required.";
                toasterTrigger('error', error);
                errorMessageMobile.innerText = error;
                return false;
            } else if (validContactNumber.test(mobile.value) == false || mobile.value.length !== 12) {
                mobile.style.borderColor = '#F00';
                error = "Invalid Mobile No.";
                toasterTrigger('error', error);
                errorMessageMobile.innerText = error;
                return false;
            } else if (iso.value == '' || iso.value.length > 3 || validName.test(iso.value)) {
                mobile.style.borderColor = '#F00';
                error = "Invalid country iso.";
                toasterTrigger('error', error);
                errorMessageMobile.innerText = error;
                return false;
            } else if (o_dial_code.value == '' || isNaN(o_dial_code.value) === true || o_dial_code.value < 1 || o_dial_code.value.length > 9) {
                other_mobile.style.borderColor = '#F00';
                error = "Invalid country dial code.";
                toasterTrigger('error', error);
                errorMessageOtherMobile.innerText = error;
                return false;
            } else if (other_mobile.value == '') {
                other_mobile.style.borderColor = '#F00';
                error = "Other Mobile No field is required.";
                toasterTrigger('error', error);
                errorMessageOtherMobile.innerText = error;
                return false;
            } else if (validContactNumber.test(other_mobile.value) == false || other_mobile.value.length !== 12) {
                other_mobile.style.borderColor = '#F00';
                error = "Invalid Other Mobile No.";
                toasterTrigger('error', error);
                errorMessageOtherMobile.innerText = error;
                return false;
            } else if (o_iso.value == '' || o_iso.value.length > 3 || validName.test(o_iso.value)) {
                other_mobile.style.borderColor = '#F00';
                error = "Invalid country iso.";
                toasterTrigger('error', error);
                errorMessageOtherMobile.innerText = error;
                return false;
            } else if (relation.value == '') {
                relation.style.borderColor = '#F00';
                error = "Relation field is required.";
                toasterTrigger('error', error);
                errorMessageRelation.innerText = error;
                return false;
            } else if (relationArray.includes(relation.value) == false || relation.value.length > 2) {
                relation.style.borderColor = '#F00';
                error = "Please select a valid option.";
                toasterTrigger('error', error);
                errorMessageRelation.innerText = error;
                return false;
            } else if (marital_status.value == '') {
                marital_status.style.borderColor = '#F00';
                error = "Marital Status field is required.";
                toasterTrigger('error', error);
                errorMessageMaritalStatus.innerText = error;
                return false;
            } else if (maritalStatusArray.includes(marital_status.value) == false || marital_status.value.length > 2) {
                marital_status.style.borderColor = '#F00';
                error = "Please select a valid option.";
                toasterTrigger('error', error);
                errorMessageMaritalStatus.innerText = error;
                return false;
            } else if (religion.value != '' && validName.test(religion.value)) {
                religion.style.borderColor = '#F00';
                error = "Special Characters are not Allowed.";
                toasterTrigger('error', error);
                errorMessageReligion.innerText = error;
                return false;
            } else if (religion.value != '' && religion.value.length > 50) {
                religion.style.borderColor = '#F00';
                error = "Length should not exceed 50 characters.";
                toasterTrigger('error', error);
                errorMessageReligion.innerText = error;
                return false;
            } else if (sect.value != '' && validName.test(sect.value)) {
                sect.style.borderColor = '#F00';
                error = "Special Characters are not Allowed.";
                toasterTrigger('error', error);
                errorMessageSect.innerText = error;
                return false;
            } else if (sect.value != '' && sect.value.length > 50) {
                sect.style.borderColor = '#F00';
                error = "Length should not exceed 50 characters.";
                toasterTrigger('error', error);
                errorMessageSect.innerText = error;
                return false;
            } else if (address.value.trim() == '') {
                address.style.borderColor = '#F00';
                error = "Address field is required.";
                toasterTrigger('error', error);
                errorMessageAddress.innerText = error;
                return false;
            } else if (validAddress.test(address.value.trim())) {
                address.style.borderColor = '#F00';
                error = "Special Characters are not Allowed.";
                toasterTrigger('error', error);
                errorMessageAddress.innerText = error;
                return false;
            } else if (permanent_address.value.trim() != '' && validAddress.test(permanent_address.value.trim())) {
                permanent_address.style.borderColor = '#F00';
                error = "Special Characters are not Allowed.";
                toasterTrigger('error', error);
                errorMessagePermanentAddress.innerText = error;
                return false;
            } else if (personal_history.value.trim() != '' && validAddress.test(personal_history.value.trim())) {
                personal_history.style.borderColor = '#F00';
                error = "Special Characters are not Allowed.";
                toasterTrigger('error', error);
                errorMessagePersonalHistory.innerText = error;
                return false;
            } else if (guardian_name.value.trim() != '' && validName.test(guardian_name.value.trim())) {
                guardian_name.style.borderColor = '#F00';
                error = "Special Characters are not Allowed.";
                toasterTrigger('error', error);
                errorMessageGuardianName.innerText = error;
                return false;
            } else if (guardian_name.value != '' && guardian_name.value.length > 50) {
                guardian_name.style.borderColor = '#F00';
                error = "Length should not exceed 50 characters.";
                toasterTrigger('error', error);
                errorMessageGuardianName.innerText = error;
                return false;
            } else if (guardian_mobile.value != '' && (validContactNumber.test(guardian_mobile.value) == false || guardian_mobile.value.length !== 12)) {
                guardian_mobile.style.borderColor = '#F00';
                error = "Invalid Guardian's Mobile No.";
                toasterTrigger('error', error);
                errorMessageGuardianMobile.innerText = error;
                return false;
            } else if (guardian_cnic.value != '' && (validCNIC.test(guardian_cnic.value) == false || guardian_cnic.value.length !== 15)) {
                guardian_cnic.style.borderColor = '#F00';
                error = "Invalid Guardian's CNIC.";
                toasterTrigger('error', error);
                errorMessageGuardianCNIC.innerText = error;
                return false;
            } else if ((guardian_name.value != '' && guardian_relation.value == '') || (guardian_mobile.value != '' && guardian_relation.value == '') || (guardian_cnic.value != '' && guardian_relation.value == '')) {
                guardian_relation.style.borderColor = '#F00';
                error = 'If you put any guardian info then "Guardian Relation" field is required.';
                toasterTrigger('error', error);
                errorMessageGuardianRelation.innerText = error;
                return false;
            } else if (guardian_relation.value != '' && (relationArray.includes(guardian_relation.value) == false || relation.value.length > 2)) {
                guardian_relation.style.borderColor = '#F00';
                error = "Please select a valid option.";
                toasterTrigger('error', error);
                errorMessageGuardianRelation.innerText = error;
                return false;
            } else if (guardian_relation.value != '' && guardian_name.value == '') {
                guardian_name.style.borderColor = '#F00';
                error = 'If you select "Guardian Relation" then "Guardian\'s Name" field is required.';
                toasterTrigger('error', error);
                errorMessageGuardianName.innerText = error;
                return false;
            } else if (joining_date.value == '') {
                joining_date.style.borderColor = '#F00';
                error = "Joining Date field is required.";
                toasterTrigger('error', error);
                errorMessageJoiningDate.innerText = error;
                return false;
            } else if (joining_date.value != '' && (!(validDate.test(joining_date.value)) || joining_date.value.length !== 10)) {
                joining_date.style.borderColor = '#F00';
                error = "Please select a valid date.";
                toasterTrigger('error', error);
                errorMessageJoiningDate.innerText = error;
                return false;
            } else if (contract_start_date.value != '' && (!(validDate.test(contract_start_date.value)) || contract_start_date.value.length !== 10)) {
                contract_start_date.style.borderColor = '#F00';
                error = "Please select a valid date.";
                toasterTrigger('error', error);
                errorMessageContractStartDate.innerText = error;
                return false;
            } else if (contract_end_date.value != '' && (!(validDate.test(contract_end_date.value)) || contract_end_date.value.length !== 10)) {
                contract_end_date.style.borderColor = '#F00';
                error = "Please select a valid date.";
                toasterTrigger('error', error);
                errorMessageContractEndDate.innerText = error;
                return false;
            } else if (leaving_date.value != '' && (!(validDate.test(leaving_date.value)) || leaving_date.value.length !== 10)) {
                leaving_date.style.borderColor = '#F00';
                error = "Please select a valid date.";
                toasterTrigger('error', error);
                errorMessageLeavingDate.innerText = error;
                return false;
            } else if (salary.value == '') {
                salary.style.borderColor = '#F00';
                error = "Salary field is required.";
                toasterTrigger('error', error);
                errorMessageSalary.innerText = error;
                return false;
            } else if (salary.value != '' && (isNaN(salary.value) === true || salary.value < 1 || salary.value.length > 9)) {
                salary.style.borderColor = '#F00';
                error = "Invalid amount of Salary.";
                toasterTrigger('error', error);
                errorMessageSalary.innerText = error;
                return false;
            } else {
                loader(true);
                var postData = {
                    "id": id.value,
                    "employee_code": employee_code.value.trim(),
                    "department_id": department_id.value,
                    "team_id": team_id.value,
                    "designation_id": designation_id.value,
                    "shift_id": shift_id.value,
                    "evaluation_type_id": evaluation_type_id.value,
                    "status": status.value,
                    "title": title.value,
                    "first_name": first_name.value.trim(),
                    "last_name": last_name.value.trim(),
                    "pseudo_name": pseudo_name.value.trim(),
                    "father_name": father_name.value.trim(),
                    "email": email.value,
                    "official_email": official_email.value,
                    "gender": gender.value,
                    "blood_group": blood_group.value,
                    "dob": dob.value,
                    "pob": pob.value.trim(),
                    "cnic": cnic.value,
                    "cnic_expiry": cnic_expiry.value,
                    "old_cnic": old_cnic.value,
                    "country_id": country_id.value,
                    "state_id": state_id.value,
                    "city_id": city_id.value,
                    "phone": phone.value,
                    "dial_code": dial_code.value,
                    "mobile": mobile.value,
                    "iso": iso.value,
                    "o_dial_code": o_dial_code.value,
                    "other_mobile": other_mobile.value,
                    "o_iso": o_iso.value,
                    "relation": relation.value,
                    "marital_status": marital_status.value,
                    "religion": religion.value.trim(),
                    "sect": sect.value.trim(),
                    "address": address.value.trim(),
                    "permanent_address": permanent_address.value.trim(),
                    "personal_history": personal_history.value.trim(),
                    "guardian_name": guardian_name.value.trim(),
                    "guardian_dial_code": guardian_dial_code.value,
                    "guardian_mobile": guardian_mobile.value,
                    "guardian_iso": guardian_iso.value,
                    "guardian_cnic": guardian_cnic.value,
                    "guardian_relation": guardian_relation.value,
                    "joining_date": joining_date.value,
                    "contract_start_date": contract_start_date.value,
                    "contract_end_date": contract_end_date.value,
                    "leaving_date": leaving_date.value,
                    "salary": salary.value.trim(),
                    "user_right_title": '<?php echo $user_right_title; ?>'
                };
                $.ajax({
                    type: "POST", url: "ajax/employee.php",
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
                                        if (redirect != '') {
                                            window.location = redirect;
                                        } else {
                                            if (obj.form_reset !== undefined && obj.form_reset) {
                                                document.getElementById("myFORM").reset();
                                                var select2_department_id_container = document.getElementById("select2-department_id-container");
                                                var select2_team_id_container = document.getElementById("select2-team_id-container");
                                                var select2_designation_id_container = document.getElementById("select2-designation_id-container");
                                                var select2_shift_id_container = document.getElementById("select2-shift_id-container");
                                                var select2_country_id_container = document.getElementById("select2-country_id-container");
                                                var select2_state_id_container = document.getElementById("select2-state_id-container");
                                                var select2_city_id_container = document.getElementById("select2-city_id-container");
                                                if (select2_department_id_container) {
                                                    select2_department_id_container.removeAttribute("title");
                                                    select2_department_id_container.innerHTML = '<span class="select2-selection__placeholder">Select</span>';
                                                }
                                                if (select2_team_id_container) {
                                                    select2_team_id_container.removeAttribute("title");
                                                    select2_team_id_container.innerHTML = '<span class="select2-selection__placeholder">Select</span>';
                                                }
                                                if (select2_designation_id_container) {
                                                    select2_designation_id_container.removeAttribute("title");
                                                    select2_designation_id_container.innerHTML = '<span class="select2-selection__placeholder">Select</span>';
                                                }
                                                if (select2_shift_id_container) {
                                                    select2_shift_id_container.removeAttribute("title");
                                                    select2_shift_id_container.innerHTML = '<span class="select2-selection__placeholder">Select</span>';
                                                }
                                                if (select2_country_id_container && select2_state_id_container && select2_city_id_container) {
                                                    select2_country_id_container.removeAttribute("title");
                                                    select2_state_id_container.removeAttribute("title");
                                                    select2_city_id_container.removeAttribute("title");
                                                    select2_country_id_container.innerHTML = select2_state_id_container.innerHTML = select2_city_id_container.innerHTML = '<span class="select2-selection__placeholder">Select</span>';
                                                }
                                                designation_id.innerHTML = state_id.innerHTML = city_id.innerHTML = '';
                                                country_id.value = '';
                                            }
                                            loader(false);
                                            toasterTrigger(obj.toasterClass, obj.responseMessage);
                                        }
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