<?php

  require_once "Models/db_connection.php";

  if( isset($_GET['examCode']) ) {
        
        $code = mysqli_real_escape_string($conn, $_GET['examCode']);

        // delete the exam from the database
        $query = "DELETE FROM exam WHERE e_code = '$code'";

        $deleted = false;
        if( !$result = mysqli_query($conn, $query) ){
            die(mysqli_error($conn));
        }else{
            $deleted = true;
        }

        echo $deleted;
    }
