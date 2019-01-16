$(document).ready(function() { 

    $('#add_new_question').on('click', function(e){
        
        if( isThereEmptyFields() ){
            swal({
                title: 'Error , Incomplete form',
                text: '! Please fill the missing fields to add new question',
                type: 'error'
            });

            return false;
        }
        if( !isValidNewQ_correctA($("#newQ_correctA").val()) ) {
            swal({
                title: 'Error',
                text: '!! Invalid correct Answer field , must be from ( 1 - 4 )',
                type: 'error'
            });

            return false;
        }
        if( !isValidQuestionBodyLength($("#newQ_body").val()) ) {
            swal({
                title: 'Error',
                text: '!! Long question body ( must be less than 500 chars )',
                type: 'error'
            });

            return false;
        }
        if( !isValidOptionLength($("#newQ_option1").val()) ) {
            swal({
                title: 'Error',
                text: '!! Long option 1 string ( must be less than 40 chars )',
                type: 'error'
            });

            return false;
        }
        if( !isValidOptionLength($("#newQ_option2").val()) ) {
            swal({
                title: 'Error',
                text: '!! Long option 2 string ( must be less than 40 chars )',
                type: 'error'
            });

            return false;
        }
        if( !isValidOptionLength($("#newQ_option3").val()) ) {
            swal({
                title: 'Error',
                text: '!! Long option 3 string ( must be less than 40 chars )',
                type: 'error'
            });

            return false;
        }
        if( !isValidOptionLength($("#newQ_option4").val()) ) {
            swal({
                title: 'Error',
                text: '!! Long option 4 string ( must be less than 40 chars )',
                type: 'error'
            });

            return false;
        }


        // --------------------------------------------- Do the AJAX request to add the new question ------------------------------------------

        var qBody, op1, op2, op3, op4, correctA; 
        qBody = $("#newQ_body").val();
        op1 = $("#newQ_option1").val();
        op2 = $("#newQ_option2").val();
        op3 = $("#newQ_option3").val();
        op4 = $("#newQ_option4").val();
        correctA = $("#newQ_correctA").val();
        exam_code = $("#exam_code_forTheNewQ").val();
        exam_name = $("#exam_name_forTheNewQ").val();
        

        $.ajax({
        method: 'POST',
        url: 'manageQuestions_ajax.php',
        data : {"exam_code":exam_code, "exam_name":exam_name, "qBody":qBody, "op1":op1, "op2":op2, "op3":op3, "op4":op4, "correctA":correctA},  
        success : function(newQuestionID) {

            // ----------------------------------------------- add the new question to the list 
            
            // get number of all current questions
            var count = $("#questionsList > div").length + 1;

            var target = document.getElementById('questionsList');
            target.insertAdjacentHTML('beforeend','<div id="'+newQuestionID+'"><div id=\'question-'+ newQuestionID +' \' class=\'question\' data-toggle=\'collapse\' data-target=\'#question-'+newQuestionID+'-collapse\'><span class="qNum">Question '+count+'</span></div><div class=\'collapse\' id=\'question-'+newQuestionID+'-collapse\'><div class=\'card card-body question_collapse\'><form><div class=\'input-group my_input_group_collapse\'><div class=\'input-group-prepend\'><span class=\'input-group-text\'>Question : </span></div><textarea id=\'question-'+newQuestionID+'-body\'  class=\'form-control\' aria-label=\'With textarea\'>'+qBody+'</textarea></div><div class=\'input-group my_input_group_collapse\'><div class=\'input-group-prepend\'><span class=\'input-group-text\'>Option 1 : </span></div><input id=\'question-'+newQuestionID+'-option-1\' value=\''+op1+'\' type=\'text\' class=\'form-control\' /></div><div class=\'input-group my_input_group_collapse\'><div class=\'input-group-prepend\'><span class=\'input-group-text\'>Option 2 : </span></div><input id=\'question-'+newQuestionID+'-option-2\' value=\''+op2+'\' type=\'text\' class=\'form-control\' /></div><div class=\'input-group my_input_group_collapse\'><div class=\'input-group-prepend\'><span class=\'input-group-text\'>Option 3 : </span></div><input id=\'question-'+newQuestionID+'-option-3\' value=\''+op3+'\' type=\'text\' class=\'form-control\' /></div><div class=\'input-group my_input_group_collapse\'><div class=\'input-group-prepend\'> <span class=\'input-group-text\'>Option 4 : </span></div><input id=\'question-'+newQuestionID+'-option-4\' value=\''+op4+'\' type=\'text\' class=\'form-control\' /></div><div class=\'input-group my_input_group_collapse\'><div class=\'input-group-prepend\'><span class=\'input-group-text\'>Correct Answer : </span></div><input id=\'question-'+newQuestionID+'-correctA\' value=\''+correctA+'\' type=\'number\' class=\'form-control\' /></div><hr><button id=\'updateQuestion-'+newQuestionID+'-Btn\' type=\'submit\' style=\'background-color: #05668D;\' class=\'btn btn-primary updateQ_btn\' disabled>Update</button><button type=\'button\' style=\'margin-left:5px; background-color: #F26868;\' class=\'btn btn-danger deleteQ_btn\'>Delete</button></form> </div></div></div>');

            swal({
                title: 'Correct', 
                text: 'Question Added Successfully', 
                type: 'success', 
                showConfirmButton: false, 
                timer: 2000
            }); 

            // -------------------------------------------------- clear the carrosal input fields
            $("#newQ_body").val("");
            $("#newQ_option1").val("");
            $("#newQ_option2").val("");
            $("#newQ_option3").val("");
            $("#newQ_option4").val("");
            $("#newQ_correctA").val("");

            // --------------------------------------------------- hide the modal
            document.getElementById("addQuestion").click();
        }

        });


    });

    
    
});

