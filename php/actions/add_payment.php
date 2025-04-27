<?php
session_start();
require_once '../connection.php';

if(isset($_POST)){
	$id=$_GET['id'];
	$payment_amount=$_POST['payment_amount_'.$id];
	$payment_date=$_POST['payment_date_'.$id];

	$get_method = $con->prepare("SELECT methods.method_name 
								FROM accounts JOIN methods ON accounts.method_id = methods.method_id 
								WHERE accounts.account_id = :aid");
	$get_method->execute([":aid"=>$id]);
	$method = $get_method->fetch(PDO::FETCH_ASSOC);
	$m_type = $method['method_name'];

	$get_date = $con->prepare("SELECT create_date FROM payments WHERE account_id = :aid ORDER BY create_date ASC");
	$get_date->execute([":aid" => $id]);
	$date = [];
	while($retrieve=$get_date->fetch(PDO::FETCH_ASSOC)){$date = $retrieve;};
	$date = $date['create_date'];

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
		//echo("<script type='application/javascript'>window.location='{$_SERVER['HTTP_REFERER']}';</script>");
	} else {
		$_SESSION['error']=true;
		$_SESSION['error_msg']="Ocurrio un error al subir la informacion. Verifique e intente otra vez.";
		//echo("<script type='application/javascript'>window.location='{$_SERVER['HTTP_REFERER']}';</script>");
	}
}
?>