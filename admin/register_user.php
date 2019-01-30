<?php
include('includes/header.php');
include('includes/functions.php');
require('includes/PDOConnection.php');

$db = new PDOConnection;

if (isset($_POST['submit_customer'])) {
  $clean_name = prepare_data($_POST['name']);
  $clean_amount = prepare_data($_POST['amount']);
  $clean_email = prepare_data($_POST['email']);
  $clean_password = prepare_data($_POST['password']);
    
  $hashed_password = hash_password($clean_password);
    
  $db->query('SELECT * FROM  users WHERE email=:email');
  $db->bind_value(':email', $clean_email);

  $customer_exists = $db->fetch_one();
    
  if ($customer_exists) {  
    store_message_in_session(
      alert_message(
        "Customer already exists",
        'alert-danger'
      )
    );
    redirect_page('customers_list.php');
    } else {
    $db->query('INSERT INTO users (id, fullname, email, password, spending) VALUES (NULL, :fullname, :email, :password, :spending) ');

    $db->bind_value(':fullname', $clean_name);
    $db->bind_value(':email', $clean_email);
    $db->bind_value(':password', $hashed_password);
    $db->bind_value(':spending', $clean_amount);

    $customer = $db->execute();

    if ($customer) {
      store_message_in_session(
        alert_message(
        "Customer added successfully",
        'alert-success'
        )
      );
      redirect_page('customers_list.php');
    } else {
      store_message_in_session(
        alert_message(
        "Customer register failed",
        'alert-danger'
        )
      );
    }
  }
}
?>
 
<div class="row">
  <div class="col-md-4 col-md-offset-4">
      <p class="pull-right" style="color:#777"> Adding Customer in Database</p><br>
  </div>
  <div class="col-md-4 col-md-offset-4">
    <form class="form-horizontal" role="form" method="post" action="register_user.php">
      <div class="form-group">
        <label class="control-label col-sm-2" for="name"></label>
        <div class="col-sm-10">
          <input type="name" name="name" class="form-control" id="name" placeholder="Enter Full Name" required>
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-sm-2" for="salary"></label>
        <div class="col-sm-10">
          <input type="text" name="amount" class="form-control" id="country" placeholder="Enter Amount" required>
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-sm-2" for="email"></label>
        <div class="col-sm-10">
          <input type="email" name="email" class="form-control" id="email" placeholder="Enter Email" required>
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-sm-2" for="password"></label>
        <div class="col-sm-10"> 
          <input type="password" name="password" class="form-control" id="password" placeholder="Enter Password" required>
        </div>
      </div>

      <div class="form-group"> 
        <div class="col-sm-offset-2 col-sm-10">
          <div class="checkbox">
            <label><input type="checkbox" required> Accept</label>
          </div>
        </div>
      </div>

      <div class="form-group"> 
        <div class="col-sm-offset-2 col-sm-10 text-center">
          <button type="submit" class="btn btn-primary pull-right" name="submit_customer">Register</button>
          <a class="pull-left btn btn-danger" href="customers_list.php"> Cancel</a>
        </div>
      </div>
    </form>          
  </div>
</div>
<?php include('includes/footer.php'); ?>  