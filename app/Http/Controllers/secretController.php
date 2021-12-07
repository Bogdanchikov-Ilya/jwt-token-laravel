<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class secretController extends Controller
{
    public function index()
    {
        return ['text' => 'secretTextForCheckJwtToken'];
    }
}
