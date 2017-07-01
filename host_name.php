<!-- Host name form -->
<div style="padding-left:16px">
    <?php
        session_start();
        if (isset($_SESSION['login']) && $_SESSION['login'] = 'success')
        {
            if (isset($_REQUEST['hostname']))
                save_hostname();
            else display_hostname();
        }
        else echo "You have to login";
        
        function save_hostname()
        {
            unset($_REQUEST['host_name']);
            $_hostname = $_REQUEST['hostname'];
            $_cmndargs = 'sudo ./hostname.sh ' . $_hostname;
            $output = shell_exec($_cmndargs);
            if ($output == NULL)
                echo "Cannot change hostname";
        }

        function display_hostname()
        {
            echo "<form method='POST' action='host_name.php'>";
            echo "<br><br>";
            echo "New hostname ";
            echo "<input name='host_name' type='hidden'>";
            echo "<input name='hostname' type='text' value='". get_hostname() ."'>";
            echo "<br><br>";
            echo "<input type='submit' value='Change hostname'>";
            echo "</form>";
        }

        function get_hostname()
        {            
            $_hostname = file_get_contents('/etc/hostname');
            if (strlen($_hostname) > 0)
                return $_hostname;
            return "";
        }
    ?>
</div>
