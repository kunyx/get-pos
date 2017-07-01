<html>
<head>
    <title> Home page </title>
    <meta charset="UTF-8" />
</head>
<body>
 <h3> Navigate to </h3>
 <form name='rpi_settings' action='home.php' method='POST'>
    <input type='submit' name='nav_button' value='RPi settings'>
 </form>
 <form name='lighting_control' action='home.php' method='POST'>
    <input type='submit' name='nav_button' value='Lighting control'>
 </form>
 <?php
    session_start();
    $redirect = "Location: index.php";
    if (isset($_REQUEST['PHPSESSID']))
		$_SESSION['login'] = 'success';
    if (isset($_SESSION['login']) && $_SESSION['login'] == 'success')
    {
        if (isset($_REQUEST['nav_button'])) {
            if ($_REQUEST['nav_button'] == 'RPi settings')
                $redirect = "Location: rpi_settings.php";
            if ($_REQUEST['nav_button'] == 'Lighting control')
                $redirect = "Location: lighting_control.php";
            echo header($redirect);
        }
    }
    else echo header($redirect);
 ?>
</body>
</html>
