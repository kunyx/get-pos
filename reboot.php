<!-- Reboot system form -->
<div style="padding-left:16px">
    <?php
        session_start();
        if (isset($_SESSION['login']) && $_SESSION['login'] = 'success')
        {
            if (isset($_REQUEST['reboot']))
            {
                system_call();
                echo '<script type="text/javascript">setTimeout(function(){window.top.location="home.php"} , 20000);</script>';
            }
            else display_form();
        }
        else echo "You have to login";

        function system_call()
        {
            unset($_REQUEST['reboot']);
            $_cmnd = 'sudo /home/nebula/scripts/reboot-system.sh > /dev/null 2> /dev/null &';
            exec($_cmnd);
            echo "Rebooting the system, please wait for the page to reload ...";
        }

        function display_form()
        {
            header( 'Content-type: text/html; charset=utf-8' );
            echo "<form method='POST' action='reboot.php'>";
            echo "<input name='reboot' type='hidden'>";
            echo "<br><br>";
            echo "<input type='submit' value='Reboot system'>";
            echo "</form>";
        }

		function display_home()
		{
			$redirect = "Location: home.php";
			echo header($redirect);
		}
    ?>
</div>

<?php
    function bg_process($fn, $redirect, $arr)
    {
        $call = function($fn, $arr) {
            header('Connection: close');
            header('Content-length: '.ob_get_length());
            ob_flush();
            flush();
            sleep(1);
            call_user_func_array($fn, $arr);
        };
        register_shutdown_function($call, $fn, $arr);
        echo header($redirect);
    }

    function ob_process_call($redirect)
    {
        // Turn off output buffering
        ini_set('output_buffering', 'off');
        // Turn off PHP output compression
        ini_set('zlib.output_compression', false);                
        //Flush (send) the output buffer and turn off output buffering
        //ob_end_flush();
        while (@ob_end_flush());                
        // Implicitly flush the buffer(s)
        ini_set('implicit_flush', true);
        ob_implicit_flush(true);
 
        ob_start();       
        echo header($redirect);  // Generate your output here       
        ignore_user_abort(true); // Ignore connection-closing by the client/user
        // Set your timelimit to a length long enough for your script to run, 
        // but not so long it will bog down your server in case multiple versions run 
        // or this script get's in an endless loop.
        if (!ini_get('safe_mode') 
            && strpos(ini_get('disable_functions'), 'set_time_limit') === FALSE)
            set_time_limit(60);
        // Get your output and send it to the client
        $content = ob_get_contents();   // Get the content of the output buffer
        ob_end_clean();                 // Close current output buffer
        $len = strlen($content);        // Get the length
        header('Connection: close');    // Tell the client to close connection
        header("Content-Length: $len"); // Close connection after $len characters
        echo $content;                  // Output content
        system_call();                       // Call function
        flush();                        // Force php-output-cache to flush to browser.
        while (ob_get_level() > 0) {    // Optional: kill all other output buffering
            ob_end_clean();
        }
    }
    /*?>
            <script language="javascript">
                setTimeout(function() {
                    //window.location.redirect('http://192.168.1.137/home.php');
                    location.href('http://192.168.1.137/home.php');
                }, 20000);
            </script> 
    <?php*/
?>
