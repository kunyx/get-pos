<html>
<head>
	<title> Lighting control </title>
	<meta charset="UTF-8" />
    <link rel="stylesheet" href="top_nav.css">
    <script type="text/javascript">
        function read_values() {
            var rotation = document.getElementById('s_rot').value;
            document.getElementById('rotation').value = rotation;
            var brightness = document.getElementById('s_brt').value;
            document.getElementById('brightness').value = brightness;
            var prog_slct = document.getElementById('prog_ddl').value;
            alert(rotation + '  ' + brightness + '  ' + prog_slct);
        }

        function stopmotor() {
            document.getElementById('stop_motor').value = 'stop_motor';
            alert('stop_motor');
        }
    </script>
    <?php
        $menu = array(
            'sliders' => 'Sliders',
            'pairing' => 'Pairing'
        );
        $title='Lighting control'; 
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
		<a href="?p=sliders"> Sliders</a>
		<a href="?p=pairing">Pairing</a>
	</div>
	<div style="padding-left:16px">
		<?php
			$default = 'sliders';
			$page = isset($_GET['p']) ? $_GET['p'] : $default;
			$page = basename($page);
			if (!file_exists(''.$page.'.php'))    {
				$page = $default;
			}
			include(''.$page.'.php');
		?> 
	</div>
</body>
</html>
