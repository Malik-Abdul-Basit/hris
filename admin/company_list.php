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
                            <!--begin::Notice-->
                            <!--<div class="alert alert-custom alert-white alert-shadow gutter-b" role="alert">
                                <div class="alert-icon">
                                    <span class="svg-icon svg-icon-primary svg-icon-xl">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"/>
                                                <path d="M7.07744993,12.3040451 C7.72444571,13.0716094 8.54044565,13.6920474 9.46808594,14.1079953 L5,23 L4.5,18 L7.07744993,12.3040451 Z M14.5865511,14.2597864 C15.5319561,13.9019016 16.375416,13.3366121 17.0614026,12.6194459 L19.5,18 L19,23 L14.5865511,14.2597864 Z M12,3.55271368e-14 C12.8284271,3.53749572e-14 13.5,0.671572875 13.5,1.5 L13.5,4 L10.5,4 L10.5,1.5 C10.5,0.671572875 11.1715729,3.56793164e-14 12,3.55271368e-14 Z" fill="#000000" opacity="0.3"/>
                                                <path d="M12,10 C13.1045695,10 14,9.1045695 14,8 C14,6.8954305 13.1045695,6 12,6 C10.8954305,6 10,6.8954305 10,8 C10,9.1045695 10.8954305,10 12,10 Z M12,13 C9.23857625,13 7,10.7614237 7,8 C7,5.23857625 9.23857625,3 12,3 C14.7614237,3 17,5.23857625 17,8 C17,10.7614237 14.7614237,13 12,13 Z" fill="#000000" fill-rule="nonzero"/>
                                            </g>
                                        </svg>
                                    </span>
                                </div>
                                <div class="alert-text">
                                    You can use the dom initialisation parameter to move DataTables features around the table to where you want them. See official documentation
                                    <a class="font-weight-bold" href="https://datatables.net/examples/advanced_init/dom_multiple_elements.html" target="_blank">here</a>.
                                </div>
                            </div>-->
                            <!--end::Notice-->

                            <!--begin::Card-->
                            <div class="card card-custom">
                                <div class="card-header flex-wrap py-5">
                                    <div class="card-title">
                                        <h3 class="card-label">
                                            <?php echo ucwords(str_replace("_", " ", $page)); ?>
                                        </h3>
                                    </div>
                                    <div class="card-toolbar">
                                        <!--begin::Dropdown-->
                                        <!--
                                        <div class="dropdown dropdown-inline mr-2">
                                            <button type="button" class="btn btn-light-primary font-weight-bolder dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="la la-download"></i> Export
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                                <ul class="nav flex-column nav-hover">
                                                    <li class="nav-header font-weight-bolder text-uppercase  text-primary pb-2">
                                                        Choose an option:
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="#" class="nav-link">
                                                            <i class="nav-icon la la-print"></i>
                                                            <span class="nav-text">Print</span>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="#" class="nav-link">
                                                            <i class="nav-icon la la-copy"></i>
                                                            <span class="nav-text">Copy</span>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="#" class="nav-link">
                                                            <i class="nav-icon la la-file-excel-o"></i>
                                                            <span class="nav-text">Excel</span>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="#" class="nav-link">
                                                            <i class="nav-icon la la-file-text-o"></i>
                                                            <span class="nav-text">CSV</span>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="#" class="nav-link">
                                                            <i class="nav-icon la la-file-pdf-o"></i>
                                                            <span class="nav-text">PDF</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>-->
                                        <!--end::Dropdown-->
                                        <?php
                                        if (hasRight($user_right_title, 'add')) {
                                            echo '<a href="' . $admin_url . 'company" class="btn btn-primary font-weight-bolder"><i class="la la-plus"></i>New Record</a>';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="mb-7">
                                        <div class="row align-items-center">
                                            <div class="col-lg-9 col-xl-8">
                                                <div class="row align-items-center">
                                                    <div class="col-md-4 my-2 my-md-0">
                                                        <div class="input-icon">
                                                            <input type="text" onkeyup="getData()" class="form-control"
                                                                   placeholder="Search..." id="BG_SearchQuery">
                                                            <span><i class="flaticon2-search-1 text-muted"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded"
                                         id="dataListingWrapper"></div>
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
            var SearchQuery = '';
            var PageNumber = "1";
            var PageSize = "10";
            var SortColumn = 'id';
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
                'L': '<?php echo $user_right_title; ?>',
                'SearchQuery': SearchQuery,
                'PageNumber': PageNumber,
                'PageSize': PageSize,
                'Sort': {'SortColumn': SortColumn, 'SortOrder': SortOrder},
                'Numbering': {
                    'field': 'sr',
                    'title': '#',
                    'text': 'center',
                    'style': 'style="width:40px"',
                    'sort': false
                },
                'Header': [
                    {'field': 'id', 'title': 'ID', 'text': 'left', 'style': 'style="width:50px"', 'sort': true},
                    {'field': 'name', 'title': 'Name', 'text': 'left', 'style': 'style="width:450px"', 'sort': true},
                    {
                        'field': 'status',
                        'title': 'Status',
                        'text': 'left',
                        'style': 'style="width:110px"',
                        'sort': true
                    },
                ],
                'Actions': {
                    'field': 'actions',
                    'title': 'Actions',
                    'text': 'left',
                    'style': 'style="overflow: visible; position: relative; width:125px"',
                    'sort': false
                },
                "PageSizeStack": ["5", "10", "20", "30", "40", "50"]
            };
            getAllCompanies(filter);
        }

        function getAllCompanies(filter) {
            loader(true);
            $.ajax({
                type: "POST", url: 'ajax/fetch/companies.php',
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

        function entryDelete(id) {
            Swal.fire({
                title: 'Are you sure want to delete?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!'
            }).then(function (result) {
                if (result.value) {
                    var D = '<?php echo hasRight($user_right_title, 'delete') ?>';
                    if (D) {
                        loader(true);
                        $.ajax({
                            type: "POST", url: "ajax/delete.php",
                            data: "delete_company=" + id,
                            success: function (resPonse) {
                                if (resPonse !== undefined && resPonse != '') {
                                    var obj = JSON.parse(resPonse);
                                    if (obj.code === 200 || obj.code === 405 || obj.code === 422) {
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