<ul>
<?php

	$content = '';
	for($i=0; $i < SizeOf($this->_mainMenu); $i++){
            $content .= '<li>
								<a id="' . $this->_mainMenu[$i]->id_a . '" href="' . $this->_mainMenu[$i]->url . '">' . $this->_mainMenu[$i]->name . '</a>
						  </li>
			';
	}
	
	if ( !is_null($this->_auth ) ) $content .= '<div class="user"><div class="title_user">Вы зашли как:</div>' . $this->_user['name'] . ' ' . $this->_user['family'] .  '</div>';
	echo $content;
?>

</ul>

