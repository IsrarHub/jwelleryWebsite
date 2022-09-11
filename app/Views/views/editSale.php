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
                            <h2 class="text-center text-muted fst-italic bg-warning text-wrap"> Update Sale</h2>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-body">
                            <?=form_open('Sale/updateSale','id="updateSale", autocomplete="on"')?>
                            <div class="row">
                                
              <div class="col-xlg-6 col-12">
              <div class="mb-3">
              <input type="hidden" name="txt_csrfname" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
              <input type="hidden" name="_method" value="PUT" />
     <label for="cus" class="form-label">Select Customer</label>
     <input type="hidden" name="id" id="id" value="<?= $data['id'] ?>">
      <select name="cus" id="cus" class="form-control" required >
        <option value="">select Customer</option>
        <?php 
        foreach($customer as $customers){
          ?>
          <option value="<?php echo $customers['id'] ?>" <?php if($data['customerid']== $customers['id']){
            echo "selected";
          } ?>  ><?= $customers['name']?></option>
        <?php } ?>
      
      </select> 
    </div>
              </div>  
              <div class="col-6">
              <div class="mb-3">
              <label for="itemweight" class="form-label">Item Weight</label>
              <input type="number" class="form-control" name="itemweight" id="itemweight" step="any" value="<?= $data['itemweight']?>" required  />
    </div>
              </div> 
              <div class="col-6">
              <div class="mb-3">
              <label for="StoneWeight" class="form-label">Stone Weight</label>
              <input type="number" class="form-control" name="StoneWeight" id="StoneWeight" step="any" value="<?= $data['stoneweight']?>" required  />
    </div>
              </div> 
              <div class="col-6">
              <div class="mb-3">
              <label for="waste" class="form-label">Waste</label>
              <input type="number" class="form-control" name="waste" id="waste" step="any" value="<?= ($data['waste'] /20) * 100?>" required />
    </div>
              </div> 
              
              <div class="col-6">
              <div class="mb-3">
              <label for="makingcost" class="form-label">Making Cost</label>
              <input type="number" class="form-control" name="makingcost" id="makingcost"  value="<?= $data['makingcost']?>"  required />
    </div>
              </div> 
              <div class="col-6">
              <div class="mb-3">
              <label for="Totalweight" class="form-label">Total weight</label>
              <input type="number" class="form-control" name="Totalweight" id="Totalweight" step="any" value="<?= $data['totalweight']?>"  required />
    </div>
              </div> 
              
              
              <div class="col-6">
              <div class="mb-3">
              <label for="stonePrice" class="form-label">Stone Price</label>
              <input type="number" class="form-control" name="stonePrice" id="stonePrice"  value="<?= $data['stoneprice']?>" required  />
    </div>
              </div>
              <div class="col-6">
              <div class="mb-3">
              <label for="beadprice" class="form-label">Beads Price</label>
              <input type="number" class="form-control" name="beadprice" id="beadprice"  value="<?= $data['beadsprice']?>" required  />
    </div>
              </div> 
              <div class="col-6">
              <div class="mb-3">
              <label for="totalprice" class="form-label">Total Price</label>
              <input type="number" class="form-control" name="totalprice" id="totalprice" value="<?= $data['totalprice']?>" required  />
    </div>
              </div> 
              <div class="col-6">
              <div class="mb-3">
              <label for="saleDate" class="form-label">Sale Date</label>
              <input type="date" class="form-control" name="saleDate" id="saleDate" value="<?= date('Y-m-d',strtotime($data['saledate']))?>" required  />
    </div>
              </div> 
              <div class="col-6">
              <div class="mb-3">
              <label for="totalgold" class="form-label">Total gold</label>
              <input type="number" class="form-control" name="totalgold" id="totalgold" step='any' value="<?= $data['totalgold']?>" required  />
    </div>
              </div>
              <div class="col-6">
              <div class="mb-3">
              <label for="advancegold" class="form-label">Advance gold</label>
              <input type="number" class="form-control" name="advancegold" id="advancegold" step='any' value="<?= $data['advancegold']?>" required  />
    </div>
              </div>
              <div class="col-6">
              <div class="mb-3">
              <label for="advanceAmount" class="form-label">Advance amount</label>
              <input type="number" class="form-control" name="advanceAmount" id="advanceAmount"  value="<?= $data['advanceamount']?>" required  />
    </div>
              </div> 
              <div class="col-6">
              <div class="mb-3">
              <label for="goldkarat" class="form-label">Gold karat</label>
            
              <select name="goldkarat" id="goldkarat" class="form-control" required >
        <option value="24k" <?php if($data['goldkarat']== "24k"){
            echo "selected";
          } ?>>24k</option>
        <option value="22k"<?php if($data['goldkarat']== "22k"){
            echo "selected";
          } ?>>22k</option>
        <option value="21k"<?php if($data['goldkarat']== "21k"){
            echo "selected";
          } ?>>21k</option>
        <option value="18k"<?php if($data['goldkarat']== "18k"){
            echo "selected";
          } ?>>18k</option>
      </select>
    </div>
              </div> 
        </div>
        <div class="col-md-12 text-center my-3">
        <input type="submit" class="btn btn-primary " name="update" value="update Sale" >
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