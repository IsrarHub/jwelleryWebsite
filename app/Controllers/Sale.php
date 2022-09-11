<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SaleModel;
use CodeIgniter\Session\Session;

class Sale extends BaseController
{
    private $dbs;
    private $sales;
    public function __construct()
    {
        
        $this->dbs = db_connect();
        $this->sales=new SaleModel($this->dbs);

        helper(['form', 'url']);
    }
    public function index()
    {
        
        $data['pageTitle']="Sale";
        // $data['customer']=$this->sales->getAllcustomers();
        // $data['sale']=$this->sales->getSales();
        echo view('views/sale',$data);
    }
    public function addSale(){
        if(session()->get('email')!=""){
           return redirect()->to('Admin/login');
        }
        else{
            
            
        $data['pageTitle']="Add Sale";
        $data['customer']=$this->sales->getAllcustomers();
        echo view('views/addSale',$data);
        }
    }
    public function viewSale($id){

    }
    public function getAllSales(){

      if ($this->request->isAJAX()) {
        $data= $this->sales->getSales();;
        $result=array();
        
        $button='';
        if(!empty($data)){
        foreach ($data as $key=>$value) {
            $button='<a  class="text-success mx-2" href="'.base_url().'/Sale/editSale/'.$value['id'].'" ><i class="fas fa-pen"></i></a>';
            $button.='<a  class="text-danger" onclick="deleteSale('.$value['id'].')" href="#"  ><i class="fas fa-trash"></i></a>';
            
            $view='<a href="'.base_url().'/Sale/viewSale/'.$value['id'].'"><i class="fas fa-eye"></i></a>';
            $result['data'][]=array(
              $button,
              $view,
    $value['name'],
    $value['saledate'],
    $value['advancegold'],
    $value['advanceamount'],
    $value['goldrate'],
    $value['goldkarat']    
    
  );
        }
      }
      else{
        $result['data'][]=array(
          'No Data Found',
          'No Data Found',
          'No Data Found',
          'No Data Found',
          'No Data Found',
          'No Data Found',
          'No Data Found',
          'No Data Found'  
);
      }

        echo json_encode($result);
    }

    } 
    public function saveSale(){
        
        // if(session()->get('email')!=""){
        //     return redirect()->to('Admin/login');
        //  }
        //  else{
            $session=session();
            $validation =  \Config\Services::validation();
            $this->validate([
                    'cus'=>[
                      'rules'=>'required',
                      'error'=>[
                        'required'=>'Customer Name is empty'
                      ]
                      ],
                      'itemweight'=>[
                        'rules'=>'required',
                        'error'=>[
                          'required'=>'Item Weight is empty'
                        ]
                        ],
                        'StoneWeight'=>[
                          'rules'=>'required',
                          'error'=>[
                            'required'=>'Stone Weight is empty'
                          ]
                          ],
                          'waste'=>[
                            'rules'=>'required',
                            'error'=>[
                              'required'=>'Waste is empty'
                            ]
                            ]
                            ,
                        'Totalweight'=>[
                          'rules'=>'required',
                          'error'=>[
                            'required'=>'Total Weight is empty'
                          ]
                          ]
                          ,
                        'makingcost'=>[
                          'rules'=>'required',
                          'error'=>[
                            'required'=>'Making Cost is empty'
                          ]
                          ]
                          ,
                        'stonePrice'=>[
                          'rules'=>'required',
                          'error'=>[
                            'required'=>'Stone Price is empty'
                          ]
                          ]
                          ,
                        'beadprice'=>[
                          'rules'=>'required',
                          'error'=>[
                            'required'=>'Bead Price is empty'
                          ]
                          ],
                          'totalprice'=>[
                            'rules'=>'required',
                            'error'=>[
                              'required'=>'Total Price is empty'
                            ]
                            ],
                            'saleDate'=>[
                              'rules'=>'required',
                              'error'=>[
                                'required'=>'Date is empty'
                              ]
                              ],
                              'totalgold'=>[
                                'rules'=>'required',
                                'error'=>[
                                  'required'=>'Total Gold is empty'
                                ]
                                    ],
                                    'advancegold'=>[
                                    'rules'=>'required',
                                    'error'=>[
                                        'required'=>'Advence gold is empty'
                                    ]
                                    ]
                                    ,
                                    'advanceAmount'=>[
                                    'rules'=>'required',
                                    'error'=>[
                                        'required'=>'Advence Amount is empty'
                                    ]
                                    ]
                                    ,
                                    'goldkarat'=>[
                                    'rules'=>'required',
                                    'error'=>[
                                        'required'=>'gold Karat is empty'
                                    ]
                                    ]
                             ]);
            if ($validation->run()==false) {
                $error=$validation->getErrors();
                $session->setFlashdata('msg',$error);
                return redirect()->to('/addSale');
            }
            else{
               
               $getKaratValues=$this->sales->getKaratValues();
               $karat=$this->request->getPost('goldkarat');
               if($karat=='24k'){
                $goldrate=$getKaratValues['goldrate24k'];
                $karatvalue=$getKaratValues['goldrate24k']/11.664;
               }
               else if($karat=='22k'){
                
                $goldrate=$getKaratValues['goldrate22k'];
                $karatvalue=$getKaratValues['goldrate22k']/11.664;
               }
               else if($karat=='21k'){
                
                $goldrate=$getKaratValues['goldrate21k'];
                $karatvalue=$getKaratValues['goldrate21k']/11.664;
               }
               if($karat=='18k'){
                
                $goldrate=$getKaratValues['goldrate18k'];
                $karatvalue=$getKaratValues['goldrate18k']/11.664;
               }


               $totalweight=$this->request->getPost('Totalweight');
               $totalmaking=$this->request->getPost('makingcost');
               $totalbeats=$this->request->getPost('beadprice');
               $totalstone=$this->request->getPost('stonePrice');
               $bill= ($totalweight * $karatvalue) + $totalmaking + $totalbeats + $totalstone;
               round($bill);
              // Bill will be total weight in grams x rate per gram + total making + total beats & stones price.
            // Total weight is the sum of weight and waste of all items included in the sale.
            // Rate per gram will be rate from the rates table ÷ 11.664.
            // This will be selected at the time of new entry in the sales table.
            // User will select the karat of gold
            // Script will pick up the rate of that karat from gold rate tablle. Divide by 11.664 and use it as rate per gram.


               $data=['customerid'=>$this->request->getPost('cus'),'saledate'=>$this->request->getPost('saleDate'),'bill'=>$bill,'totalgold'=>$this->request->getPost('totalgold'),'advancegold'=>$this->request->getPost('advancegold'),'advanceamount'=>$this->request->getPost('advanceAmount'),'goldkarat'=>$this->request->getPost('goldkarat'),'goldrate'=>$goldrate];
                 
               $insertId=$this->sales->saveSales($data);
             
               $data1=['saleid'=>$insertId,'itemweight'=>$this->request->getPost('itemweight'),'stoneweight'=>$this->request->getPost('StoneWeight'),'waste'=>$this->request->getPost('waste')*0.2,'totalweight'=>$totalweight,'makingcost'=>$totalmaking,'stoneprice'=>$totalstone,'beadsprice'=>$totalbeats,'totalprice'=>$this->request->getPost('totalprice')];
               $query=$this->sales->saveItems($data1);
               if($query){
                $session->setFlashdata('msg','Sale has been added');
                return redirect()->to('/sale');
               }
               else{
                $session->setFlashdata('msg','Failed to add Sale');
                return redirect()->to('/addSale');
               }
            }
               

        //  }
    }
    public function editSale($id){
      
      $query=$this->sales->getSale($id);
      $data['pageTitle']="Edit Sale";
      $data['customer']=$this->sales->getAllcustomers();
      $data['data']=$query;
      echo view('views/editSale',$data);
    }

