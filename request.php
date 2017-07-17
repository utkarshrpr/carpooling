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

	<div class="row">
	  <form role="form" method="post">
        <div class="form-group col-xs-10 col-sm-6 col-md-6 col-lg-6">
            <label for="source">Source</label>
            <input name="source" type="text" class="form-control" id="source" placeholder="Enter Starting Point of Trip">
        </div>
        <div class="form-group col-xs-10 col-sm-6 col-md-4 col-lg-6">
            <label for="date_time">Date-Time</label>
            <input name="date_time" type="text" class="form-control" id="date" placeholder="Enter Date and Time of Trip">
        </div>
        <div class="clearfix"></div>
        <div class="form-group col-xs-10 col-sm-6 col-md-6 col-lg-6">
            <label for="destination">Destination</label>
            <input name="destination" type="text" class="form-control" id="destination" placeholder="Enter Ending Point of Trip">
        </div>
        <div class="form-group col-xs-10 col-sm-6 col-md-6 col-lg-6">
            <label for="passengers">Number of Passengers</label>
            <input name="passengers" type="text" class="form-control" id="passengers" placeholder="Enter the Number of Passengers">
        </div>
        <div class="clearfix"></div>
        <input type="submit" name="submit" class="btn btn-success btn-bg margintop an" value="Request Trip" />
    </form>
    <div class="clearfix"></div>

    <br /><br />
	</div>

</div>

<?php
	
	if($_POST['submit']=="Request Trip")
	{

		// Check if the user filled the source
		if (!$_POST['source'])$error.="<br />Please enter starting point of trip";

    	// Check if the user filled the date and time of trip
		if (!$_POST['date_time']) $error=$error."<br />Please enter date and time of trip";

		// Check if the user filled the destination
		if (!$_POST['destination']) $error=$error."<br />Please enter ending point of trip";

		// Check if the user filled the number of free spots
		if (!$_POST['passengers']) $error=$error."<br />Please enter the number of passengers";

		// Check if any errors were encountered
		if ($error)
		$error="There were error(s) in requesting the trip:".$error;

		// If no errors, proceed for registration
		else
		{	

			// Get the driver id 
			$requestuser_id=$_SESSION['id'];

			// Insert the details entered by the user in the database
			$query="INSERT INTO request(source,destination,passengers,date_time,requestuser_id) VALUES('".mysqli_real_escape_string($link,$_POST['source'])."','".mysqli_real_escape_string($link,$_POST['destination'])."','".mysqli_real_escape_string($link,$_POST['passengers'])."','".mysqli_real_escape_string($link,$_POST['date_time'])."','".mysqli_real_escape_string($link,$requestuser_id)."')";

			// Execute the query
			mysqli_query($link,$query);

		}
	}

?>

</body>
</html>


