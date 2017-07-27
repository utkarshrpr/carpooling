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

</div>

<?php 
	
	$queryx="SELECT trip_id FROM passengers WHERE passenger_id='".mysqli_real_escape_string($link,$_SESSION['id'])."'";
	date_default_timezone_set("Asia/Kolkata");
	$current_date=date("Y-m-d H:i:s");
	echo "<br>";
	
	// Execute the query and store the result
	$resultx=mysqli_query($link,$queryx);

	echo '<div class="col-md-2 col-md-offset-8">';
	$table = '<table class="table table-striped">
	<thead>
		<tr>
		<th style="text-align:center">Driver</th>
		<th style="text-align:center">Source</th>
		<th style="text-align:center">Via</th>
		<th style="text-align:center">Destination</th>
		<th style="text-align:center">Date and Time</th>
		<th style="text-align:center">Rate</th>';
	$table.= '
		</tr>
	</thead>
	<tbody>';

	while($rowx = mysqli_fetch_array($resultx))
	{
		$queryy="SELECT * FROM trips WHERE trip_id='".mysqli_real_escape_string($link,$rowx['trip_id'])."'";
		$resulty=mysqli_query($link,$queryy);
		$rowy=mysqli_fetch_array($resulty);

		$queryz="SELECT * FROM rating WHERE rating_uid='".mysqli_real_escape_string($link,$_SESSION['id'])."' AND rated_uid='".mysqli_real_escape_string($link,$rowy['driver_id'])."' AND trip_id='".mysqli_real_escape_string($link,$rowx['trip_id'])."'";
		$resultz=mysqli_query($link,$queryz);
		$rowz=mysqli_fetch_array($resultz);

		if($rowz['rating'])
			continue;
		if($current_date<$rowy['date_time'])
			continue;
		else
		{
			$querya="SELECT name FROM user WHERE user_id='".mysqli_real_escape_string($link,$rowy['driver_id'])."'";
			$resulta=mysqli_query($link,$querya);
			$rowa=mysqli_fetch_array($resulta);

			$table.= '<td style="text-align:center;">'.$rowa['name'].'</td>';
			$table.= '<td style="text-align:center;">'.$rowy['source'].'</td>';
			$table.= '<td style="text-align:center;">'.$rowy['via'].'</td>';
			$table.= '<td style="text-align:center;">'.$rowy['destination'].'</td>';
			$table.= '<td style="text-align:center;">'.$rowy['date_time'].'</td>';
			$rate_url="rate_d.php?trip_id=".$rowx['trip_id']."&user=".$rowy['driver_id'];
			$table.= '<td style="text-align:center;"><a href='.$rate_url.' class="buttonize">Rate</a></td>';
			$table.= '</tr>';
		}
	 }

	    $table.= '
	    </tbody>
	  	</table>';
		echo '</div>';
		echo $table;

?>

</body>
</html>


