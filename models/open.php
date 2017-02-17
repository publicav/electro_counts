<?php
mb_internal_encoding( 'UTF-8' );
$pdo = \db::getLink()->getDb();
Base\Auth::sessionStart();