<?php
session_start();
require_once '../connection.php';

if(isset($_POST)){
  $id=$_GET['id'];

  $data=$con->prepare("SELECT * FROM accounts");
  $data->execute();
  $all_data=$data->fetchAll(PDO::FETCH_ASSOC);

  $payments=$con->prepare("SELECT * FROM payments");
  $payments->execute();
  $all_payments=$payments->fetchAll(PDO::FETCH_ASSOC);
  $all_payments=json_encode($all_payments, JSON_PRETTY_PRINT);

  $file = fopen('php://output', 'w'); 
  $csv_header=array("Fecha del pago","Balance","Intereses","Pago","Nuevo Balance");
  fputcsv($file, array_values($csv_header));
  if(count($all_data)>0){
    foreach($all_data as $account){
      $new_balance=0.00;
      $id=$account['account_id'];
      $account_name=$account['account_name'];
      $borrow=$account['borrow_amount'];
      $owner=$account['owner'];
      $create_date=date('d-m-Y',strtotime($account['create_date']));
      $active=$account['active'];
      $cycle=$account['cycle'];
      $interests_rate=$account['rate'];

      $show_date=date('d/m/Y',strtotime($account['create_date']));

      $get_history=$con->prepare("SELECT * FROM payments
                                  WHERE account_id=:cid
                                  ORDER BY DATE(payment_date)");
      $get_history->execute([':cid'=>$id]);
      $history=$get_history->fetchAll(PDO::FETCH_ASSOC);
      if(count($history)>0){
        $last_amount=$borrow;
        $last_date=date('Y-m-d',strtotime($create_date));
        foreach($history as $element){
          $payment_id=$element['payment_id'];
          $payment_amount=$element['amount'];
          $payment_date=date('Y-m-d',strtotime($element['payment_date']));

          $date_gap=null;
          $payment_date=date_create($payment_date);
          is_a($last_date, 'DateTime') ? $last_date=$last_date : $last_date=date_create($last_date);
          is_a($date_gap, 'DateTime') ? $date_gap=$date_gap : $date_gap=date_diff($last_date,$payment_date); 
          $date_gap=$date_gap->format("%R%a");
          

          $interests_period=floor($date_gap/$cycle);
          $interests_period >= 1 ? $interest_percent=$interests_rate*$interests_period : $interest_percent=0;

          $interests=round($last_amount*$interest_percent,2);
          $previous_balance=$last_amount;
          $last_amount-=round($payment_amount,2);
          $new_balance=$last_amount+$interests;
          $last_amount=$new_balance;
            
           
          $csv_output=array($payment_date->format('d/m/Y'),$previous_balance,$interests,$payment_amount,$new_balance);
          header('Content-Type: text/csv');
          header('Content-Disposition: attachment; filename="payments.csv"');
          header('Pragma: no-cache');
          header('Expires: 0');
          fputcsv($file, array_values($csv_output));

          $last_date=date_create(date('Y-m-d',strtotime($element['payment_date'])));
        }
      }
    }
  } 
  fclose($file);
}  
?>