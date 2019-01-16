<?php
  session_start();

  require_once "Models/db_connection.php";
    
  if(isset($_POST['exam_code'])){

    $exam_code = mysqli_real_escape_string($conn, $_POST['exam_code']);
    $student_id = mysqli_real_escape_string($conn, $_SESSION['student']['id']);

    //echo "<script>alert('exam Code : ' + $exam_code + ', student id : ' +  $student_id)</script>";
    $query = "SELECT * FROM take_exam WHERE student_id='$student_id' AND exam_code='$exam_code' ";
    
    $taken = false;
    if( !$result = mysqli_query($conn, $query) ){
        die(mysqli_error($conn));
    }else{
        $rowsNum = mysqli_num_rows($result);
        //echo "<script>alert('rowsNum : ' + $rowsNum )</script>";
        if($rowsNum >= 1)
            $taken = true;
    }

    echo $taken;

  }