<?php
 session_start();

 if(!isset($_SESSION['examiner']['id'])){
    die("<h1>! You can't be able to access this page</h1>");
 }

  $pageName = "Edit Exam Page";

  require_once "globals/global.php";

  require_once "Models/db_connection.php";

?>
    
    <link rel="stylesheet" href="./css/editExamNameOrCode.css">

</head>

<body>
    
<?php include ("globals/Examinar_header.php"); ?>

<?php // update exam code or name
       
       if( isset($_POST['updateExamBtn']) ){
           
        $examCode = mysqli_real_escape_string($conn, $_POST['examCode']);

        // check if found an exam with these info
        $query = "SELECT * FROM exam WHERE e_code = '$examCode' ";
        
        $found = false;

        if( !$result = mysqli_query($conn, $query) ) {
            die("<h1>Error Happened</h1>");
       
        } else {
            $rowcount = mysqli_num_rows($result);
            $row = mysqli_fetch_array($result);

            if($rowcount == 1){
                $found = true;
            }
        }

        if($found){

            $eName = $row['e_name'];
            $eCode = $row['e_code'];

            $_SESSION['examName_toChange'] = $eName;
            $_SESSION['examCode_toChange'] = $eCode;
            
            echo "<script> 
                swal({
                    title: 'OK', 
                    type: 'success',
                    showConfirmButton: false, 
                    timer: 500
                });
                setTimeout(function(){
                   window.location = 'editExamNameOrCode2.php'; 
                }, 500); 
            </script>";
                
        }else {
            echo "<script> 
                swal({title: 'Error', text: '!! Exam code not found', type: 'error'}); 
            </script>";
        }

       }
   ?>



<div class="container" id="my_container_header">
    <h2>Update Exam</h2>
    <p>Enter old exam code , to update the exam name or exam code</p>
</div>

<div class="container">
    <div class="row">
        <div class="col">

            <div id="my_container">
                <form id="updateExam_form" method="post" action="editExamNameOrCode.php" autocomplete="off">
            
                    <div class="input-group my_input_group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Old Exam Code : </span>
                        </div>
                        <input id="examCode" name="examCode" type="text" class="form-control"/>
                    </div>

                    <!-- <span><a href="#" id="createBtn" class="btn btn-primary">Create Exam</a></span> -->
                    <input id="submit" type="submit" name="updateExamBtn" class="btn btn-primary myBtn" value="OK">
                    <span><a href="examinerMainPage.php"  class="btn btn-secondary myBtn">Back</a></span>

                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once "globals/global_footer.php" ?>

<script src="js/editExamNameOrCode.js"></script>

</body>
</html>
