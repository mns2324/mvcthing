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

$emp_id = "";
$errorMsg = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // get request: show that employee's details in the input boxes

    // check if id exists
    if (!isset($_GET['id'])) {
        header("location: /crudtest/index.php");
        exit;
    }

    // return null if id param in the url is null
    $emp_id = $_GET['id'] ?? null;
    $employee = $empController->getEmpById($emp_id);

    if (!$employee) {
        header("location: /crudtest/index.php");
        exit;
    }

    $firstname = $employee["firstname"];
    $surname = $employee["surname"];
    $role = $employee["role"];
    $payroll = $employee["payroll"];
    $full_time = $employee["full_time"];

} else {
    // post request: edit data then go back to index
    $emp_id = $_POST["id"];
    $firstname = $_POST['firstname'];
    $surname = $_POST['surname'];
    $role = $_POST['role'];
    $payroll = $_POST['payroll'];
    $full_time = $_POST['full_time'];

    // pass the user inputs to the controller for validation
    $result = $empController->updateEmp($emp_id, $firstname, $surname, $role, $payroll, $full_time);

    // if validated, redirect to index and display the success message
    if ($result['success']) {
        $_SESSION['successMsg'] = "Employee $emp_id updated successfully.";
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
    <title>Update Employee Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</head>

<body class="bg-dark text-light">
    <div class="container my-5">
        <h2>Update Employee <?php echo htmlspecialchars($emp_id); ?>'s details</h2><br>
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
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($emp_id); ?>">

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">First Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="firstname" placeholder="Type here"
                        value="<?php echo htmlspecialchars($firstname); ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Surname</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="surname" placeholder="Type here"
                        value="<?php echo htmlspecialchars($surname); ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Role</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="role" placeholder="Type here"
                        value="<?php echo htmlspecialchars($role) ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Salary</label>
                <div class="col-sm-6">
                    <input type="number" step="0.01" class="form-control" name="payroll" placeholder="999999.99 (MAX)"
                        value="<?php echo htmlspecialchars($payroll); ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">
                    Is this employee full-time?
                </label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="full_time" placeholder="Yes or No"
                        value="<?php echo htmlspecialchars($full_time); ?>">
                </div>
            </div>

            <div class="row mb-3">
                <div class="offset-3 col-3 d-grid">
                    <button type="Submit" class="btn btn-outline-warning"
                        onclick="return confirm('Confirm again to update employee #<?php echo $emp_id ?>\'s details.');">Update</button>
                </div>
                <div class=" col-3 d-grid">
                    <a class="btn btn-outline-primary" href="index.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>

</body>

</html>