function deleteStudent(id) {
      const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          confirmButton: 'btn btn-success ms-1 hello1',
          cancelButton: 'btn btn-danger me-1'
        },
        buttonsStyling: false
      })
      
      swalWithBootstrapButtons.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete Student!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          swalWithBootstrapButtons.fire(
            'Deleted!',
            'Student has been deleted.',
            'success',
            setTimeout(function(){
                window.location.href = '/delete/' + id
            }, 1300)
          )
        } else if (
          result.dismiss === Swal.DismissReason.cancel
        ) {
          swalWithBootstrapButtons.fire(
            'Cancelled',
            'Student delete cancelled',
            'error'
          )
        }
      })
}


function close_alert() {
  {
    document.getElementById("my_alert").close()
  }
  setTimeout("close_alert()", 2000)
  }
  
  function close_alert2() {
  {
    document.getElementById("my_alert2").close()
  }
  setTimeout("close_alert()", 2000)
  }

