<?php
  session_start();
    
  $pageName = "Student Login Page";

  require_once "globals/global.php";
  
  require_once "Models/db_connection.php";
 
  // --------> for sending email

  // Import PHPMailer classes into the global namespace
  // These must be at the top of your script, not inside a function
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  //Load Composer's autoloader
  require 'sendEmail/vendor/autoload.php';
?>

    <link rel="stylesheet" href="./css/studentLogin.css">

</head>

<body>

<?php // match the student

    if( isset($_POST['submit']) ){
        
            $table = 'student';
            $id = mysqli_real_escape_string($conn, $_POST['id']);
            $enterdEmail = $_POST['email'];

            $hashedID = hash("sha3-512", $id);

            $query = "SELECT student_id, f_name, s_name, l_name, email FROM $table WHERE student_id = '$hashedID'";
            
            $found = false;
            
            if( !$result = mysqli_query($conn, $query) ) {
                die("<h1>!! Error happend while excute the query</h1>");
            
            }else {
                $rowcount = mysqli_num_rows($result);
                
                if($rowcount == 1){
                    
                    // check the email, if it's the same or not
                    $row = mysqli_fetch_array($result);
                    $student_id = mysqli_real_escape_string($conn, $row['student_id']);
                    $studentFname = mysqli_real_escape_string($conn, $row['f_name']);
                    $studentSname = mysqli_real_escape_string($conn, $row['s_name']);
                    $studentLname = mysqli_real_escape_string($conn, $row['l_name']);
                    $email = mysqli_real_escape_string($conn, $row['email']);

                    if($enterdEmail == $email){
                        $found = true;
                    }
                
                }
                    
            }

            if($found){

                // check if the student accout is activated or not
                $query = "SELECT activated FROM student WHERE student_id = '$student_id'";
                
                if( !$result = mysqli_query($conn, $query) ) {
                    die("<h1>!! Error happend while excute the query</h1>");
                
                }else {

                    $row = mysqli_fetch_row($result);
                    $isActivated = $row[0];
                }

                if($isActivated == 1){

                    // add the student info to the session
                    $_SESSION['student']['id']     = $student_id;
                    $_SESSION['student']['f_name'] = $studentFname;
                    $_SESSION['student']['s_name'] = $studentSname;
                    $_SESSION['student']['l_name'] = $studentLname;
                    $_SESSION['student']['email']  = $email;

                    // redirect to student main page
                    echo "<script>
                        swal({
                            type: 'success',
                            title: 'Correct',
                            showConfirmButton: false,
                            timer: 1000
                        });

                        setTimeout(function(){
                            window.location = 'studentMainPage.php?student_firstname=$studentFname';
                        }, 1000);
                        
                    </script>";
                        
                }else {

                    // ------> send a verification code to the email -- not working yet --
                    sendVerifEmail();
                    

                    // add the student info to the verification from in the hidden fields to use them later (while verification process)
                    echo "<script>
                    $(document).ready(function() {
                        $('#temp_student_id').val('$id');
                        $('#temp_f_name').val('$studentFname');
                        $('#temp_s_name').val('$studentSname');
                        $('#temp_l_name').val('$studentLname');
                        $('#temp_email').val('$email');   
                    });
                    </script>";


                    echo "<script>
                        $(document).ready(function() {
                            document.getElementById('email').value = '$enterdEmail';
                            document.getElementById('email').disabled = 'true';
                            document.getElementById('id').value = '$id';
                            document.getElementById('id').disabled = 'true';
                            document.getElementById('loginBtn').disabled = 'true';

                            document.getElementById('verification_modal').style.display = 'block';
                        });

                        swal({
                            type: 'success',
                            title: 'Verification Step',
                            text: 'Verification code has been sent to your email to activate your account, this step is required for just one time',
                            showConfirmButton: true, 
                        });

                    </script>";
                }


            }else {
                echo "<script> 
                    $(document).ready(function() { 
                        swal({title: 'Error', text: '!! Invalid Email OR ID', type: 'error'}); 

                        document.getElementById('email').value = '$enterdEmail';
                        document.getElementById('id').value = '$id';
                    });
                </script>";
                
            }


        }

        function sendVerifEmail(){

            // ----------------> 1- create temp verif code & save it into session
            $tempVerifCode = rand(10000, 100000);
            $_SESSION['student']['verif_code'] = $tempVerifCode; 

            // ---------------> 2- send the email

            $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
            try {
                //Server settings
                                                 
                $mail->isSMTP();                                      // Set mailer to use SMTP
                $mail->Host = 'smtp.gmail.com';                     // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                               // Enable SMTP authentication
                $mail->Username = 'ems.auto.msgs@gmail.com';                 // SMTP username
                $mail->Password = 'EM@12345';                           // SMTP password
                $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 587;                                    // TCP port to connect to

                //Recipients
                $mail->setFrom('ems.auto.msgs@gmail.com');
                $mail->addAddress($_POST['email']);                          // Add a recipient

                $body = "<h3>Examination Management System Authentication</h3>";
                $body .= "<p>Your verification code is : <strong>$tempVerifCode</strong></p>";

                //Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'EMS verification';
                $mail->Body    = $body;
                $mail->AltBody = strip_tags($body);                   // for the people who recive email without have html editor, will be show in plain text

                $mail->send();

            } catch (Exception $e) {
                //echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
            }

        }
   
