<?php
mb_internal_encoding('UTF-8');
$db = \db::getLink();
$pdo = $db->getDb();
base\Auth::sessionStart();
