<?php
include '../top.php';

include 'includes/header.php';

include_once '../includes/database.php';

if (!isset($_SESSION['adminId'])) {

  header("Location: http://localhost/user-management/admin");
  exit;
}

$taskData = $database->getallData('user_task');


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
    <h3>Task Data</h3>
    <!-- <button class="btn btn-success">Download CSV</button> -->
    <a class="btn btn-success" href="<?php echo $actual_link ?>/admin/csv.php">Download CSV</a>
  </div>

  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th scope="col">S no.</th>
        <th scope="col">User Name</th>
        <th scope="col">Start Time</th>
        <th scope="col">Stop Time</th>
        <th scope="col">Note</th>
        <th scope="col">Description</th>
      </tr>
    </thead>
    <tbody>
      <?php $i = 1; foreach ($taskData as $task) { 

        $where = "id = $task[1]";

        $taskData = $database->getDatawhere('users', $where);
        ?>
        <tr>
          <th scope="row"><?php echo $i?></th>
          <td><?php echo $taskData[0][1]?></td>
          <td><?php echo $task[2]?></td>
          <td><?php echo $task[3]?></td>
          <td><?php echo $task[4]?></td>
          <td><?php echo $task[5]?></td>
        </tr>
      <?php $i++; } ?>
    </tbody> 
  </table>
</div>

<?php include 'includes/footer.php'; ?>