function isThereEmptyFields(){
    if( /^\s*$/.test($("#newQ_body").val()) || /^\s*$/.test($("#newQ_option1").val()) ||  /^\s*$/.test($("#newQ_option2").val()) ||  /^\s*$/.test($("#newQ_option3").val()) ||  /^\s*$/.test($("#newQ_option4").val()) ||  /^\s*$/.test($("#newQ_correctA").val()) )
    return true;
    else
    return false;
}

function isValidNewQ_correctA($correct_A){
    $pattern = /^[1-4]$/;
    if($pattern.test($correct_A)){
        return true;
    }else {
        return false;
    }
}

function isValidQuestionBodyLength($qBody) {
    if($qBody.length <= 500)
        return true;
    else
        return false;
}

function isValidOptionLength($op) {
    if($op.length <= 40)
        return true;
    else
        return false;
}

function isEmptyFeild(input){
    if( /^\s*$/.test(input) )
      return true;
    else
      return false    
}

var questionsList = document.getElementById("questionsList");

// add 'change' event on the current question collapse. if there is a change ,, make the 'update btn' enabled
questionsList.addEventListener('change', function(e){

    // access the question container (in my implementation is the 'form')
    var questionContainer = e.target.parentNode.parentNode;
    var updateBtnId = questionContainer.getElementsByClassName("updateQ_btn")[0].id;
    $("#"+updateBtnId+"").removeAttr('disabled');
});


