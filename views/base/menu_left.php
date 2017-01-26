<div id="menu_left" class="left-box">
<ol>
<?php
	$menu_left = '';
	for($i=0;$i<SizeOf( $this->_leftMenu );$i++) {
			$menu_left .= '<li class="menu_childs1'  . '">
								<a  id="' . $this->_leftMenu[$i]['id_a'] . '" href="' . $this->_leftMenu[$i]['url'] . '">' . $this->_leftMenu[$i]['name'] . '</a>
						  </li>
			';
	}
	echo $menu_left;
?>

</ol>
</div>