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
		date_default_timezone_set("Asia/Kolkata");
		$current_date=date("Y-m-d H:i:s");
	?>

	<div class="row">
	  <form role="form" method="post">
        <div class="form-group col-xs-10 col-sm-6 col-md-6 col-lg-6">
            <label for="source">Source</label>
            <input name="source" type="text" class="form-control" id="source" placeholder="Enter Starting Point of Trip">
        </div>
        <div class="form-group col-xs-10 col-sm-6 col-md-4 col-lg-6">
            <label for="destination">Destination</label>
            <input name="destination" type="text" class="form-control" id="destination" placeholder="Enter Ending Point of Trip">
        </div>
        <div class="clearfix"></div>
        <input type="submit" name="submit" class="btn btn-success btn-bg margintop an" value="Search Trips" />
    </form>
    <div class="clearfix"></div>

    <br /><br />
	</div>
</div>

<?php 
	
	if($_POST['submit']=="Search Trips")
	{

		// Check if the user filled the source
		if (!$_POST['source']) $error="<br />Please enter starting point of trip";

		// Check if the user filled the destination
		if (!$_POST['destination']) $error="<br />Please enter ending point of trip";

		// Check if any errors were encountered
		if ($error)
		{
			$error="There were error(s) in search of the trip:".$error;
			echo '<div class="alert alert-danger" style="text-align:center;">'.addslashes($error).'</div>';

		}
		// If no errors, proceed for registration
		else
		{	

			// Get the driver id 
			$user_id=$_SESSION['id'];

			// Get all the trips between source and destination
			$query="SELECT * FROM trips where source='".mysqli_real_escape_string($link,$_POST['source'])."' AND destination='".$_POST['destination']."'";

			echo "<br>";
			
			// Execute the query and store the result
			$result=mysqli_query($link,$query);

			$message='Upcoming Trips from '.$_POST['source'].' to '.$_POST['destination'];

			echo '<div class="container">
 			<h4>'.$message.'</h4>
  			<hr> 
 			</div>';

			echo '<div class="col-md-2 col-md-offset-8">';
			$table = '<table class="table table-striped">
    		<thead>
      		<tr>
      		<th style="text-align:center">Free Spots</th>
      		<th style="text-align:center">Via</th>
     		<th style="text-align:center">Date and Time</th>
     		<th style="text-align:center">Driver</th>
     		<th style="text-align:center">Contact</th>
     		<th style="text-align:center">Rating</th>
     		<th style="text-align:center">Request Booking</th>';
			$table.= '
      		</tr>
    		</thead>
    		<tbody>';

			$id_number=1;	
			while($row = mysqli_fetch_array($result))
			{

				$query1="SELECT * FROM user WHERE user_id='".mysqli_real_escape_string($link,$row['driver_id'])."'";
				$result1=mysqli_query($link,$query1);
				$row1=mysqli_fetch_array($result1);
				$freespots = $row['free_spots'];
			 	$via = $row['via'];
			 	$date_time = $row['date_time'];
			 	$trip_id = $row['trip_id'];
			 	$driver = $row1['name'];
			 	$contact = $row1['contact'];
			 	$rating = $row1['rating'];

			 	if($current_date>$date_time)
			 		continue;

			 	else
			 	{
					$table.= '<tr><td style="text-align:center;">'.$freespots.'</td>';
					$table.= '<td style="text-align:center;">'.$via.'</td>';
					$table.= '<td style="text-align:center;">'.$date_time.'</td>';
					$table.= '<td style="text-align:center;">'.$driver.'</td>';
					$table.= '<td style="text-align:center;">'.$contact.'</td>';
					$table.= '<td style="text-align:center;">'.$rating.'</td>';
					$table.= '<td style="text-align:center;"><a href="book.php?trip='.$trip_id.'" class="buttonize">Request</a></td>';

				 	$table.= '</tr>';

				 	$id_number+=1;
			 	}
			 }

			    $table.= '
			    </tbody>
			 	</table>';
				echo '</div>';
				echo $table;

		}
	}


?>

</body>
</html>


