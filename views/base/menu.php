<ul>
<?php
	$mainfile = '';
	for($i=0;$i<SizeOf($menu_m);$i++) 
	{
		// if ($menu_m[$i]['tek'] == 1) 
		// {
		// 	$mainfile .= '<li class="act">
		// 						<a id="' . $menu_m[$i]['id_a'] . '"href="' . $menu_m[$i]['url'] . '">' . $menu_m[$i]['name'] . '</a>
		// 				  </li>
		// 	';
		// }
		// else 
		{
			$mainfile .= '<li>
								<a id="' . $menu_m[$i]['id_a'] . '" href="' . $menu_m[$i]['url'] . '">' . $menu_m[$i]['name'] . '</a>
						  </li>
			';
		}
	}
	
	if ($sid != 0) $mainfile .= '<div class="user"><div class="title_user">Вы зашли как:</div>' . $user['name'] . ' ' . $user['family'] .  '</div>';
	echo $mainfile;
?>

</ul>

