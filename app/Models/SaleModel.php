<?php

namespace App\Models;

use CodeIgniter\Model;

use CodeIgniter\Database\ConnectionInterface;

class SaleModel extends Model
{
       
    public $db;
    public function __construct(ConnectionInterface &$db)
    {
      $this->db=$db;
    }
    public function getAllcustomers($search=null){
        if($search==null){

          return $this->db->table('customers')->select('id,name')->get()->getResultArray();
          
        }
        else{
          return  $this->db->table('customers')->select('id,name')
               ->like('name',$search)
               ->orderBy('name')->get()->getResultArray();
          }

    }
    public function getKaratValues(){
      return $this->db->table('goldrates')->select('*')->orderBy('id','DESC')->get(1)->getRowArray();
    }
    public function saveSales($data){
      $this->db->table('sales')->insert($data);
      return $this->db->insertID();
      // $db->insertID();
    }
    public function saveItems($data){
      return $this->db->table('items')->insert($data);
    }
    public function getSale($id){
      return $this->db->table('sales as s')->select('s.*,i.itemweight,i.stoneweight,i.waste,i.totalweight,i.makingcost,i.stoneprice,i.beadsprice,totalprice')->join('items as i','i.saleid=s.id')->where('s.id',$id)->get()->getRowArray();
    }
    public function getSales(){
      
      return $this->db->table('sales as s')->select('s.*,c.name')->join('customers as c','s.customerid=c.id')->get()->getResultArray();
    }
    public function udpdateItems($data1,$id){
      return $this->db->table('items')->where('saleid',$id)->update($data1);
    }
    public function udpdateSale($data,$id){
      
      return $this->db->table('sales')->where('id',$id)->update($data);
    }
    public function deleteSale($id){
      return $this->db->table('sales')->where('id',$id)->delete();
    }
    public function deleteSaleItems($id){
      return $this->db->table('items')->where('saleid',$id)->delete();
    }
    // public function getAllCustomers(){
      
    //     return $this->db->table('customers')->select('id,name')->get()->getResultArray();
    //   }
}
