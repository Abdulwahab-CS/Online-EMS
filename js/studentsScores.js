
$(".clearBtn").click(function(e){

    Swal({
        title: 'Are you sure ?',
        text: "!! Clear all students scores data",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#05668D',
        cancelButtonColor: '#F26868',
        confirmButtonText: 'Yes'
      }).then((result) => {
        if (result.value) {
          
            window.location = "studentsScores.php?clearAll=1";

        }
      })

});