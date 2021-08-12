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
                                    <div class="card card-custom box-shadow-none">
                                        <div class="card-header flex-wrap py-5">
                                            <div class="card-title">
                                                <h3 class="card-label">
                                                    <?php echo ucwords(str_replace("_", " ", $page)); ?>
                                                    <!--<span class="d-block text-muted pt-2 font-size-sm">Sorting & pagination remote datasource</span>-->
                                                </h3>
                                            </div>
                                            <div class="card-toolbar"></div>
                                        </div>
                                        <div class="card-header flex-wrap border-0 pt-6 pb-6">
                                            <!--begin::Search Form-->
                                            <div class="mb-7 d-block" style="width: 100%">
                                                <div class="row align-items-center">
                                                    <div class="col-lg-12 col-xl-12">
                                                        <div class="row align-items-center">
                                                            <div class="col-md-2 my-2 my-md-0">
                                                                <div class="form-group">
                                                                    <label for="BG_SearchQuery">Search</label>
                                                                    <div class="input-icon">
                                                                        <input type="text" onkeyup="getData()"
                                                                               class="form-control"
                                                                               placeholder="Search..."
                                                                               id="BG_SearchQuery">
                                                                        <span><i class="flaticon2-search-1 text-muted"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 my-2 my-md-0">
                                                                <div class="form-group">
                                                                    <label for="BG_DepartmentFilter">Department</label>
                                                                    <select class="form-control"
                                                                            id="BG_DepartmentFilter"
                                                                            onchange="getData(), getTeamsAndDesignations(event)">
                                                                        <option value="-1">All</option>
                                                                        <?php
                                                                        $select = "SELECT `id`,`name` FROM `departments` WHERE `company_id`='{$global_company_id}' AND `branch_id`='{$global_branch_id}' AND `deleted_at` IS NULL ORDER BY `sort_by` ASC";
                                                                        $query = mysqli_query($db, $select);
                                                                        if (mysqli_num_rows($query) > 0) {
                                                                            while ($result = mysqli_fetch_object($query)) {
                                                                                ?>
                                                                                <option value="<?php echo $result->id; ?>"><?php echo $result->name; ?></option>
                                                                                <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 my-2 my-md-0">
                                                                <div class="form-group">
                                                                    <label for="BG_DesignationFilter">
                                                                        Designation</label>
                                                                    <select class="form-control"
                                                                            id="BG_DesignationFilter"
                                                                            onchange="getData()">
                                                                        <option value="-1">All</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2 my-2 my-md-0">
                                                                <div class="form-group">
                                                                    <label for="BG_StatusFilter">Status</label>
                                                                    <select class="form-control"
                                                                            id="BG_StatusFilter" onchange="getData()">
                                                                        <option value="-1">All</option>
                                                                        <?php
                                                                        foreach (config('users.status.title') as $key => $val) {
                                                                            echo '<option value="' . $key . '">' . $val . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2 my-2 my-md-0">
                                                                <div class="form-group">
                                                                    <label for="BG_TypeFilter">Roles</label>
                                                                    <select class="form-control"
                                                                            id="BG_TypeFilter"
                                                                            onchange="getData()">
                                                                        <option value="-1">All</option>
                                                                        <?php
                                                                        $roles = config('users.type.title');
                                                                        unset($roles[1]);
                                                                        foreach ($roles as $key => $val) {
                                                                            echo '<option value="' . $key . '">' . $val . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Search Form-->
                                        </div>

                                        <div class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded gridListingStyleWrapper no-header"
                                             id="dataListingWrapper"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
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

        function setPageNo(p) {
            document.getElementById('BG_PageNumber').value = p;
            getData();
        }

        function setSort(e) {
            var field = e.target.dataset.field;
            var sort = e.target.dataset.sort;
            var BG_SortColumn = document.getElementById('BG_SortColumn');
            var BG_SortOrder = document.getElementById('BG_SortOrder');

            if (field === undefined) {
                var set_field = 'sort_by';
            } else {
                var set_field = field;
            }
            if (sort === undefined || sort == 'DESC' || sort == 'desc') {
                var set_order = 'ASC';
            } else {
                var set_order = 'DESC';
            }

            if (BG_SortColumn) {
                BG_SortColumn.value = set_field;
            }
            if (BG_SortOrder) {
                BG_SortOrder.value = set_order;
            }
            getData();
        }

        function getData() {
            var BG_SearchQuery = document.getElementById('BG_SearchQuery');
            var BG_PageNumber = document.getElementById('BG_PageNumber');
            var BG_PageSize = document.getElementById('BG_PageSize');
            var BG_SortColumn = document.getElementById('BG_SortColumn');
            var BG_SortOrder = document.getElementById('BG_SortOrder');

            var BG_DepartmentFilter = document.getElementById('BG_DepartmentFilter');
            var BG_DesignationFilter = document.getElementById('BG_DesignationFilter');
            var BG_StatusFilter = document.getElementById('BG_StatusFilter');
            var BG_TypeFilter = document.getElementById('BG_TypeFilter');

            var SearchQuery = '';
            var PageNumber = "1";
            var PageSize = "20";
            var SortColumn = 'e.employee_code';
            var SortOrder = 'ASC';
            if (BG_SearchQuery && BG_SearchQuery.value != '') {
                SearchQuery = BG_SearchQuery.value;
            }
            if (BG_PageNumber && BG_PageNumber.value != '') {
                PageNumber = BG_PageNumber.value;
            }
            if (BG_PageSize && BG_PageSize.value != '') {
                PageSize = BG_PageSize.value;
            }
            if (BG_SortColumn && BG_SortColumn.value != '') {
                SortColumn = BG_SortColumn.value;
            }
            if (BG_SortOrder && BG_SortOrder.value != '') {
                SortOrder = BG_SortOrder.value;
            }

            var filter = {
                'L':'<?php echo $user_right_title; ?>',
                'SearchQuery': SearchQuery,
                'PageNumber': PageNumber,
                'PageSize': PageSize,
                'Sort': {'SortColumn': SortColumn, 'SortOrder': SortOrder},
                'Filter': [
                    {'field': 'e.department_id', 'value': BG_DepartmentFilter.value},
                    {'field': 'e.designation_id', 'value': BG_DesignationFilter.value},
                    {'field': 'u.status', 'value': BG_StatusFilter.value},
                    {'field': 'u.type', 'value': BG_TypeFilter.value},
                ],
                "PageSizeStack": ["20", "40", "80", "100"]
            };
            getAllUsers(filter);
        }

        function getAllUsers(filter) {
            loader(true);
            $.ajax({
                type: "POST", url: 'ajax/fetch/users.php',
                data: {'filters': filter},
                success: function (resPonse) {
                    if (resPonse !== undefined && resPonse != '') {
                        var obj = JSON.parse(resPonse);
                        if (obj.code === 200) {
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

    </script>
<?php include_once("../includes/endTags.php"); ?>