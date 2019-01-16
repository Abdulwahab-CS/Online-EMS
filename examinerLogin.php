<?php
  session_start();

  $pageName = "Examiner Login Page";

  require_once "globals/global.php";

  require_once "Models/db_connection.php";
?>

  <link rel="stylesheet" href="css/examinerLogin.css"> 
  
</head>

<body>
    
<?php // match the examiner

    // ----------------------------> examiner password
    // $username  = 'Admin_Abdulwahab';
    // $pass = '12345';
    // $hash = hash('sha3-512', $pass);
    // echo 'examiner password hash is = ' . $hash. '<br>';

    if( isset($_POST['loginBtn']) ){ 

        $table = 'examiner';
        $id = mysqli_real_escape_string($conn, $_POST['examiner_password']);
        $enterdUsername = mysqli_real_escape_string($conn, $_POST['examiner_username']);

        $hashedID = hash('sha3-512', $id);

        $query = "SELECT examiner_id, full_name, username FROM $table WHERE examiner_id = '$hashedID'";
        
        $found = false;
        
        if( !$result = mysqli_query($conn, $query) ) {
            die("<h1>!! Error happend while excute the query - in Examiner login page</h1>");
        
        }else {
            $rowcount = mysqli_num_rows($result);
            
            if($rowcount == 1){
                
                // know check the user name, must be one row
                $row = mysqli_fetch_row($result);

                $name = $row[1];
                $username = $row[2];

                if($username == $enterdUsername){
                    $found = true;
                }

            }
        }

        
        if($found){
            
            $_SESSION['examiner']['id'] = $row[0];
            $_SESSION['examiner']['name'] = $row[1];

            echo "<script> 
                    // Greating
                    swal({title: 'Correct', text: 'Welcome, $name', type: 'success', showConfirmButton: false}); 

                    // Redirecting
                    setTimeout( function() {
            
                        //redirect to examiner main page
                        window.location = 'examinerMainPage.php';
                    }, 1000);
                </script>";

                    
        }else {
            echo "<script> 
                swal({title: 'Error', text: '!! Invalid Username or Password', type: 'error'}); 
            </script>";
        }
    }
?>

    <div class="container">
        <div class="row"> 
            <div class="col">

                <div class="card card-body my_outer-border">
                    <h3 class="header">Examiner Login Form</h3>

                    <div class="card card-body my_inner_border">        
                        <form id="examiner_login_form" method="post" action="examinerLogin.php" autocomplete="off">
                            <div class="input-group my_input_group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Username : </span>
                                </div>
                                <input id="examiner_username" name="examiner_username" type="text" class="form-control"/>
                            </div>
                            <div class="input-group my_input_group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">National ID : </span>
                                </div>
                                <input id="examiner_password" name="examiner_password" type="text" class="form-control"/>
                            </div>

                            <!-- <span><a href="#" class="btn" id="loginBtn" onclick="verifiy_form()">Login</a></span> -->
                            <input id="submit" name="loginBtn" type="submit"  class="btn btn-success" value="Login">
                            <span><a href="index.php" class="btn btn-secondary" id="backBtn">Back</a></span>

                        </form>

                        
                    </div>

                </div>

            </div>
        </div>
    </div>

    <?php require_once "globals/global_footer.php" ?>
    
    <script src="js/examinerLogin.js"></script> 
    
</body>
</html>