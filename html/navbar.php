<nav class="navbar navbar-expand-lg bg-dark shadow-lg" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Calculadora</a>
    <button class='btn btn-secondary my-3 float-end' type='submit' data-bs-toggle='modal' data-bs-target='#add-modal'>+ Agregar cuenta</button>
  </div>
</nav>
<!---------------------------------------------- Add modal ---------------------------------------------->
<div class='modal fade' id='add-modal' tabindex='-1' aria-labelledby='modal-label' aria-hidden='true'>
  <div class='modal-dialog modal-dialog-centered'>
    <div class='modal-content'>
      <div class='modal-header bg-dark'>
        <h1 class='modal-title fs-5 text-white' id='modal-label'>Agregar cuenta por cobrar</h1>
      </div>
      <div class='modal-body'>
        <div class='container-fluid justify-content-center form-signin'>
    <!--------------------------Add Form -------------------------->
          <form id='account-add' class='row g-3' role='form' name='account-add' action='' method='post'>


              <div class='form-floating my-3'>
                <input type='text' name='accout_name' id='accout_name' class='form-control' placeholder='Nombre'>
                <label for='accout_name'>Nombre de la cuenta</label>
              </div>
              <div class='form-floating my-0 mb-3'>
                <input type='text' name='lastname' id='lastname' class='form-control' placeholder='Apellido'>
                <label for='lastname'>Deudor</label>
              </div>

            <div class="my-0 mb-3">  
              <label for="amount_borrowed" class="form-label">Cantidad solicitada</label>
              <div class="input-group">
                <span class="input-group-text">$</span>
                <input id="amount_borrowed" name="amount_borrowed" type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
              </div>
            </div>

            <div class="my-0 mb-3">  
              <label for="interest_rate" class="form-label">Tasa de interes</label>
              <div class="input-group">
                <input id="interest_rate" name="interest_rate" type="text" class="form-control" aria-label="Interest Rate">
                <span class="input-group-text">%</span>
              </div>
            </div>

            <div class="input-group mb-3">
              <label class="input-group-text" for="cycle">Ciclo</label>
              <select class="form-select" id="cycle" name="cycle">
                <option selected>Seleccione...</option>
                <option value="15">Quincenal</option>
                <option value="30">Mensual</option>
              </select>
            </div>

            <div class='form-floating my-0 mb-3'>
              <input class='form-control' type='date' name='start_date' id='start_date' placeholder='Fecha de inicio'>
              <label for='start_date'>Fecha de inicio</label>
            </div>
            
          </form>
<!--------------------------Add Form -------------------------->
        </div>
      </div>

      <div class='modal-footer bg-dark'>
        <button type='submit' form='account-add' name='form-add-submit' class='btn btn-info'>Agregar cuenta</button>
        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!--------------------------Add modal -------------------------->