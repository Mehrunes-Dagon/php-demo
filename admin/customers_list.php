<?php
include('includes/header.php');
include('includes/functions.php');
require('includes/PDOConnection.php');

$db = new PDOConnection;

$db->query('SELECT * FROM users');
$customers = $db->fetch_all();
?>

<div class="container">
  <?php display_session_message(); ?>
  <div class="jumbotron">
    <small class="pull-right"><a class="btn btn-primary" href="register_user.php">Add Customer</a></small>
    <?php echo $_SESSION['user_data']['fullname'] ?> | Customers
    <h2 class="text-center">Customers</h2><hr><br>
    <table class="table table-bordered table-hover text-center">
      <thead>
        <tr>
          <th class="text-center">ID</th>
          <th class="text-center">Full Name</th>
          <th class="text-center">Balance</th>
          <th class="text-center">Email</th>
          <th class="text-center">Password</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($customers as $customer) : ?>
        <tr>
          <td><?php echo $customer['id'] ?></td>
          <td><?php echo $customer['fullname'] ?></td>
          <td><?php echo $customer['spending'] ?></td>
          <td><?php echo $customer['email'] ?></td>
          <td><?php echo $customer['password'] ?></td>
          <td><a href="mailto:<?php echo $customer['email'] ?>" class='btn btn-info'>Message</a></td>
          <td><a href="edit_customer.php?cus_id=<?php echo $customer['id'] ?>" class='btn btn-warning'>Edit</a></td> 
        </tr>
        <?php endforeach ; ?>
      </tbody>
    </table>
  </div>
</div> 
<?php include('includes/footer.php'); ?>
