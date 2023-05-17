<?php
session_start();
unset($_POST);
unset($_SESSION['username']);
unset($_SESSION['razina']);
header("Location: index.php");
exit;
?>