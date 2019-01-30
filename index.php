<?php
include('./admin/includes/header.php');
include('admin/includes/functions.php');
require('./admin/includes/PDOConnection.php');
    
$db = new PDOConnection;

if (isset($_POST['submit'])) {
  $clean_name = prepare_data($_POST['username']);
  $clean_password = prepare_data($_POST['password']);

  $hashed_password = hash_password($clean_password);

  $db->query('SELECT * FROM admin WHERE email=:email AND password=:password');
  
  $db->bind_value(':email', $clean_name);
  $db->bind_value(':password',$hashed_password);
  
  $user = $db->fetch_one();
  
  if ($user) {
    $display_name = $user['fullname'];
    $display_image = $user['image'];
    $display_image_tag = "<img src='./images/$display_image' class='profile_image' />"; 
      
    $_SESSION['user_data'] = array(
      'id' => $user['id'],
      'fullname' => $user['fullname'],
      'email' => $user['email'],
      'image' => $display_image_tag
    );
    $_SESSION['logged_in'] = true;
       
    store_message_in_session(
      alert_message(
        "Welcome back " . $display_name . "!",
        'alert-success'
      )
    );
    redirect_page('./admin/my_account.php');

  } else {
    echo alert_message(
      "That user does not exist.",
      'alert-danger'
    );
  }       
} 
 
?>
<div class="row">
  <div class="col-md-4 col-md-offset-4">
    <p class=""><a class="pull-right" href="admin/register_admin.php"> Register</a></p><br>
  </div>
  <div class="col-md-4 col-md-offset-4">
    <form class="form-horizontal" role="form" method="post" action="index.php">
      <div class="form-group">
        <label class="control-label col-sm-2" for="email"></label>
        <div class="col-sm-10">
          <input type="email" name="username" class="form-control" id="email" placeholder="Enter Email" required>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-2" for="password"></label>
        <div class="col-sm-10"> 
          <input type="password" name="password" class="form-control" id="password" placeholder="Enter Password" required>
        </div>
      </div>

      <div class="form-group"> 
        <div class="col-sm-offset-2 col-sm-10 text-center">
          <button type="submit" class="btn btn-primary text-center" name="submit">Login</button>
        </div>
      </div>
    </form>       
  </div>
</div>
<?php include('./admin/includes/footer.php'); ?>