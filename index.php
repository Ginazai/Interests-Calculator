<?php
session_start();
require_once 'php/connection.php';

require_once 'php/actions/function_payment_history.php';
$all_payment_history=get_payment_history();
//Update interests
foreach($all_payment_history as $all_ac){
  $all_pmts=$all_ac['payments'];
  foreach($all_pmts as $pmt){
    $pid=$pmt['payment_id'];
    $interests=$pmt['interests'];
    if($interests!=0.00){
      $insert_interests=$con->prepare("UPDATE payments SET interests_from_payment=:iap WHERE payment_id=:pid");
      $insert_interests->execute([
        ":iap"=>$interests,
        ":pid"=>$pid
      ]);
    }
  }
}
//Recalculate balance
foreach($all_payment_history as $all_ac){
  $acc_id=$all_ac['account_id'];
  $curr_balance=$all_ac['borrow_amount'];
  $curr_status=$all_ac['active'];
  $all_pmts=$all_ac['payments'];
  foreach($all_pmts as $pmt){
    $p_amount=$pmt['payment_amount'];
    $interests=$pmt['interests'];

    $curr_balance=($curr_balance+$interests)-$p_amount;
  }
  //Determine if active, inactivate if not
  if ($curr_balance<=0.00 && $curr_status) {
    $update_status=$con->prepare("UPDATE accounts SET active=:act WHERE account_id=:aid");
      $update_status->execute([
        ":act"=>0,
        ":aid"=>$acc_id
      ]);
  }
}
// Number of records per page
$recordsPerPage = 5;

// Current page number
if (isset($_GET['page'])) {
 $currentPage = $_GET['page'];
} else {
 $currentPage = 1;
}

// Calculate the starting record index
$startFrom = ($currentPage - 1) * $recordsPerPage;

$all_data=[];
$data=$con->prepare("SELECT * FROM accounts WHERE active=1 AND deleted=0 LIMIT $startFrom, $recordsPerPage");
$data->execute();
while($get_data=$data->fetch(PDO::FETCH_ASSOC)){$all_data[]=$get_data;}
$account_data=json_encode($all_data, JSON_PRETTY_PRINT);
$all_payments=[];
$payments=$con->prepare("SELECT * FROM payments");
$payments->execute();
while($payment_row=$payments->fetch(PDO::FETCH_ASSOC)){$all_payments[]=$payment_row;}
$all_payments=json_encode($all_payments, JSON_PRETTY_PRINT);

