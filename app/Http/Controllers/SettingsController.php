<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Type;
use Illuminate\Support\Facades\Auth; // Add this line


class SettingsController extends Controller
{
    
    public function index()
    {
        $user = Auth::id();
       

        return view('settings.change_password.index');
    }
    public function edit_company_profile()
    {
        $user = Auth::id();
       

        return view('settings.company_profile.index');
    }
   
}
