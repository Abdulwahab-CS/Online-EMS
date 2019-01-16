<?php

  $pageName = "Student Registration Page";

  require_once "globals/global.php";

  require_once "Models/db_connection.php";
?>

   <link rel="stylesheet" href="./css/studentRegistrationForm.css">

</head>

<body>
    
<?php // adding new student in the database

    $isSubmit = isset($_POST['submit']);
    if( $isSubmit ){

        $firstName  = mysqli_real_escape_string($conn, $_POST['f_name']);
        $secondName = mysqli_real_escape_string($conn, $_POST['s_name']);
        $lastName   = mysqli_real_escape_string($conn, $_POST['l_name']);
        $email      = mysqli_real_escape_string($conn, $_POST['email']);
        $id         = mysqli_real_escape_string($conn, $_POST['id']);
        
        // add the student registeration info to browser local storage, in case there is an error while registring, we can be able show the data again
        echo "<script>
            localStorage.setItem('firstName', '$firstName');
            localStorage.setItem('secondName', '$secondName');
            localStorage.setItem('lastName', '$lastName');
            localStorage.setItem('email', '$email');
            localStorage.setItem('id', '$id');
        </script>";


        $hashedID = hash("sha3-512", $id);

        // ---------------------------------------------------------- check if another student with same id or email 

        $query = "SELECT student_id FROM student WHERE student_id = '$hashedID'";
        $query2 = "SELECT email FROM student WHERE email = '$email'";
        $foundSameEmailOrID = false;

        if(!$result = mysqli_query($conn, $query2) ) {
            mysqli_error($conn);
        }else {
            
            $rows = mysqli_num_rows($result);

            if($rows >= 1){
                $foundSameEmailOrID = true;
                echo "<script>
                    swal({
                        title: 'Error',
                        text: '!! found student with same email',
                        type: 'error'
                    });
                </script>";
            }
        }

        if( !$result = mysqli_query($conn, $query) ) {
            mysqli_error($conn);
        }else {
            $rows = mysqli_num_rows($result);

            if($rows >= 1){
                $foundSameEmailOrID = true;
                echo "<script>
                    swal({
                    title: 'Error',
                    text: '!! found student with same id',
                    type: 'error'
                });
                </script>";
            }
        }

        // display the info again
        if($foundSameEmailOrID){
            echo "<script>
                $(document).ready(function() {
                    document.getElementById('f_name').value = localStorage.getItem('firstName');
                    document.getElementById('s_name').value = localStorage.getItem('secondName');
                    document.getElementById('l_name').value = localStorage.getItem('lastName');
                    document.getElementById('email').value = localStorage.getItem('email');
                    document.getElementById('id').value = localStorage.getItem('id');
                });
            </script>";
        }

        
        // add new student
        if(!$foundSameEmailOrID)
        {
            $query = "INSERT INTO student (student_id, f_name, s_name, l_name, email) VALUES ('$hashedID', '$firstName', '$secondName', '$lastName', '$email')";

            if( !$result = mysqli_query($conn, $query) ){
                die(mysqli_error($conn));
            }

            echo "<script>
                swal({
                    title: 'Congratulations, $firstName',
                    text: 'You have registered successfully',
                    type: 'success',
                    showConfirmButton: false
                });

                // redirect to login page

                setTimeout( function() {
                    window.location = 'studentLogin.php';
                }, 2000);

                // after adding the student correctly, delete the registered student data from the local storage
                localStorage.removeItem('firstName');
                localStorage.removeItem('secondName');
                localStorage.removeItem('lastName');
                localStorage.removeItem('email');
                localStorage.removeItem('id');

            </script>";

        }
    

    }
?>

    <div class="container">
        <div class="row">
            <div class="col">

                <div class="card card-body out-border">
                <h3 class="header">Student Registration</h3>
                    
                    <div class="card card-body my_inner_border"> 

                    <form id="registration_form" method="post" action="studentRegistrationForm.php" autocomplete="off">
                        <div class="input-group my_input_group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">First Name : </span>
                            </div>
                            <input id="f_name" name="f_name" type="text" class="form-control"/>
                            
                        </div>
                        <div class="input-group my_input_group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Second Name : </span>
                            </div>
                            <input id="s_name" name="s_name" type="text" class="form-control"/>
                        </div>
                        <div class="input-group my_input_group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Last Name : </span>
                            </div>
                            <input id="l_name" name="l_name" type="text" class="form-control"/>
                        </div>
                        <div class="input-group my_input_group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Email : </span>
                            </div>
                            <input id="email" name="email" type="text" class="form-control"/>
                        </div>
                        <div class="input-group my_input_group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">National ID : </span>
                            </div>
                            <input id="id" name="id" type="text" class="form-control"/>
                        </div>

                        <div class="haveAccount">have account ? <span><a href="studentLogin.php" class="btn btn-outline-primary">Login</a></span></div>

                        
                        <input type="submit" name="submit" class="btn btn-success" value="Register">
                        <span><a href="index.php" class="btn btn-secondary" id="backBtn">Back</a></span>
                    </form>
                    
                    </div> 
                </div>

            </div> 
        </div>
    </div>

    <?php require_once "globals/global_footer.php" ?>
    
    <script src="js/studentRegistrationForm.js"></script>

</body>
</html>