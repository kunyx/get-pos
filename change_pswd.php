<!-- Change password form -->
<div style="padding-left:16px">
    <?php
        session_start();
        if (isset($_SESSION['login']) && $_SESSION['login'] = 'success')
        {
            if (isset($_REQUEST['password']))
                save_pswd();
            else display_change_pswd();
        }
        else echo "You have to login";

        function save_pswd()
        {
            unset($_REQUEST['change_pswd']);
            $_pswd = $_REQUEST['password'];
            if (file_put_contents('/home/nebula/conf/www/_pswd.txt', $_pswd) == FALSE)
                echo "Cannot write password to file";
        }

        function display_change_pswd()
        {
            echo "<form method='POST' action='change_pswd.php'>";
            echo "<br><br>";
            echo "New admin password ";
            echo "<input name='change_pswd' type='hidden'>";
            echo "<input name='password' type='password'>";
            echo "<br><br>";
            echo "<input type='submit' value='Change password'>";
            echo "</form>";
        }
    ?>
</div>
