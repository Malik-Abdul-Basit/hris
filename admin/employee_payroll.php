<?php
include_once("header/check_login.php");
include_once("../includes/head.php");
include_once("../includes/mobile_menu.php");
?>
    <!--begin::Main-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="d-flex flex-row flex-column-fluid page">
            <!--begin::Aside-->
            <?php include_once("../includes/main_menu.php"); ?>
            <!--end::Aside-->
            <!--begin::Wrapper-->
            <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
                <!--begin::Header-->
                <?php include_once("../includes/header_menu.php"); ?>
                <!--end::Header-->

                <!--begin::Content-->
                <div class="content  d-flex flex-column flex-column-fluid" id="kt_content">
                    <!--begin::Breadcrumb-->
                    <?php include_once('../includes/bread_crumb.php');?>
                    <!--end::Breadcrumb-->

                    <!--begin::Entry-->
                    <div class="d-flex flex-column-fluid">
                        <!--begin::Container-->
                        <div class="container">
                            <!--begin::Card-->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card card-custom">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                                <?php
                                                echo ucwords(str_replace("_", " ", $page));

                                                $NAttrs = ' type="number" class="form-control" ';
                                                $DateInput = '  type="text" class="DatePicker e-input form-control" onkeypress="openCalendar(event)" onfocus="openCalendar(event)" onclick="openCalendar(event)" maxlength="10" data-format="dd-MM-yyyy" ';
                                                $TAttrs = ' type="text" class="form-control" ';
                                                $disable = ' type="text" class="form-control form-control-solid" disabled readonly style="cursor: not-allowed" ';
                                                $onblur = ' onblur="change_color(this.value, this.id)" ';
                                                $emp_code = '';
                                                if (isset($_GET['emp_code']) && is_numeric($_GET['emp_code']) && !empty($_GET['emp_code'])) {
                                                    $emp_code = $_GET['emp_code'];
                                                }

                                                ?>
                                            </h3>
                                        </div>
                                        <!--begin::Form-->
                                        <form class="form" id="myFORM" name="myFORM" method="post"
                                              enctype="multipart/form-data">
                                            <div class="card-body">
                                                <div class="alert alert-custom alert-light-danger overflow-hidden"
                                                     role="alert" id="responseMessageWrapper">
                                                    <div class="alert-text font-weight-bold float-left"
                                                         id="responseMessage"></div>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="mb-2">
                                                        <div class="row">
                                                            <div class="col-md-8">
                                                                <h3 class="font-size-lg text-dark-75 font-weight-bold mb-10">
                                                                    Employee Information:</h3>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>* Employee Code:</label>
                                                                            <input tabindex="10" maxlength="20" id="employee_code"
                                                                                   onkeypress="runScript(event)"
                                                                                   onchange="getEmployee(this.value)"
                                                                                   value="<?php echo $emp_code; ?>" <?php echo $TAttrs . $onblur; ?>
                                                                                   placeholder="Employee Code"/>
                                                                            <div class="error_wrapper">
                                                                                <span class="text-danger"
                                                                                      id="errorMessageEmployeeCode"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Employee Email:</label>
                                                                            <input id="emp_email"
                                                                                   value="" <?php echo $disable; ?>
                                                                                   placeholder="Employee Email"/>
                                                                            <div class="error_wrapper">
                                                                                <span class="text-danger"
                                                                                      id="errorMessageEmployeeEmail"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Full Name:</label>
                                                                            <input id="full_name"
                                                                                   value="" <?php echo $disable; ?>
                                                                                   placeholder="Employee Full Name"/>
                                                                            <div class="error_wrapper">
                                                                                <span class="text-danger"
                                                                                      id="errorMessageFullName"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Pseudo Name:</label>
                                                                            <input id="emp_pseudo_name"
                                                                                   value="" <?php echo $disable; ?>
                                                                                   placeholder="Pseudo Name"/>
                                                                            <div class="error_wrapper">
                                                                                <span class="text-danger"
                                                                                      id="errorMessageEmployeePseudoName"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="employee_image_wrapper"
                                                                     id="employee_image_wrapper"></div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="separator separator-dashed my-10"></div>

                                                <div class="mb-3">
                                                    <h3 class="font-size-lg text-dark-75 font-weight-bold mb-10">
                                                        Joining Information:</h3>
                                                    <div class="mb-2">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>* Joining Date:</label>
                                                                    <input tabindex="20" <?php echo $DateInput; ?>
                                                                           id="joining_date" placeholder="Joining Date"">
                                                                    <span class="e-clear-icon e-clear-icon-hide"
                                                                          aria-label="close" role="button"></span>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageJoiningDate"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label> Contract Start Date:</label>
                                                                    <input tabindex="30" <?php echo $DateInput; ?>
                                                                           id="contract_start_date"
                                                                           placeholder="Contract Start Date">
                                                                    <span class="e-clear-icon e-clear-icon-hide"
                                                                          aria-label="close" role="button"></span>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageContractStartDate"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label> Contract Renewal Date:</label>
                                                                    <input tabindex="40" <?php echo $DateInput; ?>
                                                                           id="contract_end_date"
                                                                           placeholder="Renewal Date">
                                                                    <span class="e-clear-icon e-clear-icon-hide"
                                                                          aria-label="close" role="button"></span>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageContractEndDate"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label> Leaving Date:</label>
                                                                    <input tabindex="50" <?php echo $DateInput; ?>
                                                                           id="leaving_date" placeholder="Leaving Date">
                                                                    <span class="e-clear-icon e-clear-icon-hide"
                                                                          aria-label="close" role="button"></span>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageLeavingDate"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="separator separator-dashed my-10"></div>

                                                <div class="mb-3">
                                                    <h3 class="font-size-lg text-dark-75 font-weight-bold mb-10">
                                                        Payroll Information:</h3>
                                                    <div class="mb-2">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>NTN <small>National Tax
                                                                            Number</small></label>
                                                                    <input tabindex="60" id="ntn"
                                                                           value="" <?php echo $NAttrs . $onblur; ?>
                                                                           placeholder="NTN"/>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageNTN"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>EOBI No. <small>Employees Old-Age Benefits
                                                                            Institution</small></label>
                                                                    <input tabindex="70" id="eobi_no"
                                                                           value="" <?php echo $NAttrs . $onblur; ?>
                                                                           placeholder="EOBI No"/>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageEOBINo"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>Provident Fund No.:</label>
                                                                    <input tabindex="80" id="pf_no"
                                                                           value="" <?php echo $NAttrs . $onblur; ?>
                                                                           placeholder="Provident Fund No."/>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessagePFNo"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>* Salary:</label>
                                                                    <input tabindex="90" id="salary"
                                                                           value="" <?php echo $NAttrs . $onblur; ?>
                                                                           placeholder="Salary"/>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageSalary"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>Provident Fund:</label>
                                                                    <input tabindex="100" id="pf"
                                                                           value="" <?php echo $NAttrs . $onblur; ?>
                                                                           placeholder="Provident Fund"/>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessagePF"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>Employees Old-Age Benefits
                                                                        Institution</label>
                                                                    <input tabindex="110" id="eobi"
                                                                           value="" <?php echo $NAttrs . $onblur; ?>
                                                                           placeholder="Employees Old-Age Benefits Institution"/>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageEOBI"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>Special Allowences:</label>
                                                                    <input tabindex="120" id="special_allowences"
                                                                           value="" <?php echo $NAttrs . $onblur; ?>
                                                                           placeholder="Special Allowences"/>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageSpecialAllowences"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>Reimburse Value:</label>
                                                                    <input tabindex="130" id="reimburse_value"
                                                                           value="" <?php echo $NAttrs . $onblur; ?>
                                                                           placeholder="Reimburse Value"/>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageReimburseValue"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="separator separator-dashed my-10"></div>

                                                <div class="mb-3">
                                                    <h3 class="font-size-lg text-dark-75 font-weight-bold mb-10">
                                                        Deduction:</h3>
                                                    <div class="mb-2">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>Provident Fund:</label>
                                                                    <input tabindex="140" id="deduct_pf"
                                                                           value="" <?php echo $NAttrs . $onblur; ?>
                                                                           placeholder="Provident Fund"/>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageDeductPF"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>EOBI <small>Employees Old-Age Benefits
                                                                            Institution</small></label>
                                                                    <input tabindex="150" id="deduct_eobi"
                                                                           value="" <?php echo $NAttrs . $onblur; ?>
                                                                           placeholder="EOBI"/>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageDeductEOBI"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>Tax</label>
                                                                    <input tabindex="160" id="deduct_tax"
                                                                           value="" <?php echo $NAttrs . $onblur; ?>
                                                                           placeholder="Tax"/>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageTaxRate"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <button type="button" onclick="saveFORM()"
                                                                class="btn btn-primary font-weight-bold mr-2"><?php echo config('lang.button.title.save'); ?>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <!--end::Form-->
                                    </div>
                                </div>
                            </div>
                            <!--end::Card-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Entry-->
                </div>
                <!--end::Content-->

                <!--begin::Footer-->
                <?php include_once("../includes/footer_statement.php"); ?>
                <!--end::Footer-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::Main-->
