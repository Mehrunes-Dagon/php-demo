<?php
include('./includes/header.php'); 
include('includes/functions.php');
require('includes/PDOConnection.php');

$db = new PDOConnection;

if (isset($_POST['submit_admin'])) {
    $clean_name = prepare_data($_POST['name']);
    $clean_gender = prepare_data($_POST['gender']);
    $clean_email = prepare_data($_POST['email']);
    $clean_password = prepare_data($_POST['password']);
    
    $hashed_password = hash_password($clean_password);

    $allowed_file_types = array('jpg', 'png', 'jpeg');
    $clean_image = $_FILES['image']['name'];
    $image_extension = pathinfo($clean_image, PATHINFO_EXTENSION);
    
    if (!in_array($image_extension, $allowed_file_types)) {
      echo alert_message(
          "Invalid file type. Must be in jpg, png or jprg format",
          'alert-danger'
      );     
    } else {
        handle_image($clean_image);
        
        $db->query("SELECT * FROM admin WHERE email = :email");
        $db->bind_value(':email', $clean_email);
        
        $user_exists = $db->fetch_one();
        
        if ($user_exists) {
            echo alert_message(
                "That user exists already.",
                'alert-danger'
            );
        } else {
            $db->query("INSERT INTO admin(id, fullname, email, password, gender, image) VALUES (NULL, :fullname, :email, :password, :gender, :image);");
            
            $db->bind_value(':fullname', $clean_name);
            $db->bind_value(':email', $clean_email);
            $db->bind_value(':password', $hashed_password);
            $db->bind_value(':gender', $clean_gender);
            $db->bind_value(':image', $clean_image);
            
            $user = $db->execute();

            if ($user) {
                echo alert_message(
                    "Registration successful. You may log in now.",
                    'alert-success'
                );
            } else {
                echo alert_message(
                    "Registration failed. Please try again.",
                    'alert-danger'
                );
            }
        } 
    }
}
?>

<div class="row">
  <div class="col-md-4 col-md-offset-4">
      <p class=""><a class="pull-right" href="../index.php"> Login</a></p><br>
  </div>
  <div class="col-md-4 col-md-offset-4">
    <form class="form-horizontal" role="form" method="post" action="register_admin.php" enctype="multipart/form-data">
      <div class="form-group">
        <label class="control-label col-sm-2" for="name"></label>
        <div class="col-sm-10">
          <input type="name" name="name" class="form-control" id="name" placeholder="Enter Full Name" required>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-2" for="gender"></label>
        <div class="col-sm-10">
          <select type="" name="gender" class="form-control" id="gender" >
            <option value="">Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
            <option value="Secret">N/A</option>
          </select>
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
        <label class="control-label col-sm-2" for="image"></label>
        <div class="col-sm-10">
          <input type="file" name="image" id="image" placeholder="Choose Image">
        </div>
      </div>

      <div class="form-group"> 
        <div class="col-sm-offset-2 col-sm-10">
          <div class="checkbox">
            <label><input type="checkbox" required> Accept Agreement</label>
          </div>
        </div>
      </div>

      <div class="form-group"> 
        <div class="col-sm-offset-2 col-sm-10 text-center">
          <button type="submit" class="btn btn-primary pull-right" name="submit_admin">Register</button>
          <a class="pull-left btn btn-danger" href="../index.php"> Cancel</a>
        </div>
      </div>
    </form>        
  </div>
</div>
<?php include('includes/footer.php'); ?>  