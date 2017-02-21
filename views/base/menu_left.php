<div id="menu_left" class="left-box">
    <ol>
        <?php
        $menu_left = '';
        $countLeftMenu = count( $this->_leftMenu );
        for ( $i = 0; $i < $countLeftMenu; $i++ ) {
            // todo-me затычка когда перейдет проект на точку одного входа убрать затычка чтобы не менять базу !!!!!
            if ( $this->_leftMenu[ $i ]['id_a'] == 'add_value' ) {
                $menu_left .= "<li class=\"menu_childs1\">
								<a  id=\"add_value\" href=\"add_value.php\">{$this->_leftMenu[$i]['name']}</a>
						  </li>
			";
            } else {
                $menu_left .= "<li class=\"menu_childs1\">
								<a  id=\"{$this->_leftMenu[$i]['id_a']}\" href=\"{$this->_leftMenu[$i]['id_a']}\">{$this->_leftMenu[$i]['name']}</a>
						  </li>
			";
            }
        }
        echo $menu_left;
        ?>

    </ol>
</div>