<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    
    public function index()
    {
        //  for system maintenance and configuration.
        return view('admin.settings');
    }
}