<?php
  session_start();
  
  if(!isset($_SESSION['examiner']['id'])){
    die("<h1>! You can't be able to access this page</h1>");
  }

  $pageName = "Edit Exam Page";

  require_once "globals/global.php";

  require_once "Models/db_connection.php";
  
?>

   <link rel="stylesheet" href="./css/editExamNameOrCode2.css"> 

</head>

<body>
    
<?php include ("globals/Examinar_header.php"); ?>


<?php // show the exam name and the exam code to change -first time-

  if(!isset($_POST['updateExamBtn'])) {
    
    $eName = $_SESSION['examName_toChange'];
    $eCode = $_SESSION['examCode_toChange'];

    // put the exam name and exam code on the GUI
    echo "<script>
            $(document).ready(function(){
                document.getElementById('examName').value = '$eName';
                document.getElementById('examCode').value = '$eCode';
            }); 
    </script>";

  }
?>


<?php // update the exam name & exam code
    
    if( isset($_POST['new_exam_code']) ){

        if(isset($_SESSION['examCode_toChange'])){
            $oldCode = $_SESSION['examCode_toChange'];
        }

        $examName = mysqli_real_escape_string($conn, $_POST['new_exam_name']);
        $examCode = mysqli_real_escape_string($conn, $_POST['new_exam_code']);

        $table = "exam";
        $query = "UPDATE $table SET e_name = '$examName', e_code = '$examCode' WHERE e_code = '$oldCode' ";

        $updated = false;
        if( !$result = mysqli_query($conn, $query) ){
            die(mysqli_error($conn));
        }else{
            $updated = true;
        }

        // remove the exam name and exam code after updating 
        unset($_SESSION['examCode_toChange']);
        unset($_SESSION['examName_toChange']);

        echo $updated;
    }
?>



<div class="container" id="my_container_header">
    <h2>Update Exam</h2>
    <p>Update the exam name or the exam code</p>
</div>


<div class="container">
    <div class="row">
        <div class="col">
            
            <div id="my_container">
                <form>
                     <div class="input-group my_input_group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">New Exam Name : </span>
                        </div>
                        <input id="examName" name="examName" type="text" class="form-control"/>
                    </div>
                    
                    <div class="input-group my_input_group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">New Exam Code : </span>
                        </div>
                        <input id="examCode" name="examCode" type="text" class="form-control"/>
                    </div>

                    <input id="submitBtn" type="button" name="updateExamBtn" class="btn btn-info myBtn" value="Update Exam">
                    <span><a href="examinerMainPage.php"  class="btn btn-secondary myBtn">Back</a></span>
                </form>
            </div>
            
        </div>
    </div>
</div>

<?php require_once "globals/global_footer.php" ?>

<script src="js/editExamNameOrCode2.js"></script>

</body>
</html>
