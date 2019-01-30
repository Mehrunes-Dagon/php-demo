<?php 
include('includes/header.php');
include('includes/functions.php');
require('includes/PDOConnection.php');
include './includes/ChromePhp.php';

$db = new PDOConnection;

if(isset($_GET['cus_id'])){
  $customer_id = $_GET['cus_id'];
}

$db->query("SELECT * FROM users WHERE id=:id");
$db->bind_value(':id', $customer_id);
$row = $db->fetch_one();
?>

<div class="well">
  <small class="pull-right"><a class="btn btn-primary" href="customers_list.php">View Customers</a></small>
  <?php    
  echo '<small class="pull-left" style="color:#337ab7;">' . $_SESSION['user_data']['fullname'] . ' | Editing Customer</small>';
  ?>
  <h2 class="text-center">My Customers</h2>
</div>
   
<div class="rows">
  <?php display_session_message(); ?>
  <div class="col-md-6 col-md-offset-3">
    <?php  if($row) : ?><br>
      <form class="form-horizontal" role="form" method="post" action="edit_customer.php?cus_id=<?php echo $customer_id ?>">
        <div class="form-group">
          <label class="control-label col-sm-2" for="name" style="color:#f3f3f3;">Fullname:</label>
          <div class="col-sm-10">
            <input type="name" name="name" class="form-control" id="name" value="<?php echo $row['fullname'] ?>" required>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="country" style="color:#f3f3f3;">Amount:</label>
          <div class="col-sm-10">
            <input type="country" name="amount" class="form-control" id="country" value="<?php echo $row['spending'] ?>" required>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="email" style="color:#f3f3f3;">Email:</label>
          <div class="col-sm-10">
            <input type="email" name="email" class="form-control" id="email" value="<?php echo $row['email'] ?>" required>
          </div>
        </div>
        <div class="form-group ">
          <label class="control-label col-sm-2" for="password" style="color:#f3f3f3;">Password:</label>
          <div class="col-sm-10">
            <fieldset disabled> 
              <input type="password" name="password" class="form-control disabled" id="password" placeholder="Cannot Change Password" value="<?php echo $row['password'] ?>" required>
            </fieldset> 
          </div>
        </div>
        <div class="form-group"> 
          <div class="col-sm-offset-2 col-sm-10">
            <input type="submit" class="btn btn-primary" name="edit_customer" value="Update">
            <button type="submit" class="btn btn-danger pull-right" name="delete_customer">Delete</button>
          </div>
        </div>  
      </form>
    <?php endif ;  ?>  
  </div>
</div>  

<?php 
if (isset($_POST['edit_customer'])) {
  $clean_name = prepare_data($_POST['name']);
  $clean_amount = prepare_data($_POST['amount']);
  $clean_email = prepare_data($_POST['email']);
    
  $db->query('UPDATE users SET fullname=:fullname, email=:email, spending=:amount WHERE id=:id');
    
  $db->bind_value(':id',$customer_id );
  $db->bind_value(':fullname',$clean_name );
  $db->bind_value(':email',$clean_email );
  $db->bind_value(':amount',$clean_amount );
  
  $customer_update = $db->execute();
  
  if ($customer_update) {     
    store_message_in_session(
      alert_message(
        "Customer updated successfully",
        'alert-success'
      )
    );
  } else { 
    store_message_in_session(
      alert_message(
        "Customer update failed",
        'alert-danger'
      )
    );
  }  

  redirect_page('customers_list.php');    
}

// DELETE CUSTOMER BUG

if (isset($_POST['delete_customer'])) {
  store_message_in_session(
    alert_message(
      "Are you sure you want to delete this customer?
      <form method='post' action='edit_customer.php'>
        <input type='hidden' value='" . $customer_id . "' name='id'>
        <input class='btn btn-danger' type='submit' name='confirm_delete_user' value='Confirm Delete' >
      </form>",
      'alert-danger'
    )
  );
}    

if (isset($_POST['confirm_delete_user'])) {   
  $id = $_POST['cus_id']; 
  ChromePhp::log("YOYOY");

  $db->query('DELETE FROM users WHERE id=:id'); 
  $db->bind_value(':id', $id);

  $run_delete = $db->execute();

  if ($run_delete) {
    redirect_page('customers_list.php');
    store_message_in_session(
      alert_message(
          "Customer has been deleted successfully!!",
          'alert-success'
        )
    );
  }else {
    store_message_in_session(
      alert_message(
        "Unable to delete customer with ID $id.",
        'alert-danger'
      )
    );
  }
}  
?>
<?php include('includes/footer.php'); ?>