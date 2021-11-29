<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Docker sample app</title>
<link rel="stylesheet" href="css/style.css" />
</head>
<body>
<?php
   /*
   Author: VINEET KUMAR
    */
   # var_dump(getenv('MY_ENVVAR'));
   # $admin = getenv("mysql_db_name");
   #    echo $admin;
   define('DB_USERNAME',getenv('MYSQL_USERNAME'));
   define('DB_PASSWORD',getenv('MYSQL_PASSWORD'));
   define('DB_HOST',getenv('MYSQL_HOST'));
   define('DB_PORT',getenv('MYSQL_PORT'));
   define('DB_DATABASE',getenv('MYSQL_DATABASE'));
   #$host = GETENV('MYSQL_HOST');
   #$port = getenv('MYSQL_PORT');
   #$db   = $_ENV['MYSQL_USERNAME'];
   #$username = getenv('MYSQL_USERNAME');
   #echo $username;
   #$password = getenv('MYSQL_PASSWORD');
   #echo $host."<\br>".$db."<\br>".DB_USERNAME."<\br>".$password;
   $con = mysqli_connect(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
   #$con = mysqli_connect(localhost,tests,tests,register);
   // Check connection
   if (mysqli_connect_errno())
     {
     echo "Failed to connect to MySQL: " . mysqli_connect_error();
   }
	session_start();
    // If form submitted, insert values into the database.
    if (isset($_POST['username'])){
		
		$username = stripslashes($_REQUEST['username']); // removes backslashes
		$username = mysqli_real_escape_string($con,$username); //escapes special characters in a string
		$password = stripslashes($_REQUEST['password']);
		$password = mysqli_real_escape_string($con,$password);
		
	//Checking is user existing in the database or not
        $query = "SELECT * FROM `users` WHERE username='$username' and password='".md5($password)."'";
		$result = mysqli_query($con,$query) or die(mysqli_error());
		$rows = mysqli_num_rows($result);
        if($rows==1){
			$_SESSION['username'] = $username;
			header("Location: index.php"); // Redirect user to index.php
            }else{
				echo "<div class='form'><h3>Username/password is incorrect.</h3><br/>Click here to <a href='login.php'>Login</a></div>";
				}
    }else{
?>
<div class="form">
<h1>Log In</h1>
<form action="" method="post" name="login">
<input type="text" name="username" placeholder="Username" required />
<input type="password" name="password" placeholder="Password" required />
<input name="submit" type="submit" value="Login" />
</form>
<p>Not registered yet? <a href='registration.php'>Register Here</a></p>

<br /><br />
</div>
<?php } ?>


</body>
</html>
