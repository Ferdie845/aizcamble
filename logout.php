<?php
session_start();


unset($_SESSION['user_id']);
unset($_SESSION['username']); 


$_SESSION['logout_msg'] = "You have been successfully logged out.";


header("Location: user/login.php");
exit;
