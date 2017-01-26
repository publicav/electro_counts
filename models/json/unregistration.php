<?php
   $type['success'] = true;
   $type['message'] = 'Пользователь разлогинился';
   session_start();
   unset($_SESSION['sid']);
   session_destroy(); // разрушаем сессию
   echo json_encode($type);
