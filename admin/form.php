<?php

include 'includes/header.php';

include_once '../includes/database.php';

if (isset($_POST) && !empty($_POST)) {


    $res = $database->insertData('users', $_POST);

    header("Location: http://localhost/user-management/admin");
    exit;
}


if (!isset($_SESSION['adminId'])) {

    header("Location: http://localhost/user-management/admin");
    exit;
}
?>
<div class="container">
    <?php if (isset($_SESSION['success_message'])) {

    ?>
        <div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                <use xlink:href="#check-circle-fill" />
            </svg>
            <div>
                <?php echo $_SESSION['success_message'] ?>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div><?php
                unset($_SESSION['success_message']);
            } ?>
    <form class="m-5" action="#" method="POST">
        <div class="row">
            <div class="col-6">
                <label for="firstName" class="form-label">First Name</label>
                <input type="text" name="firstName" class="form-control" id="firstName" required>
            </div>
            <div class="col-6">
                <label for="lastName" class="form-label">Last Name</label>
                <input type="text" name="lastName" class="form-control" id="lastName" required>
            </div>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" name="email" class="form-control" id="email" required>
            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="number" name="phone" class="form-control" id="phone" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="password">
        </div>
        <div class="mb-3">
            <label for="confirm_password" class="form-label">Confirm Password</label>
            <input type="password" name="confirm_password" class="form-control" id="confirm_password">
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="autoPassword">
            <label class="form-check-label" for="autoPassword">Auto Generate Password</label>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
<?php include 'includes/footer.php'; ?>