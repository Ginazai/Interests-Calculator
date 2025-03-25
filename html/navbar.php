<!-- Interests Calculator - A simple software to facilitate the interests registry for borrowers. Copyright (C) 2025 Rafael Caballero

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, see https://www.gnu.org/licenses/gpl-3.0.en.html. -->
<nav class="navbar navbar-expand-lg bg-dark shadow-lg px-5 py-1" data-bs-theme="dark">
  <div class="container-fluid">
      <a class="navbar-brand" href="index.php"><i class="fa fa-bar-chart" style="font-size:18px"></i> Calculadora de intereses</a>
      <div class="btn-group float-end my-3 m-1" role="group">
        <a class='btn btn-sm btn-secondary' href='php/actions/download_all_csv.php'><i class="fa fa-download" style="font-size:18px"></i> Descargar todo como archivo CSV</a>
        <button class='btn btn-sm btn-success' type='button' data-bs-toggle='modal' data-bs-target='#add-modal' aria-controls="add-modal"><i class="fa fa-plus-square" style="font-size:18px"></i> Agregar cuenta</button>
        <button class='btn btn-sm btn-secondary' type='button' data-bs-toggle='offcanvas' data-bs-target='#menu' aria-controls="menu"><i class="fa fa-navicon" style="font-size:18px"></i></button>
      </div> 
  </div>
</nav>
<!---------------------------------------------- Offacanvas ---------------------------------------------->
<div id="menu" class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1"  aria-labelledby="menu_label">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title mx-auto" id="menu_label"><i class="fa fa-navicon" style="font-size:1em"></i> Menu</h5>
  </div>
  <div class="offcanvas-body">
    <ul class="list-group list-group-flush">
      <li class="list-group-item"><a href="index.php"><i class="fa fa-home" style="font-size:1em"></i> Inicio</li></a>
      <li class="list-group-item"><a href="history.php"><i class="fa fa-history" style="font-size:1em"></i> Historial</li></a>
      <li class="list-group-item"><a href="trash_bin.php"><i class="  fa fa-trash-o" style="font-size:1em"></i> Papelera</li></a>
    </ul>
  </div>
</div>
<!---------------------------------------------- Offacanvas ---------------------------------------------->
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
          <form id='account-add' class='row g-3 needs-validation' name='account-add' action='php/actions/add_account.php' method='post' novalidate>


              <div class='form-floating my-3'>
                <input type='text' name='accout_name' id='accout_name' class='form-control form-validate' placeholder='Nombre' required>
                <label for='accout_name'>Nombre de la cuenta</label>
                <div id="name-error" class="text-danger errors"></div>
              </div>
              <div class='form-floating my-0 mb-3'>
                <input type='text' name='borrower' id='borrower' class='form-control form-validate' placeholder='Deudor' required>
                <label for='borrower'>Deudor</label>
                <div id="owner-error" class="text-danger errors"></div>
              </div>

            <div class="my-0 mb-3">
              <div class="input-group">
                <span class="input-group-text">Cantidad solicitada</span>
                <span class="input-group-text">$</span>
                <input id="amount_borrowed" name="amount_borrowed" type="text" class="form-control" aria-label="Amount (to the nearest dollar)" required>
              </div>
              <div id="amount-error" class="text-danger errors"></div>
            </div>

            <div class="my-0 mb-3">
              <div class="input-group">
                <label class="input-group-text" for="interest_rate">Tasa de interes</label>
                <input id="interest_rate" class="form-control" name="interest_rate" type="text" aria-label="Interest Rate" required>
                <span class="input-group-text">%</span>
              </div>
              <div id="rate-error" class="text-danger errors"></div>
            </div>

            <div class="my-0 mb-3"> 
              <div class="input-group">
                <label class="input-group-text" for="cycle">Ciclo</label>
                <select class="form-select" id="cycle" name="cycle" required>
                  <option selected disabled value="">Seleccione...</option>
                  <option value="15">Quincenal</option>
                  <option value="30">Mensual</option>
                </select>
              </div>
              <div id="cycle-error" class="text-danger errors"></div>
            </div>

            <div class="my-0 mb-3">
              <div class="input-group">
                <label class="input-group-text" for="method">Metodo de calculo</label>
                <select name="method" class="form-select" id="method">
                  <option  value="1"selected>Automatico</option>
                  <option value="2">Manual</option>
                </select>
                <div id="method-error" class="text-danger errors"></div>
              </div>
            </div>

            <div class="my-0 mb-3">
              <div class='form-floating'>
                <input class='form-control' type='date' name='start_date' id='start_date' required>
                <label for='start_date'>Fecha de inicio</label>
              </div>
              <div id="date-error" class="text-danger errors"></div>
            </div>
            
          </form>
<!--------------------------Add Form -------------------------->
        </div>
      </div>

      <div class='modal-footer bg-dark'>
        <button type='submit' form='account-add' class='btn btn-success'>Agregar cuenta</button>
        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!--------------------------Add modal -------------------------->