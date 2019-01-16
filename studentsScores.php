<?php
  session_start();
  
  if(!isset($_SESSION['examiner']['id'])){
    die("<h1>! You can't be able to access this page</h1>");
  }

  $pageName = "Students Scores Page";

  require_once "globals/global.php";

  require_once "Models/db_connection.php";

?>

   <link rel="stylesheet" href="./css/studentsScores.css">

</head>

<body>
    
<?php include ("globals/Examinar_header.php"); ?>

<?php  // delete all students records from database if the btn press clear btn
    if(isset($_GET['clearAll'])){
        $query = "DELETE FROM take_exam WHERE 1";

        if( !$result = mysqli_query($conn, $query) ){
            die(mysqli_error($conn));
        
        }else{
           
            echo "<script>
                swal({
                    title: 'Correct',
                    text: 'Cleared successfully.',
                    type: 'success', 
                    showConfirmButton: false, 
                    timer: 1500
                });
            </script>";

        }
    }
?>

<?php // show all scores

    $query = "SELECT * FROM take_exam";
    
    if( !$result = mysqli_query($conn, $query) ){
        die(mysqli_error($conn));

    }else{
        $rowsNumber = mysqli_num_rows($result);
        if($rowsNumber == 0){
            echo "<script>
                $(document).ready(function() { 
                    document.getElementsByClassName('empryScores')[0].style.display = 'block';
                });
            </script>";
        
        }else {

            $i=1;
            while($rows = mysqli_fetch_array($result))
            {
                $studentID = mysqli_real_escape_string($conn, $rows['student_id']);
                $examCode = mysqli_real_escape_string($conn, $rows['exam_code']);
                $exam_score = $rows['exam_score'];
                $max_score = $rows['max_score'];
                $examName;
                $studentName;

                // get the student name
                $query2 = "SELECT  f_name, s_name, l_name FROM student WHERE student_id = '$studentID'";
                if( !$result2 = mysqli_query($conn, $query2) ) {
                    die("<h1>!! Error happend while excute the query</h1>");
                }else {
                    $temp1 = mysqli_fetch_array($result2);
                    $studentName = $temp1['f_name']. ' ' . $temp1['s_name'] . ' ' . $temp1['l_name'];
                }


                // get the exam name
                $query3 = "SELECT e_name FROM exam WHERE e_code='$examCode' ";
                if( !$result3 = mysqli_query($conn, $query3) ){
                    die(mysqli_error($conn)); 
                }else{
                    $temp2 = mysqli_fetch_array($result3);
                    $examName = $temp2['e_name'];
                }


                echo "<script>
                    $(document).ready(function() {

                        var target = document.getElementById('table_body');
                        var code = '<th>$i</th><td>$studentName</td><td>$examName</td><td>$examCode</td><td>$exam_score</td><td>$max_score</td>';
                        target.insertAdjacentHTML('beforeend', code);
                    });
                </script>";

                $i++;
            }


            // make the table visiable to UI & make the clear btn visiable
            echo "<script>
                $(document).ready(function() {
                    document.getElementsByClassName('scoresTable')[0].removeAttribute('style');
                    document.getElementsByClassName('clearBtn')[0].removeAttribute('style');     
                });
            </script>";
        }
    
    }
?>


<div class="container">
    <div class="row">
        <div class="col">

            <div class="header">All Students Scores</div>

            <table class="table table-hover scoresTable" style="display:none;">
                <thead>
                    <tr>
                        <th rowspan="2">#</th>
                        <th rowspan="2">Student Name</th>
                        <th colspan="2">Exam</th>
                        <th colspan="2">Score</th> 
                    </tr>
                    <tr>
                        <th class="sub_th">Exam Name</th>
                        <th class="sub_th">Exam Code</th>
                        <th class="sub_th">Exam Score</th>
                        <th class="sub_th">Max Score</th>
                    </tr>
                </thead>

                <tbody id="table_body">
                    <!-- <tr>
                        <th>1</th>
                        <td>Abdulwahab Ahmad Alhendi</td>
                        <td>Compilers</td>
                        <td>cs123</td>
                        <td>6</td>
                        <td>10</td>
                    </tr>
                    <tr>
                        <th>2</th>
                        <td>Ali Ahmad Sami</td>
                        <td>Networks</td>
                        <td>cs442</td>
                        <td>5</td>
                        <td>7</td>
                    </tr> -->
                </tbody>
            </table>

            <div class="card card-body empryScores">
                <h4>No scores recorded</h4>
            </div>

            <span><a href="examinerMainPage.php"  class="btn btn-secondary myBtn">Back</a></span>
            <button class="btn btn-outline-success clearBtn" style="display: none;">Clear</button>

        </div>
    </div>
</div>




    <?php require_once "globals/global_footer.php" ?>

    <script src="./js/studentsScores.js"></script> 

</body>
</html>