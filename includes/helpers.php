<?php
include_once("web.php");
include_once("mail/index.php");

if (!function_exists('getPageTitle')) {
    function getPageTitle($name)
    {
        $page_titles_array = array(
            'login' => 'ChargeAutomation - Login',
            'profile' => 'Client Profile',
            'tac' => 'Terms & Condations',
            'tacAdd' => 'Add Terms & Condations',
            'upsellOrders' => 'Upsell Orders'
        );
        if (array_key_exists($name, $page_titles_array)) {
            return $page_titles_array[$name];
        } else {
            return 'Site Title';
        }
    }
}

if (!function_exists('getInitialsFromString')) {
    function getInitialsFromString($name, $length = 3)
    {
        $initials = '';
        if (!empty($name)) {
            $exploded_name = explode(" ", $name);
            if (!empty($exploded_name) && is_array($exploded_name) && count($exploded_name) > 0) {
                foreach ($exploded_name as $w) {
                    $initials .= substr($w, 0, 1);
                }
            } else {
                $initials = substr($name, 0, 1);
            }
        }
        return substr($initials, 0, $length);
    }
}

if (!function_exists('getImageNameOrInitials')) {
    function getImageNameOrInitials($data, $image_flag)
    {
        $image_details = null;
        switch ($image_flag) {
            case config('db_const.logos_directory.user.value'):
                $image_details = checkImageExists($data->user_image, $data->name, $image_flag);
                break;
            case config('db_const.logos_directory.company.value'):
                $company = $data->user_account;
                $image_details = checkImageExists($company->company_logo, $company->name, $image_flag);
                break;
            case config('db_const.logos_directory.booking_source.value'):
            case config('db_const.logos_directory.property.value'):
                $image_details = checkImageExists($data->logo, $data->name, $image_flag);
                break;
        }
        return $image_details;
    }
}

if (!function_exists('generatePassword')) {
    function generatePassword($length = 15, $numeric = FALSE, $special = FALSE)
    {
        $alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
        if ($numeric) {
            $alphabet .= '0123456789';
        }
        if ($special) {
            $alphabet .= '%?>+$=-*&_@^#!~<';
        }
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < $length; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }
}

if (!function_exists('getUserImage')) {
    function getUserImage($id)
    {
        global $db, $base_url;
        $img = '';

        //return dirname(__FILE__); //C:\xampp\htdocs\projects\mso_core\includes
        //return dirname(__DIR__); //C:\xampp\htdocs\projects\mso_core
        //return basename(__DIR__); //includes

        //return $upOne = realpath(dirname(__FILE__) . '/..'); //C:\xampp\htdocs\projects\mso_core
        //return $upOne = realpath(__DIR__ . '/..'); //C:\xampp\htdocs\projects\mso_core
        //return $upOne = dirname(__DIR__, 1); //C:\xampp\htdocs\projects\mso_core
        //$upOne = dirname(__DIR__, 1). '/storage/emp_images/1682_G51DDMvsNzY4OG8rtPEQWucWCL5u3TkDAcy.png';

        if (!empty($id) && $id > 0) {
            $sql = mysqli_query($db, "SELECT `name` FROM `employee_images` WHERE `employee_id`='{$id}' AND `deleted_at` IS NULL ORDER BY `id` DESC LIMIT 1 ");
            if (mysqli_num_rows($sql) > 0) {
                $object = mysqli_fetch_object($sql);
                $path = dirname(__DIR__) . '/storage/emp_images/' . $object->name;
                if (realpath($path)) {
                    $image_path = $base_url . 'storage/emp_images/' . $object->name;
                    $img = $object->name;
                    $default = false;
                } else {
                    $sql = mysqli_query($db, "SELECT `gender` FROM `employee_basic_infos` WHERE `employee_id`='{$id}' ORDER BY `id` DESC LIMIT 1 ");
                    $object = mysqli_fetch_object($sql);
                    $image_path = $base_url . 'storage/emp_images/default/' . $object->gender . '.png';
                    $default = true;
                }
            } else {
                $sql = mysqli_query($db, "SELECT `gender` FROM `employee_basic_infos` WHERE `employee_id`='{$id}' ORDER BY `id` DESC LIMIT 1 ");
                $object = mysqli_fetch_object($sql);
                $image_path = $base_url . 'storage/emp_images/default/' . $object->gender . '.png';
                $default = true;
            }
        } else {
            $image_path = $base_url . 'storage/emp_images/default/m.png';
            $default = true;
        }
        return ['image_path' => $image_path, 'img' => $img, 'default' => $default];
    }
}

if (!function_exists('validName')) {
    function validName($value)
    {
        return preg_match("/^[a-zA-Z0-9-.@_&' ]+$/", $value);
    }
}

if (!function_exists('validEmail')) {
    function validEmail($value)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }
}

if (!function_exists('validURL')) {
    function validURL($value)
    {
        return filter_var($value, FILTER_VALIDATE_URL);
    }
}

if (!function_exists('validMobileNumber')) {
    function validMobileNumber($value)
    {
        return preg_match('/^[0-9]{3}-[0-9]{3} [0-9]{4}$/', $value);
    }
}

if (!function_exists('validPhoneNumber')) {
    function validPhoneNumber($value)
    {
        return preg_match('/^[(][0-9]{3}[)] [0-9]{3}-[0-9]{4}$/', $value);
    }
}

if (!function_exists('validAddress')) {
    function validAddress($value)
    {
        return preg_match("/^[a-zA-Z0-9+-._,@&#\/)(’' ]+$/", $value);
    }
}

if (!function_exists('validDate')) {
    function validDate($value)
    {
        return preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/", $value);
    }
}

if (!function_exists('validTime12')) {
    function validTime12($value)
    {
        return preg_match("/^((0[1-9])|(1[0-2])):([0-5][0-9]) (([P][M])|([A][M]))$/", $value);
    }
}

if (!function_exists('validTime24')) {
    function validTime24($value)
    {
        return preg_match("/^([0-1][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/", $value);
    }
}

if (!function_exists('validCNIC')) {
    function validCNIC($value)
    {
        return preg_match('/^[0-9]{5}-[0-9]{7}-[0-9]{1}$/', $value);
    }
}

if (!function_exists('validFamilyCode')) {
    function validFamilyCode($value)
    {
        return preg_match("/^[a-zA-Z0-9]+$/", $value);
    }
}

