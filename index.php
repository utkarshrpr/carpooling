<!-- Include the php files for login and connection to the database -->
<?php
	include("login.php");
	include("connection.php");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Title of the page -->
    <title>Carpooling</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Add styling -->
	<style>
		.navbar-brand {
			font-size:1.8em;
		}
		#topcontainer {
			width:100%;
			background-size:cover;
		}
		.container {
			background-size:cover;
		}
		#toprow {
			margin-top:100px;
			text-align:center;
		}
		#toprow h1 {
			font-size:300%;
		}
		.bold {
			font-weight:bold;
		}
		.margintop {
			margin-top:30px;
			
		}
		.center {
			text-align:center;
		}
		.title {
			margin-top:100px;
			font-size:300%;
		}
		#footer {
			background-color:#4C9ED9;
			padding-top:70px;
			width:100%;
		}
		.marginbottom {
			margin-bottom:30px;
		}
		.android {
			width:250px;
		}
		.am {
			background-color:#F8F8F8;
			border-radius:10px;
		}
		.an {
			margin-bottom:10px;
		}
		.logoimg {
			float: left;
			margin-right: 20px; 
			margin-top: -5px;
		}
	html {
  position: relative;
  min-height: 100%;
}
body {
  margin-bottom: 60px;
}
.footer {
  position: absolute;
  bottom: 0;
  width: 100%;
  height: 60px;
  background-color: #f5f5f5;
  text-align: center;
}

</style>
  </head>
 <body>
	<div class="navbar navbar-default navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
			<div class="navbar-brand"><a href="index.php" class="linknone">Carpooling</a><a href="http://www.iitrpr.ac.in/" target="blank"><img class="logoimg" src="img/iitrpr.png" width="30px" height="30px"></a></div>
			<button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>
		<div class="collapse navbar-collapse">
			
			<form class="navbar-form navbar-right" method="post">
				<div class="form-group">
					<input type="email" name="loginemail" placeholder="Email" class="form-control"/>
				</div>
				<div class="form-group">
					<input type="password" name="loginpassword" placeholder="Password" class="form-control"/>
				</div>
				<a href="forgotpassword.php"> Forgot password?</a>
				<input type="submit" name="submit" class="btn btn-success " value="Log In"/>
			</form>
		</div>
	</div>
	</div>
	<div class="container contentcontainer" id="topcontainer">
		<class="row">
			<div class="col-md-6 col-md-offset-3 am" id="toprow">
				<h1 class="margintop">Carpooling</h1>
				<p class="lead">Indian Institute of Technology Ropar</p>
				
				<?php
					if ($error){
						echo '<div class="alert alert-danger">'.addslashes($error).'</div>';
					
					}
					if ($message){
						echo '<div class="alert alert-success">'.addslashes($message).'</div>';
					
					}
				?>
				
				
				<p class="bold margintop" >Not a member? Sign Up below!</p>
				<p class="bold margintop" >After registering, check your email for further instructions !!</p>
				<form class="margintop" method="post">
					<label for="name">Name</label>
					<div class="input-group">
						
						<span class="input-group-addon glyphicon glyphicon-user"></span>
						<input type="name" name="name" class="form-control" placeholder="Your Name"/>
					</div>
					
					<label for="contact">Contact</label>
					<div class="input-group">
						
						<span class="input-group-addon glyphicon glyphicon-phone"></span>
						<input type="text" name="contact" class="form-control" placeholder="Your Contact Number"/>
					</div>

					<label for="email">Email Address(@iitrpr.ac.in)</label>
					<div class="input-group">
						
						<span class="input-group-addon">&#64;</span>
						<input type="email" name="email" class="form-control" placeholder="Your Email"/>
					</div>
					<!-- <label for="password">Password</label>
					<div class="input-group">
						<span class="input-group-addon glyphicon glyphicon-lock"></span>
						<input type="password" name="password" class="form-control" placeholder="Your Password"/>
					</div> -->
					
					<input type="submit" name="submit" class="btn btn-success btn-bg margintop an" value="Register" />
				</form>
			</div>
		</div>
	</div>
	<footer class="footer">
      <div class="container">
        <p class="text-muted">Design by: Ankit Dahiya and Utkarsh Singh Chauhan</p>
      </div>
    </footer>
	

    <script src="js/jquery-2.1.3.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
	<script>
	$(".contentcontainer").css("min-height",$(window).height());
	</script>

  </body>

</html>
