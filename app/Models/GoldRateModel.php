<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class GoldRateModel extends Model
{
 
    public $db;
    public function __construct(ConnectionInterface &$db)
    {
      $this->db=$db;
    }
    public function saveGoldRate($data){
      return $this->db->table('goldrates')->insert($data);
    }
    public function getAllRates(){
        
      return $this->db->table('goldrates')->select('id,goldrate24k,goldrate22k,goldrate21k,goldrate18k')->get()->getResultArray();
    }
    public function getGoldrate($id){
        
      return $this->db->table('goldrates')->select('id,goldrate24k,goldrate22k,goldrate21k,goldrate18k')->where('id',$id)->get()->getRowArray();
    }
    public function updateGoldrate($data,$id){
        return $this->db->table('goldrates')->where('id',$id)->update($data);
    }
    public function deteleGoldrate($id){
        return $this->db->table('goldrates')->where('id',$id)->delete();
    }
}
