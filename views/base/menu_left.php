<div id="menu_left" class="left-box">
<ol>
<?php
	$menu_left = '';
	for($i=0;$i<SizeOf($menu_left_m);$i++) 
	{
		// if ($menu_left_m[$i]['tek'] == 1) 
		// {
		// 	$menu_left .= '<li class="act">
		// 						<a id="' . $menu_left_m[$i]['id_a'] . '"href="' . $menu_left_m[$i]['url'] . '">' . $menu_left_m[$i]['name'] . '</a>
		// 				  </li>
		// 	';
		// }
		// else 
		
			$menu_left .= '<li class="menu_childs1'  . '">
								<a  id="' . $menu_left_m[$i]['id_a'] . '" href="' . $menu_left_m[$i]['url'] . '">' . $menu_left_m[$i]['name'] . '</a>
						  </li>
			';
		
	}
	echo $menu_left;
?>

</ol>
</div>