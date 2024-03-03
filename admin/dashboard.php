<?php
include '../top.php';

include 'includes/header.php';

include_once '../includes/database.php';

if (!isset($_SESSION['adminId'])) {

  header("Location: http://localhost/user-management/admin");
  exit;
}

$userData = $database->getallData('users');


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
    <h3>User Data</h3>
    <a class="btn btn-success" href="form.php">Add User</a>
  </div>

  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th scope="col">S no.</th>
        <th scope="col">First Name</th>
        <th scope="col">Last Name</th>
        <th scope="col">Email</th>
      </tr>
    </thead>
    <tbody>
      <?php $i = 1; foreach ($userData as $user) { ?>
        <tr>
          <th scope="row"><?php echo $i?></th>
          <td><?php echo $user[1]?></td>
          <td><?php echo $user[2]?></td>
          <td><?php echo $user[3]?></td>
        </tr>
      <?php $i++; } ?>
    </tbody> 
  </table>
</div>

<?php include 'includes/footer.php'; ?>