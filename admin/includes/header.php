<?php 
    ob_start();
    session_start();
?>
  
<html>
    <head>  
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Customer MGMT</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link href="/dashboard/amppapp/css/sb-admin.css" rel="stylesheet">
        <link href="/dashboard/amppapp/custom.css" rel="stylesheet">
    </head>

    <body>
        <nav class="navbar navbar-default navbar-fixed-top navbar-inverse">
            <div class="container-fluid" >
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.php" style="color: #f3f3f3">Customer MGMT</a>
                </div>

                <?php 
                    if(isset($_SESSION['logged_in'])) {
                        $fullname = $_SESSION['user_data']['fullname'];
                        $image = $_SESSION['user_data']['image']; 
                    } else {
                        $fullname = "new user";
                        $image = "";
                    }
                ?>
            
                <ul class="nav navbar-nav navbar-right">
                    <li class="navbar-text">Welcome, <?php echo $fullname ?> </li>
                    <?php if (isset($_SESSION['logged_in'])) { ?>
                        <li><a href="my_account.php"><strong>Account</strong></a></li>
                        <li><a href="logout.php"><strong>Sign-out</strong></a></li>
                    <?php } else { echo "<div />"; } ?>
                    <li><a href="#" ></b><?php echo $image; ?></a><li>
            </div>
        </nav>
        