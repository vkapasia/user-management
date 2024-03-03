<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<?php

include 'includes/top.php';
session_start();

include_once 'database.php';


$actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]/user-management";

// echo $actual_link;exit;

if (isset($_POST) && !empty($_POST['logout'])) {

    unset($_SESSION['usersId']);
    $_SESSION["success_message"] = "Loged Out Successfully";
    header("Location: http://localhost/user-management/login.php");
    exit;
}

if (isset($_POST) && !empty($_POST['updatePassword'])) {

    if (empty($_POST['password'])) {
        header("Location: http://localhost/user-management/dashboard.php");
        exit;
    }
    $res = $database->updatePassword('users', $_POST);

    if ($res) {
        $_SESSION["success_message"] = "Password Updated Successfully";
        header("Location: http://localhost/user-management/dashboard.php");
        exit;
    } else {
        unset($_SESSION['usersId']);
        $_SESSION["success_message"] = "Something went wrong";
        header("Location: http://localhost/user-management/login.php");
        exit;
    }
}
if (isset($_SESSION['usersId'])) {
    $userId = $_SESSION['usersId'];
    $where = "id = $userId";
    $userData = $database->getDatawhere('users', $where);

    date_default_timezone_set("Asia/Kolkata");
    $currenttime = date("Y-m-d h:i:s");

    $lastTime = $userData[0][7];
    $date1 = strtotime("$lastTime");
    $date2 = strtotime("$currenttime");

    // Formulate the Difference between two dates
    $diff = abs($date2 - $date1);

    $days = floor(($diff - $years * 365 * 60 * 60 * 24 -
        $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));

    if($days >= '30'){?>
    <script>
            // A $( document ).ready() block.
            $(document).ready(function() {

                $('#staticBackdrop').modal('show');
            });
        </script>
    <?php }

    if (empty($userData[0][7])) { ?>
        <script>
            // A $( document ).ready() block.
            $(document).ready(function() {

                $('#staticBackdrop').modal('show');
            });
        </script>
<?php }
}

?>



<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Change Your Password</h5>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <form action="#" method="POST">
                <div class="modal-body">
                    <div class="mb-1">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm Password</label>
                        <input type="confirm_password" name="confirm_password" class="form-control" id="confirm_password" required>
                    </div>
                    <input type="hidden" name="updatePassword" value="updatePassword">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
    </symbol>
    <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
    </symbol>
    <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
    </symbol>
</svg>

<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid d-flex">
            <div>
                <a class="navbar-brand" href="#">Logo</a>
                <a class="navbar-brand" href="<?php echo $actual_link ?>/dashboard.php">Tasks</a>
            </div>
            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php echo $userData[0][1] ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <form action="#" method="post">
                            <input type="hidden" name="logout" value="logout">
                            <button class="dropdown-item" type="submit">Log Out</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>