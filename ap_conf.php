<!-- AP config form -->
<div style="padding-left:16px">
    <h3> AP config </h3>
    <?php
        $_ssid = "";
        $_psk = "";
        $_chnl = "";
        $_bool = FALSE;
        $errors = array();
        session_start();
        if (isset($_SESSION['login']) && $_SESSION['login'] = 'success')
        {
            load_ap_config();
            if (isset($_REQUEST['if_mode']))
            {
                ap_config();
                unset($_REQUEST['if_mode']);
                echo '<script type="text/javascript">setTimeout(function(){window.top.location="home.php"} , 20000);</script>';
            }
            else
            {
                display_form();
                save_ap_config();
            }
        }
        else echo "You have to login";

        function ap_config()
        {
            global $_ssid;
            global $_psk;
            global $_chnl;
            global $_bool;
			global $errors;
            if (isset($_REQUEST['arg_ssid']))
                $_ssid = $_REQUEST['arg_ssid'];
            if (isset($_REQUEST['arg_psk']))
                $_psk = $_REQUEST['arg_psk'];
            if (isset($_REQUEST['arg_chnl']))
            {
                $_chnl = $_REQUEST['arg_chnl'];
                if (is_numeric($_chnl))
                {
                    $_val = (int)$_chnl;
                    if ($_val > 0 && $_val < 10)
                        $_chnl = (string)$_val;
                    else $_chnl = "";
                }
                else $_chnl = "";
            }
            if (isset($_REQUEST['rb_mode']))
                $_SESSION['if_mode'] = $_REQUEST['rb_mode'];
            else $_SESSION['if_mode'] = '0';
            if (isset($_SESSION['if_mode']) && $_SESSION['if_mode'] == '1')
            {
                $_ssid = isset($_REQUEST['arg_ssid']) ? $_REQUEST['arg_ssid'] : "";
                $_psk = isset($_REQUEST['arg_psk']) ? $_REQUEST['arg_psk'] : "";
                $_chnl = isset($_REQUEST['arg_chnl']) ? $_REQUEST['arg_chnl'] : "";
                if (is_numeric($_chnl))
                {
                    $_val = (int)$_chnl;
                    if ($_val > 0 && $_val < 10)
                        $_chnl = (string)$_val;
                    else $_chnl = "";
                }
            }
            if ($_ssid != "" && $_psk != "" && $_chnl != "")
            {
                $_cmndargs = 'sudo /home/nebula/scripts/ap_config.sh ' . $_ssid . ' ' . $_psk . ' ' . $_chnl . ' ' . $_bool;
                $output = shell_exec($_cmndargs);
                if ($output == NULL)
                    $errors[] = "<font color='red'>Cannot config AP</font>";
            }
            else $errors[] = "<font color='red'>Missing or incorrect params</font>";
        }

        function display_form()
        {
            global $_ssid;
            global $_psk;
            global $_chnl;
            global $_bool;
			global $errors;
            unset($errors);
            $_mode = isset($_SESSION['if_mode']) ? $_SESSION['if_mode'] : '0';
            echo "<form id='display_form' method='POST' action='#'>";
            echo "<input name='if_mode' type='hidden'>";
            if ($_mode == '0')
            {
                $_bool = FALSE;
                echo "<input name='rb_mode' type='radio' onclick='document.getElementById(\"display_form\").submit();' value='0' checked='checked'>DISABLE<br>";
                echo "<input name='rb_mode' type='radio' onclick='document.getElementById(\"display_form\").submit();' value='1'>ENABLE<br>";
                $_style = 'display:none; visibility: hidden;';
            }
            if ($_mode == '1')
            {
                $_bool = TRUE;
                echo "<input name='rb_config' type='radio' onclick='document.getElementById(\"display_form\").submit();' value='0'>DISABLE<br>";
                echo "<input name='rb_config' type='radio' onclick='document.getElementById(\"display_form\").submit();' value='1' checked='checked'>ENABLE<br>";
                $_style = 'display:block; visibility: visible;';
            }
            echo "<br><br>";
            //display_errors();
            echo "<div style='". $_style ."'>";
            echo "<label> AP SSID </label>";
            echo "<input name='arg_ssid' type='text' value='".$_ssid."'>";
            echo "<br><br>";
            echo "<label> AP PSK </label>";
            echo "<input name='arg_psk' type='text' value='".$_psk."'>";
            echo "<br><br>";
            echo "<label> AP CHANEL </label>";
            echo "<input name='arg_chnl' type='text' value='".$_chnl."'>";
            echo "<br><br>";
            echo "</div>";
            echo "<input type='submit' value='Update AP'>";
            echo "</form>";
        }

        function save_ap_config()
        {
            global $_ssid;
            global $_psk;
            global $_chnl;
            $_ssid = trim($_ssid);
            $_psk = trim($_psk);
            $_chnl = trim($_chnl);
            $ap_config = "_ssid,". $_ssid .PHP_EOL
                        ."_psk,". $_psk .PHP_EOL
                        ."_chnl,". $_chnl .PHP_EOL;
            file_put_contents('/home/nebula/conf/www/ap_config.csv', $ap_config);
        }

        function load_ap_config()
        {
            global $_ssid;
            global $_psk;
            global $_chnl;
            $apc_array = array_map('str_getcsv', file('/home/nebula/conf/www/ap_config.csv'));
            $_ssid = $apc_array[0][0] == "_ssid" ? $apc_array[0][1] : "";
            $_psk = $apc_array[1][0] == "_psk" ? $apc_array[1][1] : "";
            $_chnl = $apc_array[2][0] == "_chnl" ? $apc_array[2][1] : "";
        }

		function display_errors()
		{
			global $errors;
            if (count($errors) == 0)
                $_style = 'display:none; visibility: hidden;';
            else $_style = 'display:block; visibility: visible;';
            echo "<div style='". $_style ."'>";
			foreach ($errors as $err) {
				echo $err, "<br>";
			}
            echo "</div>";
		}
    ?>
</div>
