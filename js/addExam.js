
// ------------------------------- handle create exam form
$(document).ready(function() { 
    
    $('#createExamBtn').on('click', function(e){
        
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
        if( !isValidExamName($("#examName").val()) ) {
            swal({
                title: 'Error',
                text: '!! Invalid Exam Name Format',
                type: 'error'
            });

            return false;
        }
        if( !isValidExamNameLength($("#examName").val()) ) {
            swal({
                title: 'Error',
                text: '!! Long Exam Name ( must be less than 21 chars )',
                type: 'error'
            });

            return false;
        }
        if( !isValidExamCodeLength($("#examCode").val()) ) {
            swal({
                title: 'Error',
                text: '!! Long Exam Code ( must be less than 21 chars )',
                type: 'error'
            });

            return false;
        }

    });

});

function isThereEmptyFields(){
    if( /^\s*$/.test($("#examName").val()) || /^\s*$/.test($("#examCode").val()) )
      return true;
    else
      return false;
}

function isValidExamCode($eCode){
    $pattern = /^[a-zA-Z_0-9|-|.]+$/;
    if($pattern.test($eCode)){
        return true;
    }else {
        return false;
    }
}

function isValidExamName($eName){
    $pattern = /^[a-zA-Z_0-9| |-|.]+$/;
    if($pattern.test($eName)){
        return true;
    }else {
        return false;
    }
}

function isValidExamNameLength($eName) {
    if($eName.length <= 20)
        return true;
    else
        return false;
}

function isValidExamCodeLength($eCode) {
    if($eCode.length <= 20)
        return true;
    else
        return false;
}