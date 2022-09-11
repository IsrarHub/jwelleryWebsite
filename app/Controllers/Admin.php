<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Admin extends BaseController
{
    public function index()
    {
        // $session=session();
        // if(!empty($session->get('name'))){
            $data['pageTitle']="Dashboard";    
            echo view('views/dashboard',$data);
        // }
        // else{
        //     echo view('views/login');
        // }
    }
    public function login(){
        $session=session();
        if(!empty($session->get('name'))){

            echo view('views/index');
        }
        else{
            echo view('views/login');
        }
    }
    public function logincheck(){
        
    }
}
