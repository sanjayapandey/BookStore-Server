<?php
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
      }
      $count = mysql_num_rows($result);
      
      // If result matched $myusername and $mypassword, table row must be 1 row
      if($count == 1) {
         echo "success";
      }else{
	echo "incorrect";
}
   }else{
	echo "error";
   }
?>
