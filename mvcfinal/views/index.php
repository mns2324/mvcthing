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
$employees = $empController->getAllEmps();

$errorMsg = "";
$successMsg = "";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Employee Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</head>

<body data-bs-theme="dark">
    <div class="container my-5">
        <?php
        if (!empty($_SESSION['successMsg'])) {
            echo "
            <div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong>{$_SESSION['successMsg']}</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
            </div>";

            unset($_SESSION['successMsg']); // important: clear it after showing       
        } elseif (!empty($_SESSION['welcomeMsg'])) {
            // should be shown only when first logging in 
            echo "
            <div class='alert alert-info alert-dismissible fade show' role='alert'>
                <strong>{$_SESSION['welcomeMsg']}</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>    
            ";

            unset($_SESSION['welcomeMsg']); // important: clear it after showing      
        }
        ?>

        <h2>List of Employees</h2><br>
        <div class="d-flex">
            <a class="btn btn-primary" href="create.php" role="button">Add New Employee</a>
            <!-- take all remaining space on left; push to right -->
            <a class="btn btn-danger ms-auto" href="logout.php" role="button">Logout</a>
        </div>
        <br>

        <table class="table table-dark table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Surname</th>
                    <th>Role</th>
                    <th>Payroll</th>
                    <th>Full Time</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($employees as $employee): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($employee['emp_id']); ?></td>
                        <td><?php echo htmlspecialchars($employee['firstname']); ?></td>
                        <td><?php echo htmlspecialchars($employee['surname']); ?></td>
                        <td><?php echo htmlspecialchars($employee['role']); ?></td>
                        <td><?php echo htmlspecialchars($employee['payroll']); ?></td>
                        <td><?php echo $employee['full_time'] ? 'Yes' : 'No'; ?></td>
                        <td class="text-center">
                            <a class="btn btn-primary btn-sm me-2"
                                href="update.php?id=<?php echo htmlspecialchars($employee['emp_id']); ?>">
                                Edit
                            </a>

                            <a class="btn btn-danger btn-sm"
                                href="delete.php?id=<?php echo htmlspecialchars($employee['emp_id']); ?>"
                                onclick="return confirm('Are you sure you want to delete employee #<?php echo htmlspecialchars($employee['emp_id']); ?>? This cannot be undone.');">
                                Delete
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>