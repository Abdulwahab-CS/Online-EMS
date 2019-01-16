$(document).ready(function(){

    $("#logOut").click(function() {

        
        Swal({
            title: 'Log out',
            text: "Do you want to log out ? ",
            type: 'info',
            showCancelButton: true,
            confirmButtonColor: '#05668D',
            cancelButtonColor: '#F26868',
            confirmButtonText: 'Yes'
          }).then((result) => {
            if (result.value) {
              
                swal({
                    title: 'OK',
                    text: 'logged out',
                    type: 'success', 
                    showConfirmButton: false, 
                    timer: 1000
                });
        
                setTimeout(() => {
                     window.location = "index.php?studentLogout=1";
                }, 1000);

            }
          })

         

    });
   
});