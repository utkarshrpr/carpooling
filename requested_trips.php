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

</div>

<?php 

	// Get all the trips between source and destination
	$query="SELECT * FROM request";

	echo "<br>";
	
	// Execute the query and store the result
	$result=mysqli_query($link,$query);

	echo '<div class="col-md-2 col-md-offset-8">';
	$table = '<table class="table table-striped">
	<thead>
		<tr>
		<th style="text-align:center">User</th>
		<th style="text-align:center">Contact</th>
		<th style="text-align:center">Rating</th>
		<th style="text-align:center">Source</th>
		<th style="text-align:center">Destination</th>
		<th style="text-align:center">Date and Time</th>
		<th style="text-align:center">Number of Passengers</th>
		<th style="text-align:center">Create</th>';
	$table.= '
		</tr>
	</thead>
	<tbody>';

	$id_number=1;
	while($row = mysqli_fetch_array($result))
	{

		$query1="SELECT * FROM user WHERE user_id='".mysqli_real_escape_string($link,$row['requestuser_id'])."'";
		$result1=mysqli_query($link,$query1);
		$row1=mysqli_fetch_array($result1);
		$passengers = $row['passengers'];
	 	$source = $row['source'];
	 	$destination = $row['destination'];
	 	$date_time = $row['date_time'];
	 	$request_id = $row['request_id'];
	 	$user = $row1['name'];
	 	$contact = $row1['contact'];
	 	$rating = $row1['rating'];

	 	if($current_date>$date_time)
	 		continue;

	 	else
	 	{
			$table.= '<tr id="'.$id_number.'"><td style="text-align:center;">'.$user.'</td>';
			$table.= '<td style="text-align:center;">'.$contact.'</td>';
			$table.= '<td style="text-align:center;">'.$rating.'</td>';
			$table.= '<td style="text-align:center;">'.$source.'</td>';
			$table.= '<td style="text-align:center;">'.$destination.'</td>';
			$table.= '<td style="text-align:center;">'.$date_time.'</td>';
			$table.= '<td style="text-align:center;">'.$passengers.'</td>';
			$table.= '<td style="text-align:center;"><a href="create_requested.php?request='.$request_id.'" class="buttonize">Create</a></td>';
		 	$table.= '</tr>';

		 	$id_number+=1;
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


