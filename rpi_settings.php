<html>
<head>
	<title> RPi settings </title>
	<meta charset="UTF-8" />
    <link rel="stylesheet" href="top_nav.css">
    <script type="text/javascript">
        function eth_values() {
            var arg_ipadrs = document.getElementById('arg_ipadrs').value;
            var arg_routers = document.getElementById('arg_routers').value;
            var arg_dns = document.getElementById('arg_dns').value;
            var subnet_ddl = document.getElementById('subnet_ddl').value;
            alert(arg_ipadrs +'/'+ subnet_ddl + '  ' + arg_routers + '  ' + arg_dns);
        }

        function wifi_values() {
            var arg_ipadrs = document.getElementById('arg_ipadrs').value;
            var arg_routers = document.getElementById('arg_routers').value;
            var arg_dns = document.getElementById('arg_dns').value;
            var subnet_ddl = document.getElementById('subnet_ddl').value;
            var arg_ssid = document.getElementById('arg_ssid').value;
            var arg_psk = document.getElementById('arg_psk').value;
            alert(arg_ipadrs +'/'+ subnet_ddl + '  ' + arg_routers + '  ' + arg_dns);
        }
    </script>
    <?php
        $menu = array(
            'reboot' => 'Reboot',
            'reset_settings' => 'Reset settings',
            'system_update' => 'System update',
            'change_pswd' => 'Change password',
            'host_name' => 'Host name',
            'ap_conf' => 'AP config',
            'wlan_conf' => 'Wifi config',
            'eth_conf' => 'Ethernet config'
        );
        $title='RPi settings';
        function generateMenu()    {
            global $menu,$default,$title;
            echo '    <ul>';
            $p = isset($_GET['p']) ? $_GET['p'] : $default;
            foreach ($menu as $link=>$item)    {
                $class='';
                if ($link==$p)    {
                    $class=' class="selected"';
                    $title=$item;
                }
                echo '<li><a href="?p='.$link.'"'.$class.'>'.$item.'</a></li>';
            }
            echo '</ul>';
        }
    ?> 
</head>

<body>
	<div class="topnav">
		<a href="?p=reboot"> Reboot</a>
		<a href="?p=reset_settings">Reset settings</a>
		<a href="?p=system_update">System update</a>
		<a href="?p=change_pswd">Change password</a>
		<a href="?p=host_name">Host name</a>
		<a href="?p=ap_conf">AP config</a>
		<a href="?p=wlan_conf">Wifi config</a>
		<a href="?p=eth_conf">Ethernet config</a>
	</div>
	<div style="padding-left:16px">
		<?php
			$default = 'reboot';
			$page = isset($_GET['p']) ? $_GET['p'] : $default;
			$page = basename($page);
			if (!file_exists(''.$page.'.php')) {
				$page = $default;
			}
			include(''.$page.'.php');
		?> 
	</div>
</body>
</html>
