<html>
<head>
	<title> Admin login </title>
	<meta charset="UTF-8" />
</head>
<body>
	<?php
		$errors = array();
		validate_passwd();
		if (count($errors) == 0 &&
			isset($_REQUEST['success']) &&
			$_REQUEST['success'] == 'success') {
				session_start();
				$_SESSION['login'] = 'success';
				display_home();
		}
		else  {
			display_errors();
			display_login();
		}
		
		function validate_passwd()
		{
			global $errors;
			if ($_REQUEST['password'] == '') {
				$errors[] = "<font color='red'>Please enter admin password</font>";
			}
			else {
				$_pswd = file_get_contents('/home/nebula/conf/www/_pswd.txt');
				//echo "Password=" . $_pswd, "<br>";
				if ($_pswd == $_REQUEST['password'])
					$_REQUEST['success'] = 'success';
				else $errors[] = "<font color='red'>Incorrect password</font>";
			}
		}

		function display_errors()
		{
			global $errors;
			foreach ($errors as $err) {
				echo $err, "<br>";
			}
		}

		function display_home()
		{
			$redirect = "Location: home.php";
			echo header($redirect);
		}

		function display_login()
		{
			echo "<form method='POST' action='index.php'>";
			echo "<br><br>";
			echo "Admin password ";
			echo "<input name='PHPSESSID' type='hidden'>";
			echo "<input name='success' type='hidden'>";
			echo "<input name='password' type='password'>";
			echo "<br><br>";
			echo session_id();
			echo "<input type='submit' value='Login'>";
			echo "</form>";
		}
	?>
</body>
</html>
