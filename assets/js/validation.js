$(document).ready(function(){
  (() => {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    const formsQuery = document.querySelectorAll('.needs-validation')
    const forms = Array.from(formsQuery)

    // Loop over them and prevent submission
    forms.map((form) => {
      $(form).on('click submit',function(event){
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }
        form.classList.add('was-validated')
      });
    },false)

  })()
});

