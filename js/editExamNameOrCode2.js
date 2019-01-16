// ------------------------------- handle create exam form
$(document).ready(function() { 
    
    $('#submitBtn').on('click', function(e){
        e.preventDefault();

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
                text: '!! Long Exam Name ( must be less than 11 chars )',
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



        Swal({
            title: 'Are you sure ?',
            text: "Do you want to update the exam ?",
            type: 'info',
            showCancelButton: true,
            confirmButtonColor: '#05668D',
            cancelButtonColor: '#F26868',
            confirmButtonText: 'Yes'
          }).then((result) => {
            if (result.value) {
                
                // get the new exam name and exam code
                var exam_name = document.getElementById('examName').value;
                var exam_code = document.getElementById('examCode').value;
                
                $.ajax({
                    method: 'post',
                    url: 'editExamNameOrCode2.php',
                    data: {"new_exam_code":exam_code, "new_exam_name":exam_name},
                    
                    success: function(data){
                        swal({title: 'Correct', text: 'Exam updated successfully', type: 'success', showConfirmButton: false, timer: 1500}); 
                
                        // redirect to examiner main page
                        setTimeout(function(){
                            window.location = 'examinerMainPage.php';
                        }, 1500)
                    }
                });



                // window.location = "editExamNameOrCode2.php?updateExamBtn=1";

                // swal({
                //     title: 'OK',
                //     text: 'Exam updated successfully',
                //     type: 'success', 
                //     showConfirmButton: false, 
                //     timer: 500
                // });
        
                // setTimeout(() => {
                //      window.location = "examinerMainPage.php";
                // }, 500);

            }
          })
       


    });

});

function isThereEmptyFields(){
    if( /^\s*$/.test($("#examName").val()) || /^\s*$/.test($("#examCode").val()) )
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

function isValidExamName($eName){
    $pattern = /^[a-zA-Z_0-9| |-]+$/;
    if($pattern.test($eName)){
        return true;
    }else {
        return false;
    }
}

function isValidExamNameLength($eName) {
    if($eName.length <= 10)
        return true;
    else
        return false;
}

function isValidExamCodeLength($eCode) {
    if($eCode.length <= 10)
        return true;
    else
        return false;
}