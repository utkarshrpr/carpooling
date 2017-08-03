<?php

	// Start the session
	session_start();

	// Check if the user clicked on logout button
	if ($_GET['logout']==1 AND isset($_SESSION['id'])) 
	{

		// Destroy the session
		session_destroy();
		$message="You have been logged out !!";
	
	}

	// Include the php file for database connection
	include("connection.php");

	// Check if the user clicked on Register button in the index page
	if($_POST['submit']=='Register')
	{

		// Check if the user filled the email field
		if (!$_POST['email'])$error.="<br />Please enter your mail";

		// Check if the email entered is valid
		else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) $error=$error."Please enter a valid email";
		$email = $_POST['email'];

		// Domain name should be iitrpr.ac.in
		$allowed = array('iitrpr.ac.in');

		// Get the domain name from the email entered by the user
    	$domain = array_pop(explode('@', $email));

    	// Check if the user entered the email-id of institute domain name
    	if ( ! in_array($domain, $allowed)) $error=$error."<br />Please enter email-id of institute domain only";

    	// Check if the user filled an invalid contact number
		if (!is_numeric($_POST['contact'])) $error="<br />Please enter a valid contact number";

    	// Check if the user filled the name field
		if (!$_POST['name']) $error=$error."<br />Please enter your name";

		// // Check if the user filled the password field
		// if (!$_POST['password']) $error=$error."<br />Please enter your password";

		// Check if any errors were encountered
		if ($error)
		$error= "There were error(s) in your sign up details:".$error;

		// If no errors, proceed for registration
		else
		{	
			// Check if the email id is already stored in the database
			$query1="SELECT * FROM user WHERE email='".mysqli_real_escape_string($link,$_POST['email'])."'";

			// Execute the query and store the result
			$result1=mysqli_query($link,$query1);

			// Get the results of the query
			$results1=mysqli_num_rows($result1);

			// If we get any result, then user is already registered
			if($results1)
			$error = "The email you entered is already registered !!";

			// If not registered, continue with the registration
			else
			{
				$password = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890"), -7);
				$dup_password=$password;

				$to = $_POST['email'];
				$subject = "Confirm registration for Carpooling";
				$txt = "Hello ".$_POST['name'].","."\r\n";
				$txt.= "Your password is: ".$dup_password."\r\n";
				$txt.= "Kindly change it by logging in and editing your profile from Edit Profile section.";
				$headers = "From: utkarshchauhan007@gmail.com";
				
				if(@mail($to,$subject,$txt,$headers))
				{
					// Insert the details entered by the user in the database
					$query="INSERT INTO user (name,email,contact,password) VALUES('".mysqli_real_escape_string($link,$_POST['name'])."','".mysqli_real_escape_string($link,$_POST['email'])."','".mysqli_real_escape_string($link,$_POST['contact'])."','".mysqli_real_escape_string($link,md5($password))."')";
					// Execute the query
					mysqli_query($link,$query);

					// Store the id used in the query as session id
					$_SESSION['id']=mysqli_insert_id($link);
					header("Location:index.php");
				}
				else
				{
					$error="There was an error in sending the email. Please try again later !!";
					// echo '<div class="alert alert-danger" style="text-align:center;">'.addslashes($error).'</div>';
				}

		}
	}
}

		// Check if the user clicked on Log In button in the index page
		if ($_POST['submit']=="Log In")
		{

			// Get the user from the database based on the email and password entered by the user
			$query="SELECT * FROM user where email='".mysqli_real_escape_string($link,$_POST['loginemail'])."' AND password='".md5($_POST['loginpassword'])."' LIMIT 1";
			echo "<br>";
			
			// Execute the query and store the result
			$result=mysqli_query($link,$query);

			// Get the results of the query
			$row=mysqli_fetch_array($result);

			// If the user is stored in the database
			if($row)
			{	

				// Store the user_id, email and name of the user as SESSION variables
				$_SESSION['id']=$row['user_id'];
				$_SESSION['email']=$row['email'];
				$_SESSION['name']=$row['name'];

				// Go to the dashboard of the user
				header("Location:user.php");
			}

			// If the user is not stored in the database
			else 
			{
				$error = "The email or password is incorrect !!";
			}
	
		}
?>