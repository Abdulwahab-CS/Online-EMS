<?php
  session_start();

  if(!isset($_SESSION['examiner']['id'])){
    die("<h1>! You can't be able to access this page</h1>");
  }

  $pageName = "Manage Questions page";

  require_once "globals/global.php";

  require_once "Models/db_connection.php";

?>

  <link rel="stylesheet" href="./css/manageQuestions.css">
 
</head>

<body>
    
<?php include ("globals/Examinar_header.php"); ?>


<?php // show the exam info
    
    if( isset($_GET['exam_code']) ) {
        
      $examcode = mysqli_real_escape_string($conn, $_GET['exam_code']);
      $examname = $_GET['exam_name'];

      // ----------------- 1st) show the exam name & code and make them disabled on the GUI 
      // ----------------- 2nd) add the exam name & exam code in the new question collapse form as hidden inputs
      echo "<script>
        $(document).ready(function(){
            document.getElementById('examName').value = '$examname';
            document.getElementById('examCode').value = '$examcode';
            document.getElementById('examName').disabled = true;
            document.getElementById('examCode').disabled = true;
        
        
            // add the exam name & exam code in the new question collapse form as hidden fields
    
            document.getElementById('exam_name_forTheNewQ').value = '$examname';
            document.getElementById('exam_code_forTheNewQ').value = '$examcode';
        }); 
      </script>";
      

      // ----------------------------- show all the questions for this exam  ------------------------------------

      $query = "SELECT * FROM question WHERE exam_code = '$examcode'";
      
      if( !$result = mysqli_query($conn, $query) ) {
        die(mysqli_error($conn));
        
      }else {

        $counter = 1;
        while( $row = mysqli_fetch_row($result) ) {
            
            // add the questions of this exam in the questions list
            $id = $row[1];
            $qBody = $row[2];
            $op1 = $row[3];
            $op2 = $row[4];
            $op3 = $row[5];
            $op4 = $row[6];
            $correctA = $row[7];
           
            echo "<script> 
                var id = '$id';
                var qBody = '$qBody';
                var op1 = '$op1'; 
                var op2 = '$op2'; 
                var op3 = '$op3';
                var op4 = '$op3';
                var correctA = '$correctA';
                
                $(document).ready(function() {  
                    var target = document.getElementById('questionsList');
                    target.insertAdjacentHTML('beforeend','<div id=\'$id\'><div id=\'question-$id\' class=\'question\' data-toggle=\'collapse\' data-target=\'#question-$id-collapse\'><span class=\'qNum\'>Question $counter</span></div><div class=\'collapse\' id=\'question-$id-collapse\'><div class=\'card card-body question_collapse\'><form autocomplete=\'off\'><div class=\'input-group my_input_group_collapse\'><div class=\'input-group-prepend\'><span class=\'input-group-text\'>Question : </span></div><textarea id=\'question-$id-body\'  class=\'form-control\' aria-label=\'With textarea\'>$qBody</textarea></div><div class=\'input-group my_input_group_collapse\'><div class=\'input-group-prepend\'><span class=\'input-group-text\'>Option 1 : </span></div><input id=\'question-$id-option-1\' value=\'$op1\' type=\'text\' class=\'form-control\' /></div><div class=\'input-group my_input_group_collapse\'><div class=\'input-group-prepend\'><span class=\'input-group-text\'>Option 2 : </span></div><input id=\'question-$id-option-2\' value=\'$op2\' type=\'text\' class=\'form-control\' /></div><div class=\'input-group my_input_group_collapse\'><div class=\'input-group-prepend\'><span class=\'input-group-text\'>Option 3 : </span></div><input id=\'question-$id-option-3\' value=\'$op3\' type=\'text\' class=\'form-control\' /></div><div class=\'input-group my_input_group_collapse\'><div class=\'input-group-prepend\'> <span class=\'input-group-text\'>Option 4 : </span></div><input id=\'question-$id-option-4\' value=\'$op4\' type=\'text\' class=\'form-control\' /></div><div class=\'input-group my_input_group_collapse\'><div class=\'input-group-prepend\'><span class=\'input-group-text\'>Correct Answer : </span></div><input id=\'question-$id-correctA\' value=\'$correctA\' type=\'number\' class=\'form-control\' /></div><hr><button id=\'updateQuestion-$id-Btn\' type=\'submit\' style=\'background-color: #05668D;\' class=\'btn btn-primary updateQ_btn\' disabled>Update</button><button type=\'button\' style=\'margin-left: 5px; background-color: #F26868; \' class=\'btn btn-danger deleteQ_btn\'>Delete</button></form> </div></div></div>');
                }); 
            </script>";
            $counter++;
        }
        
      }

    }
