<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class AdministradorController extends BaseController
{
    public function index()
    {
        $data['datatables'] = true;
        return view('administrador/list',$data);
    }
}