if (!function_exists('lowerCaseExist')) {
    function lowerCaseExist($value)
    {
        if (preg_match('/[a-z]/', $value)) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('uppercaseExist')) {
    function uppercaseExist($value)
    {
        if (preg_match('/[A-Z]/', $value)) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('numberExist')) {
    function numberExist($value)
    {
        if (preg_match('/[0-9]/', $value)) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('specialCharactersExist')) {
    function specialCharactersExist($value)
    {
        if (preg_match('/[!@#$%^&*]/', $value)) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('getClasses')) {
    function getClasses($link, $page_no, $total_no_of_pages)
    {
        if (in_array($link, ['first', 'prev'])) {
            $p = $link == 'first' ? 1 : $page_no - 1;

            if ($page_no <= 1) {
                return ' class="datatable-pager-link datatable-pager-link-' . $link . ' datatable-pager-link-disabled"';
            } else {
                return ' class="datatable-pager-link datatable-pager-link-' . $link . '" onclick="setPageNo(' . $p . ')"';
            }
        } else if (in_array($link, ['next', 'last'])) {
            $p = $link == 'last' ? $total_no_of_pages : $page_no + 1;

            if ($page_no >= $total_no_of_pages) {
                return ' class="datatable-pager-link datatable-pager-link-' . $link . ' datatable-pager-link-disabled"';
            } else {
                return ' class="datatable-pager-link datatable-pager-link-' . $link . '" onclick="setPageNo(' . $p . ')"';
            }
        }
    }
}

if (!function_exists('getPaginationNumbering')) {
    function getPaginationNumbering($page_no, $total_records_per_page, $total_records, $PageSizeStack)
    {
        $adjacents = "2";
        $total_no_of_pages = ceil($total_records / $total_records_per_page);
        $second_last = $total_no_of_pages - 1;

        $data = '<div class="datatable-pager datatable-paging-loaded">
            <ul class="datatable-pager-nav mb-5 mb-sm-0" id="BG_PagerNumberingHolder">
                <li>
                    <a title="First" href="javascript:;"' . getClasses("first", $page_no, $total_no_of_pages) . '><i class="flaticon2-fast-back"></i></a>
                </li>
                <li>
                    <a title="Previous" href="javascript:;"' . getClasses("prev", $page_no, $total_no_of_pages) . '><i class="flaticon2-back"></i></a>
                </li>
                <li><input type="hidden" readonly class="datatable-pager-input form-control" id="BG_PageNumber" title="Page number" value="' . $page_no . '"></li>';
        if ($total_no_of_pages <= 5) {
            for ($counter = 1; $counter <= $total_no_of_pages; $counter++) {
                if ($counter == $page_no) {
                    $data .= '<li><a href="javascript:;" class="datatable-pager-link datatable-pager-link-number datatable-pager-link-active">' . $counter . '</a></li>';
                } else {
                    $data .= '<li><a href="javascript:;" class="datatable-pager-link datatable-pager-link-number" onclick="setPageNo(' . $counter . ')">' . $counter . '</a></li>';
                }
            }
        } elseif ($total_no_of_pages > 5) {
            if ($page_no <= 3) {
                for ($counter = 1; $counter <= 3; $counter++) {
                    if ($page_no == $counter) {
                        $data .= '<li><a href="javascript:;" class="datatable-pager-link datatable-pager-link-number datatable-pager-link-active">' . $counter . '</a></li>';
                    } else {
                        $data .= '<li><a href="javascript:;" class="datatable-pager-link datatable-pager-link-number" onclick="setPageNo(' . $counter . ')">' . $counter . '</a></li>';
                    }
                }
                $data .= "<li><a>...</a></li>";
                $data .= '<li><a href="javascript:;" class="datatable-pager-link datatable-pager-link-number" onclick="setPageNo(' . $second_last . ')">' . $second_last . '</a></li>';
                $data .= '<li><a href="javascript:;" class="datatable-pager-link datatable-pager-link-number" onclick="setPageNo(' . $total_no_of_pages . ')">' . $total_no_of_pages . '</a></li>';
            } elseif ($page_no >= 4 && $page_no < $total_no_of_pages - 2) {
                $data .= '<li><a href="javascript:;" class="datatable-pager-link datatable-pager-link-number" onclick="setPageNo(1)">1</a></li>';
                $data .= '<li><a href="javascript:;" class="datatable-pager-link datatable-pager-link-number" onclick="setPageNo(2)">2</a></li>';
                $data .= "<li><a>...</a></li>";
                for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {
                    if ($counter != 2) {
                        if ($page_no == $counter) {
                            $data .= '<li><a href="javascript:;" class="datatable-pager-link datatable-pager-link-number datatable-pager-link-active">' . $counter . '</a></li>';
                        } else {
                            $data .= '<li><a href="javascript:;" class="datatable-pager-link datatable-pager-link-number" onclick="setPageNo(' . $counter . ')">' . $counter . '</a></li>';
                        }
                    }
                }
                $data .= "<li><a>...</a></li>";
                $data .= '<li><a href="javascript:;" class="datatable-pager-link datatable-pager-link-number" onclick="setPageNo(' . $second_last . ')">' . $second_last . '</a></li>';
                $data .= '<li><a href="javascript:;" class="datatable-pager-link datatable-pager-link-number" onclick="setPageNo(' . $total_no_of_pages . ')">' . $total_no_of_pages . '</a></li>';
            } else {
                $data .= '<li><a href="javascript:;" class="datatable-pager-link datatable-pager-link-number" onclick="setPageNo(1)">1</a></li>';
                $data .= '<li><a href="javascript:;" class="datatable-pager-link datatable-pager-link-number" onclick="setPageNo(2)">2</a></li>';
                $data .= "<li><a>...</a></li>";
                for ($counter = $total_no_of_pages - 2; $counter <= $total_no_of_pages; $counter++) {
                    if ($page_no == $counter) {
                        $data .= '<li><a href="javascript:;" class="datatable-pager-link datatable-pager-link-number datatable-pager-link-active">' . $counter . '</a></li>';
                    } else {
                        $data .= '<li><a href="javascript:;" class="datatable-pager-link datatable-pager-link-number" onclick="setPageNo(' . $counter . ')">' . $counter . '</a></li>';
                    }
                }
            }
        }
        $data .= '<li>
                    <a title="Next" href="javascript:;"' . getClasses("next", $page_no, $total_no_of_pages) . '><i class="flaticon2-next"></i></a>
                </li>
                <li>
                    <a title="Last" href="javascript:;"' . getClasses("last", $page_no, $total_no_of_pages) . '><i class="flaticon2-fast-next"></i></a>
                </li>
            </ul>
            <div class="datatable-pager-info">
                <div class="dropdown datatable-pager-size" style="width: 60px;">
                <select title="Select page size" onchange="getData()" class="custom-select custom-select-sm form-control form-control-sm" aria-controls="kt_datatable" id="BG_PageSize">';
        foreach ($PageSizeStack as $n) {
            $s = $total_records_per_page == $n ? ' selected="selected"' : '';
            $data .= '<option value="' . $n . '"' . $s . '>' . $n . '</option>';
        }
        $data .= '</select>
                </div>
                <span class="datatable-pager-detail">Showing ' . round(round($page_no * $total_records_per_page) - round($total_records_per_page) + 1) . ' - ';
        $data .= (round($page_no * $total_records_per_page) > $total_records) ? $total_records : round($page_no * $total_records_per_page);
        /*.round($page_no*$total_records_per_page).*/
        $data .= ' of ' . $total_records . '</span>
            </div>
        </div>';
        return $data;
    }
}

if (!function_exists('getStates')) {
    function getStates($country_id, $id)
    {
        global $db;

        $data = '<option selected="selected" value="">Select</option>';
        $select = "SELECT `id`,`state_name` FROM `states` WHERE `country_id`='{$country_id}' ORDER BY `state_name` ASC";
        $query = mysqli_query($db, $select);
        if (mysqli_num_rows($query) > 0) {
            while ($result = mysqli_fetch_object($query)) {
                $selected = '';
                if ($id == $result->id) {
                    $selected = ' selected="selected" ';
                }
                $data .= '<option value="' . $result->id . '"' . $selected . '>' . $result->state_name . '</option>';
            }
        }
        return $data;
    }
}

if (!function_exists('getCities')) {
    function getCities($state_id, $id)
    {
        global $db;

        $data = '<option selected="selected" value="">Select</option>';
        $select = "SELECT `id`,`city_name` FROM `cities` WHERE `state_id`='{$state_id}' ORDER BY `city_name` ASC";
        $query = mysqli_query($db, $select);
        if (mysqli_num_rows($query) > 0) {
            while ($result = mysqli_fetch_object($query)) {
                $selected = '';
                if ($id == $result->id) {
                    $selected = ' selected="selected" ';
                }
                $data .= '<option value="' . $result->id . '"' . $selected . '>' . $result->city_name . '</option>';
            }
        }
        return $data;
    }
}

if (!function_exists('getTeams')) {
    function getTeams($id, $company_id, $branch_id, $employeeId = 0)
    {
        global $db;

        !empty($employeeId) ? $c = " AND `employee_id`='{$employeeId}' " : $c = '';

        $data = '<option selected="selected" value="">Select</option>';
        $select = "SELECT `id`,`name` FROM `teams` WHERE `company_id`='{$company_id}' AND `branch_id`='{$branch_id}' AND `deleted_at` IS NULL " . $c . " ORDER BY `sort_by` ASC";
        $query = mysqli_query($db, $select);
        if (mysqli_num_rows($query) > 0) {
            while ($result = mysqli_fetch_object($query)) {
                $selected = '';
                if ($id == $result->id) {
                    $selected = 'selected="selected"';
                }
                $data .= '<option value="' . $result->id . '"' . $selected . '>' . $result->name . '</option>';
            }
        }
        return $data;
    }
}

if (!function_exists('getDesignations')) {
    function getDesignations($departmentId, $id, $company_id, $branch_id)
    {
        global $db;

        $data = '<option selected="selected" value="">Select</option>';
        $select = "SELECT `id`,`name` FROM `designations` WHERE `company_id`='{$company_id}' AND `branch_id`='{$branch_id}' AND `department_id`='{$departmentId}' AND `deleted_at` IS NULL ORDER BY `sort_by` ASC";
        $query = mysqli_query($db, $select);
        if (mysqli_num_rows($query) > 0) {
            while ($result = mysqli_fetch_object($query)) {
                $selected = '';
                if ($id == $result->id) {
                    $selected = 'selected="selected"';
                }
                $data .= '<option value="' . $result->id . '"' . $selected . '>' . $result->name . '</option>';
            }
        }
        return $data;
    }
}

if (!function_exists('getEmailFooter')) {
    function getEmailFooter()
    {
        global $mail, $base_url;

        //email footer start here
        $path = dirname(__DIR__) . '/assets/custom_assets/images/';
        $f = '<h4 style="color:#222;display:block;font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;font-size:12px;font-weight:600;letter-spacing:0.15px;line-height:18px;margin:25px 0 15px 0;width:100%;">Regards,</h4>';
        $mail->AddEmbeddedImage($path . 'HRISLogo.png', "HRISLogo", "", "base64", "image/jpg/png");
        $f .= '<h3 style="display:block;margin:0;overflow:hidden;width:100%;"><a href="' . $base_url . '"><img src="cid:HRISLogo" alt="Logo"></a></h3>';
        $f .= '<h2 style="color:#777;display:block;font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;font-size:11px;font-weight:300;letter-spacing:0.15px;line-height:18px;margin:10px 0 5px 0;width:100%;">
        This transmission is only for the use of the intended recipient and may contain information that is privileged,
        confidential, secret or otherwise exempt from disclosure under applicable law.
        If you are not the intended recipient you may not copy, distribute, disseminate or otherwise use this transmission or the information it contains in any way.
        If this communication has been transmitted to you in error, please immediately notify the sender and delete this e-mail message from your computer. Thank you</h2>';
        $mail->AddEmbeddedImage($path . 'HRISSignature.png', "HRISSignature", "", "base64", "image/jpg/png");
        $f .= '<h1 style="display:block;margin:0;width:100%;"><img src="cid:HRISSignature" alt="Signature">&nbsp;<span style="color:#99CC00;display: inline-block;font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif;font-size: 11px;font-weight:400;letter-spacing:0.15px;line-height:18px;margin:0;vertical-align:middle;">Please consider your environmental responsibility before printing this email.</span></h1>';
        //email footer end here

        /*
        $mail->addAttachment("file.txt", "File.txt");
        $mail->addAttachment('test.txt');
        $mail->addAttachment("images/profile.png"); //Filename is optional\
        */

        return $f;
    }
}

if (!function_exists('sendEmail')) {
    function sendEmail($parameters)
    {
        global $mail;

        $parameters = (object)$parameters;
        $replyTo = isset($parameters->replyTo) ? $parameters->replyTo : '';
        $mailTo = $parameters->mailTo;
        $mail->addAddress($mailTo['email']);
        $CC = isset($parameters->cc) ? $parameters->cc : '';
        $Bcc = isset($parameters->bcc) ? $parameters->bcc : '';

        $mail->Subject = ucwords(str_replace("_", " ", $parameters->subject));

        if (array_key_exists("name", $mailTo)) {
            $mailToName = $mailTo['name'];
            $mail->addAddress($mailTo['email'], $mailToName);
        }

        if (!empty($replyTo) && is_array($replyTo) && count($replyTo) > 0) {
            if (array_key_exists("name", $replyTo)) {
                $mail->addReplyTo($replyTo['email'], $replyTo['name']);
            } else {
                $mail->addReplyTo($replyTo['email']);
            }
        }

        if (!empty($CC) && is_array($CC) && count($CC) > 0) {
            if (array_key_exists("name", $CC)) {
                $mail->addCC($CC['email'], $CC['name']);
            } else {
                $mail->addCC($CC['email']);
            }
        }

        if (!empty($Bcc) && is_array($Bcc) && count($Bcc) > 0) {
            if (array_key_exists("name", $Bcc)) {
                $mail->addBCC($Bcc['email'], $Bcc['name']);
            } else {
                $mail->addBCC($Bcc['email']);
            }
        }

        $message = $parameters->data['email_body'];
        $message .= getEmailFooter();

        $mail->msgHTML($message);

        try {
            $mail->send();
            return json_encode(["code" => 200, 'successMessage' => $parameters->data['message']]);
        } catch (Exception $e) {
            return json_encode(["code" => 405, 'accessDeniedMessage' => "Error while sending Email. " . $mail->ErrorInfo]);
        }
    }
}

if (!function_exists('reflectTemplate')) {
    function reflectTemplate($html, $array)
    {
        foreach ($array as $template_key => $value) {
            $html = str_replace($template_key, $value, $html);
        }
        return $html;
    }
}

if (!function_exists('getEmployeeInfoFromId')) {
    function getEmployeeInfoFromId($id)
    {
        global $db;
        $branch_id = $_SESSION['branch_id'];

        $select = "SELECT e.company_id, c.name AS company_name, c.status AS company_status, 
        b.id AS branch_id, b.name AS branch_name, b.company_email, b.hr_email, b.other_email,
        CONCAT('+',b.dial_code,' ',b.mobile) AS branch_mobile, b.phone AS branch_phone, b.fax AS branch_fax,
        b.web AS company_web, b.address AS branch_address, b.status AS branch_status, b.type AS branch_type,
        u.id AS user_id, u.email AS user_email, u.status AS user_status, u.type AS user_type, u.email_verified_at,
        e.employee_code, e.status AS employee_status,
        CONCAT(empb.first_name,' ',empb.last_name) AS full_name, empb.*,
        payroll.joining_date, payroll.contract_start_date, payroll.contract_end_date, payroll.leaving_date, payroll.salary,
        e.department_id, dep.name AS department_name, 
        e.team_id, team.name AS team_name,
        e.designation_id, deg.name AS designation_name, 
        e.shift_id, shift.name AS shift_name, shift.from AS shift_from,shift.to AS shift_to,
        e.evaluation_type_id, evaluation_type.name AS evaluation_type_name, evaluation_type.duration AS evaluation_type_duration,
        country.country_name,
        state.state_name,
        time_zone.time_zone,
        city.city_name,
        email_verification.id AS email_verification_detail_id, email_verification.verification_code,email_verification.signed_url
        FROM
            employees AS e
        INNER JOIN 
            companies AS c
            ON c.id = e.company_id
        INNER JOIN 
            branches AS b
            ON c.id = b.company_id
        INNER JOIN 
            employee_basic_infos AS empb
            ON e.id = empb.employee_id
        INNER JOIN 
            departments AS dep
            ON dep.id = e.department_id
        INNER JOIN 
            designations AS deg
            ON deg.id = e.designation_id
        INNER JOIN
            shifts AS shift
            ON shift.id = e.shift_id
        INNER JOIN 
            evaluation_types AS evaluation_type
            ON evaluation_type.id = e.evaluation_type_id
        INNER JOIN 
            countries AS country
            ON country.id = empb.country_id
        INNER JOIN 
            states AS state
            ON state.id = empb.state_id
        INNER JOIN 
            time_zones AS time_zone
            ON time_zone.country_id = empb.country_id
        INNER JOIN 
            cities AS city
            ON city.id = empb.city_id
        INNER JOIN 
            users AS u
            ON u.employee_id = e.id
        LEFT JOIN 
            teams AS team
            ON team.id = e.team_id
        LEFT JOIN 
            employee_payrolls AS payroll
            ON e.id = payroll.employee_id
        LEFT JOIN 
            email_verification_details AS email_verification
            ON u.id = email_verification.user_id
        WHERE e.id='{$id}' AND b.id='{$branch_id}' ORDER BY e.id, email_verification.id DESC LIMIT 1";
        $sql = mysqli_query($db, $select);
        if (mysqli_num_rows($sql) > 0) {
            if ($fetch = mysqli_fetch_object($sql)) {
                unset($fetch->id);
                return $fetch;
            }
        }
    }
}

if (!function_exists('getReporteesEmployees')) {
    function getReporteesEmployees($id)
    {
        global $db;
        $company_id = $_SESSION['company_id'];
        $branch_id = $_SESSION['branch_id'];
        $data = [0];
        $select = "SELECT e.id FROM employees AS e INNER JOIN teams AS t ON e.team_id=t.id WHERE e.id!='{$id}' AND e.company_id='{$company_id}' AND e.branch_id='{$branch_id}' AND e.deleted_at IS NULL AND t.employee_id='{$id}' AND t.company_id='{$company_id}' AND t.branch_id='{$branch_id}' AND t.deleted_at IS NULL";
        $sql = mysqli_query($db, $select);
        if (mysqli_num_rows($sql) > 0) {
            while ($fetch = mysqli_fetch_object($sql)) {
                $data[] = $fetch->id;
            }
            unset($data[0]);
        }
        return $data;
    }
}

if (!function_exists('getSiblings')) {
    function getSiblings($employee_id, $team_id)
    {
        global $db;
        $company_id = $_SESSION['company_id'];
        $branch_id = $_SESSION['branch_id'];
        $data = [0];
        $select = "SELECT e.id FROM employees AS e INNER JOIN teams AS t ON e.team_id=t.id WHERE e.id!='{$employee_id}' AND e.team_id='{$team_id}' AND e.company_id='{$company_id}' AND e.branch_id='{$branch_id}' AND e.deleted_at IS NULL AND t.id='{$team_id}' AND t.company_id='{$company_id}' AND t.branch_id='{$branch_id}' AND t.deleted_at IS NULL";
        $sql = mysqli_query($db, $select);
        if (mysqli_num_rows($sql) > 0) {
            while ($fetch = mysqli_fetch_object($sql)) {
                $data[] = $fetch->id;
            }
            unset($data[0]);
        }
        return $data;
    }
}

if (!function_exists('checkEmployeeActiveOrNot')) {
    function checkEmployeeActiveOrNot($id)
    {
        global $db;

        $working = config('employees.status.value.working');
        $status = mysqli_query($db, "SELECT id FROM employees WHERE id='{$id}' AND status='{$working}' AND deleted_at IS NULL LIMIT 1");
        return mysqli_num_rows($status) > 0 ? true : false;
    }
}

if (!function_exists('getParent')) {
    function getParent($id)
    {
        global $db;
        $employee_id = 0;
        $sql_parent = mysqli_query($db, "SELECT t.employee_id FROM employees AS e INNER JOIN teams AS t ON t.id=e.team_id WHERE e.id='{$id}' LIMIT 1");
        if (mysqli_num_rows($sql_parent) > 0) {
            $fetch_parent = mysqli_fetch_object($sql_parent);
            $employee_id = $fetch_parent->employee_id;
        }
        return $employee_id;
    }
}

if (!function_exists('getReportEmpId')) {
    function getReportEmpId($id)
    {
        global $db;

        $company_id = $_SESSION['company_id'];
        $branch_id = $_SESSION['branch_id'];
        $parent_id = 0;
        $sql_total = mysqli_query($db, "SELECT id FROM teams WHERE company_id='{$company_id}' AND branch_id='{$branch_id}' AND deleted_at IS NULL");
        if ($sql_total && mysqli_num_rows($sql_total) > 0) {
            while ($fetch_total = mysqli_fetch_object($sql_total)) {
                $parent_id = getParent($id);
                if (checkEmployeeActiveOrNot($parent_id)) {
                    break;
                } else {
                    $id = $parent_id;
                }
            }
        }
        return $parent_id;
    }
}

if (!function_exists('getParentInfoFromEmpIdDepartmentBase')) {
    function getParentInfoFromEmpIdDepartmentBase($id)
    {
        global $db;

        $sql_child_designation = mysqli_query($db, "SELECT `department_id`, `designation_id`, `team_id` FROM `employees` WHERE `id`='{$id}' LIMIT 1");
        if (mysqli_num_rows($sql_child_designation) > 0) {
            $fetch_child_designation = mysqli_fetch_object($sql_child_designation);
            $department_id = $fetch_child_designation->department_id;
            $child_team_id = $fetch_child_designation->team_id;
            $designation_id = $fetch_child_designation->designation_id;

            $sql_count_designations = mysqli_query($db, "SELECT COUNT(id) AS total_designations FROM designations WHERE department_id='{$department_id}'");
            if ($sql_count_designations && mysqli_num_rows($sql_count_designations) > 0) {
                $fetch_count_designations = mysqli_fetch_object($sql_count_designations);
                $i = $fetch_count_designations->total_designations < 5 ? 5 : $fetch_count_designations->total_designations;
                $parent_info_array = [];
                for ($i; $i >= 0; $i--) {
                    $sql_parent_designation = mysqli_query($db, "SELECT `report_to_designation_id` FROM `designations` WHERE `id`='{$designation_id}' LIMIT 1");
                    if (mysqli_num_rows($sql_parent_designation) > 0) {
                        $fetch_parent_designation = mysqli_fetch_object($sql_parent_designation);
                        $designation_id = $fetch_parent_designation->report_to_designation_id;
                        if (!empty($designation_id) && $designation_id > 0) {
                            $working = config('employees.status.value.working');

                            $select_parent_info = "SELECT emp.team_id, emp.employee_code, empb.employee_id, empb.first_name, empb.last_name, CONCAT(empb.first_name,' ',empb.last_name) AS full_name, empb.email, empb.official_email
                            FROM
                                employees AS emp
                            INNER JOIN 
                                employee_basic_infos AS empb
                                ON emp.id = empb.employee_id
                            WHERE emp.designation_id='{$designation_id}' AND emp.status='{$working}'";
                            $sql_parent_info = mysqli_query($db, $select_parent_info);

                            if (mysqli_num_rows($sql_parent_info) > 0) {
                                while ($fetch_parent_info = mysqli_fetch_object($sql_parent_info)) {
                                    $team_id = $fetch_parent_info->team_id;
                                    $parent_info_array[$team_id] = $fetch_parent_info;
                                }
                                break;
                            }

                        } else {
                            break;
                        }
                    }
                }
                if (isset($parent_info_array) && sizeof($parent_info_array) == 1) {
                    return $parent_info_array[$team_id];
                } else if (isset($parent_info_array) && sizeof($parent_info_array) > 1) {
                    return $parent_info_array[$child_team_id];
                } else {
                    return $parent_info_array;
                }
            }
        }
    }
}

if (!function_exists('defaultNumberStacks')) {
    function defaultNumberStacks()
    {
        return array(
            'number_stack_is_default' => '1',
            'evaluation_number_stack_id' => '0',
            'total' => '30.00',
            'stack' =>
                [
                    [
                        "gp_name" => "Outstanding",
                        "gp_value" => "30.00",
                        "gp_description" => "Who always performs above his job requirements."
                    ],
                    [
                        "gp_name" => "Superior",
                        "gp_value" => "25.00",
                        "gp_description" => "Who usually performs above the expectation of his job requirements and seldom needs the help of his supervisor/boss."
                    ],
                    [
                        "gp_name" => "Competent",
                        "gp_value" => "20.00",
                        "gp_description" => "Who always perform according to expectations."
                    ],
                    [
                        "gp_name" => "Below Expectation",
                        "gp_value" => "15.00",
                        "gp_description" => "Who perform his job in line with but frequently needs the help/ assistance of his supervisor/boss."
                    ],
                    [
                        "gp_name" => "Unacceptable",
                        "gp_value" => "10.00",
                        "gp_description" => "Who always performs below his job requirements."
                    ],
                ]
        );
    }
}

if (!function_exists('getNumberStacksOfEvaluation')) {
    function getNumberStacksOfEvaluation($company_id, $branch_id, $evaluation_id, $department_id)
    {

        /*$select = "SELECT ev_nsd.gp_id, ev_nsd.gp_name, ev_nsd.gp_value, ev_nsd.gp_description, ev_ns.department_id
        FROM
            evaluation_default_number_stack_details AS ev_nsd
        INNER JOIN
            evaluation_default_number_stacks AS ev_ns
        ON ev_ns.id = ev_nsd.gp_id
        WHERE ev_ns.company_id='{$company_id}' AND ev_ns.branch_id='{$branch_id}'
        AND (ev_ns.department_id='0' OR ev_ns.department_id='{$department_id}')
        AND ev_ns.deleted_at IS NULL ORDER BY ev_ns.department_id, ev_nsd.gp_value ASC";
            $query = mysqli_query($db, $select);
            if (mysqli_num_rows($query) > 0) {
                $stacks_array['number_stack_is_default'] = '1';
                while ($fetch = mysqli_fetch_assoc($query)) {
                    $array[$fetch['department_id']][] = $fetch;
                }
                if (array_key_exists($department_id, $array)) {
                    $stackArray = $array[$department_id];
                } else {
                    $stackArray = $array[0];
                }
                $stacks_array['evaluation_number_stack_id'] = $stackArray[0]['gp_id'];
                $stacks_array['total'] = max(array_column($stackArray, 'gp_value'));
                $stacks_array['stack'] = $stackArray;
            }*/


        global $db;
        $stacks_array = [];

        $select = "SELECT ev_nsd.gp_id, ev_nsd.gp_name, ev_nsd.gp_value, ev_nsd.gp_description
        FROM 
            evaluation_number_stack_details AS ev_nsd
        INNER JOIN
            evaluation_number_stacks AS ev_ns
            ON ev_ns.id = ev_nsd.gp_id
        WHERE ev_ns.evaluation_id='{$evaluation_id}' AND ev_ns.company_id='{$company_id}' AND ev_ns.branch_id='{$branch_id}'
        AND ev_ns.deleted_at IS NULL ORDER BY ev_nsd.gp_value DESC";
        $query = mysqli_query($db, $select);
        if (mysqli_num_rows($query) > 0) {
            $stacks_array['number_stack_is_default'] = '0';
            while ($fetch = mysqli_fetch_assoc($query)) {
                $stacks_array['evaluation_number_stack_id'] = $fetch['gp_id'];
                unset($fetch['gp_id']);
                $stacks[] = $fetch;
            }
            $stacks_array['total'] = max(array_column($stacks, 'gp_value'));
            $stacks_array['stack'] = $stacks;
        } else {
            $select = "SELECT `id` FROM `evaluation_default_number_stacks` WHERE `department_id`='{$department_id}'
            AND company_id='{$company_id}' AND branch_id='{$branch_id}'
            AND deleted_at IS NULL ORDER BY `id` DESC LIMIT 1";
            $query = mysqli_query($db, $select);
            if (mysqli_num_rows($query) > 0) {
                $fetch = mysqli_fetch_object($query);
                $gp_id = $fetch->id;
                $stackArray = [];
                $stacks_array['number_stack_is_default'] = '1';
                $stacks_array['evaluation_number_stack_id'] = $gp_id;

                $select1 = "SELECT `gp_name`,`gp_value`,`gp_description` FROM `evaluation_default_number_stack_details` WHERE `gp_id`='{$gp_id}' ORDER BY `gp_value` DESC";
                $query1 = mysqli_query($db, $select1);
                while ($fetch1 = mysqli_fetch_assoc($query1)) {
                    $stackArray[] = $fetch1;
                }
                $stacks_array['total'] = max(array_column($stackArray, 'gp_value'));
                $stacks_array['stack'] = $stackArray;
            } else {
                $select = "SELECT `id` FROM `evaluation_default_number_stacks` WHERE `department_id`='0'
                AND company_id='{$company_id}' AND branch_id='{$branch_id}'
                AND deleted_at IS NULL ORDER BY `id` DESC LIMIT 1";
                $query = mysqli_query($db, $select);
                if (mysqli_num_rows($query) > 0) {
                    $fetch = mysqli_fetch_object($query);
                    $gp_id = $fetch->id;
                    $stackArray = [];
                    $stacks_array['number_stack_is_default'] = '1';
                    $stacks_array['evaluation_number_stack_id'] = $gp_id;

                    $select1 = "SELECT `gp_name`,`gp_value`,`gp_description` FROM `evaluation_default_number_stack_details` WHERE `gp_id`='{$gp_id}' ORDER BY `gp_value` DESC";
                    $query1 = mysqli_query($db, $select1);
                    while ($fetch1 = mysqli_fetch_assoc($query1)) {
                        $stackArray[] = $fetch1;
                    }
                    $stacks_array['total'] = max(array_column($stackArray, 'gp_value'));
                    $stacks_array['stack'] = $stackArray;
                } else {
                    $stacks_array = defaultNumberStacks();
                }

            }
        }

        return $stacks_array;
    }
}

if (!function_exists('getEvaluationResult')) {
    function getEvaluationResult($evaluation_id, $evaluation_detail_id)
    {
        global $db;
        $evaluation_results = array();

        $select = "SELECT `evaluation_task_detail_id`, `obtaining_number` FROM `evaluation_results` WHERE `evaluation_id`='{$evaluation_id}' AND `evaluation_detail_id`='{$evaluation_detail_id}' ORDER BY `evaluation_task_detail_id` ASC";
        $query = mysqli_query($db, $select);
        if (mysqli_num_rows($query) > 0) {
            while ($fetch = mysqli_fetch_object($query)) {
                $evaluation_results[$fetch->evaluation_task_detail_id] = $fetch->obtaining_number;
            }
        }

        return $evaluation_results;
    }
}

if (!function_exists('getLessThanNumberStacks')) {
    function getLessThanNumberStacks($array, $number = '')
    {
        if ($number == '') {
            $data = $array;
        } else {
            $data = array_filter($array, function ($element) use ($number) {
                return ($element['gp_value'] <= $number);
            });
        }
        return $data;
    }
}

if (!function_exists('getGreaterThanNumberStacks')) {
    function getGreaterThanNumberStacks($array, $number = '')
    {
        if ($number == '') {
            $data = $array;
        } else {
            $data = array_filter($array, function ($element) use ($number) {
                return ($element['gp_value'] >= $number);
            });
        }
        return $data;
    }
}

if (!function_exists('sortMultiDimensionalArrayAscendingByKey')) {
    function sortMultiDimensionalArrayAscendingByKey($array, $k)
    {
        usort($array, function ($a, $b) use ($k) {
            return $a[$k] - $b[$k];
        });
        return $array;
    }
}

if (!function_exists('sortMultiDimensionalArrayDescendingByKey')) {
    function sortMultiDimensionalArrayDescendingByKey($array, $k)
    {
        usort($array, function ($a, $b) use ($k) {
            return $b[$k] - $a[$k];
        });
        return $array;
    }
}

if (!function_exists('getAllAlphabeticChars')) {
    function getAllAlphabeticChars()
    {
        return range('A', 'Z');
    }
}

if (!function_exists('getAlphabetLetterByPosition')) {
    function getAlphabetLetterByPosition($value)
    {
        $value--;
        if ($value <= 26) {
            $alphas = getAllAlphabeticChars();
            return $alphas[$value];
        }
    }
}

if (!function_exists('getRelatedSalaryBands')) {
    function getRelatedSalaryBands($department_id, $id, $company_id, $branch_id)
    {
        global $db;

        $data = '<option selected="selected" value="">Select</option>';
        $select = "SELECT `id`, `name` FROM `salary_grades` WHERE `company_id`='{$company_id}' AND `branch_id`='{$branch_id}' AND `department_id`='{$department_id}' AND `deleted_at` IS NULL ORDER BY `name` ASC";
        $query = mysqli_query($db, $select);
        if (mysqli_num_rows($query) > 0) {
            while ($result = mysqli_fetch_object($query)) {
                $selected = '';
                if ($id == $result->id) {
                    $selected = 'selected="selected"';
                }
                $data .= '<option value="' . $result->id . '"' . $selected . '>' . $result->name . '</option>';
            }
        } else {
            $select = "SELECT `id`, `name` FROM `salary_grades` WHERE `company_id`='{$company_id}' AND `branch_id`='{$branch_id}' AND `department_id`='0' AND `deleted_at` IS NULL ORDER BY `name` ASC";
            $query = mysqli_query($db, $select);
            if (mysqli_num_rows($query) > 0) {
                while ($result = mysqli_fetch_object($query)) {
                    $selected = '';
                    if ($id == $result->id) {
                        $selected = 'selected="selected"';
                    }
                    $data .= '<option value="' . $result->id . '"' . $selected . '>' . $result->name . '</option>';
                }
            }

        }
        return $data;
    }
}

if (!function_exists('getRelatedSalaryGrades')) {
    function getRelatedSalaryGrades($salary_grade_id, $id)
    {
        global $db;

        $data = '<option selected="selected" value="">Select</option>';
        $select = "SELECT `id`, `grade_name` FROM `salary_grade_details` WHERE `salary_grade_id`='{$salary_grade_id}' ORDER BY `id` ASC";
        $query = mysqli_query($db, $select);
        if (mysqli_num_rows($query) > 0) {
            while ($result = mysqli_fetch_object($query)) {
                $selected = '';
                if ($id == $result->id) {
                    $selected = 'selected="selected"';
                }
                $data .= '<option value="' . $result->id . '"' . $selected . '>' . $result->grade_name . '</option>';
            }
        }
        return $data;
    }
}

if (!function_exists('numberToWord')) {
    function numberToWord($number = '')
    {
        $no = round($number);
        $point = round($number - $no, 2) * 100;
        $hundred = null;
        $digits_1 = strlen($no);
        $i = 0;
        $str = array();
        $words = array(
            '0' => '',
            '1' => 'one',
            '2' => 'two',
            '3' => 'three',
            '4' => 'four',
            '5' => 'five',
            '6' => 'six',
            '7' => 'seven',
            '8' => 'eight',
            '9' => 'nine',
            '10' => 'ten',
            '11' => 'eleven',
            '12' => 'twelve',
            '13' => 'thirteen',
            '14' => 'fourteen',
            '15' => 'fifteen',
            '16' => 'sixteen',
            '17' => 'seventeen',
            '18' => 'eighteen',
            '19' => 'nineteen',
            '20' => 'twenty',
            '30' => 'thirty',
            '40' => 'forty',
            '50' => 'fifty',
            '60' => 'sixty',
            '70' => 'seventy',
            '80' => 'eighty',
            '90' => 'ninety'
        );
        $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
        while ($i < $digits_1) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += ($divider == 10) ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str [] = ($number < 21) ? $words[$number] . " " . $digits[$counter] . $plural . " " . $hundred : $words[floor($number / 10) * 10]
                    . " " . $words[$number % 10] . " " . $digits[$counter] . $plural . " " . $hundred;
            } else {
                $str[] = null;
            }
        }
        $str = array_reverse($str);
        $result = implode('', $str);
        $points = ($point) ? "." . $words[$point / 10] . " " . $words[$point = $point % 10] : '';
        return $result;
    }
}

if (!function_exists('insertNotification')) {
    function insertNotification($type, $notify_from_id, $notify_to_employee_id, $model_id, $data, $link, $status, $company_id, $branch_id, $added_by)
    {
        global $db;
        $model = config("notifications.type.model." . $type);

        $insert = "INSERT INTO `notifications`(`id`, `type`, `notify_from_id`, `notify_to_id`, `model_id`, `model`, `data`, `link`, `status`, `company_id`, `branch_id`, `added_by`) VALUES (NULL, '{$type}', '{$notify_from_id}', '{$notify_to_employee_id}', '{$model_id}', '{$model}', '{$data}', '{$link}', '{$status}', '{$company_id}', '{$branch_id}', '{$added_by}')";
        mysqli_query($db, $insert);
        return mysqli_insert_id($db);
    }
}

if (!function_exists('deleteNotification')) {
    function deleteNotification($type, $model_id, $company_id, $branch_id, $notify_from_id = '', $notify_to_id = '')
    {
        global $db;
        $model = config("notifications.type.model." . $type);

        $c = " AND `company_id`='{$company_id}' AND `branch_id`='{$branch_id}'";
        if (isset($notify_from_id) && !empty($notify_from_id)) {
            $c .= " AND `notify_from_id`='{$notify_from_id}'";
        }
        if (isset($notify_to_id) && !empty($notify_to_id)) {
            $c .= " AND `notify_to_id`='{$notify_to_id}'";
        }

        $delete = "DELETE FROM `notifications` WHERE `type`='{$type}' AND `model_id`='{$model_id}'" . $c;
        mysqli_query($db, $delete);
        return mysqli_affected_rows($db);
    }
}

if (!function_exists('getNotification')) {
    function getNotification($id)
    {
        global $db, $admin_url;
        $return = '';
        $unseen_notifications = 0;
        $status_read = config('notifications.status.value.read');

        $chk = mysqli_query($db, "SELECT `id` FROM `notifications` WHERE `notify_to_id`='{$id}' AND `deleted_at` IS NULL ORDER BY `id`");
        $total_notifications = mysqli_num_rows($chk);
        if ($total_notifications > 0) {
            $return .= '<div class="row py-2">
                <div class="col-md-12">
                    <span class="float-right">
                        <a href="">
                            See All (' . $total_notifications . ') <i class="ki ki-long-arrow-next"></i>
                        </a>
                    </span>
                </div>
            </div>';

            $check = mysqli_query($db, "SELECT `id` FROM `notifications` WHERE `notify_to_id`='{$id}' AND `status`!='{$status_read}' AND `deleted_at` IS NULL ORDER BY `id`");
            $unseen_notifications = mysqli_num_rows($check);

            $sql = mysqli_query($db, "SELECT * FROM `notifications` WHERE `notify_to_id`='{$id}' AND `deleted_at` IS NULL ORDER BY `id` DESC LIMIT 0, 15");
            while ($data = mysqli_fetch_object($sql)) {
                //$type = $data->type;
                //$notify_from_id = $data->notify_from_id;
                //$notify_to_id = $data->notify_to_id;
                //$model_id = $data->model_id;

                if ($data->status == $status_read) {
                    if (empty($data->link)) {
                        $radio = '<div class="col-12 mt-3">
                            <div class="font-weight-bold font-size-md">' . $data->data . '</div>
                            <div class="text-muted font-size-sm">' . $data->created_at . '</div>
                        </div>';
                    } else {
                        $radio = '<div class="col-12 mt-3">
                            <a href="' . $data->link . '">
                                <div class="font-weight-bold font-size-md">' . $data->data . '</div>
                            </a>
                            <div class="text-muted font-size-sm">' . $data->created_at . '</div>
                        </div>';
                    }
                } else {

                    if (empty($data->link)) {
                        $radio = '
                    <div class="col-10 mt-1">
                            <div class="font-weight-bold font-size-md">' . $data->data . '</div>
                        <div class="text-muted font-size-sm">' . $data->created_at . '</div>
                    </div>
                    <div class="col-2 text-vertical-align-center">
                        <div class="radio-inline float-right">
                            <label title="Mark as read" class="radio radio-outline radio-outline-2x radio-primary">
                                <input title="Mark as read" type="radio" onclick="readNotification(' . $data->id . ')" checked="checked" value="' . $data->id . '">
                                <span></span>
                            </label>
                        </div>
                    </div>';
                    } else {
                        $radio = '
                    <div class="col-10 mt-3">
                        <a href="' . $data->link . '">
                            <div class="font-weight-bold font-size-md">' . $data->data . '</div>
                        </a>
                        <div class="text-muted font-size-sm">' . $data->created_at . '</div>
                    </div>
                    <div class="col-2 text-vertical-align-center">
                        <div class="radio-inline float-right">
                            <label title="Mark as read" class="radio radio-outline radio-outline-2x radio-primary">
                                <input title="Mark as read" type="radio" onclick="readNotification(' . $data->id . ')" checked="checked" value="' . $data->id . '">
                                <span></span>
                            </label>
                        </div>
                    </div>';
                    }
                }

                $return .= '
                    <div class="row py-3" data-id="' . $data->id . '">
                        <div class="col-md-3">
                            <div class="symbol symbol-60">
                                <div class="symbol-label"><div class="symbol-label" style="background-image:url(' . getUserImage($data->notify_from_id)['image_path'] . ')"></div></div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="row">' . $radio . '</div>
                        </div>
                    </div>';
            }
        } else {
            $return .= '
                <div class="row py-2">
                    <div class="col-md-12">
                       <h6 class="text-danger text-center">There is no notification.</h6>
                    </div>
                </div>';
        }
        return ['total_notifications' => $total_notifications, 'unseen_notifications' => $unseen_notifications, 'list_of_notifications' => $return,];
    }
}

if (!function_exists('getEmployeesTeamWise')) {
    function getEmployeesTeamWise($evaluation_id, $department_id, $designation_id, $company_id, $branch_id)
    {
        global $db;

        $select = "SELECT `t`.`id`,`t`.`name`
        FROM 
            `employees` AS `e`
        LEFT JOIN
            `teams` AS `t`
        ON `e`.`team_id`=`t`.`id`
        WHERE `e`.`department_id`='{$department_id}' AND `e`.`designation_id`='{$designation_id}' AND `e`.`company_id`='{$company_id}' 
        AND `e`.`branch_id`='{$branch_id}' AND `e`.`deleted_at` IS NULL GROUP BY `e`.`team_id` ORDER BY `t`.`sort_by` ASC";
        $query = mysqli_query($db, $select);
        if (mysqli_num_rows($query) > 0) {
            $data = '<div class="separator separator-dashed my-10"></div>
        <div class="mb-3" style="webkit-box-shadow: 0 2px 5px 0 rgba(0,0,0,0.16) !important; box-shadow: 0 2px 5px 0 rgba(0,0,0,0.16) !important;">
            <div class="card-header-of-tree-view">
                <span class="switch switch-success switch-sm switch-icon float-left">
                    <label>
                        <input type="checkbox" id="checkedUncheckedAll" onchange="checkAndUncheck(this.id)">
                        <span></span>
                    </label>
                </span>
                <b>Checked / Unchecked All Employees</b>
            </div>
            <div class="mb-2">
                <div id="Data_Holder_Parent_Div" class="p-0 m-0">
                    <div id="Data_Holder_Child_Div" class="p-0 m-0">
                        <div class="mb-3">
                            <div class="pb-4 pl-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="accordion accordion-light accordion-light-borderless accordion-svg-toggle" id="accordionForCustomTreeView">';
            while ($result = mysqli_fetch_object($query)) {
                $team_id = empty($result->id) ? '0' : $result->id;
                $team_name = empty($result->name) ? 'No Team' : $result->name;
                $data .= '
                <div class="card custom-tree-view my-5">
                    <div class="card-header">
                        <a class="card-title" data-toggle="collapse" aria-controls="collapseTeam_' . $team_id . '" href="#collapseTeam_' . $team_id . '" aria-expanded="false" data-open="true" role="button">
                            <span class="svg-icon svg-icon-primary">
                                <svg width="10px" height="10px" viewBox="0 0 26 26">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                        <path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,
                                        4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,
                                        18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,
                                        17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" fill="#000000" fill-rule="nonzero"></path>
                                        <path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,
                                        14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,
                                        13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,
                                        15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" fill="#000000"
                                        fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999)"></path>
                                    </g>
                                </svg>
                            </span>
                        </a>
                        <div class="card-label parent-card-label-wrapper">
                            <label class="checkbox">
                                <input type="checkbox" id="checkedUncheckedAllChild' . $team_id . '"
                                class="checkedUncheckedAll"
                                onchange="checkAndUncheck(this.id)">
                                <span></span>
                                <b class="ml-2">' . $team_name . '</b>
                            </label>
                        </div>
                    </div>
                    <div id="collapseTeam_' . $team_id . '" class="collapse show">
                        <div class="card-body ml-8 px-5 py-3">
                            <ul role="group" class="jstree-children">';
                $emp_array = [];
                if (isset($evaluation_id) && is_numeric($evaluation_id) && !empty($evaluation_id) && $evaluation_id > 0) {
                    $select_emp_array = "SELECT ed.employee_id 
                FROM
                    evaluation_details AS ed
                INNER JOIN
                    evaluations AS e
                    ON e.id = ed.evaluation_id
                WHERE ed.evaluation_id='{$evaluation_id}' AND e.company_id='{$company_id}' AND e.branch_id='{$branch_id}' AND e.deleted_at IS NULL ORDER BY ed.evaluation_id ASC";
                    $query_emp_array = mysqli_query($db, $select_emp_array);
                    if (mysqli_num_rows($query_emp_array) > 0) {
                        while ($object_emp_array = mysqli_fetch_object($query_emp_array)) {
                            $emp_array[] = $object_emp_array->employee_id;
                        }
                    }
                }

                $select_emp = "SELECT e.employee_code, eb.employee_id, CONCAT(eb.first_name,' ',eb.last_name) AS full_name ,eb.pseudo_name 
            FROM
                employees AS e
            INNER JOIN
                employee_basic_infos AS eb
                ON e.id = eb.employee_id
            WHERE e.department_id='{$department_id}' AND e.designation_id='{$designation_id}' AND e.team_id='{$team_id}' AND e.company_id='{$company_id}' AND e.branch_id='{$branch_id}' AND e.deleted_at IS NULL ORDER BY e.employee_code ASC";

                $query_emp = mysqli_query($db, $select_emp);
                if (mysqli_num_rows($query_emp) > 0) {
                    while ($result_emp = mysqli_fetch_object($query_emp)) {
                        $checked = in_array($result_emp->employee_id, $emp_array) ? ' checked="checked" ' : '';
                        $data .= '<li class="py-2">
                        <div class="d-flex align-items-center my-4">
                            <span class="bullet bullet-bar bg-info  align-self-stretch"></span>
                            <label class="checkbox checkbox-lg checkbox-light-info checkbox-inline flex-shrink-0 m-0 mx-4">
                                <input type="checkbox" ' . $checked . ' class="employeeCheckboxes checkedUncheckedAll checkedUncheckedAllChild' . $team_id . '" data-team_id="' . $team_id . '" value="' . $result_emp->employee_id . '">
                                <span></span>
                            </label>
                            <div class="d-flex flex-column flex-grow-1">
                                <b class="text-dark-75 font-weight-bold font-size-lg mb-1">' . $result_emp->employee_code . ' - ' . $result_emp->full_name;
                        if (!empty($result_emp->pseudo_name)) {
                            $data .= ' <small>(' . $result_emp->pseudo_name . ')</small> ';
                        }
                        $data .= '</b>
                            </div>
                        </div>
                    </li>';
                    }
                }
                $data .= '</ul></div></div></div>';
            }
            $data .= '</div></div></div></div></div></div></div></div></div>';
            $code = 200;
            $toasterClass = 'success';
            $responseMessage = 'Employees list successfully loaded.';
        } else {
            $data = '<div class="separator separator-dashed my-10"></div> <b class="d-block p-5 text-center">There is no employee exist in selected department.</b>';
            $code = 404;
            $toasterClass = 'error';
            $responseMessage = 'There is no employee exist in selected department.';
        }
        return ["code" => $code, "data" => $data, "toasterClass" => $toasterClass, "responseMessage" => $responseMessage];
    }
}

if (!function_exists('numberStackUsed')) {
    function numberStackUsed($id, $is_default)
    {
        global $db;
        $query = mysqli_query($db, "SELECT `id` FROM `evaluation_results` WHERE `evaluation_number_stack_id`='{$id}' AND `number_stack_is_default`='{$is_default}' LIMIT 1");
        return mysqli_num_rows($query) > 0 ? true : false;
    }
}

if (!function_exists('encode')) {
    function encode($string)
    {
        if (!empty($string))
            return base64_encode($string);
    }
}

if (!function_exists('decode')) {
    function decode($string)
    {
        if (!empty($string))
            return base64_decode($string);
    }
}

if (!function_exists('getSuperAdmin')) {
    function getSuperAdmin($company_id, $branch_id)
    {
        global $db;
        $type = config('users.type.value.super_admin');
        $query = mysqli_query($db, "SELECT u.email, CONCAT(eb.first_name,' ',eb.last_name) AS full_name FROM users AS u INNER JOIN employees AS e ON u.employee_id=e.id INNER JOIN employee_basic_infos AS eb ON u.employee_id=eb.employee_id WHERE u.type='{$type}' AND e.company_id='{$company_id}' AND e.branch_id='{$branch_id}' ORDER BY u.id ASC");
        return mysqli_num_rows($query) > 0 ? $query : false;
    }
}

if (!function_exists('getAdmin')) {
    function getAdmin($company_id, $branch_id)
    {
        global $db;
        $type = config('users.type.value.admin');
        $query = mysqli_query($db, "SELECT u.email, CONCAT(eb.first_name,' ',eb.last_name) AS full_name FROM users AS u INNER JOIN employees AS e ON u.employee_id=e.id INNER JOIN employee_basic_infos AS eb ON u.employee_id=eb.employee_id WHERE u.type='{$type}' AND e.company_id='{$company_id}' AND e.branch_id='{$branch_id}' ORDER BY u.id ASC");
        return mysqli_num_rows($query) > 0 ? $query : false;
    }
}

if (!function_exists('getUserRights')) {
    function getUserRights($user_id, $branch_id)
    {
        global $db;
        $company_id = $_SESSION['company_id'];

        $data = [];

        $select = "SELECT * FROM `user_rights` WHERE `user_id` = '{$user_id}' AND `company_id` = '{$company_id}' AND `branch_id` = '{$branch_id}' ORDER BY `id` ASC";
        $query = mysqli_query($db, $select);
        if (mysqli_num_rows($query) > 0) {
            while ($result = mysqli_fetch_object($query)) {
                $right = $result->main_menu_id . '_' . $result->sub_menu_id . '_' . $result->child_menu_id . '_' . $result->action;
                $data[] = $right;
            }
        }

        return $data;
    }
}

if (!function_exists('getAllLinks')) {
    function getAllLinks()
    {
        global $db;

        $m_active = config('main_menus.status.value.active');
        $s_active = config('sub_menus.status.value.active');
        $c_active = config('child_menus.status.value.active');

        $data = [];

        $select = "SELECT c.id, c.user_right_title, c.action, c.sub_menu_id, s.main_menu_id
        FROM
            child_menus AS c
        INNER JOIN
            sub_menus AS s
            ON c.sub_menu_id=s.id
        INNER JOIN
            main_menus AS m
            ON s.main_menu_id=m.id
        WHERE c.user_right_title IS NOT NULL AND  c.user_right_title !=''
        AND m.status = '{$m_active}' AND s.status = '{$s_active}'
        AND c.status = '{$c_active}' AND c.action != ''
        ORDER BY m.sort_by, s.sort_by, c.sort_by";
        $query = mysqli_query($db, $select);
        if (mysqli_num_rows($query) > 0) {
            while ($result = mysqli_fetch_assoc($query)) {
                $n = $result['user_right_title'];
                unset($result['user_right_title']);
                $data[$n][] = $result;
            }
        }

        return $data;
    }
}

if (!function_exists('getUserRightsHTML')) {
    function getUserRightsHTML($user_id, $branch_id)
    {
        global $db;
        $user_rights = getUserRights($user_id, $branch_id);
        $row_number = 0;

        $data = '
        <table class="datatable-table d-block">
            <thead class="datatable-head">
                <tr style="left:0" class="datatable-row">
                    <th class="datatable-cell datatable-cell-left">
                        <div class="float-left" style="width:30%" data-field="name">Name</div>
                        <div class="float-left" style="width:70%" data-field="action">Action</div>
                    </th>
                </tr>
            </thead>
            <tbody class="datatable-body">';
        foreach (getAllLinks() as $key => $v) {
            $row_number++;
            $evenOrOdd = ($row_number % 2) == 1 ? 'odd' : 'even';
            $user_right_title = ucwords(str_replace('_', ' ', $key));

            $data .= '<tr style="left:0" data-row="' . $row_number . '" class="datatable-row datatable-row-' . $evenOrOdd . '">
                <td class="datatable-cell datatable-cell-left py-5">
                    <div class="float-left pt-2 font-weight-bolder" style="width:30%" data-field="name">' . $user_right_title . '</div>
                    <div class="float-left" style="width:70%" data-field="action">';
            foreach ($v as $column) {
                $m_id = $column['main_menu_id'];
                $s_id = $column['sub_menu_id'];
                $c_id = $column['id'];
                $switch_array = ['add' => 'primary', 'edit' => 'success', 'delete' => 'danger', 'view' => 'warning',];
                if (!empty($column['action'])) {
                    $action = json_decode($column['action'], true);
                    foreach ($action as $action_key => $action_value) {
                        $right = $m_id . '_' . $s_id . '_' . $c_id . '_' . $action_key;
                        $checked = in_array($right, $user_rights) ? ' checked="checked" ' : '';
                        $switch_class = array_key_exists($action_key, $switch_array) ? $switch_array[$action_key] : 'primary';

                        $data .= '<div class="form-group float-left overflow-hidden m-0 mr-5">
                        <label class="col-form-label float-left font-weight-bolder mr-1" style="padding: 5px 3px 0 0">
                            ' . $action_value . '
                        </label>
                        <div class="float-left">
                            <span class="switch switch-sm switch-outline switch-icon switch-' . $switch_class . '">
                                <label>
                                    <input type="checkbox" data-main_menu_id="' . $m_id . '" data-sub_menu_id="' . $s_id . '" data-child_menu_id="' . $c_id . '" value="' . $action_key . '" class="rightRepresentativeBox" name="rightRepresentativeBox[]" ' . $checked . '>
                                    <span></span>
                                </label>
                            </span>
                        </div>
                    </div>';
                    }
                }
            }

            $data .= '</div></td></tr>';
        }
        $data .= '</tbody></table>';

        return $data;
    }
}

if (!function_exists('hasRight')) {
    function hasRight($user_right_title, $right)
    {
        global $db;
        $company_id = $_SESSION['company_id'];
        $branch_id = $_SESSION['branch_id'];
        $employee_id = $_SESSION['employee_id'];
        $user_id = $_SESSION['user_id'];
        $employee_info = getEmployeeInfoFromId($employee_id);

        if ($employee_info->user_type != config('users.type.value.super_admin')) {
            $select = "SELECT ur.id
            FROM
                user_rights AS ur
            INNER JOIN 
                child_menus AS cm
                ON ur.child_menu_id=cm.id
            WHERE 
            ur.user_id='{$user_id}' AND ur.company_id='{$company_id}' AND ur.branch_id='{$branch_id}' 
            AND ur.action='{$right}' AND cm.user_right_title='{$user_right_title}' AND cm.user_right_title!=''
            ORDER BY ur.id ASC LIMIT 1";
            $query = mysqli_query($db, $select);
            if (mysqli_num_rows($query) > 0)
                return true;
            else
                return false;
        } else {
            return true;
        }
    }
}

if (!function_exists('getEmployeeCardHTML')) {
    function getEmployeeCardHTML($employee_id)
    {
        global $admin_url, $ct_assets;
        $global_employee_id = $_SESSION['employee_id'];

        $my_info = getEmployeeInfoFromId($global_employee_id);
        $employee_info = getEmployeeInfoFromId($employee_id);

        $card_front_left_bg = $ct_assets . 'images/employee_card/pngs/card-front-left-bg.png';
        $card_back_left_bg = $ct_assets . 'images/employee_card/pngs/card-back-bg.png';

        if (!empty($employee_info) && !empty($my_info) && ($my_info->user_type == config('users.type.value.super_admin') || $my_info->user_type == config('users.type.value.admin') || $my_info->user_type == config('users.type.value.manager'))) {

            $checkImage = getUserImage($employee_info->employee_id);
            $image_path = $checkImage['image_path'];
            $blood_group = !empty($employee_info->blood_group) ? config('employee_basic_infos.blood_group.title.' . $employee_info->blood_group) : '';
            $cell = '+' . $employee_info->dial_code . ' ' . $employee_info->mobile;
            $Emg_cell = !empty($employee_info->other_mobile) ? '+' . $employee_info->o_dial_code . ' ' . $employee_info->other_mobile : '';
            $address = strlen($employee_info->address) > 100 ? substr($employee_info->address, 0, 96) . ' ...' : $employee_info->address;
            $permanent_address = strlen($employee_info->permanent_address) > 100 ? substr($employee_info->permanent_address, 0, 96) . ' ...' : $employee_info->permanent_address;
            $joining_date = !empty($employee_info->joining_date) ? date('d-M-Y', strtotime($employee_info->joining_date)) : '';

            $data = '<div class="employee-card-aside front">
            <div class="employee-card-front-left-side" style="background-image: url(' . $card_front_left_bg . ');">
                <div class="department_name">' . $employee_info->department_name . '</div>
            </div>
            <div class="employee-card-front-right-side">
                <div class="full-line">
                    <div class="employee-card-color-logo">
                        <svg version="1.1" x="0px" y="0px"
	 viewBox="0 0 103.4 31.4" style="enable-background:new 0 0 103.4 31.4;" xml:space="preserve">

<g>
	
		<rect x="35.4" y="14.51" transform="matrix(0.1602 0.9871 -0.9871 0.1602 47.5257 -25.4246)" style="fill:#94BD59;" width="6.6" height="1.42"/>
	
		<rect x="38.81" y="18.43" transform="matrix(0.1602 0.9871 -0.9871 0.1602 51.5972 -23.0076)" style="fill:#94BD59;" width="1.01" height="0.78"/>
	
		<rect x="37.79" y="11.22" transform="matrix(0.1602 0.9871 -0.9871 0.1602 43.5508 -27.8102)" style="fill:#94BD59;" width="0.66" height="0.94"/>
	
		<rect x="37.9" y="20.04" transform="matrix(0.9871 -0.1602 0.1602 0.9871 -2.7414 6.589)" style="fill:#94BD59;" width="3.19" height="0.52"/>
	<rect x="33.77" y="22.15" style="fill:#94BD59;" width="6.84" height="1.11"/>
	<g>
		<path style="fill:#94BD59;" d="M35.09,19.07c0-1.64,1.43-3.01,3.28-3.23l-0.21-1.16c-2.4,0.32-4.25,2.17-4.25,4.39
			c0,1.21,0.55,2.31,1.44,3.12h2.43C36.23,21.77,35.09,20.53,35.09,19.07z"/>
	</g>
</g>
<g>
	<path style="fill:#94BD59;" d="M16.16,25.87v-0.58h0.58v0.58H16.16z M16.16,28.48v-2.29h0.58v2.29H16.16z"/>
	<path style="fill:#94BD59;" d="M19.44,28.48h-0.59v-1.28c0-0.18-0.03-0.32-0.1-0.4c-0.06-0.08-0.15-0.13-0.27-0.13
		c-0.06,0-0.12,0.01-0.18,0.04c-0.06,0.02-0.12,0.06-0.17,0.1c-0.05,0.04-0.1,0.09-0.15,0.15c-0.04,0.06-0.08,0.12-0.1,0.19v1.34
		h-0.58v-2.29h0.53v0.42c0.08-0.15,0.21-0.26,0.37-0.34c0.16-0.08,0.34-0.12,0.54-0.12c0.14,0,0.26,0.03,0.35,0.08
		c0.09,0.05,0.16,0.12,0.21,0.2c0.05,0.08,0.08,0.18,0.1,0.29s0.03,0.22,0.03,0.33V28.48z"/>
	<path style="fill:#94BD59;" d="M22.12,28.48h-0.59v-1.28c0-0.18-0.03-0.32-0.1-0.4c-0.06-0.08-0.15-0.13-0.27-0.13
		c-0.06,0-0.12,0.01-0.18,0.04c-0.06,0.02-0.12,0.06-0.17,0.1c-0.05,0.04-0.1,0.09-0.15,0.15c-0.04,0.06-0.08,0.12-0.1,0.19v1.34
		h-0.58v-2.29h0.53v0.42c0.08-0.15,0.21-0.26,0.37-0.34c0.16-0.08,0.34-0.12,0.54-0.12c0.14,0,0.26,0.03,0.35,0.08
		c0.09,0.05,0.16,0.12,0.21,0.2c0.05,0.08,0.08,0.18,0.1,0.29s0.03,0.22,0.03,0.33V28.48z"/>
	<path style="fill:#94BD59;" d="M23.73,28.52c-0.19,0-0.35-0.03-0.5-0.1c-0.15-0.06-0.27-0.15-0.38-0.26c-0.1-0.11-0.18-0.23-0.24-0.38
		c-0.06-0.14-0.08-0.29-0.08-0.45c0-0.16,0.03-0.31,0.08-0.45c0.05-0.14,0.13-0.27,0.24-0.38c0.1-0.11,0.23-0.2,0.38-0.26
		c0.15-0.06,0.32-0.1,0.5-0.1s0.35,0.03,0.5,0.1c0.15,0.06,0.27,0.15,0.38,0.26c0.1,0.11,0.18,0.24,0.24,0.38
		c0.06,0.14,0.08,0.29,0.08,0.45c0,0.16-0.03,0.31-0.08,0.45c-0.06,0.14-0.13,0.27-0.24,0.38c-0.1,0.11-0.23,0.2-0.38,0.26
		C24.09,28.49,23.92,28.52,23.73,28.52z M23.13,27.34c0,0.1,0.02,0.19,0.05,0.28c0.03,0.08,0.07,0.15,0.13,0.22
		c0.05,0.06,0.12,0.11,0.19,0.14c0.07,0.03,0.15,0.05,0.24,0.05c0.08,0,0.16-0.02,0.24-0.05c0.07-0.03,0.14-0.08,0.19-0.14
		c0.05-0.06,0.1-0.13,0.13-0.22c0.03-0.08,0.05-0.18,0.05-0.28c0-0.1-0.02-0.19-0.05-0.27c-0.03-0.08-0.07-0.16-0.13-0.22
		c-0.05-0.06-0.12-0.11-0.19-0.14c-0.07-0.03-0.15-0.05-0.24-0.05c-0.08,0-0.16,0.02-0.24,0.05c-0.07,0.03-0.14,0.08-0.19,0.14
		c-0.05,0.06-0.1,0.13-0.13,0.22C23.15,27.14,23.13,27.24,23.13,27.34z"/>
	<path style="fill:#94BD59;" d="M25.9,28.48l-0.84-2.29h0.6L26.24,28l0.58-1.81h0.55l-0.84,2.29H25.9z"/>
	<path style="fill:#94BD59;" d="M28.29,28.52c-0.11,0-0.21-0.02-0.31-0.05c-0.1-0.04-0.18-0.09-0.25-0.15c-0.07-0.07-0.12-0.14-0.16-0.23
		c-0.04-0.09-0.06-0.18-0.06-0.29c0-0.11,0.02-0.21,0.07-0.3s0.11-0.17,0.2-0.23c0.09-0.06,0.19-0.11,0.31-0.15
		c0.12-0.04,0.25-0.05,0.39-0.05c0.1,0,0.2,0.01,0.3,0.03c0.1,0.02,0.18,0.04,0.26,0.07v-0.13c0-0.15-0.04-0.27-0.13-0.35
		c-0.09-0.08-0.21-0.12-0.38-0.12c-0.12,0-0.24,0.02-0.36,0.07c-0.12,0.04-0.24,0.11-0.36,0.19l-0.18-0.37
		c0.29-0.2,0.61-0.29,0.95-0.29c0.33,0,0.58,0.08,0.77,0.24c0.18,0.16,0.27,0.4,0.27,0.7v0.71c0,0.06,0.01,0.1,0.03,0.13
		c0.02,0.03,0.06,0.04,0.11,0.04v0.5c-0.1,0.02-0.18,0.03-0.26,0.03c-0.11,0-0.2-0.02-0.26-0.07c-0.06-0.05-0.1-0.12-0.11-0.2
		l-0.01-0.13c-0.1,0.13-0.23,0.24-0.37,0.31C28.61,28.48,28.46,28.52,28.29,28.52z M28.46,28.09c0.1,0,0.19-0.02,0.28-0.05
		c0.09-0.03,0.16-0.08,0.21-0.14c0.06-0.05,0.1-0.1,0.1-0.17v-0.26c-0.07-0.03-0.15-0.05-0.23-0.06c-0.08-0.02-0.16-0.02-0.24-0.02
		c-0.15,0-0.27,0.03-0.37,0.1s-0.14,0.15-0.14,0.26c0,0.1,0.04,0.18,0.11,0.25C28.25,28.06,28.35,28.09,28.46,28.09z"/>
	<path style="fill:#94BD59;" d="M31.57,28.36c-0.08,0.04-0.17,0.07-0.29,0.11c-0.11,0.03-0.23,0.05-0.36,0.05c-0.08,0-0.16-0.01-0.23-0.03
		c-0.07-0.02-0.13-0.05-0.19-0.1c-0.05-0.05-0.1-0.1-0.13-0.17c-0.03-0.07-0.05-0.16-0.05-0.26v-1.31h-0.3v-0.45h0.3v-0.74h0.59
		v0.74h0.48v0.45h-0.48v1.12c0,0.08,0.02,0.14,0.06,0.17c0.04,0.03,0.09,0.05,0.15,0.05c0.06,0,0.12-0.01,0.18-0.03
		c0.06-0.02,0.11-0.04,0.14-0.05L31.57,28.36z"/>
	<path style="fill:#94BD59;" d="M31.92,25.87v-0.58h0.58v0.58H31.92z M31.92,28.48v-2.29h0.58v2.29H31.92z"/>
	<path style="fill:#94BD59;" d="M33.69,28.48l-0.84-2.29h0.6L34.03,28l0.58-1.81h0.55l-0.84,2.29H33.69z"/>
	<path style="fill:#94BD59;" d="M36.5,28.52c-0.18,0-0.35-0.03-0.5-0.09c-0.15-0.06-0.27-0.15-0.38-0.26c-0.1-0.11-0.19-0.23-0.24-0.38
		c-0.06-0.14-0.09-0.29-0.09-0.45c0-0.16,0.03-0.32,0.08-0.46c0.05-0.14,0.14-0.27,0.24-0.38c0.1-0.11,0.23-0.2,0.38-0.26
		c0.15-0.06,0.32-0.1,0.5-0.1c0.19,0,0.35,0.03,0.5,0.1c0.15,0.06,0.27,0.15,0.38,0.26c0.1,0.11,0.18,0.23,0.24,0.38
		c0.05,0.14,0.08,0.29,0.08,0.45c0,0.04,0,0.07,0,0.11c0,0.04-0.01,0.06-0.01,0.09h-1.77c0.01,0.09,0.03,0.17,0.07,0.24
		c0.03,0.07,0.08,0.13,0.14,0.18c0.05,0.05,0.12,0.09,0.19,0.11c0.07,0.03,0.14,0.04,0.22,0.04c0.12,0,0.23-0.03,0.33-0.08
		c0.1-0.06,0.17-0.13,0.21-0.23l0.5,0.14c-0.08,0.17-0.22,0.32-0.4,0.43C36.98,28.46,36.76,28.52,36.5,28.52z M37.1,27.14
		c-0.02-0.17-0.08-0.31-0.19-0.41c-0.11-0.1-0.25-0.16-0.41-0.16c-0.08,0-0.15,0.01-0.22,0.04c-0.07,0.03-0.13,0.07-0.18,0.12
		c-0.05,0.05-0.1,0.11-0.13,0.18c-0.03,0.07-0.05,0.15-0.06,0.23H37.1z"/>
	<path style="fill:#94BD59;" d="M41.32,28.48h-0.59v-1.28c0-0.18-0.03-0.31-0.1-0.4c-0.07-0.09-0.16-0.13-0.28-0.13
		c-0.05,0-0.11,0.01-0.17,0.04c-0.06,0.02-0.11,0.06-0.17,0.1c-0.05,0.04-0.1,0.09-0.14,0.15c-0.04,0.06-0.08,0.12-0.1,0.19v1.34
		h-0.58v-3.19h0.58v1.32c0.08-0.15,0.2-0.26,0.34-0.34c0.14-0.08,0.3-0.12,0.48-0.12c0.15,0,0.27,0.03,0.36,0.08
		c0.09,0.05,0.17,0.12,0.22,0.2s0.09,0.18,0.11,0.29c0.02,0.11,0.03,0.22,0.03,0.33V28.48z"/>
	<path style="fill:#94BD59;" d="M42.93,28.52c-0.18,0-0.35-0.03-0.5-0.09s-0.27-0.15-0.38-0.26c-0.1-0.11-0.19-0.23-0.24-0.38
		c-0.06-0.14-0.09-0.29-0.09-0.45c0-0.16,0.03-0.32,0.08-0.46c0.05-0.14,0.14-0.27,0.24-0.38c0.1-0.11,0.23-0.2,0.38-0.26
		c0.15-0.06,0.32-0.1,0.5-0.1c0.19,0,0.35,0.03,0.5,0.1c0.15,0.06,0.27,0.15,0.38,0.26c0.1,0.11,0.18,0.23,0.24,0.38
		c0.05,0.14,0.08,0.29,0.08,0.45c0,0.04,0,0.07,0,0.11c0,0.04-0.01,0.06-0.01,0.09h-1.77c0.01,0.09,0.03,0.17,0.07,0.24
		c0.03,0.07,0.08,0.13,0.14,0.18c0.05,0.05,0.12,0.09,0.19,0.11c0.07,0.03,0.14,0.04,0.22,0.04c0.12,0,0.23-0.03,0.33-0.08
		c0.1-0.06,0.17-0.13,0.21-0.23l0.5,0.14c-0.08,0.17-0.22,0.32-0.4,0.43C43.41,28.46,43.19,28.52,42.93,28.52z M43.53,27.14
		c-0.02-0.17-0.08-0.31-0.19-0.41c-0.11-0.1-0.25-0.16-0.41-0.16c-0.08,0-0.15,0.01-0.22,0.04c-0.07,0.03-0.13,0.07-0.18,0.12
		c-0.05,0.05-0.1,0.11-0.13,0.18c-0.03,0.07-0.05,0.15-0.06,0.23H43.53z"/>
	<path style="fill:#94BD59;" d="M45.16,28.52c-0.11,0-0.21-0.02-0.31-0.05c-0.1-0.04-0.18-0.09-0.25-0.15c-0.07-0.07-0.12-0.14-0.16-0.23
		c-0.04-0.09-0.06-0.18-0.06-0.29c0-0.11,0.02-0.21,0.07-0.3s0.11-0.17,0.2-0.23c0.09-0.06,0.19-0.11,0.31-0.15
		c0.12-0.04,0.25-0.05,0.39-0.05c0.1,0,0.2,0.01,0.3,0.03c0.1,0.02,0.18,0.04,0.26,0.07v-0.13c0-0.15-0.04-0.27-0.13-0.35
		c-0.09-0.08-0.21-0.12-0.38-0.12c-0.12,0-0.24,0.02-0.36,0.07c-0.12,0.04-0.24,0.11-0.36,0.19l-0.18-0.37
		c0.29-0.2,0.61-0.29,0.95-0.29c0.33,0,0.58,0.08,0.77,0.24c0.18,0.16,0.27,0.4,0.27,0.7v0.71c0,0.06,0.01,0.1,0.03,0.13
		c0.02,0.03,0.06,0.04,0.11,0.04v0.5c-0.1,0.02-0.18,0.03-0.26,0.03c-0.11,0-0.2-0.02-0.26-0.07c-0.06-0.05-0.1-0.12-0.11-0.2
		L46,28.11c-0.1,0.13-0.23,0.24-0.37,0.31C45.48,28.48,45.32,28.52,45.16,28.52z M45.32,28.09c0.1,0,0.19-0.02,0.28-0.05
		c0.09-0.03,0.16-0.08,0.21-0.14c0.06-0.05,0.1-0.1,0.1-0.17v-0.26c-0.07-0.03-0.15-0.05-0.23-0.06c-0.08-0.02-0.16-0.02-0.24-0.02
		c-0.15,0-0.27,0.03-0.37,0.1c-0.1,0.07-0.14,0.15-0.14,0.26c0,0.1,0.04,0.18,0.11,0.25C45.12,28.06,45.21,28.09,45.32,28.09z"/>
	<path style="fill:#94BD59;" d="M47.08,25.29h0.59v2.45c0,0.08,0.02,0.15,0.06,0.2c0.04,0.05,0.1,0.07,0.17,0.07c0.03,0,0.07-0.01,0.12-0.02
		c0.04-0.01,0.08-0.03,0.12-0.04l0.08,0.45c-0.08,0.04-0.17,0.07-0.27,0.09c-0.11,0.02-0.2,0.03-0.28,0.03
		c-0.18,0-0.33-0.05-0.43-0.15c-0.1-0.1-0.15-0.24-0.15-0.42V25.29z"/>
	<path style="fill:#94BD59;" d="M49.88,28.36c-0.08,0.04-0.17,0.07-0.29,0.11c-0.11,0.03-0.23,0.05-0.36,0.05c-0.08,0-0.16-0.01-0.23-0.03
		c-0.07-0.02-0.13-0.05-0.19-0.1c-0.05-0.05-0.1-0.1-0.13-0.17c-0.03-0.07-0.05-0.16-0.05-0.26v-1.31h-0.3v-0.45h0.3v-0.74h0.59
		v0.74h0.48v0.45h-0.48v1.12c0,0.08,0.02,0.14,0.06,0.17c0.04,0.03,0.09,0.05,0.15,0.05c0.06,0,0.12-0.01,0.18-0.03
		c0.06-0.02,0.11-0.04,0.14-0.05L49.88,28.36z"/>
	<path style="fill:#94BD59;" d="M52.36,28.48h-0.59v-1.28c0-0.18-0.03-0.31-0.1-0.4c-0.07-0.09-0.16-0.13-0.28-0.13
		c-0.05,0-0.11,0.01-0.17,0.04c-0.06,0.02-0.11,0.06-0.17,0.1c-0.05,0.04-0.1,0.09-0.14,0.15c-0.04,0.06-0.08,0.12-0.1,0.19v1.34
		h-0.58v-3.19h0.58v1.32c0.08-0.15,0.2-0.26,0.34-0.34c0.14-0.08,0.3-0.12,0.48-0.12c0.15,0,0.27,0.03,0.36,0.08
		c0.09,0.05,0.17,0.12,0.22,0.2s0.09,0.18,0.11,0.29c0.02,0.11,0.03,0.22,0.03,0.33V28.48z"/>
	<path style="fill:#94BD59;" d="M53.86,27.33c0-0.16,0.03-0.31,0.08-0.45c0.05-0.14,0.14-0.27,0.24-0.38c0.1-0.11,0.23-0.19,0.38-0.26
		c0.15-0.06,0.32-0.1,0.5-0.1c0.25,0,0.46,0.05,0.64,0.16s0.31,0.25,0.4,0.42l-0.57,0.17c-0.05-0.08-0.11-0.15-0.2-0.19
		c-0.08-0.05-0.17-0.07-0.27-0.07c-0.08,0-0.16,0.02-0.24,0.05c-0.07,0.03-0.14,0.08-0.19,0.14c-0.05,0.06-0.1,0.13-0.13,0.22
		c-0.03,0.08-0.05,0.18-0.05,0.28s0.02,0.2,0.05,0.28c0.03,0.08,0.08,0.16,0.13,0.22c0.05,0.06,0.12,0.11,0.19,0.14
		c0.07,0.03,0.15,0.05,0.23,0.05c0.1,0,0.2-0.03,0.29-0.08c0.09-0.05,0.15-0.12,0.19-0.19l0.57,0.17c-0.08,0.17-0.21,0.32-0.39,0.43
		c-0.18,0.11-0.4,0.17-0.65,0.17c-0.19,0-0.35-0.03-0.5-0.1c-0.15-0.06-0.27-0.15-0.38-0.26c-0.1-0.11-0.19-0.24-0.24-0.38
		C53.89,27.64,53.86,27.49,53.86,27.33z"/>
	<path style="fill:#94BD59;" d="M57.14,28.52c-0.11,0-0.21-0.02-0.31-0.05c-0.1-0.04-0.18-0.09-0.25-0.15c-0.07-0.07-0.12-0.14-0.16-0.23
		c-0.04-0.09-0.06-0.18-0.06-0.29c0-0.11,0.02-0.21,0.07-0.3c0.05-0.09,0.11-0.17,0.2-0.23c0.09-0.06,0.19-0.11,0.31-0.15
		c0.12-0.04,0.25-0.05,0.39-0.05c0.1,0,0.2,0.01,0.3,0.03c0.1,0.02,0.18,0.04,0.26,0.07v-0.13c0-0.15-0.04-0.27-0.13-0.35
		c-0.09-0.08-0.21-0.12-0.38-0.12c-0.12,0-0.24,0.02-0.36,0.07c-0.12,0.04-0.24,0.11-0.36,0.19l-0.18-0.37
		c0.29-0.2,0.61-0.29,0.95-0.29c0.33,0,0.58,0.08,0.77,0.24c0.18,0.16,0.27,0.4,0.27,0.7v0.71c0,0.06,0.01,0.1,0.03,0.13
		c0.02,0.03,0.06,0.04,0.11,0.04v0.5c-0.1,0.02-0.18,0.03-0.26,0.03c-0.11,0-0.2-0.02-0.26-0.07c-0.06-0.05-0.1-0.12-0.11-0.2
		l-0.01-0.13c-0.1,0.13-0.23,0.24-0.37,0.31C57.46,28.48,57.3,28.52,57.14,28.52z M57.3,28.09c0.1,0,0.19-0.02,0.28-0.05
		c0.09-0.03,0.16-0.08,0.21-0.14c0.06-0.05,0.1-0.1,0.1-0.17v-0.26c-0.07-0.03-0.15-0.05-0.23-0.06c-0.08-0.02-0.16-0.02-0.24-0.02
		c-0.15,0-0.27,0.03-0.37,0.1c-0.1,0.07-0.14,0.15-0.14,0.26c0,0.1,0.04,0.18,0.11,0.25C57.1,28.06,57.19,28.09,57.3,28.09z"/>
	<path style="fill:#94BD59;" d="M60.42,26.69c-0.18,0-0.34,0.04-0.48,0.1c-0.14,0.07-0.24,0.16-0.3,0.29v1.38h-0.58v-2.29h0.54v0.49
		c0.04-0.08,0.09-0.15,0.14-0.21c0.06-0.06,0.11-0.12,0.18-0.16c0.06-0.05,0.13-0.08,0.19-0.11c0.07-0.02,0.13-0.04,0.19-0.04
		c0.03,0,0.06,0,0.07,0s0.03,0,0.05,0V26.69z"/>
	<path style="fill:#94BD59;" d="M61.74,28.52c-0.18,0-0.35-0.03-0.5-0.09c-0.15-0.06-0.27-0.15-0.38-0.26c-0.1-0.11-0.19-0.23-0.24-0.38
		c-0.06-0.14-0.09-0.29-0.09-0.45c0-0.16,0.03-0.32,0.08-0.46c0.05-0.14,0.14-0.27,0.24-0.38c0.1-0.11,0.23-0.2,0.38-0.26
		c0.15-0.06,0.32-0.1,0.5-0.1c0.19,0,0.35,0.03,0.5,0.1c0.15,0.06,0.27,0.15,0.38,0.26c0.1,0.11,0.18,0.23,0.24,0.38
		c0.05,0.14,0.08,0.29,0.08,0.45c0,0.04,0,0.07,0,0.11c0,0.04-0.01,0.06-0.01,0.09h-1.77c0.01,0.09,0.03,0.17,0.07,0.24
		c0.03,0.07,0.08,0.13,0.14,0.18c0.05,0.05,0.12,0.09,0.19,0.11c0.07,0.03,0.14,0.04,0.22,0.04c0.12,0,0.23-0.03,0.33-0.08
		c0.1-0.06,0.17-0.13,0.21-0.23l0.5,0.14c-0.08,0.17-0.22,0.32-0.4,0.43C62.22,28.46,62,28.52,61.74,28.52z M62.34,27.14
		c-0.02-0.17-0.08-0.31-0.19-0.41c-0.11-0.1-0.25-0.16-0.41-0.16c-0.08,0-0.15,0.01-0.22,0.04c-0.07,0.03-0.13,0.07-0.18,0.12
		c-0.05,0.05-0.1,0.11-0.13,0.18c-0.03,0.07-0.05,0.15-0.06,0.23H62.34z"/>
	<path style="fill:#94BD59;" d="M64.43,25.87v-0.58h0.58v0.58H64.43z M64.43,28.48v-2.29h0.58v2.29H64.43z"/>
	<path style="fill:#94BD59;" d="M67.72,28.48h-0.59v-1.28c0-0.18-0.03-0.32-0.1-0.4c-0.06-0.08-0.15-0.13-0.27-0.13
		c-0.06,0-0.12,0.01-0.18,0.04c-0.06,0.02-0.12,0.06-0.17,0.1c-0.05,0.04-0.1,0.09-0.15,0.15c-0.04,0.06-0.08,0.12-0.1,0.19v1.34
		h-0.58v-2.29h0.53v0.42c0.08-0.15,0.21-0.26,0.37-0.34c0.16-0.08,0.34-0.12,0.54-0.12c0.14,0,0.26,0.03,0.35,0.08
		c0.09,0.05,0.16,0.12,0.21,0.2c0.05,0.08,0.08,0.18,0.1,0.29s0.03,0.22,0.03,0.33V28.48z"/>
	<path style="fill:#94BD59;" d="M69.22,28.52c-0.16,0-0.3-0.03-0.44-0.09c-0.13-0.06-0.25-0.15-0.35-0.25c-0.1-0.11-0.17-0.23-0.22-0.38
		c-0.05-0.14-0.08-0.3-0.08-0.47c0-0.17,0.03-0.32,0.08-0.46c0.05-0.14,0.12-0.27,0.21-0.38c0.09-0.11,0.2-0.19,0.32-0.25
		c0.13-0.06,0.26-0.09,0.41-0.09c0.17,0,0.32,0.04,0.46,0.12c0.14,0.08,0.24,0.19,0.32,0.32v-1.3h0.58v2.52
		c0,0.06,0.01,0.1,0.03,0.13c0.02,0.03,0.06,0.04,0.11,0.04v0.5c-0.1,0.02-0.18,0.03-0.25,0.03c-0.11,0-0.19-0.03-0.26-0.08
		c-0.07-0.05-0.1-0.12-0.11-0.2l-0.01-0.14c-0.08,0.15-0.2,0.26-0.34,0.33C69.53,28.48,69.38,28.52,69.22,28.52z M69.37,28.02
		c0.06,0,0.11-0.01,0.17-0.03c0.06-0.02,0.11-0.05,0.16-0.08c0.05-0.04,0.09-0.08,0.13-0.12c0.04-0.05,0.07-0.1,0.09-0.15v-0.55
		c-0.02-0.06-0.06-0.12-0.1-0.18c-0.04-0.05-0.09-0.1-0.14-0.14c-0.05-0.04-0.11-0.07-0.17-0.09c-0.06-0.02-0.12-0.03-0.18-0.03
		c-0.09,0-0.17,0.02-0.24,0.06c-0.07,0.04-0.14,0.09-0.19,0.16c-0.05,0.07-0.09,0.14-0.12,0.22c-0.03,0.08-0.04,0.17-0.04,0.26
		c0,0.1,0.02,0.18,0.05,0.27c0.03,0.08,0.08,0.15,0.13,0.21c0.06,0.06,0.12,0.11,0.2,0.14C69.19,28,69.28,28.02,69.37,28.02z"/>
	<path style="fill:#94BD59;" d="M71.83,28.52c-0.24,0-0.42-0.08-0.54-0.23c-0.12-0.15-0.18-0.38-0.18-0.67v-1.43h0.58v1.31
		c0,0.35,0.13,0.53,0.38,0.53c0.11,0,0.22-0.03,0.33-0.1c0.11-0.07,0.19-0.17,0.26-0.31v-1.42h0.59v1.62c0,0.06,0.01,0.1,0.03,0.13
		c0.02,0.03,0.06,0.04,0.11,0.04v0.5c-0.06,0.01-0.11,0.02-0.15,0.02c-0.04,0-0.08,0-0.11,0c-0.11,0-0.19-0.02-0.26-0.07
		c-0.07-0.05-0.1-0.11-0.12-0.2l-0.01-0.18c-0.1,0.16-0.23,0.28-0.39,0.35C72.2,28.48,72.02,28.52,71.83,28.52z"/>
	<path style="fill:#94BD59;" d="M74.74,28.52c-0.19,0-0.38-0.03-0.56-0.09c-0.18-0.06-0.34-0.15-0.47-0.26l0.22-0.37
		c0.14,0.1,0.28,0.17,0.41,0.23c0.13,0.05,0.26,0.08,0.4,0.08c0.12,0,0.21-0.02,0.28-0.07c0.07-0.04,0.1-0.11,0.1-0.19
		c0-0.08-0.04-0.14-0.12-0.18c-0.08-0.04-0.21-0.08-0.38-0.13c-0.15-0.04-0.27-0.08-0.38-0.12c-0.1-0.04-0.19-0.08-0.25-0.13
		c-0.06-0.05-0.11-0.1-0.14-0.17s-0.04-0.14-0.04-0.23c0-0.12,0.02-0.22,0.07-0.31c0.05-0.09,0.11-0.17,0.19-0.24
		c0.08-0.07,0.18-0.12,0.29-0.15c0.11-0.03,0.23-0.05,0.36-0.05c0.17,0,0.33,0.02,0.48,0.07c0.15,0.05,0.29,0.13,0.41,0.24
		l-0.24,0.35c-0.12-0.09-0.23-0.15-0.34-0.19c-0.11-0.04-0.22-0.06-0.33-0.06c-0.1,0-0.18,0.02-0.25,0.06
		c-0.07,0.04-0.1,0.11-0.1,0.2c0,0.04,0.01,0.07,0.02,0.1c0.02,0.03,0.04,0.05,0.08,0.07c0.04,0.02,0.08,0.04,0.14,0.06
		c0.06,0.02,0.13,0.04,0.21,0.06c0.16,0.04,0.29,0.08,0.4,0.12c0.11,0.04,0.2,0.09,0.27,0.14c0.07,0.05,0.12,0.11,0.16,0.18
		s0.05,0.15,0.05,0.25c0,0.22-0.08,0.4-0.25,0.53C75.25,28.45,75.02,28.52,74.74,28.52z"/>
	<path style="fill:#94BD59;" d="M77.46,28.36c-0.08,0.04-0.17,0.07-0.29,0.11c-0.11,0.03-0.23,0.05-0.36,0.05c-0.08,0-0.16-0.01-0.23-0.03
		c-0.07-0.02-0.13-0.05-0.19-0.1c-0.05-0.05-0.1-0.1-0.13-0.17c-0.03-0.07-0.05-0.16-0.05-0.26v-1.31h-0.3v-0.45h0.3v-0.74h0.59
		v0.74h0.48v0.45H76.8v1.12c0,0.08,0.02,0.14,0.06,0.17c0.04,0.03,0.09,0.05,0.15,0.05c0.06,0,0.12-0.01,0.18-0.03
		c0.06-0.02,0.11-0.04,0.14-0.05L77.46,28.36z"/>
	<path style="fill:#94BD59;" d="M79.17,26.69c-0.18,0-0.34,0.04-0.48,0.1c-0.14,0.07-0.24,0.16-0.3,0.29v1.38h-0.58v-2.29h0.54v0.49
		c0.04-0.08,0.09-0.15,0.14-0.21c0.06-0.06,0.11-0.12,0.18-0.16c0.06-0.05,0.13-0.08,0.19-0.11c0.07-0.02,0.13-0.04,0.19-0.04
		c0.03,0,0.06,0,0.07,0s0.03,0,0.05,0V26.69z"/>
	<path style="fill:#94BD59;" d="M79.59,28.92c0.05,0.01,0.1,0.03,0.14,0.03c0.05,0.01,0.09,0.01,0.12,0.01c0.04,0,0.07-0.01,0.1-0.02
		c0.03-0.01,0.06-0.04,0.09-0.08c0.03-0.04,0.05-0.09,0.08-0.15c0.03-0.06,0.05-0.14,0.08-0.24l-0.9-2.29h0.6l0.62,1.78l0.55-1.78
		h0.55l-0.96,2.74c-0.06,0.16-0.15,0.29-0.28,0.39c-0.13,0.1-0.3,0.15-0.5,0.15c-0.05,0-0.09,0-0.14-0.01
		c-0.05-0.01-0.1-0.02-0.15-0.04V28.92z"/>
	<path style="fill:#94BD59;" d="M83.83,28.52c-0.19,0-0.38-0.03-0.56-0.09c-0.18-0.06-0.34-0.15-0.47-0.26l0.22-0.37
		c0.14,0.1,0.28,0.17,0.41,0.23c0.13,0.05,0.26,0.08,0.4,0.08c0.12,0,0.21-0.02,0.28-0.07c0.07-0.04,0.1-0.11,0.1-0.19
		c0-0.08-0.04-0.14-0.12-0.18c-0.08-0.04-0.21-0.08-0.38-0.13c-0.15-0.04-0.27-0.08-0.38-0.12c-0.1-0.04-0.19-0.08-0.25-0.13
		c-0.06-0.05-0.11-0.1-0.14-0.17s-0.04-0.14-0.04-0.23c0-0.12,0.02-0.22,0.07-0.31c0.05-0.09,0.11-0.17,0.19-0.24
		c0.08-0.07,0.18-0.12,0.29-0.15c0.11-0.03,0.23-0.05,0.36-0.05c0.17,0,0.33,0.02,0.48,0.07c0.15,0.05,0.29,0.13,0.41,0.24
		l-0.24,0.35c-0.12-0.09-0.23-0.15-0.34-0.19c-0.11-0.04-0.22-0.06-0.33-0.06c-0.1,0-0.18,0.02-0.25,0.06
		c-0.07,0.04-0.1,0.11-0.1,0.2c0,0.04,0.01,0.07,0.02,0.1c0.02,0.03,0.04,0.05,0.08,0.07c0.04,0.02,0.08,0.04,0.14,0.06
		c0.06,0.02,0.13,0.04,0.21,0.06c0.16,0.04,0.29,0.08,0.4,0.12c0.11,0.04,0.2,0.09,0.27,0.14c0.07,0.05,0.12,0.11,0.16,0.18
		c0.03,0.07,0.05,0.15,0.05,0.25c0,0.22-0.08,0.4-0.25,0.53C84.34,28.45,84.11,28.52,83.83,28.52z"/>
	<path style="fill:#94BD59;" d="M86.23,28.52c-0.19,0-0.35-0.03-0.5-0.1c-0.15-0.06-0.27-0.15-0.38-0.26c-0.1-0.11-0.18-0.23-0.24-0.38
		c-0.06-0.14-0.08-0.29-0.08-0.45c0-0.16,0.03-0.31,0.08-0.45c0.05-0.14,0.13-0.27,0.24-0.38c0.1-0.11,0.23-0.2,0.38-0.26
		c0.15-0.06,0.32-0.1,0.5-0.1c0.19,0,0.35,0.03,0.5,0.1c0.15,0.06,0.27,0.15,0.38,0.26c0.1,0.11,0.18,0.24,0.24,0.38
		c0.06,0.14,0.08,0.29,0.08,0.45c0,0.16-0.03,0.31-0.08,0.45c-0.06,0.14-0.13,0.27-0.24,0.38c-0.1,0.11-0.23,0.2-0.38,0.26
		C86.59,28.49,86.42,28.52,86.23,28.52z M85.63,27.34c0,0.1,0.02,0.19,0.05,0.28c0.03,0.08,0.07,0.15,0.13,0.22
		c0.05,0.06,0.12,0.11,0.19,0.14c0.07,0.03,0.15,0.05,0.24,0.05c0.08,0,0.16-0.02,0.24-0.05c0.07-0.03,0.14-0.08,0.19-0.14
		c0.05-0.06,0.1-0.13,0.13-0.22c0.03-0.08,0.05-0.18,0.05-0.28c0-0.1-0.02-0.19-0.05-0.27c-0.03-0.08-0.07-0.16-0.13-0.22
		s-0.12-0.11-0.19-0.14c-0.07-0.03-0.15-0.05-0.24-0.05c-0.08,0-0.16,0.02-0.24,0.05c-0.07,0.03-0.14,0.08-0.19,0.14
		c-0.05,0.06-0.1,0.13-0.13,0.22C85.65,27.14,85.63,27.24,85.63,27.34z"/>
	<path style="fill:#94BD59;" d="M87.86,25.29h0.59v2.45c0,0.08,0.02,0.15,0.06,0.2c0.04,0.05,0.1,0.07,0.17,0.07c0.03,0,0.07-0.01,0.12-0.02
		c0.04-0.01,0.08-0.03,0.12-0.04L89,28.39c-0.08,0.04-0.17,0.07-0.27,0.09c-0.11,0.02-0.2,0.03-0.28,0.03
		c-0.18,0-0.33-0.05-0.43-0.15c-0.1-0.1-0.15-0.24-0.15-0.42V25.29z"/>
	<path style="fill:#94BD59;" d="M89.99,28.52c-0.24,0-0.42-0.08-0.54-0.23c-0.12-0.15-0.18-0.38-0.18-0.67v-1.43h0.58v1.31
		c0,0.35,0.13,0.53,0.38,0.53c0.11,0,0.22-0.03,0.33-0.1c0.11-0.07,0.19-0.17,0.26-0.31v-1.42h0.59v1.62c0,0.06,0.01,0.1,0.03,0.13
		c0.02,0.03,0.06,0.04,0.11,0.04v0.5c-0.06,0.01-0.11,0.02-0.15,0.02c-0.04,0-0.08,0-0.11,0c-0.11,0-0.19-0.02-0.26-0.07
		c-0.07-0.05-0.1-0.11-0.12-0.2l-0.01-0.18c-0.1,0.16-0.23,0.28-0.39,0.35C90.36,28.48,90.18,28.52,89.99,28.52z"/>
	<path style="fill:#94BD59;" d="M93.41,28.36c-0.08,0.04-0.17,0.07-0.29,0.11c-0.11,0.03-0.23,0.05-0.36,0.05c-0.08,0-0.16-0.01-0.23-0.03
		c-0.07-0.02-0.13-0.05-0.19-0.1c-0.05-0.05-0.1-0.1-0.13-0.17c-0.03-0.07-0.05-0.16-0.05-0.26v-1.31h-0.3v-0.45h0.3v-0.74h0.59
		v0.74h0.48v0.45h-0.48v1.12c0,0.08,0.02,0.14,0.06,0.17c0.04,0.03,0.09,0.05,0.15,0.05c0.06,0,0.12-0.01,0.18-0.03
		c0.06-0.02,0.11-0.04,0.14-0.05L93.41,28.36z"/>
	<path style="fill:#94BD59;" d="M93.76,25.87v-0.58h0.58v0.58H93.76z M93.76,28.48v-2.29h0.58v2.29H93.76z"/>
	<path style="fill:#94BD59;" d="M95.97,28.52c-0.19,0-0.35-0.03-0.5-0.1c-0.15-0.06-0.27-0.15-0.38-0.26c-0.1-0.11-0.18-0.23-0.24-0.38
		c-0.06-0.14-0.08-0.29-0.08-0.45c0-0.16,0.03-0.31,0.08-0.45c0.05-0.14,0.13-0.27,0.24-0.38c0.1-0.11,0.23-0.2,0.38-0.26
		c0.15-0.06,0.32-0.1,0.5-0.1c0.19,0,0.35,0.03,0.5,0.1c0.15,0.06,0.27,0.15,0.38,0.26c0.1,0.11,0.18,0.24,0.24,0.38
		c0.06,0.14,0.08,0.29,0.08,0.45c0,0.16-0.03,0.31-0.08,0.45c-0.06,0.14-0.13,0.27-0.24,0.38c-0.1,0.11-0.23,0.2-0.38,0.26
		C96.32,28.49,96.16,28.52,95.97,28.52z M95.37,27.34c0,0.1,0.02,0.19,0.05,0.28c0.03,0.08,0.07,0.15,0.13,0.22
		c0.05,0.06,0.12,0.11,0.19,0.14c0.07,0.03,0.15,0.05,0.24,0.05c0.08,0,0.16-0.02,0.24-0.05c0.07-0.03,0.14-0.08,0.19-0.14
		c0.05-0.06,0.1-0.13,0.13-0.22c0.03-0.08,0.05-0.18,0.05-0.28c0-0.1-0.02-0.19-0.05-0.27c-0.03-0.08-0.07-0.16-0.13-0.22
		s-0.12-0.11-0.19-0.14c-0.07-0.03-0.15-0.05-0.24-0.05c-0.08,0-0.16,0.02-0.24,0.05c-0.07,0.03-0.14,0.08-0.19,0.14
		c-0.05,0.06-0.1,0.13-0.13,0.22S95.37,27.24,95.37,27.34z"/>
	<path style="fill:#94BD59;" d="M99.73,28.48h-0.59v-1.28c0-0.18-0.03-0.32-0.1-0.4c-0.06-0.08-0.15-0.13-0.27-0.13
		c-0.06,0-0.12,0.01-0.18,0.04c-0.06,0.02-0.12,0.06-0.17,0.1c-0.05,0.04-0.1,0.09-0.15,0.15c-0.04,0.06-0.08,0.12-0.1,0.19v1.34
		H97.6v-2.29h0.53v0.42c0.08-0.15,0.21-0.26,0.37-0.34c0.16-0.08,0.34-0.12,0.54-0.12c0.14,0,0.26,0.03,0.35,0.08
		c0.09,0.05,0.16,0.12,0.21,0.2c0.05,0.08,0.08,0.18,0.1,0.29s0.03,0.22,0.03,0.33V28.48z"/>
	<path style="fill:#94BD59;" d="M101.15,28.52c-0.19,0-0.38-0.03-0.56-0.09c-0.18-0.06-0.34-0.15-0.47-0.26l0.22-0.37
		c0.14,0.1,0.28,0.17,0.41,0.23c0.13,0.05,0.26,0.08,0.4,0.08c0.12,0,0.21-0.02,0.28-0.07c0.07-0.04,0.1-0.11,0.1-0.19
		c0-0.08-0.04-0.14-0.12-0.18c-0.08-0.04-0.21-0.08-0.38-0.13c-0.15-0.04-0.27-0.08-0.38-0.12c-0.1-0.04-0.19-0.08-0.25-0.13
		c-0.06-0.05-0.11-0.1-0.14-0.17s-0.04-0.14-0.04-0.23c0-0.12,0.02-0.22,0.07-0.31c0.05-0.09,0.11-0.17,0.19-0.24
		c0.08-0.07,0.18-0.12,0.29-0.15c0.11-0.03,0.23-0.05,0.36-0.05c0.17,0,0.33,0.02,0.48,0.07c0.15,0.05,0.29,0.13,0.41,0.24
		l-0.24,0.35c-0.12-0.09-0.23-0.15-0.34-0.19c-0.11-0.04-0.22-0.06-0.33-0.06c-0.1,0-0.18,0.02-0.25,0.06
		c-0.07,0.04-0.1,0.11-0.1,0.2c0,0.04,0.01,0.07,0.02,0.1c0.02,0.03,0.04,0.05,0.08,0.07c0.04,0.02,0.08,0.04,0.14,0.06
		c0.06,0.02,0.13,0.04,0.21,0.06c0.16,0.04,0.29,0.08,0.4,0.12c0.11,0.04,0.2,0.09,0.27,0.14c0.07,0.05,0.12,0.11,0.16,0.18
		s0.05,0.15,0.05,0.25c0,0.22-0.08,0.4-0.25,0.53C101.66,28.45,101.44,28.52,101.15,28.52z"/>
</g>
<path style="fill-rule:evenodd;clip-rule:evenodd;fill:#94BD59;" d="M3.56,8.72h2.22c0,0,0.47-1.21,2.26-2.14l0.2-2.19C8.24,4.39,4.88,4.98,3.56,8.72z"/>
<path style="fill-rule:evenodd;clip-rule:evenodd;fill:#94BD59;" d="M5.13,10.71c-0.03,0.25-0.32,2.76,1.54,4.46c1.3,1.19,2.86,1.27,3.21,1.28c0.98,0.03,1.71-0.24,2.07-0.38
	c1.55-0.6,2.44-1.71,2.83-2.28c0.1,0.08,0.21,0.16,0.31,0.24c-0.29,0.5-0.82,1.29-1.74,1.99c-0.79,0.6-1.51,0.86-1.69,0.93
	c-2.14,0.75-4.1-0.03-4.56-0.22c-1.6-0.68-2.45-1.81-2.67-2.1c-0.76-1.06-1.01-2.11-1.1-2.63c-0.09-0.52-0.09-0.96-0.08-1.28H5.13z"
	/>
<path style="fill-rule:evenodd;clip-rule:evenodd;fill:#94BD59;" d="M12.27,4.79c0,0,2.55,0.95,3.5,4.13h-1.13c0,0-0.47-1.23-1.87-2.04L12.27,4.79z"/>
<g>
	<g>
		<path style="fill:#006F92;" d="M13.36,13.65c0,0-0.01,0-0.01,0c-0.15-0.01-0.29-0.11-0.32-0.26l-1.9-8.03l-0.94,5.15
			c-0.03,0.17-0.2,0.26-0.35,0.28c-0.17-0.01-0.31-0.13-0.33-0.3L9.22,7.69l-0.64,5.63c-0.02,0.15-0.13,0.27-0.28,0.3
			c-0.15,0.02-0.3-0.05-0.37-0.18c-0.05-0.09-1.13-2.47-1.39-3.04c-0.15-0.33-0.46-0.34-0.5-0.33l-3.48,0V9.38h3.46
			C6.3,9.36,6.9,9.49,7.17,10.12c0.13,0.3,0.52,1.06,0.85,1.7l0.85-7.45c0.02-0.17,0.17-0.3,0.34-0.3c0.17,0,0.32,0.13,0.34,0.3
			l0.37,3.46l0.82-4.35c0.03-0.16,0.17-0.27,0.33-0.28c0,0,0.01,0,0.01,0c0.16,0,0.3,0.11,0.33,0.26l1.98,8.37l0.49-1.51
			c0.07-0.26,0.4-0.8,1.14-0.8h1.38v0.69h-1.38c-0.4,0-0.48,0.29-0.48,0.3l-0.87,2.9C13.64,13.56,13.5,13.65,13.36,13.65z"/>
	</g>
	<path style="fill-rule:evenodd;clip-rule:evenodd;fill:#006F92;" d="M2.03,8.97c-0.41,0-0.74,0.33-0.74,0.74s0.33,0.75,0.74,0.75s0.75-0.34,0.75-0.75S2.44,8.97,2.03,8.97z
		 M2.03,10.12c-0.21,0-0.39-0.18-0.39-0.39c0-0.21,0.18-0.39,0.39-0.39c0.21,0,0.39,0.18,0.39,0.39C2.42,9.94,2.24,10.12,2.03,10.12
		z"/>
	<path style="fill-rule:evenodd;clip-rule:evenodd;fill:#006F92;" d="M16.94,9.12c-0.41,0-0.74,0.33-0.74,0.74c0,0.41,0.33,0.75,0.74,0.75c0.41,0,0.75-0.34,0.75-0.75
		C17.7,9.45,17.36,9.12,16.94,9.12z M16.94,10.27c-0.21,0-0.38-0.18-0.38-0.39c0-0.21,0.17-0.39,0.38-0.39
		c0.22,0,0.39,0.18,0.39,0.39C17.34,10.09,17.17,10.27,16.94,10.27z"/>
</g>
<g>
	<path style="fill:#006F92;" d="M19.73,19.41l-2.49-4v6.11c0,0.3-0.26,0.56-0.56,0.56s-0.56-0.26-0.56-0.56v-8.44c0-0.26,0.21-0.47,0.47-0.47
		c0.16,0,0.3,0.08,0.39,0.21l3.59,5.79l3.59-5.79c0.08-0.13,0.22-0.21,0.39-0.21c0.26,0,0.47,0.21,0.47,0.47v8.44
		c0,0.3-0.26,0.56-0.56,0.56s-0.56-0.26-0.56-0.56v-6.11l-2.49,4c-0.18,0.29-0.48,0.48-0.83,0.48
		C20.21,19.89,19.91,19.7,19.73,19.41z"/>
	<path style="fill:#006F92;" d="M32.57,21.54c0,0.27-0.19,0.42-0.5,0.5c-0.43,0.08-1.03,0.14-1.73,0.14c-2.23,0-3.24-1.49-3.24-3.35
		c0-1.85,0.99-3.34,2.98-3.34c1.99,0,2.95,1.27,2.95,2.92c0,0.47-0.37,0.85-0.83,0.85h-4c0.29,1.3,0.74,1.88,2.63,1.88
		c0.24,0,0.74-0.05,1.24-0.1C32.35,21.05,32.57,21.27,32.57,21.54z M31.91,18.22c-0.03-1.36-0.87-1.68-1.85-1.68
		c-1.12,0-1.7,0.56-1.85,1.68H31.91z"/>
	<path style="fill:#006F92;" d="M41.51,18.77c0-2.31,1.88-3.27,3.16-3.27c0.51,0,1.27,0.03,2.02,0.4c0.16,0.08,0.27,0.24,0.27,0.43
		c0,0.27-0.24,0.5-0.51,0.5c-0.08,0-0.13-0.03-0.24-0.06c-0.56-0.19-1.01-0.22-1.33-0.22c-0.87,0-2.25,0.45-2.25,2.21
		c0,1.96,1.41,2.39,2.25,2.39c0.32,0,0.77-0.03,1.33-0.22c0.11-0.03,0.16-0.06,0.24-0.06c0.27,0,0.51,0.22,0.51,0.5
		c0,0.19-0.11,0.35-0.27,0.43c-0.75,0.37-1.51,0.4-2.02,0.4C43.5,22.12,41.51,21.45,41.51,18.77z"/>
	<path style="fill:#006F92;" d="M51.27,15.5c1.97,0,3.14,0.93,3.14,2.63v3.4c0,0.3-0.16,0.56-0.47,0.56c-0.22,0-0.58,0-0.66-0.5l-0.05-0.27
		c-0.72,0.87-2.1,0.87-2.52,0.87h-0.21c-0.3,0-2.02-0.16-2.02-2.09c0-1.04,0.61-1.97,2.42-1.97c0.5,0,1.16,0.03,2.37,0.69v-0.64
		c0-0.95-0.5-1.64-2.66-1.64c-0.24,0-0.61,0.05-0.98,0.1c-0.27,0-0.48-0.21-0.48-0.48c0-0.21,0.14-0.4,0.34-0.47
		C49.89,15.58,50.4,15.5,51.27,15.5z M53.29,19.86c0,0-0.74-0.69-2.01-0.69c-1.43,0-1.67,0.39-1.67,0.98s0.39,0.99,1.67,0.99
		c1.51,0,2.01-0.77,2.01-0.77V19.86z"/>
	<path style="fill:#006F92;" d="M60.31,15.5c0.29,0,0.51,0.22,0.51,0.51s-0.24,0.53-0.53,0.53H60.1c-2.23,0-2.31,2.13-2.31,2.13v2.86
		c0,0.3-0.26,0.56-0.56,0.56c-0.3,0-0.56-0.26-0.56-0.56v-5.37c0-0.3,0.16-0.56,0.47-0.56c0.22,0,0.51,0,0.59,0.53l0.06,0.42
		c0.64-1.04,2.21-1.04,2.41-1.04H60.31z"/>
	<path style="fill:#006F92;" d="M67.25,21.54c0,0.27-0.19,0.42-0.5,0.5c-0.43,0.08-1.03,0.14-1.73,0.14c-2.23,0-3.24-1.49-3.24-3.35
		c0-1.85,0.99-3.34,2.98-3.34c1.99,0,2.95,1.27,2.95,2.92c0,0.47-0.37,0.85-0.83,0.85h-4c0.29,1.3,0.74,1.88,2.63,1.88
		c0.24,0,0.74-0.05,1.24-0.1C67.03,21.05,67.25,21.27,67.25,21.54z M66.6,18.22c-0.03-1.36-0.87-1.68-1.85-1.68
		c-1.12,0-1.7,0.56-1.85,1.68H66.6z"/>
	<path style="fill:#006F92;" d="M76.85,19.41l-2.49-4v6.11c0,0.3-0.26,0.56-0.56,0.56c-0.3,0-0.56-0.26-0.56-0.56v-8.44
		c0-0.26,0.21-0.47,0.47-0.47c0.16,0,0.3,0.08,0.39,0.21l3.59,5.79l3.59-5.79c0.08-0.13,0.22-0.21,0.39-0.21
		c0.26,0,0.47,0.21,0.47,0.47v8.44c0,0.3-0.26,0.56-0.56,0.56c-0.3,0-0.56-0.26-0.56-0.56v-6.11l-2.49,4
		c-0.18,0.29-0.48,0.48-0.83,0.48C77.33,19.89,77.03,19.7,76.85,19.41z"/>
	<path style="fill:#006F92;" d="M90.35,13.27c0,0.27-0.18,0.55-0.45,0.55c-0.67-0.13-1.57-0.22-1.94-0.22c-1.07,0-2.7,0-2.7,1.44
		c0,1.88,6,1.78,6,4.62c0,1.76-1.49,2.53-3.55,2.53c-1.2,0-2.2-0.19-2.84-0.42c-0.19-0.06-0.34-0.26-0.34-0.48
		c0-0.27,0.22-0.51,0.5-0.51c0.03,0,0.06,0,0.11,0.02c0.66,0.16,1.62,0.35,2.5,0.35c1.25,0,2.49-0.29,2.49-1.46c0-1.94-6-1.7-6-4.65
		c0-2.09,1.8-2.49,3.67-2.49c1.07,0,1.73,0.1,2.17,0.22C90.17,12.83,90.35,13.04,90.35,13.27z"/>
	<path style="fill:#006F92;" d="M93.03,17.16c0-3.43,2.49-4.62,4.54-4.62c2.07,0,4.54,1.19,4.54,4.62c0,4.11-2.81,5.02-4.54,5.02
		C95.84,22.19,93.03,21.27,93.03,17.16z M101.01,17.21c0-3.02-1.73-3.63-3.43-3.63c-1.7,0-3.42,0.61-3.42,3.63
		c0,3.48,2.05,3.93,3.42,3.93C98.94,21.14,101.01,20.69,101.01,17.21z"/>
</g>
</svg>
                    </div>
                </div>
            
                <div class="full-line">
                    <div class="employee-card-image-portion">
                    
                        <svg version="1.1" x="0px" y="0px"
	 viewBox="0 0 98.89 100.6" style="enable-background:new 0 0 98.89 100.6;" xml:space="preserve">

<path style="fill-rule:evenodd;clip-rule:evenodd;fill:#F0F4F9;" d="M0,0v100.6h98.89V0H0z M48.73,83.76c-17.95,0-32.51-14.56-32.51-32.52s14.56-32.52,32.51-32.52
	s32.5,14.56,32.5,32.52S66.68,83.76,48.73,83.76z"/>
<path style="fill:#94BD59;" d="M50.88,1.73c-24.02,0-43.52,19.33-43.81,43.29l7.57-1.71c3.55-15.56,17.47-27.17,34.11-27.17
	c19.32,0,34.99,15.67,34.99,35c0,19.32-15.67,34.99-34.99,34.99c-10.24,0-19.45-4.4-25.85-11.4c-0.31,0.45-0.69,0.93-1.19,1.44
	c-0.4,0.41-0.78,0.74-1.14,1.02c7.87,7.54,18.55,12.18,30.31,12.18c24.2,0,43.82-19.62,43.82-43.82
	C94.7,21.35,75.08,1.73,50.88,1.73z"/>
<path style="fill-rule:evenodd;clip-rule:evenodd;fill:#F0F4F9;" d="M14.9,48.79c6.5,0,11.77,5.27,11.77,11.77S21.4,72.32,14.9,72.32c-6.5,0-11.77-5.27-11.77-11.77
	S8.41,48.79,14.9,48.79L14.9,48.79z"/>
<path style="fill-rule:evenodd;clip-rule:evenodd;fill:#94BD59;" d="M7.47,58.46h2.78c0,0,0.59-1.52,2.84-2.68l0.25-2.75C13.33,53.03,9.12,53.77,7.47,58.46z"/>
<path style="fill-rule:evenodd;clip-rule:evenodd;fill:#94BD59;" d="M9.44,60.96c-0.04,0.31-0.4,3.46,1.93,5.59c1.62,1.49,3.59,1.59,4.02,1.61c1.23,0.04,2.15-0.3,2.59-0.48
	c1.94-0.75,3.06-2.14,3.55-2.85c0.13,0.1,0.26,0.2,0.39,0.29c-0.36,0.63-1.03,1.62-2.18,2.49c-0.99,0.75-1.9,1.08-2.12,1.16
	c-2.69,0.94-5.14-0.03-5.71-0.28c-2-0.86-3.07-2.27-3.34-2.64c-0.96-1.32-1.27-2.64-1.38-3.3c-0.11-0.65-0.12-1.2-0.1-1.6H9.44z"/>
<path style="fill-rule:evenodd;clip-rule:evenodd;fill:#94BD59;" d="M18.39,53.53c0,0,3.2,1.19,4.38,5.18h-1.42c0,0-0.59-1.55-2.35-2.56L18.39,53.53z"/>
<g>
	<path style="fill:#006F92;" d="M19.75,64.65c-0.01,0-0.01,0-0.02,0c-0.19-0.01-0.36-0.14-0.4-0.33l-2.38-10.07l-1.18,6.45
		c-0.04,0.21-0.25,0.33-0.44,0.35c-0.21-0.01-0.39-0.17-0.41-0.38l-0.36-3.49l-0.81,7.05c-0.02,0.19-0.16,0.34-0.35,0.37
		c-0.19,0.03-0.37-0.06-0.46-0.22c-0.06-0.11-1.42-3.09-1.74-3.81c-0.18-0.42-0.58-0.42-0.63-0.41l-4.36,0v-0.86h4.34
		c0.35-0.03,1.1,0.14,1.44,0.93c0.17,0.38,0.66,1.33,1.07,2.13l1.07-9.34c0.03-0.22,0.21-0.38,0.43-0.38c0.22,0,0.4,0.16,0.43,0.38
		l0.46,4.34l1.03-5.46c0.04-0.2,0.21-0.34,0.41-0.35c0,0,0.01,0,0.01,0c0.2,0,0.37,0.14,0.42,0.33l2.48,10.49l0.62-1.89
		c0.08-0.33,0.5-1.01,1.43-1.01h1.73v0.86h-1.73c-0.5,0-0.6,0.37-0.6,0.38l-1.09,3.63C20.1,64.53,19.93,64.65,19.75,64.65z"/>
</g>
<path style="fill-rule:evenodd;clip-rule:evenodd;fill:#006F92;" d="M5.55,58.78c-0.52,0-0.93,0.41-0.93,0.93c0,0.52,0.41,0.94,0.93,0.94s0.94-0.43,0.94-0.94
	C6.49,59.19,6.07,58.78,5.55,58.78z M5.55,60.22c-0.27,0-0.49-0.23-0.49-0.49c0-0.27,0.23-0.49,0.49-0.49s0.49,0.23,0.49,0.49
	C6.04,59.99,5.82,60.22,5.55,60.22z"/>
<path style="fill-rule:evenodd;clip-rule:evenodd;fill:#006F92;" d="M24.24,58.97c-0.52,0-0.93,0.41-0.93,0.93c0,0.52,0.41,0.94,0.93,0.94c0.52,0,0.94-0.43,0.94-0.94
	C25.19,59.38,24.76,58.97,24.24,58.97z M24.24,60.4c-0.27,0-0.48-0.23-0.48-0.49c0-0.27,0.21-0.49,0.48-0.49
	c0.28,0,0.49,0.23,0.49,0.49C24.73,60.18,24.52,60.4,24.24,60.4z"/>
</svg>
                        
                        <div class="employee-card-employee-image">
                            <img src="' . $image_path . '">
                        </div>
                    </div>
                </div>
		    
                <div class="full-line">
                    <div class="employee-card-employee-name">' . $employee_info->full_name . '</div>
                </div>
                
                <div class="full-line">
                    <div class="employee-card-employee-designation">' . $employee_info->designation_name . '</div>
                </div>
                
                <div class="full-line"><div class="employee-card-horizontal-line"></div></div>
                
                <div class="full-line text-center">
                    <div class="employee-card-QR-code">
                    <svg version="1.1" x="0px" y="0px"
	 viewBox="0 0 99 98" style="enable-background:new 0 0 99 98;" xml:space="preserve">
<path d="M0.5,98h3.92v-3.92H0.5V98 M4.42,98h3.92v-3.92H4.42V98 M8.34,98h3.92v-3.92H8.34V98 M12.26,98h3.92v-3.92h-3.92V98
	 M16.18,98h3.92v-3.92h-3.92V98 M20.1,98h3.92v-3.92H20.1V98 M24.02,98h3.92v-3.92h-3.92V98 M31.86,98h3.92v-3.92h-3.92V98
	 M35.78,98h3.92v-3.92h-3.92V98 M47.54,98h3.92v-3.92h-3.92V98 M55.38,98h3.92v-3.92h-3.92V98 M67.14,98h3.92v-3.92h-3.92V98
	 M74.98,98h3.92v-3.92h-3.92V98 M78.9,98h3.92v-3.92H78.9V98 M82.82,98h3.92v-3.92h-3.92V98 M86.74,98h3.92v-3.92h-3.92V98
	 M90.66,98h3.92v-3.92h-3.92V98 M94.58,98h3.92v-3.92h-3.92V98 M0.5,94.08h3.92v-3.92H0.5V94.08 M24.02,94.08h3.92v-3.92h-3.92
	V94.08 M31.86,94.08h3.92v-3.92h-3.92V94.08 M47.54,94.08h3.92v-3.92h-3.92V94.08 M51.46,94.08h3.92v-3.92h-3.92V94.08 M59.3,94.08
	h3.92v-3.92H59.3V94.08 M63.22,94.08h3.92v-3.92h-3.92V94.08 M71.06,94.08h3.92v-3.92h-3.92V94.08 M74.98,94.08h3.92v-3.92h-3.92
	V94.08 M78.9,94.08h3.92v-3.92H78.9V94.08 M82.82,94.08h3.92v-3.92h-3.92V94.08 M94.58,94.08h3.92v-3.92h-3.92V94.08 M0.5,90.16
	h3.92v-3.92H0.5V90.16 M8.34,90.16h3.92v-3.92H8.34V90.16 M12.26,90.16h3.92v-3.92h-3.92V90.16 M16.18,90.16h3.92v-3.92h-3.92V90.16
	 M24.02,90.16h3.92v-3.92h-3.92V90.16 M31.86,90.16h3.92v-3.92h-3.92V90.16 M39.7,90.16h3.92v-3.92H39.7V90.16 M51.46,90.16h3.92
	v-3.92h-3.92V90.16 M55.38,90.16h3.92v-3.92h-3.92V90.16 M59.3,90.16h3.92v-3.92H59.3V90.16 M82.82,90.16h3.92v-3.92h-3.92V90.16
	 M86.74,90.16h3.92v-3.92h-3.92V90.16 M94.58,90.16h3.92v-3.92h-3.92V90.16 M0.5,86.24h3.92v-3.92H0.5V86.24 M8.34,86.24h3.92v-3.92
	H8.34V86.24 M12.26,86.24h3.92v-3.92h-3.92V86.24 M16.18,86.24h3.92v-3.92h-3.92V86.24 M24.02,86.24h3.92v-3.92h-3.92V86.24
	 M31.86,86.24h3.92v-3.92h-3.92V86.24 M47.54,86.24h3.92v-3.92h-3.92V86.24 M51.46,86.24h3.92v-3.92h-3.92V86.24 M67.14,86.24h3.92
	v-3.92h-3.92V86.24 M71.06,86.24h3.92v-3.92h-3.92V86.24 M78.9,86.24h3.92v-3.92H78.9V86.24 M82.82,86.24h3.92v-3.92h-3.92V86.24
	 M86.74,86.24h3.92v-3.92h-3.92V86.24 M90.66,86.24h3.92v-3.92h-3.92V86.24 M94.58,86.24h3.92v-3.92h-3.92V86.24 M0.5,82.32h3.92
	V78.4H0.5V82.32 M8.34,82.32h3.92V78.4H8.34V82.32 M12.26,82.32h3.92V78.4h-3.92V82.32 M16.18,82.32h3.92V78.4h-3.92V82.32
	 M24.02,82.32h3.92V78.4h-3.92V82.32 M31.86,82.32h3.92V78.4h-3.92V82.32 M43.62,82.32h3.92V78.4h-3.92V82.32 M59.3,82.32h3.92V78.4
	H59.3V82.32 M63.22,82.32h3.92V78.4h-3.92V82.32 M67.14,82.32h3.92V78.4h-3.92V82.32 M71.06,82.32h3.92V78.4h-3.92V82.32
	 M74.98,82.32h3.92V78.4h-3.92V82.32 M78.9,82.32h3.92V78.4H78.9V82.32 M86.74,82.32h3.92V78.4h-3.92V82.32 M90.66,82.32h3.92V78.4
	h-3.92V82.32 M94.58,82.32h3.92V78.4h-3.92V82.32 M0.5,78.4h3.92v-3.92H0.5V78.4 M24.02,78.4h3.92v-3.92h-3.92V78.4 M39.7,78.4h3.92
	v-3.92H39.7V78.4 M43.62,78.4h3.92v-3.92h-3.92V78.4 M55.38,78.4h3.92v-3.92h-3.92V78.4 M63.22,78.4h3.92v-3.92h-3.92V78.4
	 M78.9,78.4h3.92v-3.92H78.9V78.4 M82.82,78.4h3.92v-3.92h-3.92V78.4 M0.5,74.48h3.92v-3.92H0.5V74.48 M4.42,74.48h3.92v-3.92H4.42
	V74.48 M8.34,74.48h3.92v-3.92H8.34V74.48 M12.26,74.48h3.92v-3.92h-3.92V74.48 M16.18,74.48h3.92v-3.92h-3.92V74.48 M20.1,74.48
	h3.92v-3.92H20.1V74.48 M24.02,74.48h3.92v-3.92h-3.92V74.48 M31.86,74.48h3.92v-3.92h-3.92V74.48 M43.62,74.48h3.92v-3.92h-3.92
	V74.48 M47.54,74.48h3.92v-3.92h-3.92V74.48 M55.38,74.48h3.92v-3.92h-3.92V74.48 M63.22,74.48h3.92v-3.92h-3.92V74.48 M71.06,74.48
	h3.92v-3.92h-3.92V74.48 M78.9,74.48h3.92v-3.92H78.9V74.48 M86.74,74.48h3.92v-3.92h-3.92V74.48 M90.66,74.48h3.92v-3.92h-3.92
	V74.48 M94.58,74.48h3.92v-3.92h-3.92V74.48 M31.86,70.56h3.92v-3.92h-3.92V70.56 M39.7,70.56h3.92v-3.92H39.7V70.56 M51.46,70.56
	h3.92v-3.92h-3.92V70.56 M63.22,70.56h3.92v-3.92h-3.92V70.56 M78.9,70.56h3.92v-3.92H78.9V70.56 M82.82,70.56h3.92v-3.92h-3.92
	V70.56 M0.5,66.64h3.92v-3.92H0.5V66.64 M8.34,66.64h3.92v-3.92H8.34V66.64 M12.26,66.64h3.92v-3.92h-3.92V66.64 M16.18,66.64h3.92
	v-3.92h-3.92V66.64 M20.1,66.64h3.92v-3.92H20.1V66.64 M24.02,66.64h3.92v-3.92h-3.92V66.64 M27.94,66.64h3.92v-3.92h-3.92V66.64
	 M31.86,66.64h3.92v-3.92h-3.92V66.64 M39.7,66.64h3.92v-3.92H39.7V66.64 M47.54,66.64h3.92v-3.92h-3.92V66.64 M51.46,66.64h3.92
	v-3.92h-3.92V66.64 M55.38,66.64h3.92v-3.92h-3.92V66.64 M59.3,66.64h3.92v-3.92H59.3V66.64 M63.22,66.64h3.92v-3.92h-3.92V66.64
	 M67.14,66.64h3.92v-3.92h-3.92V66.64 M71.06,66.64h3.92v-3.92h-3.92V66.64 M74.98,66.64h3.92v-3.92h-3.92V66.64 M78.9,66.64h3.92
	v-3.92H78.9V66.64 M86.74,66.64h3.92v-3.92h-3.92V66.64 M0.5,62.72h3.92V58.8H0.5V62.72 M8.34,62.72h3.92V58.8H8.34V62.72
	 M16.18,62.72h3.92V58.8h-3.92V62.72 M20.1,62.72h3.92V58.8H20.1V62.72 M27.94,62.72h3.92V58.8h-3.92V62.72 M35.78,62.72h3.92V58.8
	h-3.92V62.72 M39.7,62.72h3.92V58.8H39.7V62.72 M47.54,62.72h3.92V58.8h-3.92V62.72 M55.38,62.72h3.92V58.8h-3.92V62.72
	 M71.06,62.72h3.92V58.8h-3.92V62.72 M74.98,62.72h3.92V58.8h-3.92V62.72 M78.9,62.72h3.92V58.8H78.9V62.72 M94.58,62.72h3.92V58.8
	h-3.92V62.72 M0.5,58.8h3.92v-3.92H0.5V58.8 M8.34,58.8h3.92v-3.92H8.34V58.8 M16.18,58.8h3.92v-3.92h-3.92V58.8 M24.02,58.8h3.92
	v-3.92h-3.92V58.8 M31.86,58.8h3.92v-3.92h-3.92V58.8 M51.46,58.8h3.92v-3.92h-3.92V58.8 M55.38,58.8h3.92v-3.92h-3.92V58.8
	 M59.3,58.8h3.92v-3.92H59.3V58.8 M67.14,58.8h3.92v-3.92h-3.92V58.8 M71.06,58.8h3.92v-3.92h-3.92V58.8 M74.98,58.8h3.92v-3.92
	h-3.92V58.8 M78.9,58.8h3.92v-3.92H78.9V58.8 M82.82,58.8h3.92v-3.92h-3.92V58.8 M90.66,58.8h3.92v-3.92h-3.92V58.8 M94.58,58.8
	h3.92v-3.92h-3.92V58.8 M0.5,54.88h3.92v-3.92H0.5V54.88 M4.42,54.88h3.92v-3.92H4.42V54.88 M8.34,54.88h3.92v-3.92H8.34V54.88
	 M12.26,54.88h3.92v-3.92h-3.92V54.88 M20.1,54.88h3.92v-3.92H20.1V54.88 M35.78,54.88h3.92v-3.92h-3.92V54.88 M39.7,54.88h3.92
	v-3.92H39.7V54.88 M47.54,54.88h3.92v-3.92h-3.92V54.88 M51.46,54.88h3.92v-3.92h-3.92V54.88 M63.22,54.88h3.92v-3.92h-3.92V54.88
	 M74.98,54.88h3.92v-3.92h-3.92V54.88 M82.82,54.88h3.92v-3.92h-3.92V54.88 M90.66,54.88h3.92v-3.92h-3.92V54.88 M4.42,50.96h3.92
	v-3.92H4.42V50.96 M8.34,50.96h3.92v-3.92H8.34V50.96 M12.26,50.96h3.92v-3.92h-3.92V50.96 M20.1,50.96h3.92v-3.92H20.1V50.96
	 M24.02,50.96h3.92v-3.92h-3.92V50.96 M27.94,50.96h3.92v-3.92h-3.92V50.96 M31.86,50.96h3.92v-3.92h-3.92V50.96 M35.78,50.96h3.92
	v-3.92h-3.92V50.96 M43.62,50.96h3.92v-3.92h-3.92V50.96 M51.46,50.96h3.92v-3.92h-3.92V50.96 M55.38,50.96h3.92v-3.92h-3.92V50.96
	 M59.3,50.96h3.92v-3.92H59.3V50.96 M67.14,50.96h3.92v-3.92h-3.92V50.96 M71.06,50.96h3.92v-3.92h-3.92V50.96 M78.9,50.96h3.92
	v-3.92H78.9V50.96 M86.74,50.96h3.92v-3.92h-3.92V50.96 M90.66,50.96h3.92v-3.92h-3.92V50.96 M94.58,50.96h3.92v-3.92h-3.92V50.96
	 M4.42,47.04h3.92v-3.92H4.42V47.04 M12.26,47.04h3.92v-3.92h-3.92V47.04 M20.1,47.04h3.92v-3.92H20.1V47.04 M31.86,47.04h3.92
	v-3.92h-3.92V47.04 M35.78,47.04h3.92v-3.92h-3.92V47.04 M39.7,47.04h3.92v-3.92H39.7V47.04 M43.62,47.04h3.92v-3.92h-3.92V47.04
	 M55.38,47.04h3.92v-3.92h-3.92V47.04 M59.3,47.04h3.92v-3.92H59.3V47.04 M63.22,47.04h3.92v-3.92h-3.92V47.04 M67.14,47.04h3.92
	v-3.92h-3.92V47.04 M71.06,47.04h3.92v-3.92h-3.92V47.04 M74.98,47.04h3.92v-3.92h-3.92V47.04 M78.9,47.04h3.92v-3.92H78.9V47.04
	 M94.58,47.04h3.92v-3.92h-3.92V47.04 M12.26,43.12h3.92V39.2h-3.92V43.12 M20.1,43.12h3.92V39.2H20.1V43.12 M24.02,43.12h3.92V39.2
	h-3.92V43.12 M35.78,43.12h3.92V39.2h-3.92V43.12 M43.62,43.12h3.92V39.2h-3.92V43.12 M47.54,43.12h3.92V39.2h-3.92V43.12
	 M51.46,43.12h3.92V39.2h-3.92V43.12 M59.3,43.12h3.92V39.2H59.3V43.12 M63.22,43.12h3.92V39.2h-3.92V43.12 M67.14,43.12h3.92V39.2
	h-3.92V43.12 M71.06,43.12h3.92V39.2h-3.92V43.12 M74.98,43.12h3.92V39.2h-3.92V43.12 M82.82,43.12h3.92V39.2h-3.92V43.12
	 M90.66,43.12h3.92V39.2h-3.92V43.12 M94.58,43.12h3.92V39.2h-3.92V43.12 M0.5,39.2h3.92v-3.92H0.5V39.2 M8.34,39.2h3.92v-3.92H8.34
	V39.2 M12.26,39.2h3.92v-3.92h-3.92V39.2 M16.18,39.2h3.92v-3.92h-3.92V39.2 M31.86,39.2h3.92v-3.92h-3.92V39.2 M35.78,39.2h3.92
	v-3.92h-3.92V39.2 M63.22,39.2h3.92v-3.92h-3.92V39.2 M74.98,39.2h3.92v-3.92h-3.92V39.2 M90.66,39.2h3.92v-3.92h-3.92V39.2
	 M0.5,35.28h3.92v-3.92H0.5V35.28 M4.42,35.28h3.92v-3.92H4.42V35.28 M8.34,35.28h3.92v-3.92H8.34V35.28 M12.26,35.28h3.92v-3.92
	h-3.92V35.28 M16.18,35.28h3.92v-3.92h-3.92V35.28 M24.02,35.28h3.92v-3.92h-3.92V35.28 M27.94,35.28h3.92v-3.92h-3.92V35.28
	 M31.86,35.28h3.92v-3.92h-3.92V35.28 M35.78,35.28h3.92v-3.92h-3.92V35.28 M39.7,35.28h3.92v-3.92H39.7V35.28 M47.54,35.28h3.92
	v-3.92h-3.92V35.28 M51.46,35.28h3.92v-3.92h-3.92V35.28 M55.38,35.28h3.92v-3.92h-3.92V35.28 M67.14,35.28h3.92v-3.92h-3.92V35.28
	 M74.98,35.28h3.92v-3.92h-3.92V35.28 M82.82,35.28h3.92v-3.92h-3.92V35.28 M90.66,35.28h3.92v-3.92h-3.92V35.28 M47.54,31.36h3.92
	v-3.92h-3.92V31.36 M59.3,31.36h3.92v-3.92H59.3V31.36 M63.22,31.36h3.92v-3.92h-3.92V31.36 M0.5,27.44h3.92v-3.92H0.5V27.44
	 M4.42,27.44h3.92v-3.92H4.42V27.44 M8.34,27.44h3.92v-3.92H8.34V27.44 M12.26,27.44h3.92v-3.92h-3.92V27.44 M16.18,27.44h3.92
	v-3.92h-3.92V27.44 M20.1,27.44h3.92v-3.92H20.1V27.44 M24.02,27.44h3.92v-3.92h-3.92V27.44 M31.86,27.44h3.92v-3.92h-3.92V27.44
	 M39.7,27.44h3.92v-3.92H39.7V27.44 M47.54,27.44h3.92v-3.92h-3.92V27.44 M55.38,27.44h3.92v-3.92h-3.92V27.44 M63.22,27.44h3.92
	v-3.92h-3.92V27.44 M71.06,27.44h3.92v-3.92h-3.92V27.44 M74.98,27.44h3.92v-3.92h-3.92V27.44 M78.9,27.44h3.92v-3.92H78.9V27.44
	 M82.82,27.44h3.92v-3.92h-3.92V27.44 M86.74,27.44h3.92v-3.92h-3.92V27.44 M90.66,27.44h3.92v-3.92h-3.92V27.44 M94.58,27.44h3.92
	v-3.92h-3.92V27.44 M0.5,23.52h3.92V19.6H0.5V23.52 M24.02,23.52h3.92V19.6h-3.92V23.52 M31.86,23.52h3.92V19.6h-3.92V23.52
	 M39.7,23.52h3.92V19.6H39.7V23.52 M51.46,23.52h3.92V19.6h-3.92V23.52 M55.38,23.52h3.92V19.6h-3.92V23.52 M59.3,23.52h3.92V19.6
	H59.3V23.52 M63.22,23.52h3.92V19.6h-3.92V23.52 M71.06,23.52h3.92V19.6h-3.92V23.52 M94.58,23.52h3.92V19.6h-3.92V23.52 M0.5,19.6
	h3.92v-3.92H0.5V19.6 M8.34,19.6h3.92v-3.92H8.34V19.6 M12.26,19.6h3.92v-3.92h-3.92V19.6 M16.18,19.6h3.92v-3.92h-3.92V19.6
	 M24.02,19.6h3.92v-3.92h-3.92V19.6 M39.7,19.6h3.92v-3.92H39.7V19.6 M47.54,19.6h3.92v-3.92h-3.92V19.6 M51.46,19.6h3.92v-3.92
	h-3.92V19.6 M63.22,19.6h3.92v-3.92h-3.92V19.6 M71.06,19.6h3.92v-3.92h-3.92V19.6 M78.9,19.6h3.92v-3.92H78.9V19.6 M82.82,19.6
	h3.92v-3.92h-3.92V19.6 M86.74,19.6h3.92v-3.92h-3.92V19.6 M94.58,19.6h3.92v-3.92h-3.92V19.6 M0.5,15.68h3.92v-3.92H0.5V15.68
	 M8.34,15.68h3.92v-3.92H8.34V15.68 M12.26,15.68h3.92v-3.92h-3.92V15.68 M16.18,15.68h3.92v-3.92h-3.92V15.68 M24.02,15.68h3.92
	v-3.92h-3.92V15.68 M31.86,15.68h3.92v-3.92h-3.92V15.68 M35.78,15.68h3.92v-3.92h-3.92V15.68 M43.62,15.68h3.92v-3.92h-3.92V15.68
	 M51.46,15.68h3.92v-3.92h-3.92V15.68 M59.3,15.68h3.92v-3.92H59.3V15.68 M63.22,15.68h3.92v-3.92h-3.92V15.68 M71.06,15.68h3.92
	v-3.92h-3.92V15.68 M78.9,15.68h3.92v-3.92H78.9V15.68 M82.82,15.68h3.92v-3.92h-3.92V15.68 M86.74,15.68h3.92v-3.92h-3.92V15.68
	 M94.58,15.68h3.92v-3.92h-3.92V15.68 M0.5,11.76h3.92V7.84H0.5V11.76 M8.34,11.76h3.92V7.84H8.34V11.76 M12.26,11.76h3.92V7.84
	h-3.92V11.76 M16.18,11.76h3.92V7.84h-3.92V11.76 M24.02,11.76h3.92V7.84h-3.92V11.76 M35.78,11.76h3.92V7.84h-3.92V11.76
	 M39.7,11.76h3.92V7.84H39.7V11.76 M43.62,11.76h3.92V7.84h-3.92V11.76 M55.38,11.76h3.92V7.84h-3.92V11.76 M71.06,11.76h3.92V7.84
	h-3.92V11.76 M78.9,11.76h3.92V7.84H78.9V11.76 M82.82,11.76h3.92V7.84h-3.92V11.76 M86.74,11.76h3.92V7.84h-3.92V11.76
	 M94.58,11.76h3.92V7.84h-3.92V11.76 M0.5,7.84h3.92V3.92H0.5V7.84 M24.02,7.84h3.92V3.92h-3.92V7.84 M31.86,7.84h3.92V3.92h-3.92
	V7.84 M35.78,7.84h3.92V3.92h-3.92V7.84 M43.62,7.84h3.92V3.92h-3.92V7.84 M47.54,7.84h3.92V3.92h-3.92V7.84 M51.46,7.84h3.92V3.92
	h-3.92V7.84 M55.38,7.84h3.92V3.92h-3.92V7.84 M59.3,7.84h3.92V3.92H59.3V7.84 M63.22,7.84h3.92V3.92h-3.92V7.84 M71.06,7.84h3.92
	V3.92h-3.92V7.84 M94.58,7.84h3.92V3.92h-3.92V7.84 M0.5,3.92h3.92V0H0.5V3.92 M4.42,3.92h3.92V0H4.42V3.92 M8.34,3.92h3.92V0H8.34
	V3.92 M12.26,3.92h3.92V0h-3.92V3.92 M16.18,3.92h3.92V0h-3.92V3.92 M20.1,3.92h3.92V0H20.1V3.92 M24.02,3.92h3.92V0h-3.92V3.92
	 M35.78,3.92h3.92V0h-3.92V3.92 M51.46,3.92h3.92V0h-3.92V3.92 M63.22,3.92h3.92V0h-3.92V3.92 M71.06,3.92h3.92V0h-3.92V3.92
	 M74.98,3.92h3.92V0h-3.92V3.92 M78.9,3.92h3.92V0H78.9V3.92 M82.82,3.92h3.92V0h-3.92V3.92 M86.74,3.92h3.92V0h-3.92V3.92
	 M90.66,3.92h3.92V0h-3.92V3.92 M94.58,3.92h3.92V0h-3.92V3.92L94.58,3.92z"/>
</svg>
                    
                    
                    
                    </div>
                </div>
    
                <div class="full-line">
                    <div class="employee-card-employee-code">ID NO: ' . $employee_info->employee_code . '</div>
                </div>
            </div>
        </div>
        
        <div class="employee-card-aside back" style="background-image: url(' . $card_back_left_bg . ')">
            <div class="full-line">
                <div class="employee-card-white-logo">
                <svg version="1.1" x="0px" y="0px"
	 viewBox="0 0 96.69 25.51" style="enable-background:new 0 0 96.69 25.51;" xml:space="preserve">
<g>
	<g>
		
			<rect x="33" y="11.44" transform="matrix(0.1602 0.9871 -0.9871 0.1602 42.2868 -25.4827)" style="fill:#FFFFFF;" width="6.23" height="1.34"/>
		
			<rect x="36.22" y="15.14" transform="matrix(0.1602 0.9871 -0.9871 0.1602 46.1279 -23.2025)" style="fill:#FFFFFF;" width="0.95" height="0.74"/>
		
			<rect x="35.26" y="8.34" transform="matrix(0.1602 0.9871 -0.9871 0.1602 38.5367 -27.7334)" style="fill:#FFFFFF;" width="0.62" height="0.89"/>
		
			<rect x="35.36" y="16.66" transform="matrix(0.9871 -0.1602 0.1602 0.9871 -2.2315 6.1238)" style="fill:#FFFFFF;" width="3.01" height="0.49"/>
		<rect x="31.46" y="18.65" style="fill:#FFFFFF;" width="6.45" height="1.05"/>
		<g>
			<path style="fill:#FFFFFF;" d="M32.71,15.74c0-1.55,1.35-2.84,3.1-3.05l-0.2-1.1c-2.27,0.3-4.01,2.04-4.01,4.14c0,1.14,0.52,2.18,1.36,2.94
				h2.29C33.78,18.29,32.71,17.12,32.71,15.74z"/>
		</g>
	</g>
	<g>
		<path style="fill:#FFFFFF;" d="M14.85,22.16v-0.55h0.55v0.55H14.85z M14.85,24.62v-2.16h0.55v2.16H14.85z"/>
		<path style="fill:#FFFFFF;" d="M17.94,24.62h-0.55v-1.21c0-0.17-0.03-0.3-0.09-0.38c-0.06-0.08-0.14-0.12-0.25-0.12
			c-0.06,0-0.11,0.01-0.17,0.03s-0.11,0.05-0.16,0.09c-0.05,0.04-0.1,0.09-0.14,0.14c-0.04,0.05-0.07,0.12-0.09,0.18v1.26h-0.55
			v-2.16h0.5v0.4c0.08-0.14,0.19-0.24,0.35-0.32c0.15-0.08,0.32-0.12,0.51-0.12c0.13,0,0.24,0.02,0.33,0.07
			c0.08,0.05,0.15,0.11,0.2,0.19c0.05,0.08,0.08,0.17,0.1,0.27s0.03,0.2,0.03,0.31V24.62z"/>
		<path style="fill:#FFFFFF;" d="M20.47,24.62h-0.55v-1.21c0-0.17-0.03-0.3-0.09-0.38c-0.06-0.08-0.14-0.12-0.25-0.12
			c-0.06,0-0.11,0.01-0.17,0.03s-0.11,0.05-0.16,0.09c-0.05,0.04-0.1,0.09-0.14,0.14c-0.04,0.05-0.07,0.12-0.09,0.18v1.26h-0.55
			v-2.16h0.5v0.4c0.08-0.14,0.19-0.24,0.35-0.32c0.15-0.08,0.32-0.12,0.51-0.12c0.13,0,0.24,0.02,0.33,0.07
			c0.08,0.05,0.15,0.11,0.2,0.19c0.05,0.08,0.08,0.17,0.1,0.27s0.03,0.2,0.03,0.31V24.62z"/>
		<path style="fill:#FFFFFF;" d="M21.99,24.66c-0.18,0-0.33-0.03-0.47-0.09c-0.14-0.06-0.26-0.14-0.36-0.25c-0.1-0.1-0.17-0.22-0.22-0.36
			c-0.05-0.13-0.08-0.28-0.08-0.42c0-0.15,0.03-0.29,0.08-0.43c0.05-0.13,0.13-0.25,0.22-0.36c0.1-0.1,0.22-0.18,0.36-0.25
			c0.14-0.06,0.3-0.09,0.47-0.09s0.33,0.03,0.47,0.09c0.14,0.06,0.26,0.14,0.35,0.25c0.1,0.1,0.17,0.22,0.22,0.36
			c0.05,0.13,0.08,0.28,0.08,0.43c0,0.15-0.03,0.29-0.08,0.42s-0.13,0.25-0.22,0.36c-0.1,0.1-0.21,0.18-0.35,0.25
			C22.33,24.63,22.17,24.66,21.99,24.66z M21.43,23.54c0,0.1,0.01,0.18,0.04,0.26c0.03,0.08,0.07,0.15,0.12,0.2s0.11,0.1,0.18,0.13
			c0.07,0.03,0.14,0.05,0.22,0.05c0.08,0,0.15-0.02,0.22-0.05c0.07-0.03,0.13-0.08,0.18-0.13s0.09-0.13,0.12-0.21
			c0.03-0.08,0.04-0.17,0.04-0.26c0-0.09-0.01-0.18-0.04-0.26s-0.07-0.15-0.12-0.21s-0.11-0.1-0.18-0.13
			c-0.07-0.03-0.14-0.05-0.22-0.05c-0.08,0-0.15,0.02-0.22,0.05c-0.07,0.03-0.13,0.08-0.18,0.14s-0.09,0.13-0.12,0.21
			S21.43,23.45,21.43,23.54z"/>
		<path style="fill:#FFFFFF;" d="M24.04,24.62l-0.79-2.16h0.57l0.55,1.71l0.55-1.71h0.52l-0.79,2.16H24.04z"/>
		<path style="fill:#FFFFFF;" d="M26.3,24.66c-0.1,0-0.2-0.02-0.29-0.05c-0.09-0.03-0.17-0.08-0.23-0.14c-0.07-0.06-0.12-0.13-0.15-0.22
			c-0.04-0.08-0.06-0.17-0.06-0.27c0-0.1,0.02-0.2,0.07-0.28s0.11-0.16,0.19-0.22c0.08-0.06,0.18-0.11,0.29-0.14
			c0.11-0.03,0.24-0.05,0.37-0.05c0.1,0,0.19,0.01,0.28,0.02c0.09,0.02,0.17,0.04,0.25,0.07v-0.12c0-0.14-0.04-0.25-0.12-0.33
			c-0.08-0.08-0.2-0.12-0.36-0.12c-0.12,0-0.23,0.02-0.34,0.06s-0.22,0.1-0.34,0.18l-0.17-0.35c0.28-0.18,0.58-0.28,0.9-0.28
			c0.31,0,0.55,0.08,0.72,0.23c0.17,0.15,0.26,0.37,0.26,0.66v0.67c0,0.06,0.01,0.1,0.03,0.12c0.02,0.02,0.05,0.04,0.1,0.04v0.47
			c-0.09,0.02-0.17,0.03-0.24,0.03c-0.1,0-0.18-0.02-0.24-0.07c-0.06-0.05-0.09-0.11-0.1-0.19l-0.01-0.12
			c-0.1,0.13-0.21,0.22-0.35,0.29S26.45,24.66,26.3,24.66z M26.45,24.25c0.09,0,0.18-0.02,0.27-0.05c0.08-0.03,0.15-0.08,0.2-0.13
			c0.06-0.05,0.09-0.1,0.09-0.16v-0.25c-0.07-0.02-0.14-0.04-0.21-0.06c-0.08-0.02-0.15-0.02-0.22-0.02c-0.14,0-0.26,0.03-0.35,0.1
			s-0.14,0.15-0.14,0.25c0,0.09,0.04,0.17,0.11,0.23C26.26,24.22,26.35,24.25,26.45,24.25z"/>
		<path style="fill:#FFFFFF;" d="M29.39,24.51c-0.07,0.03-0.16,0.07-0.27,0.1c-0.11,0.03-0.22,0.05-0.34,0.05c-0.08,0-0.15-0.01-0.22-0.03
			s-0.13-0.05-0.18-0.09c-0.05-0.04-0.09-0.1-0.12-0.16c-0.03-0.07-0.05-0.15-0.05-0.25v-1.24h-0.28v-0.42h0.28v-0.7h0.55v0.7h0.45
			v0.42h-0.45v1.05c0,0.08,0.02,0.13,0.06,0.16c0.04,0.03,0.09,0.05,0.15,0.05c0.06,0,0.11-0.01,0.17-0.03
			c0.06-0.02,0.1-0.04,0.13-0.05L29.39,24.51z"/>
		<path style="fill:#FFFFFF;" d="M29.72,22.16v-0.55h0.55v0.55H29.72z M29.72,24.62v-2.16h0.55v2.16H29.72z"/>
		<path style="fill:#FFFFFF;" d="M31.39,24.62l-0.79-2.16h0.57l0.55,1.71l0.55-1.71h0.52l-0.79,2.16H31.39z"/>
		<path style="fill:#FFFFFF;" d="M34.04,24.66c-0.17,0-0.33-0.03-0.47-0.09s-0.26-0.14-0.36-0.24c-0.1-0.1-0.18-0.22-0.23-0.35
			c-0.05-0.13-0.08-0.28-0.08-0.42c0-0.15,0.03-0.3,0.08-0.44c0.05-0.14,0.13-0.26,0.23-0.36c0.1-0.1,0.22-0.18,0.36-0.25
			c0.14-0.06,0.3-0.09,0.48-0.09c0.18,0,0.33,0.03,0.47,0.09c0.14,0.06,0.26,0.14,0.35,0.24c0.1,0.1,0.17,0.22,0.22,0.35
			c0.05,0.13,0.08,0.27,0.08,0.42c0,0.04,0,0.07,0,0.1c0,0.03,0,0.06-0.01,0.08h-1.67c0.01,0.09,0.03,0.16,0.06,0.23
			c0.03,0.07,0.08,0.12,0.13,0.17c0.05,0.05,0.11,0.08,0.18,0.11c0.07,0.02,0.13,0.04,0.21,0.04c0.11,0,0.21-0.03,0.31-0.08
			c0.1-0.05,0.16-0.12,0.2-0.21l0.47,0.13c-0.08,0.17-0.21,0.3-0.38,0.41C34.49,24.61,34.28,24.66,34.04,24.66z M34.6,23.36
			c-0.01-0.16-0.07-0.29-0.18-0.39c-0.11-0.1-0.23-0.15-0.39-0.15c-0.07,0-0.14,0.01-0.21,0.04c-0.06,0.03-0.12,0.06-0.17,0.11
			c-0.05,0.05-0.09,0.1-0.12,0.17c-0.03,0.07-0.05,0.14-0.06,0.22H34.6z"/>
		<path style="fill:#FFFFFF;" d="M38.59,24.62h-0.55v-1.21c0-0.17-0.03-0.3-0.09-0.38c-0.06-0.08-0.15-0.12-0.27-0.12
			c-0.05,0-0.1,0.01-0.16,0.03s-0.11,0.05-0.16,0.09c-0.05,0.04-0.09,0.09-0.14,0.14c-0.04,0.05-0.07,0.12-0.09,0.18v1.26h-0.55
			v-3.01h0.55v1.25c0.08-0.14,0.19-0.25,0.32-0.32c0.14-0.08,0.29-0.11,0.45-0.11c0.14,0,0.25,0.02,0.34,0.07
			c0.09,0.05,0.16,0.11,0.21,0.19s0.08,0.17,0.1,0.27c0.02,0.1,0.03,0.21,0.03,0.31V24.62z"/>
		<path style="fill:#FFFFFF;" d="M40.11,24.66c-0.17,0-0.33-0.03-0.47-0.09s-0.26-0.14-0.36-0.24c-0.1-0.1-0.18-0.22-0.23-0.35
			c-0.05-0.13-0.08-0.28-0.08-0.42c0-0.15,0.03-0.3,0.08-0.44c0.05-0.14,0.13-0.26,0.23-0.36c0.1-0.1,0.22-0.18,0.36-0.25
			c0.14-0.06,0.3-0.09,0.48-0.09c0.18,0,0.33,0.03,0.47,0.09c0.14,0.06,0.26,0.14,0.35,0.24c0.1,0.1,0.17,0.22,0.22,0.35
			c0.05,0.13,0.08,0.27,0.08,0.42c0,0.04,0,0.07,0,0.1c0,0.03,0,0.06-0.01,0.08h-1.67c0.01,0.09,0.03,0.16,0.06,0.23
			c0.03,0.07,0.08,0.12,0.13,0.17c0.05,0.05,0.11,0.08,0.18,0.11c0.07,0.02,0.13,0.04,0.21,0.04c0.11,0,0.21-0.03,0.31-0.08
			c0.1-0.05,0.16-0.12,0.2-0.21l0.47,0.13c-0.08,0.17-0.21,0.3-0.38,0.41C40.56,24.61,40.35,24.66,40.11,24.66z M40.67,23.36
			c-0.01-0.16-0.07-0.29-0.18-0.39c-0.11-0.1-0.23-0.15-0.39-0.15c-0.07,0-0.14,0.01-0.21,0.04c-0.06,0.03-0.12,0.06-0.17,0.11
			c-0.05,0.05-0.09,0.1-0.12,0.17c-0.03,0.07-0.05,0.14-0.06,0.22H40.67z"/>
		<path style="fill:#FFFFFF;" d="M42.21,24.66c-0.1,0-0.2-0.02-0.29-0.05c-0.09-0.03-0.17-0.08-0.23-0.14c-0.07-0.06-0.12-0.13-0.15-0.22
			c-0.04-0.08-0.06-0.17-0.06-0.27c0-0.1,0.02-0.2,0.07-0.28s0.11-0.16,0.19-0.22c0.08-0.06,0.18-0.11,0.29-0.14
			c0.11-0.03,0.24-0.05,0.37-0.05c0.1,0,0.19,0.01,0.28,0.02c0.09,0.02,0.17,0.04,0.25,0.07v-0.12c0-0.14-0.04-0.25-0.12-0.33
			c-0.08-0.08-0.2-0.12-0.36-0.12c-0.12,0-0.23,0.02-0.34,0.06s-0.22,0.1-0.34,0.18l-0.17-0.35c0.28-0.18,0.58-0.28,0.9-0.28
			c0.31,0,0.55,0.08,0.72,0.23c0.17,0.15,0.26,0.37,0.26,0.66v0.67c0,0.06,0.01,0.1,0.03,0.12c0.02,0.02,0.05,0.04,0.1,0.04v0.47
			c-0.09,0.02-0.17,0.03-0.24,0.03c-0.1,0-0.18-0.02-0.24-0.07c-0.06-0.05-0.09-0.11-0.1-0.19L43,24.27
			c-0.1,0.13-0.21,0.22-0.35,0.29S42.36,24.66,42.21,24.66z M42.36,24.25c0.09,0,0.18-0.02,0.27-0.05c0.08-0.03,0.15-0.08,0.2-0.13
			c0.06-0.05,0.09-0.1,0.09-0.16v-0.25c-0.07-0.02-0.14-0.04-0.21-0.06c-0.08-0.02-0.15-0.02-0.22-0.02c-0.14,0-0.26,0.03-0.35,0.1
			s-0.14,0.15-0.14,0.25c0,0.09,0.04,0.17,0.11,0.23C42.17,24.22,42.26,24.25,42.36,24.25z"/>
		<path style="fill:#FFFFFF;" d="M44.02,21.61h0.55v2.32c0,0.08,0.02,0.14,0.06,0.19s0.09,0.07,0.17,0.07c0.03,0,0.07-0.01,0.11-0.02
			c0.04-0.01,0.08-0.02,0.11-0.04l0.07,0.42c-0.07,0.04-0.16,0.06-0.26,0.08c-0.1,0.02-0.19,0.03-0.27,0.03
			c-0.17,0-0.31-0.05-0.4-0.14c-0.09-0.09-0.14-0.22-0.14-0.39V21.61z"/>
		<path style="fill:#FFFFFF;" d="M46.66,24.51c-0.07,0.03-0.16,0.07-0.27,0.1c-0.11,0.03-0.22,0.05-0.34,0.05c-0.08,0-0.15-0.01-0.22-0.03
			s-0.13-0.05-0.18-0.09c-0.05-0.04-0.09-0.1-0.12-0.16c-0.03-0.07-0.05-0.15-0.05-0.25v-1.24h-0.28v-0.42h0.28v-0.7h0.55v0.7h0.45
			v0.42h-0.45v1.05c0,0.08,0.02,0.13,0.06,0.16c0.04,0.03,0.09,0.05,0.15,0.05c0.06,0,0.11-0.01,0.17-0.03
			c0.06-0.02,0.1-0.04,0.13-0.05L46.66,24.51z"/>
		<path style="fill:#FFFFFF;" d="M49,24.62h-0.55v-1.21c0-0.17-0.03-0.3-0.09-0.38c-0.06-0.08-0.15-0.12-0.27-0.12c-0.05,0-0.1,0.01-0.16,0.03
			s-0.11,0.05-0.16,0.09c-0.05,0.04-0.09,0.09-0.14,0.14c-0.04,0.05-0.07,0.12-0.09,0.18v1.26h-0.55v-3.01h0.55v1.25
			c0.08-0.14,0.19-0.25,0.32-0.32c0.14-0.08,0.29-0.11,0.45-0.11c0.14,0,0.25,0.02,0.34,0.07c0.09,0.05,0.16,0.11,0.21,0.19
			s0.08,0.17,0.1,0.27c0.02,0.1,0.03,0.21,0.03,0.31V24.62z"/>
		<path style="fill:#FFFFFF;" d="M50.42,23.54c0-0.15,0.03-0.29,0.08-0.43c0.05-0.13,0.13-0.25,0.23-0.35c0.1-0.1,0.22-0.18,0.36-0.24
			c0.14-0.06,0.3-0.09,0.47-0.09c0.24,0,0.44,0.05,0.6,0.15s0.29,0.23,0.37,0.4l-0.54,0.17c-0.05-0.08-0.11-0.14-0.19-0.18
			c-0.08-0.04-0.16-0.06-0.26-0.06c-0.08,0-0.15,0.02-0.22,0.05c-0.07,0.03-0.13,0.08-0.18,0.13c-0.05,0.06-0.09,0.12-0.12,0.2
			c-0.03,0.08-0.04,0.17-0.04,0.26s0.02,0.18,0.04,0.26c0.03,0.08,0.07,0.15,0.12,0.21s0.11,0.1,0.18,0.13
			c0.07,0.03,0.14,0.05,0.22,0.05c0.1,0,0.19-0.02,0.27-0.07c0.08-0.05,0.14-0.11,0.17-0.18l0.54,0.17c-0.07,0.16-0.2,0.3-0.37,0.4
			c-0.17,0.1-0.38,0.16-0.61,0.16c-0.18,0-0.33-0.03-0.47-0.09c-0.14-0.06-0.26-0.14-0.36-0.25c-0.1-0.1-0.18-0.22-0.23-0.36
			C50.44,23.83,50.42,23.69,50.42,23.54z"/>
		<path style="fill:#FFFFFF;" d="M53.51,24.66c-0.1,0-0.2-0.02-0.29-0.05c-0.09-0.03-0.17-0.08-0.23-0.14c-0.07-0.06-0.12-0.13-0.15-0.22
			c-0.04-0.08-0.06-0.17-0.06-0.27c0-0.1,0.02-0.2,0.07-0.28s0.11-0.16,0.19-0.22c0.08-0.06,0.18-0.11,0.29-0.14
			c0.11-0.03,0.24-0.05,0.37-0.05c0.1,0,0.19,0.01,0.28,0.02c0.09,0.02,0.17,0.04,0.25,0.07v-0.12c0-0.14-0.04-0.25-0.12-0.33
			c-0.08-0.08-0.2-0.12-0.36-0.12c-0.12,0-0.23,0.02-0.34,0.06s-0.22,0.1-0.34,0.18l-0.17-0.35c0.28-0.18,0.58-0.28,0.9-0.28
			c0.31,0,0.55,0.08,0.72,0.23c0.17,0.15,0.26,0.37,0.26,0.66v0.67c0,0.06,0.01,0.1,0.03,0.12c0.02,0.02,0.05,0.04,0.1,0.04v0.47
			c-0.09,0.02-0.17,0.03-0.24,0.03c-0.1,0-0.18-0.02-0.24-0.07c-0.06-0.05-0.09-0.11-0.1-0.19l-0.01-0.12
			c-0.1,0.13-0.21,0.22-0.35,0.29S53.66,24.66,53.51,24.66z M53.66,24.25c0.09,0,0.18-0.02,0.27-0.05c0.08-0.03,0.15-0.08,0.2-0.13
			c0.06-0.05,0.09-0.1,0.09-0.16v-0.25c-0.07-0.02-0.14-0.04-0.21-0.06c-0.08-0.02-0.15-0.02-0.22-0.02c-0.14,0-0.26,0.03-0.35,0.1
			s-0.14,0.15-0.14,0.25c0,0.09,0.04,0.17,0.11,0.23C53.47,24.22,53.56,24.25,53.66,24.25z"/>
		<path style="fill:#FFFFFF;" d="M56.61,22.94c-0.17,0-0.32,0.04-0.45,0.1c-0.13,0.06-0.23,0.15-0.28,0.28v1.31h-0.55v-2.16h0.51v0.46
			c0.04-0.07,0.08-0.14,0.14-0.2c0.05-0.06,0.11-0.11,0.17-0.15s0.12-0.08,0.18-0.1c0.06-0.02,0.12-0.03,0.18-0.03
			c0.03,0,0.05,0,0.07,0s0.03,0,0.04,0V22.94z"/>
		<path style="fill:#FFFFFF;" d="M57.85,24.66c-0.17,0-0.33-0.03-0.47-0.09s-0.26-0.14-0.36-0.24c-0.1-0.1-0.18-0.22-0.23-0.35
			c-0.05-0.13-0.08-0.28-0.08-0.42c0-0.15,0.03-0.3,0.08-0.44c0.05-0.14,0.13-0.26,0.23-0.36c0.1-0.1,0.22-0.18,0.36-0.25
			c0.14-0.06,0.3-0.09,0.48-0.09c0.18,0,0.33,0.03,0.47,0.09c0.14,0.06,0.26,0.14,0.35,0.24c0.1,0.1,0.17,0.22,0.22,0.35
			c0.05,0.13,0.08,0.27,0.08,0.42c0,0.04,0,0.07,0,0.1c0,0.03,0,0.06-0.01,0.08H57.3c0.01,0.09,0.03,0.16,0.06,0.23
			c0.03,0.07,0.08,0.12,0.13,0.17c0.05,0.05,0.11,0.08,0.18,0.11c0.07,0.02,0.13,0.04,0.21,0.04c0.11,0,0.21-0.03,0.31-0.08
			c0.1-0.05,0.16-0.12,0.2-0.21l0.47,0.13c-0.08,0.17-0.21,0.3-0.38,0.41C58.3,24.61,58.1,24.66,57.85,24.66z M58.41,23.36
			c-0.01-0.16-0.07-0.29-0.18-0.39c-0.11-0.1-0.23-0.15-0.39-0.15c-0.07,0-0.14,0.01-0.21,0.04c-0.06,0.03-0.12,0.06-0.17,0.11
			c-0.05,0.05-0.09,0.1-0.12,0.17c-0.03,0.07-0.05,0.14-0.06,0.22H58.41z"/>
		<path style="fill:#FFFFFF;" d="M60.39,22.16v-0.55h0.55v0.55H60.39z M60.39,24.62v-2.16h0.55v2.16H60.39z"/>
		<path style="fill:#FFFFFF;" d="M63.49,24.62h-0.55v-1.21c0-0.17-0.03-0.3-0.09-0.38c-0.06-0.08-0.14-0.12-0.25-0.12
			c-0.06,0-0.11,0.01-0.17,0.03s-0.11,0.05-0.16,0.09c-0.05,0.04-0.1,0.09-0.14,0.14c-0.04,0.05-0.07,0.12-0.09,0.18v1.26h-0.55
			v-2.16h0.5v0.4c0.08-0.14,0.19-0.24,0.35-0.32c0.15-0.08,0.32-0.12,0.51-0.12c0.13,0,0.24,0.02,0.33,0.07
			c0.08,0.05,0.15,0.11,0.2,0.19c0.05,0.08,0.08,0.17,0.1,0.27s0.03,0.2,0.03,0.31V24.62z"/>
		<path style="fill:#FFFFFF;" d="M64.91,24.66c-0.15,0-0.29-0.03-0.41-0.09s-0.23-0.14-0.33-0.24c-0.09-0.1-0.16-0.22-0.21-0.36
			c-0.05-0.14-0.08-0.28-0.08-0.44c0-0.16,0.02-0.3,0.07-0.44c0.05-0.13,0.11-0.25,0.2-0.35c0.08-0.1,0.19-0.18,0.3-0.24
			s0.25-0.09,0.39-0.09c0.16,0,0.3,0.04,0.43,0.12c0.13,0.08,0.23,0.18,0.3,0.3v-1.23h0.55v2.37c0,0.06,0.01,0.1,0.03,0.12
			c0.02,0.02,0.05,0.04,0.1,0.04v0.47c-0.1,0.02-0.17,0.03-0.23,0.03c-0.1,0-0.18-0.02-0.24-0.07s-0.1-0.11-0.11-0.19l-0.01-0.14
			c-0.08,0.14-0.19,0.24-0.32,0.31C65.2,24.62,65.06,24.66,64.91,24.66z M65.05,24.19c0.05,0,0.11-0.01,0.16-0.03
			c0.06-0.02,0.11-0.04,0.15-0.08c0.05-0.03,0.09-0.07,0.13-0.12s0.06-0.09,0.08-0.14v-0.52c-0.02-0.06-0.05-0.12-0.09-0.17
			c-0.04-0.05-0.09-0.09-0.14-0.13c-0.05-0.04-0.1-0.07-0.16-0.09s-0.11-0.03-0.17-0.03c-0.08,0-0.16,0.02-0.23,0.05
			c-0.07,0.04-0.13,0.08-0.18,0.15c-0.05,0.06-0.09,0.13-0.12,0.21c-0.03,0.08-0.04,0.16-0.04,0.25c0,0.09,0.01,0.17,0.04,0.25
			c0.03,0.08,0.07,0.14,0.12,0.2c0.05,0.06,0.11,0.1,0.19,0.14C64.88,24.17,64.96,24.19,65.05,24.19z"/>
		<path style="fill:#FFFFFF;" d="M67.37,24.66c-0.22,0-0.39-0.07-0.51-0.21c-0.12-0.14-0.17-0.35-0.17-0.63v-1.35h0.55v1.23
			c0,0.33,0.12,0.5,0.36,0.5c0.11,0,0.21-0.03,0.31-0.1c0.1-0.06,0.18-0.16,0.25-0.29v-1.34h0.55v1.52c0,0.06,0.01,0.1,0.03,0.12
			c0.02,0.02,0.05,0.04,0.1,0.04v0.47c-0.06,0.01-0.1,0.02-0.14,0.02c-0.04,0-0.07,0-0.1,0c-0.1,0-0.18-0.02-0.24-0.07
			c-0.06-0.04-0.1-0.11-0.11-0.19l-0.01-0.17c-0.1,0.15-0.22,0.26-0.37,0.33C67.72,24.62,67.55,24.66,67.37,24.66z"/>
		<path style="fill:#FFFFFF;" d="M70.11,24.66c-0.18,0-0.36-0.03-0.53-0.09s-0.32-0.14-0.44-0.25l0.21-0.35c0.13,0.09,0.26,0.16,0.38,0.21
			c0.13,0.05,0.25,0.07,0.37,0.07c0.11,0,0.2-0.02,0.26-0.06c0.06-0.04,0.09-0.1,0.09-0.18c0-0.08-0.04-0.13-0.11-0.17
			s-0.2-0.08-0.36-0.12c-0.14-0.04-0.26-0.08-0.36-0.11c-0.1-0.04-0.18-0.08-0.24-0.12s-0.1-0.1-0.13-0.16s-0.04-0.13-0.04-0.21
			c0-0.11,0.02-0.21,0.06-0.3c0.04-0.09,0.1-0.16,0.18-0.22c0.08-0.06,0.17-0.11,0.27-0.14c0.1-0.03,0.21-0.05,0.34-0.05
			c0.16,0,0.31,0.02,0.46,0.07c0.14,0.05,0.27,0.12,0.39,0.23l-0.22,0.33c-0.11-0.08-0.22-0.14-0.32-0.18s-0.21-0.06-0.31-0.06
			c-0.09,0-0.17,0.02-0.23,0.06c-0.06,0.04-0.09,0.1-0.09,0.19c0,0.04,0.01,0.07,0.02,0.09c0.01,0.02,0.04,0.05,0.07,0.07
			c0.03,0.02,0.08,0.04,0.13,0.06c0.05,0.02,0.12,0.04,0.2,0.06c0.15,0.04,0.28,0.08,0.38,0.12c0.11,0.04,0.19,0.08,0.26,0.13
			s0.12,0.11,0.15,0.17s0.05,0.14,0.05,0.23c0,0.21-0.08,0.38-0.23,0.5C70.6,24.6,70.38,24.66,70.11,24.66z"/>
		<path style="fill:#FFFFFF;" d="M72.68,24.51c-0.07,0.03-0.16,0.07-0.27,0.1c-0.11,0.03-0.22,0.05-0.34,0.05c-0.08,0-0.15-0.01-0.22-0.03
			s-0.13-0.05-0.18-0.09c-0.05-0.04-0.09-0.1-0.12-0.16c-0.03-0.07-0.05-0.15-0.05-0.25v-1.24h-0.28v-0.42h0.28v-0.7h0.55v0.7h0.45
			v0.42h-0.45v1.05c0,0.08,0.02,0.13,0.06,0.16c0.04,0.03,0.09,0.05,0.15,0.05c0.06,0,0.11-0.01,0.17-0.03
			c0.06-0.02,0.1-0.04,0.13-0.05L72.68,24.51z"/>
		<path style="fill:#FFFFFF;" d="M74.3,22.94c-0.17,0-0.32,0.04-0.45,0.1c-0.13,0.06-0.23,0.15-0.28,0.28v1.31h-0.55v-2.16h0.51v0.46
			c0.04-0.07,0.08-0.14,0.14-0.2c0.05-0.06,0.11-0.11,0.17-0.15s0.12-0.08,0.18-0.1c0.06-0.02,0.12-0.03,0.18-0.03
			c0.03,0,0.05,0,0.07,0s0.03,0,0.04,0V22.94z"/>
		<path style="fill:#FFFFFF;" d="M74.69,25.04c0.05,0.01,0.09,0.02,0.14,0.03s0.08,0.01,0.11,0.01c0.04,0,0.07-0.01,0.1-0.02
			s0.06-0.04,0.08-0.07s0.05-0.08,0.07-0.14s0.05-0.14,0.08-0.23l-0.85-2.16h0.57l0.58,1.68l0.52-1.68h0.52l-0.91,2.59
			c-0.05,0.15-0.14,0.27-0.27,0.37c-0.13,0.1-0.28,0.14-0.47,0.14c-0.04,0-0.09,0-0.13-0.01c-0.05-0.01-0.09-0.02-0.14-0.04V25.04z"
			/>
		<path style="fill:#FFFFFF;" d="M78.69,24.66c-0.18,0-0.36-0.03-0.53-0.09s-0.32-0.14-0.44-0.25l0.21-0.35c0.13,0.09,0.26,0.16,0.38,0.21
			c0.13,0.05,0.25,0.07,0.37,0.07c0.11,0,0.2-0.02,0.26-0.06c0.06-0.04,0.09-0.1,0.09-0.18c0-0.08-0.04-0.13-0.11-0.17
			s-0.2-0.08-0.36-0.12c-0.14-0.04-0.26-0.08-0.36-0.11c-0.1-0.04-0.18-0.08-0.24-0.12s-0.1-0.1-0.13-0.16s-0.04-0.13-0.04-0.21
			c0-0.11,0.02-0.21,0.06-0.3c0.04-0.09,0.1-0.16,0.18-0.22c0.08-0.06,0.17-0.11,0.27-0.14c0.1-0.03,0.21-0.05,0.34-0.05
			c0.16,0,0.31,0.02,0.46,0.07c0.14,0.05,0.27,0.12,0.39,0.23l-0.22,0.33c-0.11-0.08-0.22-0.14-0.32-0.18s-0.21-0.06-0.31-0.06
			c-0.09,0-0.17,0.02-0.23,0.06c-0.06,0.04-0.09,0.1-0.09,0.19c0,0.04,0.01,0.07,0.02,0.09c0.01,0.02,0.04,0.05,0.07,0.07
			c0.03,0.02,0.08,0.04,0.13,0.06c0.05,0.02,0.12,0.04,0.2,0.06c0.15,0.04,0.28,0.08,0.38,0.12c0.11,0.04,0.19,0.08,0.26,0.13
			s0.12,0.11,0.15,0.17s0.05,0.14,0.05,0.23c0,0.21-0.08,0.38-0.23,0.5C79.17,24.6,78.96,24.66,78.69,24.66z"/>
		<path style="fill:#FFFFFF;" d="M80.96,24.66c-0.18,0-0.33-0.03-0.47-0.09c-0.14-0.06-0.26-0.14-0.36-0.25c-0.1-0.1-0.17-0.22-0.22-0.36
			c-0.05-0.13-0.08-0.28-0.08-0.42c0-0.15,0.03-0.29,0.08-0.43c0.05-0.13,0.13-0.25,0.22-0.36c0.1-0.1,0.22-0.18,0.36-0.25
			c0.14-0.06,0.3-0.09,0.47-0.09s0.33,0.03,0.47,0.09c0.14,0.06,0.26,0.14,0.35,0.25c0.1,0.1,0.17,0.22,0.22,0.36
			c0.05,0.13,0.08,0.28,0.08,0.43c0,0.15-0.03,0.29-0.08,0.42s-0.13,0.25-0.22,0.36c-0.1,0.1-0.21,0.18-0.35,0.25
			C81.29,24.63,81.13,24.66,80.96,24.66z M80.39,23.54c0,0.1,0.01,0.18,0.04,0.26c0.03,0.08,0.07,0.15,0.12,0.2s0.11,0.1,0.18,0.13
			c0.07,0.03,0.14,0.05,0.22,0.05c0.08,0,0.15-0.02,0.22-0.05c0.07-0.03,0.13-0.08,0.18-0.13s0.09-0.13,0.12-0.21
			c0.03-0.08,0.04-0.17,0.04-0.26c0-0.09-0.01-0.18-0.04-0.26s-0.07-0.15-0.12-0.21s-0.11-0.1-0.18-0.13
			c-0.07-0.03-0.14-0.05-0.22-0.05c-0.08,0-0.15,0.02-0.22,0.05c-0.07,0.03-0.13,0.08-0.18,0.14s-0.09,0.13-0.12,0.21
			S80.39,23.45,80.39,23.54z"/>
		<path style="fill:#FFFFFF;" d="M82.49,21.61h0.55v2.32c0,0.08,0.02,0.14,0.06,0.19s0.09,0.07,0.17,0.07c0.03,0,0.07-0.01,0.11-0.02
			c0.04-0.01,0.08-0.02,0.11-0.04l0.07,0.42c-0.07,0.04-0.16,0.06-0.26,0.08c-0.1,0.02-0.19,0.03-0.27,0.03
			c-0.17,0-0.31-0.05-0.4-0.14c-0.09-0.09-0.14-0.22-0.14-0.39V21.61z"/>
		<path style="fill:#FFFFFF;" d="M84.51,24.66c-0.22,0-0.39-0.07-0.51-0.21c-0.12-0.14-0.17-0.35-0.17-0.63v-1.35h0.55v1.23
			c0,0.33,0.12,0.5,0.36,0.5c0.11,0,0.21-0.03,0.31-0.1c0.1-0.06,0.18-0.16,0.25-0.29v-1.34h0.55v1.52c0,0.06,0.01,0.1,0.03,0.12
			c0.02,0.02,0.05,0.04,0.1,0.04v0.47c-0.06,0.01-0.1,0.02-0.14,0.02c-0.04,0-0.07,0-0.1,0c-0.1,0-0.18-0.02-0.24-0.07
			c-0.06-0.04-0.1-0.11-0.11-0.19l-0.01-0.17c-0.1,0.15-0.22,0.26-0.37,0.33C84.85,24.62,84.69,24.66,84.51,24.66z"/>
		<path style="fill:#FFFFFF;" d="M87.73,24.51c-0.07,0.03-0.16,0.07-0.27,0.1c-0.11,0.03-0.22,0.05-0.34,0.05c-0.08,0-0.15-0.01-0.22-0.03
			s-0.13-0.05-0.18-0.09c-0.05-0.04-0.09-0.1-0.12-0.16c-0.03-0.07-0.05-0.15-0.05-0.25v-1.24h-0.28v-0.42h0.28v-0.7h0.55v0.7h0.45
			v0.42h-0.45v1.05c0,0.08,0.02,0.13,0.06,0.16c0.04,0.03,0.09,0.05,0.15,0.05c0.06,0,0.11-0.01,0.17-0.03
			c0.06-0.02,0.1-0.04,0.13-0.05L87.73,24.51z"/>
		<path style="fill:#FFFFFF;" d="M88.06,22.16v-0.55h0.55v0.55H88.06z M88.06,24.62v-2.16h0.55v2.16H88.06z"/>
		<path style="fill:#FFFFFF;" d="M90.15,24.66c-0.18,0-0.33-0.03-0.47-0.09c-0.14-0.06-0.26-0.14-0.36-0.25c-0.1-0.1-0.17-0.22-0.22-0.36
			c-0.05-0.13-0.08-0.28-0.08-0.42c0-0.15,0.03-0.29,0.08-0.43c0.05-0.13,0.13-0.25,0.22-0.36c0.1-0.1,0.22-0.18,0.36-0.25
			c0.14-0.06,0.3-0.09,0.47-0.09s0.33,0.03,0.47,0.09c0.14,0.06,0.26,0.14,0.35,0.25c0.1,0.1,0.17,0.22,0.22,0.36
			c0.05,0.13,0.08,0.28,0.08,0.43c0,0.15-0.03,0.29-0.08,0.42s-0.13,0.25-0.22,0.36c-0.1,0.1-0.21,0.18-0.35,0.25
			C90.48,24.63,90.32,24.66,90.15,24.66z M89.58,23.54c0,0.1,0.01,0.18,0.04,0.26c0.03,0.08,0.07,0.15,0.12,0.2s0.11,0.1,0.18,0.13
			c0.07,0.03,0.14,0.05,0.22,0.05c0.08,0,0.15-0.02,0.22-0.05c0.07-0.03,0.13-0.08,0.18-0.13s0.09-0.13,0.12-0.21
			c0.03-0.08,0.04-0.17,0.04-0.26c0-0.09-0.01-0.18-0.04-0.26s-0.07-0.15-0.12-0.21s-0.11-0.1-0.18-0.13
			c-0.07-0.03-0.14-0.05-0.22-0.05c-0.08,0-0.15,0.02-0.22,0.05c-0.07,0.03-0.13,0.08-0.18,0.14s-0.09,0.13-0.12,0.21
			S89.58,23.45,89.58,23.54z"/>
		<path style="fill:#FFFFFF;" d="M93.69,24.62h-0.55v-1.21c0-0.17-0.03-0.3-0.09-0.38c-0.06-0.08-0.14-0.12-0.25-0.12
			c-0.06,0-0.11,0.01-0.17,0.03s-0.11,0.05-0.16,0.09c-0.05,0.04-0.1,0.09-0.14,0.14c-0.04,0.05-0.07,0.12-0.09,0.18v1.26h-0.55
			v-2.16h0.5v0.4c0.08-0.14,0.19-0.24,0.35-0.32c0.15-0.08,0.32-0.12,0.51-0.12c0.13,0,0.24,0.02,0.33,0.07
			c0.08,0.05,0.15,0.11,0.2,0.19c0.05,0.08,0.08,0.17,0.1,0.27s0.03,0.2,0.03,0.31V24.62z"/>
		<path style="fill:#FFFFFF;" d="M95.03,24.66c-0.18,0-0.36-0.03-0.53-0.09s-0.32-0.14-0.44-0.25l0.21-0.35c0.13,0.09,0.26,0.16,0.38,0.21
			c0.13,0.05,0.25,0.07,0.37,0.07c0.11,0,0.2-0.02,0.26-0.06c0.06-0.04,0.09-0.1,0.09-0.18c0-0.08-0.04-0.13-0.11-0.17
			s-0.2-0.08-0.36-0.12c-0.14-0.04-0.26-0.08-0.36-0.11c-0.1-0.04-0.18-0.08-0.24-0.12s-0.1-0.1-0.13-0.16s-0.04-0.13-0.04-0.21
			c0-0.11,0.02-0.21,0.06-0.3c0.04-0.09,0.1-0.16,0.18-0.22c0.08-0.06,0.17-0.11,0.27-0.14c0.1-0.03,0.21-0.05,0.34-0.05
			c0.16,0,0.31,0.02,0.46,0.07c0.14,0.05,0.27,0.12,0.39,0.23l-0.22,0.33c-0.11-0.08-0.22-0.14-0.32-0.18s-0.21-0.06-0.31-0.06
			c-0.09,0-0.17,0.02-0.23,0.06c-0.06,0.04-0.09,0.1-0.09,0.19c0,0.04,0.01,0.07,0.02,0.09c0.01,0.02,0.04,0.05,0.07,0.07
			c0.03,0.02,0.08,0.04,0.13,0.06c0.05,0.02,0.12,0.04,0.2,0.06c0.15,0.04,0.28,0.08,0.38,0.12c0.11,0.04,0.19,0.08,0.26,0.13
			s0.12,0.11,0.15,0.17s0.05,0.14,0.05,0.23c0,0.21-0.08,0.38-0.23,0.5C95.51,24.6,95.3,24.66,95.03,24.66z"/>
	</g>
	<g>
		<path style="fill-rule:evenodd;clip-rule:evenodd;fill:#FFFFFF;" d="M2.96,5.98h2.09c0,0,0.44-1.14,2.14-2.02l0.19-2.07C7.37,1.89,4.21,2.45,2.96,5.98z"/>
		<path style="fill-rule:evenodd;clip-rule:evenodd;fill:#FFFFFF;" d="M4.45,7.86c-0.03,0.23-0.3,2.6,1.45,4.21c1.22,1.12,2.7,1.2,3.03,1.21c0.93,0.03,1.62-0.23,1.95-0.36
			c1.46-0.56,2.3-1.61,2.67-2.15c0.1,0.07,0.2,0.15,0.3,0.22c-0.27,0.47-0.78,1.22-1.64,1.88c-0.75,0.57-1.43,0.81-1.59,0.87
			c-2.02,0.71-3.87-0.02-4.3-0.21C4.81,12.89,4,11.83,3.8,11.55c-0.72-1-0.95-1.99-1.04-2.48c-0.08-0.49-0.09-0.9-0.08-1.21H4.45z"
			/>
		<path style="fill-rule:evenodd;clip-rule:evenodd;fill:#FFFFFF;" d="M11.18,2.27c0,0,2.41,0.9,3.3,3.9h-1.07c0,0-0.45-1.16-1.77-1.93L11.18,2.27z"/>
		<g>
			<path style="fill:#FFFFFF;" d="M12.2,10.63c0,0-0.01,0-0.01,0c-0.15-0.01-0.27-0.11-0.3-0.25L10.1,2.8L9.22,7.66
				C9.18,7.82,9.03,7.91,8.88,7.92C8.72,7.92,8.59,7.79,8.57,7.64L8.3,5.01L7.7,10.32c-0.02,0.14-0.12,0.25-0.26,0.28
				c-0.14,0.02-0.28-0.04-0.35-0.17c-0.04-0.08-1.07-2.33-1.31-2.87C5.64,7.25,5.34,7.25,5.3,7.25l-3.28,0V6.6h3.27
				c0.27-0.02,0.83,0.11,1.09,0.7c0.13,0.29,0.49,1,0.8,1.6l0.8-7.03C8,1.71,8.14,1.59,8.3,1.59s0.3,0.12,0.32,0.29l0.35,3.27
				l0.78-4.11c0.03-0.15,0.16-0.26,0.31-0.26c0,0,0,0,0.01,0c0.15,0,0.28,0.1,0.32,0.25l1.87,7.9l0.46-1.42
				c0.06-0.25,0.38-0.76,1.08-0.76h1.3v0.65h-1.3c-0.37,0-0.45,0.28-0.45,0.29l-0.82,2.73C12.47,10.54,12.34,10.63,12.2,10.63z"/>
		</g>
		<path style="fill-rule:evenodd;clip-rule:evenodd;fill:#FFFFFF;" d="M1.52,6.22c-0.39,0-0.7,0.31-0.7,0.7s0.31,0.71,0.7,0.71s0.71-0.32,0.71-0.71S1.91,6.22,1.52,6.22z M1.52,7.3
			c-0.2,0-0.37-0.17-0.37-0.37c0-0.2,0.17-0.37,0.37-0.37s0.37,0.17,0.37,0.37C1.89,7.13,1.72,7.3,1.52,7.3z"/>
		<path style="fill-rule:evenodd;clip-rule:evenodd;fill:#FFFFFF;" d="M15.59,6.36c-0.39,0-0.7,0.31-0.7,0.7c0,0.39,0.31,0.71,0.7,0.71s0.71-0.32,0.71-0.71
			C16.3,6.67,15.98,6.36,15.59,6.36z M15.59,7.44c-0.2,0-0.36-0.17-0.36-0.37c0-0.2,0.16-0.37,0.36-0.37c0.21,0,0.37,0.17,0.37,0.37
			C15.96,7.27,15.8,7.44,15.59,7.44z"/>
	</g>
	<g>
		<path style="fill:#FFFFFF;" d="M18.22,16.07l-2.35-3.77v5.77c0,0.29-0.24,0.53-0.53,0.53s-0.53-0.24-0.53-0.53V10.1
			c0-0.24,0.2-0.44,0.44-0.44c0.15,0,0.29,0.08,0.36,0.2l3.39,5.46l3.39-5.46c0.08-0.12,0.21-0.2,0.36-0.2
			c0.24,0,0.44,0.2,0.44,0.44v7.96c0,0.29-0.24,0.53-0.53,0.53s-0.53-0.24-0.53-0.53V12.3l-2.35,3.77
			c-0.17,0.27-0.45,0.45-0.79,0.45S18.38,16.34,18.22,16.07z"/>
		<path style="fill:#FFFFFF;" d="M30.33,18.08c0,0.26-0.18,0.39-0.47,0.47c-0.41,0.08-0.97,0.14-1.63,0.14c-2.1,0-3.06-1.41-3.06-3.16
			c0-1.74,0.94-3.15,2.82-3.15s2.79,1.2,2.79,2.75c0,0.44-0.35,0.8-0.79,0.8h-3.77c0.27,1.23,0.7,1.77,2.48,1.77
			c0.23,0,0.7-0.05,1.17-0.09C30.12,17.61,30.33,17.82,30.33,18.08z M29.71,14.95c-0.03-1.29-0.82-1.59-1.74-1.59
			c-1.06,0-1.6,0.53-1.74,1.59H29.71z"/>
		<path style="fill:#FFFFFF;" d="M38.77,15.46c0-2.18,1.77-3.09,2.98-3.09c0.48,0,1.2,0.03,1.91,0.38c0.15,0.08,0.26,0.23,0.26,0.41
			c0,0.26-0.23,0.47-0.48,0.47c-0.08,0-0.12-0.03-0.23-0.06c-0.53-0.18-0.95-0.21-1.26-0.21c-0.82,0-2.12,0.42-2.12,2.09
			c0,1.85,1.33,2.26,2.12,2.26c0.3,0,0.73-0.03,1.26-0.21c0.11-0.03,0.15-0.06,0.23-0.06c0.26,0,0.48,0.21,0.48,0.47
			c0,0.18-0.11,0.33-0.26,0.41c-0.71,0.35-1.42,0.38-1.91,0.38C40.64,18.62,38.77,17.99,38.77,15.46z"/>
		<path style="fill:#FFFFFF;" d="M47.97,12.37c1.86,0,2.97,0.88,2.97,2.48v3.21c0,0.29-0.15,0.53-0.44,0.53c-0.21,0-0.54,0-0.62-0.47
			l-0.05-0.26c-0.68,0.82-1.98,0.82-2.38,0.82h-0.2c-0.29,0-1.91-0.15-1.91-1.97c0-0.98,0.58-1.86,2.29-1.86
			c0.47,0,1.09,0.03,2.24,0.65V14.9c0-0.89-0.47-1.54-2.51-1.54c-0.23,0-0.58,0.05-0.92,0.09c-0.26,0-0.45-0.2-0.45-0.45
			c0-0.2,0.14-0.38,0.32-0.44C46.67,12.45,47.16,12.37,47.97,12.37z M49.88,16.49c0,0-0.7-0.65-1.89-0.65
			c-1.35,0-1.57,0.36-1.57,0.92s0.36,0.94,1.57,0.94c1.42,0,1.89-0.73,1.89-0.73V16.49z"/>
		<path style="fill:#FFFFFF;" d="M56.5,12.37c0.27,0,0.48,0.21,0.48,0.48s-0.23,0.5-0.5,0.5H56.3c-2.1,0-2.18,2.01-2.18,2.01v2.69
			c0,0.29-0.24,0.53-0.53,0.53s-0.53-0.24-0.53-0.53v-5.07c0-0.29,0.15-0.53,0.44-0.53c0.21,0,0.48,0,0.56,0.5l0.06,0.39
			c0.61-0.98,2.09-0.98,2.27-0.98H56.5z"/>
		<path style="fill:#FFFFFF;" d="M63.05,18.08c0,0.26-0.18,0.39-0.47,0.47c-0.41,0.08-0.97,0.14-1.63,0.14c-2.1,0-3.06-1.41-3.06-3.16
			c0-1.74,0.94-3.15,2.82-3.15s2.79,1.2,2.79,2.75c0,0.44-0.35,0.8-0.79,0.8h-3.77c0.27,1.23,0.7,1.77,2.48,1.77
			c0.23,0,0.7-0.05,1.17-0.09C62.84,17.61,63.05,17.82,63.05,18.08z M62.43,14.95c-0.03-1.29-0.82-1.59-1.74-1.59
			c-1.06,0-1.6,0.53-1.74,1.59H62.43z"/>
		<path style="fill:#FFFFFF;" d="M72.11,16.07l-2.35-3.77v5.77c0,0.29-0.24,0.53-0.53,0.53s-0.53-0.24-0.53-0.53V10.1
			c0-0.24,0.2-0.44,0.44-0.44c0.15,0,0.29,0.08,0.36,0.2l3.39,5.46l3.39-5.46c0.08-0.12,0.21-0.2,0.36-0.2
			c0.24,0,0.44,0.2,0.44,0.44v7.96c0,0.29-0.24,0.53-0.53,0.53s-0.53-0.24-0.53-0.53V12.3l-2.35,3.77
			c-0.17,0.27-0.45,0.45-0.79,0.45S72.28,16.34,72.11,16.07z"/>
		<path style="fill:#FFFFFF;" d="M84.84,10.27c0,0.26-0.17,0.51-0.42,0.51c-0.64-0.12-1.48-0.21-1.83-0.21c-1.01,0-2.54,0-2.54,1.36
			c0,1.77,5.66,1.68,5.66,4.36c0,1.67-1.41,2.39-3.35,2.39c-1.14,0-2.07-0.18-2.68-0.39c-0.18-0.06-0.32-0.24-0.32-0.45
			c0-0.26,0.21-0.48,0.47-0.48c0.03,0,0.06,0,0.11,0.02c0.62,0.15,1.53,0.33,2.36,0.33c1.18,0,2.35-0.27,2.35-1.38
			c0-1.83-5.66-1.6-5.66-4.39c0-1.97,1.7-2.35,3.47-2.35c1.01,0,1.63,0.09,2.04,0.21C84.68,9.86,84.84,10.06,84.84,10.27z"/>
		<path style="fill:#FFFFFF;" d="M87.38,13.95c0-3.24,2.35-4.36,4.28-4.36c1.95,0,4.28,1.12,4.28,4.36c0,3.88-2.65,4.74-4.28,4.74
			S87.38,17.82,87.38,13.95z M94.9,13.99c0-2.85-1.63-3.42-3.24-3.42s-3.22,0.58-3.22,3.42c0,3.28,1.94,3.71,3.22,3.71
			S94.9,17.28,94.9,13.99z"/>
	</g>
</g>
</svg>
                
                </div>
            </div>
            
            <div class="full-line">
                <ul>
                    <li>
                        <b>Date of Joining</b>
                        <article>: </article><span>' . $joining_date . '</span>
                    </li>
                    <li>
                        <b>Employee ID</b>
                        <article>: </article><span>' . $employee_info->employee_code . '</span>
                    </li>
                    <li>
                        <b>Blood Group</b>
                        <article>: </article><span>' . $blood_group . '</span>
                    </li>
                    <li>
                        <b>Cell</b>
                        <article>: </article><span>' . $cell . '</span>
                    </li>
                    <li>
                        <b>Emg Contact</b>
                        <article>: </article><span>' . $Emg_cell . '</span>
                    </li>
                    <li>
                        <b>Email</b>
                        <article>: </article><span>' . $employee_info->official_email . '</span>
                    </li>
                    <li>
                        <b>Current Address</b>
                        <article>: </article><span>' . $address . '</span>
                    </li>
                    <li>
                        <b>Permanent Address</b>
                        <article>: </article><span>' . $permanent_address . '</span>
                    </li>
                </ul>
            </div>
            
            <div class="full-line">
                <div class="employee-card-note-portion">
                    Note: If you find the lost card,
                    please mail it to
                    <br>
                    Palm Breeze Tower,
                    Kohinoor Town, Faisalabad.
                </div>
            </div>
            
            <div class="full-line footer-icons">
                <svg version="1.1" x="0px" y="0px"
                viewBox="0 0 10 10"
                xml:space="preserve">
                    <g>
                        <g>
                            <path style="fill:#FFFFFF;" d="M9.74,7.34l-1.4-1.4c-0.5-0.5-1.35-0.3-1.55,0.35c-0.15,0.45-0.65,0.7-1.1,0.6c-1-0.25-2.35-1.55-2.6-2.6
			                c-0.15-0.45,0.15-0.95,0.6-1.1C4.34,3,4.54,2.15,4.04,1.65l-1.4-1.4c-0.4-0.35-1-0.35-1.35,0L0.35,1.2c-0.95,1,0.1,3.65,2.45,5.99
			                s4.99,3.45,5.99,2.45l0.95-0.95C10.09,8.29,10.09,7.69,9.74,7.34z"/>
                        </g>
                    </g>
                </svg>&nbsp;+92 41 539 0001&nbsp;&nbsp;
                <svg version="1.1" x="0px" y="0px"
                viewBox="0 0 10 10"
                xml:space="preserve">
                    <g>
                        <g>
                            <g>
                                <path style="fill:#FFFFFF;" d="M9.05,1.22H0.96c-0.2,0-0.29,0.25-0.14,0.38l3.94,3.24c0.14,0.12,0.34,0.12,0.48,
                                0C5.98,4.24,8.22,2.4,9.19,1.6C9.34,1.47,9.25,1.22,9.05,1.22z"/>
                            </g>
                        </g>
                        <g>
                            <g>
                                <path style="fill:#FFFFFF;" d="M5.23,6.2c-0.13,0.11-0.32,0.11-0.45,0L0.35,2.56C0.21,2.44,0,2.54,0,2.73v5.7c0,0.2,0.16,0.36,0.36,0.36
                                h9.29c0.2,0,0.36-0.16,0.36-0.36V2.78c0-0.18-0.21-0.28-0.35-0.17L5.23,6.2z"/>
                            </g>
                        </g>
                    </g>
                </svg>&nbsp;hr@medcaremso.com
            </div>
            
            <div class="full-line footer-icons text-center">
                <svg version="1.1" x="0px" y="0px"
                viewBox="0 0 10 10"
                xml:space="preserve">
                    <path style="fill:#FFFFFF;" d="M9.73,4.35C9.73,4.35,9.73,4.35,9.73,4.35L5.65,0.27C5.48,0.1,5.25,0,5,0C4.75,0,4.52,0.1,4.35,0.27L0.27,4.35
	                c0,0,0,0,0,0c-0.36,0.36-0.36,0.94,0,1.3c0.16,0.16,0.38,0.26,0.61,0.27c0.01,0,0.02,0,0.03,0h0.16v3C1.07,9.52,1.55,10,2.15,10h1.6
	                c0.16,0,0.29-0.13,0.29-0.29V7.35c0-0.27,0.22-0.49,0.49-0.49h0.94c0.27,0,0.49,0.22,0.49,0.49v2.35C5.96,9.87,6.09,10,6.26,10h1.6
	                c0.59,0,1.08-0.48,1.08-1.08v-3h0.15c0.25,0,0.48-0.1,0.65-0.27C10.09,5.29,10.09,4.71,9.73,4.35z"/>
	            </svg>&nbsp;www.medcaremso.com
	        </div>
	    </div>';

            $footer_buttons = '<a href="' . $admin_url . 'print/employee_card.php?printEmployeeCard=' . $employee_id . '" class="btn btn-sm btn-light-success font-weight-bold">Print</a>
                           <button type="button" class="btn btn-sm btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>';

            $data = ['code' => 200, 'data' => $data, 'footer_buttons' => $footer_buttons];
        } else {
            $data = ["code" => 405, "toasterClass" => 'warning', "responseMessage" => 'Sorry! You have no right to Preview Employee Card.'];
        }

        return $data;
    }
}

if (!function_exists('getSalaryGrade')) {
    function getSalaryGrade($salary, $department_id)
    {
        global $db;
        $company_id = $_SESSION['company_id'];
        $branch_id = $_SESSION['branch_id'];
        $return = [];

        $select = "SELECT band.name, grade.grade_name, grade.from, grade.to 
        FROM 
            salary_grade_details AS grade 
        INNER JOIN 
            salary_grades AS band 
            ON grade.salary_grade_id=band.id 
        WHERE '{$salary}' >= grade.from AND '{$salary}' <= grade.to 
        AND band.department_id='{$department_id}' AND band.company_id='{$company_id}' AND band.branch_id='{$branch_id}'
        ORDER BY grade.id ASC LIMIT 1";
        $query = mysqli_query($db, $select);
        if (mysqli_num_rows($query) > 0) {
            $return = mysqli_fetch_assoc($query);
        } else {
            $select = "SELECT band.name AS salary_band, grade.grade_name AS salary_grade, grade.from, grade.to 
            FROM 
                salary_grade_details AS grade 
            INNER JOIN 
                salary_grades AS band 
                ON grade.salary_grade_id=band.id 
            WHERE '{$salary}' >= grade.from AND '{$salary}' <= grade.to 
            AND band.department_id='0' AND band.company_id='{$company_id}' AND band.branch_id='{$branch_id}'
            ORDER BY grade.id ASC LIMIT 1";
            $query = mysqli_query($db, $select);
            if (mysqli_num_rows($query) > 0) {
                $return = mysqli_fetch_assoc($query);
            }
        }

        return $return;

    }
}

if (!function_exists('sendEmailVerificationEmail')) {
    function sendEmailVerificationEmail($employee_id)
    {
        global $base_url;

        $employeeInfo = getEmployeeInfoFromId($employee_id);
        $url = $base_url.'email_confirmation?signature='.$employeeInfo->signed_url.'&code='.$employeeInfo->verification_code.'&ei='.$employee_id;

        $subject = 'email_confirmation';
        $mail_body = getMailBody($subject, ['{mailToName}' => $employeeInfo->full_name, '{link}' => $url]);
        $parameters = [
            'subject' => $subject,
            'data' => [
                'email_body' => $mail_body['html'],
                'message' => $mail_body['message'],
            ],
            'mailTo' => [
                'email' => $employeeInfo->user_email,
                'name' => $employeeInfo->full_name,
            ]
        ];
        return sendEmail($parameters);
    }
}





?>