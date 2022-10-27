//add Employee in the Database
$("#add_employee_form").submit(function(e){
  e.preventDefault();
 const fd=new FormData(this);
 $("#add_employee_btn").text('Adding...');
 $.ajax({
   url:'/store',
   method:'post',
   data:fd,
   cache: false,
   contentType:false,
   processData:false,
   dataType:'json',
   success: function(response){
    
     if(response.status==200){
      swal.fire(
        'Added!',
        'Employee Added successfully!',
        'success'
      )
      fetchAllEmployees();
     }
     $("#add_employee_btn").text('Add Employee');
     $("#add_employee_form")[0].reset();
     $("#addEmployeeModal").modal('hide');
   }

 });
   });
   // delete employee ajax request
   $(document).on('click', '.deleteIcon', function(e) {
    e.preventDefault();
    let id = $(this).attr('id');
    var csrf = $("meta[name='csrf-token']").attr("content");
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '/delete',
          method: 'delete',
          data: {
            id: id,
            _token: csrf
          },
          success: function(response) {
            console.log(response);
            Swal.fire(
              'Deleted!',
              'Your file has been deleted.',
              'success'
            )
            fetchAllEmployees();
          }
        });
      }
    })
  });

   fetchAllEmployees();
	// handle fetch all eamployees ajax request
 function fetchAllEmployees() {
  $.ajax({
    url:'/fetchall',
    method: 'get',
    success: function(response) {
      $("#show_all_employees").html(response);
      $("table").DataTable({
        order: [0, 'desc']
      });
     
    }
  });
}

// click on edit button so show all data in the form
$(document).on('click','.editIcon',function(e){
e.preventDefault();
let id =$(this).attr('id');
$.ajax({
  url:'/edit',
  method:'get',
  data:{
    id:id,
    _token:'{{csrf_token}}'
  },
  success:function(response){
    //console.log(response);
    $('#fname').val(response.first_name);
    $('#lname').val(response.last_name);
    $('#email').val(response.email);
    $('#phone').val(response.phone);
    $('#post').val(response.post);
    $("#avatar").html(
      `<img src="storage/imges/${response.avatar}" width="100" class="img-fluid img-thumbnail">`);
    $("#emp_id").val(response.id);
    $("#emp_avatar").val(response.avatar);
  }
});
});

//update Employee in the Database
$("#edit_employee_form").submit(function(e){
  e.preventDefault();
 const fd=new FormData(this);
 $("#edit_employee_btn").text('Updating...');
 $.ajax({
   url:'/Update',
   method:'post',
   data:fd,
   cache: false,
   contentType:false,
   processData:false,
   dataType:'json',
   success: function(response){
    
     if(response.status==200){
      swal.fire(
        'Update!',
        'Employee Updated successfully!',
        'success'
      )
      fetchAllEmployees();
     }
     $("#edit_employee_btn").text('Update Employee');
     $("#edit_employee_form")[0].reset();
     $("#editEmployeeModal").modal('hide');
   }

 });
   });

  


 