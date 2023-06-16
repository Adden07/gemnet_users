<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Administrator\AdminController;
use Illuminate\Support\Facades\DB;

class HomeController extends AdminController
{
    public function index()
    {  
 
        $data = array(
            "title" => "Dashboad",
        );
        return view('admin.home')->with($data);
    }
}
