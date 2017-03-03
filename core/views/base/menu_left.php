<nav id="navbar">
    <ul id="left-menu">
        <?php
        $menu_left = '';
        $countLeftMenu = count( $this->_leftMenu );
        for ( $i = 0; $i < $countLeftMenu; $i++ ) {
            $menu_left .=
                "<li>
                    <a  id=\"{$this->_leftMenu[$i]['id_a']}\" href=\"{$this->_leftMenu[$i]['id_a']}\"><i class=\"{$this->_leftMenu[$i]['icon']}\"></i>{$this->_leftMenu[$i]['name']}</a>
                </li>
			";
        }
        echo $menu_left;
        ?>

    </ul>
</nav>