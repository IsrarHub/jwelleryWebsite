<?php

namespace App\Models;

use CodeIgniter\Model;

use CodeIgniter\Database\ConnectionInterface;

class ItemsModel extends Model
{
    public $db;
    public function __construct(ConnectionInterface &$db)
    {
      $this->db=$db;
    }
}
