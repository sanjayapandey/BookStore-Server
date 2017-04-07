<!DOCTYPE html>
<html>
<?php
session_start();
if(!isset($_SESSION['username'])){
	header("Location: login.php");
}
include("config.php");
?>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Dashboard</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="css/bootstrap.min.css">  
  <link rel="stylesheet" href="css/bookstore.css">
  <link rel="stylesheet" href="css/my-css.css">
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/ionicons.min.css">
  <link rel="stylesheet" href="css/skins/_all-skins.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div id="wrapper">
 <!-- Sidebar -->
        
</div>
<div class="container">
		<div class="row">
			<div class="col-sm-2"></div>
			<div class="col-sm-7">
				<div class="login-logo">
					<b>Book </b>Store
				</div>
			</div>
			<div class="col-sm-3">
				<a href="cart.php" style="font-size: 25px;">
		          <span class="glyphicon glyphicon-shopping-cart">Cart</span>
		        </a>
		        <div class="pull-right">
			  	<a href = "profile.php"><i class="glyphicon glyphicon-user"></i>&nbsp;&nbsp; <strong><?php echo $_SESSION['username']?></strong></a>&nbsp;&nbsp;&nbsp;
			  	 <a href="logout.php" class="btn btn-danger btn-flat"> Logout </a>
			  	</div>
			  </div>
		</div>
   <!-- Small boxes (Stat box) -->
		  <div class="row">
			<div class="col-sm-2">
				<div id="sidebar-wrapper">
					<ul class="sidebar-nav">
						<li><a href="dashboard.php">Dashboard</a>
						</li>
						 <?php if($_SESSION['username'] == 'admin'){?>
						<li><a href="upload.php">Upload</a>
						</li>
						<li><a href="books.php">Books</a>
						</li>
						<li><a href="customers.php">Customer</a>
						</li>
						<?php }?>
					</ul>
				</div>
			</div>
			<div class="col-sm-8">
				<h2>Available Customers</h2>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Total Amount</th>
						</tr>
					</thead>
					<tbody>
					<?php 
					/**
					 * This configuration file includes database connection.
					 */
					include("config.php");
						
					//query to get all books
					$query = "SELECT customer_id, first_name, last_name,phone_number FROM customer ORDER BY first_name";
					$result = mysql_query($query);
					//iterate over all the rows

					while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
						?>
						<tr>
						<td>
						<?php 
						echo $row['customer_id'];
						?>
						</td>
						<td>
						<a href="customer.php?id=<?php echo $row['customer_id'];?>">
						<?php 
						echo $row['first_name']; echo " "; echo $row['last_name'];
						?>
						</a>
						</td>
						<td>
						<?php 
						//query to get all books
						$customer_id = $row['customer_id'];
						$query1 = "SELECT SUM(p.quantity*b.price) FROM purchase p, books b WHERE p.ISBN = b.ISBN AND p.customer_id = '$customer_id'";
						$result1 = mysql_query($query1);
						//iterate over all the rows
						
						while ($row = mysql_fetch_array($result1, MYSQL_ASSOC)) {
							echo round($row['SUM(p.quantity*b.price)'],2);
						}
						?>
						</td>
						</tr>
						<?php
					}
					?>
					</tbody>
				</table>
			</div>
		  </div>
		  <?php if($_SESSION['username'] == 'admin'){?>
		   <div class="row">
		  	<div class="col-sm-2"></div>
		  	<div class="col-sm-8">
		  	<div class="panel panel-default">
						<div class="panel-body">
							<a href="reset.php" class="btn btn-primary btn-flat pull-left"> Clear System </a>
			  				<form action="#" method="POST">
			  					<input type="hidden" name="fileName" value="customers.php">
			  					<input type="submit" class="btn btn-primary btn-flat pull-right" name="source" value="source">
			  				</form>
						</div>
				</div>
				<div class="panel panel-default">
						<h3>Page Source Code</h3>
					<div class="panel-body">
						<?php 
							if(isset($_POST['source']) && $_POST['source'] != ''){
								
								$file = fopen( $_POST['fileName'], "r" ) or	exit( "Unable to open file!" );
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
		  <?php }?>
		 </div>
</body>
</html>