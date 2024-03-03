<?php

include 'top.php';

session_start();

if (!isset($_SESSION['usersId'])) {

  header("Location: http://localhost/user-management");
  exit;
}

include 'includes/header.php';

include_once 'includes/database.php';

if (isset($_POST) && !empty($_POST)) {

    $res = $database->insertMultiData('user_task', $_POST);

    // print_r($res);exit;
    if($res){

        header("Location: http://localhost/user-management/dashboard.php");
        exit;
    }
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
        <div id="addDiv">
            <div class="row">
                <div class="col-md-2">
                    <label for="startTime" class="form-label">Start Time</label>
                    <input type="datetime-local" name="startTime[]" class="form-control" id="startTime" required>
                </div>
                <div class="col-md-2">
                    <label for="stopTime" class="form-label">Stop Time</label>
                    <input type="datetime-local" name="stopTime[]" class="form-control" id="stopTime" required>
                </div>
                <div class="col-md-2">
                    <label for="notes" class="form-label">Notes</label>
                    <input type="text" name="note[]" class="form-control" id="notes" required>
                </div>
                <div class="col-md-2">
                    <label for="description" class="form-label">Description</label>
                    <input type="text" name="description[]" class="form-control" id="description" required>
                </div>
                <div class="col-md-2">
                    <label for="addMore" class="form-label">Add More</label>
                    <span class="form-control col-md-2 text-center" id="add_button">+</span>
                </div>
            </div>
        </div>
        <div class="mt-3">
            <button type="submit" class="btn btn-primary col-md-2">Submit</button>
        </div>
    </form>

    
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>


    $(document).ready(function() {
        $("#add_button").click(function() {

            var html = '<div class="row"><div class="col-md-2"> <label for="startTime" class="form-label">Start Time</label><input type="datetime-local" name="startTime[]" class="form-control" id="startTime" required></div><div class="col-md-2"><label for="stopTime" class="form-label">Stop Time</label><input type="datetime-local" name="stopTime[]" class="form-control" id="stopTime" required></div><div class="col-md-2"><label for="notes" class="form-label">Notes</label><input type="text" name="note[]" class="form-control" id="notes" required></div><div class="col-md-2"><label for="description" class="form-label">Description</label><input type="text" name="description[]" class="form-control" id="description" required></div><div class="col-md-2"><label for="addMore" class="form-label">Add More</label><span class="form-control col-md-2 remove_button text-center">-</span></div></div>';

            $("#addDiv").append(html);
        });

        $('#addDiv').on('click', '.remove_button', function() {
            $(this).parent('div').parent('div').remove();
        });

    });
</script>
<?php include 'includes/footer.php'; ?>