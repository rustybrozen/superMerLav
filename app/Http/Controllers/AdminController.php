<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    //

    public function dashboard() {
        return view('admin.dashboard');
    }

    public function category() {
        return view('admin.category');
    }


    public function products() {
        return view('admin.products');
    }


    public function users() {
        return view('admin.users');
    }


    public function orders() {
        return view('admin.orders');
    }



}
