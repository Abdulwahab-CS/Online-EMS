$(document).ready(function() { 

    $('#registration_form').on('submit', function(e){
        
        if( isThereEmptyFields() ){
            swal({
                title: 'Error , Incomplete form',
                text: '! Please fill the missing fields',
                type: 'error'
            });

            return false;
        }
        if( !isValidName($("#f_name").val()) ) {
            swal({
                title: 'Error',
                text: '!! Invalid first name',
                type: 'error'
            });

            return false; 
        }
        if( !isValidName($("#s_name").val()) ) {
            swal({
                title: 'Error',
                text: '!! Invalid second name',
                type: 'error'
            });

            return false;
        }
        if( !isValidName($("#l_name").val()) ) {
            swal({
                title: 'Error',
                text: '!! Invalid last name',
                type: 'error'
            });

            return false;
        }
        if( !isValidEamil($("#email").val()) ) {
            swal({
                title: 'Error',
                text: '!! Invalid Email Format (xxx@xxx.xxx) ',
                type: 'error'
            });

            return false;
        }
        if( !isValidID($("#id").val()) ) {
            swal({
                title: 'Error',
                text: '!! Invalid ID format , must be ONLY NUMBERS',
                type: 'error'
            });

            return false;
        }
        if( !isValidNameLength($("#f_name").val()) ) {
            swal({
                title: 'Error',
                text: '!! Long first name ( must be less than 20 chars )',
                type: 'error'
            });

            return false; 
        }
        if( !isValidNameLength($("#s_name").val()) ) {
            swal({
                title: 'Error',
                text: '!! Long second name ( must be less than 20 chars )',
                type: 'error'
            });

            return false;
        }
        if( !isValidNameLength($("#l_name").val()) ) {
            swal({
                title: 'Error',
                text: '!! Long last name ( must be less than 20 chars )',
                type: 'error'
            });

            return false;
        }
        if( !isValidEamilLength($("#email").val()) ) {
            swal({
                title: 'Error',
                text: '!! Long email ( must be less than 40 chars )',
                type: 'error'
            });

            return false;
        }
        if( !isValidIDLength($("#id").val()) ) {
            swal({
                title: 'Error',
                text: '!! National ID must be 10 numbers',
                type: 'error'
            });

            return false;
        }

        

    });

});

function isThereEmptyFields(){
    if( $("#f_name").val() == '' ||  $("#s_name").val() == '' || $("#l_name").val() == '' || $("#email").val() == '' ||  $("#id").val() == '')
      return true;
    else
      return false;
}

function isValidName($name) {
    $pattern = /^[a-zA-Z]+$/;
    if($pattern.test($name)){
        return true;
    }else {
        return false;
    }
}

function isValidEamil($email){
    // my regx was :  /^[a-zA-Z_0-9|.|-]+[@][a-zA-Z]+[.][a-zA-Z| ]+$/
    $pattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))( |)$/;
    if($pattern.test($email)){
        return true;
    }else {
        return false;
    }
}

function isValidID($id){
    $pattern = /^[0-9]+$/;
    if($pattern.test($id)){
        return true;
    }else {
        return false;
    }
}

function isValidNameLength($name) {
    if($name.length <= 20)
        return true;
    else
        return false;
}

function isValidEamilLength($email){
    if($email.length <= 40)
        return true;
    else
        return false;
}

function isValidIDLength($id){
    if($id.length == 10)
        return true;
    else
        return false;
}



function register() {
    console.log("yes1");
        if(isCompleteInput() == true) {

            swal({
                type: 'success',
                title: 'You have Registred Successfuly',
                showConfirmButton: false,
                
                timer: 2000
            })

            clearInputFeilds();

        } else {
            swal({
                title: 'Uncomplete data',
                text: 'Please complete the form information !!',
                type: 'error'
            });
        }

}

function isCompleteInput() {

    var fName, sName, lName, email, id;
    fName = document.getElementById("f_name").value;
    sName = document.getElementById("s_name").value;
    lName = document.getElementById("l_name").value;
    email = document.getElementById("email").value;
    id = document.getElementById("id").value;

    if(fName == "" || sName == "" || lName == "" || email == "" || id == "")
      return false;
    else
      return true;
}

function clearInputFeilds() {

    document.getElementById("f_name").value = "";
    document.getElementById("s_name").value = "";
    document.getElementById("l_name").value = "";
    document.getElementById("email").value = "";
    document.getElementById("id").value = "";

}


function greating() {
    swal({
        title: 'Congratulations',
        text: 'You have been registered successfully',
        type: 'success'
    });
}
