<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    function index() : View{
        $products = Product::where('status',1)->get();
        $userAdmin = User::where('role','admin')->get();
        $categories = Category::where('status',1)->get();

        return view('admin.dashboard.index',compact('products','userAdmin','categories'));
    }
}
