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
<div class="container">
	<?php

		echo '<h2>Hi, '.$_SESSION['name'].'! Welcome to Carpooling !!</h2>';

	?>

	<div class="border row">
  		<div class="border col-md-3">
  			<h3>Create a Trip</h3>
  			<form class="navbar-form navbar-center" method="post">
				<input type="submit" name="submit" class="btn btn-success " value="Create"/>
			</form>
  		</div>
  		<div class="border col-md-3">
  			<h3>Search for a Trip</h3>
  			<form class="navbar-form navbar-center" method="post">
				<input type="submit" name="submit" class="btn btn-success " value="Search"/>
			</form>
  		</div>
		<div class="border col-md-3">
			<h3>Request for a Trip</h3>
			<form class="navbar-form navbar-center" method="post">
				<input type="submit" name="submit" class="btn btn-success " value="Request"/>
			</form>
		</div>
		<div class="border col-md-3">
			<h3>Requested Trips</h3>
			<form class="navbar-form navbar-center" method="post">
				<input type="submit" name="submit" class="btn btn-success " value="Requested Trips"/>
			</form>
		</div>
		<div class="border col-md-3">
			<h3>My Trips/Approvals</h3>
			<form class="navbar-form navbar-center" method="post">
				<input type="submit" name="submit" class="btn btn-success " value="View"/>
			</form>
		</div>
		<div class="border col-md-3">
			<h3>Rate Drivers</h3>
			<form class="navbar-form navbar-center" method="post">
				<input type="submit" name="submit" class="btn btn-success " value="Rate Drivers"/>
			</form>
		</div>
		<div class="border col-md-3">
			<h3>Rate Passengers</h3>
			<form class="navbar-form navbar-center" method="post">
				<input type="submit" name="submit" class="btn btn-success " value="Rate Passengers"/>
			</form>
		</div>
	</div>

	<?php

	if($_POST['submit']=="Create")
	{
		header("Location:create.php");
	}
	if($_POST['submit']=="Search")
	{
		header("Location:search.php");
	}
	if($_POST['submit']=="Request")
	{
		header("Location:request.php");
	}
	if($_POST['submit']=="Requested Trips")
	{
		header("Location:requested_trips.php");
	}
	if($_POST['submit']=="View")
	{
		header("Location:pending_approvals.php");
	}
	if($_POST['submit']=="Rate Drivers")
	{
		header("Location:rate_drivers.php");
	}
	if($_POST['submit']=="Rate Passengers")
	{
		header("Location:rate_passengers.php");
	}

	?>


</div>

</body>
</html>


