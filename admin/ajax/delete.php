<?php
include_once('../../includes/connection.php');

$deleted_at = date('Y-m-d H:i:s');
$global_company_id = $_SESSION['company_id'];
$global_branch_id = $_SESSION['branch_id'];
$global_user_id = $_SESSION['user_id'];
global $db;

if (isset($_POST['delete_company']) && hasRight('company', 'delete')) {
    $delete = htmlentities($_POST['delete_company']);
    $query = mysqli_query($db, "SELECT id FROM employees WHERE company_id='{$delete}' AND deleted_at IS NULL");
    $number_of_record = mysqli_num_rows($query);
    if ($number_of_record == 0) {
        if (mysqli_query($db, "UPDATE `companies` SET `deleted_by`='{$global_user_id}', `deleted_at`='{$deleted_at}' WHERE `id`='{$delete}'")) {
            echo json_encode(["code" => 200, "toasterClass" => 'success', "responseMessage" => 'Record has been deleted.']);
        } else {
            echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'Unexpected error.']);
        }
    } else {
        echo json_encode(["code" => 422, "toasterClass" => 'warning', "responseMessage" => $number_of_record . ' Employee(s) exist in this Company.']);
    }
}

if (isset($_POST['delete_branch']) && hasRight('branch', 'delete')) {
    $delete = htmlentities($_POST['delete_branch']);
    $query = mysqli_query($db, "SELECT id FROM employees WHERE branch_id='{$delete}' AND deleted_at IS NULL");
    $number_of_record = mysqli_num_rows($query);
    if ($number_of_record == 0) {
        if (mysqli_query($db, "UPDATE `branches` SET `deleted_by`='{$global_user_id}', `deleted_at`='{$deleted_at}' WHERE `company_id`='{$global_company_id}' AND `id`='{$delete}'")) {
            echo json_encode(["code" => 200, "toasterClass" => 'success', "responseMessage" => 'Record has been deleted.']);
        } else {
            echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'Unexpected error.']);
        }
    } else {
        echo json_encode(["code" => 422, "toasterClass" => 'warning', "responseMessage" => $number_of_record . ' Employee(s) exist in this Branch.']);
    }
}

if (isset($_POST['delete_department']) && hasRight('department', 'delete')) {
    $delete = htmlentities($_POST['delete_department']);
    $query = mysqli_query($db, "SELECT id FROM employees WHERE department_id='{$delete}' AND deleted_at IS NULL");
    $number_of_record = mysqli_num_rows($query);
    if ($number_of_record == 0) {
        if (mysqli_query($db, "UPDATE `departments` SET `deleted_by`='{$global_user_id}', `deleted_at`='{$deleted_at}' WHERE `company_id`='{$global_company_id}' AND `branch_id`='{$global_branch_id}' AND `id`='{$delete}'")) {
            echo json_encode(["code" => 200, "toasterClass" => 'success', "responseMessage" => 'Record has been deleted.']);
        } else {
            echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'Unexpected error.']);
        }
    } else {
        echo json_encode(["code" => 422, "toasterClass" => 'warning', "responseMessage" => $number_of_record . ' Employee(s) exist in this Department.']);
    }
}

if (isset($_POST['delete_team']) && hasRight('team', 'delete')) {
    $delete = htmlentities($_POST['delete_team']);
    $query = mysqli_query($db, "SELECT id FROM employees WHERE team_id='{$delete}' AND deleted_at IS NULL");
    $number_of_record = mysqli_num_rows($query);
    if ($number_of_record == 0) {
        if (mysqli_query($db, "UPDATE `teams` SET `deleted_by`='{$global_user_id}', `deleted_at`='{$deleted_at}' WHERE `company_id`='{$global_company_id}' AND `branch_id`='{$global_branch_id}' AND `id`='{$delete}'")) {
            echo json_encode(["code" => 200, "toasterClass" => 'success', "responseMessage" => 'Record has been deleted.']);
        } else {
            echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'Unexpected error.']);
        }
    } else {
        echo json_encode(["code" => 422, "toasterClass" => 'warning', "responseMessage" => $number_of_record . ' Employee(s) exist in this Team.']);
    }
}

