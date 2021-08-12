<?php
include_once('../../includes/connection.php');
$global_employee_id = $_SESSION['employee_id'];
?>

<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<head>
    <meta charset="utf-8"/>
    <title>Employee Card</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0 !important;
            padding: 0 !important;
        }

        .employee-card-wrapper {
            background: transparent;
            display: block;
            margin: 0 auto;
            overflow: visible;
            width: 2.25in;
        }

        .full-line {
            display: block;
            margin: 0;
            overflow: hidden;
            padding: 0;
            width: 100%;
        }

        .employee-card-wrapper svg {
            height: 100%;
            width: 100%;
        }

        .employee-card-wrapper .employee-card-aside {
            height: 3.5in;
            margin: 0 !important;
            overflow: hidden;
            width: 2.25in;
        }

        .employee-card-wrapper .employee-card-front-left-side {
            background-color: #1171a0;
            background-size: 100% 100%;
            background-repeat: no-repeat;
            display: block;
            float: left;
            height: 3.5in;
            margin: 0;
            overflow: hidden;
            position: relative;
            width: 0.52in;
        }

        .employee-card-wrapper .employee-card-front-left-side .department_name {
            background-color: transparent;
            color: #fff;
            font-family: 'Open Sans', sans-serif;
            font-size: 14px;
            font-weight: 600;
            height: 3.5in;
            letter-spacing: 1.2px;
            line-height: 56px;
            text-align: center;
            text-transform: uppercase;
            transform: rotate(-90deg);
            -ms-transform: rotate(-90deg);
            width: 3.5in;
        }

        .employee-card-wrapper .employee-card-front-right-side {
            background: #f0f4f9;
            float: left;
            height: 3.5in;
            margin: 0;
            overflow: hidden;
            width: 1.73in;
        }

        .employee-card-wrapper .employee-card-color-logo {
            display: block;
            height: auto;
            margin: 0.2in auto;
            overflow: hidden;
            width: 1.5in;
        }

        .employee-card-wrapper .employee-card-image-portion {
            display: block;
            height: 1.23in;
            margin: 0 auto 10px;
            overflow: hidden;
            position: relative;
            width: 1.31in;
        }

        .employee-card-wrapper .employee-card-image-portion svg {
            position: relative;
            z-index: 2;
        }

        .employee-card-wrapper .employee-card-image-portion .employee-card-employee-image {
            float: left;
            height: 78px;
            left: 23px;
            margin: 0 auto;
            overflow: hidden;
            position: absolute;
            top: 21px;
            width: 78px;
            z-index: 1;
        }

        .employee-card-wrapper .employee-card-image-portion .employee-card-employee-image img {
            height: 100%;
            width: 100%;
        }

        .employee-card-wrapper .employee-card-employee-name, .employee-card-wrapper .employee-card-employee-designation {
            color: #1171a1;
            font-family: 'Open Sans', sans-serif;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.2px;
            padding: 0 2px;
            text-align: center;
            text-transform: uppercase;
        }

        .employee-card-wrapper .employee-card-employee-designation {
            font-weight: 400;
        }

        .employee-card-wrapper .employee-card-horizontal-line {
            background: #1171a1;
            border-radius: 2px !important;
            -moz-border-radius: 2px !important;
            -webkit-border-radius: 2px !important;
            height: 1px;
            margin: 2px auto 0.10in;
            width: 50%;
        }

        .employee-card-wrapper .employee-card-QR-code {
            display: block;
            height: 0.43in;
            margin: 0 auto;
            width: 0.43in;
        }

        .employee-card-wrapper .employee-card-employee-code {
            display: block;
            color: #000;
            font-family: 'Open Sans', sans-serif;
            font-size: 6px;
            font-weight: 800;
            margin: 1px auto 0;
            text-align: center;
            width: 100%;
            text-transform: uppercase;
            letter-spacing: 0.2px;

        }

        .employee-card-wrapper .employee-card-aside.back {
            background-color: #1171a0;
            background-size: 2.25in 100%;
            background-repeat: no-repeat;
            color: #fff;
            font-family: 'Open Sans', sans-serif;
            font-size: 8px;
            font-weight: 700;
        }

        .employee-card-wrapper .employee-card-white-logo {
            display: block;
            height: auto;
            margin: 0 auto;
            overflow: hidden;
            padding: 0.20in 0;
            width: 1.65in;
        }

        .employee-card-wrapper .employee-card-aside.back ul {
            display: block;
            float: left;
            list-style: none;
            margin: 0;
            overflow: hidden;
            padding: 0 14px;
            max-height: 187px;
            min-height: 176px;
        }

        .employee-card-wrapper .employee-card-aside.back ul li {
            display: block;
            float: left;
            list-style: none;
            margin: 0 0 6px 0;
            overflow: hidden;
            padding: 0;
            width: 100%;
        }

        .employee-card-wrapper .employee-card-aside.back ul li b {
            display: block;
            float: left;
            font-weight: 700;
            overflow: hidden;
            padding: 0 4px 0 0;
            width: calc(37% - 6px);
        }

        .employee-card-wrapper .employee-card-aside.back ul li span {
            display: block;
            float: left;
            overflow: hidden;
            width: calc(63% - 5px);
        }

        .employee-card-wrapper .employee-card-aside.back ul li article{
            display: block;
            float: left;
            width: 5px;
        }

        .employee-card-wrapper .employee-card-note-portion {
            display: block;
            font-size: 7px;
            line-height: 10px;
            margin: 4px auto 6px;
            overflow: hidden;
            text-align: center;
            padding: 0;
            width: 100%;
        }

        .employee-card-wrapper .employee-card-aside.back .footer-icons {
            display: block;
            line-height: 10px;
            font-size: 7px;
            text-align: center;
        }

        .employee-card-wrapper .employee-card-aside.back .footer-icons svg {
            enable-background: new 0 0 7 7;
            height: 7px;
            width: 7px;
        }

        @media print {
            .employee-card-aside {
                page-break-after: always;
            }
        }

    </style>


</head>
<!--end::Head-->

<!--begin::Body-->
<!-- onload="window.print()"  -->
<body id="kt_body" onload="window.print()"
      class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">

<?php
if (isset($_GET['printEmployeeCard']) && !empty($_GET['printEmployeeCard']) && is_numeric($_GET['printEmployeeCard'])) {
    $data = getEmployeeCardHTML($_GET['printEmployeeCard']);
    if ($data['code'] == 200) {
        echo '<div class="employee-card-wrapper print_page" id="employee_card_wrapper">';
        echo $data['data'];
        echo '</div>';
    } else {
        header('Location: ' . $page_not_found_url);
        exit();
    }
} else {
    header('Location: ' . $page_not_found_url);
    exit();
}


?>


</body>
</html>

