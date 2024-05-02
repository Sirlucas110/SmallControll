<?php
session_start();
unset($_SESSION['order']);
 
$message = ['status' => 'success', 'message' => '', 'redirect'=> 'orders'];
echo json_encode($message);
return; 
