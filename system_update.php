<!-- Update system form -->
<div style="padding-left:16px">
    <?php
        session_start();
        if (isset($_SESSION['login']) && $_SESSION['login'] = 'success')
        {
            if (isset($_REQUEST['system_update']))
            {
                system_update();
                echo '<script type="text/javascript">setTimeout(function(){window.top.location="home.php"} , 20000);</script>';
            }
            else display_form();
        }
        else echo "You have to login";

        function system_update()
        {
            unset($_REQUEST['system_update']);
            $_cmnd = 'sudo /home/nebula/scripts/system-update.sh';
            $output = shell_exec($_cmnd);
            if ($output == NULL)
                echo "Cannot update system";
        }

        function display_form()
        {
            echo "<form method='POST' action='system_update.php'>";
            echo "<input name='system_update' type='hidden'>";
            echo "<br><br>";
            echo "<input type='submit' value='Update system'>";
            echo "</form>";
        }
    ?>
</div>
