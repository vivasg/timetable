document.addEventListener('DOMContentLoaded', function () {
/*
    $('[name="btn_main"]').on('click', function() {
        $('#myModal').modal('show');
    });
*/
   //$('[name="form_Main"]').validator();

    $('[name="form_Main"]').on("submit",submitForm);

    function submitForm(event){
        event.preventDefault();
        var form = $(this);
        var inputs = form.find("input");
        //alert(1);
        $.each( inputs, function( index, val ){
             var input = $(val),
             val = input.val(),
             formGroup = input.parents(".form-group"),
             label = formGroup.find("label").text().toLowerCase();
             console.log(label);
        })

    }

});