<!-- Ethernet config form -->
<div style="padding-left:16px">
    <h3> Ethernet config </h3>
    <?php
        $_ipadrs = "";
        $_routers = "";
        $_dns = "";
        $_subnet = "";
        $errors = array();
        session_start();
        if (isset($_SESSION['login']) && $_SESSION['login'] = 'success')
        {
            load_eth_config();
            if (isset($_REQUEST['if_mode']))
            {
                if_config();
                unset($_REQUEST['if_mode']);
                echo '<script type="text/javascript">setTimeout(function(){window.top.location="home.php"} , 20000);</script>';
            }
            else
            {
                display_form();
                save_eth_config();
            }
        }
        else echo "You have to login";

        function if_config()
        {
            $_iface = "eth0";
            $_ifdeny = "wlan0";
            global $_ipadrs;
            global $_routers;
            global $_dns;
            global $_subnet;
            global $errors;
            if (isset($_REQUEST['rb_mode']))
                $_SESSION['if_mode'] = $_REQUEST['rb_mode'];
            else $_SESSION['if_mode'] = '0';
            if (isset($_SESSION['if_mode']) && $_SESSION['if_mode'] == '1')
            {
                $_ipadrs = isset($_REQUEST['arg_ipadrs']) ? $_REQUEST['arg_ipadrs'] : "";
                $_routers = isset($_REQUEST['arg_routers']) ? $_REQUEST['arg_routers'] : "";
                $_dns = isset($_REQUEST['arg_dns']) ? $_REQUEST['arg_dns'] : "";
                $_subnet = isset($_REQUEST['subnet_ddl']) ? $_REQUEST['subnet_ddl'] : "";
            }
            if ($_iface == "eth0" && $_ifdeny == "wlan0")
            {
                $_cmnd = 'sudo /home/nebula/scripts/if_config.sh';
                $cmnd_args = $_cmnd . ' ';
                if (isset($_SESSION['if_mode']) && $_SESSION['if_mode'] == '0')
                    $cmnd_args .= $_iface  .' '.  $_ifdeny;
                else
                {
                    if ($_ipadrs != "" && $_routers != "" && $_dns != "")
                        $cmnd_args .= $_iface .' '. $_ifdeny .' '. $_ipadrs .' '. $_routers .' '. $_dns .' '. $_subnet;
                    else $errors[] = "<font color='red'>Missing or incorrect params</font>";
                }
                $output = shell_exec($cmnd_args);
                if ($output == NULL)
                    $errors[] = "<font color='red'>Cannot config Ethernet</font>";
            }
        }

        function display_form()
        {
            global $_ipadrs;
            global $_routers;
            global $_dns;
            global $_subnet;
            global $errors;
            unset($errors);
            $_mode = isset($_SESSION['if_mode']) ? $_SESSION['if_mode'] : '0';
            echo "<form id='display_form' method='POST' action='#'>";
            echo "<input name='if_mode' type='hidden'>";
            if ($_mode == '0')
            {
                echo "<input name='rb_mode' type='radio' onclick='document.getElementById(\"display_form\").submit();' value='0' checked='checked'>DHCP<br>";
                echo "<input name='rb_mode' type='radio' onclick='document.getElementById(\"display_form\").submit();' value='1'>STATIC<br>";
                $_style = 'display:none; visibility: hidden;';
            }
            if ($_mode == '1')
            {
                echo "<input name='rb_config' type='radio' onclick='document.getElementById(\"display_form\").submit();' value='0'>DHCP<br>";
                echo "<input name='rb_config' type='radio' onclick='document.getElementById(\"display_form\").submit();' value='1' checked='checked'>STATIC<br>";
                $_style = 'display:block; visibility: visible;';
            }
            echo "<br><br>";
            //display_errors();
            echo "<div style='". $_style ."'>";
            echo "<label> IP Address </label>";
            echo "<input type='text'name='arg_ipadrs' id='arg_ipadrs' value='".$_ipadrs."'>";
            echo "<br><br>";
            echo "<label> Gateway address </label>";
            echo "<input type='text' name='arg_routers' id='arg_routers' value='".$_routers."'>";
            echo "<br><br>";
            echo "<label> DNS server </label>";
            echo "<input type='text' name='arg_dns' id='arg_dns' value='".$_dns."'>";
            echo "<br><br>";
            echo "<p> Select subnet <br>";
            echo "<select name='subnet_ddl' id='subnet_ddl'>";
            echo "<option value='24'>24</option>";
            echo "<option value='16'>16</option>";
            echo "<option value='8'>8</option>";
            echo "<option value='32'>32</option>";
            echo "</select>";
            echo "</p>";
            echo "<br><br>";
            echo "</div>";
            echo "<input type='submit' value='Update Ethernet' onclick='eth_values();'>";
            echo "</form>";
        }

        function save_eth_config()
        {
            global $_ipadrs;
            global $_routers;
            global $_dns;
            global $_subnet;
            $_ipadrs = trim($_ipadrs);
            $_routers = trim($_routers);
            $_dns = trim($_dns);
            $_subnet = trim($_subnet);
            $eth_config = "_ipadrs,". $_ipadrs .PHP_EOL
                         ."_routers,". $_routers .PHP_EOL
                         ."_dns,". $_dns .PHP_EOL
                         ."_subnet,". $_subnet .PHP_EOL;
            file_put_contents('/home/nebula/conf/www/eth_config.csv', $eth_config);
        }

        function load_eth_config()
        {
            global $_ipadrs;
            global $_routers;
            global $_dns;
            global $_subnet;
            $eth_config = array_map('str_getcsv', file('/home/nebula/conf/www/eth_config.csv'));
            $_ipadrs = $eth_config[0][0] == "_ipadrs" ? $eth_config[0][1] : "";
            $_routers = $eth_config[1][0] == "_routers" ? $eth_config[1][1] : "";
            $_dns = $eth_config[2][0] == "_dns" ? $eth_config[2][1] : "";
            $_subnet = $eth_config[3][0] == "_subnet" ? $eth_config[3][1] : "";
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
