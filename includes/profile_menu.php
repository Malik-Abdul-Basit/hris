<div class="flex-row-auto offcanvas-mobile w-250px w-xxl-350px" id="kt_profile_aside">
    <!--begin::Profile Card-->
    <div class="card card-custom card-stretch">
        <!--begin::Body-->
        <div class="card-body pt-4">
            <!--begin::User-->
            <div class="d-flex align-items-center">
                <div class="symbol symbol-60 symbol-xxl-100 mr-5 align-self-start align-self-xxl-center">
                    <?php echo config("employees.status.profile_status." . $result->status); ?>
                    <div class="symbol-label"
                         style="background-image:url('<?php echo getUserImage($result->employee_id)['image_path']; ?>')">
                    </div>
                </div>
                <div class="mt-5">
                    <span class="font-weight-bolder font-size-h5 text-dark-75">
                        <?php echo $result->full_name; ?>
                    </span>
                    <div class="text-muted">
                        <?php echo $result->pseudo_name; ?>
                    </div>
                    <div class="text-muted">
                        <i class="icon-md fas fa-barcode float-left"
                           style="margin:1px 5px 0 0;"></i> <?php echo $result->employee_code; ?>
                    </div>
                    <div class="mt-2">
                        <a href="#"
                           class="btn btn-sm btn-primary font-weight-bold mr-2 py-2 px-3 px-xxl-5 my-1">Chat</a>
                        <a href="#"
                           class="btn btn-sm btn-success font-weight-bold py-2 px-3 px-xxl-5 my-1">Follow</a>
                    </div>
                </div>
            </div>
            <!--end::User-->

            <!--begin::Contact-->
            <div class="py-9">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="font-weight-bold mr-2">Department:</span>
                    <span class="text-muted"><?php echo $result->department_name; ?></span>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="font-weight-bold mr-2">Designation:</span>
                    <span class="text-muted"><?php echo $result->designation_name; ?></span>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <span class="font-weight-bold mr-2">Team:</span>
                    <span class="text-muted"><?php echo !empty($result->team_name) ? $result->team_name : '-'; ?></span>
                </div>
            </div>
            <!--end::Contact-->

            <!--begin::Nav-->
            <div class="navi navi-bold navi-hover navi-active navi-link-rounded">

                <?php
                if (hasRight('employee_profile', 'view')) {
                    ?>
                    <div class="navi-item mb-2">
                        <a href="<?php echo $admin_url . 'profile_overview?emp_id=' . $result->employee_id; ?>"
                           class="navi-link py-4 <?php if ($page == 'profile_overview') {
                               echo 'active';
                           } ?>">
                            <span class="navi-icon mr-2">
                            <span class="svg-icon">
                                <svg width="24px" height="24px" viewBox="0 0 24 24">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <polygon points="0 0 24 0 24 24 0 24"/>
                                        <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,
                                        9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero"
                                              opacity="0.3"/>
                                        <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,
                                        20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,
                                        20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
                                    </g>
                                </svg>
                            </span>
                        </span>
                            <span class="navi-text font-size-lg">
                                Profile Overview
                            </span>
                        </a>
                    </div>
                    <?php
                }
                if (hasRight('employee_qualification', 'edit') || hasRight('employee_qualification', 'delete') || hasRight('employee_qualification', 'view')) {
                    ?>
                    <div class="navi-item mb-2">
                        <a href="<?php echo $admin_url . 'qualification_overview?emp_id=' . $result->employee_id; ?>"
                           class="navi-link py-4 <?php if ($page == 'qualification_overview') {
                               echo 'active';
                           } ?>">
                            <span class="navi-icon mr-2">
                            <span class="svg-icon">
                                <svg width="24px" height="24px" viewBox="0 0 24 24">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"/>
                                        <path d="M13.6855025,18.7082217 C15.9113859,17.8189707 18.682885,17.2495635 22,17 C22,16.9325178 22,13.1012863 22,5.50630526 L21.9999762,
                                        5.50630526 C21.9999762,5.23017604 21.7761292,5.00632908 21.5,5.00632908 C21.4957817,5.00632908 21.4915635,5.00638247 21.4873465,
                                        5.00648922 C18.658231,5.07811173 15.8291155,5.74261533 13,7 C13,7.04449645 13,10.79246 13,18.2438906 L12.9999854,18.2438906 C12.9999854,
                                        18.520041 13.2238496,18.7439052 13.5,18.7439052 C13.5635398,18.7439052 13.6264972,18.7317946 13.6855025,18.7082217 Z"
                                              fill="#000000"/>
                                        <path d="M10.3144829,18.7082217 C8.08859955,17.8189707 5.31710038,17.2495635 1.99998542,17 C1.99998542,16.9325178 1.99998542,
                                        13.1012863 1.99998542,5.50630526 L2.00000925,5.50630526 C2.00000925,5.23017604 2.22385621,5.00632908 2.49998542,5.00632908 C2.50420375,
                                        5.00632908 2.5084219,5.00638247 2.51263888,5.00648922 C5.34175439,5.07811173 8.17086991,5.74261533 10.9999854,7 C10.9999854,7.04449645 10.9999854,
                                        10.79246 10.9999854,18.2438906 L11,18.2438906 C11,18.520041 10.7761358,18.7439052 10.4999854,18.7439052 C10.4364457,18.7439052 10.3734882,
                                        18.7317946 10.3144829,18.7082217 Z" fill="#000000" opacity="0.3"/>
                                    </g>
                                </svg>
                            </span>
                        </span>
                            <span class="navi-text font-size-lg">
                                Qualification Detail
                            </span>
                        </a>
                    </div>
                    <?php
                }
                if (hasRight('employee_experience', 'edit') || hasRight('employee_experience', 'delete') || hasRight('employee_experience', 'view')) {
                    ?>
                    <div class="navi-item mb-2">
                        <a href="<?php echo $admin_url . 'experience_overview?emp_id=' . $result->employee_id; ?>"
                           class="navi-link py-4 <?php if ($page == 'experience_overview') {
                               echo 'active';
                           } ?>">
                            <span class="navi-icon mr-2">
                            <span class="svg-icon">
                                <svg width="24px" height="24px" viewBox="0 0 24 24">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <polygon points="0 0 24 0 24 24 0 24"/>
                                        <path d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,
                                        8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,
                                        2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,
                                        10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,
                                        16.5074963 12.9336061,16.072447 Z" fill="#000000" fill-rule="nonzero"/>
                                        <path d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,
                                        14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,
                                        15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,
                                        20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,
                                        14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,
                                        14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z"
                                              fill="#000000" opacity="0.3"/>
                                    </g>
                                </svg>
                            </span>
                        </span>
                            <span class="navi-text font-size-lg">
                                Experience Detail
                            </span>
                        </a>
                    </div>
                    <?php
                }
                if (hasRight('employee_payroll', 'edit') || hasRight('employee_payroll', 'delete') || hasRight('employee_payroll', 'view')) {
                    ?>
                    <div class="navi-item mb-2">
                        <a href="<?php echo $admin_url . 'payroll_overview?emp_id=' . $result->employee_id; ?>"
                           class="navi-link py-4 <?php if ($page == 'payroll_overview') {
                               echo 'active';
                           } ?>">
                            <span class="navi-icon mr-2">
                            <span class="svg-icon">
                                <svg width="24px" height="24px" viewBox="0 0 24 24">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"/>
                                        <path d="M8,3 L8,3.5 C8,4.32842712 8.67157288,5 9.5,5 L14.5,5 C15.3284271,5 16,4.32842712 16,3.5 L16,3 L18,3 C19.1045695,3 20,3.8954305 20,5 L20,21 C20,22.1045695 19.1045695,23 18,23 L6,23 C4.8954305,23 4,22.1045695 4,21 L4,5 C4,3.8954305 4.8954305,3 6,3 L8,3 Z"
                                              fill="#000000" opacity="0.3"/>
                                        <path d="M11,2 C11,1.44771525 11.4477153,1 12,1 C12.5522847,1 13,1.44771525 13,2 L14.5,2 C14.7761424,2 15,2.22385763 15,2.5 L15,3.5 C15,3.77614237 14.7761424,4 14.5,4 L9.5,4 C9.22385763,4 9,3.77614237 9,3.5 L9,2.5 C9,2.22385763 9.22385763,2 9.5,2 L11,2 Z"
                                              fill="#000000"/>
                                        <rect fill="#000000" opacity="0.3" x="10" y="9" width="7" height="2" rx="1"/>
                                        <rect fill="#000000" opacity="0.3" x="7" y="9" width="2" height="2" rx="1"/>
                                        <rect fill="#000000" opacity="0.3" x="7" y="13" width="2" height="2" rx="1"/>
                                        <rect fill="#000000" opacity="0.3" x="10" y="13" width="7" height="2" rx="1"/>
                                        <rect fill="#000000" opacity="0.3" x="7" y="17" width="2" height="2" rx="1"/>
                                        <rect fill="#000000" opacity="0.3" x="10" y="17" width="7" height="2" rx="1"/>
                                    </g>
                                </svg>
                            </span>
                        </span>
                            <span class="navi-text font-size-lg">
                                Payroll Detail
                            </span>
                        </a>
                    </div>
                    <?php
                }
                ?>
            </div>
            <!--end::Nav-->
        </div>
        <!--end::Body-->
    </div>
    <!--end::Profile Card-->
</div>