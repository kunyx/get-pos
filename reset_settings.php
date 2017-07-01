<!-- Reset settings form -->
<div style="padding-left:16px">
    <?php
        session_start();
        if (isset($_SESSION['login']) && $_SESSION['login'] = 'success')
        {
            if (isset($_REQUEST['reset_settings']))
            {
                reset_settings();
                echo '<script type="text/javascript">setTimeout(function(){window.top.location="home.php"} , 20000);</script>';
            }
            else display_form();
        }
        else echo "You have to login";

        function reset_settings()
        {
            unset($_REQUEST['reset_settings']);
            $_cmnd = 'sudo /home/nebula/scripts/reset-settings.sh';
            $output = shell_exec($_cmnd);
            if ($output == NULL)
                echo "Cannot reset settings";
        }

        function display_form()
        {
            echo "<form method='POST' action='#'>";
            echo "<input name='reset_settings' type='hidden'>";
            echo "<br><br>";
            echo "<input type='submit' value='Reset settings'>";
            echo "</form>";
        }
    ?>
</div>