<?php
include_once("../includes/footer.php");
include_once("../includes/footer_script.php");
?>
    <script>
        function saveFORM() {

            var validDate = /^(0[1-9]|1\d|2\d|3[01])\-(0[1-9]|1[0-2])\-(19|20)\d{2}$/;

            var employee_code = document.getElementById('employee_code');
            var joining_date = document.getElementById('joining_date');
            var contract_start_date = document.getElementById('contract_start_date');
            var contract_end_date = document.getElementById('contract_end_date');
            var leaving_date = document.getElementById('leaving_date');
            var ntn = document.getElementById('ntn');
            var eobi_no = document.getElementById('eobi_no');
            var pf_no = document.getElementById('pf_no');
            var salary = document.getElementById('salary');
            var pf = document.getElementById('pf');
            var eobi = document.getElementById('eobi');
            var special_allowences = document.getElementById('special_allowences');
            var reimburse_value = document.getElementById('reimburse_value');
            var deduct_pf = document.getElementById('deduct_pf');
            var deduct_eobi = document.getElementById('deduct_eobi');
            var deduct_tax = document.getElementById('deduct_tax');

            var errorMessageEmployeeCode = document.getElementById('errorMessageEmployeeCode');
            var errorMessageJoiningDate = document.getElementById('errorMessageJoiningDate');
            var errorMessageContractStartDate = document.getElementById('errorMessageContractStartDate');
            var errorMessageContractEndDate = document.getElementById('errorMessageContractEndDate');
            var errorMessageLeavingDate = document.getElementById('errorMessageLeavingDate');
            var errorMessageNTN = document.getElementById('errorMessageNTN');
            var errorMessageEOBINo = document.getElementById('errorMessageEOBINo');
            var errorMessagePFNo = document.getElementById('errorMessagePFNo');
            var errorMessageSalary = document.getElementById('errorMessageSalary');
            var errorMessagePF = document.getElementById('errorMessagePF');
            var errorMessageEOBI = document.getElementById('errorMessageEOBI');
            var errorMessageSpecialAllowences = document.getElementById('errorMessageSpecialAllowences');
            var errorMessageReimburseValue = document.getElementById('errorMessageReimburseValue');
            var errorMessageDeductPF = document.getElementById('errorMessageDeductPF');
            var errorMessageDeductEOBI = document.getElementById('errorMessageDeductEOBI');
            var errorMessageTaxRate = document.getElementById('errorMessageTaxRate');

            var employeeImageWrapper = document.getElementById('employee_image_wrapper');

            var responseMessageWrapper = document.getElementById('responseMessageWrapper');
            var responseMessage = document.getElementById('responseMessage');

            employee_code.style.borderColor = joining_date.style.borderColor = contract_start_date.style.borderColor = contract_end_date.style.borderColor = leaving_date.style.borderColor = '#E4E6EF';
            ntn.style.borderColor = eobi_no.style.borderColor = pf_no.style.borderColor = salary.style.borderColor = pf.style.borderColor = eobi.style.borderColor = '#E4E6EF';
            special_allowences.style.borderColor = reimburse_value.style.borderColor = deduct_pf.style.borderColor = deduct_eobi.style.borderColor = deduct_tax.style.borderColor = '#E4E6EF';

            errorMessageEmployeeCode.innerText = errorMessageJoiningDate.innerText = errorMessageContractStartDate.innerText = errorMessageContractEndDate.innerText = errorMessageLeavingDate.innerText = "";
            errorMessageNTN.innerText = errorMessageEOBINo.innerText = errorMessagePFNo.innerText = errorMessageSalary.innerText = "";
            errorMessagePF.innerText = errorMessageEOBI.innerText = errorMessageSpecialAllowences.innerText = errorMessageReimburseValue.innerText = "";
            errorMessageDeductPF.innerText = errorMessageDeductEOBI.innerText = errorMessageTaxRate.innerText = "";

            responseMessage.innerText = '';
            responseMessageWrapper.style.display = "none";

            if (employee_code.value == '') {
                employee_code.style.borderColor = '#F00';
                errorMessageEmployeeCode.innerText = "Employee Code field is required.";
                return false;
            } else if (isNaN(employee_code.value) === true || employee_code.value < 1 || employee_code.value.length > 20) {
                employee_code.style.borderColor = '#F00';
                errorMessageEmployeeCode.innerText = "Invalid Employee Code.";
                return false;
            } else if (joining_date.value == '') {
                joining_date.style.borderColor = '#F00';
                errorMessageJoiningDate.innerText = "Joining Date field is required.";
                return false;
            } else if (!(validDate.test(joining_date.value)) || joining_date.value.length !== 10) {
                joining_date.style.borderColor = '#F00';
                errorMessageJoiningDate.innerText = "Please select a valid date.";
                return false;
            } else if (contract_start_date.value != '' && (!(validDate.test(contract_start_date.value)) || contract_start_date.value.length !== 10)) {
                contract_start_date.style.borderColor = '#F00';
                errorMessageContractStartDate.innerText = "Please select a valid date.";
                return false;
            } else if (contract_end_date.value != '' && (!(validDate.test(contract_end_date.value)) || contract_end_date.value.length !== 10)) {
                contract_end_date.style.borderColor = '#F00';
                errorMessageContractEndDate.innerText = "Please select a valid date.";
                return false;
            } else if (leaving_date.value != '' && (!(validDate.test(leaving_date.value)) || leaving_date.value.length !== 10)) {
                leaving_date.style.borderColor = '#F00';
                errorMessageLeavingDate.innerText = "Please select a valid date.";
                return false;
            } else if (ntn.value != '' && (isNaN(ntn.value) === true || ntn.value < 1 || ntn.value.length > 9)) {
                ntn.style.borderColor = '#F00';
                errorMessageNTN.innerText = "Invalid National Tax Number.";
                return false;
            } else if (eobi_no.value != '' && (isNaN(eobi_no.value) === true || eobi_no.value < 1 || eobi_no.value.length > 9)) {
                eobi_no.style.borderColor = '#F00';
                errorMessageEOBINo.innerText = "Invalid Employees Old-Age Benefits Institution Number.";
                return false;
            } else if (pf_no.value != '' && (isNaN(pf_no.value) === true || pf_no.value < 1 || pf_no.value.length > 9)) {
                pf.style.borderColor = '#F00';
                errorMessagePFNo.innerText = "Invalid Provident Fund Number.";
                return false;
            } else if (salary.value == '') {
                salary.style.borderColor = '#F00';
                errorMessageSalary.innerText = "Salary field is required.";
                return false;
            } else if (isNaN(salary.value) === true || salary.value < 1 || salary.value.length > 9) {
                salary.style.borderColor = '#F00';
                errorMessageSalary.innerText = "Invalid amount of Salary.";
                return false;
            } else if (pf.value != '' && (isNaN(pf.value) === true || pf.value < 1 || pf.value.length > 9)) {
                pf.style.borderColor = '#F00';
                errorMessagePF.innerText = "Invalid amount of Provident Fund.";
                return false;
            } else if (eobi.value != '' && (isNaN(eobi.value) === true || eobi.value < 1 || eobi.value.length > 9)) {
                eobi.style.borderColor = '#F00';
                errorMessageEOBI.innerText = "Invalid amount of Employees Old-Age Benefits Institution.";
                return false;
            } else if (special_allowences.value != '' && (isNaN(special_allowences.value) === true || special_allowences.value < 1 || special_allowences.value.length > 9)) {
                special_allowences.style.borderColor = '#F00';
                errorMessageSpecialAllowences.innerText = "Invalid amount of Special Allowences.";
                return false;
            } else if (reimburse_value.value != '' && (isNaN(reimburse_value.value) === true || reimburse_value.value < 1 || reimburse_value.value.length > 9)) {
                reimburse_value.style.borderColor = '#F00';
                errorMessageReimburseValue.innerText = "Invalid amount of Reimburse Value.";
                return false;
            } else if (deduct_pf.value != '' && (isNaN(deduct_pf.value) === true || deduct_pf.value < 1 || deduct_pf.value.length > 9)) {
                deduct_pf.style.borderColor = '#F00';
                errorMessageDeductPF.innerText = "Invalid amount of Provident Fund.";
                return false;
            } else if (deduct_eobi.value != '' && (isNaN(deduct_eobi.value) === true || deduct_eobi.value < 1 || deduct_eobi.value.length > 9)) {
                deduct_eobi.style.borderColor = '#F00';
                errorMessageDeductEOBI.innerText = "Invalid amount of Employees Old-Age Benefits Institution.";
                return false;
            } else if (deduct_tax.value != '' && (isNaN(deduct_tax.value) === true || deduct_tax.value < 1 || deduct_tax.value.length > 9)) {
                deduct_tax.style.borderColor = '#F00';
                errorMessageTaxRate.innerText = "Invalid amount of Tax.";
                return false;
            } else {
                loader(true);
                var postData = {
                    "employee_code": employee_code.value,
                    "joining_date": joining_date.value,
                    "contract_start_date": contract_start_date.value,
                    "contract_end_date": contract_end_date.value,
                    "leaving_date": leaving_date.value,
                    "ntn": ntn.value,
                    "eobi_no": eobi_no.value,
                    "pf_no": pf_no.value,
                    "salary": salary.value,
                    "pf": pf.value,
                    "eobi": eobi.value,
                    "special_allowences": special_allowences.value,
                    "reimburse_value": reimburse_value.value,
                    "deduct_pf": deduct_pf.value,
                    "deduct_eobi": deduct_eobi.value,
                    "deduct_tax": deduct_tax.value,
                    "user_right_title": '<?php echo $user_right_title; ?>'
                };
                $.ajax({
                    type: "POST", url: "ajax/employee_payroll.php",
                    data: {'postData': postData},
                    success: function (resPonse) {
                        if (resPonse !== undefined && resPonse != '') {
                            var obj = JSON.parse(resPonse);
                            if (obj.code === 200 || obj.code === 405 || obj.code === 422) {
                                var title = '';
                                if (obj.code === 422) {
                                    if (obj.errorField !== undefined && obj.errorField != '' && obj.errorDiv !== undefined && obj.errorDiv != '' && obj.errorMessage !== undefined && obj.errorMessage != '') {
                                        document.getElementById(obj.errorField).style.borderColor = '#F00';
                                        document.getElementById(obj.errorDiv).innerText = obj.errorMessage;
                                        loader(false);
                                        toasterTrigger('warning', obj.errorMessage);
                                    }
                                } else if (obj.code === 405 || obj.code === 200) {
                                    if (obj.responseMessage !== undefined && obj.responseMessage != '') {
                                        if(obj.code === 200 && obj.employee_id !== undefined && obj.employee_id != '' && isNaN(obj.employee_id) === false && obj.employee_id > 0 ){
                                            var redirect = <?php echo isset($_GET['emp_code']) && is_numeric($_GET['emp_code']) && !empty($_GET['emp_code']) ?'"'.$admin_url.'payroll_overview?emp_id="' : '""'; ?>;
                                            if (redirect != '') {
                                                window.location = redirect+obj.employee_id;
                                            }
                                        }

                                        if (obj.form_reset !== undefined && obj.form_reset) {
                                            document.getElementById("myFORM").reset();
                                            employeeImageWrapper.innerHTML = "";
                                        }
                                        loader(false);
                                        toasterTrigger(obj.toasterClass, obj.responseMessage);
                                    } else {
                                        loader(false);
                                    }
                                } else {
                                    loader(false);
                                }
                            } else {
                                loader(false);
                            }
                        } else {
                            loader(false);
                        }
                    },
                    error: function () {
                        loader(false);
                    }
                });
            }
        }

        function getEmployee(code) {
            loader(true);
            var employee_code = document.getElementById('employee_code');
            var joining_date = document.getElementById('joining_date');
            var contract_start_date = document.getElementById('contract_start_date');
            var contract_end_date = document.getElementById('contract_end_date');
            var leaving_date = document.getElementById('leaving_date');
            var ntn = document.getElementById('ntn');
            var eobi_no = document.getElementById('eobi_no');
            var pf_no = document.getElementById('pf_no');
            var salary = document.getElementById('salary');
            var pf = document.getElementById('pf');
            var eobi = document.getElementById('eobi');
            var special_allowences = document.getElementById('special_allowences');
            var reimburse_value = document.getElementById('reimburse_value');
            var deduct_pf = document.getElementById('deduct_pf');
            var deduct_eobi = document.getElementById('deduct_eobi');
            var deduct_tax = document.getElementById('deduct_tax');

            var errorMessageEmployeeCode = document.getElementById('errorMessageEmployeeCode');
            var errorMessageJoiningDate = document.getElementById('errorMessageJoiningDate');
            var errorMessageContractStartDate = document.getElementById('errorMessageContractStartDate');
            var errorMessageContractEndDate = document.getElementById('errorMessageContractEndDate');
            var errorMessageLeavingDate = document.getElementById('errorMessageLeavingDate');
            var errorMessageNTN = document.getElementById('errorMessageNTN');
            var errorMessageEOBINo = document.getElementById('errorMessageEOBINo');
            var errorMessagePFNo = document.getElementById('errorMessagePFNo');
            var errorMessageSalary = document.getElementById('errorMessageSalary');
            var errorMessagePF = document.getElementById('errorMessagePF');
            var errorMessageEOBI = document.getElementById('errorMessageEOBI');
            var errorMessageSpecialAllowences = document.getElementById('errorMessageSpecialAllowences');
            var errorMessageReimburseValue = document.getElementById('errorMessageReimburseValue');
            var errorMessageDeductPF = document.getElementById('errorMessageDeductPF');
            var errorMessageDeductEOBI = document.getElementById('errorMessageDeductEOBI');
            var errorMessageTaxRate = document.getElementById('errorMessageTaxRate');

            var employeeImageWrapper = document.getElementById('employee_image_wrapper');
            var responseMessageWrapper = document.getElementById('responseMessageWrapper');
            var responseMessage = document.getElementById('responseMessage');

            var emp_email = document.getElementById('emp_email');
            var full_name = document.getElementById('full_name');
            var emp_pseudo_name = document.getElementById('emp_pseudo_name');

            emp_email.value = full_name.value = emp_pseudo_name.value = joining_date.value = contract_start_date.value = contract_end_date.value = leaving_date.value = '';
            ntn.value = eobi_no.value = pf_no.value = salary.value = pf.value = eobi.value = special_allowences.value = reimburse_value.value = deduct_pf.value = deduct_eobi.value = deduct_tax.value = '';

            employee_code.style.borderColor = joining_date.style.borderColor = contract_start_date.style.borderColor = contract_end_date.style.borderColor = leaving_date.style.borderColor = '#E4E6EF';
            ntn.style.borderColor = eobi_no.style.borderColor = pf_no.style.borderColor = salary.style.borderColor = pf.style.borderColor = eobi.style.borderColor = '#E4E6EF';
            special_allowences.style.borderColor = reimburse_value.style.borderColor = deduct_pf.style.borderColor = deduct_eobi.style.borderColor = deduct_tax.style.borderColor = '#E4E6EF';

            errorMessageEmployeeCode.innerText = errorMessageJoiningDate.innerText = errorMessageContractStartDate.innerText = errorMessageContractEndDate.innerText = errorMessageLeavingDate.innerText = '';
            errorMessageNTN.innerText = errorMessageEOBINo.innerText = errorMessagePFNo.innerText = errorMessageSalary.innerText = '';
            errorMessagePF.innerText = errorMessageEOBI.innerText = errorMessageSpecialAllowences.innerText = errorMessageReimburseValue.innerText = '';
            errorMessageDeductPF.innerText = errorMessageDeductEOBI.innerText = errorMessageTaxRate.innerText = responseMessage.innerText = employeeImageWrapper.innerHTML = '';
            responseMessageWrapper.style.display = "none";

            var postData = {"code": code};
            $.ajax({
                type: "POST", url: "ajax/common.php",
                data: {'postData': postData, 'getEmployee': true, "R": "employee_payroll"},
                success: function (resPonse) {
                    if (resPonse !== undefined && resPonse != '') {
                        var obj = JSON.parse(resPonse);
                        if (obj.code !== undefined && obj.code != '') {
                            if (obj.code === 405 && obj.hasRight === false) {
                                loader(false);
                                toasterTrigger('warning', 'Sorry! You have no right to perform this action.');
                            } else if (obj.code === 200 && obj.employee_info !== undefined && obj.employee_info != '' && obj.hasRight === true) {
                                var employee_info = obj.employee_info;
                                emp_email.value = employee_info.email;
                                full_name.value = employee_info.full_name;
                                emp_pseudo_name.value = employee_info.pseudo_name;
                                employeeImageWrapper.innerHTML = '<div class="employee_image_portion"><img src="' + employee_info.image + '" alt="' + code + '"></div>';
                                getPayrollInfo(employee_info.id);
                            } else if (obj.code === 404) {
                                if (obj.responseMessage !== undefined && obj.responseMessage != '') {
                                    responseMessageWrapper.style.display = "block";
                                    responseMessage.innerText = errorMessageEmployeeCode.innerText = obj.responseMessage;
                                    employee_code.style.borderColor = '#F00';
                                    loader(false);
                                }
                            } else {
                                loader(false);
                            }
                        } else {
                            loader(false);
                        }
                    } else {
                        loader(false);
                    }
                },
                error: function () {
                    loader(false);
                }
            });
        }

        function getPayrollInfo(id) {

            var joining_date = document.getElementById('joining_date');
            var contract_start_date = document.getElementById('contract_start_date');
            var contract_end_date = document.getElementById('contract_end_date');
            var leaving_date = document.getElementById('leaving_date');
            var ntn = document.getElementById('ntn');
            var eobi_no = document.getElementById('eobi_no');
            var pf_no = document.getElementById('pf_no');
            var salary = document.getElementById('salary');
            var pf = document.getElementById('pf');
            var eobi = document.getElementById('eobi');
            var special_allowences = document.getElementById('special_allowences');
            var reimburse_value = document.getElementById('reimburse_value');
            var deduct_pf = document.getElementById('deduct_pf');
            var deduct_eobi = document.getElementById('deduct_eobi');
            var deduct_tax = document.getElementById('deduct_tax');

            ntn.value = eobi_no.value = pf_no.value = salary.value = pf.value = eobi.value = special_allowences.value = reimburse_value.value = deduct_pf.value = deduct_eobi.value = deduct_tax.value = '';

            var postData = {"id": id};
            $.ajax({
                type: "POST", url: "ajax/common.php",
                data: {'postData': postData, 'getPayrollInfo': true},
                success: function (resPonse) {
                    if (resPonse !== undefined && resPonse != '') {
                        var obj = JSON.parse(resPonse);
                        if (obj.code !== undefined && obj.code != '') {
                            if (obj.code === 200) {
                                joining_date.value = obj.data[0].joining_date;
                                contract_start_date.value = obj.data[0].contract_start_date;
                                contract_end_date.value = obj.data[0].contract_end_date;
                                leaving_date.value = obj.data[0].leaving_date;
                                ntn.value = obj.data[0].ntn > 0 ? obj.data[0].ntn : '';
                                eobi_no.value = obj.data[0].eobi_no > 0 ? obj.data[0].eobi_no : '';
                                pf_no.value = obj.data[0].pf_no > 0 ? obj.data[0].pf_no : '';
                                salary.value = obj.data[0].salary;
                                pf.value = obj.data[0].pf > 0 ? obj.data[0].pf : '';
                                eobi.value = obj.data[0].eobi > 0 ? obj.data[0].eobi : '';
                                special_allowences.value = obj.data[0].special_allowences > 0 ? obj.data[0].special_allowences : '';
                                reimburse_value.value = obj.data[0].reimburse_value > 0 ? obj.data[0].reimburse_value : '';
                                deduct_pf.value = obj.data[0].deduct_pf > 0 ? obj.data[0].deduct_pf : '';
                                deduct_eobi.value = obj.data[0].deduct_eobi > 0 ? obj.data[0].deduct_eobi : '';
                                deduct_tax.value = obj.data[0].deduct_tax > 0 ? obj.data[0].deduct_tax : '';
                                loader(false);
                            } else {
                                loader(false);
                            }
                        } else {
                            loader(false);
                        }
                    } else {
                        loader(false);
                    }
                },
                error: function () {
                    loader(false);
                }
            });
        }

        function runScript(e) {
            if (e.keyCode == 13 || isNaN(e.key) === false) {
                if (e.keyCode == 13) {
                    if (e.target.value !== undefined && e.target.value != '') {
                        getEmployee(e.target.value);
                    }
                }
            } else {
                e.preventDefault();
            }
        }

        <?php
        if (isset($_GET['emp_code']) && is_numeric($_GET['emp_code']) && !empty($_GET['emp_code'])) {
            echo 'getEmployee(' . $_GET['emp_code'] . ')';
        }
        ?>

    </script>
<?php include_once("../includes/endTags.php"); ?>