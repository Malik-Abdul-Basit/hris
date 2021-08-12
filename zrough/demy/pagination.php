<?php include_once("header/check_login.php"); ?>
<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<?php include_once("../includes/head.php"); ?>
<!--end::Head-->

<!--begin::Body-->
<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
<!--begin::Main-->
<!--begin::Header Mobile-->
<?php include_once("../includes/mobile_menu.php"); ?>
<!--end::Header Mobile-->
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
                <!--begin::Subheader-->
                <div class="subheader py-2 py-lg-6  subheader-solid " id="kt_subheader">
                    <div class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                        <!--begin::Info-->
                        <div class="d-flex align-items-center flex-wrap mr-1">
                            <!--begin::Page Heading-->
                            <div class="d-flex align-items-baseline flex-wrap mr-5">
                                <!--begin::Page Title-->
                                <h5 class="text-dark font-weight-bold my-1 mr-5"><?php  echo ucwords(str_replace("_", " ", $page));  ?></h5>
                                <!--end::Page Title-->

                                <!--begin::Breadcrumb-->
                                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                                    <li class="breadcrumb-item">
                                        <a href="" class="text-muted">Management</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="" class="text-muted"><?php  echo ucwords(str_replace("_", " ", $page));  ?></a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="" class="text-muted">Add</a>
                                    </li>
                                </ul>
                                <!--end::Breadcrumb-->
                            </div>
                            <!--end::Page Heading-->
                        </div>
                        <!--end::Info-->
                    </div>
                </div>
                <!--end::Subheader-->

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

                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-7">
                                            <div class="row align-items-center">
                                                <div class="col-lg-9 col-xl-8">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-4 my-2 my-md-0">
                                                            <div class="input-icon">
                                                                <input type="text" class="form-control" placeholder="Search..." id="BG_SearchQuery">
                                                                <span><i class="flaticon2-search-1 text-muted"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded" id="dataListingWrapper">
                                            <?php
                                            if (isset($_GET['page_no']) && !empty($_GET['page_no'])) {
                                                $page_no = $_GET['page_no'];
                                            }
                                            else {
                                                $page_no = 1;
                                            }

                                            $total_records_per_page = 30;
                                            $offset = ($page_no-1) * $total_records_per_page;
                                            $previous_page = $page_no - 1;
                                            $next_page = $page_no + 1;
                                            $adjacents = "2";

                                            $result_count = mysqli_query($db,"SELECT COUNT(*) As total_records FROM `rough`");
                                            $total_records = mysqli_fetch_array($result_count);
                                            $total_records = $total_records['total_records'];
                                            $total_no_of_pages = ceil($total_records / $total_records_per_page);
                                            $second_last = $total_no_of_pages - 1; // total page minus 1
                                            ?>

                                            <table class="datatable-table" style="display: block;">
                                                <thead class="datatable-head">
                                                <tr class="datatable-row" style="left: 0px;">
                                                    <th data-field="sr"
                                                        class="datatable-cell-center datatable-cell datatable-cell-sort"><span
                                                                style="width: 40px;">#</span></th>
                                                    <th data-field="id" class="datatable-cell datatable-cell-sort"><span
                                                                style="width: 150px;">ID</span></th>
                                                    <th data-field="name" class="datatable-cell datatable-cell-sort"><span
                                                                style="width: 500px;">Name</span></th>
                                                    <th data-field="sort_by" class="datatable-cell datatable-cell-sort"><span
                                                                style="width: 150px;">Sort By</span></th>
                                                    <th data-field="Actions" data-autohide-disabled="false"
                                                        class="datatable-cell-left datatable-cell datatable-cell-sort"><span
                                                                style="width: 125px;">Actions</span></th>
                                                </tr>
                                                </thead>
                                                <tbody class="datatable-body" style="">
                                                <tr data-row="0" class="datatable-row" style="left: 0px;">
                                                    <td class="datatable-cell-center datatable-cell" data-field="sr"
                                                        aria-label="1"><span style="width: 40px;">1</span></td>
                                                    <td data-field="id" aria-label="2" class="datatable-cell"><span
                                                                style="width: 150px;">2</span></td>
                                                    <td data-field="name" aria-label="Billing Department"
                                                        class="datatable-cell"><span
                                                                style="width: 500px;">Billing Department</span></td>
                                                    <td data-field="sort_by" aria-label="1" class="datatable-cell"><span
                                                                style="width: 150px;">1</span></td>
                                                    <td class="datatable-cell-left datatable-cell" data-field="Actions"
                                                        data-autohide-disabled="false" aria-label="null"><span
                                                                style="overflow: visible; position: relative; width: 125px;"><a
                                                                    href="http://localhost/projects/mso_core/admin/designation?id=2"
                                                                    class="btn btn-sm btn-clean btn-icon" title="Edit"><i
                                                                        class="la la-edit"></i></a><button type="button"
                                                                                                           onclick="entryDelete(2)"
                                                                                                           class="btn btn-sm btn-clean btn-icon"
                                                                                                           title="Delete"><i
                                                                        class="la la-trash"></i></button></span></td>
                                                </tr>
                                                <tr data-row="1" class="datatable-row datatable-row-even" style="left: 0px;">
                                                    <td class="datatable-cell-center datatable-cell" data-field="sr"
                                                        aria-label="2"><span style="width: 40px;">2</span></td>
                                                    <td data-field="id" aria-label="3" class="datatable-cell"><span
                                                                style="width: 150px;">3</span></td>
                                                    <td data-field="name" aria-label="Payment Posting Department"
                                                        class="datatable-cell"><span style="width: 500px;">Payment Posting Department</span>
                                                    </td>
                                                    <td data-field="sort_by" aria-label="2" class="datatable-cell"><span
                                                                style="width: 150px;">2</span></td>
                                                    <td class="datatable-cell-left datatable-cell" data-field="Actions"
                                                        data-autohide-disabled="false" aria-label="null"><span
                                                                style="overflow: visible; position: relative; width: 125px;"><a
                                                                    href="http://localhost/projects/mso_core/admin/designation?id=3"
                                                                    class="btn btn-sm btn-clean btn-icon" title="Edit"><i
                                                                        class="la la-edit"></i></a><button type="button"
                                                                                                           onclick="entryDelete(3)"
                                                                                                           class="btn btn-sm btn-clean btn-icon"
                                                                                                           title="Delete"><i
                                                                        class="la la-trash"></i></button></span></td>
                                                </tr>
                                                <tr data-row="2" class="datatable-row" style="left: 0px;">
                                                    <td class="datatable-cell-center datatable-cell" data-field="sr"
                                                        aria-label="3"><span style="width: 40px;">3</span></td>
                                                    <td data-field="id" aria-label="4" class="datatable-cell"><span
                                                                style="width: 150px;">4</span></td>
                                                    <td data-field="name" aria-label="AR Department" class="datatable-cell">
                                                        <span style="width: 500px;">AR Department</span></td>
                                                    <td data-field="sort_by" aria-label="3" class="datatable-cell"><span
                                                                style="width: 150px;">3</span></td>
                                                    <td class="datatable-cell-left datatable-cell" data-field="Actions"
                                                        data-autohide-disabled="false" aria-label="null"><span
                                                                style="overflow: visible; position: relative; width: 125px;"><a
                                                                    href="http://localhost/projects/mso_core/admin/designation?id=4"
                                                                    class="btn btn-sm btn-clean btn-icon" title="Edit"><i
                                                                        class="la la-edit"></i></a><button type="button"
                                                                                                           onclick="entryDelete(4)"
                                                                                                           class="btn btn-sm btn-clean btn-icon"
                                                                                                           title="Delete"><i
                                                                        class="la la-trash"></i></button></span></td>
                                                </tr>
                                                <tr data-row="3" class="datatable-row datatable-row-even" style="left: 0px;">
                                                    <td class="datatable-cell-center datatable-cell" data-field="sr"
                                                        aria-label="4"><span style="width: 40px;">4</span></td>
                                                    <td data-field="id" aria-label="5" class="datatable-cell"><span
                                                                style="width: 150px;">5</span></td>
                                                    <td data-field="name" aria-label="Finance Department"
                                                        class="datatable-cell"><span
                                                                style="width: 500px;">Finance Department</span></td>
                                                    <td data-field="sort_by" aria-label="4" class="datatable-cell"><span
                                                                style="width: 150px;">4</span></td>
                                                    <td class="datatable-cell-left datatable-cell" data-field="Actions"
                                                        data-autohide-disabled="false" aria-label="null"><span
                                                                style="overflow: visible; position: relative; width: 125px;"><a
                                                                    href="http://localhost/projects/mso_core/admin/designation?id=5"
                                                                    class="btn btn-sm btn-clean btn-icon" title="Edit"><i
                                                                        class="la la-edit"></i></a><button type="button"
                                                                                                           onclick="entryDelete(5)"
                                                                                                           class="btn btn-sm btn-clean btn-icon"
                                                                                                           title="Delete"><i
                                                                        class="la la-trash"></i></button></span></td>
                                                </tr>
                                                <tr data-row="4" class="datatable-row" style="left: 0px;">
                                                    <td class="datatable-cell-center datatable-cell" data-field="sr"
                                                        aria-label="5"><span style="width: 40px;">5</span></td>
                                                    <td data-field="id" aria-label="6" class="datatable-cell"><span
                                                                style="width: 150px;">6</span></td>
                                                    <td data-field="name" aria-label="IT Department" class="datatable-cell">
                                                        <span style="width: 500px;">IT Department</span></td>
                                                    <td data-field="sort_by" aria-label="5" class="datatable-cell"><span
                                                                style="width: 150px;">5</span></td>
                                                    <td class="datatable-cell-left datatable-cell" data-field="Actions"
                                                        data-autohide-disabled="false" aria-label="null"><span
                                                                style="overflow: visible; position: relative; width: 125px;"><a
                                                                    href="http://localhost/projects/mso_core/admin/designation?id=6"
                                                                    class="btn btn-sm btn-clean btn-icon" title="Edit"><i
                                                                        class="la la-edit"></i></a><button type="button"
                                                                                                           onclick="entryDelete(6)"
                                                                                                           class="btn btn-sm btn-clean btn-icon"
                                                                                                           title="Delete"><i
                                                                        class="la la-trash"></i></button></span></td>
                                                </tr>
                                                <tr data-row="5" class="datatable-row datatable-row-even" style="left: 0px;">
                                                    <td class="datatable-cell-center datatable-cell" data-field="sr"
                                                        aria-label="6"><span style="width: 40px;">6</span></td>
                                                    <td data-field="id" aria-label="7" class="datatable-cell"><span
                                                                style="width: 150px;">7</span></td>
                                                    <td data-field="name" aria-label="Administration Department"
                                                        class="datatable-cell"><span style="width: 500px;">Administration Department</span>
                                                    </td>
                                                    <td data-field="sort_by" aria-label="7" class="datatable-cell"><span
                                                                style="width: 150px;">7</span></td>
                                                    <td class="datatable-cell-left datatable-cell" data-field="Actions"
                                                        data-autohide-disabled="false" aria-label="null"><span
                                                                style="overflow: visible; position: relative; width: 125px;"><a
                                                                    href="http://localhost/projects/mso_core/admin/designation?id=7"
                                                                    class="btn btn-sm btn-clean btn-icon" title="Edit"><i
                                                                        class="la la-edit"></i></a><button type="button"
                                                                                                           onclick="entryDelete(7)"
                                                                                                           class="btn btn-sm btn-clean btn-icon"
                                                                                                           title="Delete"><i
                                                                        class="la la-trash"></i></button></span></td>
                                                </tr>
                                                <tr data-row="6" class="datatable-row" style="left: 0px;">
                                                    <td class="datatable-cell-center datatable-cell" data-field="sr"
                                                        aria-label="7"><span style="width: 40px;">7</span></td>
                                                    <td data-field="id" aria-label="1" class="datatable-cell"><span
                                                                style="width: 150px;">1</span></td>
                                                    <td data-field="name" aria-label="HR Department" class="datatable-cell">
                                                        <span style="width: 500px;">HR Department</span></td>
                                                    <td data-field="sort_by" aria-label="10" class="datatable-cell"><span
                                                                style="width: 150px;">10</span></td>
                                                    <td class="datatable-cell-left datatable-cell" data-field="Actions"
                                                        data-autohide-disabled="false" aria-label="null"><span
                                                                style="overflow: visible; position: relative; width: 125px;"><a
                                                                    href="http://localhost/projects/mso_core/admin/designation?id=1"
                                                                    class="btn btn-sm btn-clean btn-icon" title="Edit"><i
                                                                        class="la la-edit"></i></a><button type="button"
                                                                                                           onclick="entryDelete(1)"
                                                                                                           class="btn btn-sm btn-clean btn-icon"
                                                                                                           title="Delete"><i
                                                                        class="la la-trash"></i></button></span></td>
                                                </tr>
                                                <tr data-row="7" class="datatable-row datatable-row-even" style="left: 0px;">
                                                    <td class="datatable-cell-center datatable-cell" data-field="sr"
                                                        aria-label="8"><span style="width: 40px;">8</span></td>
                                                    <td data-field="id" aria-label="8" class="datatable-cell"><span
                                                                style="width: 150px;">8</span></td>
                                                    <td data-field="name" aria-label="Test" class="datatable-cell"><span
                                                                style="width: 500px;">Test</span></td>
                                                    <td data-field="sort_by" aria-label="11" class="datatable-cell"><span
                                                                style="width: 150px;">11</span></td>
                                                    <td class="datatable-cell-left datatable-cell" data-field="Actions"
                                                        data-autohide-disabled="false" aria-label="null"><span
                                                                style="overflow: visible; position: relative; width: 125px;"><a
                                                                    href="http://localhost/projects/mso_core/admin/designation?id=8"
                                                                    class="btn btn-sm btn-clean btn-icon" title="Edit"><i
                                                                        class="la la-edit"></i></a><button type="button"
                                                                                                           onclick="entryDelete(8)"
                                                                                                           class="btn btn-sm btn-clean btn-icon"
                                                                                                           title="Delete"><i
                                                                        class="la la-trash"></i></button></span></td>
                                                </tr>
                                                </tbody>
                                            </table>

                                            <div class="datatable-pager datatable-paging-loaded">
                                                <ul class="datatable-pager-nav mb-5 mb-sm-0" id="datatable-pager-">
                                                    <li>
                                                        <a title="First" href="<?php echo $page_no > 1 ? '?page_no=1' : 'javascript:;'; ?>"
                                                           class="datatable-pager-link datatable-pager-link-first <?php echo $page_no <= 1 ? 'datatable-pager-link-disabled' : ''; ?>" data-page="1">
                                                            <i class="flaticon2-fast-back"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a title="Previous" href="<?php echo $page_no > 1 ? '?page_no='.$previous_page : 'javascript:;'; ?>"
                                                           class="datatable-pager-link datatable-pager-link-prev <?php echo $page_no <= 1 ? 'datatable-pager-link-disabled' : ''; ?>" data-page="<?php echo $previous_page; ?>">
                                                            <i class="flaticon2-back"></i>
                                                        </a>
                                                    </li>
                                                    <li style="display: none;">
                                                        <input type="hidden" readonly class="datatable-pager-input form-control" id="BG_PageNumber" title="Page number">
                                                    </li>

                                                    <?php
                                                    if ($total_no_of_pages <= 5){
                                                        for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
                                                            if ($counter == $page_no) {
                                                                echo '<li><a href="javascript:;" class="datatable-pager-link datatable-pager-link-number datatable-pager-link-active">'.$counter.'</a></li>';
                                                            }else{
                                                                echo '<li><a href="?page_no='.$counter.'" class="datatable-pager-link datatable-pager-link-number">'.$counter.'</a></li>';
                                                            }
                                                        }
                                                    }
                                                    elseif($total_no_of_pages > 5){
                                                        if($page_no <= 3) {
                                                            for ($counter = 1; $counter <= 3 ; $counter++){
                                                                if ($page_no == $counter) {
                                                                    echo '<li><a href="javascript:;" class="datatable-pager-link datatable-pager-link-number datatable-pager-link-active">'.$counter.'</a></li>';
                                                                }else{
                                                                    echo '<li><a href="?page_no='.$counter.'" class="datatable-pager-link datatable-pager-link-number">'.$counter.'</a></li>';
                                                                }
                                                            }
                                                            echo "<li><a>...</a></li>";
                                                            echo '<li><a href="?page_no='.$second_last.'" class="datatable-pager-link datatable-pager-link-number">'.$second_last.'</a></li>';
                                                            echo '<li><a href="?page_no='.$total_no_of_pages.'" class="datatable-pager-link datatable-pager-link-number">'.$total_no_of_pages.'</a></li>';
                                                        }
                                                        elseif($page_no >= 4 && $page_no < $total_no_of_pages - 2) {
                                                            echo '<li><a href="?page_no=1" class="datatable-pager-link datatable-pager-link-number">1</a></li>';
                                                            echo '<li><a href="?page_no=2" class="datatable-pager-link datatable-pager-link-number">2</a></li>';
                                                            echo "<li><a>...</a></li>";
                                                            for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {
                                                                if($counter != 2){
                                                                    if ($page_no == $counter) {
                                                                        echo '<li><a href="javascript:;" class="datatable-pager-link datatable-pager-link-number datatable-pager-link-active">'.$counter.'</a></li>';
                                                                    }
                                                                    else{
                                                                        echo '<li><a href="?page_no='.$counter.'" class="datatable-pager-link datatable-pager-link-number">'.$counter.'</a></li>';
                                                                    }
                                                                }
                                                            }
                                                            echo "<li><a>...</a></li>";
                                                            echo '<li><a href="?page_no='.$second_last.'" class="datatable-pager-link datatable-pager-link-number">'.$second_last.'</a></li>';
                                                            echo '<li><a href="?page_no='.$total_no_of_pages.'" class="datatable-pager-link datatable-pager-link-number">'.$total_no_of_pages.'</a></li>';
                                                        }
                                                        else {
                                                            echo '<li><a href="?page_no=1" class="datatable-pager-link datatable-pager-link-number">1</a></li>';
                                                            echo '<li><a href="?page_no=2" class="datatable-pager-link datatable-pager-link-number">2</a></li>';
                                                            echo "<li><a>...</a></li>";

                                                            for ($counter = $total_no_of_pages - 2; $counter <= $total_no_of_pages; $counter++) {
                                                                if ($page_no == $counter) {
                                                                    echo '<li><a href="javascript:;" class="datatable-pager-link datatable-pager-link-number datatable-pager-link-active">'.$counter.'</a></li>';
                                                                }else{
                                                                    echo '<li><a href="?page_no='.$counter.'" class="datatable-pager-link datatable-pager-link-number">'.$counter.'</a></li>';
                                                                }
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                    <li>
                                                        <a title="Next" href="<?php echo $page_no < $total_no_of_pages ? '?page_no='.$next_page : 'javascript:;'; ?>"
                                                           class="datatable-pager-link datatable-pager-link-next <?php echo $page_no >= $total_no_of_pages ? 'datatable-pager-link-disabled' : ''; ?>" data-page="<?php echo $next_page; ?>">
                                                            <i class="flaticon2-next"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a title="Last" href="<?php echo $page_no < $total_no_of_pages ? '?page_no='.$total_no_of_pages : 'javascript:;'; ?>"
                                                           class="datatable-pager-link datatable-pager-link-last <?php echo $page_no >= $total_no_of_pages ? 'datatable-pager-link-disabled' : ''; ?>" data-page="<?php echo $total_no_of_pages; ?>">
                                                            <i class="flaticon2-fast-next"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                                <div class="datatable-pager-info">
                                                    <div class="dropdown bootstrap-select datatable-pager-size"
                                                         style="width: 60px;">
                                                        <select onchange="getData()" class="selectpicker datatable-pager-size" title="Select page size" data-width="60px" data-container="body" id="BG_PageSize">
                                                            <option value="5">5</option>
                                                            <option value="10">10</option>
                                                            <option value="20">20</option>
                                                            <option value="30">30</option>
                                                            <option value="50">50</option>
                                                            <option value="100">100</option>
                                                        </select>
                                                    </div>
                                                    <span class="datatable-pager-detail">Showing 1 - <?php echo $page_no." of ".$total_no_of_pages; ?></span></div>
                                            </div>
                                        </div>
                                    </div>
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
<?php include_once("../includes/footer.php"); ?>
<script>
    function saveFORM() {

        var checkValidName = /[^a-zA-Z0-9-.@_&' ]/;
        var validEmail = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        var validContactNumber = /^[\-)( ]*([0-9]{3})[\-)( ]*([0-9]{3})[\-)( ]*([0-9]{4})$/;
        var validURL = /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i;
        var validAddress = /[^a-zA-Z0-9+-._,@&#' ]/;
        var statusArray = ["0", "1"];
        var typeArray = ['o', 'h'];

        var id = document.getElementById('id');
        var name = document.getElementById('name');
        var company_email = document.getElementById('company_email');
        var hr_email = document.getElementById('hr_email');
        var other_email = document.getElementById('other_email');
        var country_id = document.getElementById('country_id');
        var state_id = document.getElementById('state_id');
        var city_id = document.getElementById('city_id');
        var dial_code = document.getElementById('dial_code');
        var mobile = document.getElementById('mobile');
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

        if (name.value == '') {
            name.style.borderColor = '#F00';
            errorMessageName.innerText = "Name field is required.";
            return false;
        }
        else if(checkValidName.test(name.value)) {
            name.style.borderColor = '#F00';
            errorMessageName.innerText = "Special Characters are not Allowed.";
            return false;
        }
        else if (name.value.length > 50) {
            name.style.borderColor = '#F00';
            errorMessageName.innerText = "Length should not exceed 50.";
            return false;
        }
        else if (company_email.value == '') {
            company_email.style.borderColor = '#F00';
            errorMessageCompanyEmail.innerText = "Company Email field is required.";
            return false;
        }
        else if (validEmail.test(company_email.value) == false) {
            company_email.style.borderColor = '#F00';
            errorMessageCompanyEmail.innerText = "Invalid Email Address.";
            return false;
        }
        else if (hr_email.value == '') {
            hr_email.style.borderColor = '#F00';
            errorMessageHREmail.innerText = "HR Email field is required.";
            return false;
        }
        else if (validEmail.test(hr_email.value) == false) {
            hr_email.style.borderColor = '#F00';
            errorMessageHREmail.innerText = "Invalid Email Address.";
            return false;
        }
        else if (other_email.value != '' && validEmail.test(other_email.value) == false) {
            other_email.style.borderColor = '#F00';
            errorMessageOtherEmail.innerText = "Invalid Email Address.";
            return false;
        }
        else if (country_id.value == ''){
            country_id.style.borderColor = '#F00';
            errorMessageCountry.innerText = "Country field is required.";
            return false;
        }
        else if (isNaN(country_id.value) === true || country_id.value < 1 || country_id.value.length > 10 ){
            country_id.style.borderColor = '#F00';
            errorMessageCountry.innerText = "Please select a valid option.";
            return false;
        }
        else if (state_id.value == ''){
            state_id.style.borderColor = '#F00';
            errorMessageState.innerText = "State field is required.";
            return false;
        }
        else if (isNaN(state_id.value) === true || state_id.value < 1 || state_id.value.length > 10 ){
            state_id.style.borderColor = '#F00';
            errorMessageState.innerText = "Please select a valid option.";
            return false;
        }
        else if (city_id.value == ''){
            city_id.style.borderColor = '#F00';
            errorMessageCity.innerText = "City field is required.";
            return false;
        }
        else if (isNaN(city_id.value) === true || city_id.value < 1 || city_id.value.length > 10 ){
            city_id.style.borderColor = '#F00';
            errorMessageCity.innerText = "Please select a valid option.";
            return false;
        }
        else if (mobile.value == ''){
            mobile.style.borderColor = '#F00';
            errorMessageMobile.innerText = "Mobile field is required.";
            return false;
        }
        else if (validContactNumber.test(mobile.value) == false || mobile.value.length != 12){
            mobile.style.borderColor = '#F00';
            errorMessageMobile.innerText = "Invalid Mobile No.";
            return false;
        }
        else if (phone.value != ''  && (validContactNumber.test(phone.value) == false || phone.value.length != 14)){
            phone.style.borderColor = '#F00';
            errorMessagePhone.innerText = "Invalid Phone number.";
            return false;
        }
        else if (fax.value != ''  && (validContactNumber.test(fax.value) == false || fax.value.length != 14)){
            fax.style.borderColor = '#F00';
            errorMessageFax.innerText = "Invalid Fax number.";
            return false;
        }
        else if (web.value != ''  && validURL.test(web.value) == false){
            web.style.borderColor = '#F00';
            errorMessageWeb.innerText = "Invalid Web link.";
            return false;
        }
        else if (status.value == '') {
            status.style.borderColor = '#F00';
            errorMessageStatus.innerText = "Status field is required.";
            return false;
        }
        else if (statusArray.includes(status.value) == false || status.value.length > 2) {
            status.style.borderColor = '#F00';
            errorMessageStatus.innerText = "Please select a valid option.";
            return false;
        }
        else if (type.value == ''){
            type.style.borderColor = '#F00';
            errorMessageType.innerText = "Type field is required.";
            return false;
        }
        else if (typeArray.includes(type.value) == false || type.value.length > 2) {
            type.style.borderColor = '#F00';
            errorMessageType.innerText = "Please select a valid option.";
            return false;
        }
        else if (address.value == ''){
            address.style.borderColor = '#F00';
            errorMessageAddress.innerText = "Address field is required.";
            return false;
        }
        else if (validAddress.test(address.value)){
            address.style.borderColor = '#F00';
            errorMessageAddress.innerText = "Special Characters are not Allowed.";
            return false;
        }
        else {
            var postData = {
                "id":id.value,
                "name":name.value,
                "company_email":company_email.value,
                "hr_email":hr_email.value,
                "other_email":other_email.value,
                "country_id":country_id.value,
                "state_id":state_id.value,
                "city_id":city_id.value,
                "dial_code":dial_code.value,
                "mobile":mobile.value,
                "phone":phone.value,
                "fax":fax.value,
                "web":web.value,
                "status":status.value,
                "type":type.value,
                "address":address.value,
            };
            $.ajax({
                type: "POST", url: "ajax/branch.php",
                data: {'postData':postData},
                success: function (resPonse) {
                    if (resPonse !== undefined && resPonse != '') {
                        var obj = JSON.parse(resPonse);
                        if(obj.code === 200 || obj.code === 405 || obj.code === 422){
                            var title = '';
                            if (obj.code === 422) {
                                if (obj.errorField !== undefined && obj.errorField != '' && obj.errorDiv !== undefined && obj.errorDiv != '' && obj.errorMessage !== undefined && obj.errorMessage != '') {
                                    document.getElementById(obj.errorField).style.borderColor = '#F00';
                                    document.getElementById(obj.errorDiv).innerText = obj.errorMessage;
                                    toasterTrigger('warning',obj.errorMessage);
                                }
                            }
                            else if(obj.code === 405 || obj.code === 200){
                                if (obj.responseMessage !== undefined && obj.responseMessage != '') {
                                    toasterTrigger(obj.toasterClass,obj.responseMessage);
                                    if(obj.form_reset !== undefined && obj.form_reset){
                                        document.getElementById("myFORM").reset();
                                        setTimeout(function(){ location.reload(); }, 2000);
                                    }
                                }
                            }
                        }
                    }
                }
            });
        }
    }
</script>
</body>
<!--end::Body-->
</html>