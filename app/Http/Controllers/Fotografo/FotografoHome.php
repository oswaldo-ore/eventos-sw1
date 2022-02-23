<?php

namespace App\Http\Controllers\Fotografo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FotografoHome extends Controller
{
    public function index()
    {
        return view('fotografo.home');
    }
}
