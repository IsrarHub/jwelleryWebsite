<?= $this->extend('views/index') ?>

<?= $this->section('content') ?>


<main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4"></h1>
                        
                        
                        <div class="card mb-4">
                        <?php 
                          if(session()->get('msg')!=""){
                          
                            $error=session()->get('msg');

                                  echo "<script>
                                  Swal.fire({
                                    icon: 'success',
                                    title: 'success',
                                    text: '$error'
                                  })
                          </script>";
                          }
                          
                          ?>

                            <div class="card-body">
                            <a href="<?= base_url('Sale/addSale')?>" class="btn btn-primary">
                            Make new Sale
                            </a>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header"> 
                                Sales
                            </div>
                            <div class="card-body">
                            
                                <table id="sales" class="table display nowrap" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>Action</th>
                                            <th>View</th>
                                            <th>Customer Name</th>
                                            <th>Sale Date</th>
                                            <th>Advance Gold</th>
                                            <th>Advance amount</th>
                                            <th>Gold Rate</th>
                                            <th>Gold Karat</th>
                                        </tr>
                                    </thead>
                                    
                                    <!--  -->

                                </table>
                            
                            </div>
                        </div>
                    </div>
                </main>

                <?= $this->endsection()?>      


<?= $this->section('script') ?>
               
                <script>



$(document).ready(function() {
     // Setup - add a text input to each footer cell
     $('#sales thead tr')
       .appendTo('#sales thead');
     var table = $('#sales').DataTable({
       "orderCellsTop": true,
       "scrollY":300,
       "scrollX":true,
       "pageLength" : 10,
       "lengthMenu":  [5,10,20,50] ,
       "ajax": {
           url : "<?=base_url('Sale/getAllSales')?>",
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



  
  function deleteSale(id){
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
      url: "<?=base_url('Sale/deleteSale')?>",
      method: "Post",
      data: {
        id: id,
        [csrfName]:csrfHash
      },
      dataType: 'Json',
      success: function(response) {
        
        if (response.code == 1) {
          $('#sales').DataTable().ajax.reload();
          Swal.fire(
            'Deleted!',
            'The Sale has been deleted.',
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