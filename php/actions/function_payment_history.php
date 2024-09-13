<?php
function get_payment_history(){
  $host="localhost";
  $user="";
  $password="";
  $db="interets_calculator";

  $dsn = "mysql:host=$host;dbname=$db";
  $con = new PDO($dsn, $user, $password);
  
  $query_history=array();

  $data=$con->prepare("SELECT * FROM accounts");
  $data->execute();
  $all_data=$data->fetchAll(PDO::FETCH_ASSOC);

  if(count($all_data)>0){
    foreach($all_data as $account){
      $account_data=array();
      $new_balance=0.00;
      $id=$account['account_id'];
      $account_name=$account['account_name'];
      $borrow=$account['borrow_amount'];
      $owner=$account['owner'];
      $create_date=date('d-m-Y',strtotime($account['create_date']));
      $active=$account['active'];
      $cycle=$account['cycle'];
      $interests_rate=$account['rate'];

      $account_data['account_id']=$id;
      $account_data['borrow_amount']=$borrow;
      $account_data['owner']=$owner;
      $account_data['create_date']=$create_date;
      $account_data['active']=$active;
      $account_data['cycle']=$cycle;
      $account_data['interests_rate']=$interests_rate;
      $account_data['payments']=array();

      $query_history[$account_name]=$account_data;

      $show_date=date('d/m/Y',strtotime($account['create_date']));

      $get_history=$con->prepare("SELECT * FROM payments
                                  WHERE account_id=:cid
                                  ORDER BY DATE(create_date)");
      $get_history->execute([':cid'=>$id]);
      $history=$get_history->fetchAll(PDO::FETCH_ASSOC);
      if(count($history)>0){
        $last_amount=$borrow;
        $last_date=date('Y-m-d',strtotime($create_date));
        foreach($history as $element){
          $payment_data=array();
          $payment_id=$element['payment_id'];
          $payment_amount=$element['amount'];
          $payment_date=date('Y-m-d',strtotime($element['create_date']));

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

          
          $payment_data['payment_id']=$payment_id;
          $payment_data['create_date']=$payment_date->format('d/m/Y');
          $payment_data['previous_balance']=round($previous_balance,2);
          $payment_data['interests']=$interests;
          $payment_data['payment_amount']=round($payment_amount,2);
          $payment_data['new_balance']=$new_balance;

          array_push($query_history[$account_name]['payments'], $payment_data);
          $last_date=date_create(date('Y-m-d',strtotime($element['create_date'])));
        }
      }
    }
  } 
  return $query_history;
}
?>