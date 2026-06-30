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

$errorMsg = "";
$successMsg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // pass the user inputs to the controller for validation
    $result = $empController->createEmp(
        $_POST['firstname'],
        $_POST['surname'],
        $_POST['role'],
        $_POST['payroll'],
        $_POST['full_time']
    );

    // if validated, redirect to index and display the success message
    if ($result['success']) {
        $_SESSION['successMsg'] = "Employee added successfully";
        header("Location: index.php");
        exit;
    }

    $errorMsg = $result['message'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MVC Final</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</head>

<body data-bs-theme="dark">
    <div class="container my-5">
        <h2>Add a new Employee</h2>
        <?php
        if (!empty($errorMsg)) {
            // remember to use single quotes if adding html syntax inside echos
            echo "
            <div class='alert alert-warning alert-dismissible fade show col-5' role='alert'>
                <strong>$errorMsg</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>    
            ";
        }
        ?>

        <form method="post">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">First Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="firstname" placeholder="Type here">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Surname</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="surname" placeholder="Type here">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Role</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="role" placeholder="Type here">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Salary</label>
                <div class="col-sm-6">
                    <input type="number" step="0.01" class="form-control" name="payroll" placeholder="999999.99 (MAX)">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">
                    Is this employee full-time?
                </label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="full_time" placeholder="Yes or No">
                </div>
            </div>

            <div class="row mb-3">
                <div class="offset-3 col-3 d-grid">
                    <button type="Submit" class="btn btn-outline-success">Create</button>
                </div>
                <div class=" col-3 d-grid">
                    <a class="btn btn-outline-primary" href="index.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>

</html>