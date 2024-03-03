<?php

include 'top.php';

session_start();


if (!isset($_SESSION['usersId'])) {

  header("Location: http://localhost/user-management");
  exit;
}
include 'includes/header.php';

include_once 'includes/database.php';


$where = 'user_id = 1';

$taskData = $database->getDatawhere('user_task', $where);


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
  <div class="d-flex justify-content-between m-2">
    <h3>All Task</h3>
    <a class="btn btn-success" href="form.php">Add Task</a>
  </div>

  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th scope="col">S no.</th>
        <th scope="col">Start Time</th>
        <th scope="col">Stop Time</th>
        <th scope="col">Note</th>
        <th scope="col">Description</th>
      </tr>
    </thead>
    <tbody>
      <?php $i = 1; foreach ($taskData as $data) { ?>
        <tr>
          <th scope="row"><?php echo $i?></th>
          <td><?php echo $data[2]?></td>
          <td><?php echo $data[3]?></td>
          <td><?php echo $data[4]?></td>
          <td><?php echo $data[5]?></td>
        </tr>
      <?php $i++; } ?>
    </tbody> 
  </table>
</div>

<?php include 'includes/footer.php'; ?>