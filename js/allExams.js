$('table').on('click', 'input.showExam[type="button"]', function(e){
    
    var $row = $(this).closest("tr");       
        $tds = $row.find("td");             

    var i=0;
    var examCode;
    $.each($tds, function() {                    
       $(this).text();
       if(i==2)
         examCode = $(this).text();
        i++;
    });
    
    window.location = "showExam.php?exam_code=" + examCode;

});


$('table').on('click', 'input.deleteBtn[type="button"]', function(e){
    e.preventDefault();       

    Swal({
        title: 'Are you sure ?',
        text: "!! You won't be able to revert this exam",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#05668D',
        cancelButtonColor: '#F26868',
        confirmButtonText: 'Yes, delete it !'
      }).then((result) => {
        if (result.value) {
          
            // -------------------------------------- delete the exam from the database (do AJAX request)

            // --------- get the selected exam code 
            var $row = $(this).closest("tr");       
            $tds = $row.find("td");             

            var i=0;
            var examCode;
            $.each($tds, function() { 
                $(this).text();                   
                if(i==2){
                   examCode = $(this).text();
                }    
                i++;
            });

            // --------- do AJAX request ( to delete the exam from database )
            $.ajax({
                method: "GET",
                url: "deleteExam_ajax.php",
                data: {"examCode":examCode},
                success: function(isDeleted){
                    if(isDeleted == true){

                        swal({
                            title: 'Correct',
                            text: 'Deleted successfully.',
                            type: 'success', 
                            showConfirmButton: false, 
                            timer: 1000
                        });

                    }
                }
            });


            // ------------------------- remove the exam from the table 
            $(this).closest('tr').remove();

            // re-order the exams in the all exams 
            var Numbers = document.querySelectorAll(".examsCounter");
            
            for(var i=0; i<Numbers.length; i++){
                Numbers[i].textContent = i+1;
            }
          
        }
      })

});


$('table').on('click', 'input.manageQuestions[type="button"]', function(e){
    
    // get the exam id from the row

    var $row = $(this).closest("tr");       
        $tds = $row.find("td");             

    var i=0;
    var examCode, examName;
    $.each($tds, function() {                    
       if(i==1)
         examName = $(this).text();
       if(i==2)
         examCode = $(this).text();

        i++;
    });

    // redirect to manage questions page
    window.location = "manageQuestions.php?exam_code=" + examCode + "&exam_name=" + examName;
    
});
