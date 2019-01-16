<?php
  session_start();
  
  if(!isset($_SESSION['examiner']['id'])){
    die("<h1>! You can't be able to access this page</h1>");
  }
  
  $pageName = "Show Exam Page";

  require_once "globals/global.php";

  require_once "Models/db_connection.php";
?>

  <link rel="stylesheet" href="./css/showExam.css">

</head>

<body>
    
<?php include ("globals/Examinar_header.php"); ?>


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
                    var target = document.getElementById('allQuestinos_area');
                    target.insertAdjacentHTML('beforeend','<div class=\'question\'><div class=\'question_body\'>Question <span>$i</span> : <span>$qBody</span> </div><div class=\'option\'><span> 1</span> - <span>$op1</span> </div><div class=\'option\'><span> 2</span> - <span>$op2</span> </div><div class=\'option\'><span> 3</span> - <span>$op3</span>  </div><div class=\'option\'><span> 4</span> - <span>$op4</span>  </div><div class=\'correct_answer\'>Correct Answer Number : <span>$correctA</span>  </div></div>');
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

                    <div class="">
                      <div id="allQuestinos_area">

                        <!-- <div class="question">
                            <div class="question_body">
                                Question <span>1</span> : <span>What is SLR in bottom-up parsing ?</span> 
                            </div>
                            <div class="option">
                                <span>1</span> - <span>demo option x</span> 
                            </div>
                            <div class="option">
                                <span>2</span> - <span>demo option y</span> 
                            </div>
                            <div class="option">
                                <span>3</span> - <span>demo option w</span>  
                            </div>
                            <div class="option">
                                <span>4</span> - <span>demo option z</span>  
                            </div>
                            <div class="correct_answer">
                                Correct Answer Number : <span>3</span>  
                            </div>
                        </div> -->

                       </div>
                    </div>
                    <span><a href="allExams.php" id="backbtn" class="btn btn-secondary backBtn">&emsp;Back&emsp;</a></span>
 
            </div>
        </div> 
    </div>

    <?php require_once "globals/global_footer.php" ?>

</body>
</html>