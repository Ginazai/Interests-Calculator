<?php
session_start();
require_once '../connection.php';
if(isset($_POST)){
  $get_data=$con->prepare("SELECT * FROM( 
                          SELECT account_id as id,create_date,null as interests,borrow_amount as debit,null as credit 
                          FROM accounts 
                          UNION 
                          SELECT account_id,create_date,null,null,amount FROM payments
                          UNION 
                          SELECT account_id,create_date,interests_from_payment,null,null FROM payments) AS csv_data 
                          ORDER BY DATE(create_date) ASC"); 
  
  $get_data->execute();
  $all_data=$get_data->fetchAll(PDO::FETCH_ASSOC);
  $file = fopen('php://output', 'w');       
  if($all_data>0){
    $fname="borrowing_data_as_of_".date('d-m-Y',strtotime(date_default_timezone_get())).".csv";
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="'.$fname.'"');
    header('Pragma: no-cache');
    header('Expires: 0');
    $csv_header=array("Referencia","Fecha","Descripcion","Debito","Credito");
    fputcsv($file, array_values($csv_header));
    foreach($all_data as $element){
      $data_type=array_keys((array)$element);
      $fecha=date('d/m/Y',strtotime($element['create_date']));
      $descripcion="";
      $referencia=$element['id'];
      $debito=$element['debit'];
      $credito=$element['credit'];
      $intereses=$element['interests'];

      if($debito!=NULL){
        $descripcion="Prestamo de $".$debito." otorgado";
        $credito="";
      }
      else if($credito!=NULL) {
        $descripcion="pago por $".$credito." realizado";
        $debito="";
      }
      else if($intereses!=NULL&&$intereses>0){
        $descripcion="Intereses acomulados en la cuenta";
        $debito=$intereses;
        $credito="";
      } else {continue;}
      
      $last_elem = end($all_data);

      $csv_output=array($referencia,$fecha,$descripcion,$debito,$credito);
      fputcsv($file, array_values($csv_output)); 
      
    }    
  }
  fclose($file);
}  
?>