<!-- Sliders & DDL for Lighting controls -->
<div style="padding-left:16px">
    <h3> Lighting controls </h3>
    <?php
        $_progslct = 0;
        $_rotation = 0;
        $_intensity = 128;
        session_start();
        if (isset($_SESSION['login']) && $_SESSION['login'] = 'success')
        {
            if (isset($_REQUEST['lighting_control']))
            {
                lighting_control();
                unset($_REQUEST['lighting_control']);
            }
            if (isset($_REQUEST['stop_motor']))
            {
                stop_motor();
                unset($_REQUEST['stop_motor']);
            }
            display_form();
        }
        else echo "You have to login";

        function stop_motor()
        {
            if ($_REQUEST['stop_motor'] == 'stop_motor')
            {
                $_cmnd = 'sudo /home/nebula/scripts/stop_motor.py';
                $output = shell_exec($_cmnd);
                if ($output == NULL) echo "Error";
            }
        }

        function lighting_control()
        {
            global $_progslct;
            global $_rotation;
            global $_intensity;
            $_progslct = isset($_POST['prog_ddl']) ? $_POST['prog_ddl'] : 0;
            $_rotation = isset($_POST['rotation']) ? $_POST['rotation'] : 0;
            $_intensity = isset($_POST['brightness']) ? $_POST['brightness'] : 128;
            $_cmnd = 'sudo /home/nebula/scripts/lighting_control.py';
            $cmnd_args = $_cmnd . ' ';
            $cmnd_args .= $_rotation .' '. $_intensity .' '. $_progslct;
            $output = shell_exec($cmnd_args);
            if ($output == NULL) echo "Error";
        }

        function display_form()
        {
            global $_rotation;
            global $_intensity;
            echo "<form method='POST' action='#'>";
            echo "<input name='lighting_control' type='hidden'>";
            echo "<input type='hidden' name='stop_motor' id='stop_motor'>";
            echo "<input type='hidden' name='rotation' id='rotation'>";
            echo "<input type='hidden' name='brightness' id='brightness'>";
            echo "<label> Rotation </label>";
            echo "<input type='range' name='s_rot' id='s_rot' min='-100' max='100' value='".$_rotation."'>";
            echo "<br><br>";
            echo "<label> Brightness </label>";
            echo "<input type='range' name='s_brt' id='s_brt' min='0' max='255' value='".$_intensity."'>";
            echo "<br><br>";
            echo "<p> Select programe <br>";
            echo "<select name='prog_ddl' id='prog_ddl'>";
            echo "<option value='0'>none</option>";
            echo "<option value='1'>5 m</option>";
            echo "<option value='2'>30m</option>";
            echo "<option value='3'>1 h</option>";
            echo "<option value='4'>2 h</option>";
            echo "</select>";
            echo "</p>";
            echo "<br><br>";
            echo "<input type='button' name='btn_stop' id='btn_stop' value='Stop' onclick='javascript:stopmotor();'>";
            echo "<br><br>";
            echo "<input type='submit' name='Update Lighting' onclick='javascript:read_values();'>";
            echo "</form>";
        }
    ?>
</div>
