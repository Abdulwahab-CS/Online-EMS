$(document).ready(function() { 
    
    $('#examiner_login_form').on('submit', function(e){
        
        if( isThereEmptyFields() ){
            swal({
                title: 'Error , Incomplete form',
                text: '! Please fill the missing fields',
                type: 'error'
            });

            return false;
        }
        if( !isValidUsername($("#examiner_username").val()) ) {
            swal({
                title: 'Error',
                text: '!! Invalid Username',
                type: 'error'
            });

            return false;
        }
        if( !isValidID($("#examiner_password").val()) ) {
            swal({
                title: 'Error',
                text: '!! Invalid ID',
                type: 'error'
            });

            return false;
        }
    });

});

function isThereEmptyFields(){
    if( $("#examiner_username").val() == '' ||  $("#examiner_password").val() == '' )
      return true;
    else
      return false;
}

function isValidUsername($username){
    if($username !== ''){
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
    if( $("#examiner_username").val() == '' ||  $("#examiner_password").val() == '')
      return true;
    else
      return false;
}
