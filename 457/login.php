<!DOCTYPE html>
<?php
	session_start();
	if(isset($_SESSION['username'])){
		header("Location: dashboard.php");
	}
   include("config.php");
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      $username = $_POST['username'];
      $password = $_POST['password']; 
      
      $sql = "SELECT customer_id FROM customer WHERE user_name = '$username' and password = '$password'";
      $result = mysql_query($sql);
      $count = 0;
      while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
      	$count = $count+1;
      	$_SESSION['username'] = $username;
      	$_SESSION['userid'] = $row['customer_id'];
      }
      $count = mysql_num_rows($result);
      
      // If result matched $myusername and $mypassword, table row must be 1 row
      if($count == 1) {
         header('Location: dashboard.php');
      }else {
        $_SESSION['error'] = "Username or password Incorrect! Please try again.";
      }
   }
?>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Book Store</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="css/bootstrap.min.css">  
  <link rel="stylesheet" href="css/bookstore.css">
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/ionicons.min.css">
  <link rel="stylesheet" href="css/skins/_all-skins.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <b>Book</b>Store
  </div>
  <div class="login-box-body">
    <p class="login-box-msg"><strong>Sign In</strong></p>

    <form action="" method="post">
	  	<?php if(!empty($_SESSION['error'])) {?>
	  		<div class="alert alert-danger">
	  	<?php
	  		echo $_SESSION['error']; 
	  	?>
	  		</div>
	  	<?php 
	  	} 
	  	unset($_SESSION['error']); ?>
	
      <div class="form-group has-feedback">
        <input type="text" name="username" class="form-control" placeholder="User Name">
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-4">
          <button type="submit" name="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
	<div class="col-xs-8">
		<a href="signup.html" class="btn btn-block btn-flat"> Create new account </a>
        </div>
      </div>
    </form>
  </div>
</div>
		
		  <div class="row">
		  	<div class="col-sm-2"></div>
		  	<div class="col-sm-8">
		  	<div class="panel panel-default">
						<div class="panel-body">
			  				<form action="#" method="GET">
			  					<input type="hidden" name="fileName" value="login.php">
			  					<input type="submit" class="btn btn-primary btn-flat pull-right" name="source" value="source">
			  				</form>
						</div>
				</div>
				<div class="panel panel-default">
						<h3>Page Source Code</h3>
					<div class="panel-body">
						<?php 
							if(isset($_GET['source']) && $_GET['source'] != ''){
								
								$file = fopen( $_GET['fileName'], "r" ) or	exit( "Unable to open file!" );
								while ( !feof( $file ) )
									highlight_string(fgets( $file ));
								fclose( $file );
							}
						?>
					</div>
				</div>
			</div>
			<div class="col-sm-2"></div>
		  </div>
</body>
</html>
