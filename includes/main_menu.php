<div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto" id="kt_aside">
    <!--begin::Brand-->
    <div class="brand flex-column-auto" id="kt_brand">
        <a href="<?php echo $admin_url . 'dashboard'; ?>" class="brand-logo">
            <img alt="Logo" src="<?php echo $tm_assets; ?>media/logos/admin_logo_colored.png"/>
        </a>
        <button class="brand-toggle btn btn-sm px-0" id="kt_aside_toggle">
            <span class="svg-icon svg-icon svg-icon-xl">
                <svg width="24px" height="24px" viewBox="0 0 24 24">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <polygon points="0 0 24 0 24 24 0 24"/>
                        <path d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,
                        4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,
                        18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,
                        17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z" fill="#000000" fill-rule="nonzero"
                              transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999)"/>
                        <path d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,
                        14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,
                        13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,
                        15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z" fill="#000000" fill-rule="nonzero"
                              opacity="0.3"
                              transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999)"/>
                    </g>
                </svg>
            </span>
        </button>
    </div>
    <!--end::Brand-->

    <!--begin::Aside Menu-->
    <div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
        <div id="kt_aside_menu" class="aside-menu my-4"
             data-menu-vertical="1"
             data-menu-scroll="1"
             data-menu-dropdown-timeout="500">
            <ul class="menu-nav">
                <li aria-haspopup="true" class="menu-item <?php if (in_array($page, array('dashboard'))) {
                    echo 'menu-item-active';
                } ?>">
                    <a href="<?php echo $admin_url . 'dashboard'; ?>" class="menu-link ">
                        <span class="svg-icon menu-icon">
                            <svg width="24px" height="24px" viewBox="0 0 24 24">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <polygon points="0 0 24 0 24 24 0 24"/>
                                    <path d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,
                                    8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,
                                    3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,
                                    10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z"
                                          fill="#000000" fill-rule="nonzero"/>
                                    <path d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,
                                    14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,
                                    15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,
                                    15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,
                                    14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,
                                    14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z"
                                          fill="#000000" opacity="0.3"/>
                                </g>
                            </svg>
                        </span>
                        <span class="menu-text">Dashboard</span>
                    </a>
                </li>

                <li class="menu-section ">
                    <h4 class="menu-text">Custom</h4>
                    <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                </li>

                <?php
                //include_once('commented_menus.php');


                $sqlM = "SELECT mm.* FROM main_menus AS mm ";
                if($global_employee_info->user_type != config('users.type.value.super_admin')){
                    $sqlM .= " INNER JOIN user_rights AS ur ON mm.id=ur.main_menu_id ";
                }
                $sqlM .= " WHERE mm.status = '";
                $sqlM .= config('main_menus.status.value.active')."'";
                if($global_employee_info->user_type != config('users.type.value.super_admin')){
                    $sqlM .= " AND ur.user_id='{$global_user_id}' AND ur.company_id='{$global_company_id}' AND ur.branch_id='{$global_branch_id}' ";
                }
                $sqlM .= " GROUP BY mm.id ORDER BY mm.sort_by ASC";

                $select_main_menu = mysqli_query($db, $sqlM);
                if (mysqli_num_rows($select_main_menu) > 0) {
                    while ($main_menu = mysqli_fetch_object($select_main_menu)) {
                        $main_menu_class = ($main_menu->id == $main_menu_id) ? 'menu-item-open' : '';
                        ?>
                        <li class="menu-item menu-item-submenu <?php echo $main_menu_class; ?>" aria-haspopup="true"
                            data-menu-toggle="hover" data-id="main-menu-id-<?php echo $main_menu->id; ?>">
                            <a href="javascript:;" class="menu-link menu-toggle">
                                <span class="svg-icon menu-icon"><?php echo $main_menu->icon; ?></span>
                                <span class="menu-text"><?php echo $main_menu->name; ?></span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="menu-submenu">
                                <i class="menu-arrow"></i>
                                <ul class="menu-subnav">
                                    <li class="menu-item menu-item-parent" aria-haspopup="true">
                                        <span class="menu-link">
                                            <span class="menu-text"><?php echo $main_menu->name; ?></span>
                                        </span>
                                    </li>
                                    <?php
                                    $sqlS = "SELECT sm.* FROM sub_menus AS sm ";
                                    if($global_employee_info->user_type != config('users.type.value.super_admin')){
                                        $sqlS .= " INNER JOIN user_rights AS ur ON sm.id=ur.sub_menu_id ";
                                    }
                                    $sqlS .= " WHERE sm.main_menu_id='{$main_menu->id}' AND sm.status = '";
                                    $sqlS .= config('sub_menus.status.value.active')."'";
                                    if($global_employee_info->user_type != config('users.type.value.super_admin')){
                                        $sqlS .= " AND ur.user_id='{$global_user_id}' AND ur.company_id='{$global_company_id}' AND ur.branch_id='{$global_branch_id}' ";
                                    }
                                    $sqlS .= " GROUP BY sm.id ORDER BY sm.sort_by ASC";
                                    $select_sub_menu = mysqli_query($db, $sqlS);
                                    if (mysqli_num_rows($select_sub_menu) > 0) {
                                        while ($sub_menu = mysqli_fetch_object($select_sub_menu)) {
                                            $sub_menu_class = ($sub_menu->id == $sub_menu_id) ? 'menu-item-open' : '';
                                            ?>
                                            <li class="menu-item menu-item-submenu <?php echo $sub_menu_class; ?>"
                                                aria-haspopup="true"
                                                data-menu-toggle="hover" data-id="sub-menu-id-<?php echo $sub_menu->id; ?>">
                                                <a href="javascript:;" class="menu-link menu-toggle">
                                                    <i class="menu-bullet menu-bullet-line"><span></span></i>
                                                    <span class="menu-text"><?php echo $sub_menu->name; ?></span>
                                                    <i class="menu-arrow"></i>
                                                </a>
                                                <div class="menu-submenu">
                                                    <i class="menu-arrow"></i>
                                                    <ul class="menu-subnav">
                                                        <?php
                                                        $sqlC = "SELECT cm.* FROM child_menus AS cm ";
                                                        if($global_employee_info->user_type != config('users.type.value.super_admin')){
                                                            $sqlC .= " INNER JOIN user_rights AS ur ON cm.id=ur.child_menu_id ";
                                                        }
                                                        $sqlC .= " WHERE cm.sub_menu_id='{$sub_menu->id}' AND cm.status = '";
                                                        $sqlC .= config('child_menus.status.value.active');
                                                        $sqlC .= "' AND cm.menu_link = '";
                                                        $sqlC .= config('child_menus.menu_link.value.display')."'";
                                                        if($global_employee_info->user_type != config('users.type.value.super_admin')){
                                                            $sqlC .= " AND ur.user_id='{$global_user_id}' AND ur.company_id='{$global_company_id}' AND ur.branch_id='{$global_branch_id}' ";
                                                        }
                                                        $sqlC .= " GROUP BY cm.id ORDER BY cm.sort_by ASC";
                                                        $select_child_menu = mysqli_query($db, $sqlC);
                                                        if (mysqli_num_rows($select_child_menu) > 0) {
                                                            while ($child_menu = mysqli_fetch_object($select_child_menu)) {
                                                                ?>
                                                                <li class="menu-item <?php if ($child_menu->id == $child_menu_id) {
                                                                    echo 'menu-item-active';
                                                                } ?>" aria-haspopup="true" data-id="child-menu-id-<?php echo $child_menu->id; ?>">
                                                                    <a href="<?php echo $admin_url . $child_menu->file_name; ?>"
                                                                       class="menu-link ">
                                                                        <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                                                        <span class="menu-text"><?php echo $child_menu->display_name; ?></span>
                                                                    </a>
                                                                </li>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </ul>
                                                </div>
                                            </li>
                                            <?php
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                        </li>
                        <?php

                    }
                }


                ?>
            </ul>
        </div>
    </div>
    <!--end::Aside Menu-->
</div>
