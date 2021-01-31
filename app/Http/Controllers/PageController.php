<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function customer()
    {
        $countries = Country::all();

        return view('customers', [
            'countries' => $countries
        ]);
    }

    public function car()
    {
        return view('cars');
    }
}
