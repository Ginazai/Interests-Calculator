<?php
session_start();
require_once '../connection.php';

if(isset($_POST)){
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

	echo("<script type='application/javascript'>window.location='../../index.php';</script>");
}
?>