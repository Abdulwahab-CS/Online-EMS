$(document).ready(function() { 
    
    $('#updateExam_form').on('submit', function(e){
        
        if( isThereEmptyFields() ){
            swal({
                title: 'Error , Incomplete form',
                text: '! Please fill the missing fields',
                type: 'error'
            });

            return false;
        }
        if( !isValidExamCode($("#examCode").val()) ) {
            swal({
                title: 'Error',
                text: '!! Invalid Exam Code Format',
                type: 'error'
            });

            return false;
        }
        if( !isValidExamCodeLength($("#examCode").val()) ) {
            swal({
                title: 'Error',
                text: '!! Long Exam Code ( must be less than 11 chars )',
                type: 'error'
            });

            return false;
        }
    });

});

function isThereEmptyFields(){
    if( /^\s*$/.test($("#examCode").val()) )
      return true;
    else
      return false;
}

function isValidExamCode($eCode){
    $pattern = /^[a-zA-Z_0-9|-]+$/;
    if($pattern.test($eCode)){
        return true;
    }else {
        return false;
    }
}


function isValidExamCodeLength($eCode) {
    if($eCode.length <= 10)
        return true;
    else
        return false;
}