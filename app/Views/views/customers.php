<?= $this->extend('views/index') ?>

<?= $this->section('content') ?>
script


<main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4"></h1>
                        
                        
                        <div class="card mb-4">
                            <div class="card-body">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#saveCustomers">
                            Add Customer
                            </button>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header"> 
                                Customers
                            </div>
                            <div class="card-body">
                            
                                <table id="customers" class="table display nowrap" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>Action</th>
                                            <th>View</th>
                                            <th>Customer Name</th>
                                            <th>Phone Number</th>
                                            <th>Address</th>
                                            
                                            
                                        </tr>
                                    </thead>          
                                </table>
                            
                            </div>
                        </div>
                    </div>
                </main>

                <div class="modal fade" id="saveCustomers" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Customer</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?=form_open('','id="savecus", autocomplete="on"')?>
      <div class="modal-body">
          <div class="row">  
              <div class="col-6">
              <div class="mb-3">
              <input type="hidden" class="txt_csrfname" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
     <label for="cusname" class="form-label">Customer Name</label>
     <input type="text"  class="form-control" name='cusname' id="cusname" placeholder="Customer Name" required >
     <span class="text-danger error-text cusname_error"></span>
       </div>
              </div>
              
              
              
              <div class="col-6">
              <div class="mb-3">
     <label for="phno" class="form-label">Phone Number</label>
     <input type="number"  class="form-control" name='phno' id="phno" placeholder="Phone Number" required >
     <span class="text-danger error-text phno_error"></span>
       </div>
              </div>

              <div class="col-12">
              <div class="mb-3">
     <label for="address" class="form-label">Customer Address</label>
   <textarea name="address" id="address" cols="25" rows="5" placeholder="Customer Address" class="form-control"></textarea>
     <span class="text-danger error-text address_error"></span>
       </div>
              </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary" name="save" value="Save">
      </div>
      </div>
      <?=form_close()?>
    </div>
  </div>
</div>


<!-- edit  Modal -->
<div class="modal fade" id="editCustomer" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Customer</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?=form_open('','id="editcus", autocomplete="off"')?>
      <div class="modal-body">
      <div class="col-6">
              <div class="mb-3">
              <input type="hidden" class="txt_csrfname" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
     <label for="editcusname" class="form-label">Customer Name</label>
     <input type="text"  class="form-control" name='editcusname' id="editcusname" required >
     <input type="hidden"  class="form-control" name='editid' id="editid" required >
     <span class="text-danger error-text editcusname_error"></span>
       </div>
              </div>
               
              <div class="col-6">
              <div class="mb-3">
     <label for="editphno" class="form-label">Phone Number</label>
     <input type="number"  class="form-control" name='editphno' id="editphno" required >
     <span class="text-danger error-text editphno_error"></span>
       </div>
              </div>

              <div class="col-12">
              <div class="mb-3">
     <label for="editaddress" class="form-label">Customer Address</label>
   <textarea name="editaddress" id="editaddress" cols="25" rows="5"  class="form-control"></textarea>
     <span class="text-danger error-text editaddress_error"></span>
       </div>
              </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-success" name="update" value="Update">
      </div>
      <?=form_close()?>
    </div>
  </div>
</div>

<?= $this->endsection()?>      


<?= $this->section('script') ?>


<script>

