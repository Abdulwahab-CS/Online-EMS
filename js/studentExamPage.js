$(document).ready(function() { 
    
  $('#submitExamBtn').on('click', function(e){
        
      if( isThereEmptyQuestions() ){
          swal({
              title: 'Error , Empty Question',
              text: '! Please answer all questions',
              type: 'error'
          });
          
      
      }else {
          swal({
              title: 'OK',
              text: 'Exam Completed successfully',
              showConfirmButton: false,
              timer: 1500,
              type: 'success'

          }); 
          
          // ---------------------------------------- get all answers, and send to calaExamScore.php page to clac the score 

          var questionsNumber = $('#questionsNum').text();
          var answers = [];
          for(var i=1; i<=questionsNumber; i++){
              var item = $('input[name=question-'+i+'-opts]:checked').val(); // the item can be either (1, 2, 3, or 4) indicates to the selected option
              answers.push(item);
          }    

          var examCode = $("#eCode").text();


          $.ajax({
            method: 'POST',
            url: 'calcExamScore.php',
            data: {"examCode":examCode, "allAnswers":answers},
            success: function(){

                setTimeout(function(){
                    window.location = "studentMainPage.php";
                }, 1500);
                
            }
          });

          
      }

  });


  $(".exitExamBtn").click(function(e){

        Swal({
            title: 'Are you sure ?',
            text: "!! Your data of this exam will removed completely",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#05668D',
            cancelButtonColor: '#F26868',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.value) {
                
                swal({
                    title: 'OK',
                    text: 'Exam will be terminated completely',
                    showConfirmButton: false,
                    timer: 1500,
                    type: 'success'
                });
                
                setTimeout(function(){
                    window.location = "studentMainPage.php";
                }, 1500);
            }
        })

    });






});

function isThereEmptyQuestions(){
  // first you have to know number of questions & check if there is a questions with no answer
  var questionsNumber = $('#questionsNum').text();
  var emptyFound = false;

  for(var i=1; i<=questionsNumber; i++){
      var item = $('input[name=question-'+i+'-opts]:checked').val();

      if ( typeof item == "undefined" ){
         
          emptyFound = true;
      }
  }    
  
  return emptyFound;
}


