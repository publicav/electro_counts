<?php
function myAutoload($classname) {
    $filename = $classname .".php";
    include_once($filename);
}
 
// регистрируем загрузчик
spl_autoload_register('myAutoload');
?>