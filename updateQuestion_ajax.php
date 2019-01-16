<?php

require_once "Models/db_connection.php";


$exam_code =  mysqli_real_escape_string($conn, $_GET['exam_code']);
$question_id = mysqli_real_escape_string($conn, $_GET['question_id']);
$qBody = mysqli_real_escape_string($conn, $_GET['qBody']);
$op1 = mysqli_real_escape_string($conn, $_GET['op1']);
$op2 = mysqli_real_escape_string($conn, $_GET['op2']);
$op3 = mysqli_real_escape_string($conn, $_GET['op3']);
$op4 = mysqli_real_escape_string($conn, $_GET['op4']);
$correctA = mysqli_real_escape_string($conn, $_GET['correctA']);


$query = "UPDATE question SET question_body = '$qBody', answer1 = '$op1', answer2 = '$op2', answer3 = '$op3', answer4 = '$op4', correct_ans = '$correctA' WHERE exam_code='$exam_code' AND question_id='$question_id' ";

$flag = false;
if( !$result = mysqli_query($conn, $query) ){
    
    die(mysqli_error($conn));
} else {

    $flag = true;
}

echo $flag;
