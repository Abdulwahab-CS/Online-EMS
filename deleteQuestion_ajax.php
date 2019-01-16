<?php

require_once "Models/db_connection.php";


$exam_code = mysqli_real_escape_string($conn, $_GET['exam_code']);
$question_id = mysqli_real_escape_string($conn, $_GET['question_id']);

$query = "DELETE FROM question WHERE exam_code='$exam_code' AND question_id='$question_id' ";

$flag = false;
if( !$result = mysqli_query($conn, $query) ){
    
    die(mysqli_error($conn));
} else {

    $flag = true;
}

echo $flag;
