$('#wrapper_dob, #wrapper_cnic_expiry, #wrapper_joining_date, #wrapper_contract_start_date, #wrapper_contract_end_date, #wrapper_leaving_date').datetimepicker({
    format: 'DD-MM-yy',
});

$('#shift_from, #shift_to').timepicker();

/*for(var i=1; i <= 10; ++i){
    $('#wrapper_date_of_completion'+i+', #wrapper_date_of_joining'+i+', #wrapper_date_of_resigning'+i).datetimepicker({
        format: 'DD-MM-yy',
    });
}*/