?>


<?php // check the verification code

    if(isset($_POST['vCode'])){

        // to add the student to the session
        $student_id = $_POST['temp_student_id'];
        $f_name = $_POST['temp_f_name'];
        $s_name = $_POST['temp_s_name'];
        $l_name = $_POST['temp_l_name'];
        $email = $_POST['temp_email'];

        // fixes the enterd email and ID - while verification step
        echo "<script>
        $(document).ready(function(){
         
            document.getElementById('email').value = '$email';
            document.getElementById('email').disabled = 'true';
            document.getElementById('id').value = '$student_id';
            document.getElementById('id').disabled = 'true';

            document.getElementById('loginBtn').disabled = 'true';

            // fill the verification form hidden fileds
            document.getElementById('temp_student_id').value = '$student_id';
            document.getElementById('temp_f_name').value = '$f_name';
            document.getElementById('temp_s_name').value = '$s_name';
            document.getElementById('temp_l_name').value = '$l_name';
            document.getElementById('temp_email').value = '$email';

        });
        </script>";


        $inputCode = $_POST['vCode'];
        
        $theCode = $_SESSION['student']['verif_code'];

        if($inputCode == $theCode){

            // remove the verification code from the session
            if(isset($_SESSION['student']['verif_code'])){
                unset($_SESSION['student']['verif_code']);
            }

            // calc the hash of the student ID, (because it was not hashed -for better UX/UI issues- )
            $hashedID = hash('sha3-512', $student_id); 

            // add the student info to the session
            $_SESSION['student']['id']     = $hashedID;
            $_SESSION['student']['f_name'] = $f_name;
            $_SESSION['student']['s_name'] = $s_name;
            $_SESSION['student']['l_name'] = $l_name;
            $_SESSION['student']['email']  = $email;

            // activate the user account
            $query = "UPDATE student SET activated='1' WHERE student_id='$hashedID' ";
            if( !$result = mysqli_query($conn, $query) ){
                die(mysqli_error($conn));
            }
            
            echo "<script>
                swal({
                    type: 'success',
                    title: 'Correct Verification Vode',
                    showConfirmButton: false,
                    timer: 1500
                });

                // redirect to student main page
                setTimeout(function(){
                    window.location = 'studentMainPage.php?student_firstname=$f_name';
                }, 1500);
                
            </script>";
        } else {

            echo "<script>
                
                $(document).ready(function() {
                    document.getElementById('verification_modal').style.display = 'block';
                });
            
                swal({
                    type: 'error',
                    title: 'Wrong Verification Code',
                    text: 'please enter the correct verification code',
                    showConfirmButton: true
                });
            </script>";

        }

    }

?>

    <div class="container">
        <div class="row">
            <div class="col">

                <div class="card card-body out-border">
                    <h3 class="header">Student Login</h3>

                    <div class="card card-body my_inner_border"> 

                    <form id="login_form" name="login_form" method="post" action="studentLogin.php" autocomplete="off">
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


                        <input id="loginBtn" type="submit" name="submit" class="btn btn-success" value="Login">
                        <span><a href="studentRegistrationForm.php" class="btn btn-secondary" id="backBtn">Back</a></span>
                    </form>
                    
                    </div> 
                </div>


                <div id="verification_modal">
                    <h5 class="vHeaderText">Verification code has been sent to your email</h5>
                    <form class="verification_form" method="post" action="studentLogin.php" autocomplete="off">
                        <label class="vLabel" for="vCode">Enter Verification Code : 
                            <input type="text" id="vCode" name="vCode">
                        </label><br>
                         
                        <!-- to use them later while the verification step. -->
                        <!-- 
                            1st) the main goal is when the user entered the verification code successfully, I should add the student info to the session
                            2nd) for every time, the user entered wrong password, set the email and the ID to the login form and make them disabled. so that the user try agian enter the correct verif code
                        -->
                        <input type="hidden" id="temp_student_id" name="temp_student_id" value="">
                        <input type="hidden" id="temp_f_name" name="temp_f_name" value="">
                        <input type="hidden" id="temp_s_name" name="temp_s_name" value="">
                        <input type="hidden" id="temp_l_name" name="temp_l_name" value="">
                        <input type="hidden" id="temp_email" name="temp_email" value="">

                        <button id="enterVerifCodeBtn" class="btn btn-primary vBtn" type="submit">Enter</button>
                    </form>
                </div>

            </div> 
        </div>
    </div>
    
    <?php require_once "globals/global_footer.php" ?>
    
    <script src="./js/studentLogin.js"></script>
    
</body>
</html>
