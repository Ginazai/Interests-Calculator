<?php
session_start();
require_once '../connection.php';

if(isset($_POST)){
	$id=$_GET['id'];

	$insert_payment = $con->prepare("INSERT INTO payments (account_id,amount,payment_date) VALUES (:ai,:am,:pd)");
	$insert_payment->execute([
		":ai"=> $id,
		":am"=> $_POST['payment_amount'],
		":pd"=> $_POST['payment_date']
	]);

	echo("<script type='application/javascript'>window.location='../../index.php';</script>");
}
?>