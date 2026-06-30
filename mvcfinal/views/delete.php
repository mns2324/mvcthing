<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

require_once '../database.php';
require_once '../models/Employees.php';
require_once '../controllers/EmployeeController.php';

// create the db object, pass db into emp to get access to getConnection()
// pass empModel to empController, now the controller can use the model's functions!
$db = new Database();
$empModel = new Employees($db);
$empController = new EmployeeController($empModel);

if (isset($_GET["id"])) {
    $emp_id = $_GET["id"];

    $empController->deleteEmp($emp_id);

    if ($empController->deleteEmp($emp_id)) {
        $_SESSION['successMsg'] = "Employee $emp_id deleted successfully";
    } else {
        $_SESSION['errorMsg'] = "Failed to delete user";
    }
}

header("location: index.php");
exit;
?>