    public function updateSale(){
       
      // if(session()->get('email')!=""){
      //     return redirect()->to('Admin/login');
      //  }
      //  else{
          $session=session();
          $validation = \Config\Services::validation();
          $this->validate([
                  'cus'=>[
                    'rules'=>'required',
                    'error'=>[
                      'required'=>'Customer Name is empty'
                    ]
                    ],
                    'itemweight'=>[
                      'rules'=>'required',
                      'error'=>[
                        'required'=>'Item Weight is empty'
                      ]
                      ],
                      'StoneWeight'=>[
                        'rules'=>'required',
                        'error'=>[
                          'required'=>'Stone Weight is empty'
                        ]
                        ],
                        'waste'=>[
                          'rules'=>'required',
                          'error'=>[
                            'required'=>'Waste is empty'
                          ]
                          ]
                          ,
                      'Totalweight'=>[
                        'rules'=>'required',
                        'error'=>[
                          'required'=>'Total Weight is empty'
                        ]
                        ]
                        ,
                      'makingcost'=>[
                        'rules'=>'required',
                        'error'=>[
                          'required'=>'Making Cost is empty'
                        ]
                        ]
                        ,
                      'stonePrice'=>[
                        'rules'=>'required',
                        'error'=>[
                          'required'=>'Stone Price is empty'
                        ]
                        ]
                        ,
                      'beadprice'=>[
                        'rules'=>'required',
                        'error'=>[
                          'required'=>'Bead Price is empty'
                        ]
                        ],
                        'totalprice'=>[
                          'rules'=>'required',
                          'error'=>[
                            'required'=>'Total Price is empty'
                          ]
                          ],
                          'saleDate'=>[
                            'rules'=>'required',
                            'error'=>[
                              'required'=>'Date is empty'
                            ]
                            ],
                            'totalgold'=>[
                              'rules'=>'required',
                              'error'=>[
                                'required'=>'Total Gold is empty'
                              ]
                                  ],
                                  'advancegold'=>[
                                  'rules'=>'required',
                                  'error'=>[
                                      'required'=>'Advence gold is empty'
                                  ]
                                  ]
                                  ,
                                  'advanceAmount'=>[
                                  'rules'=>'required',
                                  'error'=>[
                                      'required'=>'Advence Amount is empty'
                                  ]
                                  ]
                                  ,
                                  'goldkarat'=>[
                                  'rules'=>'required',
                                  'error'=>[
                                      'required'=>'gold Karat is empty'
                                  ]
                                  ]
                           ]);
          if ($validation->run()==false) {
              $error=$validation->getErrors();
              $session->setFlashdata('msg',$error);
              return redirect()->to(base_url('Sale/editSale').'/'.$this->request->getPost('id'));
          }
          else{
             
             $getKaratValues=$this->sales->getKaratValues();
             $karat=$this->request->getPost('goldkarat');
             if($karat=='24k'){
              $goldrate=$getKaratValues['goldrate24k'];
              $karatvalue=$getKaratValues['goldrate24k']/11.664;
             }
             else if($karat=='22k'){
              
              $goldrate=$getKaratValues['goldrate22k'];
              $karatvalue=$getKaratValues['goldrate22k']/11.664;
             }
             else if($karat=='21k'){
              
              $goldrate=$getKaratValues['goldrate21k'];
              $karatvalue=$getKaratValues['goldrate21k']/11.664;
             }
             if($karat=='18k'){
              
              $goldrate=$getKaratValues['goldrate18k'];
              $karatvalue=$getKaratValues['goldrate18k']/11.664;
             }


             $totalweight=$this->request->getPost('Totalweight');
             $totalmaking=$this->request->getPost('makingcost');
             $totalbeats=$this->request->getPost('beadprice');
             $totalstone=$this->request->getPost('stonePrice');
             $bill= ($totalweight * $karatvalue) + $totalmaking + $totalbeats + $totalstone;
             round($bill);
            // Bill will be total weight in grams x rate per gram + total making + total beats & stones price.
          // Total weight is the sum of weight and waste of all items included in the sale.
          // Rate per gram will be rate from the rates table ÷ 11.664.
          // This will be selected at the time of new entry in the sales table.
          // User will select the karat of gold
          // Script will pick up the rate of that karat from gold rate tablle. Divide by 11.664 and use it as rate per gram.

            $id=$this->request->getPost('id');
             $data=['customerid'=>$this->request->getPost('cus'),'saledate'=>$this->request->getPost('saleDate'),'bill'=>$bill,'totalgold'=>$this->request->getPost('totalgold'),'advancegold'=>$this->request->getPost('advancegold'),'advanceamount'=>$this->request->getPost('advanceAmount'),'goldkarat'=>$this->request->getPost('goldkarat'),'goldrate'=>$goldrate];
               
             $insertId=$this->sales->udpdateSale($data,$id);
           
             $data1=['itemweight'=>$this->request->getPost('itemweight'),'stoneweight'=>$this->request->getPost('StoneWeight'),'waste'=>$this->request->getPost('waste')*0.2,'totalweight'=>$totalweight,'makingcost'=>$totalmaking,'stoneprice'=>$totalstone,'beadsprice'=>$totalbeats,'totalprice'=>$this->request->getPost('totalprice')];
             $query=$this->sales->udpdateItems($data1,$id);
             if($query){
              $session->setFlashdata('msg','Sale has been updated');
              return redirect()->to('/sale');
             }
             else{
              $session->setFlashdata('msg','Failed to update Sale');
              return redirect()->to(base_url('Sale/editSale').'/'.$id);
             }
          }
             

      //  }
  }
  public function deleteSale(){
    if($this->request->isAJAX()){
      $id=$this->request->getPost('id');


      $query=$this->sales->deleteSale($id);
      $query=$this->sales->deleteSaleItems($id);
      if($query){

        echo json_encode(['code'=>1, 'msg'=>'Sale has been Deleted']);
      } else {
          echo json_encode(['code'=>0,'msg'=>'Failed to delete ']);
      }
    }
  }
}
