<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Buyer extends Controller
{
    public function User()
    {
        return view('page.buyer');
    }

    public function UserOrder()
    {
        return view('page.order');
    }
}
