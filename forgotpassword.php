<?php 
	session_destroy();
	include("connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Forgot Password</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="js/jquery-2.1.3.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
<style>
	.navbar {
		position:relative;
	}
	.center {
		text-align: center;
	}
	.logoimg {
			float: left;
			margin-right: 20px; 
			margin-top: -5px;
		}
	.linknone,.linknone:hover,.linknone:visited,.linknone:active,.linknone:link {
					text-decoration:none;
					color: #777;
	}
</style>
</head>

<body>
	<div class="navbar navbar-default navbar-fixed-top">
	<div class="container">
		<div class="navbar-header pull-left">
			<div class="navbar-brand"><a href="index.php" class="linknone">Carpooling</a><a href="http://www.iitrpr.ac.in/" target="blank"><img class="logoimg" src="img/iitrpr.png" width="30px" height="30px"></a></div>

		</div>
		</div>
	</div>
	
	<div class="container">
		<div class="row center" > 
			<div class="col-md-6 col-md-offset-3">
			<h3>An email will be sent to this address including further steps</h3>
			<form class="sendmail" method="post">
			<label for="email"></label>
			<div class="input-group">
				<span class="input-group-addon">&#64;</span>
				<input name="email" type="email" placeholder="Your registered email" class="form-control" >
			</div>

			<br>
			<input type="submit" name="submit" class="btn btn-success btn-bg margintop an" value="Send" />		
			<br>
      	</form>

 </div>
	</div>
</div>

<?php 
	
	if($_POST['submit']=="Send")
	{
		$sql = "SELECT name FROM user WHERE email='".mysqli_real_escape_string($link,$_POST['email'])."'";
		$resultsql = mysqli_query($link,$sql);
		$rowsql = mysqli_fetch_array($resultsql);

		if(!$rowsql['name']) $error="<br />The e-mail you entered is not registered !!";
		if(!$_POST['email']) $error="<br />Please enter your e-mail address !!";

		if ($error)
		{
			$error="There were error(s) in resetting your password:".$error;
			echo '<div class="alert alert-danger" style="text-align:center;">'.addslashes($error).'</div>';

		}

		else
		{
			$password = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890"), -7);
			$dup_password=$password;
			
			$sq="UPDATE `user` SET `password`='".mysqli_real_escape_string($link,md5($password))."' WHERE `email`='".mysqli_real_escape_string($link,$_POST['email'])."'";
			mysqli_query($link, $sq);

			$to = $_POST['email'];
			$subject = "Reset password for Carpooling";
			$txt = "Hello ".$rowsql['name'].","."\r\n";
			$txt.= "Your new password is: ".$dup_password."\r\n";
			$txt.= "Kindly change it by logging in and editing your profile from Edit Profile section.";
			$headers = "From: utkarshchauhan007@gmail.com";

			mail($to,$subject,$txt,$headers);
			header("Location:index.php");
		}
	}

?>
</body>
</html>