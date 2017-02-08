<ul>
    <?php
    base\mainMenu::getMenu( $this->_FileMainMenu )->render();

    //    $content = '';
    //    $countMainMenu = count( $this->_mainMenu );
    //    for ( $i = 0; $i < $countMainMenu; $i++ ) {
    //        $content .= "<li>
    //                            <a id=\"{$this->_mainMenu[$i]->id_a}\" href=\"{$this->_mainMenu[$i]->url}\">{$this->_mainMenu[$i]->name}</a>
    //					  </li>
    //			";
    //    }
    //    echo $content;
    \pdo\GetUser::GetUser( $this->_auth )->render();
    ?>
</ul>