<?php
$sq = "SELECT l.id, l.name FROM  lots AS l;";
if ($res = $db_li->query($sq)) {
    while ($row = $res->fetch_assoc()) {
        $lots[] = $row;              
    }
    $res->free();
}
?>