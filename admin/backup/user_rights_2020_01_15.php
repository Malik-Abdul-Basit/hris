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
                                                                    foreach (config("users.type.title") as $key => $value) {
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
                                                        <div id="Data_Holder_Parent_Div">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label><b>* Branch:</b></label>
                                                                        <select tabindex="40"
                                                                                id="branch_id" <?php echo $TAttrs . $onblur; ?>>
                                                                            <?php
                                                                            $working = config('branches.status.value.working');
                                                                            $select = "SELECT `id`,`name` FROM `branches` WHERE `company_id`='{$global_company_id}' AND `status`='{$working}' AND `deleted_at` IS NULL ORDER BY `type` ASC";
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
                                                                <table class="datatable-table d-block">
                                                                    <thead class="datatable-head">
                                                                    <tr style="left:0" class="datatable-row">
                                                                        <th class="datatable-cell datatable-cell-left">
                                                                            <div class="float-left" style="width:30%"
                                                                                 data-field="name">Name
                                                                            </div>
                                                                            <div class="float-left" style="width:70%"
                                                                                 data-field="action">Action
                                                                            </div>
                                                                        </th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody class="datatable-body">
                                                                    <?php
                                                                    $m_active = config('main_menus.status.value.active');
                                                                    $s_active = config('sub_menus.status.value.active');
                                                                    $c_active = config('child_menus.status.value.active');
                                                                    $select = "SELECT c.id, c.user_right_title, c.sub_menu_id, s.main_menu_id
                                                                    FROM
                                                                        child_menus AS c
                                                                    INNER JOIN
                                                                        sub_menus AS s
                                                                        ON c.sub_menu_id=s.id
                                                                    INNER JOIN
                                                                        main_menus AS m
                                                                        ON s.main_menu_id=m.id
                                                                    WHERE c.user_right_title IS NOT NULL AND  c.user_right_title !=''
                                                                    AND m.status = '{$m_active}' AND s.status = '{$s_active}' AND c.status = '{$c_active}'
                                                                    GROUP BY c.user_right_title
                                                                    ORDER BY m.sort_by, s.sort_by, c.sort_by";
                                                                    $query = mysqli_query($db, $select);
                                                                    if (mysqli_num_rows($query) > 0) {
                                                                        while ($result = mysqli_fetch_object($query)) {
                                                                            $user_right_title = ucwords(str_replace('_', ' ', $result->user_right_title));
                                                                            ?>
                                                                            <tr style="left:0" data-row="1"
                                                                                class="datatable-row datatable-row-odd">
                                                                                <td class="datatable-cell datatable-cell-left py-5">
                                                                                    <div class="float-left pt-2 font-weight-bolder"
                                                                                         style="width:30%"
                                                                                         data-field="name">
                                                                                        <?php echo $user_right_title; ?>
                                                                                    </div>
                                                                                    <div class="float-left"
                                                                                         style="width:70%"
                                                                                         data-field="action">
                                                                                        <?php
                                                                                        $select1 = "SELECT c.id, c.action, c.sub_menu_id, s.main_menu_id
                                                                                        FROM
                                                                                            child_menus AS c
                                                                                        INNER JOIN
                                                                                            sub_menus AS s
                                                                                        ON c.sub_menu_id=s.id
                                                                                        INNER JOIN
                                                                                            main_menus AS m
                                                                                        ON s.main_menu_id=m.id
                                                                                        WHERE c.user_right_title ='{$result->user_right_title}'
                                                                                        ORDER BY c.sort_by ASC";
                                                                                        $query1 = mysqli_query($db, $select1);
                                                                                        if (mysqli_num_rows($query1) > 0) {
                                                                                            while ($result1 = mysqli_fetch_object($query1)) {
                                                                                                $child_id = $result1->id;
                                                                                                $action = json_decode($result1->action, true);
                                                                                                $switch_array = ['add' => 'primary', 'edit' => 'success', 'delete' => 'danger', 'view' => 'warning',];
                                                                                                foreach ($action as $action_key => $action_value) {
                                                                                                    ?>
                                                                                                    <div class="form-group float-left overflow-hidden m-0 mr-5">
                                                                                                        <label class="col-form-label float-left font-weight-bolder mr-1"
                                                                                                               style="padding: 5px 3px 0 0"><?php echo $action_value; ?></label>
                                                                                                        <div class="float-left">
                                                                                                <span class="switch switch-sm switch-outline switch-icon switch-<?php echo $switch_array[$action_key]; ?>">
                                                                                                    <label>
                                                                                                        <input type="checkbox"
                                                                                                               name="select">
                                                                                                        <span></span>
                                                                                                    </label>
                                                                                                </span>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <?php
                                                                                                }
                                                                                            }
                                                                                        }


                                                                                        ?>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>


                                                                    </tbody>


                                                                </table>
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

            var employee_code = document.getElementById('employee_code');

            var errorMessageEmployeeCode = document.getElementById('errorMessageEmployeeCode');
            var responseMessageWrapper = document.getElementById('responseMessageWrapper');
            var responseMessage = document.getElementById('responseMessage');

            employee_code.style.borderColor = '#E4E6EF';
            errorMessageEmployeeCode.innerText = responseMessage.innerText = '';
            responseMessageWrapper.style.display = "none";

        }

        function getEmployee(code) {
            loader(true);
            var employee_code = document.getElementById('employee_code');
            var emp_email = document.getElementById('emp_email');
            var full_name = document.getElementById('full_name');
            var emp_pseudo_name = document.getElementById('emp_pseudo_name');

            var errorMessageEmployeeCode = document.getElementById('errorMessageEmployeeCode');
            var employeeImageWrapper = document.getElementById('employee_image_wrapper');
            var responseMessageWrapper = document.getElementById('responseMessageWrapper');
            var responseMessage = document.getElementById('responseMessage');

            emp_email.value = full_name.value = emp_pseudo_name.value = errorMessageEmployeeCode.innerText = employeeImageWrapper.innerHTML = responseMessage.innerText = '';
            responseMessageWrapper.style.display = "none";

            var postData = {"code": code};
            $.ajax({
                type: "POST", url: "ajax/common.php",
                data: {'postData': postData, 'getEmployee': true},
                success: function (resPonse) {
                    if (resPonse !== undefined && resPonse != '') {
                        var obj = JSON.parse(resPonse);
                        if (obj.code !== undefined && obj.code != '') {
                            if (obj.code === 200) {
                                emp_email.value = obj.email;
                                full_name.value = obj.full_name;
                                emp_pseudo_name.value = obj.pseudo_name;
                                employeeImageWrapper.innerHTML = '<div class="employee_image_portion"><img src="' + obj.image + '" alt="' + code + '"></div>';
                                getUserRights(obj.id);
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

        function getUserRights(id) {
            var postData = {"id": id};
            $.ajax({
                type: "POST", url: "ajax/common.php",
                data: {'postData': postData, 'getUserRights': true},
                success: function (resPonse) {
                    if (resPonse !== undefined && resPonse != '') {
                        var obj = JSON.parse(resPonse);
                        if (obj.code !== undefined && obj.code != '') {
                            if (obj.code === 200 && obj.type !== undefined && obj.status !== undefined) {
                                document.getElementById('type').value = obj.type;
                                document.getElementById('status').value = obj.status;
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