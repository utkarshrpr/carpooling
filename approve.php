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
		$query1 = "SELECT * FROM trips WHERE trip_id='".mysqli_real_escape_string($link,$_GET['trip_id'])."'";
		$result1 = mysqli_query($link,$query1);
		$row1 = mysqli_fetch_array($result1);
		$query2 = "SELECT name FROM user WHERE user_id='".mysqli_real_escape_string($link,$_GET['user_id'])."'";
		$result2 = mysqli_query($link,$query2);
		$row2 = mysqli_fetch_array($result2);

	?>

	<div class="row">
	  <form role="form" method="post">
        <div class="form-group col-xs-10 col-sm-6 col-md-6 col-lg-6">
            <label for="source">Source</label>
            <input readonly name="source" type="text" class="form-control" id="source" value="<?php echo $row1['source']; ?>">
        </div>
        <div class="form-group col-xs-10 col-sm-6 col-md-6 col-lg-6">
            <label for="date_time">Date-Time of Trip</label>
            <input readonly name="date_time" type="text" class="form-control" id="date_time" value="<?php echo $row1['date_time']; ?>">
        </div>
        <div class="clearfix"></div>
        <div class="form-group col-xs-10 col-sm-6 col-md-6 col-lg-6">
            <label for="destination">Destination</label>
            <input readonly name="destination" type="text" class="form-control" id="destination" value="<?php echo $row1['destination']; ?>">
        </div>
        <div class="form-group col-xs-10 col-sm-6 col-md-6 col-lg-6">
            <label for="passengers">Number of Passengers</label>
            <input readonly name="passengers" type="text" class="form-control" id="passengers" value="<?php echo $_GET['passengers']; ?>">
        </div>
        <div class="clearfix"></div>
        <div class="form-group col-xs-10 col-sm-6 col-md-6 col-lg-6">
            <label for="user">Booked By</label>
            <input readonly name="user" type="text" class="form-control" id="user" value="<?php echo $row2['name']; ?>">
        </div>
        <div class="form-group col-xs-10 col-sm-6 col-md-6 col-lg-6">
            <label for="freespots">Free Spots</label>
            <input readonly name="freespots" type="text" class="form-control" id="freespots" value="<?php echo $row1['free_spots']; ?>">
        </div>
        <input type="submit" name="submit" class="btn btn-success btn-bg margintop an" value="Approve" />
    </form>
    <div class="clearfix"></div>
    <br /><br />
	</div>

</div>

<?php
	
	if($_POST['submit']=="Approve")
	{
		
		// Check if the user filled the source
		if (!$_POST['source']) $error="<br />Please enter starting point of trip";

    	// Check if the user filled the date and time of trip
		if (!$_POST['date_time']) $error="<br />Please enter date and time of trip";

		// Check if the user filled his name
		if (!$_POST['user']) $error="<br />Please enter the name of the user";

		// Check if the user filled the destination
		if (!$_POST['destination']) $error="<br />Please enter ending point of trip";

		// Check if the user filled the number of passengers
		if (!$_POST['passengers']) $error="<br />Please enter the number of passengers";

		// Check if the user filled the number of free spots
		if (!$_POST['freespots']) $error="<br />Please enter the number of freespots";

		if($_POST['passengers']>$_POST['freespots']) $error="<br />Not enough free spots";

		// Check if any errors were encountered
		if ($error)
		{
			$error="There were error(s) in booking the trip:".$error;
			echo '<div class="alert alert-danger" style="text-align:center;">'.addslashes($error).'</div>';

		}

		// If no errors, proceed for approval
		else
		{	

			// Insert the details entered by the user in the database
			$query1="INSERT INTO passengers(trip_id,num_passengers,passenger_id) VALUES('".mysqli_real_escape_string($link,$row1['trip_id'])."','".mysqli_real_escape_string($link,$_POST['passengers'])."','".mysqli_real_escape_string($link,$_GET['user_id'])."')";
			mysqli_query($link, $query1);		

			$query2="UPDATE `approvals` SET `status`='approved' WHERE `user_id`='".mysqli_real_escape_string($link,$_GET['user_id'])."' AND `driver_id`='".mysqli_real_escape_string($link,$_SESSION['driver_id'])."' AND `trip_id`='".mysqli_real_escape_string($link,$row1['trip_id'])."' AND `passengers`='".mysqli_real_escape_string($link,$_POST['passengers'])."'";
			mysqli_query($link, $query2);

			$free_spots=$_POST['freespots']-$_POST['passengers'];

			$sql="UPDATE `trips` SET `free_spots`='".mysqli_real_escape_string($link,$free_spots)."' WHERE `trip_id`='".mysqli_real_escape_string($link,$row1['trip_id'])."'";
			mysqli_query($link, $sql);		

			header("Location:pending_approvals.php");
		}
	}

?>

</body>
</html>


