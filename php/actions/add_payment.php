<?php
session_start();
require_once '../connection.php';

if(isset($_POST)){
	$id=$_GET['id'];
	$payment_amount=$_POST['payment_amount_'.$id];
	$payment_date=$_POST['payment_date_'.$id];

	if(!empty($payment_amount)&&!empty($payment_date)
		&&intval($payment_amount)>0)
	{
		$insert_payment = $con->prepare("INSERT INTO payments (account_id,amount,create_date) VALUES (:ai,:am,:pd)");
		$insert_payment->execute([
			":ai"=> $id,
			":am"=> $payment_amount,
			":pd"=> $payment_date
		]);

		echo("<script type='application/javascript'>window.location='../../index.php';</script>");
	} else {
		$_SESSION['error']=true;
		$_SESSION['error_msg']="Ocurrio un error al subir la informacion. Verifique e intente otra vez.";
		echo("<script type='application/javascript'>window.location='../../index.php';</script>");
	}
}
?>