?>

<?php // (this code used before using AJAX) add new question

    // if( isset($_POST['submit_new_question']) )
    // {   
    //     // ------------------------------------------------------------------------ add the question to the exam
        
    //     // -------------------------------- get the exam info from the session
    //     $examcode = $_SESSION['exam_code'];
    //     $examname = $_SESSION['exam_name'];

    //     // get all questions of the selected exam to calculate the questions id
    //     $query = "SELECT * FROM question WHERE exam_code='$examcode'";

    //     if( !$result = mysqli_query($conn, $query) ){
    //         die(mysqli_error($conn));
            
    //     }else {
    //         $numberOfQuestions = mysqli_num_rows($result);

    //         if($numberOfQuestions > 0){
    //             // get the question_id for the last row
    //             $i=0;
    //             while($row = mysqli_fetch_row($result)){
    //                 $tempArr[$i] = $row[1];
    //                 $i++; 
    //             }
    //             $lastID = end($tempArr);
    //         }else{
    //             // means no questions
    //             $lastID = -1;
    //         }
            
            
    //     }
    //     // the id for the new question is the lastID + 1,  or 1 if it's the first question
    //     if($lastID != -1)
    //         $question_id = $lastID+1;
    //     else{
    //         // means the first question
    //         $question_id = 1;
    //     }

    //     // fetch the data from the form to add the new question
    //     $question_body = $_POST['newQ_body'];
    //     $question_op1 = $_POST['newQ_option1'];
    //     $question_op2 = $_POST['newQ_option2'];
    //     $question_op3 = $_POST['newQ_option3'];
    //     $question_op4 = $_POST['newQ_option4'];
    //     $question_correctA = $_POST['newQ_correctA'];


    //     // --> add the question to the exam in the database
    //     $table = "question";
    //     $query = "INSERT INTO $table (exam_code, question_id, question_body, answer1, answer2, answer3, answer4, correct_ans) VALUES ('$examcode', '$question_id', '$question_body', '$question_op1', '$question_op2', '$question_op3', '$question_op4', '$question_correctA')"; 
        
    //     $added = false;
    //     if( !$result = mysqli_query($conn, $query) ){
    //         die(mysqli_error($conn));
    //     }else{
    //         $added = true;
    //     }

    //     if($added){
    //         echo "<script>        
    //                 swal({title: 'Correct', text: 'Question added successfully', type: 'success', showConfirmButton: false, timer: 2500}); 
    //             </script>";
    //             //  refresh the page
    //             // header("Location: manageQuestions.php");
    //     }else {
    //         echo "<h2>Error<h2>";
    //     }
        
        

    //     // ------------------------ after inserint the question 
    //     // ------------------------ print the exam code and name again and make them disabled $ print all the questions

    //     // --------------- get the exam info from the database & show the name & code and make them disabled 
    //     $query = "SELECT e_name FROM exam WHERE e_code = '$examcode'";
        
    //     if( !$result = mysqli_query($conn, $query) ){
    //         die(mysqli_error($conn));
            
    //     }else {

    //         $row = mysqli_fetch_row($result);
    //         $examname = $row[0];
    //     }

    //     // put the exam name and exam code on the GUI
    //     echo "<script>
    //         $(document).ready(function(){
    //             document.getElementById('examName').value = '$examname';
    //             document.getElementById('examCode').value = '$examcode';
    //             document.getElementById('examName').disabled = true;
    //             document.getElementById('examCode').disabled = true;
    //         }); 
    //     </script>";

        
    //     // -------------------------------------------- show all the questions for this exam

    //     $query = "SELECT * FROM question WHERE exam_code = '$examcode'";
        
    //     if( !$result = mysqli_query($conn, $query) ) {
    //         die(mysqli_error($conn));
            
    //     }else {

    //         $counter = 1;
    //         while( $row = mysqli_fetch_row($result) ) {
                
    //             // add the questions of this exam in the questions list
    //             $id = $row[1];
    //             $qBody = $row[2];
    //             $op1 = $row[3];
    //             $op2 = $row[4];
    //             $op3 = $row[5];
    //             $op4 = $row[6];
    //             $correctA = $row[7];
            
    //             echo "<script> 
    //                 var id = '$id';
    //                 var qBody = '$qBody';
    //                 var op1 = '$op1'; 
    //                 var op2 = '$op2'; 
    //                 var op3 = '$op3';
    //                 var op4 = '$op3';
    //                 var correctA = '$correctA';
                    
    //                 $(document).ready(function() {  
    //                     var target = document.getElementById('questionsList');
    //                     target.insertAdjacentHTML('beforeend','<div id=\'question-$id\' class=\'question\' data-toggle=\'collapse\' data-target=\'#question-$id-collapse\'>Question $counter</div><div class=\'collapse\' id=\'question-$id-collapse\'><div class=\'card card-body question_collapse\'><form><div class=\'input-group my_input_group_collapse\'><div class=\'input-group-prepend\'><span class=\'input-group-text\'>Question : </span></div><textarea id=\'question-$id-body\'  class=\'form-control\' aria-label=\'With textarea\'>$qBody</textarea></div><div class=\'input-group my_input_group_collapse\'><div class=\'input-group-prepend\'><span class=\'input-group-text\'>Option 1 : </span></div><input id=\'question-$id-option-1\' value=\'$op1\' type=\'text\' class=\'form-control\' /></div><div class=\'input-group my_input_group_collapse\'><div class=\'input-group-prepend\'><span class=\'input-group-text\'>Option 2 : </span></div><input id=\'question-$id-option-2\' value=\'$op2\' type=\'text\' class=\'form-control\' /></div><div class=\'input-group my_input_group_collapse\'><div class=\'input-group-prepend\'><span class=\'input-group-text\'>Option 3 : </span></div><input id=\'question-$id-option-3\' value=\'$op3\' type=\'text\' class=\'form-control\' /></div><div class=\'input-group my_input_group_collapse\'><div class=\'input-group-prepend\'> <span class=\'input-group-text\'>Option 4 : </span></div><input id=\'question-$id-option-4\' value=\'$op4\' type=\'text\' class=\'form-control\' /></div><div class=\'input-group my_input_group_collapse\'><div class=\'input-group-prepend\'><span class=\'input-group-text\'>Correct Answer : </span></div><input id=\'question-$id-correctA\' value=\'$correctA\' type=\'number\' class=\'form-control\' /></div><hr><button id=\'updateQuestion-$id-Btn\' type=\'submit\' class=\'btn btn-primary\' disabled>Update</button><button id=\'deleteQuestion-$id-Btn type=\'button\' style=\'margin-left: 5px;\' class=\'btn btn-danger\' disabled>Delete</button></form> </div></div>');
    //                 }); 
    //             </script>";
    //             $counter++;
    //         }
            
    //     }

    // }

