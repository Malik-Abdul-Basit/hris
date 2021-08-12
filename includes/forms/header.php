<head>
<meta charset="utf-8"/>
    <meta name="description" content="Latest updates and statistic charts">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title><?php echo ucwords(str_replace("_", " ", $page)); ?></title>
    <!--<script src="<?php //echo $base_url; ?>assets/custom_assets/js/vue.js"></script>-->
    <script src="<?php echo $ct_assets; ?>js/jquery-3.5.1.min.js"></script>
    <script src="<?php echo $base_url; ?>assets/forms_assets/js/webfont.js"></script>
    <script>
        WebFont.load({
            google: {"families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]},
            active: function () {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <link href="<?php echo $base_url; ?>assets/forms_assets/css/style.bundle.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo $ct_assets; ?>css/style.css" rel="stylesheet" type="text/css"/>
    <link rel="shortcut icon" href="<?php echo $tm_assets?>media/logos/favicon.ico"/>
</head>