$(document).ready(function() {
     // Setup - add a text input to each footer cell
     $('#customers thead tr')
       .appendTo('#customers thead');
     var table = $('#customers').DataTable({
       "orderCellsTop": true,
       "scrollY":300,
       "scrollX":true,
       "pageLength" : 10,
       "lengthMenu":  [5,10,20,50] ,
       "ajax": {
           url : "<?=base_url('Customers/getAllCustomers')?>",
           type : 'GET'
       },
      
       initComplete: function() {
         var api = this.api();
         // For each column
         api
           .columns()
           .eq(0)
           .each(function(colIdx) {
             // Set the header cell to contain the input element
             var cell = $('.filters th').eq(
               $(api.column(colIdx).header()).index()
             );
             var title = $(cell).text();
             $(cell).html('<input type="text" placeholder="' + title + '" />');

             // On every keypress in this input
             $(
                 'input',
                 $('.filters th').eq($(api.column(colIdx).header()).index())
               )
               .off('keyup change')
               .on('keyup change', function(e) {
                 e.stopPropagation();

                 // Get the search value
                 $(this).attr('title', $(this).val());
                 var regexr = '({search})'; //$(this).parents('th').find('select').val();

                 var cursorPosition = this.selectionStart;
                 // Search the column for that value
                 api
                   .column(colIdx)
                   .search(
                     this.value != '' ?
                     regexr.replace('{search}', '(((' + this.value + ')))') :
                     '',
                     this.value != '',
                     this.value == ''
                   )
                   .draw();
                 $(this)
                   .focus()[0]
                   .setSelectionRange(cursorPosition, cursorPosition);
               });
           });
       },
     });
     $('input.filter').on('change', function() {
   table.draw();
 });


  });



  $("#savecus").submit(function(e) {
      e.preventDefault();
       var form=this;
      $.ajax({
        url: "<?php echo base_url('Customers/saveCustomer') ?>",
        method: "POST",
                        data: new FormData(this),
                        processData: false,
                        contentType: false,
                        cache: false,
                        dataType: "json",
                        beforeSend:function(){
          $(form).find('span.error_text').text('');
        },
        success: function(data) {
     
            if($.isEmptyObject(data.error)){
                if(data.code ==1){
                   $(form)[0].reset();
                    $('#saveCustomers').modal('hide');
                 $('#customers').DataTable().ajax.reload(null,false);
                    Swal.fire(
                        'Saved!',
                        'Customer has been saved!',
                        'success'
                    )
                }
                else{
                    Swal.fire(
                        'Error!',
                        'Error to Save!',
                        'error'
                    )
                }
            }
            else{
                $.each(data.error, function(prefix,val){
                  Swal.fire(
                        'Error!',
                        val,
                        'error'
                    )
                });
            }
        
        },
        error: function() {
          Swal.fire(
                        'Error!',
                        'Something went wrong',
                        'error'
                    )
        }
      });
    });

   
    function editCustomer(id){
        var csrfName = '<?= csrf_token() ?>';
    var csrfHash = '<?= csrf_hash() ?>';  

    $.ajax({
        url: "<?= base_url('Customers/getCustomer') ?>",
        method:'post',
        data: {
          id: id,
          [csrfName]:csrfHash

         },
        dataType: 'Json',
        async: false,
        success: function(response) {
      
            $('#editid').val(response.id);
           $('#editcusname').val(response.name);
           $('#editphno').val(response.phonenumber);
           $('#editaddress').val(response.address);    
            $('#editCustomer').modal('show');
          
          
        }
      });
   }

   $('#editcus').submit(function(e){
   e.preventDefault();
   var form=this;
   $.ajax({
    url:'<?=base_url('Customers/editCustomer')?>',
    method:'post',
    data:new FormData(form),
    processData:false,
    dataType:'json',
    contentType:false,
    beforeSend:function(){
      $(form).find('span.error_text').text('');
    },
    success:function(data){
     if($.isEmptyObject(data.error)){
        if(data.code==1){
          $('#editCustomer').modal('hide');
          $('#customers').DataTable().ajax.reload(null,false);
          Swal.fire(
                        'Updated!',
                        'Customer has been Updated!',
                        'success'
                    )
        }
        else{
          Swal.fire(
                        'Error!',
                        'Failed to update!',
                        'error'
                    )
        }
     }
     else{
      $.each(data.error,function(prefix,val){
        
        Swal.fire(
                        'Error!',
                        val,
                        'error'
                    )
      }); 
     }
    }
   });  
   });

   function deleteCustomer(id){
    var csrfName = '<?= csrf_token() ?>';
    var csrfHash = '<?= csrf_hash() ?>';  

  Swal.fire({
  title: 'Are you sure?',
  text: "You really want to delete!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#d33',
  cancelButtonColor: '#3085d6',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
  if (result.isConfirmed) {
    $.ajax({
      url: "<?=base_url('Customers/deleteCustomer')?>",
      method: "Post",
      data: {
        id: id,
        [csrfName]:csrfHash
      },
      dataType: 'Json',
      success: function(response) {
        
        if (response.code == 1) {
          $('#customers').DataTable().ajax.reload();
          Swal.fire(
            'Deleted!',
            'The Customer has been deleted.',
            'success'
          )
        } else {
          
          Swal.fire(
                        'Error!',
                        'Error',
                        'error'
                    )
        }
      }
    });
  }
});

  }


  </script>

<?= $this->endsection()?>  