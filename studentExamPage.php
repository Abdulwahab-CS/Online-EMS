<?php
  session_start();

  if(!isset($_SESSION['student']['id'])){
    die("<h1>! You can't be able to access this page</h1>");
  }

  $pageName = "Student Exam Page";

  require_once "globals/global.php";

  require_once "Models/db_connection.php";
?>

 <link rel="stylesheet" href="./css/studentExamPage.css"> 
 
</head>

<body>

<?php
    if(isset($_GET['exam_code'])){

        // --------------------------------------------- get the exam information 
        $examCode = mysqli_real_escape_string($conn, $_GET['exam_code']);

        $query = "SELECT * FROM exam WHERE e_code = '$examCode'";
    
        if( !$results = mysqli_query($conn, $query) ){
            die(mysqli_error($conn));

        }else{
                // must will be one tow
                $row = mysqli_fetch_row($results);
                
                $examName = $row[0];
                $examCode = $row[1];
                
                
                // get the number of questions of this exam
                $query = "SELECT * FROM question WHERE exam_code = '$examCode'";

                if( !$allQuestions = mysqli_query($conn, $query) ){
                    die(mysqli_error($conn));
        
                }else{
                    $NumOfQuestions = mysqli_num_rows($allQuestions);
                    
                }
        }

        // ----------------------------  Now update the header info for the exam
        echo "<script>
            $(document).ready(function () {
                $('#eName').text('$examName');
                $('#eCode').text('$examCode');
                $('#questionsNum').text('$NumOfQuestions');
            });  
        </script>";

        
        // ----------------------- display all the quesions in this exam

        $i = 1;
        while( $row = mysqli_fetch_row($allQuestions) ) {
            
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
                    var target = document.getElementById('questoins_place');
                    target.insertAdjacentHTML('beforeend','<div class=\'question\'><div class=\'question_body\'><span class=\'question_number\'>$i - </span>$qBody</div><div class=\'radio option\'><label><input type=\'radio\' name=\'question-$i-opts\' value=\'1\'> $op1</label></div><div class=\'radio option\'><label><input type=\'radio\' name=\'question-$i-opts\' value=\'2\'> $op2</label></div><div class=\'radio option\'><label><input type=\'radio\' name=\'question-$i-opts\' value=\'3\'> $op3</label></div><div class=\'radio option\'><label><input type=\'radio\' name=\'question-$i-opts\' value=\'4\'> $op4</label></div></div>');
                }); 
            </script>";
            $i++;
        }


    }
?>


<div class="container">
    <div class="row">
        <div class="col">
        
            <div class="card card-header" style="background-color:  #05668D;">
                <div class="info">Exam Code : <span id="eCode">-</span></div>
                <div class="info">Exam Name : <span id="eName">-</span></div>
                <div class="info">Total Number of Questions : <span id="questionsNum">-</span></div>
            </div>

            <form>
            
              <div id="questoins_place">
            
                <!-- demo question

                    <div class="question">
                        <div class="question_body">
                            <span class="question_number">1</span> - What is top-down parsing in compiler course ?
                        </div>

                        <div class="radio option">
                            <label><input type="radio" name="question-1-opts" value="1"> Option 1 demo</label>
                        </div>
                        <div class="radio option">
                            <label><input type="radio" name="question-1-opts" value="2"> Option 2 demo</label>
                        </div>
                        <div class="radio option">
                            <label><input type="radio" name="question-1-opts" value="3"> Option 3 demo</label>
                        </div>
                        <div class="radio option">
                            <label><input type="radio" name="question-1-opts" value="4"> Option 4 demo</label>
                    </div>
                </div> -->

      
                <!-- <div class="nextBtn_container">
                    <button class="btn btn-info nextBtn" onclick="nextQ()">Next</button>
                    <button class="btn btn-secondary prevBtn" disabled>Prev</button>
                </div> -->

              </div> <!-- end questions list -->
            
              <input id="submitExamBtn" type="button" name="submitExamBtn" class="btn btn-primary submitBtn" value="Submit"> 
              <input type="button" class="btn btn-danger exitExamBtn" value="Exit Exam">
            
            </form> <!-- end form -->

        </div>
    </div>
</div>

<?php require_once "globals/global_footer.php" ?>

 <script src="js/studentExamPage.js"></script> 
  
</body>
</html>







<!-- Draft - not completed code - for the student answer the questions one by one 

class question {
                constructor(id, body, op1, op2, op3, op4, correctA) {
                    this.id_ = id;
                    this.body_ = body;
                    this.op1_ = op1;
                    this.op2_ = op2;
                    this.op3_ = op3;
                    this.op4_ = op4;
                    this.correctA_ = correctA; 
                }
            }

                var allQuestionsArray = [];

                var id = '$id';
                var qBody = '$qBody';
                var op1 = '$op1'; 
                var op2 = '$op2'; 
                var op3 = '$op3';
                var op4 = '$op3';
                var correctA = '$correctA';

                var question$i = new question(id, qBody, op1, op2, op3, op4, correctA);
                localStorage.setItem('Q$i', 'question$i');
                allQuestionsArray.push(question$i);
                

                // store the questions in the localStorage;
                
                // $(document).ready(function() {  
                //     var target = document.getElementById('questionsList');
                //     target.insertAdjacentHTML('beforeend','<div id=\'question-$id\' class=\'question\' data-toggle=\'collapse\' data-target=\'#question-$id-collapse\'>Question $counter</div><div class=\'collapse\' id=\'question-$id-collapse\'><div class=\'card card-body question_collapse\'><form><div class=\'input-group my_input_group_collapse\'><div class=\'input-group-prepend\'><span class=\'input-group-text\'>Question : </span></div><textarea id=\'question-$id-body\'  class=\'form-control\' aria-label=\'With textarea\'>$qBody</textarea></div><div class=\'input-group my_input_group_collapse\'><div class=\'input-group-prepend\'><span class=\'input-group-text\'>Option 1 : </span></div><input id=\'question-$id-option-1\' value=\'$op1\' type=\'text\' class=\'form-control\' /></div><div class=\'input-group my_input_group_collapse\'><div class=\'input-group-prepend\'><span class=\'input-group-text\'>Option 2 : </span></div><input id=\'question-$id-option-2\' value=\'$op2\' type=\'text\' class=\'form-control\' /></div><div class=\'input-group my_input_group_collapse\'><div class=\'input-group-prepend\'><span class=\'input-group-text\'>Option 3 : </span></div><input id=\'question-$id-option-3\' value=\'$op3\' type=\'text\' class=\'form-control\' /></div><div class=\'input-group my_input_group_collapse\'><div class=\'input-group-prepend\'> <span class=\'input-group-text\'>Option 4 : </span></div><input id=\'question-$id-option-4\' value=\'$op4\' type=\'text\' class=\'form-control\' /></div><div class=\'input-group my_input_group_collapse\'><div class=\'input-group-prepend\'><span class=\'input-group-text\'>Correct Answer : </span></div><input id=\'question-$id-correctA\' value=\'$correctA\' type=\'number\' class=\'form-control\' /></div><hr><button id=\'updateQuestion-$id-Btn\' type=\'submit\' class=\'btn btn-primary\' disabled>Update</button><button id=\'deleteQuestion-$id-Btn type=\'button\' style=\'margin-left: 5px;\' class=\'btn btn-danger\'>Delete</button></form> </div></div>');
                // }); 
            </script>";
            $i++;
        }

-->