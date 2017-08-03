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
	
	$message="My Approvals";
	echo '<div class="container">
 			<h4>'.$message.'</h4>
  			<hr> 
 			</div>'; 
	$query="SELECT * FROM approvals WHERE driver_id='".mysqli_real_escape_string($link,$_SESSION['id'])."'";

	echo "<br>";
	
	// Execute the query and store the result
	$result=mysqli_query($link,$query);

	echo '<div class="col-md-2 col-md-offset-8">';
	$table = '<table class="table table-striped">
	<thead>
		<tr>
		<th style="text-align:center">Booked By</th>
		<th style="text-align:center">Contact</th>
		<th style="text-align:center">User Rating</th>
		<th style="text-align:center">Source</th>
		<th style="text-align:center">Destination</th>
		<th style="text-align:center">Date and Time</th>
		<th style="text-align:center">Number of Passengers</th>
		<th style="text-align:center">Free Spots</th>
		<th style="text-align:center">Status/Approve/Reject</th>';
	$table.= '
		</tr>
	</thead>
	<tbody>';

	$id_number=1;
	while($row = mysqli_fetch_array($result))
	{
		$query1="SELECT * FROM user WHERE user_id='".mysqli_real_escape_string($link,$row['user_id'])."'";
		$result1=mysqli_query($link,$query1);
		$row1=mysqli_fetch_array($result1);
		$query2="SELECT * FROM trips WHERE trip_id='".mysqli_real_escape_string($link,$row['trip_id'])."'";
		$result2=mysqli_query($link,$query2);
		$row2=mysqli_fetch_array($result2);
		$passengers = $row['passengers'];
	 	$source = $row2['source'];
	 	$destination = $row2['destination'];
	 	$date_time = $row2['date_time'];
	 	$user = $row1['name'];
	 	$contact = $row1['contact'];
	 	$rating = $row1['rating'];
	 	$free_spots = $row2['free_spots'];

	 	$_SESSION['driver_id']=$_SESSION['id'];

		$table.= '<tr id="'.$id_number.'"><td style="text-align:center;">'.$user.'</td>';
		$table.= '<td style="text-align:center;">'.$contact.'</td>';
		$table.= '<td style="text-align:center;">'.$rating.'</td>';
		$table.= '<td style="text-align:center;">'.$source.'</td>';
		$table.= '<td style="text-align:center;">'.$destination.'</td>';
		$table.= '<td style="text-align:center;">'.$date_time.'</td>';
		$table.= '<td style="text-align:center;">'.$passengers.'</td>';
		$table.= '<td style="text-align:center;">'.$free_spots.'</td>';
		$approve_url="approve.php?trip_id=".$row['trip_id']."&user_id=".$row['user_id']."&passengers=".$row['passengers'];
		$reject_url="reject.php?trip_id=".$row['trip_id']."&user_id=".$row['user_id']."&passengers=".$row['passengers'];

		if($row['status']=='pending')
		{
			if($current_date<$date_time)
			{
				$table.= '<td style="text-align:center;"><a href='.$approve_url.' class="buttonize">Approve</a>/<a href='.$reject_url.' class="buttonize">Reject</a></td>';
			}
			else
			{
				$table.= '<td style="text-align:center;">Approval Pending and Trip Completed</td>';
			}
		}
		else
			$table.= '<td style="text-align:center;">'.ucfirst($row['status']).'</td>';
	 	$table.= '</tr>';

	 	$id_number+=1;
	 }

	    $table.= '
	    </tbody>
	  	</table>';
		echo '</div>';
		echo $table;

?>

<?php 
	
	$message="My Trips";
	echo '<div class="container">
 			<h4>'.$message.'</h4>
  			<hr> 
 			</div>'; 
	$queryx="SELECT * FROM trips WHERE driver_id='".mysqli_real_escape_string($link,$_SESSION['id'])."'";

	echo "<br>";
	
	// Execute the query and store the result
	$resultx=mysqli_query($link,$queryx);

	echo '<div class="col-md-2 col-md-offset-8">';
	$table = '<table class="table table-striped">
	<thead>
		<tr>
		<th style="text-align:center">Source</th>
		<th style="text-align:center">Via</th>
		<th style="text-align:center">Destination</th>
		<th style="text-align:center">Date and Time</th>
		<th style="text-align:center">Free Spots</th>';
	$table.= '
		</tr>
	</thead>
	<tbody>';

	while($rowx = mysqli_fetch_array($resultx))
	{

		$table.= '<td style="text-align:center;">'.$rowx['source'].'</td>';
		$table.= '<td style="text-align:center;">'.$rowx['via'].'</td>';
		$table.= '<td style="text-align:center;">'.$rowx['destination'].'</td>';
		$table.= '<td style="text-align:center;">'.$rowx['date_time'].'</td>';
		if($current_date<$rowx['date_time'])
		{
			$table.= '<td style="text-align:center;">'.$rowx['free_spots'].'</td>';
		}
		else
		{
			$table.= '<td style="text-align:center;">Trip Completed</td>';
		}
		$table.= '</tr>';
	 }

	    $table.= '
	    </tbody>
	  	</table>';
		echo '</div>';
		echo $table;

?>

</body>
</html>


