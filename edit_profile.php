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

				?>
				<p class="lead">Edit Profile</p>
				
				<form class="margintop" method="post">
					<label for="name">Name</label>
					<div class="input-group">
						
						<span class="input-group-addon glyphicon glyphicon-user"></span>
						<input type="name" name="name" class="form-control" placeholder="Your Name"/>
					</div>
					
					<label for="contact">Contact</label>
					<div class="input-group">
						
						<span class="input-group-addon glyphicon glyphicon-phone"></span>
						<input type="text" name="contact" class="form-control" placeholder="Your Contact Number"/>
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
</body>
</html>