if (isset($_POST['delete_salary_grade']) && hasRight('salary_grade', 'delete')) {
    $delete = htmlentities($_POST['delete_salary_grade']);
    $query = mysqli_query($db, "SELECT `id` FROM `designations` WHERE `salary_grade_id`='{$delete}' AND deleted_at IS NULL");
    $number_of_record = mysqli_num_rows($query);
    if ($number_of_record == 0) {
        if (mysqli_query($db, "UPDATE `salary_grades` SET `deleted_by`='{$global_user_id}', `deleted_at`='{$deleted_at}' WHERE `company_id`='{$global_company_id}' AND `branch_id`='{$global_branch_id}' AND `id`='{$delete}'")) {
            echo json_encode(["code" => 200, "toasterClass" => 'success', "responseMessage" => 'Record has been deleted.']);
        } else {
            echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'Unexpected error.']);
        }
    } else {
        echo json_encode(["code" => 422, "toasterClass" => 'warning', "responseMessage" => 'This Salary Band (Grade) is already in use.']);
    }
}

if (isset($_POST['delete_designation']) && hasRight('designation', 'delete')) {
    $delete = htmlentities($_POST['delete_designation']);
    $query = mysqli_query($db, "SELECT id FROM employees WHERE designation_id='{$delete}' AND deleted_at IS NULL");
    $number_of_record = mysqli_num_rows($query);
    if ($number_of_record == 0) {
        if (mysqli_query($db, "UPDATE `designations` SET `deleted_by`='{$global_user_id}', `deleted_at`='{$deleted_at}' WHERE `company_id`='{$global_company_id}' AND `branch_id`='{$global_branch_id}' AND `id`='{$delete}'")) {
            echo json_encode(["code" => 200, "toasterClass" => 'success', "responseMessage" => 'Record has been deleted.']);
        } else {
            echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'Unexpected error.']);
        }
    } else {
        echo json_encode(["code" => 422, "toasterClass" => 'warning', "responseMessage" => 'This designation assigned to ' . $number_of_record . ' Employee(s).']);
    }
}

if (isset($_POST['delete_shift']) && hasRight('shift', 'delete')) {
    $delete = htmlentities($_POST['delete_shift']);
    $query = mysqli_query($db, "SELECT id FROM employees WHERE shift_id='{$delete}' AND deleted_at IS NULL");
    $number_of_record = mysqli_num_rows($query);
    if ($number_of_record == 0) {
        if (mysqli_query($db, "UPDATE `shifts` SET `deleted_by`='{$global_user_id}', `deleted_at`='{$deleted_at}' WHERE `company_id`='{$global_company_id}' AND `branch_id`='{$global_branch_id}' AND `id`='{$delete}'")) {
            echo json_encode(["code" => 200, "toasterClass" => 'success', "responseMessage" => 'Record has been deleted.']);
        } else {
            echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'Unexpected error.']);
        }
    } else {
        echo json_encode(["code" => 422, "toasterClass" => 'warning', "responseMessage" => 'This shift assigned to ' . $number_of_record . ' Employee(s).']);
    }
}

if (isset($_POST['delete_employee']) && hasRight('employee', 'delete')) {
    $delete = htmlentities($_POST['delete_employee']);
    if (mysqli_query($db, "UPDATE `employees` SET `deleted_by`='{$global_user_id}', `deleted_at`='{$deleted_at}' WHERE `id`='{$delete}'")) {
        echo json_encode(["code" => 200, "toasterClass" => 'success', "responseMessage" => 'Record has been deleted.']);
    } else {
        echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'Unexpected error.']);
    }
}

if (isset($_POST['delete_employee_image']) && hasRight('employee_image', 'delete')) {
    $filters = (object)$_POST['delete_employee_image'];
    $employee_id = $filters->id;
    $name = $filters->name;

    if (mysqli_query($db, "UPDATE `employee_images` SET `deleted_by`='{$global_user_id}', `deleted_at`='{$deleted_at}' WHERE `employee_id`='{$employee_id}' AND `name`='{$name}'")) {
        if (!empty($filters->name) && file_exists('../../storage/emp_images/' . $filters->name)) {
            unlink('../../storage/emp_images/' . $filters->name);
        }
        echo json_encode(["code" => 200, "toasterClass" => 'success', "responseMessage" => 'Record has been deleted.']);
    } else {
        echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'Unexpected error.']);
    }
}

