<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Essential JS 2 TypeScript Components">
    <meta name="author" content="Syncfusion">
    <link href="css/fabric.css" rel="stylesheet">
    <style rel="stylesheet">
        .e-control-wrapper.e-date-wrapper {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>


<div style="display:block;float:left;width:300px;padding:5px">
    <?php
    //httpswww.syncfusion.comjavascript-ui-controlsjs-datepicker
    $date_picker = ['dd-MM-yyyy', 'dd-MMM-yyyy', 'dd-MMMM-yyyy', 'dd-MM-yy', 'dd-MMM-yy', 'dd-MMMM-yy', 'yyyy-MM-dd', 'yyyy-MMM-dd', 'yyyy-MMMM-dd', 'yy-MM-dd', 'yy-MMM-dd', 'yy-MMMM-dd'];
    foreach ($date_picker as $index => $f) {
        ?>
        <input type="text" class="DatePicker e-input" id="first<?php echo $index; ?>" data-placeholder="<?php echo $f; ?>" data-format="<?php echo $f; ?>"
               value="">
        <span class="e-clear-icon e-clear-icon-hide" aria-label="close" role="button"></span>
        <?php
    }
    ?>
</div>


<div style="display:block;float:left;width:300px;padding:5px">
    <?php
    $date_picker = ['MM-yyyy', 'MMM-yyyy', 'MMMM-yyyy', 'MM-yy', 'MMM-yy', 'MMMM-yy', 'yyyy-MM', 'yyyy-MMM', 'yyyy-MMMM', 'yy-MM', 'yy-MMM', 'yy-MMMM'];
    foreach ($date_picker as $index => $f) {
        ?>
        <input type="text" class="MonthPicker e-input" id="second<?php echo $index; ?>" data-format="<?php echo $f; ?>"
               value="">
        <span class="e-clear-icon e-clear-icon-hide" aria-label="close" role="button"></span>
        <?php
    }
    ?>
</div>

<script src="js/common.js"></script>
<script src="js/datepicker.js"></script>
</body>
</html>