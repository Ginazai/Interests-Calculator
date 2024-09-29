$(document).ready(function(){

  const isValidDate = (stringDate) => {
    const regex = /^\d{4}-\d{2}-\d{2}$/; 
    return regex.test(stringDate);
  }

  const setInvalid = (invalidClass) => {
    invalidClass.removeClass("is-valid");
    invalidClass.addClass("is-invalid");
  }

  const setValid = (validClass) => {
    validClass.removeClass("is-invalid");
    validClass.addClass("is-valid");
  }

  var error=true;
  var account_name=$("#accout_name");
  var borrower=$("#borrower");
  var amount=$("#amount_borrowed");
  var rate=$("#interest_rate");
  var cycle=$("#cycle");
  var date=$("#start_date");

  account_name.on('click input',()=>{
    if(account_name.val().length<1){
      error=true;
      setInvalid(account_name);
      $("#name-error").html("El nombre de la cuenta es requerido");
    } else {
      error=false;
      setValid(account_name);
      $("#name-error").html("");
    }
  });

  borrower.on('click input',()=>{
    if(borrower.val().length<1){
      error=true;
      setInvalid(borrower);
      $("#owner-error").html("El nombre del deudor es requerido");
    } else {
      error=false;
      setValid(borrower);
      $("#owner-error").html("");
    }
  });

  amount.on('click input',()=>{
    if(amount.val().length<1){
      error=true;
      setInvalid(amount);
      $("#amount-error").html("Ingrese la cantidad solicitada");
    }
    if(isNaN(amount.val())){
      error=true;
      setInvalid(amount);
      $("#amount-error").html("La cantidad solicitada debe ser numerica");
    } else {
      error=false;
      setValid(amount);
      $("#amount-error").html("");
    }
  });

  rate.on('click input',()=>{
    if(rate.val().length<1){
      error=true;
      setInvalid(rate);
      $("#rate-error").html("Ingrese la tasa de intereses");
    }
    if(isNaN(rate.val())){
      error=true;
      setInvalid(rate);
      $("#rate-error").html("La tasa de intereses debe ser numerica");
    } else {
      error=false;
      setValid(rate);
      $("#rate-error").html("");
    }
  });

  cycle.on('click input',()=>{
    if(cycle.val()==null){
      error=true;
      setInvalid(cycle);
      $("#cycle-error").html("Seleccione un tipo de cyclo");
    } else {
      error=false;
      setValid(cycle);
      $("#cycle-error").html("");
    }
  });

  date.on('click input',()=>{
    if(!isValidDate(date.val())){
      error=true;
      setInvalid(date);
      $("#date-error").html("La fecha es requerida");
    } else {
      error=false;
      setValid(date);
      $("#date-error").html("");
    }
  });

  (()=>{
    'use strict';
    $("#account-add").on('submit',(e)=>{  
      if(!$("form#account-add")[0].checkValidity()||error){
        e.preventDefault();
        e.stopPropagation();
      }
    });
  })()

});