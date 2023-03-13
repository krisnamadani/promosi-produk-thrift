<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data['admins'] = Admin::all()->count();
        $data['products'] = Product::all()->count();
        
        return view('dashboard', $data);
    }
}
