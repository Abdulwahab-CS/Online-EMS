<?php
  session_start();
  $pageName = "Start Page"; 

  require_once "globals/global.php";
  
?>

  <link rel="stylesheet" href="./css/index.css">

</head>


<body>

<?php // Examiner or Student Logout

    // Examiner Logout
    if(isset($_GET['examinerLogout'])){
        if(isset($_SESSION['examiner'])){
            unset($_SESSION['examiner']);
        }
    }

    // Student Logout
    if(isset($_GET['studentLogout'])){
        if(isset($_SESSION['student'])){
            unset($_SESSION['student']);
        }
    }

?>

<div class="container">

    <div class="row">
        <div class="col">
            <h1 id="startPage_title">Examination Management System</h1>
        </div>  
    </div>    
    <br>
    <div class="row my_row">

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <a id="E_btn" href="examinerLogin.php"> 
                <div class="item">
                    <img class="img startPage_imgs" src="./imgs/examinar.jpg" alt="Examinar Image">  
                    <p class="startPage_descriptions">Examiner</p> 
                </div>
            </a>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <a id="S_btn" href="studentRegistrationForm.php">
                <div class="item">
                    <img class="img startPage_imgs" src="./imgs/student.jpg" alt="Student Image"> 
                    <p class="startPage_descriptions">Student</p>  
                </div>
            </a>
        </div>

    </div> 
                
</div> 


<?php require_once "globals/global_footer.php" ?>


</body>
</html>