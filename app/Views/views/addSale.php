<?= $this->extend('views/index') ?>

<?= $this->section('content') ?>


<main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4"></h1>
                        <div class="card mb-4">
                          <?php 
                          if(session()->get('msg')!=""){
                          
                            $error=session()->get('msg');

                            foreach($error as $err){
                              
                                  echo "<script>
                                  Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: '$err'
                                  })
                          </script>";
                            }
                            
                          }
                          
                          ?>

                            <div class="card-body">
                            <h2 class="text-center text-muted fst-italic bg-warning text-wrap"> Add New Sell</h2>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-body">
                            <?=form_open('Sale/saveSale','id="savesal", autocomplete="on"')?>
                            <div class="row">
                                
              <div class="col-xlg-6 col-12">
              <div class="mb-3">
              <input type="hidden" name="txt_csrfname" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
     <label for="cus" class="form-label">Select Customer</label>
     
      <select name="cus" id="cus" class="form-control" required >
        <option value="">select Customer</option>
        <?php 
        foreach($customer as $customers){
          ?>
          <option value="<?=$customers['id']?>"><?= $customers['name']?></option>
        <?php } ?>
      
      </select> 
    </div>
              </div>  
              <div class="col-6">
              <div class="mb-3">
              <label for="itemweight" class="form-label">Item Weight</label>
              <input type="number" class="form-control" name="itemweight" id="itemweight" step="any" placeholder="Item Weight" required  />
    </div>
              </div> 
              <div class="col-6">
              <div class="mb-3">
              <label for="StoneWeight" class="form-label">Stone Weight</label>
              <input type="number" class="form-control" name="StoneWeight" id="StoneWeight" step="any" placeholder="Stone Weight" required  />
    </div>
              </div> 
              <div class="col-6">
              <div class="mb-3">
              <label for="waste" class="form-label">Waste</label>
              <input type="number" class="form-control" name="waste" id="waste" step="any" placeholder="waste" required />
    </div>
              </div> 
              
              <div class="col-6">
              <div class="mb-3">
              <label for="makingcost" class="form-label">Making Cost</label>
              <input type="number" class="form-control" name="makingcost" id="makingcost"  placeholder="Making Cost"  required />
    </div>
              </div> 
              <div class="col-6">
              <div class="mb-3">
              <label for="Totalweight" class="form-label">Total weight</label>
              <input type="number" class="form-control" name="Totalweight" id="Totalweight" step="any" placeholder="Total weight"  required />
    </div>
              </div> 
              
              
              <div class="col-6">
              <div class="mb-3">
              <label for="stonePrice" class="form-label">Stone Price</label>
              <input type="number" class="form-control" name="stonePrice" id="stonePrice"  placeholder="Stone Price" required  />
    </div>
              </div>
              <div class="col-6">
              <div class="mb-3">
              <label for="beadprice" class="form-label">Beads Price</label>
              <input type="number" class="form-control" name="beadprice" id="beadprice"  placeholder="Beads Price" required  />
    </div>
              </div> 
              <div class="col-6">
              <div class="mb-3">
              <label for="totalprice" class="form-label">Total Price</label>
              <input type="number" class="form-control" name="totalprice" id="totalprice"  placeholder="Total Price" required  />
    </div>
              </div> 
              <div class="col-6">
              <div class="mb-3">
              <label for="saleDate" class="form-label">Sale Date</label>
              <input type="date" class="form-control" name="saleDate" id="saleDate" required  />
    </div>
              </div> 
              <div class="col-6">
              <div class="mb-3">
              <label for="totalgold" class="form-label">Total gold</label>
              <input type="number" class="form-control" name="totalgold" id="totalgold" step='any' placeholder="Total gold" required  />
    </div>
              </div>
              <div class="col-6">
              <div class="mb-3">
              <label for="advancegold" class="form-label">Advance gold</label>
              <input type="number" class="form-control" name="advancegold" id="advancegold" step='any' placeholder="Advance gold" required  />
    </div>
              </div>
              <div class="col-6">
              <div class="mb-3">
              <label for="advanceAmount" class="form-label">Advance amount</label>
              <input type="number" class="form-control" name="advanceAmount" id="advanceAmount"  placeholder="Advance amount" required  />
    </div>
              </div> 
              <div class="col-6">
              <div class="mb-3">
              <label for="goldkarat" class="form-label">Gold karat</label>
            
              <select name="goldkarat" id="goldkarat" class="form-control" required >
        <option value="24k">24k</option>
        <option value="22k">22k</option>
        <option value="21k">21k</option>
        <option value="18k">18k</option>
      </select>
    </div>
              </div> 
              
              

        </div>
        <div class="col-md-12 text-center my-3">
        <input type="submit" class="btn btn-primary " name="save" value="Add Sale" >
        </div>
                      <?=form_close()?>          
                            </div>
                        </div>
                    </div>
                </main>


<?= $this->endsection()?>      


<?= $this->section('script') ?>

                <script>
$('#cus').select2();
$('#goldkarat').select2();

$(document).on('change','#makingcost,#stonePrice,#beadprice',function(){
let total=0;
let price1=$('#makingcost').val() ;

let price2 =$('#stonePrice').val();
let price3= $('#beadprice').val();

 total=Number(price1) + Number(price2) + Number(price3);
 $('#totalprice').val(total);


});
$(document).on('change','#itemweight,#StoneWeight,#waste',function(){
let total=0;
let price1=$('#itemweight').val() ;

let price2 =$('#StoneWeight').val();
let price3= $('#waste').val();

 total=Number(price1) + Number(price2) + Number(price3) *0.2;
 $('#Totalweight').val(total);


});

  </script>
<?= $this->endsection()?>      