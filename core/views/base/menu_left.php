<nav id="navbar">
    <ul id="left-menu">
        <?php
        $menu_left = '';
        $leftMenu = $this->_leftMenu;
        $countLeftMenu = count( $leftMenu );
        for ( $i = 0; $i < $countLeftMenu; $i++ ) {
            if ( !is_null( $leftMenu[ $i ][0]['li_id'] ) )
                $li_id = "id=" . $leftMenu[ $i ][0]['li_id'];
            else $li_id = '';

            $menu_left .=
                "<li $li_id>
                    <a  id=\"{$leftMenu[$i][0]['id_a']}\" href=\"{$leftMenu[$i][0]['id_a']}\"><i class=\"{$leftMenu[$i][0]['icon']}\"></i>{$leftMenu[$i][0]['name']}</a>
                </li>
			";
            if ( count( $leftMenu[ $i ] ) > 1 ) {
                $j = 1;
                $menu_left .= "<ul id=\"submenu\" class=\"hide-submenu\">";
                while ( $j < count( $leftMenu[ $i ] ) ) {
                    $menu_left .=
                        "<li>
                            <a  id=\"{$leftMenu[$i][$j]['id_a']}\" href=\"{$leftMenu[$i][$j]['id_a']}\"><i class=\"{$leftMenu[$i][$j]['icon']}\"></i>{$leftMenu[$i][$j]['name']}</a>
                        </li>";
                    $j++;

                }
                $menu_left .= "</ul>";

            }
        }
        echo $menu_left;
        ?>

    </ul>
</nav>