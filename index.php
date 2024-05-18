<?php
require_once 'php/connection.php';

$data=$con->prepare("SELECT * FROM accounts");
$data->execute();
while($get_data=$data->fetch(PDO::FETCH_ASSOC)){$all_data[]=$get_data;}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
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
  </head>
  <body>
    <div class="container">
      <button class='btn btn-dark my-3 float-end' type='submit' data-bs-toggle='modal' data-bs-target='#add-modal'>+ Agregar</button>
      <div class="row w-100">
    <?php
    if(count($all_data)>0){
      foreach($all_data as $account){
        ?>
        <div class="my-2">
          <div class="accordion" id="accordionExample">
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                  Accordion Item #1
                </button>
              </h2>
              <div id="collapseTwo" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                  <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php
      }
    }   
    ?>
      </div>
    </div>
  <script 
  src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" 
  integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" 
  crossorigin="anonymous"></script>
  <script 
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
  integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
  crossorigin="anonymous"></script>
  <!-- my resources -->
  <link rel="stylesheet" type="text/css" href="css/stylesheet.css">
  <script type="text/javascript" src="js/script.js"></script>

  <!---------------------------------------------- Add modal ---------------------------------------------->
  <div class='modal fade' id='add-modal' tabindex='-1' aria-labelledby='modal-label' aria-hidden='true'>
    <div class='modal-dialog modal-dialog-centered'>
      <div class='modal-content'>
        <div class='modal-header bg-dark'>
          <h1 class='modal-title fs-5 text-white' id='modal-label'>Agregar usuario</h1>
        </div>
        <div class='modal-body'>
          <div class='container-fluid justify-content-center form-signin'>
      <!--------------------------Add Form -------------------------->
            <form id='user-add' class='row g-3' role='form' name='user-add' action='actions/create/crear_usuario.php' method='post'>

              <div class='row g-2'>
                <div class='form-floating'>
                  <input type='text' name='name' id='name' class='form-control' placeholder='Nombre'>
                  <label for='name'>Nombre</label>
                </div>
                <div class='form-floating'>
                  <input type='text' name='lastname' id='lastname' class='form-control' placeholder='Apellido'>
                  <label for='lastname'>Apellido</label>
                </div>
              </div>
              <div class='form-floating'>
                <input class='form-control' type='date' name='dob' id='dob' placeholder='Fecha de nacimiento'>
                <label for='dob'>Fecha de nacimiento</label>
              </div>

              <div class='form-floating'>
                <input type='password' name='password' id='password' class='form-control' placeholder='Contrase&ntilde;a'>
                <label for='password'>Contrase&ntilde;a</label>
              </div>
              <div class='input-group'>
                <span id='phone-label' class='input-group-text'>+507</span>
                <input type='number' name='phone' id='phone' class='form-control' placeholder='Numero de telefono' aria-describedby='phone-label'>
              </div>
              <div class='form-floating'>
                <input type='email' name='email' id='email' class='form-control' placeholder='Correo Electronico'>
                <label for='email'>Correo Electronico</label>
              </div>

              <div class='checkbox-inline'>
                <label>
                  <input type='checkbox' name='active' value='1' checked> Active
                </label>
              </div>
              
            </form>
  <!--------------------------Add Form -------------------------->
          </div>
        </div>

        <div class='modal-footer bg-dark'>
          <button type='submit' form='user-add' name='form-add-submit' class='btn btn-info'>Agregar</button>
          <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar</button>
        </div>
      </div>
    </div>
  </div>
  <!--------------------------Add modal -------------------------->
  </body>
</html>