questionsList.addEventListener('click', function(e) {
    e.preventDefault();
    
    if(e.target.className.includes("deleteQ_btn")) {

        Swal({
            title: 'Are you sure ?',
            text: "!! You won't be able to revert this question",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#05668D',
            cancelButtonColor: '#F26868',
            confirmButtonText: 'Yes, delete it !'
          }).then((result) => {
            if (result.value) {
                
                // ------------------------------------------ delete the question from the database
                
                // --> get the exam code and question id to delete the exam
                var exam_code = $("#examCode").val();
                var question_id = e.target.parentNode.parentNode.parentNode.parentNode.id;
                //console.log("delete from eCode = " + exam_code + ", question id = " + question_id);

                // ----------------------------------------- delete the question from the database
                $.ajax({
                    method: 'GET',
                    url: 'deleteQuestion_ajax.php',
                    data : {"exam_code":exam_code, "question_id":question_id},
                    
                    success: function(data){
                        if(data==true){
                             
                            // ------------------------------------------ delete the question from the table
                
                            // console.log("delete question with id = " + e.target.parentNode.parentNode.parentNode.parentNode.id);
                            var question = e.target.parentNode.parentNode.parentNode.parentNode;
                            questionsList.removeChild(question);

                            // ------------------------------------------ re-number the questions in the question list
                            var numberOfQuestions = $("#questionsList > div").length;
                            for(var i=1; i<=numberOfQuestions; i++){
                                
                                $("#questionsList div:nth-child("+i+") div:nth-child(1) span.qNum ").text("Question " + i);
                            }
                            
                            swal({
                                title: 'Correct', 
                                text: 'Question deleted successfully', 
                                type: 'success', 
                                showConfirmButton: false, 
                                timer: 1500
                            });
    
                        } 
                    }

                });

                
            }
            
          });

        
    } else if(e.target.className.includes("updateQ_btn")) {
    
                // ------------------------------------------ delete the question from the database
                
                // get the exam code and question id AND get all the input feilds to update the exam
                var exam_code = $("#examCode").val();
                var question_id = e.target.parentNode.parentNode.parentNode.parentNode.id;


                var qBody = document.getElementById("question-"+question_id+"-body").value;
                //console.log("question body : "+qBody);
                var op1 = document.getElementById("question-"+question_id+"-option-1").value;
                //console.log("op1 : " + op1);
                var op2 = document.getElementById("question-"+question_id+"-option-2").value;
                //console.log("op2 : " + op2);
                var op3 = document.getElementById("question-"+question_id+"-option-3").value;
                //console.log("op3 : " + op3);
                var op4 = document.getElementById("question-"+question_id+"-option-4").value;
                //console.log("op4 : " + op4);
                var correctA = document.getElementById("question-"+question_id+"-correctA").value;
                //console.log("correctA : " + correctA);
                

                // check if the input fiels after editing is valid or not
                if( isEmptyFeild(qBody) || isEmptyFeild(op1) || isEmptyFeild(op2) || isEmptyFeild(op3) || isEmptyFeild(op4) || isEmptyFeild(correctA) )
                {
                    swal({
                        title: 'Error , Incomplete form',
                        text: '! Please fill the missing fields to add new question',
                        type: 'error'
                    });

                }else if( !isValidNewQ_correctA(correctA) ){
                    swal({
                        title: 'Error',
                        text: '!! Invalid correct Answer field , must be from ( 1 - 4 )',
                        type: 'error'
                    });
                    
                }
                else if( !isValidQuestionBodyLength(qBody) ) {
                    swal({
                        title: 'Error',
                        text: '!! Long question body ( must be less than 500 chars )',
                        type: 'error'
                    });
        
                }
                else if( !isValidOptionLength(op1) ) {
                    swal({
                        title: 'Error',
                        text: '!! Long option 1 string ( must be less than 40 chars )',
                        type: 'error'
                    });

                }
                else if( !isValidOptionLength(op2) ) {
                    swal({
                        title: 'Error',
                        text: '!! Long option 2 string ( must be less than 40 chars )',
                        type: 'error'
                    });

                }
                else if( !isValidOptionLength(op3) ) {
                    swal({
                        title: 'Error',
                        text: '!! Long option 3 string ( must be less than 40 chars )',
                        type: 'error'
                    });

                }
                else if( !isValidOptionLength(op4) ) {
                    swal({
                        title: 'Error',
                        text: '!! Long option 4 string ( must be less than 40 chars ) ',
                        type: 'error'
                    });
    
                }
                else {
                    // --> OK, all input is valild, now start updating <--
                    
                    // -------------------------------- update the question in the database
                    $.ajax({
                        method: 'GET',
                        url: 'updateQuestion_ajax.php',
                        data : {"exam_code":exam_code, "question_id":question_id, "qBody":qBody, "op1":op1,"op2":op2,"op3":op3,"op4":op4, "correctA":correctA},
                        
                        success: function(data){
                            if(data==true){
                                
                                // ------------------------------------------ update the question in the table GUI
                                
                                swal({
                                    title: 'Correct', 
                                    text: 'Question updated successfully', 
                                    type: 'success', 
                                    showConfirmButton: false, 
                                    timer: 1500
                                });

                                // make the update btn disabled again
                                document.getElementById("updateQuestion-"+question_id+"-Btn").disabled = true;

                            } 
                        }

                    });

                }  
    } 
            
    
});