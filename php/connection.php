<?php
$host="localhost";
$user="root";
$password="";
$db="interets_calculator_v1.5";

$dsn = "mysql:host=$host;dbname=$db";
$con = new PDO($dsn, $user, $password);

?>