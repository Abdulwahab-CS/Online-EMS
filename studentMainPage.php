<?php 
  session_start();

  if(!isset($_SESSION['student']['id'])){
    die("<h1>! You can't be able to access this page</h1>");
  }

  $pageName = "Student Main Page";

  require_once "globals/global.php";

  require_once "Models/db_connection.php";

?>

 <link rel="stylesheet" href="./css/studentMainPage.css">

</head>

<body> 

<?php include ("globals/Student_header.php"); ?>

<?php 


  // print the student name besides the word 'Welcome'
  if(isset($_SESSION['student']['id'])){
    
    $fname = $_SESSION['student']['f_name'];
    $sname = $_SESSION['student']['s_name'];
    $lname = $_SESSION['student']['l_name'];
   
    echo "<script>
          $(document).ready(function () {
              $('#std_name').text('$fname' + ' $sname' + ' $lname');
          });  
    </script>";
  }

  // ----------------------------------- get all the exams
  $query = "SELECT * FROM exam";
    
  if( !$allExams = mysqli_query($conn, $query) ){
      die(mysqli_error($conn));

  }else{
      
      while($row = mysqli_fetch_row($allExams)){

          $examName = $row[0];
          $examCode = $row[1];

          echo "<script>
            $(document).ready(function() {
              var select = document.getElementById('exams_select_input');
              var opt = document.createElement('option');
              opt.value = '$examCode';
              opt.textContent = '$examName';
              select.appendChild(opt);
            });
          </script>";
      }

  }


?>

  <div class="container">
      <div class="row">
          <div class="col">

                <h2>Welcome : <span id="std_name">-</span></h2>
                
                <div class="card card-body">
                   
                  <div class="input-group my_input_group">
                    <div class="input-group-prepend">
                      <label class="input-group-text" id="inputGroup-sizing-lg" for="inputGroupSelect01">Choose Exam</label>
                    </div>
                    <select class="custom-select" id="exams_select_input">
                      <option selected disabled></option>
                    </select>
                  </div>
                  
                  <input id="submit" type="submit" name="createExamBtn" onclick="startExam()" class="btn btn-primary btn-lg startExamBtn" value="Start Exam">
              </div>
              
          </div>
      </div>
  </div>

  <?php require_once "globals/global_footer.php" ?>

  <script src="js/studentMainPage.js"></script> 
  
</body>
</html>