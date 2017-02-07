<ul>
    <?php
    $content = '';
    $countMainMenu = count( $this->_mainMenu );
    for ( $i = 0; $i < $countMainMenu; $i++ ) {
        $content .= "<li>
                            <a id=\"{$this->_mainMenu[$i]->id_a}\" href=\"{$this->_mainMenu[$i]->url}\">{$this->_mainMenu[$i]->name}</a>
					  </li>
			";
    }
    if ( !is_null( $this->_auth ) ) {
        $user = pdo\GetUser::GetUser( $this->_auth );
        $content .= "<div class=\"user\"><div class=\"title_user\">Вы зашли как:</div>{$user['name']} {$user['family']}</div>";
    }
    echo $content;
    ?>
</ul>