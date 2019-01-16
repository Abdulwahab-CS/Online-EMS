function startExam() {

    var chosen = document.getElementById("exams_select_input").value;
    

    if(chosen != "") {

        // check if the student has taken this exam before or not
        
        $.ajax({
            method: 'POST',
            url: 'isExamTakenBefore.php',
            data: {'exam_code':chosen},
            
            success: function(isExamTakenBefore){
                
                if(isExamTakenBefore){
                    swal({
                        title: 'Oops',
                        text: 'You have done this exam before',
                        type: 'error'
                    });
                
                }else {

                    // if the student is not take the exam before
                    window.location = "studentExamPage.php?exam_code=" + chosen;
                }
            }
        });
        
        

    } else {
        swal({
            title: 'Empty Selectoin',
            text: 'Please choose an exam !!',
            type: 'error'
        });

    }

  }