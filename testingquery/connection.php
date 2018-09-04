<?php
global $db;
$strHostname = "localhost";
$strUsername = "root";
$strPassword = "";
$strDbname = "querytesting";

$db = new PDO("mysql:host=$strHostname;dbname=$strDbname;",$strUsername,$strPassword);
?>