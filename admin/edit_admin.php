<?php 
  include('includes/header.php');
  include('includes/functions.php');
  require('includes/PDOConnection.php');

  $db = new PDOConnection;

    if (isset($_GET['id'])) {
      $id = $_GET['id'];
    }

  $db->query("SELECT * FROM admin WHERE id =:id");
  $db->bind_value(':id', $id);

  $row = $db->fetch_one();
?>
    
<div class="row">
  <div class="col-md-4 col-md-offset-4"></div>
  <div class="col-md-4 col-md-offset-4">
    <form class="form-horizontal" role="form" method="post" action="<?php $_SERVER["PHP_SELF"]; ?>" enctype="multipart/form-data">
      <?php if($row) : ?>

        <div class="form-group">
          <label class="control-label col-sm-2" for="name"></label>
          <div class="col-sm-10">
            <input type="name" name="name" class="form-control" id="name" value="<?php echo $row['fullname'] ?>" required>
          </div>
        </div>
      
        <div class="form-group">
          <label class="control-label col-sm-2" for="email"></label>
          <div class="col-sm-10">
            <input type="email" name="username" class="form-control" id="email" value="<?php echo $row['email'] ?>" required>
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
          <label class="control-label col-sm-2" for="password"></label>
          <div class="col-sm-10"> 
            <input type="password" name="password" class="form-control" id="password" placeholder="Confirm Password" value="" required>
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2" for="image"></label>
          <div class="col-sm-10">
            <input type="file" name="image" id="image" placeholder="Choose Image">
          </div>
        </div>

        <div class="form-group"> 
          <div class="col-sm-offset-2 col-sm-10 text-center">
            <button type="submit" class="btn btn-primary pull-right" name="submit_update">Update</button>
            <a class="pull-left btn btn-danger" href="my_account.php">Cancel</a>
          </div>
        </div>
      
      <?php endif; ?>
    </form>
          
    <?php
      if (isset($_POST['submit_update'])) {
          $clean_name = prepare_data($_POST['name']);
          $clean_gender = prepare_data($_POST['gender']);
          $clean_email = prepare_data($_POST['username']);
          $clean_password = prepare_data($_POST['password']);
          
          $hashed_password = hash_password($clean_password);
          
          $clean_image = $_FILES['image']['name'];
          handle_image($clean_image);
        
          $db->query("UPDATE admin SET fullname=:fullname, email=:email, password=:password, gender=:gender,image=:image");
          
          $db->bind_value(':fullname', $clean_name);
          $db->bind_value(':gender', $clean_gender);
          $db->bind_value(':email', $clean_email);
          $db->bind_value(':password', $hashed_password);
          $db->bind_value(':image', $clean_image);
          
          $user = $db->execute();
        
          if ($user) {
            store_message_in_session(
              alert_message(
                "Update was successful",
                'alert-success'
              )
            );
            redirect_page('my_account.php');
          } else {
            store_message_in_session(
              alert_message(
                "Update failed!",
                'alert-danger'
              )
            );
            redirect_page('my_account.php');
          }    
        }
    ?>
  </div>
</div>        
<?php include('includes/footer.php'); ?>  