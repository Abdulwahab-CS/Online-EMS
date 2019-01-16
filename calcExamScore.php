<?php
    session_start();
    require_once "Models/db_connection.php";


    if(isset($_POST['examCode'])){

        $eCode = mysqli_real_escape_string($conn, $_POST['examCode']);
        $allAnswers = $_POST['allAnswers'];

        $max_score = count($allAnswers);
        $exam_score = 0;

        // get all correct anwers for each question & calc score
        $query = "SELECT correct_ans FROM question WHERE exam_code='$eCode' ";

        if( !$result = mysqli_query($conn, $query)){
            die("<h1>Error happended while excuting the query</h1>");
        }else {

            // calc the exam score
            $i = 0;
            while($row = mysqli_fetch_array($result)){
                if( $row['correct_ans'] == $allAnswers[$i]){
                    ++$exam_score;
                }
                ++$i;
            }

            // update the database with the exam score
            $studentID = $_SESSION['student']['id'];

            $query = "INSERT INTO take_exam (student_id, exam_code, exam_score, max_score) VALUES ('$studentID', '$eCode', '$exam_score', '$max_score')";

            if( !$result = mysqli_query($conn, $query)){
                die("<h1>Error happended while excuting the query</h1>");
            
            } 

        }

    }
