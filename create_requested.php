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
		$query = "SELECT * FROM request WHERE request_id='".mysqli_real_escape_string($link,$_GET['request'])."'";
		$result = mysqli_query($link,$query);
		$row = mysqli_fetch_array($result);

	?>

	<div class="row">
	  <form id="routeForm "role="form" method="post">
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
            <input name="via" type="text" class="form-control" id="via" placeholder="Enter a mid-point on your route">
        </div>
        <div class="clearfix"></div>
        <div class="form-group col-xs-10 col-sm-6 col-md-6 col-lg-6">
            <label for="destination">Destination</label>
            <input readonly name="destination" type="text" class="form-control" id="destination" value="<?php echo $row['destination']; ?>">
        </div>
        <div class="form-group col-xs-10 col-sm-6 col-md-6 col-lg-6">
            <label for="freespots">Number of Free Spots</label>
            <input name="freespots" type="text" class="form-control" id="freespots" placeholder="Enter the Number of Free Spots">
        </div>
        <div class="clearfix"></div>
        <input type="submit" name="submit" class="btn btn-success btn-bg margintop an" value="Create Trip" />
    </form>
    <div class="clearfix"></div>
    <br /><br />
	</div>

</div>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyB82qWTjFYGu9xkvmWGFIkpcXnOjmwO6hM&sensor=false&libraries=places"></script>
<script type="text/javascript">
    google.maps.event.addDomListener(window, 'load', function () {
    	var source = new google.maps.places.Autocomplete(document.getElementById('source'));
    	var via = new google.maps.places.Autocomplete(document.getElementById('via'));
    	var destination = new google.maps.places.Autocomplete(document.getElementById('destination'));
    });
</script>
<!-- This script is used for datetime-picker used in the date-time field -->
<script type="text/javascript">
	$(".form_datetime").datetimepicker({
		format: "yyyy-mm-dd hh:ii:ss",
		autoclose: true,
		showMeridian: true,
		todayBtn: true,
		startDate: "+0d",
		minuteStep: 10
	});
		// prevents form submition on pressing enter
	$('#routeForm').on('keyup keypress', function(e) {
	  var keyCode = e.keyCode || e.which;
	  if (keyCode === 13) { 
	    e.preventDefault();
	    return false;
	  }
	});
</script>
<?php

	function redirect($url)
	{
    	if (!headers_sent())
    	{    
      	  header('Location: '.$url);
       	 exit;
        }
    	else
    	{  
    		echo '<script type="text/javascript">';
       		echo 'window.location.href="'.$url.'";';
        	echo '</script>';
       		echo '<noscript>';
	        echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
	        echo '</noscript>'; exit;
    	}
	}
	
	if($_POST['submit']=="Create Trip")
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
		if (!$_POST['freespots']) $error="<br />Please enter the number of free spots";

		// Check if any errors were encountered
		if ($error)
		{
			$error="There were error(s) in creation of the trip:".$error;
			echo '<div class="alert alert-danger" style="text-align:center;">'.addslashes($error).'</div>';

		}

		// If no errors, proceed for registration
		else
		{	

			// Get the driver id 
			$driver_id=$_SESSION['id'];

			// Insert the details entered by the user in the database
			$query="INSERT INTO trips(source,destination,free_spots,via,date_time,driver_id) VALUES('".mysqli_real_escape_string($link,$_POST['source'])."','".mysqli_real_escape_string($link,$_POST['destination'])."','".mysqli_real_escape_string($link,$_POST['freespots'])."','".mysqli_real_escape_string($link,$_POST['via'])."','".mysqli_real_escape_string($link,$_POST['date_time'])."','".mysqli_real_escape_string($link,$driver_id)."')";

			// Execute the query
			mysqli_query($link,$query);

			$query1="DELETE FROM `request` WHERE `request_id`='".mysqli_real_escape_string($link,$_GET['request'])."'";
			mysqli_query($link,$query1);

			$sql = "SELECT name,email FROM user WHERE user_id='".mysqli_real_escape_string($link,$row['requestuser_id'])."'";
			$resultsql = mysqli_query($link,$sql);
			$rowsql = mysqli_fetch_array($resultsql);

			$to = $rowsql['email'];
			$subject = "Requested Trip Created to ".$_POST['destination'];
			$txt = "Hello ".$rowsql['name'].","."\r\n";
			$txt.= $_SESSION['name']." has created the following trip requested by you:"."\r\n";
			$txt.= "Source: ".$_POST['source']."\r\n"."Destination: ".$_POST['destination']."\r\n"."Date-Time: ".$_POST['date_time']."\r\n"."Free Spots: ".$_POST['freespots']."\r\n"."You can book this trip by logging into this account !!";
			$headers = "From: utkarshchauhan007@gmail.com";

			mail($to,$subject,$txt,$headers);

			redirect("requested_trips.php");
		}
	}

?>

</body>
</html>