if (isset($_POST['delete_employee_qualification'], $_POST['emp']) && hasRight('employee_qualification', 'delete')) {
    $id = htmlentities($_POST['delete_employee_qualification']);
    $employee_id = htmlentities($_POST['emp']);
    if (mysqli_query($db, "DELETE q FROM employee_qualification_infos AS q INNER JOIN employees AS e ON e.id=q.employee_id WHERE e.id = '{$employee_id}' AND q.id='{$id}' AND e.company_id='{$global_company_id}' AND e.branch_id='{$global_branch_id}'")) {
        echo json_encode(["code" => 200, "toasterClass" => 'success', "responseMessage" => 'Record has been deleted.']);
    } else {
        echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'Unexpected error.']);
    }
}

if (isset($_POST['delete_employee_experience'], $_POST['emp']) && hasRight('employee_experience', 'delete')) {
    $id = htmlentities($_POST['delete_employee_experience']);
    $employee_id = htmlentities($_POST['emp']);
    if (mysqli_query($db, "DELETE q FROM employee_experience_infos AS q INNER JOIN employees AS e ON e.id=q.employee_id WHERE e.id = '{$employee_id}' AND q.id='{$id}' AND e.company_id='{$global_company_id}' AND e.branch_id='{$global_branch_id}'")) {
        echo json_encode(["code" => 200, "toasterClass" => 'success', "responseMessage" => 'Record has been deleted.']);
    } else {
        echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'Unexpected error.']);
    }
}

if (isset($_POST['delete_employee_payroll'], $_POST['emp']) && hasRight('employee_payroll', 'delete')) {
    $id = htmlentities($_POST['delete_employee_payroll']);
    $employee_id = htmlentities($_POST['emp']);
    if (mysqli_query($db, "DELETE q FROM employee_payrolls AS q INNER JOIN employees AS e ON e.id=q.employee_id WHERE e.id = '{$employee_id}' AND q.id='{$id}' AND e.company_id='{$global_company_id}' AND e.branch_id='{$global_branch_id}'")) {
        echo json_encode(["code" => 200, "toasterClass" => 'success', "responseMessage" => 'Record has been deleted.']);
    } else {
        echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'Unexpected error.']);
    }
}

if (isset($_POST['delete_evaluation_type']) && hasRight('evaluation_type', 'delete')) {
    $delete = htmlentities($_POST['delete_evaluation_type']);
    $query = mysqli_query($db, "SELECT `id` FROM `evaluations` WHERE `evaluation_type_id`='{$delete}' AND deleted_at IS NULL");
    $number_of_record = mysqli_num_rows($query);
    if ($number_of_record == 0) {
        if (mysqli_query($db, "UPDATE `evaluation_types` SET `deleted_by`='{$global_user_id}', `deleted_at`='{$deleted_at}' WHERE `company_id`='{$global_company_id}' AND `branch_id`='{$global_branch_id}' AND `id`='{$delete}'")) {
            echo json_encode(["code" => 200, "toasterClass" => 'success', "responseMessage" => 'Record has been deleted.']);
        } else {
            echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'Unexpected error.']);
        }
    } else {
        echo json_encode(["code" => 422, "toasterClass" => 'warning', "responseMessage" => 'This Evaluation Type is already in use.']);
    }
}

if (isset($_POST['delete_default_evaluation_number_stack']) && hasRight('default_number_stack', 'delete')) {
    $delete = htmlentities($_POST['delete_default_evaluation_number_stack']);
    $default = config('evaluation_results.number_stack_is_default.value.default');
    if (!numberStackUsed($delete, $default)) {
        if (mysqli_query($db, "UPDATE `evaluation_default_number_stacks` SET `deleted_by`='{$global_user_id}', `deleted_at`='{$deleted_at}' WHERE `company_id`='{$global_company_id}' AND `branch_id`='{$global_branch_id}' AND `id`='{$delete}'")) {
            echo json_encode(["code" => 200, "toasterClass" => 'success', "responseMessage" => 'Record has been deleted.']);
        } else {
            echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'Unexpected error.']);
        }
    } else {
        echo json_encode(["code" => 422, "toasterClass" => 'warning', "responseMessage" => "This Number Stack attached with evaluation."]);
    }
}

