<?php
	session_start();
if(!isset($_SESSION['id'])){
	header("Location:index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Dashboard</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="js/jquery-2.1.3.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <style type="text/css">
	.container{
		text-align: center;
	}
	.red{
    color: red;
}
.borderround {
	border:1px solid #DEDEDE;
	border-radius: 10px;

}
.righticon {
	float: right;
	
}
.smallfont {
	font-size: .8em;
}
.navbar{
	position: relative;
}
.logoimg {
			float: left;
			margin-right: 20px; 
			margin-top: -5px;
		}
.clearicon {
	float:right;
	margin-right: 20px;
	
}	
.borderbottom {
margin: 0;
}
  </style>
</head>

<body>
	<div class="navbar navbar-default navbar-fixed-top">
	<div class="container">
		<div class="navbar-header pull-left">
			<div class="navbar-brand"><a href="user.php" class="linknone">Carpooling</a><a href="http://www.iitrpr.ac.in/" target="blank"><img class="logoimg" src="img/iitrpr.png" width="30px" height="30px"></a></div>
			
		</div>
		<div class="pull-right">
			<ul class="navbar-nav nav">
			<li><a href="edit_profile.php">Edit Profile</a></li>
			<li><a href="logout.php">Log Out</a></li>
			</ul>
			
		</div>
	</div>
	</div>

<?php 
	include("connection.php");
?>
<div class="container contentcontainer" id="topcontainer">
		<class="row">
			<div class="col-md-6 col-md-offset-3 am" id="toprow">
				<?php

					echo '<h2>Hi, '.$_SESSION['name'].'! Welcome to Carpooling !!</h2>';
					$user_id=$_SESSION['id'];
					$query="SELECT * FROM user WHERE user_id='".mysqli_real_escape_string($link,$user_id)."'";
					$result=mysqli_query($link,$query);
					$row=mysqli_fetch_array($result);

				?>
				<p class="lead">Edit Profile</p>
				
				<form class="margintop" method="post">
					<label for="name">Name</label>
					<div class="input-group">
						
						<span class="input-group-addon glyphicon glyphicon-user"></span>
						<input type="name" name="name" class="form-control" value="<?php echo $row['name']; ?>">
					</div>
					
					<label for="contact">Contact</label>
					<div class="input-group">
						
						<span class="input-group-addon glyphicon glyphicon-phone"></span>
						<input type="text" name="contact" class="form-control" value="<?php echo $row['contact']; ?>">
					</div>

					<label for="password">Password</label>
					<div class="input-group">
						
						<span class="input-group-addon glyphicon glyphicon-lock"></span>
						<input type="password" name="password" class="form-control" placeholder="Your Password"/>
					</div>

					<label for="repassword">Re-Enter Password</label>
					<div class="input-group">
						<span class="input-group-addon glyphicon glyphicon-lock"></span>
						<input type="password" name="repassword" class="form-control" placeholder="Re-Enter Your Password"/>
					</div>
					<br>
					<input type="submit" name="submit" class="btn btn-success btn-bg margintop an" value="Edit Profile" />
				</form>
			</div>
		</div>

<?php
	
	if($_POST['submit']=="Edit Profile")
	{


		// Check if the user entered the name
		if (!$_POST['name']) $error="<br />Please enter your name";

		// Check if the user filled an invalid name
		if (strlen($_POST['name'])>0 && strlen(trim($_POST['name']))==0) $error="<br />Please enter a valid name";

    	// Check if the user filled an invalid contact number
		if (!is_numeric($_POST['contact'])) $error="<br />Please enter a valid contact number";

		// Check if the user entered the password
		if (!$_POST['password']) $error="<br />Please enter your password";

		// Check if the user filled an invalid password
		if (strlen($_POST['password'])>0 && strlen(trim($_POST['password']))==0) $error="<br />Please enter a valid password";

		// Check if the passwords match
		if ($_POST['password']!=$_POST['repassword']) $error="<br />Passwords do not match";

		// Check if any errors were encountered
		if ($error)
		{
			$error="There were error(s) in editing your profile:".$error;
			echo '<div class="alert alert-danger" style="text-align:center;">'.addslashes($error).'</div>';

		}

		// If no errors, proceed for registration
		else
		{	
			$_SESSION['name']=$_POST['name'];
			$sql="UPDATE `user` SET `name`='".mysqli_real_escape_string($link,$_POST['name'])."', `contact`='".mysqli_real_escape_string($link,$_POST['contact'])."', `password`='".mysqli_real_escape_string($link,$_POST['password'])."' WHERE `user_id`='".mysqli_real_escape_string($link,$row['user_id'])."'";
			mysqli_query($link, $sql);		

			header("Location:user.php");
		}
	}

?>

</body>
</html>


