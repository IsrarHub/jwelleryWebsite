<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class CustomerModel extends Model
{
    public $db;
    public function __construct(ConnectionInterface &$db)
    {
      $this->db=$db;
    }
    public function saveCustomer($data){
        return $this->db->table('customers')->insert($data);
    }
    public function getAllCustomers(){
      
      return $this->db->table('customers')->select('id,name,phonenumber,address')->get()->getResultArray();
    }
    public function getCustomer($id){

      return $this->db->table('customers')->select('id,name,phonenumber,address')->where('id',$id)->get()->getRowArray();
    }
    public function updateCustomer($data,$id){
      
      return $this->db->table('customers')->where('id',$id)->update($data);
    }
    public function deleteCustomer($id){
      return $this->db->table('customers')->where('id',$id)->delete();
    }
}
