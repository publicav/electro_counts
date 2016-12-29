<?php
$sq = "SELECT l.id, l.name FROM  lots AS l;";
if ($res = $pdo->query( $sq ))$lots = $res->fetchAll();
?>