?>

<div class="container my_container">
    <div class="row">
        <div class="col">

                <div class="input-group my_input_group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Exam Name : </span>
                    </div>
                    <input id="examName" type="text" class="form-control" />
                </div>
                <div class="input-group my_input_group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Exam Code : </span>
                    </div>
                    <input id="examCode" type="text" class="form-control" />
                </div>
        
            <span><a href="allExams.php" id="backbtn" class="btn btn-secondary backBtn">Back</a></span>
            <span><a href="#newQcollapse" id="addQuestion" class="btn btn-info addQBtb" data-toggle="collapse">Add New Question</a></span>

             

            <!-- New Question Collapse -->
            <div class="collapse" id="newQcollapse">
                <div class="card card-body newQuestion_collapse" id="my_card">
                <form autocomplete="off">
                       <div class="input-group newQ_my_input_group_collapsebody">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Question : </span>
                            </div>
                            <textarea id="newQ_body" name="newQ_body" class="form-control" aria-label="With textarea"></textarea>
                        </div>

                        <div class="input-group my_input_group_collapse">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Option 1 : </span>
                            </div>
                            <input id="newQ_option1" name="newQ_option1" type="text" class="form-control"/>
                        </div>
                        
                        <div class="input-group my_input_group_collapse">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Option 2 : </span>
                            </div>
                            <input id="newQ_option2" name="newQ_option2" type="text" class="form-control"/>
                        </div>
                        
                        <div class="input-group my_input_group_collapse">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Option 3 : </span>
                            </div>
                            <input id="newQ_option3" name="newQ_option3" type="text" class="form-control"/>
                        </div>

                        <div class="input-group my_input_group_collapse">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Option 4 : </span>
                            </div>
                            <input id="newQ_option4" name="newQ_option4" type="text" class="form-control"/>
                        </div>

                        <div class="input-group my_input_group_collapse">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Correct Answer : </span>
                            </div>
                            <input id="newQ_correctA" name="newQ_correctA" type="number" class="form-control"/>
                        </div>

                        <hr>

                        <input type="hidden" id="exam_name_forTheNewQ" name="exam_name_forTheNewQ" value="">
                        <input type="hidden" id="exam_code_forTheNewQ" name="exam_code_forTheNewQ" value="">

                        <input id="add_new_question" type="button" name="add_new_question" class="btn btn-success" value="Add Question">
                   </form> 
                </div>
            </div>

        </div>
    </div>
