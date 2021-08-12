<?php
$f = 'font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;';
$h1 = 'display:block;margin:0;width:100%;';
$h2 = 'color:#777;display:block;font-size:11px;font-weight:300;letter-spacing:0.45px;line-height:18px;margin:10px 0 5px 0;width:100%;' . $f;
$h3 = 'display:block;margin:0;overflow:hidden;width:100%;';
$h4 = 'color:#222;display:block;font-size:12px;font-weight:600;letter-spacing:0.45px;line-height:18px;margin:25px 0 15px 0;width:100%;' . $f;
$h5 = 'color: #111;display:block;font-size:12px;font-weight:600;letter-spacing:0.45px;line-height:18px;margin:0 0 3px 0;width:100%;' . $f;
$h6 = 'color: #222;display:block;font-size:12px;font-weight:300;letter-spacing:0.45px;line-height:18px;margin:0 0 10px 0;width:100%;' . $f;
$p = 'color: #222;display:block;font-size:12px;font-weight:300;letter-spacing:0.45px;line-height:18px;margin:10px 0 0 0;width:100%;' . $f;
$span = 'color:#99CC00;display: inline-block;font-size: 11px;font-weight:400;letter-spacing:0.45px;line-height:18px;margin:0;vertical-align:middle;' . $f;
$table = 'color: #222;border-collapse: collapse;display: inline-table;font-size: 12px;font-weight: 300;letter-spacing: 0.15px;line-height: 18px;margin: 0;' . $f;
$td = ' color: #222; font-size: 12px; font-weight: 300; letter-spacing: 0.15px; padding: 3px 5px;' . $f;
$style = '<style>h1{' . $h1 . '}h2{' . $h2 . '}h3{' . $h3 . '}h4{' . $h4 . '}h5{' . $h5 . '}h6{' . $h6 . '}p{' . $p . '}span { ' . $span . '} table{' . $table . ' }table tr td{ ' . $td . ' } table tr td b{color: #111} h6 strong{color: #0a8cf0}</style>';
$h1 = ' style="' . $h1 . '"';
$h2 = ' style="' . $h2 . '"';
$h3 = ' style="' . $h3 . '"';
$h4 = ' style="' . $h4 . '"';
$h5 = ' style="' . $h5 . '"';
$h6 = ' style="' . $h6 . '"';
$p = ' style="' . $p . '"';
$span = ' style=" ' . $span . '"';
$table = ' style="' . $table . '"';
$td = ' style=" ' . $td . ' "';
$td_b = ' style="color: #222222;"';
$strong = ' style="color: #0a8cf0;"';

$array = [
    'email_confirmation' => [
        'email' => [
            'message' => 'Email verification link sent at your email address. Please check your inbox.',
            'html' => $style . '
            <h5 ' . $h5 . '> Hi {mailToName},</h5>
            <h6 ' . $h6 . '>Please click at below button and confirm your email.</h6>
            <p ' . $p . '>
                <a href="{link}">Confirm</a>.
            </p>',
        ],
        'notification' => [
            'message' => 'Email verification link sent at your email address.',
        ],
    ],
    'password_reset' => [
        'email' => [
            'message' => 'Your password has been changed, and sent at your email address. Please check your email.',
            'html' => $style . '
            <h5 ' . $h5 . '> Hi {mailToName},</h5>
            <h6 ' . $h6 . '>Your account\'s password has been changed, please find your new password below.</h6>
            <table border="1" cellspacing="0" ' . $table . '>
                <tr>
                    <td ' . $td . '><b ' . $td_b . '>E-mail</b></td>
                    <td>{mailTo}</td>
                </tr>
                <tr>
                    <td ' . $td . '><b ' . $td_b . '>New Password</b></td>
                    <td>{newPassword}</td>
                </tr>
            </table>
            <p ' . $p . '>
                For Login to your account please click <a href="' . $base_url . 'login">here</a>.
            </p>',
        ],
        'notification' => [
            'message' => 'Your password has been changed.',
        ],
    ],
    'evaluation_start' => [
        'email' => [
            'message' => 'Evaluation link successfully sent at "{mailTo}".',
            'html' => $style . '
            <h5 ' . $h5 . '> Hi {mailToName},</h5>
            <h6 ' . $h6 . '>Please check the link below and fill out <strong ' . $strong . '>{ResourceName}\'s</strong> Evaluation Form and inform HR After submission.</h6>
            <p ' . $p . '>
                Please click <a href="{link}">here</a>, and fill Form.
            </p>',
        ],
        'notification' => [
            'message' => 'Evaluation started for {employeeName}.',
        ],
    ],
    'evaluation_result_add' => [
        'email' => [
            'message' => 'Evaluation successfully submitted.',
            'html' => $style . '
            <h5 ' . $h5 . '> Hi {mailToName},</h5>
            <h6 ' . $h6 . '>There is a recent submission of <strong ' . $strong . '>{ResourceName}\'s</strong> Please check it on.</h6>
            <p ' . $p . '>
                Please click <a href="{link}">here</a>.
            </p>',
        ],
        'notification' => [
            'message' => 'Evaluation submitted by {employeeName}.',
        ],
    ],
];
//before the given date


if (!function_exists('getMailBody')) {
    function getMailBody($type, $template_variables=[])
    {
        global $array;
        $email = $array[$type]['email'];
        $msg = reflectTemplate($email['message'], $template_variables);
        $html = reflectTemplate($email['html'], $template_variables);
        return ['message' => $msg, 'html' => $html];
    }
}

if (!function_exists('getNotificationBody')) {

    function getNotificationBody($type, $template_variables=[])
    {
        global $array;
        $notification = $array[$type]['notification'];
        $msg = reflectTemplate($notification['message'], $template_variables);
        return ['message' => $msg];
    }
}

?>