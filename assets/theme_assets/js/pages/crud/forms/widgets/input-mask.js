// Class definition

var KTInputmask = function () {
    
    // Private functions
    var demos = function () {
        
        // phone number format
        $("#phone").inputmask("mask", {
            "mask": "(999) 999-9999"
        });

        // cnic format
        $("#cnic,#old_cnic").inputmask("mask", {
            "mask": "99999-9999999-9"
        });

        // mobile format
        $("#mobile").inputmask({
            "mask": "999-999 9999"/*,placeholder: "800-640 6409"*/
        });

        //ip address
        $("#ip_address").inputmask({
            "mask": "999.999.999.999"
        });  

        //email address
        $("#email,#official_email").inputmask({
            mask: "*{1,20}[.*{1,20}][.*{1,20}][.*{1,20}]@*{1,20}[.*{2,6}][.*{1,2}]",
            greedy: false,
            onBeforePaste: function (pastedValue, opts) {
                pastedValue = pastedValue.toLowerCase();
                return pastedValue.replace("mailto:", "");
            },
            definitions: {
                '*': {
                    validator: "[0-9A-Za-z!#$%&'*+/=?^_`{|}~\-]",
                    cardinality: 1,
                    casing: "lower"
                }
            }
        });        
    }

    return {
        // public functions
        init: function() {
            demos(); 
        }
    };
}();

jQuery(document).ready(function() {
    KTInputmask.init();
});