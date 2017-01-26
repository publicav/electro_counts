<?php
    mb_internal_encoding('UTF-8'); 
    
   $type['success'] = true;
   $type['message'] = 'Пользователь разлогинился';
   session_start();
   unset($_SESSION['sid']);
   session_destroy(); // разрушаем сессию
   echo json_encode($type);
