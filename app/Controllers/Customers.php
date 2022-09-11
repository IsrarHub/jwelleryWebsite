<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CustomerModel;

class Customers extends BaseController
{
    private $dbs;
    private $customers;
    public function __construct()
    {
        $this->dbs = db_connect();
        $this->customers=new CustomerModel($this->dbs);

        helper(['form', 'url']);
    }
    public function index()
    {
        //
        $data['pageTitle']="Customers";
        echo view('views/customers',$data);
    }
    public function saveCustomer(){
        if ($this->request->isAJAX()) {
            $session=session();
            $validation =  \Config\Services::validation();
          $this->validate([
                  'cusname'=>[
                    'rules'=>'required',
                    'error'=>[
                      'required'=>'Customer Name is empty'
                    ]
                    ],
                    'phno'=>[
                      'rules'=>'required',
                      'error'=>[
                        'required'=>'Phone number is empty'
                      ]
                      ],
                      'address'=>[
                        'rules'=>'required',
                        'error'=>[
                          'required'=>'Address is empty'
                        ]
                        ]
                           ]);
          if ($validation->run()==false) {
              $error=$validation->getErrors();
              echo json_encode(['code'=>0,'error'=>$error]);
          }
          else{

            $data=['name'=>$this->request->getPost('cusname'),'phonenumber'=>$this->request->getPost('phno'),
            'address'=>$this->request->getPost('address'),
                 ];  
              $query=$this->customers->saveCustomer($data);
              if ($query) {
                  echo json_encode(['code'=>1, 'msg'=>'Customer has been added']);
              } else {
                  echo json_encode(['code'=>0,'msg'=>'Failed to save ']);
              }
          } 
        }
    }
    public function getAllCustomers(){
        if ($this->request->isAJAX()) {
            $data=$this->customers->getAllCustomers();
            $token = csrf_hash();
            $result=array();
            
            $button='';
            if(!empty($data)){
            foreach ($data as $key=>$value) {
                $button='<a  class="text-success mx-2" onclick="editCustomer('.$value['id'].')" href="#"  ><i class="fas fa-pen"></i></a>';
                $button.='<a  class="text-danger" onclick="deleteCustomer('.$value['id'].')" href="#"  ><i class="fas fa-trash"></i></a>';
                
                $view='<a href="'.base_url().'/Customers/viewCustomer/'.$value['id'].'"><i class="fas fa-eye"></i></a>';
                $result['data'][]=array(
                  $button,
                  $view,
        $value['name'],
        $value['phonenumber'],
        $value['address'],
        
        
      );
            }
          }
          else{
            $result['data'][]=array(
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

    public function viewCustomer($id){

    }
    public function getCustomer(){

          $token=$this->request->getPost('csrfName'); 
        $id=$this->request->getPost('id');
        $query=$this->customers->getCustomer($id);
        
        echo json_encode($query);
    }
    public function editCustomer(){
      if ($this->request->isAJAX()) {
        $session=session();
        $validation =  \Config\Services::validation();
      $this->validate([
              'editcusname'=>[
                'rules'=>'required',
                'error'=>[
                  'required'=>'Customer Name is empty'
                ]
                ],
                'editphno'=>[
                  'rules'=>'required',
                  'error'=>[
                    'required'=>'Phone number is empty'
                  ]
                  ],
                  'editaddress'=>[
                    'rules'=>'required',
                    'error'=>[
                      'required'=>'Address is empty'
                    ]
                    ]
                       ]);
      if ($validation->run()==false) {
          $error=$validation->getErrors();
          echo json_encode(['code'=>0,'error'=>$error]);
      }
      else{
      $id=$this->request->getPost('editid');
        $data=['name'=>$this->request->getPost('editcusname'),'phonenumber'=>$this->request->getPost('editphno'),
        'address'=>$this->request->getPost('editaddress'),
             ];  
          $query=$this->customers->updateCustomer($data,$id);
          if ($query) {
              echo json_encode(['code'=>1, 'msg'=>'Customer has been updated']);
          } else {
              echo json_encode(['code'=>0,'msg'=>'Failed to update ']);
          }
      } 
    }
  }

  public function deleteCustomer(){
    if ($this->request->isAJAX()) {
          $id=$this->request->getPost('id');
          $query=$this->customers->deleteCustomer($id);
          if ($query) {
            echo json_encode(['code'=>1, 'msg'=>'Customer has been Deleted']);
        } else {
            echo json_encode(['code'=>0,'msg'=>'Failed to delete ']);
        }
    }
  }
}
