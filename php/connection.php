<?php
$host="localhost";
$user="";
$password="";
$db="interets_calculator";

$dsn = "mysql:host=$host;dbname=$db";
$con = new PDO($dsn, $user, $password);

?>