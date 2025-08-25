<?php
require_once 'includes/config.php';

session_unset();
session_destroy();

session_start();
$_SESSION['show_login_modal'] = true;

header('Location: index.php');
exit;
?>
