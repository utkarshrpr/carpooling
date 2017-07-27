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

		$query2 = "SELECT name FROM user WHERE user_id='".mysqli_real_escape_string($link,$_GET['user'])."'";
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
            <label for="via">Via</label>
            <input readonly name="via" type="text" class="form-control" id="via" value="<?php echo $row1['via']; ?>">
        </div>
        <div class="clearfix"></div>
        <div class="form-group col-xs-10 col-sm-6 col-md-6 col-lg-6">
            <label for="user">Passenger</label>
            <input readonly name="user" type="text" class="form-control" id="user" value="<?php echo $row2['name']; ?>">
        </div>
        <div class="form-group col-xs-10 col-sm-6 col-md-6 col-lg-6">
            <label for="rating">Rate Passenger</label>
      			<select class="form-control" id="rating" name="rating">
      			<option value="" selected hidden></option>
		        <option>1</option>
		        <option>2</option>
		        <option>3</option>
		        <option>4</option>
		        <option>5</option>
		      </select>
        </div>
        <input type="submit" name="submit" class="btn btn-success btn-bg margintop an" value="Rate" />
    </form>
    <div class="clearfix"></div>
    <br /><br />
	</div>

</div>

<?php
	
	if($_POST['submit']=="Rate")
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
		if (!$_POST['via']) $error="<br />Please enter the mid-point of the trip";

		// Check if the user filled the number of free spots
		if (!$_POST['rating'] or $_POST['rating']=="") $error="<br />Please enter the rating";

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
			$query1="INSERT INTO rating(trip_id,rated_uid,rating_uid,rating) VALUES('".mysqli_real_escape_string($link,$_GET['trip_id'])."','".mysqli_real_escape_string($link,$_GET['user'])."','".mysqli_real_escape_string($link,$_SESSION['id'])."','".mysqli_real_escape_string($link,$_POST['rating'])."')";
			mysqli_query($link, $query1);		

			$query2="SELECT rating FROM rating WHERE rated_uid='".mysqli_real_escape_string($link,$_GET['user'])."'";
			$result2 = mysqli_query($link,$query2);
			$total_rating=0;
			$count=0;
			while($row2 = mysqli_fetch_array($result2))
			{
				$total_rating+=$row2['rating'];
				$count+=1;
			}
			if($count!=0)
			{
				$avg_rating=$total_rating/$count;

				$sql = "UPDATE user SET rating='".mysqli_real_escape_string($link,$avg_rating)."' WHERE user_id='".mysqli_real_escape_string($link,$_GET['user'])."'";
				mysqli_query($link,$sql); 
			}

			header("Location:rate_passengers.php");
		}
	}

?>

</body>
</html>