if (isset($_POST['delete_evaluation_grading_policy']) && hasRight('grading_policy', 'delete')) {
    $delete = htmlentities($_POST['delete_evaluation_grading_policy']);
    if (mysqli_query($db, "UPDATE `evaluation_grading_policies` SET `deleted_by`='{$global_user_id}', `deleted_at`='{$deleted_at}' WHERE `company_id`='{$global_company_id}' AND `branch_id`='{$global_branch_id}' AND `id`='{$delete}'")) {
        echo json_encode(["code" => 200, "toasterClass" => 'success', "responseMessage" => 'Record has been deleted.']);
    }
    /*$query = mysqli_query($db, "SELECT id FROM employees WHERE shift_id='{$delete}' AND deleted_at IS NULL");
    $number_of_record = mysqli_num_rows($query);
    if ($number_of_record == 0) {
        if (mysqli_query($db, "UPDATE `shifts` SET `deleted_by`='{$global_user_id}', `deleted_at`='{$deleted_at}' WHERE `company_id`='{$global_company_id}' AND `branch_id`='{$global_branch_id}' AND `id`='{$delete}'")) {
            echo json_encode(["code" => 200, "toasterClass" => 'success', "responseMessage" => 'Record has been deleted.']);
        } else {
            echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'Unexpected error.']);
        }
    } else {
        echo json_encode(["code" => 422, "toasterClass" => 'warning', "responseMessage" => 'This shift assigned to ' . $number_of_record . ' Employee(s).']);
    }*/
}

if (isset($_POST['remove_employee_from_evaluation'])) {
    $delete = htmlentities($_POST['remove_employee_from_evaluation']);
    $evaluation_id = htmlentities($_POST['evaluation_id']);
    $query = mysqli_query($db, "SELECT `id` FROM `evaluation_details` WHERE `evaluation_id`='{$evaluation_id}'");
    $number_of_record = mysqli_num_rows($query);
    if ($number_of_record > 1) {
        $query2 = mysqli_query($db, "SELECT `id` FROM `evaluation_results` WHERE `evaluation_detail_id`='{$delete}'");
        $number_of_records = mysqli_num_rows($query2);
        if ($number_of_records == 0) {
            if (mysqli_query($db, "DELETE FROM `evaluation_details` WHERE `id` = '{$delete}'")) {
                echo json_encode(["code" => 200, "toasterClass" => 'success', "responseMessage" => 'Record has been deleted.']);
            } else {
                echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'Unexpected error.']);
            }
        } else {
            echo json_encode(["code" => 422, "toasterClass" => 'warning', "responseMessage" => "Evaluation result of this user already added."]);
        }
    } else {
        echo json_encode(["code" => 422, "toasterClass" => 'warning', "responseMessage" => "There should be at least one employee in evaluation."]);

    }
}

if (isset($_POST['delete_evaluation_number_stack']) && hasRight('number_stack', 'delete')) {
    $not_default = config('evaluation_results.number_stack_is_default.value.not_default');
    $delete = htmlentities($_POST['delete_evaluation_number_stack']);
    $query = mysqli_query($db, "SELECT `id` FROM `evaluation_results` WHERE `evaluation_number_stack_id`='{$delete}' AND `number_stack_is_default`='{$not_default}'");
    $number_of_record = mysqli_num_rows($query);
    if ($number_of_record == 0) {
        if (mysqli_query($db, "UPDATE `evaluation_number_stacks` SET `deleted_by`='{$global_user_id}', `deleted_at`='{$deleted_at}' WHERE `company_id`='{$global_company_id}' AND `branch_id`='{$global_branch_id}' AND `id`='{$delete}'")) {
            echo json_encode(["code" => 200, "toasterClass" => 'success', "responseMessage" => 'Record has been deleted.']);
        } else {
            echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'Unexpected error.']);
        }
    } else {
        echo json_encode(["code" => 422, "toasterClass" => 'warning', "responseMessage" => "This Number Stack attached with evaluation."]);

    }
}

if (isset($_POST['delete_default_evaluation_tasks']) && hasRight('evaluation_tasks', 'delete')) {
    $delete = htmlentities($_POST['delete_default_evaluation_tasks']);
    if (mysqli_query($db, "UPDATE `evaluation_default_questions` SET `deleted_by`='{$global_user_id}', `deleted_at`='{$deleted_at}' WHERE `company_id`='{$global_company_id}' AND `branch_id`='{$global_branch_id}' AND `id`='{$delete}'")) {
        echo json_encode(["code" => 200, "toasterClass" => 'success', "responseMessage" => 'Record has been deleted.']);
    }
}

?>