// Pagination links
$sql = "SELECT COUNT(*) AS total FROM accounts WHERE active=1 AND deleted=0";
$result = $con->query($sql);
$row = $result->fetch(PDO::FETCH_ASSOC);
$totalRecords = $row["total"];
$totalPages = ceil($totalRecords / $recordsPerPage);
?>
<!DOCTYPE html>
<html lang="es" dir="ltr" data-bs-theme="light">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Interests Calculator</title>
    <script 
    src="https://code.jquery.com/jquery-3.7.1.min.js" 
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" 
    crossorigin="anonymous"></script>
    <script 
    src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js" 
    integrity="sha256-lSjKY0/srUM9BE3dPm+c4fBo1dky2v27Gdjm2uoZaL0=" 
    crossorigin="anonymous"></script>
	  <link 
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
    rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
    crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <?= isset($all_payments) ? "<script type='text/javascript'>var all_payments=$all_payments;</script>" : "" ?>
    <?= isset($account_data) ? "<script type='text/javascript'>var all_data=$account_data;</script>" : "" ?>
  </head>
  <body>
    <header><?php require_once "html/navbar.php" ?></header>
    <main class="my-3">
    <div class="container">
      <div id="alert-box" class="alert alert-danger visually-hidden" role="alert">
        <?php 
        if(isset($_SESSION['error'])){
          if($_SESSION['error']){
            echo $_SESSION['error_msg'];
          } 
        } ?>
      </div>
      <div class="row w-100 mx-auto">
    <?php
    if(count($all_data)>0){
      foreach($all_data as $account){
        $new_balance=0.00;
        $id=$account['account_id'];
        $account_name=$account['account_name'];
        $borrow=$account['borrow_amount'];
        $owner=$account['owner'];
        $create_date=date('d-m-Y',strtotime($account['create_date']));
        $active=$account['active'];
        $method=$account['method_id'];
        $deleted=$account['deleted'];
        $cycle=$account['cycle'];
        $interests_rate=$account['rate'];

        $show_date=date('d/m/Y',strtotime($account['create_date']));
        ?>
        <div class="my-2">
          <div class="accordion shadow-lg" id="data-accordion-<?= $id ?>">
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?= $id ?>" aria-expanded="false" aria-controls="collapse-<?= $id ?>">
                  <div class="d-flex justify-content-between w-100">
                    <div class="row">
                      <h3 class="my-0"><?= $account_name ?></h3>
                      <p><?= $owner ?></p>
                      <div class="col-12 m-0"><p>Inicio: <?= $show_date ?></p></div>
                    </div>
                    <div class="ms-auto me-3 h-100 my-auto">
                      <div>
                        <div class="col-12"><p class="float-end my-0">$<?= $borrow ?> (al <b><?=$interests_rate*100?>%</b> de intereses <?=$cycle==15?"quincenal":"mensual"?>)</p></div>
                        <div class="col-12">
                          <p class="float-end my-0"><b><?=$active==1?"activa":"inactiva"?></b></p>
                        </div>
                      </div>
                    </div>             
                  </div>
                </button>
              </h2>
              <div id="collapse-<?= $id ?>" class="accordion-collapse collapse" data-bs-parent="#data-accordion-<?= $id ?>">
                <div class="accordion-body">
                  <a class='btn btn-secondary btn-sm m-1 float-end' href='php/actions/create_csv.php?id=<?=$id?>'><i class="fa fa-download" style="font-size:18px"></i> Descargar CSV</a>     
                  <button class='btn btn-success btn-sm m-1' type='submit' data-bs-toggle='modal' data-bs-target='#add-payment-<?=$id?>'><i class="fa fa-money" style="font-size:18px"></i> Agregar pago</button></br>
                  <button class='btn btn-secondary btn-sm m-1' type='submit' data-bs-toggle='modal' data-bs-target='#confirm-delete-account-<?=$id?>'><i class="fa fa-minus-square" style="font-size:18px"></i> Eliminar cuenta</button>  
 
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Balance</th>
                        <th scope="col">Intereses</th>
                        <th scope="col">Pago</th>
                        <th scope="col">Nuevo Balance</th>
                        <th scope="col">Accion</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                      $get_history=$con->prepare("SELECT * FROM payments
                                                  WHERE account_id=:cid
                                                  ORDER BY DATE(create_date)");
                      $get_history->execute([':cid'=>$id]);
                      $history=array();
                      while($history_row=$get_history->fetch(PDO::FETCH_ASSOC)){$history[]=$history_row;}
                      if(count($history)>0){
                        $last_amount=$borrow;
                        $last_date=date('Y-m-d',strtotime($create_date));
                        foreach($history as $element){
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
                          // echo "<br>date gap: " . $date_gap . "<br>";

                          $interests=round($last_amount*$interest_percent,2);
                          $previous_balance=$last_amount;
                          $last_amount-=round($payment_amount,2);
                          $new_balance=$last_amount+$interests;
                          $last_amount=$new_balance;
                          ?>
                          <tr>
                            <th scope="row"><?= $payment_id ?></th>
                            <td><?= $payment_date->format('d/m/Y') ?></td>
                            <td>$<?= round($previous_balance,2) ?></td>
                            <td>$<?= $interests ?></td>
                            <td>$<?= round($payment_amount,2) ?></td>
                            <td>$<?= $new_balance ?></td>
                            <td><button class='btn btn-secondary btn-sm' type='submit' data-bs-toggle='modal' data-bs-target='#confirm-delete-payment-<?=$payment_id?>'><i class="fa fa-trash" style="font-size:18px"></i> Eliminar</button>   </td>
                          </tr>
                          <?php
                          $last_date=date_create(date('Y-m-d',strtotime($element['create_date'])));
                        }
                      }
                      ?>
                    </tbody>
                  </table>

                </div>
              </div>
            </div>
          </div>
        </div>
        <!----------------------------------------- Add payment modal ------------------------------------------>
        <div class='modal fade' id='add-payment-<?=$id?>' tabindex='-1' aria-labelledby='payment-modal-label-<?=$id?>' aria-hidden='true'>
          <div class='modal-dialog modal-dialog-centered'>
            <div class='modal-content'>
              <div class='modal-header bg-dark'>
                <h1 class='modal-title fs-5 text-white' id='payment-modal-label-<?=$id?>'>Agregar pago a cuenta: <span class='text-success'><?=$account_name?></span></h1>
              </div>
              <div class='modal-body'>
                <div class='container-fluid justify-content-center form-signin'>
                  <!--------------------------Add Form -------------------------->
                  <form id='payment-add-<?=$id?>' class='row g-3 needs-validation' name='payment-add-<?=$id?>' action='php/actions/add_payment.php?id=<?=$id?>' method='post' novalidate>

                      <div class="my-3">
                        <div class="input-group">
                          <span class="input-group-text">$</span>
                          <input id="payment_amount_<?=$id?>" type="text" class="form-control" aria-label="Amount (to the nearest dollar)" name="payment_amount_<?=$id?>" required>
                        </div>
                        <div class="text-danger" id="payment_amount_error_<?=$id?>"></div>
                      </div>

                      <?php //if($method==2):?>  
                      <div class='form-floating'>
                        <input class='form-control' type='date' name='payment_date_<?=$id?>' id='payment_date_<?=$id?>' required>
                        <label for='payment_date_<?=$id?>'>Fecha del pago</label>
                        <div class="text-danger" id="payment_date_error_<?=$id?>"></div>
                      </div>
                      <?php //endif;?>

                      <input class='form-control visually-hidden' type='text' name='previous_balance_<?=$id?>' id='previous_balance_<?=$id?>' value="<?=$interests?>" readonly>     
                    
                  </form>
                  <!--------------------------Add Form -------------------------->
                </div>
              </div>

              <div class='modal-footer bg-dark'>
                <button type='submit' form='payment-add-<?=$id?>' class='btn btn-success'>Agregar pago</button>
                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar</button>
              </div>
            </div>
          </div>
        </div>
        <!----------------------------------------- Add payment modal ------------------------------------------>   
        <!-------------------------------------- Confirm delete account modal-------------------------------------->
        <div class='modal fade' id='confirm-delete-account-<?=$id?>' tabindex='-1' aria-labelledby='confirm-modal-label-<?=$id?>' aria-hidden='true'>
          <div class='modal-dialog modal-dialog-centered'>
            <div class='modal-content'>
              <div class='modal-header bg-dark my-0'>
                <h1 class='modal-title fs-5 text-white' id='confirm-modal-label-<?=$id?>'>Seguro que quieres borrar la cuenta <span class='text-success'><?=$account_name?></span>?</h1>
              </div>
              <div class='modal-body p-0'>
                <div class='container-fluid my-0 justify-content-center form-signin'>
                  <form id='delete-account-<?=$id?>' class='row g-3' name='delete-account-<?=$id?>' action='php/actions/delete_account.php?id=<?=$id?>' method='post'></form>
                </div>
              </div>

              <div class='modal-footer bg-dark my-0'>
                <button type='submit' form='delete-account-<?=$id?>' class='btn btn-success'>Confirmar</button>
                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
              </div>
            </div>
          </div>
        </div>
        <!-------------------------------------- Confirm delete account modal-------------------------------------->
        <?php
      }
    }   
    ?>
      </div>
      <div>
        <nav>
          <ul class='pagination justify-content-center'>
          <?php
          if ($totalPages > 1) {
          for ($i = 1; $i <= $totalPages; $i++) {
           if ($i == $currentPage) {
             echo "<li class='page-item active'><a class='page-link' href='?page=$i'>$i</a></li>";
           } else {
             echo "<li class='page-item'><a class='page-link' href='?page=$i'>$i</a></li>";
           }
          }
          }
          ?>
          </ul>
        </nav>
      </div>
      
    </div>
  </main>
  <div id="payments-modals"></div>
  <script type="application/javascript"> 
    all_payments.map((payment)=>{
      var payment_id=payment.payment_id;
      var amount=payment.amount;

      var content=`<div class="modal fade" id="confirm-delete-payment-${payment_id}" tabindex="-1" aria-labelledby="modal-label-${payment_id}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header bg-dark my-0">
              <h1 class="modal-title fs-5 text-white" id="modal-label-${payment_id}">Seguro que quieres borrar el pago de <span class="text-success">${amount}</span>? (esta accion no es reversible)</h1>
            </div>
            <div class="modal-body p-0">
              <div class="container-fluid my-0 justify-content-center form-signin">
                <form id="delete-payment-${payment_id}" class="row g-3" name="delete-payment-${payment_id}" action="php/actions/delete_payment.php?id=${payment_id}" method="post"></form>
              </div>
            </div>
      
            <div class="modal-footer bg-dark my-0">
              <button type="submit" form="delete-payment-${payment_id}" class="btn btn-success">Confirmar</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
          </div>
        </div>
      </div>`;
      $('#payments-modals').append(content);
    });
  </script>
  <script 
  src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" 
  integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" 
  crossorigin="anonymous"></script>
  <script 
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
  integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
  crossorigin="anonymous"></script>
  <!-- my resources -->
  <link rel="stylesheet" type="text/css" href="assets/css/stylesheet.css">
  <script type="text/javascript" src="assets/js/script.js"></script>
  <script type="text/javascript" src="assets/js/validation.js"></script>
  <script type="text/javascript" src="assets/js/ajax-unset.js"></script>
  </body>
</html>
