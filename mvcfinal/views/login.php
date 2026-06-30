<?php
// track user login status
session_start();
// redirect to index if already logged in
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) {
    header("Location: index.php");
    exit;
}

$errorMsg = "";

require_once '../database.php';
require_once '../models/SiteUsers.php';
require_once '../controllers/SiteUserController.php';

// create the db object, pass db into emp to get access to getConnection()
// pass empModel to empController, now the controller can use the model's functions!
$db = new Database();
$userModel = new SiteUsers($db);
$userController = new SiteUserController($userModel);


$username = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // check if username is empty
    if (empty(trim($_POST["username"]))) {
        $errorMsg = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // check if password is empty
    if (empty(trim($_POST["password"]))) {
        $errorMsg = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty($errorMsg)) {
        $user = $userController->getWebUserByName($username);

        // check if user exists and entered password matches that user's password
        if ($user && $password === $user["password"]) {
            // store data in session variables
            $_SESSION["logged_in"] = true;
            $_SESSION["site_id"] = $user["site_id"];
            $_SESSION["username"] = $username;
            $_SESSION['welcomeMsg'] = "Welcome, " . $_SESSION['username'] . "!";

            header("Location: index.php");
            exit;
        } else {
            $errorMsg = "Invalid username or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page for MVC Final</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</head>

<body class="bg-dark text-light">

    <?php
    if (!empty($errorMsg)) {
        // remember to use single quotes if adding html syntax inside echos
        echo "
        <div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong>$errorMsg</strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>    
        ";
    }
    ?>

    <div class="container my-5">
        <form method="post" class="mx-auto" style="max-width: 300px;">
            <h2 class="mb-4">Login Page</h2>

            <div class="mb-3">
                <label class="form-label" for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>

            <div class="mb-3">
                <label class="form-label" for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <button type="submit" class="btn btn-primary form-control" name="login"> Login </button>
        </form>
    </div>
</body>

</html>