<?php
  session_start();
  
  if(!isset($_SESSION['examiner']['id'])){
    die("<h1>! You can't be able to access this page</h1>");
  }

  $pageName = "Add Exam Page";

  require_once "globals/global.php";

  require_once "Models/db_connection.php";
  
?>

   <link rel="stylesheet" href="./css/addExam.css">

</head>

<body>
    
<?php include ("globals/Examinar_header.php"); ?>

<?php // adding new exam in the database
    
    if( isset($_POST['createExamBtn']) ){

        // create exam object
        $exam_code = mysqli_real_escape_string($conn, $_POST['examCode']);
        $exam_name = mysqli_real_escape_string($conn, $_POST['examName']);
        
        // ------- check if the exam already has been created - ( no exist exam with same exam code )
        $query = "SELECT * FROM exam WHERE e_code = '$exam_code'";
    
        if( !$result = mysqli_query($conn, $query) ) {
            mysqli_error($conn);

        }else {
            $rows = mysqli_num_rows($result);

            // means the student aleady registered 
            if($rows >= 1){
                
                echo "<script>
                    swal({
                        title: 'Error',
                        text: 'Found exam with same code',
                        type: 'error',     
                    });
                    </script>";
                
            }else {
                // add the exam to the database
                
                $examinerID = $_SESSION['examiner']['id'];
                
                $table = "exam";
                $query = "INSERT INTO $table (e_name, e_code, examiner_id) VALUES ('$exam_name', '$exam_code', '$examinerID')";

                $added = false;
                if( !$result = mysqli_query($conn, $query) ){
                    die(mysqli_error($conn));
                }else{
                    $added = true;
                }

                if($added){
                    echo "<script>        
                            swal({title: 'Correct', text: 'The \' $exam_name \' exam has been added successfully', type: 'success', showConfirmButton: false, timer: 1500}); 
                        
                            // redirect to edit exam page to add questions to the exam
                            
                            setTimeout(function(){
                                window.location = 'allExams.php';
                            }, 1500)
                             
                        </script>";
                    
                }else {
                    echo "<script> 
                        swal({title: 'Error', text: '!! Incorrect username or password', type: 'error'}); 
                    </script>";
                }
            }
        }
    }
?>


<div class="container" id="my_container_header">
    <h2>Add New Exam</h2>
    <p>Enter a name and a code to add new exam</p>
</div>    

<div class="container" >
    <div class="row">
        <div class="col">
                
            <div id="my_container">
                <form id="addExam_form" method="post" action="addExam.php" autocomplete="off">
                     <div class="input-group my_input_group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Exam Name : </span>
                        </div>
                        <input id="examName" name="examName" type="text" class="form-control"/>
                    </div>
                    
                    <div class="input-group my_input_group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Exam Code : </span>
                        </div>
                        <input id="examCode" name="examCode" type="text" class="form-control"/>
                    </div>

                    <!-- <span><a href="#" id="createBtn" class="btn btn-primary">Create Exam</a></span> -->
                    <input id="createExamBtn" type="submit" name="createExamBtn" class="btn btn-primary myBtn" value="Create Exam">
                    <span><a href="examinerMainPage.php"  class="btn btn-secondary myBtn">Back</a></span>

                </form>
            </div>
   
        </div>
    </div>
</div>

<?php require_once "globals/global_footer.php" ?>

 <script src="./js/addExam.js"></script> 

</body>
</html>
