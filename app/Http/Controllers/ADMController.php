<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Add this line
use App\Models\Supplier;
use App\Models\Agent;
use App\Models\Type;
use App\Models\Ticket;
use App\Models\Order;
use App\Models\Refund;
use Illuminate\View\View;
use DateTime;
use Illuminate\Support\Facades\DB;

class ADMController extends Controller
{
    public function view()
    {
        $user = Auth::id();
        $suppliers = Supplier::where([['is_delete',0],['is_active',1],['user',$user]])->get();
        $agents = Agent::where([['is_delete',0],['is_active',1],['user',$user]])->get();
        $types = Type::where([['is_delete',0],['is_active',1],['user',$user]])->get();
        $tickets = Ticket::where([['is_delete',0],['is_active',1],['user', $user]])->get();
        foreach($tickets as $order){
           
            $order->agent = Agent::where('id', $order->agent)->value('name');
            $order->supplier = Supplier::where('id', $order->supplier)->value('name');
        }
        // dd($orders);
        // dd($suppliers);
        return view('ticket.adm', compact('suppliers', 'agents', 'types', 'tickets'));
    }
    public function adm_entry(Request $request){
        $refund = new Refund();
        $refund->ticket_no = $request->ticket;
        $refund->date = $request->refund_date;
        $refund->agent = $request->agent;
        $refund->supplier = $request->supplier;
        $refund->prev_agent_amount = $request->agent_fare;
        $refund->prev_supply_amount = $request->supplier_fare;
        $refund->now_agent_fere = $request->agent_refundfare;
        $refund->now_supplier_fare = $request->supplier_refundfare;

        $agentRefundFare = $request->input('agent_refundfare');
        $supplierRefundFare = $request->input('supplier_refundfare');
        $profit = $agentRefundFare - $supplierRefundFare;

        $refund->refund_profit = $profit;


        $ticket = Ticket::where(['ticket_no' => $request->ticket])->first();

        if ($ticket) {
            $ticket->is_refund = 1;
            $ticket->refund_profit = $profit;
            $flag = $ticket->save();
        } else {
            // Ticket not found, handle accordingly (e.g., show an error message)
            $flag = false;
        }

       
        if($flag){
            return redirect()->route('ticket.adm')->with('success', 'Void Ticket Added successfully');
        }
        else{
            return redirect()->route('ticket.adm')->with('error', 'Adding Void Ticket failed');
        }
    } 
}