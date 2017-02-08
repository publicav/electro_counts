<ul>
    <?php
    \base\mainMenu::getMenu( $this->_FileMainMenu )->render();
    \pdo\GetUser::GetUser( $this->_auth )->render();
    ?>
</ul>