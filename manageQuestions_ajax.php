<?php
    session_start();
    
    require_once "Models/db_connection.php";

    // ------------------------------------------------------------------------ add the question to the exam
    
    $examcode = mysqli_real_escape_string($conn, $_POST['exam_code']);
    $examname = $_POST['exam_name'];


    // ------> get all questions of the selected exam to calculate the questions id
    $query = "SELECT * FROM question WHERE exam_code='$examcode'";

    if( !$result = mysqli_query($conn, $query) ){
        die(mysqli_error($conn));
        
    }else {
        $numberOfQuestions = mysqli_num_rows($result);

        if($numberOfQuestions > 0){
            // get the question_id for the last row
            $i=0;
            while($row = mysqli_fetch_row($result)){
                $tempArr[$i] = $row[1];
                $i++; 
            }
            $lastID = end($tempArr);
        }else{
            // means no questions
            $lastID = -1;
        }
        
        
    }
    // the id for the new question is the lastID + 1,  or 1 if it's the first question
    if($lastID != -1)
        $question_id = $lastID+1;
    else{
        // means the first question
        $question_id = 1;
    }


    // fetch the data from the form to add the new question
    $question_body = mysqli_real_escape_string($conn, $_POST['qBody']);
    $question_op1 = mysqli_real_escape_string($conn, $_POST['op1']);
    $question_op2 = mysqli_real_escape_string($conn, $_POST['op2']);
    $question_op3 = mysqli_real_escape_string($conn, $_POST['op3']);
    $question_op4 = mysqli_real_escape_string($conn, $_POST['op4']);
    $question_correctA = mysqli_real_escape_string($conn, $_POST['correctA']);


    // --> add the question to the exam in the database
    $table = "question";
    $query = "INSERT INTO $table (exam_code, question_id, question_body, answer1, answer2, answer3, answer4, correct_ans) VALUES ('$examcode', '$question_id', '$question_body', '$question_op1', '$question_op2', '$question_op3', '$question_op4', '$question_correctA')"; 
    
    $added = false;
    if( !$result = mysqli_query($conn, $query) ){
        die(mysqli_error($conn));
    }else{
        $added = true;
    }

    // return the id of the new question to the manageQuestions.js to take it from there
    echo $question_id;
