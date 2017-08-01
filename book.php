<?php
	session_start();
if(!isset($_SESSION['id']))
{
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
  <link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css">
  <script src="js/jquery-2.1.3.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/bootstrap-datetimepicker.min.js"></script>
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
		$query = "SELECT * FROM trips WHERE trip_id='".mysqli_real_escape_string($link,$_GET['trip'])."'";
		$result = mysqli_query($link,$query);
		$row = mysqli_fetch_array($result);

	?>

	<div class="row">
	  <form role="form" method="post">
        <div class="form-group col-xs-10 col-sm-6 col-md-6 col-lg-6">
            <label for="source">Source</label>
            <input readonly name="source" type="text" class="form-control" id="source" value="<?php echo $row['source']; ?>">
        </div>

        <div class="form-group col-xs-10 col-sm-6 col-md-6 col-lg-6">
            <label for="date_time">Date-Time of Trip</label>
            <input readonly name="date_time" type="text" class="form-control" id="date_time" value="<?php echo $row['date_time']; ?>">
        </div>

        <div class="clearfix"></div>
        <div class="form-group col-xs-10 col-sm-6 col-md-6 col-lg-6">
            <label for="via">Via</label>
            <input readonly name="via" type="text" class="form-control" id="via" value="<?php echo $row['via']; ?>">
        </div>
        <div class="clearfix"></div>
        <div class="form-group col-xs-10 col-sm-6 col-md-6 col-lg-6">
            <label for="destination">Destination</label>
            <input readonly name="destination" type="text" class="form-control" id="destination" value="<?php echo $row['destination']; ?>">
        </div>
        <div class="form-group col-xs-10 col-sm-6 col-md-6 col-lg-6">
            <label for="passengers">Number of Passengers</label>
            <input name="passengers" type="text" class="form-control" id="freespots" placeholder="Enter the Number of Passengers">
        </div>
        <div class="clearfix"></div>
        <input type="submit" name="submit" class="btn btn-success btn-bg margintop an" value="Book Ride" />
    </form>
    <div class="clearfix"></div>
    <br /><br />
	</div>

</div>

<?php
	
	if($_POST['submit']=="Book Ride")
	{

		// Check if the user filled the source
		if (!$_POST['source']) $error="<br />Please enter starting point of trip";

    	// Check if the user filled the date and time of trip
		if (!$_POST['date_time']) $error="<br />Please enter date and time of trip";

		// Check if the user filled a mid-point in the route
		if (!$_POST['via']) $error="<br />Please enter a mid-point in the route";

		// Check if the user filled the destination
		if (!$_POST['destination']) $error="<br />Please enter ending point of trip";

		// Check if the user filled the number of free spots
		if (!$_POST['passengers']) $error="<br />Please enter the number of passengers";

		if($_POST['passengers']>$row['free_spots']) $error="<br />Not enough free spots";

		// Check if any errors were encountered
		if ($error)
		{
			$error="There were error(s) in booking the trip:".$error;
			echo '<div class="alert alert-danger" style="text-align:center;">'.addslashes($error).'</div>';

		}

		// If no errors, proceed for registration
		else
		{	

			// Get the passenger id 
			$passenger_id=$_SESSION['id'];

			// Insert the details into the approval table
			$query1="INSERT INTO approvals(trip_id,user_id,driver_id,passengers) VALUES('".mysqli_real_escape_string($link,$row['trip_id'])."','".mysqli_real_escape_string($link,$passenger_id)."','".mysqli_real_escape_string($link,$row['driver_id'])."','".mysqli_real_escape_string($link,$_POST['passengers'])."')";

			// Execute the query
			mysqli_query($link,$query1);

			header("Location:user.php");
		}
	}

?>

</body>
</html>


