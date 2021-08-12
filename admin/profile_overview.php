<?php
include_once("header/check_login.php");
if (isset($_GET['emp_id']) && is_numeric($_GET['emp_id']) && !empty($_GET['emp_id'])) {
    $select = "SELECT 
    e.employee_code, e.status,
    eb.*,
    CONCAT(eb.first_name, ' ', eb.last_name) AS full_name,
    CONCAT('+', eb.dial_code, ' ', eb.mobile) AS contact_no,
    CONCAT('+', eb.o_dial_code, ' ', eb.other_mobile) AS other_contact_no,
    CONCAT('+', eb.guardian_dial_code, ' ', eb.guardian_mobile) AS guardian_mobile_no,
    dep.name AS department_name,
    desg.name AS designation_name,
    team.name AS team_name,
    country.country_name, state.state_name, city.city_name
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
            INNER JOIN
        countries AS country
            ON eb.country_id = country.id
            INNER JOIN
        states AS state
            ON eb.state_id = state.id
            INNER JOIN
        cities AS city
            ON eb.city_id = city.id
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
                                            <div class="card-title"><!-- align-items-start flex-column -->
                                                <h3 class="card-label font-weight-bolder text-dark">
                                                    <?php echo $child_menu_name; ?>
                                                </h3>
                                            </div>

                                            <?php
                                            if(hasRight('employee', 'edit')){
                                                ?>
                                                <div class="dropdown dropdown-inline mt-3">
                                                    <a href="javascript:;"
                                                       class="btn btn-clean btn-hover-light-primary btn-sm btn-icon"
                                                       data-toggle="dropdown" aria-haspopup="true"
                                                       aria-expanded="false">
                                                        <i class="ki ki-bold-more-hor"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                                        <ul class="navi navi-hover py-1">
                                                            <li class="navi-item">
                                                                <a href="<?php echo $admin_url; ?>employee?id=<?php echo $result->employee_id; ?>&emp_code=<?php echo $result->employee_code; ?>"
                                                                   class="navi-link">
                                                                    <span class="navi-icon"><i
                                                                                class="flaticon2-pen"></i></span>
                                                                    <span class="navi-text">Edit</span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <!--end::Header-->

                                        <!--begin::Form-->
                                        <form class="form">
                                            <!--begin::Body-->
                                            <div class="card-body">
                                                <div class="row mb-2">
                                                    <div class="col-xl-6 col-lg-6 mb-2">
                                                        <div class="row">
                                                            <label class="col-sm-6"><b>Full Name</b></label>
                                                            <div class="col-sm-6">
                                                                <?php echo config("employee_basic_infos.title.title." . $result->title) . ' ' . $result->full_name; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 mb-2">
                                                        <div class="row">
                                                            <label class="col-sm-6"><b>Father's Name</b></label>
                                                            <div class="col-sm-6">
                                                                <?php echo $result->father_name; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 mb-2">
                                                        <div class="row">
                                                            <label class="col-sm-6"><b>Official Email</b></label>
                                                            <div class="col-sm-6">
                                                                <a class="text-muted text-hover-primary"
                                                                   href="mailto:<?php echo $result->official_email; ?>"><?php echo $result->official_email; ?></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 mb-2">
                                                        <div class="row">
                                                            <label class="col-sm-6"><b>Email</b></label>
                                                            <div class="col-sm-6">
                                                                <a class="text-muted text-hover-primary"
                                                                   href="mailto:<?php echo $result->email; ?>"><?php echo $result->email; ?></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 mb-2">
                                                        <div class="row">
                                                            <label class="col-sm-6"><b>Mobile No</b></label>
                                                            <div class="col-sm-6">
                                                                <?php echo $result->contact_no; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 mb-2">
                                                        <div class="row">
                                                            <label class="col-sm-6"><b>Emergency Contact</b></label>
                                                            <div class="col-sm-6">
                                                                <?php echo $result->other_contact_no; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 mb-2">
                                                        <div class="row">
                                                            <label class="col-sm-6"><b>Relation</b> <small>(With
                                                                    Emergency No.)</small></label>
                                                            <div class="col-sm-6">
                                                                <?php
                                                                if (!empty($result->relation)) {
                                                                    echo config("employee_basic_infos.relation.title." . $result->relation);
                                                                } else {
                                                                    echo '-';
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    if (!empty($result->phone)) {
                                                        ?>
                                                        <div class="col-xl-6 col-lg-6 mb-2">
                                                            <div class="row">
                                                                <label class="col-sm-6"><b>Phone No</b></label>
                                                                <div class="col-sm-6">
                                                                    <?php echo $result->phone; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                    if (!empty($result->old_cnic)) {
                                                        ?>
                                                        <div class="col-xl-6 col-lg-6 mb-2">
                                                            <div class="row">
                                                                <label class="col-sm-6"><b>Old CNIC</b></label>
                                                                <div class="col-sm-6">
                                                                    <?php echo $result->old_cnic; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                    <div class="col-xl-6 col-lg-6 mb-2">
                                                        <div class="row">
                                                            <label class="col-sm-6"><b>CNIC</b></label>
                                                            <div class="col-sm-6">
                                                                <?php echo $result->cnic; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    if (!empty($result->cnic_expiry)) {
                                                        ?>
                                                        <div class="col-xl-6 col-lg-6 mb-2">
                                                            <div class="row">
                                                                <label class="col-sm-6"><b>CNIC Expiry</b></label>
                                                                <div class="col-sm-6">
                                                                    <?php echo date('d M Y', strtotime($result->cnic_expiry)); ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                    <div class="col-xl-6 col-lg-6 mb-2">
                                                        <div class="row">
                                                            <label class="col-sm-6"><b>Date & Place of
                                                                    Birth</b></label>
                                                            <div class="col-sm-6">
                                                                <?php echo date('d M Y', strtotime($result->dob)); ?>
                                                                (<?php echo $result->pob; ?>)
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 mb-2">
                                                        <div class="row">
                                                            <label class="col-sm-6"><b>Blood Group & Gender</b></label>
                                                            <div class="col-sm-6">
                                                                <?php echo config("employee_basic_infos.blood_group.title." . $result->blood_group); ?>
                                                                (<?php echo config("employee_basic_infos.gender.title." . $result->gender); ?>
                                                                )
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 mb-2">
                                                        <div class="row">
                                                            <label class="col-sm-6"><b>Marital Status</b></label>
                                                            <div class="col-sm-6">
                                                                <?php echo config("employee_basic_infos.marital_status.title." . $result->marital_status); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    if (!empty($result->religion) || !empty($result->sect)) {
                                                        ?>
                                                        <div class="col-xl-6 col-lg-6 mb-2">
                                                            <div class="row">
                                                                <label class="col-sm-6"><b>
                                                                        <?php
                                                                        if (!empty($result->religion) && !empty($result->sect)) {
                                                                            echo 'Religion & Sect';
                                                                        } elseif (!empty($result->religion) && empty($result->sect)) {
                                                                            echo 'Religion';
                                                                        } elseif (empty($result->religion) && !empty($result->sect)) {
                                                                            echo 'Sect';
                                                                        }
                                                                        ?>
                                                                    </b></label>
                                                                <div class="col-sm-6">
                                                                    <?php
                                                                    if (!empty($result->religion) && !empty($result->sect)) {
                                                                        echo $result->religion . ' (' . $result->sect . ')';
                                                                    } elseif (!empty($result->religion) && empty($result->sect)) {
                                                                        echo $result->religion;
                                                                    } elseif (empty($result->religion) && !empty($result->sect)) {
                                                                        echo $result->sect;
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                    <div class="col-xl-6 col-lg-6 mb-2">
                                                        <div class="row">
                                                            <label class="col-sm-6"><b>City, State, Country</b></label>
                                                            <div class="col-sm-6">
                                                                <?php echo $result->city_name . ', ' . $result->state_name . ', ' . $result->country_name; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-xl-6 col-lg-6 mb-2">
                                                        <div class="row">
                                                            <label class="col-sm-6"><b>Address</b></label>
                                                            <div class="col-sm-6">
                                                                <?php echo $result->address; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 mb-2">
                                                        <div class="row">
                                                            <label class="col-sm-6"><b>Permanent Address</b></label>
                                                            <div class="col-sm-6">
                                                                <?php echo $result->permanent_address; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-xl-3 col-lg-3"><b>Personal History</b></label>
                                                    <div class="col-lg-9 col-xl-6">
                                                        <?php echo !empty($result->personal_history) ? $result->personal_history : '-'; ?>
                                                    </div>
                                                </div>

                                                <div class="separator separator-dashed my-7"></div>

                                                <div class="row mb-2">
                                                    <div class="col-xl-12">
                                                        <h3 class="font-size-lg text-dark-75 font-weight-bold mb-8">
                                                            Guardian Information:
                                                        </h3>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-xl-6 col-lg-6 mb-2">
                                                        <div class="row">
                                                            <label class="col-sm-6"><b>Name</b></label>
                                                            <div class="col-sm-6">
                                                                <?php echo $result->guardian_name; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 mb-2">
                                                        <div class="row">
                                                            <label class="col-sm-6"><b>Mobile No.</b></label>
                                                            <div class="col-sm-6">
                                                                <?php
                                                                if(!empty($result->guardian_mobile)){
                                                                    echo $result->guardian_mobile_no;
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 mb-2">
                                                        <div class="row">
                                                            <label class="col-sm-6"><b>CNIC</b></label>
                                                            <div class="col-sm-6">
                                                                <?php echo $result->guardian_cnic; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 mb-2">
                                                        <div class="row">
                                                            <label class="col-sm-6"><b>Relation</b></label>
                                                            <div class="col-sm-6">
                                                                <?php
                                                                if (!empty($result->guardian_relation)) {
                                                                    echo config("employee_basic_infos.relation.title." . $result->relation);
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Body-->
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

    </script>
<?php include_once("../includes/endTags.php"); ?>