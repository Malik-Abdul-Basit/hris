
        <script>var HOST_URL = "https://preview.keenthemes.com/metronic/theme/html/tools/preview";</script>
        <!--begin::Global Config(global config for global JS scripts)-->

        <script>
            var KTAppSettings = {
                "breakpoints": {
                    "sm": 576,
                    "md": 768,
                    "lg": 992,
                    "xl": 1200,
                    "xxl": 1400
                },
                "colors": {
                    "theme": {
                        "base": {
                            "white": "#ffffff",
                            "primary": "#3699FF",
                            "secondary": "#E5EAEE",
                            "success": "#1BC5BD",
                            "info": "#8950FC",
                            "warning": "#FFA800",
                            "danger": "#F64E60",
                            "light": "#E4E6EF",
                            "dark": "#181C32"
                        },
                        "light": {
                            "white": "#ffffff",
                            "primary": "#E1F0FF",
                            "secondary": "#EBEDF3",
                            "success": "#C9F7F5",
                            "info": "#EEE5FF",
                            "warning": "#FFF4DE",
                            "danger": "#FFE2E5",
                            "light": "#F3F6F9",
                            "dark": "#D6D6E0"
                        },
                        "inverse": {
                            "white": "#ffffff",
                            "primary": "#ffffff",
                            "secondary": "#3F4254",
                            "success": "#ffffff",
                            "info": "#ffffff",
                            "warning": "#ffffff",
                            "danger": "#ffffff",
                            "light": "#464E5F",
                            "dark": "#ffffff"
                        }
                    },
                    "gray": {
                        "gray-100": "#F3F6F9",
                        "gray-200": "#EBEDF3",
                        "gray-300": "#E4E6EF",
                        "gray-400": "#D1D3E0",
                        "gray-500": "#B5B5C3",
                        "gray-600": "#7E8299",
                        "gray-700": "#5E6278",
                        "gray-800": "#3F4254",
                        "gray-900": "#181C32"
                    }
                },
                "font-family": "Poppins"
            };
        </script>
        <!--end::Global Config-->

        <?php
        if(in_array($page, ['employee_image']) ){//,'employee_family_info','employee_qualification', 'employee_experience', 'employee_payroll'
            ?>
            <script src="<?php echo $base_url ?>assets/croppie_assets/js/jquery.js"></script>
            <?php
        }
        ?>

        <script src="<?php echo $tm_assets; ?>plugins/global/plugins.bundle.js"></script>
        <script src="<?php echo $tm_assets; ?>plugins/custom/prismjs/prismjs.bundle.js"></script>

        <script src="<?php echo $tm_assets; ?>js/scripts.bundle.js"></script>

        <script src="<?php echo $base_url; ?>assets/date_picker_assets/js/common.js"></script>
        <script src="<?php echo $base_url; ?>assets/date_picker_assets/js/datepicker.js"></script>

        <script src="<?php echo $ct_assets; ?>js/input-mask.js"></script>
        <script src="<?php echo $ct_assets; ?>js/maxlength.js"></script>
        <script src="<?php echo $ct_assets; ?>js/select2.js"></script>
        <script src="<?php echo $ct_assets; ?>js/touch_spin.js"></script>

        <script src="<?php echo $base_url; ?>assets/time_picker/js/timepicki.js"></script>
        <script> $('.timepicker').timepicki(); </script>

        <?php
        if(in_array($page, ['start_evaluation']) ){
            ?>
            <script src="<?php echo $tm_assets ?>plugins/custom/jstree/jstree.bundle.js"></script>
            <!--<script src="<?php //echo $tm_assets ?>js/pages/features/miscellaneous/treeview.js"></script>-->
            <?php
        }
        ?>

        <script type="text/javascript">

            function logout () {
                loader(true);
                var logout_co = <?php echo (isset($global_company_id) && !empty($global_company_id) ? "'".$global_company_id."'" : "''"); ?>;
                var logout_br = <?php echo (isset($global_branch_id) && !empty($global_branch_id) ? "'".$global_branch_id."'" : "''"); ?>;
                var logout_em = <?php echo (isset($global_employee_id) && !empty($global_employee_id) ? "'".$global_employee_id."'" : "''"); ?>;
                var logout_us = <?php echo (isset($global_user_id) && !empty($global_user_id) ? "'".$global_user_id."'" : "''"); ?>;

                var postData = {"logout_co":logout_co,"logout_br":logout_br,"logout_em":logout_em,"logout_us":logout_us};

                $.ajax({
                    type: "POST", url: "ajax/logout.php",
                    data: {'postData':postData},
                    success: function (resPonse) {
                        if (resPonse !== undefined && resPonse != '') {
                            window.location = '../login';
                        } else {
                            window.location = '../login';
                            loader(false);
                        }
                    },
                    error: function () {
                        window.location = '../login';
                        loader(false);
                    }
                });
            }

            function sameAsAbove(copyfrom,pastein) {
                document.getElementById(pastein).value=document.getElementById(copyfrom).value;
                document.getElementById(pastein).focus();
            }

            function change_color(value, id) {
                if (value == '') {
                    document.getElementById(id).style.borderColor = '#F00';
                } else {
                    document.getElementById(id).style.borderColor = '#E4E6EF';
                }
            }

            var country_select_is_valid = document.getElementById("country_id");
            if(country_select_is_valid){
                document.getElementById("country_id").onchange = function () {
                    var id = this.value;
                    var dial_code = this.options[this.selectedIndex].getAttribute("data-dial_code");
                    var iso = this.options[this.selectedIndex].getAttribute("data-iso");
                    var mobile_no_flag = document.getElementById('mobile_no_flag');
                    var other_mobile_no_flag = document.getElementById('other_mobile_no_flag');
                    var guardian_mobile_no_flag = document.getElementById('guardian_mobile_no_flag');

                    if(document.getElementById('dial_code')){
                        document.getElementById('dial_code').value=dial_code;
                    }
                    if(document.getElementById('iso')){
                        document.getElementById('iso').value=iso;
                    }
                    if(document.getElementById('o_dial_code')){
                        document.getElementById('o_dial_code').value=dial_code;
                    }
                    if(document.getElementById('o_iso')){
                        document.getElementById('o_iso').value=iso;
                    }
                    if(document.getElementById('guardian_dial_code')){
                        document.getElementById('guardian_dial_code').value=dial_code;
                    }
                    if(document.getElementById('guardian_iso')){
                        document.getElementById('guardian_iso').value=iso;
                    }

                    if(mobile_no_flag){
                        mobile_no_flag.innerHTML = '<img class="mr-1" src="<?php echo $ct_assets; ?>images/flags/'+iso+'.png">'+'+'+dial_code;
                    }
                    if(other_mobile_no_flag){
                        other_mobile_no_flag.innerHTML = '<img class="mr-1" src="<?php echo $ct_assets; ?>images/flags/'+iso+'.png">'+'+'+dial_code;
                    }
                    if(guardian_mobile_no_flag){
                        guardian_mobile_no_flag.innerHTML = '<img class="mr-1" src="<?php echo $ct_assets; ?>images/flags/'+iso+'.png">'+'+'+dial_code;
                    }

                    document.getElementById('state_id').innerHTML = document.getElementById('city_id').innerHTML = '';
                    var postData = {"country_id":id};
                    $.ajax({
                        type: "POST", url: "ajax/common.php",
                        data: {'postData':postData,'getStates':true},
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
                };
            }

            function getCities(e) {
                var id = e.target.value;
                document.getElementById('city_id').innerHTML = '';
                var postData = {"state_id":id};
                $.ajax({
                    type: "POST", url: "ajax/common.php",
                    data: {'postData':postData,'getCities':true},
                    success: function (resPonse) {
                        if (resPonse !== undefined && resPonse != '') {
                            var obj = JSON.parse(resPonse);
                            if (obj.code !== undefined && obj.code != '' && obj.code === 200) {
                                if (obj.CitiesList !== undefined && obj.CitiesList != '') {
                                    document.getElementById('city_id').innerHTML = obj.CitiesList;
                                }
                            }
                        }
                    }
                });
            }

            function getTeamsAndDesignations(e) {
                var id = e.target.value;
                var postData = {"departmentId":id};
                $.ajax({
                    type: "POST", url: "ajax/common.php",
                    data: {'postData':postData,'getTeamsAndDesignations':true},
                    success: function (resPonse) {
                        if (resPonse !== undefined && resPonse != '') {
                            var obj = JSON.parse(resPonse);
                            if (obj.code !== undefined && obj.code != '' && obj.code === 200) {
                                var team_id = document.getElementById('team_id');
                                var designation_id = document.getElementById('designation_id');
                                var BG_DesignationFilter = document.getElementById('BG_DesignationFilter');

                                /*if (team_id && obj.TeamsList !== undefined && obj.TeamsList != '') {
                                    team_id.innerHTML = obj.TeamsList;
                                }*/
                                if (designation_id && obj.DesignationsList !== undefined && obj.DesignationsList != '') {
                                    designation_id.innerHTML = obj.DesignationsList;
                                }
                                if (BG_DesignationFilter && obj.DesignationsList !== undefined && obj.DesignationsList != '') {
                                    BG_DesignationFilter.innerHTML = '<option value="-1">All</option>'+obj.DesignationsList;
                                }
                            }
                        }
                    }
                });
            }

            function toasterTrigger(toasterClass, msg) {
                toastr.options = {
                    closeButton: true,
                    debug: false,
                    newestOnTop: false,
                    progressBar: false,
                    positionClass: 'toast-top-right', /*toast-top-right, toast-bottom-right, toast-top-left, toast-bottom-left,*/
                    preventDuplicates: false,
                    onclick: null,
                    showDuration: 300,
                    hideDuration: 500,
                    timeOut: 2500,
                    extendedTimeOut: 1000,
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut"
                }
                var $toast = toastr[toasterClass](msg);
                $toastlast = $toast;
            }

            function loader (action){
                var loader_wrapper = document.getElementById('loader-wrapper');
                var body = document.getElementsByTagName("BODY")[0];
                if(loader_wrapper && action === true){
                    loader_wrapper.classList.add("display-true");
                    body.classList.add("overflow-hidden");
                }
                else if(loader_wrapper && action === false){
                    loader_wrapper.classList.remove("display-true");
                    body.classList.remove("overflow-hidden");
                }
            }

            function checkAndUncheck(elm){
                var checked = $("#"+elm).is(':checked');
                $("."+elm).each(function () {
                    $(this).prop("checked", checked);
                });
            }

            function allowNumberOnly(e) {
                if (e.keyCode === 8 || (e.keyCode >= 48 && e.keyCode <= 57)) {
                    return true;
                } else {
                    e.preventDefault();
                }
            }

            function onlyNumber(e) {
                if (isNaN(e.key) === true) {
                    e.preventDefault();
                }
            }

            function allowNumberAndPoint(e) {
                if (e.keyCode === 8 || e.keyCode === 46 || (e.keyCode >= 48 && e.keyCode <= 57)) {
                    return true;
                } else {
                    e.preventDefault();
                }
            }

            function allowNumberAndPointLess(e) {
                //console.log(e.key);
                //console.log(e.target.value);
                if (e.keyCode === 8 || e.keyCode === 46 || (e.keyCode >= 48 && e.keyCode <= 57)) {
                    var val = e.target.value + e.key;
                    if (val <= 100) {
                        return true;
                    } else {
                        e.preventDefault();
                    }
                } else {
                    e.preventDefault();
                }
            }

            function openCalendar(e) {
                e.preventDefault();
                /*var el = document.getElementById(e.target.id);
                var date_icon = el.closest("span").getElementsByClassName("e-date-icon")[0];
                date_icon.click();
                date_icon.focus();
                e.preventDefault();*/
            }

            var KTBootstrapDaterangepicker = function () {

                var dateRangePicker = function () {

                    $('#daterangepicker').daterangepicker({
                        buttonClasses: ' btn',
                        applyClass: 'btn-primary',
                        cancelClass: 'btn-secondary'
                    }, function(start, end, label) {
                        $('#daterangepicker .form-control').val( start.format('DD-MM-YYYY') + ' To ' + end.format('DD-MM-YYYY'));
                        $('#rangeStart').val(start.format('YYYY-MM-DD'));
                        $('#rangeEnd').val(end.format('YYYY-MM-DD'));
                        getData();
                    });
                }

                return {
                    init: function() {
                        dateRangePicker();
                    }
                };
            }();

            jQuery(document).ready(function() {
                KTBootstrapDaterangepicker.init();
            });

            function loadCalendar(ids) {
                !function (e) {
                    function t(t) {
                        for (var l, r, d = t[0], s = t[1], o = t[2], u = 0, p = []; u < d.length; u++) r = d[u], Object.prototype.hasOwnProperty.call(i, r) && i[r] && p.push(i[r][0]), i[r] = 0;
                        for (l in s) Object.prototype.hasOwnProperty.call(s, l) && (e[l] = s[l]);
                        for (c && c(t); p.length;) p.shift()();
                        return a.push.apply(a, o || []), n()
                    }

                    function n() {
                        for (var e, t = 0; t < a.length; t++) {
                            for (var n = a[t], l = !0, d = 1; d < n.length; d++) {
                                var s = n[d];
                                0 !== i[s] && (l = !1)
                            }
                            l && (a.splice(t--, 1), e = r(r.s = n[0]))
                        }
                        return e
                    }

                    var l = {}, i = {447: 0}, a = [];

                    function r(t) {
                        if (l[t]) return l[t].exports;
                        var n = l[t] = {i: t, l: !1, exports: {}};
                        return e[t].call(n.exports, n, n.exports, r), n.l = !0, n.exports
                    }

                    r.m = e, r.c = l, r.d = function (e, t, n) {
                        r.o(e, t) || Object.defineProperty(e, t, {enumerable: !0, get: n})
                    }, r.r = function (e) {
                        "undefined" != typeof Symbol && Symbol.toStringTag && Object.defineProperty(e, Symbol.toStringTag, {value: "Module"}), Object.defineProperty(e, "__esModule", {value: !0})
                    }, r.t = function (e, t) {
                        if (1 & t && (e = r(e)), 8 & t) return e;
                        if (4 & t && "object" == typeof e && e && e.__esModule) return e;
                        var n = Object.create(null);
                        if (r.r(n), Object.defineProperty(n, "default", {
                            enumerable: !0,
                            value: e
                        }), 2 & t && "string" != typeof e) for (var l in e) r.d(n, l, function (t) {
                            return e[t]
                        }.bind(null, l));
                        return n
                    }, r.n = function (e) {
                        var t = e && e.__esModule ? function () {
                            return e.default
                        } : function () {
                            return e
                        };
                        return r.d(t, "a", t), t
                    }, r.o = function (e, t) {
                        return Object.prototype.hasOwnProperty.call(e, t)
                    }, r.p = "";
                    var d = window.webpackJsonp = window.webpackJsonp || [], s = d.push.bind(d);
                    d.push = t, d = d.slice();
                    for (var o = 0; o < d.length; o++) t(d[o]);
                    var c = s;
                    a.push([881, 0]), n()
                }
                ({
                    881: function (e, t, n) {
                        for (var key in ids) {
                            if (ids.hasOwnProperty(key)) {
                                if(key=='d'){
                                    ids[key].forEach(runLoopForDate);
                                }
                                if(key=='m'){
                                    ids[key].forEach(runLoopForMonth);
                                }
                            }
                        }

                        function runLoopForDate(item) {
                            getDatePicker(e, t, n, item);
                        }

                        function runLoopForMonth(item) {
                            getMonthPicker(e, t, n, item);
                        }
                    }
                });

                function getDatePicker(e, t, n, id) {
                    var el = document.getElementById(id);
                    var f = el.getAttribute("data-format") === null ? 'dd-MM-yyyy' : el.getAttribute("data-format");
                    var p = el.getAttribute("placeholder") === null ? 'Select Date' : el.getAttribute("placeholder");
                    returnDatePicker(e, t, n, f, p, id);
                }
                function returnDatePicker(e, t, n, f, p, id) {
                    var l, i;
                    var w = 'calc(100% - 2px)';
                    return l = [n, t, n(0), n(31), n(0)], void 0 === (i = function (e, t, n, l, i) {
                        "use strict";
                        Object.defineProperty(t, "__esModule", {value: !0}), n.enableRipple(!1);
                        var a = new l.DatePicker({
                            placeholder: p,
                            width: w,
                            format: f,
                            showTodayButton: !0,
                        });
                        a.appendTo("#" + id), a.hide()
                    }.apply(t, l)) || (e.exports = i);
                }

                function getMonthPicker(e, t, n, id) {
                    var el = document.getElementById(id);
                    var f = el.getAttribute("data-format") === null ? 'MM-yyyy' : el.getAttribute("data-format");
                    var p = el.getAttribute("placeholder") === null ? 'Select Date' : el.getAttribute("placeholder");
                    returnMonthPicker(e, t, n, f, p, id)
                }
                function returnMonthPicker(e, t, n, f, p, id) {
                    var l, i;
                    var w = 'calc(100% - 2px)';

                    return l = [n, t, n(0), n(31), n(0)], void 0 === (i = function (e, t, n, l, i) {
                        "use strict";
                        Object.defineProperty(t, "__esModule", {value: !0}), n.enableRipple(!1);
                        var a = new l.DatePicker({
                            placeholder: p,
                            width: w,
                            format: f,
                            showTodayButton: 0,
                            start: "Decade", depth: "Year",
                        });
                        a.appendTo("#" + id), a.hide()
                    }.apply(t, l)) || (e.exports = i);
                }
            }

        </script>
