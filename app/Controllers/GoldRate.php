<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GoldRateModel;

class GoldRate extends BaseController
{
    private $dbs;
    private $goldrate;
    public function __construct()
    {
        $this->dbs = db_connect();
        $this->goldrate=new GoldRateModel($this->dbs);

        helper(['form', 'url']);
    }
    public function index()
    {     
        $data['pageTitle']="Gold Rates";
        echo view('views/goldrates',$data);
    }
    public function getAllGoldRates(){
        if ($this->request->isAJAX()) {
            $data=$this->goldrate->getAllRates();
            $token = csrf_hash();
            $result=array();
            
            $button='';
            if(!empty($data)){
            foreach ($data as $key=>$value) {
                $button='<a  class="text-success mx-2" onclick="editGoldRate('.$value['id'].')" href="#"  ><i class="fas fa-pen"></i></a>';
                $button.='<a  class="text-danger" onclick="deleteGoldRate('.$value['id'].')" href="#"  ><i class="fas fa-trash"></i></a>';
                
                $result['data'][]=array(
                  $button,
        $value['goldrate24k'],
        $value['goldrate22k'],
        $value['goldrate21k'],
        $value['goldrate18k']
        
        
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
              'No Data Found'
                
  );
          }

            echo json_encode($result);
        }

    }
    public function savegoldRate(){
        if ($this->request->isAJAX()) {
            $validation =  \Config\Services::validation();
            $this->validate([
                    '24k'=>[
                      'rules'=>'required',
                      'error'=>[
                        'required'=>'24k Gold rate is empty'
                      ]
                      ],
                      '22k'=>[
                        'rules'=>'required',
                        'error'=>[
                          'required'=>'22k Gold Rate is empty'
                        ]
                        ],
                        '21k'=>[
                          'rules'=>'required',
                          'error'=>[
                            'required'=>'21k is Gold Rate is empty'
                          ]
                          ],
                          '18k'=>[
                            'rules'=>'required',
                            'error'=>[
                              'required'=>'18k is Gold Rate is empty'
                            ]
                            ]
                             ]);
            if ($validation->run()==false) {
                $error=$validation->getErrors();
                echo json_encode(['code'=>0,'error'=>$error]);
            }
            else{

            $data=['goldrate24k'=>$this->request->getPost('24k'),'goldrate22k'=>$this->request->getPost('22k'),'goldrate21k'=>$this->request->getPost('21k'),'goldrate18k'=>$this->request->getPost('18k')];

            $query=$this->goldrate->saveGoldRate($data);
            if($query){
                echo json_encode(['code'=>1, 'msg'=>'Gold Rate has been added']);
              } else {
                  echo json_encode(['code'=>0,'msg'=>'Failed to save ']);
              }
            }
        }
    }
    public function getGoldRate(){
        if($this->request->isAJAX()){
            $id=$this->request->getPost('id');
            $query=$this->goldrate->getGoldRate($id);
            echo json_encode($query);
        }
    }
    public function editGoldRate(){
        if ($this->request->isAJAX()) {
            $validation =  \Config\Services::validation();
            $this->validate([
                    'edit24k'=>[
                      'rules'=>'required',
                      'error'=>[
                        'required'=>'24k Gold rate is empty'
                      ]
                      ],
                      'edit22k'=>[
                        'rules'=>'required',
                        'error'=>[
                          'required'=>'22k Gold Rate is empty'
                        ]
                        ],
                        'edit21k'=>[
                          'rules'=>'required',
                          'error'=>[
                            'required'=>'21k is Gold Rate is empty'
                          ]
                          ],
                          'edit18k'=>[
                            'rules'=>'required',
                            'error'=>[
                              'required'=>'18k is Gold Rate is empty'
                            ]
                            ]
                             ]);
            if ($validation->run()==false) {
                $error=$validation->getErrors();
                echo json_encode(['code'=>0,'error'=>$error]);
            }
            else{
               $id=$this->request->getPost('editid');
            $data=['goldrate24k'=>$this->request->getPost('edit24k'),'goldrate22k'=>$this->request->getPost('edit22k'),'goldrate21k'=>$this->request->getPost('edit21k'),'goldrate18k'=>$this->request->getPost('edit18k')];

            $query=$this->goldrate->updateGoldrate($data,$id);
            if($query){
                echo json_encode(['code'=>1, 'msg'=>'Gold Rate has been Updated']);
              } else {
                  echo json_encode(['code'=>0,'msg'=>'Failed to update ']);
              }
            }
        }
    }
    public function deleteGoldRate(){
        if ($this->request->isAJAX()) {
         $id=$this->request->getPost('id');
         $query=$this->goldrate->deteleGoldrate($id);
         if($query){
            echo json_encode(['code'=>1, 'msg'=>'Gold Rate has been Deleted']);
          } else {
              echo json_encode(['code'=>0,'msg'=>'Failed to Delete ']);
          }
        }
        }
    
}
