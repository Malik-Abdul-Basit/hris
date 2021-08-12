"use strict";

var KTToastrDemo = function() {

    // basic demo
    var demo = function() {
        var $toastlast;

        $('#showtoast').click(function () {
            var shortCutFunction = 'success'; /*success,info,warning,error*/
            var msg = 'successfully add';
            var title = '';
            /*var $showDuration = 300;
            var $hideDuration = 1000;
            var $timeOut = 5000;
            var $extendedTimeOut = 1000;
            var $showEasing = 'swing';
            var $hideEasing = 'linear';
            var $showMethod = 'fadeIn';
            var $hideMethod = 'fadeOut';
            var addClear = false;*/

            toastr.options = {
                closeButton: true,
                debug: false,
                newestOnTop: false,
                progressBar: true,
                positionClass: 'toast-top-right', /*toast-top-right, toast-bottom-right, toast-top-left, toast-bottom-left,*/
                preventDuplicates: false,
                onclick: null,
                showDuration: 300,
                hideDuration: 500,
                timeOut: 5000,
                extendedTimeOut: 1000,
                showEasing: "swing",
                hideEasing: "linear",
                showMethod: "fadeIn",
                hideMethod: "fadeOut"
            };

            $('#toastrOptions').text(
                    'toastr.options = '
                    + JSON.stringify(toastr.options, null, 2)
                    + ';'
                    + '\n\ntoastr.'
                    + shortCutFunction
                    + '("'
                    + msg
                    + (title ? '", "' + title : '')
                    + '");'
            );

            var $toast = toastr[shortCutFunction](msg, title); // Wire up an event handler to a button in the toast, if it exists
            $toastlast = $toast;

            if(typeof $toast === 'undefined'){
                return;
            }
        });

        $('#cleartoasts').click(function () {
            toastr.clear();
        });
    }

    return {
        init: function() {
            demo();
        }
    };
}();

jQuery(document).ready(function() {
    KTToastrDemo.init();
});