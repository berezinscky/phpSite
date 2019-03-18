<?php
require_once "lib/config_class.php";
$config = new Config();
session_start();
unset($_SESSION["user_id"]);
unset($_SESSION["user_login"]);
header("Location: $config->address");
?>