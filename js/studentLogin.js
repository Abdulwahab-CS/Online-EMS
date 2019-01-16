$(document).ready(function() { 
    
    $('#loginBtn').on('click', function(e){
        
        if( isThereEmptyFields() ){
            swal({
                title: 'Error , Incomplete form',
                text: '! Please fill the missing fields',
                type: 'error'
            });

            return false;
        }
        if( !isValidEamil($("#email").val()) ) {
            swal({
                title: 'Error',
                text: '!! Invalid Email Format (xxx@xxx.xxx) ',
                type: 'error'
            });

            return false;
        }
        if( !isValidID($("#id").val()) ) {
            swal({
                title: 'Error',
                text: '!! Invalid ID format , must be ONLY NUMBERS',
                type: 'error'
            });

            return false;
        }
        
    });

});


function isThereEmptyFields(){
    if( $("#email").val() == '' ||  $("#id").val() == '' )
      return true;
    else
      return false;
}

function isValidEamil($email){
    // my regex was : /^[a-zA-Z_0-9|.|-]+[@][a-zA-Z]+[.][a-zA-Z]+$/;
    $pattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if($pattern.test($email)){
        return true;
    }else {
        return false;
    }
}

function isValidID($id){
    $pattern = /^[0-9]+$/;
    if($pattern.test($id)){
        return true;
    }else {
        return false;
    }
}


function isThereEmptyFields(){
    if( $("#f_name").val() == '' ||  $("#s_name").val() == '' || $("#l_name").val() == '' || $("#email").val() == '' ||  $("#id").val() == '')
      return true;
    else
      return false;
}
