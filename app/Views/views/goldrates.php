<?= $this->extend('views/index') ?>

<?= $this->section('content') ?>


<main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4"></h1>
                        
                        
                        <div class="card mb-4">
                            <div class="card-body">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#saveGoldrate">
                            Add Gold Rate
                            </button>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header"> 
                                Gold Rates
                            </div>
                            <div class="card-body">
                            
                                <table id="goldRates" class="table display nowrap" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>Action</th>
                                            <th>Rate 24k</th>
                                            <th>Rate 22k</th>
                                            <th>Rate 21k</th>
                                            <th>Rate 18k</th>
                                            
                                            
                                        </tr>
                                    </thead>          
                                </table>
                            
                            </div>
                        </div>
                    </div>
                </main>

                <div class="modal fade" id="saveGoldrate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Customer</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?=form_open('','id="saveGold", autocomplete="on"')?>
      <div class="modal-body">
          <div class="row">  
              <div class="col-6">
              <div class="mb-3">
              <input type="hidden" class="txt_csrfname" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
     <label for="24k" class="form-label">24k Gold Rate</label>
     <input type="number"  class="form-control" name='24k' id="24k" placeholder="24k Gold Rate" required >
     <span class="text-danger error-text 24k_error"></span>
       </div>
              </div>
              <div class="col-6">
              <div class="mb-3">
     <label for="22k" class="form-label">22k Gold Rate</label>
     <input type="number"  class="form-control" name='22k' id="22k" placeholder="22k Gold Rate" required >
     <span class="text-danger error-text 22k_error"></span>
       </div>
              </div>
              <div class="col-6">
              <div class="mb-3">
     <label for="21k" class="form-label">21k Gold Rate</label>
     <input type="number"  class="form-control" name='21k' id="21k" placeholder="21k Gold Rate" required >
     <span class="text-danger error-text 21k_error"></span>
       </div>
              </div>
              
              
              
              <div class="col-6">
              <div class="mb-3">
     <label for="18k" class="form-label">18k Gold Rate</label>
     <input type="number"  class="form-control" name='18k' id="18k" placeholder="18k Gold Rate" required >
     <span class="text-danger error-text 18k_error"></span>
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
<div class="modal fade" id="editgoldrate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Customer</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?=form_open('','id="editgold", autocomplete="off"')?>
      <div class="modal-body">
      <div class="row">  
              <div class="col-6">
              <div class="mb-3">
              <input type="hidden" class="txt_csrfname" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
     <label for="edit24k" class="form-label">24k Gold Rate</label>
     <input type="number"  class="form-control" name='edit24k' id="edit24k"  required >
     <input type="hidden"  class="form-control" name='editid' id="editid"  required >
     <span class="text-danger error-text edit24k_error"></span>
       </div>
              </div>
              <div class="col-6">
              <div class="mb-3">
     <label for="edit22k" class="form-label">22k Gold Rate</label>
     <input type="number"  class="form-control" name='edit22k' id="edit22k" required >
     <span class="text-danger error-text edit22k_error"></span>
       </div>
              </div>
              <div class="col-6">
              <div class="mb-3">
     <label for="edit21k" class="form-label">21k Gold Rate</label>
     <input type="number"  class="form-control" name='edit21k' id="edit21k" required >
     <span class="text-danger error-text edit21k_error"></span>
       </div>
              </div>
              
              
              
              <div class="col-6">
              <div class="mb-3">
     <label for="edit18k" class="form-label">18k Gold Rate</label>
     <input type="number"  class="form-control" name='edit18k' id="edit18k"  required >
     <span class="text-danger error-text edit18k_error"></span>
       </div>
              </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-success" name="update" value="Update">
      </div>
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
     $('#goldRates thead tr')
       .appendTo('#goldRates thead');
     var table = $('#goldRates').DataTable({
       "orderCellsTop": true,
       "scrollY":300,
       "scrollX":true,
       "pageLength" : 10,
       "lengthMenu":  [5,10,20,50] ,
       "ajax": {
           url : "<?=base_url('Goldrate/getAllGoldRates')?>",
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



  $("#saveGold").submit(function(e) {
      e.preventDefault();
       var form=this;
      $.ajax({
        url: "<?php echo base_url('GoldRate/savegoldRate') ?>",
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
                    $('#saveGoldrate').modal('hide');
                 $('#goldRates').DataTable().ajax.reload(null,false);
                    Swal.fire(
                        'Saved!',
                        'Gold Rate has been saved!',
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

   
    function editGoldRate(id){
        var csrfName = '<?= csrf_token() ?>';
    var csrfHash = '<?= csrf_hash() ?>';  

    $.ajax({
        url: "<?= base_url('Goldrate/getGoldRate') ?>",
        method:'post',
        data: {
          id: id,
          [csrfName]:csrfHash

         },
        dataType: 'Json',
        async: false,
        success: function(response) {
      
            $('#editid').val(response.id);
           $('#edit24k').val(response.goldrate24k);
           $('#edit22k').val(response.goldrate22k);
           $('#edit21k').val(response.goldrate21k);
           $('#edit18k').val(response.goldrate18k);
           
          $('#editgoldrate').modal('show');    
            
          
          
        }
      });
   }

   $('#editgold').submit(function(e){
   e.preventDefault();
   var form=this;
   $.ajax({
    url:'<?=base_url('GoldRate/editGoldRate')?>',
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
          $('#editgoldrate').modal('hide');
          $('#goldRates').DataTable().ajax.reload(null,false);
          Swal.fire(
                        'Updated!',
                        'Gold Rate has been Updated!',
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

   function deleteGoldRate(id){
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
      url: "<?=base_url('GoldRate/deleteGoldRate')?>",
      method: "Post",
      data: {
        id: id,
        [csrfName]:csrfHash
      },
      dataType: 'Json',
      success: function(response) {
       
        if (response.code == 1) {
          $('#goldRates').DataTable().ajax.reload();
          Swal.fire(
            'Deleted!',
            'The Gold Rate has been deleted.',
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