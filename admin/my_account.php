<?php
include('includes/header.php');
include('includes/functions.php');
require('includes/PDOConnection.php');

$db = new PDOConnection;
   
$db->query("SELECT * FROM admin WHERE email=:email");
$email = $_SESSION['user_data']['email'];
$db->bind_value(':email', $email);
    
$row = $db->fetch_one();
?>

<div class="well">  
  <a class="btn btn-primary pull-right btn-lg" href="customers_list.php">View Customers</a>
  <?php  
  $fullname = $_SESSION['user_data']['fullname'];
  echo '<small class="pull-left" style="color:#337ab7;">' . $fullname .'  | Viewing/Editing Profile</small>';
  ?>
  <h2 class="text-center">My Account</h2>
</div>

<div class="container"> 
  <div class="rows">
    <?php display_session_message(); ?>
      <div class="col-md-9">
        <?php  if($row) { ?><br>
          <form class="form-horizontal" role="form" method="post" action="">
            <div class="form-group">
              <label class="control-label col-sm-2" for="name" style="color:#f3f3f3;">Full Name:</label>
              <div class="col-sm-10">
                <input type="name" name="name" class="form-control" id="name" value="<?php echo $row['fullname'] ?>" required>
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
                <input type="password" name="password" class="form-control disabled" id="password" value="<?php echo $row['password'] ?>" required>
              </fieldset> 
              </div>
            </div>

            <div class="form-group"> 
              <div class="col-sm-offset-2 col-sm-10">
                <a class="btn btn-primary" href="edit_admin.php?id=<?php echo $row['id'] ?>">Edit</a>
                <button type="submit" class="btn btn-danger pull-right" name="delete_form">Delete</button>
              </div>
            </div>
          </form>       
      </div>
      <div class="col-md-3">
      <div style="padding: 20px;">
        <div class="thumbnail" >
          <a href="edit_admin.php?id=<?php echo $row['id'] ?>">
            <?php  $image = $row['image']; ?>
            <?php echo ' <img src="images/' . $image . '"  style="width:150px;height:150px">'; ?> 
          </a>
          <h4 class="text-center"><?php echo $fullname ?></h4>
        </div>
      </div>
    </div>
    <?php } ?> 
  </div>  
</div>

<?php             
  if (isset($_POST['delete_form'])) {
    $id = $_SESSION['user_data']['id'];

    $message = alert_message(
          "Are you sure you want to delete your account?
          <form method='post' action='my_account.php'>
            <input type='hidden' value='" . $id . " name='id'><br>
            <input class='btn btn-danger' type='submit' name='delete_admin' value='Confirm Delete'>
          </form>",
          'alert-danger'
    );
    store_message_in_session($message);
  }        

  if (isset($_POST['delete_admin'])) {
    $id = $_POST['id'];  
    $db->query('DELETE FROM admin WHERE id=:id');
    $db->bind_value(':id', $id);
      
    $admin = $db->execute();
      
    if ($admin) {
      redirect_page('logout.php');
    } else {
      store_message_in_session(
        alert_message(
          "User with ID ' . $id . ' Could not be deleted",
          'alert-danger'
        )
      );
    } 
  }           
?>
<?php include('includes/footer.php'); ?>