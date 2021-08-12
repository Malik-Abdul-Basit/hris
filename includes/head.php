<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<head>
    <meta charset="utf-8"/>
    <title><?php
        echo ucwords(str_replace("_", " ", $page));
        if (isset($global_employee_info->company_name) && !empty($global_employee_info->company_name)) {
            echo ' | ' . $global_employee_info->company_name;
        }
        ?></title>
    <meta name="description"
          content="<?php
          echo ucwords(str_replace("_", " ", $page));
          if (isset($global_employee_info->company_name) && !empty($global_employee_info->company_name)) {
              echo ' | ' . $global_employee_info->company_name;
          } ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700"/>

    <?php
    if (in_array($page, ['login', 'forgot_password', 'email_confirmation'])) {
        ?>
        <link <?php echo $css_atr ?> href="<?php echo $tm_assets ?>css/pages/login/login-3.css" rel="stylesheet"
                                     type="text/css"/>
        <?php
    }
    if (in_array($page, ['start_evaluation'])) {
        ?>
        <link <?php echo $css_atr ?> href="<?php echo $tm_assets ?>plugins/custom/jstree/jstree.bundle.css"/>
        <?php
    }
    ?>

    <link <?php echo $css_atr ?> href="<?php echo $base_url ?>assets/time_picker/css/time_picker_style.css">
    <link <?php echo $css_atr ?> href="<?php echo $base_url ?>assets/time_picker/css/timepicki.css">

    <link <?php echo $css_atr ?> href="<?php echo $tm_assets ?>plugins/global/plugins.bundle.css"/>
    <link <?php echo $css_atr ?> href="<?php echo $tm_assets ?>plugins/custom/prismjs/prismjs.bundle.css"/>

    <link <?php echo $css_atr ?> href="<?php echo $tm_assets ?>css/style.bundle.css"/>
    <link <?php echo $css_atr ?> href="<?php echo $tm_assets ?>css/themes/layout/header/base/light.css"/>
    <link <?php echo $css_atr ?> href="<?php echo $tm_assets ?>css/themes/layout/header/menu/light.css"/>
    <link <?php echo $css_atr ?> href="<?php echo $tm_assets ?>css/themes/layout/brand/dark.css"/>
    <link <?php echo $css_atr ?> href="<?php echo $tm_assets ?>css/themes/layout/aside/dark.css"/>

    <script type="text/javascript" src="<?php echo $ct_assets ?>js/jquery-3.5.1.min.js"></script>

    <?php
    if (in_array($page, ['employee_image'])) {//,'employee_family_info','employee_qualification', 'employee_experience', 'employee_payroll'
        ?>
        <link <?php echo $css_atr ?> href="<?php echo $base_url ?>assets/croppie_assets/css/croppie.css"/>
        <!--<link rel="stylesheet" href="http://demo.itsolutionstuff.com/plugin/croppie.css">-->
        <?php
    }
    /*if(in_array($page, ['employee','employee_qualification', 'employee_experience']) ){*/
    ?>
    <!--<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">-->
    <!--<script type="text/javascript" src="<?php //echo $base_url; ?>assets/date_picker_assets/js/es5-shim.min.js"></script>
    <script type="text/javascript" src="<?php //echo $base_url; ?>assets/date_picker_assets/js/date-time-picker.min.js"></script>-->


    <?php
    /*}*/
    ?>
    <link <?php echo $css_atr ?> href="<?php echo $base_url; ?>assets/date_picker_assets/css/datepicker.css">
    <link <?php echo $css_atr ?> href="<?php echo $ct_assets ?>css/style.css"/>
    <link <?php echo $css_atr ?> href="<?php echo $ct_assets ?>css/collapse_card.css"/>
    <link rel="shortcut icon" href="<?php echo $tm_assets ?>media/logos/favicon.ico"/>
</head>
<!--end::Head-->

<!--begin::Body-->
<body id="kt_body"
      class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading"
    <?php //if($user_id!=1){echo 'oncontextmenu="return false" onselectstart="return false"  onkeydown="if ((arguments[0] || window.event).ctrlKey) return false"';} ?>>
<div id="loader-wrapper">
    <div class="vertical-center">
        <div class="loader-box">
            <!--<i class="fa fa-spinner fa-pulse fa-fw"></i>-->
            <div class="spinner spinner-track spinner-primary own-spinner"></div>
            <p>Please Wait ...</p>
        </div>

    </div>
</div>

