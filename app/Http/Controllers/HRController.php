<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Add this line
use App\Models\Supplier;
use App\Models\Agent;
use App\Models\Deportee;
use App\Models\Type;
use App\Models\Ticket;
use App\Models\Order;
use App\Models\VoidTicket;
use Illuminate\View\View;
use DateTime;
use Illuminate\Support\Facades\DB;

class HRController extends Controller
{
    public function view(Request $request) {
        $user = Auth::id();
        
        return view('hr.paysalary', compact('user'));
    }
    public function stuff_view(Request $request) {
        $user = Auth::id();
        
        return view('hr.stuff_details', compact('user'));
    }
    

    
    


}