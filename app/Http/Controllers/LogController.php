<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log;


class LogController extends Controller
{
    public function index()
    {
        //latest admin logs
        $logs =  auth()->user()->logs()->latest()->get();
        return view('logs.index', compact('logs'));
    }
}