</div>


<!-- Questions List -->
<div class="container QL_contianer">
    
        <div class="col">
            
            <h4 class="QL_header">Questions List</h4>

            <div id="questionsList">

            <!-- question 1 sample
              <div id="wholeQuestion-1">
                <div id="question-1" class="question" data-toggle="collapse" data-target="#question-1-collapse"><b>Question 1<b></div>
                <div class="collapse" id="question-1-collapse">
                    <div class="card card-body question_collapse">
                        <form>
                            <div class="input-group my_input_group_collapse">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Question : </span>
                                </div>
                                <textarea id="question-1-body" class="form-control" aria-label="With textarea" ></textarea>
                            </div>

                            <div class="input-group my_input_group_collapse">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Option 1 : </span>
                                </div>
                                <input id="question-1-option-1" type="text" class="form-control" />
                            </div>
                            
                            <div class="input-group my_input_group_collapse">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Option 2 : </span>
                                </div>
                                <input id="question-1-option-2" type="text" class="form-control" />
                            </div>
                            
                            <div class="input-group my_input_group_collapse">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Option 3 : </span>
                                </div>
                                <input id="question-1-option-3" type="text" class="form-control" />
                            </div>

                            <div class="input-group my_input_group_collapse">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Option 4 : </span>
                                </div>
                                <input id="question-1-option-4" type="text" class="form-control" />
                            </div>

                            <div class="input-group my_input_group_collapse">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Correct Answer : </span>
                                </div>
                                <input id="question-1-correctA" type="number" class="form-control" />
                            </div>

                            <hr>

                            <button id="updateQuestion-1-Btn" type="submit" class="btn btn-primary updateQ_btn" disabled>Update</button>
                            <button id="deleteQuestion-1-Btn" data_id="delete" type="button" class="btn btn-danger deleteQ_btn" disabled>Delete</button>
                        </form> 
                     </div>
                  </div>
                
                </div>
            -->

                    
            </div>

        </div>
 
</div>

<?php require_once "globals/global_footer.php" ?>
 
<script src="./js/manageQuestions.js"></script>
 
</body>
</html>





<!-- MEMO 


// add the new question to recently created exam
        $choices = array($question_op1, $question_op2, $question_op3, $question_op4);
        $new_question = new Question($exam_code, $question_id, $question_body, $choices, $question_correctA);
        
        // loop on all_exams to find the recent created exam and add the question to it
        $iterator = $all_exams->getIterator();

        while ($iterator->valid()) {
            $e_Code = $iterator->current()->getCode();
            if($e_Code == $exam_code){
                //update the match exam
                $iterator->current()->setQuestions($new_question);
            }
            $iterator->next();
        }






-->