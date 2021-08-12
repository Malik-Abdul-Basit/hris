<?php
include_once("header/check_login.php");
if (isset($_GET['emp_id']) && is_numeric($_GET['emp_id']) && !empty($_GET['emp_id'])) {
    $select = "SELECT 
    e.employee_code, e.status,
    eb.*,
    CONCAT(eb.first_name, ' ', eb.last_name) AS full_name,
    dep.name AS department_name,
    desg.name AS designation_name,
    team.name AS team_name
    FROM
        employees AS e
            INNER JOIN 
        employee_basic_infos AS eb
            ON e.id = eb.employee_id
            INNER JOIN
        departments AS dep
            ON e.department_id = dep.id
            INNER JOIN
        designations AS desg
            ON e.designation_id = desg.id
            LEFT JOIN
        teams AS team
            ON e.team_id = team.id
    WHERE e.id='{$_GET['emp_id']}' ORDER BY e.id ASC LIMIT 1";
    $query = mysqli_query($db, $select);
    if (mysqli_num_rows($query) != 1) {
        header('Location: ' . $page_not_found_url);
    } else {
        $result = mysqli_fetch_object($query);
    }
} else {
    header('Location: ' . $page_not_found_url);
}
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
                        <div class=" container ">
                            <!--begin::Profile Personal Information-->
                            <div class="d-flex flex-row">
                                <!--begin::Aside-->
                                <?php include_once('../includes/profile_menu.php'); ?>
                                <!--end::Aside-->

                                <!--begin::Content-->
                                <div class="flex-row-fluid ml-lg-8">
                                    <!--begin::Card-->

                                    <div class="card card-custom card-stretch">

                                        <!--begin::Header-->
                                        <div class="card-header py-3">
                                            <div class="card-title">
                                                <h3 class="card-label font-weight-bolder text-dark">
                                                    <?php echo $child_menu_name; ?>
                                                </h3>
                                            </div>
                                            <div id="actionButtons"></div>
                                        </div>
                                        <!--end::Header-->

                                        <!--begin::Form-->
                                        <form class="form">
                                            <div class="card-body">
                                                <div id="dataListingWrapper"></div>
                                            </div>
                                        </form>
                                        <!--end::Form-->
                                        </div>
                                </div>
                                <!--end::Content-->
                            </div>
                            <!--end::Profile Personal Information-->
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
        getData();

        function getData() {
            var filter = {
                'employee_id': '<?php echo $result->employee_id; ?>',
                'employee_code': '<?php echo $result->employee_code; ?>',
            };

            loader(true);
            $.ajax({
                type: "POST", url: 'ajax/fetch/qualification_overview.php',
                data: {'filters': filter},
                success: function (resPonse) {
                    if (resPonse !== undefined && resPonse != '') {
                        var obj = JSON.parse(resPonse);
                        if (obj.code === 200) {
                            document.getElementById('actionButtons').innerHTML = obj.actionButtons;
                            document.getElementById('dataListingWrapper').innerHTML = obj.data;
                            loader(false);
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

        function entryDelete(id, emp) {
            Swal.fire({
                title: 'Are you sure want to delete?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!'
            }).then(function (result) {
                if (result.value) {
                    var D = '<?php echo hasRight('employee_qualification', 'delete') ?>';
                    if (D) {
                        loader(true);
                        $.ajax({
                            type: "POST", url: "ajax/delete.php",
                            data: "delete_employee_qualification=" + id + "&emp=" + emp,
                            success: function (resPonse) {
                                if (resPonse !== undefined && resPonse != '') {
                                    var obj = JSON.parse(resPonse);
                                    if (obj.code === 200 || obj.code === 405) {
                                        if (obj.code === 200) {
                                            getData();
                                            Swal.fire({
                                                icon: 'success',
                                                title: obj.responseMessage,
                                                showConfirmButton: false,
                                                timer: 1200
                                            });
                                        } else {
                                            loader(false);
                                        }
                                        toasterTrigger(obj.toasterClass, obj.responseMessage);
                                    }
                                } else {
                                    loader(false);
                                }
                            },
                            error: function () {
                                loader(false);
                            }
                        });
                    } else {
                        toasterTrigger('error', 'Sorry! You have no right to delete record.');
                    }
                }
            });
        }
    </script>
<?php include_once("../includes/endTags.php"); ?>