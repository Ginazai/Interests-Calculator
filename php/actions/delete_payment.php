<?php
session_start();
require_once '../connection.php';

if(isset($_POST)){
	$id=$_GET['id'];

	$delete_payment = $con->prepare("DELETE FROM payments WHERE payment_id=:pid");
	$delete_payment->execute([":pid"=>$id]);

	echo("<script type='application/javascript'>window.location='{$_SERVER['HTTP_REFERER']}';</script>");
}
?>