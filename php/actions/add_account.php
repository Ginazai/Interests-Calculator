<?php
session_start();
require_once '../connection.php';

function dataError(){
	if(empty($_POST['accout_name'])||empty($_POST['amount_borrowed'])
		||empty($_POST['borrower'])||empty($_POST['start_date'])
		||empty($_POST['cycle'])||empty($_POST['interest_rate'])

		||!is_numeric($_POST['cycle'])||!is_numeric($_POST['amount_borrowed'])
		||!is_numeric($_POST['interest_rate']))
	{
		return true;
	} else{return false;}
}
if(isset($_POST)&&!dataError()){
	$add_account = $con->prepare("INSERT INTO accounts 
								(account_name,borrow_amount,owner,create_date,active,cycle,rate) 
								VALUES (:an,:bo,:own,:cdt,:act,:cyc,:rt)");
	$add_account->execute([
		":an" => $_POST['accout_name'],
		":bo" => $_POST['amount_borrowed'],
		":own" => $_POST['borrower'],
		":cdt" => $_POST['start_date'],
		":act" => 1,
		":cyc" => $_POST['cycle'],
		":rt" => $_POST['interest_rate']/100
	]);

	$_SESSION['error']=false;
	$_SESSION['error_msg']="";
	echo("<script type='application/javascript'>window.location='{$_SERVER['HTTP_REFERER']}';</script>");
} else {
	$_SESSION['error']=true;
	$_SESSION['error_msg']="Ocurrio un error al subir la informacion. Verifique e intente otra vez.";
	echo("<script type='application/javascript'>window.location='{$_SERVER['HTTP_REFERER']}';</script>");
}
?>