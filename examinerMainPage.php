<?php
  session_start();

  if(!isset($_SESSION['examiner']['id'])){
      die("<h1>! You can't be able to access this page</h1>");
  }

  $pageName = "Examinar Main Page";

  require_once "globals/global.php";

?>

  <link rel="stylesheet" href="./css/examinerMainPage.css"> 
  
</head>
  
<body>

<?php require_once "globals/Examinar_header.php" ?>


<div class="container">
  <div class="row">
    <div class="col">

      <div class="mycontainer">
    
        <h2 class="greatingStatment">Welcome <b> <?php if(isset($_SESSION['examiner']['name'])) echo $_SESSION['examiner']['name'] ?> </b> , in Examinar Dashboard</h2><hr>
        <div>
          <p><a href="addExam.php" class="btn my_btn">Add Exam</a></p>
          <p><a href="editExamNameOrCode.php" class="btn my_btn">Update Exam</a></p>
          <p><a href="allExams.php" class="btn my_btn">Manage Exams</a></p>
          <p><a href="studentsScores.php" class="btn my_btn">Students Scores</a></p>
        </div>

      </div>

    </div>
  </div>
</div>  

<?php require_once "globals/global_footer.php" ?>

</body>
</html>