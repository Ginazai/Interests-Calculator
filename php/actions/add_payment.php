<?php
session_start();
require_once '../connection.php';

if(isset($_POST)){
	$id=$_GET['id'];
	$payment_amount=$_POST['payment_amount_'.$id];
	$m_type=$_POST['method_'.$id];

	$get_date = $con->prepare("SELECT create_date FROM payments WHERE account_id = :aid ORDER BY create_date ASC");
	$get_date->execute([":aid" => $id]);
	$prev_date = [];
	while($retrieve=$get_date->fetch(PDO::FETCH_ASSOC)){$prev_date = $retrieve;};

	if(!$prev_date || $prev_date == null || count($prev_date) < 1){
		//SELECT from accounts table rather than payments
		$get_date = $con->prepare("SELECT create_date FROM accounts WHERE account_id = :aid");
		$get_date->execute([":aid" => $id]);
		$prev_date = [];
		while($retrieve=$get_date->fetch(PDO::FETCH_ASSOC)){$prev_date = $retrieve;};
		$prev_date = $prev_date['create_date'];
	} else {
		$prev_date = $prev_date['create_date'];
	}
	//Retrieve cycle
	$get_cycle = $con->prepare("SELECT cycle FROM accounts WHERE account_id = :aid");
	$get_cycle->execute([":aid" => $id]);
	$cycle = [];
	while($retrieve_cycle=$get_cycle->fetch(PDO::FETCH_ASSOC)){$cycle = $retrieve_cycle;};
	$cycle = $cycle['cycle'];
	$range = $cycle == 15 ? ' + 15 days': ' + 30 days';

	$m_type == 1 ? $payment_date=date('Y-m-d', strtotime($prev_date. $range)) : $payment_date=$_POST['payment_date_'.$id];
	//Here goes the rest of the code for automatic dates calc
	if(!empty($payment_amount)&&!empty($payment_date)
		&&intval($payment_amount)>0)
	{
		$insert_payment = $con->prepare("INSERT INTO payments (account_id,amount,create_date) VALUES (:ai,:am,:pd)");
		$insert_payment->execute([
			":ai"=> $id,
			":am"=> $payment_amount,
			":pd"=> $payment_date
		]);
		echo("<script type='application/javascript'>window.location='{$_SERVER['HTTP_REFERER']}';</script>");
	} else {
		$_SESSION['error']=true;
		$_SESSION['error_msg']="Ocurrio un error al subir la informacion. Verifique e intente otra vez.";
		echo("<script type='application/javascript'>window.location='{$_SERVER['HTTP_REFERER']}';</script>");
	}
}
?>