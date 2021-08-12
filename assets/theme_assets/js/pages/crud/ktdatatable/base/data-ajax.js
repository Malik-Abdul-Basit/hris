"use strict";
// Class definition

var KTDatatableRemoteAjaxDemo = function() {
    // Private functions

    // basic demo
    var demo = function() {

        var datatable = $('#kt_datatable').KTDatatable({
            // datasource definition
            data: {
                type: 'remote',
                source: {
                    read: {
                        url:'ajax/zdata.php',
                        // sample custom headers
                        // headers: {'x-my-custom-header': 'some value', 'x-test-header': 'the value'},
                        map: function(raw) {
                            var dataSet = raw;
                            if (typeof raw.data !== 'undefined') {
                                dataSet = raw.data;
                            }
                            return dataSet;
                        },
                    },
                },
                pageSize: 10,
                serverPaging: true,
                serverFiltering: true,
                serverSorting: true,
            },

            // layout definition
            layout: {
                scroll: false,
                footer: false,
            },

            // column sorting
            sortable: true,
            pagination: true,

            search: {
                input: $('#kt_datatable_search_query'),
                key: 'search'
            },

            // columns definition
            columns: [
                /*{
                field: 'id',
                title: 'Name',
                sortable: 'asc',
                width: 40,
                type: 'number',
                selector: false,
                textAlign: 'center',
                },*/  {
                    // callback function support for column rendering
                    //'title': 'Success' 'class': ' label-light-success'
                    field: 'first_name',
                    title: 'Name',
                    sortable: 'asc',
                    textAlign: 'center',
                    autoHide: false,
                    template: function(row) {
                        return  '<div class="card card-custom gutter-b">\n' +
                            '    <div class="card-body">\n' +
                            '        <!--begin::Top-->\n' +
                            '        <div class="d-flex">\n' +
                            '            <!--begin::Pic-->\n' +
                            '            <div class="flex-shrink-0 mr-7">\n' +
                            '                <div class="symbol symbol-50 symbol-lg-120">\n' +
                            '                    <img alt="Pic" src="../assets/theme_assets/media/users/300_21.jpg">\n' +
                            '                </div>\n' +
                            '            </div>\n' +
                            '            <!--end::Pic-->\n' +
                            '\n' +
                            '            <!--begin: Info-->\n' +
                            '            <div class="flex-grow-1">\n' +
                            '                <!--begin::Title-->\n' +
                            '                <div class="d-flex align-items-center justify-content-between flex-wrap mt-2">\n' +
                            '                    <!--begin::User-->\n' +
                            '                    <div class="mr-3">\n' +
                            '                        <!--begin::Name-->\n' +
                            '                        <a href="#" class="d-flex align-items-center text-dark text-hover-primary font-size-h5 font-weight-bold mr-3">\n' +
                            '                            Jason Muller <i class="flaticon2-correct text-success icon-md ml-2"></i>\n' +
                            '                        </a>\n' +
                            '                        <!--end::Name-->\n' +
                            '\n' +
                            '                        <!--begin::Contacts-->\n' +
                            '                        <div class="d-flex flex-wrap my-2">\n' +
                            '                            <a href="#" class="text-muted text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">\n' +
                            '                                <span class="svg-icon svg-icon-md svg-icon-gray-500 mr-1"><!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Mail-notification.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">\n' +
                            '    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\n' +
                            '        <rect x="0" y="0" width="24" height="24"></rect>\n' +
                            '        <path d="M21,12.0829584 C20.6747915,12.0283988 20.3407122,12 20,12 C16.6862915,12 14,14.6862915 14,18 C14,18.3407122 14.0283988,18.6747915 14.0829584,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,8 C3,6.8954305 3.8954305,6 5,6 L19,6 C20.1045695,6 21,6.8954305 21,8 L21,12.0829584 Z M18.1444251,7.83964668 L12,11.1481833 L5.85557487,7.83964668 C5.4908718,7.6432681 5.03602525,7.77972206 4.83964668,8.14442513 C4.6432681,8.5091282 4.77972206,8.96397475 5.14442513,9.16035332 L11.6444251,12.6603533 C11.8664074,12.7798822 12.1335926,12.7798822 12.3555749,12.6603533 L18.8555749,9.16035332 C19.2202779,8.96397475 19.3567319,8.5091282 19.1603533,8.14442513 C18.9639747,7.77972206 18.5091282,7.6432681 18.1444251,7.83964668 Z" fill="#000000"></path>\n' +
                            '        <circle fill="#000000" opacity="0.3" cx="19.5" cy="17.5" r="2.5"></circle>\n' +
                            '    </g>\n' +
                            '</svg><!--end::Svg Icon--></span>                                jason@siastudio.com\n' +
                            '                            </a>\n' +
                            '                            <a href="#" class="text-muted text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">\n' +
                            '                                <span class="svg-icon svg-icon-md svg-icon-gray-500 mr-1"><!--begin::Svg Icon | path:assets/media/svg/icons/General/Lock.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">\n' +
                            '    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\n' +
                            '        <mask fill="white">\n' +
                            '            <use xlink:href="#path-1"></use>\n' +
                            '        </mask>\n' +
                            '        <g></g>\n' +
                            '        <path d="M7,10 L7,8 C7,5.23857625 9.23857625,3 12,3 C14.7614237,3 17,5.23857625 17,8 L17,10 L18,10 C19.1045695,10 20,10.8954305 20,12 L20,18 C20,19.1045695 19.1045695,20 18,20 L6,20 C4.8954305,20 4,19.1045695 4,18 L4,12 C4,10.8954305 4.8954305,10 6,10 L7,10 Z M12,5 C10.3431458,5 9,6.34314575 9,8 L9,10 L15,10 L15,8 C15,6.34314575 13.6568542,5 12,5 Z" fill="#000000"></path>\n' +
                            '    </g>\n' +
                            '</svg><!--end::Svg Icon--></span>                                PR Manager\n' +
                            '                            </a>\n' +
                            '                            <a href="#" class="text-muted text-hover-primary font-weight-bold">\n' +
                            '                                <span class="svg-icon svg-icon-md svg-icon-gray-500 mr-1"><!--begin::Svg Icon | path:assets/media/svg/icons/Map/Marker2.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">\n' +
                            '    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\n' +
                            '        <rect x="0" y="0" width="24" height="24"></rect>\n' +
                            '        <path d="M9.82829464,16.6565893 C7.02541569,15.7427556 5,13.1079084 5,10 C5,6.13400675 8.13400675,3 12,3 C15.8659932,3 19,6.13400675 19,10 C19,13.1079084 16.9745843,15.7427556 14.1717054,16.6565893 L12,21 L9.82829464,16.6565893 Z M12,12 C13.1045695,12 14,11.1045695 14,10 C14,8.8954305 13.1045695,8 12,8 C10.8954305,8 10,8.8954305 10,10 C10,11.1045695 10.8954305,12 12,12 Z" fill="#000000"></path>\n' +
                            '    </g>\n' +
                            '</svg><!--end::Svg Icon--></span>                                Melbourne\n' +
                            '                            </a>\n' +
                            '                        </div>\n' +
                            '                        <!--end::Contacts-->\n' +
                            '                    </div>\n' +
                            '                    <!--begin::User-->\n' +
                            '\n' +
                            '                    <!--begin::Actions-->\n' +
                            '                    <div class="my-lg-0 my-1">\n' +
                            '                        <a href="#" class="btn btn-sm btn-light-primary font-weight-bolder text-uppercase mr-2">Ask</a>\n' +
                            '                        <a href="#" class="btn btn-sm btn-primary font-weight-bolder text-uppercase">Hire</a>\n' +
                            '                    </div>\n' +
                            '                    <!--end::Actions-->\n' +
                            '                </div>\n' +
                            '                <!--end::Title-->\n' +
                            '\n' +
                            '                <!--begin::Content-->\n' +
                            '                <div class="d-flex align-items-center flex-wrap justify-content-between">\n' +
                            '                    <!--begin::Description-->\n' +
                            '                    <div class="flex-grow-1 font-weight-bold text-dark-50 py-2 py-lg-2 mr-5">\n' +
                            '                        I distinguish three main text objectives could be merely to inform people.<br>\n' +
                            '                        A second could be persuade people. You want people to bay objective.\n' +
                            '                    </div>\n' +
                            '                    <!--end::Description-->\n' +
                            '\n' +
                            '                    <!--begin::Progress-->\n' +
                            '                    <div class="d-flex mt-4 mt-sm-0">\n' +
                            '                        <span class="font-weight-bold mr-4">Progress</span>\n' +
                            '                        <div class="progress progress-xs mt-2 mb-2 flex-shrink-0 w-150px w-xl-250px">\n' +
                            '                            <div class="progress-bar bg-success" role="progressbar" style="width: 63%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>\n' +
                            '                        </div>\n' +
                            '                        <span class="font-weight-bolder text-dark ml-4">78%</span>\n' +
                            '                    </div>\n' +
                            '                    <!--end::Progress-->\n' +
                            '                </div>\n' +
                            '                <!--end::Content-->\n' +
                            '            </div>\n' +
                            '            <!--end::Info-->\n' +
                            '        </div>\n' +
                            '        <!--end::Top-->\n' +
                            '\n' +
                            '        <!--begin::Separator-->\n' +
                            '        <div class="separator separator-solid my-7"></div>\n' +
                            '        <!--end::Separator-->\n' +
                            '\n' +
                            '        <!--begin::Bottom-->\n' +
                            '        <div class="d-flex align-items-center flex-wrap">\n' +
                            '            <!--begin: Item-->\n' +
                            '            <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">\n' +
                            '                <span class="mr-4">\n' +
                            '                    <i class="flaticon-piggy-bank icon-2x text-muted font-weight-bold"></i>\n' +
                            '                </span>\n' +
                            '                <div class="d-flex flex-column text-dark-75">\n' +
                            '                    <span class="font-weight-bolder font-size-sm">Earnings</span>\n' +
                            '                    <span class="font-weight-bolder font-size-h5"><span class="text-dark-50 font-weight-bold">$</span>249,500</span>\n' +
                            '                </div>\n' +
                            '            </div>\n' +
                            '            <!--end: Item-->\n' +
                            '\n' +
                            '            <!--begin: Item-->\n' +
                            '            <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">\n' +
                            '                <span class="mr-4">\n' +
                            '                    <i class="flaticon-confetti icon-2x text-muted font-weight-bold"></i>\n' +
                            '                </span>\n' +
                            '                <div class="d-flex flex-column text-dark-75">\n' +
                            '                    <span class="font-weight-bolder font-size-sm">Expenses</span>\n' +
                            '                    <span class="font-weight-bolder font-size-h5"><span class="text-dark-50 font-weight-bold">$</span>164,700</span>\n' +
                            '                </div>\n' +
                            '            </div>\n' +
                            '            <!--end: Item-->\n' +
                            '\n' +
                            '            <!--begin: Item-->\n' +
                            '            <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">\n' +
                            '                <span class="mr-4">\n' +
                            '                    <i class="flaticon-pie-chart icon-2x text-muted font-weight-bold"></i>\n' +
                            '                </span>\n' +
                            '                <div class="d-flex flex-column text-dark-75">\n' +
                            '                    <span class="font-weight-bolder font-size-sm">Net</span>\n' +
                            '                    <span class="font-weight-bolder font-size-h5"><span class="text-dark-50 font-weight-bold">$</span>782,300</span>\n' +
                            '                </div>\n' +
                            '            </div>\n' +
                            '            <!--end: Item-->\n' +
                            '\n' +
                            '            <!--begin: Item-->\n' +
                            '            <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">\n' +
                            '                <span class="mr-4">\n' +
                            '                    <i class="flaticon-file-2 icon-2x text-muted font-weight-bold"></i>\n' +
                            '                </span>\n' +
                            '                <div class="d-flex flex-column flex-lg-fill">\n' +
                            '                    <span class="text-dark-75 font-weight-bolder font-size-sm">73 Tasks</span>\n' +
                            '                    <a href="#" class="text-primary font-weight-bolder">View</a>\n' +
                            '                </div>\n' +
                            '            </div>\n' +
                            '            <!--end: Item-->\n' +
                            '\n' +
                            '            <!--begin: Item-->\n' +
                            '            <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">\n' +
                            '                <span class="mr-4">\n' +
                            '                    <i class="flaticon-chat-1 icon-2x text-muted font-weight-bold"></i>\n' +
                            '                </span>\n' +
                            '                <div class="d-flex flex-column">\n' +
                            '                    <span class="text-dark-75 font-weight-bolder font-size-sm">648 Comments</span>\n' +
                            '                    <a href="#" class="text-primary font-weight-bolder">View</a>\n' +
                            '                </div>\n' +
                            '            </div>\n' +
                            '            <!--end: Item-->\n' +
                            '\n' +
                            '            <!--begin: Item-->\n' +
                            '            <div class="d-flex align-items-center flex-lg-fill my-1">\n' +
                            '                <span class="mr-4">\n' +
                            '                    <i class="flaticon-network icon-2x text-muted font-weight-bold"></i>\n' +
                            '                </span>\n' +
                            '                <div class="symbol-group symbol-hover">\n' +
                            '                    <div class="symbol symbol-30 symbol-circle" data-toggle="tooltip" title="" data-original-title="Mark Stone">\n' +
                            '                        <img alt="Pic" src="assets/media/users/300_25.jpg">\n' +
                            '                    </div>\n' +
                            '                    <div class="symbol symbol-30 symbol-circle" data-toggle="tooltip" title="" data-original-title="Charlie Stone">\n' +
                            '                        <img alt="Pic" src="assets/media/users/300_19.jpg">\n' +
                            '                    </div>\n' +
                            '                    <div class="symbol symbol-30 symbol-circle" data-toggle="tooltip" title="" data-original-title="Luca Doncic">\n' +
                            '                        <img alt="Pic" src="assets/media/users/300_22.jpg">\n' +
                            '                    </div>\n' +
                            '                    <div class="symbol symbol-30 symbol-circle" data-toggle="tooltip" title="" data-original-title="Nick Mana">\n' +
                            '                        <img alt="Pic" src="assets/media/users/300_23.jpg">\n' +
                            '                    </div>\n' +
                            '                    <div class="symbol symbol-30 symbol-circle" data-toggle="tooltip" title="" data-original-title="Teresa Fox">\n' +
                            '                        <img alt="Pic" src="assets/media/users/300_18.jpg">\n' +
                            '                    </div>\n' +
                            '                    <div class="symbol symbol-30  symbol-circle symbol-light" data-toggle="tooltip" title="" data-original-title="More users">\n' +
                            '                        <span class="symbol-label font-weight-bold">5+</span>\n' +
                            '                    </div>\n' +
                            '                </div>\n' +
                            '            </div>\n' +
                            '            <!--end: Item-->\n' +
                            '        </div>\n' +
                            '        <!--end::Bottom-->\n' +
                            '    </div>\n' +
                            '</div>';







                    }


            }],

        });

		$('#kt_datatable_search_status').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'status');
        });

        $('#kt_datatable_search_type').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'type');
        });

        $('#kt_datatable_search_status, #kt_datatable_search_type').selectpicker();
    };

    return {
        // public functions
        init: function() {
            demo();
        },
    };
}();

jQuery(document).ready(function() {
    KTDatatableRemoteAjaxDemo.init();
});
