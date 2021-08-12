
<div class="subheader py-2 py-lg-6  subheader-solid " id="kt_subheader"  <?php if (!$checkLogin) { echo 'style="left:0px!important;"';} ?>>
    <div class=" container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <div class="d-flex align-items-center flex-wrap mr-1">
            <div class="d-flex align-items-baseline flex-wrap mr-5">
                <h5 class="text-dark font-weight-bold my-1 mr-5"><?php echo ucwords(str_replace("_", " ", $page)); ?></h5>
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted"><?php echo $main_menu_name; ?></a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted"><?php echo $sub_menu_name; ?></a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted active"><?php echo $child_menu_name; ?></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>