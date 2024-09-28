$(document).ready(function(){

  const isValidDate = (stringDate) => {
    const regex = /^\d{4}-\d{2}-\d{2}$/; 
    return regex.test(stringDate);
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
      account_name.removeClass("is-valid");
      account_name.addClass("is-invalid");
      $("#name-error").html("El nombre de la cuenta es requerido");
    } else {
      error=false;
      account_name.removeClass("is-invalid");
      account_name.addClass("is-valid");
      $("#name-error").html("");
    }
  });

  borrower.on('click input',()=>{
    if(borrower.val().length<1){
      error=true;
      borrower.removeClass("is-valid");
      borrower.addClass("is-invalid");
      $("#owner-error").html("El nombre del deudor es requerido");
    } else {
      error=false;
      borrower.removeClass("is-invalid");
      borrower.addClass("is-valid");
      $("#owner-error").html("");
    }
  });

  amount.on('input click',()=>{
    if(amount.val().length<1){
      error=true;
      amount.removeClass("is-valid");
      amount.addClass("is-invalid");
      $("#amount-error").html("Ingrese la cantidad solicitada");
    }
    else if(isNaN(amount.val())){
      error=true;
      amount.removeClass("is-valid");
      amount.addClass("is-invalid");
      $("#amount-error").html("La cantidad solicitada debe ser numerica");
    } else {
      error=false;
      amount.removeClass("is-invalid");
      amount.addClass("is-valid");
      $("#amount-error").html("");
    }
  });

  rate.on('input click',()=>{
    if(rate.val().length<1){
      error=true;
      rate.removeClass("is-valid");
      rate.addClass("is-invalid");
      $("#rate-error").html("Ingrese la tasa de intereses");
    }
    else if(isNaN(rate.val())){
      error=true;
      rate.removeClass("is-valid");
      rate.addClass("is-invalid");
      $("#rate-error").html("La tasa de intereses debe ser numerica");
    } else {
      error=false;
      rate.removeClass("is-invalid");
      rate.addClass("is-valid");
      $("#rate-error").html("");
    }
  });

  cycle.on('click input',()=>{
    if(cycle.val()==null||cycle.val().length<1){
      error=true;
      cycle.removeClass("is-valid");
      cycle.addClass("is-invalid");
      $("#cycle-error").html("Seleccione un tipo de cyclo");
    } else {
      error=false;
      cycle.removeClass("is-invalid");
      cycle.addClass("is-valid");
      $("#cycle-error").html("");
    }
  });

  date.on('click input focus',()=>{
    if(!isValidDate(date.val())){
      error=true;
      date.removeClass("is-valid");
      date.addClass("is-invalid");
      $("#date-error").html("La fecha es requerida");
    } else {
      error=false;
      date.removeClass("is-invalid");
      date.addClass("is-valid");
      $("#date-error").html("");
    }
  });

  (()=>{
    'use strict';
    $("#account-add").on('submit',(e)=>{  
      if(!$("form#account-add")[0].checkValidity()||error){
        console.log("error is true");
        e.preventDefault();
        e.stopPropagation();
      }
    });
  })()

});

