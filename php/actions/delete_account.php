<?php
session_start();
require_once '../connection.php';

if(isset($_POST)){
	$id=$_GET['id'];

	$delete_account = $con->prepare("UPDATE accounts SET deleted=1 WHERE account_id=:aid");
	$delete_account->execute([":aid"=>$id]);

	echo("<script type='application/javascript'>window.location='{$_SERVER['HTTP_REFERER']}';</script>");
}