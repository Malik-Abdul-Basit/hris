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
                            <div class="card card-custom">
                                <div class="card-header flex-wrap py-5">
                                    <div class="card-title">
                                        <h3 class="card-label">
                                            <?php echo ucwords(str_replace("_", " ", $page)); ?>
                                        </h3>
                                    </div>
                                    <div class="card-toolbar">
                                        <?php
                                        if (hasRight($user_right_title, 'add')) {
                                            echo '<a href="' . $admin_url . 'branch" class="btn btn-primary font-weight-bolder"><i class="la la-plus"></i>New Record</a>';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="mb-7">
                                        <div class="row align-items-center">
                                            <div class="col-xl-12">
                                                <div class="row align-items-center">

                                                    <div class="col-md-3 my-2 my-md-0">
                                                        <div class="input-icon">
                                                            <input type="text" onkeyup="getData()" class="form-control"
                                                                   placeholder="Search..." id="BG_SearchQuery">
                                                            <span><i class="flaticon2-search-1 text-muted"></i></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 my-2 my-md-0">
                                                        <div class="form-group">
                                                            <label for="BG_CountryIdFilter">Country</label>
                                                            <select class="form-control"
                                                                    id="BG_CountryIdFilter"
                                                                    onchange="getData(), getStates(this.value)">
                                                                <option selected="selected" value="">Select
                                                                </option>
                                                                <?php
                                                                $select = "SELECT `id`,`country_name` FROM `countries`";
                                                                $query = mysqli_query($db, $select);
                                                                if (mysqli_num_rows($query) > 0) {
                                                                    while ($result = mysqli_fetch_object($query)) {
                                                                        ?>
                                                                        <option value="<?php echo $result->id; ?>"><?php echo $result->country_name; ?></option>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 my-2 my-md-0">
                                                        <div class="form-group">
                                                            <label for="state_id">State</label>
                                                            <select class="form-control"
                                                                    id="state_id"
                                                                    onchange="getCities(event), getData()">
                                                                <option selected="selected" value="">Select
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 my-2 my-md-0">
                                                        <div class="form-group">
                                                            <label for="city_id">City</label>
                                                            <select class="form-control" id="city_id"
                                                                    onchange="getData()">
                                                                <option selected="selected" value="">Select
                                                                </option>
                                                            </select>
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

            var BG_CountryIdFilter = document.getElementById('BG_CountryIdFilter');
            var BG_StateIdFilter = document.getElementById('state_id');
            var BG_CityIdFilter = document.getElementById('city_id');

            var SearchQuery = '';
            var PageNumber = "1";
            var PageSize = "10";
            var SortColumn = 'b.id';
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
                'Filter': [
                    {'field': 'b.country_id', 'value': BG_CountryIdFilter.value},
                    {'field': 'b.state_id', 'value': BG_StateIdFilter.value},
                    {'field': 'b.city_id', 'value': BG_CityIdFilter.value},
                ],
                'Numbering': {
                    'field': 'sr',
                    'title': '#',
                    'text': 'center',
                    'style': 'style="width:30px"',
                    'sort': false
                },
                'Header': [
                    {
                        'field': 'name',
                        'title': 'Name',
                        'text': 'left',
                        'style': 'style="font-size: 11px;width:70px"',
                        'sort': true
                    },
                    {
                        'field': 'emails',
                        'title': 'E-Mails',
                        'text': 'left',
                        'style': 'style="font-size: 11px;width:150px"',
                        'sort': true
                    },
                    {
                        'field': 'numbers',
                        'title': 'Contact No',
                        'text': 'left',
                        'style': 'style="font-size: 11px;width:150px"',
                        'sort': true
                    },
                    {
                        'field': 'country_name',
                        'title': 'Country',
                        'text': 'left',
                        'style': 'style="font-size: 11px;width:65px"',
                        'sort': true
                    },
                    {
                        'field': 'state_name',
                        'title': 'State',
                        'text': 'left',
                        'style': 'style="font-size: 11px;width:60px"',
                        'sort': true
                    },
                    {
                        'field': 'city_name',
                        'title': 'City',
                        'text': 'left',
                        'style': 'style="font-size: 11px;width:65px"',
                        'sort': true
                    },
                    {
                        'field': 'address',
                        'title': 'Address',
                        'text': 'left',
                        'style': 'style="font-size: 11px;width:135px"',
                        'sort': true
                    },
                    {
                        'field': 'type',
                        'title': 'Type',
                        'text': 'left',
                        'style': 'style="font-size: 11px;width:115px"',
                        'sort': true
                    },
                    {
                        'field': 'status',
                        'title': 'Status',
                        'text': 'left',
                        'style': 'style="font-size: 11px;width:70px"',
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
            getAllBranches(filter);
        }

        function getAllBranches(filter) {
            loader(true);
            $.ajax({
                type: "POST", url: 'ajax/fetch/branches.php',
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

        function getStates(id) {
            var postData = {"country_id": id};
            $.ajax({
                type: "POST", url: "ajax/common.php",
                data: {'postData': postData, 'getStates': true},
                success: function (resPonse) {
                    if (resPonse !== undefined && resPonse != '') {
                        var obj = JSON.parse(resPonse);
                        if (obj.code !== undefined && obj.code != '' && obj.code === 200) {
                            if (obj.StatesList !== undefined && obj.StatesList != '') {
                                document.getElementById('state_id').innerHTML = obj.StatesList;
                            }
                        }
                    }
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
                            data: "delete_branch=" + id,
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