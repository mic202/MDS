<?php
	session_start();
	// Call database
	require_once('connect.ini.php');
	var_dump($_POST);
	echo '</br>';
	//Set email and password that entered by user
	$email = trim($_POST['email']);
	$password = $_POST['password'];
	//NullValueException

	$user_info = user_auth($db_link, $email, $password);
	
	if($user_info[0] != null)
		user_login($user_info);

	if($_REQUEST['action'] == 'logout')
		user_logout();
/*-------------------------------------------------------------------
|	
|	Function to check if given userID and Password are authorized
|		If it is the authorized user: returns $user_info array
|		$user_info['Email','Password','Username']
|	
---------------------------------------------------------------------*/
	function user_auth($db, $email, $password, $user_info=null) 
	{

		$query = "SELECT Email, Password, Lastname, Firstname FROM users
					WHERE Email = '$email' && Password = '$password'";

		$result = mysqli_query($db, $query);
		if(mysqli_num_rows($result)>0) 
		{
			while($row = mysqli_fetch_array($result)) 
			{
				$user_info = $row;
			}

			return $user_info;
		}
		else
		{	
			//header('Location:login_form.php');
		
		}		
	}

	function user_login($user_info) 
	{
		$_SESSION['user_lname'] = $user_info['Lastname'];		
		$_SESSION['user_fname'] = $user_info['Firstname'];
		$_SESSION['user_email'] = $user_info['Email'];
		header('Location:../index.php');		
	}

	function user_logout() {
		session_unset();
		header('Location:../index.php');
	}



?>