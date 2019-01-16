<?php
  session_start();

  if(!isset($_SESSION['examiner']['id'])){
    die("<h1>! You can't be able to access this page</h1>");
  }

  $pageName = "All Exams Page";

  require_once "globals/global.php";

  require_once "Models/db_connection.php";

?>

   <link rel="stylesheet" href="./css/allExams.css">

</head>


<body>

<?php include ("globals/Examinar_header.php"); ?>


<?php // show all the exams in the database 
    
        // -------------------------------------------- print all the exams
        $query = "SELECT * FROM exam";
    
        if( !$allExams = mysqli_query($conn, $query) ){
            die(mysqli_error($conn));

        }else{

            // check if there is no exams, show 'no exams recorded phrase'
            $rowsNum = mysqli_num_rows($allExams);
            if($rowsNum == 0) {
                echo "<script>
                    $(document).ready(function() { 
                        document.getElementsByClassName('noExams')[0].style.display = 'block';
                    });
                </script>";
            
            }else {

                $examsCount = 1;
                // add exams in the table
                while($row = mysqli_fetch_row($allExams)){

                    $examName = $row[0];
                    $examCode = $row[1];

                    // get the number of quesionts in this exam
                    $query = "SELECT * FROM question WHERE exam_code = '$examCode'";

                    if( !$allQuestions = mysqli_query($conn, $query) ){
                        die(mysqli_error($conn));
                    
                    }else{
                        $questionsNum = mysqli_num_rows($allQuestions);

                        echo "<script>
                            $(document).ready(function() {
                                var target = document.getElementById('table_body');
                                target.insertAdjacentHTML('beforeend', \"<tr><td class='examsCounter'>$examsCount</td><td>$examName</td><td>$examCode</td><td>$questionsNum</td><td><input type=\'button\' class=\'btn showExam'\ value='\Show\'> <input type=\'button\' class=\'btn manageQuestions\' value=\'Manage Questions\'> <input type=\'button\' class=\'btn deleteBtn\' value=\'Delete\'></td></tr>\");
                            });
                            
                        </script>";
                    
                    }

                    $examsCount++;
                }


                // make the table visiable to UI
                echo "<script>
                $(document).ready(function() {
                    document.getElementsByClassName('allExamsTable')[0].removeAttribute('style');     
                });
                </script>";

            }


        }

?>

<?php  // (this code is used before using AJAX) to delete an exam

    // if( isset($_GET['examCode_toDelete']) ) {
        
    //     $code = $_GET['examCode_toDelete'];

    //     // delete the exam from the database

    //     $query = "DELETE FROM exam WHERE e_code = '$code'";

    //     $deleted = false;
    //     if( !$result = mysqli_query($conn, $query) ){
    //         die(mysqli_error($conn));
    //     }else{
    //         $deleted = true;
    //     }

    //     if($deleted){
    //         echo "<script> swal({
    //             title: 'Correct',
    //             text: 'Deleted successfully.',
    //             type: 'success', 
    //             showConfirmButton: false, 
    //             timer: 1000
    //         }); 
    //         </script>";
    //     }else {
    //         echo "<script> 
    //             swal({title: 'Error', text: '!! Somthing wrong happned', type: 'error'}); 
    //         </script>";
    //     }


    //     // ----------------- after deleting the exam from the database, print again all exams
    //     // -------------------------------------------- print all the exams
    //     $query = "SELECT * FROM exam";
    
    //     if( !$allExams = mysqli_query($conn, $query) ){
    //         die(mysqli_error($conn));

    //     }else{
            
    //         $examsCount = 1;
    //         // add exams in the table
    //         while($row = mysqli_fetch_row($allExams)){

    //             $examName = $row[0];
    //             $examCode = $row[1];

    //             // get the number of quesionts in this exam
    //             $query = "SELECT * FROM question WHERE exam_code = '$examCode'";

    //             if( !$allQuestions = mysqli_query($conn, $query) ){
    //                 die(mysqli_error($conn));
                
    //             }else{
    //                 $questionsNum = mysqli_num_rows($allQuestions);

    //                 echo "<script>
    //                     $(document).ready(function() {
    //                         var target = document.getElementById('table_body');
    //                         target.insertAdjacentHTML('beforeend', \"<tr><td>$examsCount</td><td>$examName</td><td>$examCode</td><td>$questionsNum</td><td><input type=\'button\' class=\'btn showExam'\ value='\Show\'> <input type=\'button\' class=\'btn manageQuestions\' value=\'Manage Questions\'> <input type=\'button\' class=\'btn deleteBtn\' value=\'Delete\'></td></tr>\");
    //                     });
                        
    //                 </script>";
                
    //             }

    //             $examsCount++;
    //         }

    //     }

    // }


?>

    <div class="container">
        <div class="row">
            <div class="col">

                <div class="allExams_header">All Exams</div>
               
                <table class="table allExamsTable" style="display:none;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Exam Name</th>
                            <th>Exam Code</th>
                            <th>Questions Number</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody id="table_body">
                        <!-- <tr>
                            <td class="examsCounter">1</td>
                            <td>compiler</td>
                            <td>cs123</td>
                            <td>10</td>
                            <td><input type="button" class="btn showExam" value="Show"> <input type="button" class="btn manageQuestions" value="Manage Questions"> <input type="button" class="btn deleteBtn" value="Delete"></td>
                        </tr> -->
                    </tbody>
                </table>
                

                <div class="card card-body noExams">
                    <h4>No exams found</h4>
                </div>
 
                
                <hr>
                <span class="btn btn-success addNewQBtn"><a href="addExam.php">Add New Exam</a></span>
                <span><a href="examinerMainPage.php"  class="btn btn-secondary myBtn">Back</a></span>
            </div>
        </div>
    </div>
    
    <?php require_once "globals/global_footer.php" ?>

     <script src="js/allExams.js"></script> 
    
</body>
</html>
