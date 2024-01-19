<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function index(): string
    {
        $data['datatables'] = true;
        return view('dashboard/index', $data);
    }

    public function campanhas()
    {
        $data['datatables'] = true;
        return view('dashboard/campanhas', $data);
    }
}
