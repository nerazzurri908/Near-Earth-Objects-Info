<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DefaultController extends Controller
{
    public function __invoke()
    {
        return ['hello' => 'MacPaw Internship 2022!'];
    }
}
