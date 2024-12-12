<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Supplier;
use App\Models\Agent;
use App\Models\AIT;
use App\Models\Type;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Receiver;
use App\Models\Refund;
use App\Models\ReissueTicket;
use App\Models\Ticket;
use App\Models\Transaction;
use App\Models\VoidTicket;
use Illuminate\Support\Facades\Auth; // Add this line
use DateTime;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\View as ViewFacade;

class GeneralLedgerController extends Controller
{
    //

    public function general_ledger()
    {
        if(Auth::user()){
            $user = Auth::id();
            $suppliers = Supplier::where([['is_delete', 0], ['is_active', 1], ['user', $user]])->get();
            $agents = Agent::where([['is_delete', 0], ['is_active', 1], ['user', $user]])->get();
            return view('report.general_ledger.index', compact('agents', 'suppliers'));
            
        }
        else{
            return view('welcome');
        }
    }

    public function general_ledger_report(Request $request){
        if(Auth::user()){
            // dd($request->all());
            $agentSupplier = $request->input('agent_supplier'); // "agent"
            $agentSupplierId = $request->input('agent_supplier_id'); // "82"
            $startDate = $request->input('start_date'); // "12/05/2024"
            $endDate = $request->input('end_date'); // "12/19/2024"
        
            if ($startDate) {
                $startDate = Carbon::createFromFormat('m/d/Y', $startDate)->format('Y-m-d');
            } else {
                $startDate = null; // Set to null if not provided
            }
        
            if ($endDate) {
                $endDate = Carbon::createFromFormat('m/d/Y', $endDate)->format('Y-m-d');
            } else {
                $endDate = null; // Set to null if not provided
            }
            
            if($agentSupplier === 'agent'){
                  // Fetch the opening balance for the given agent from the Agent table
                $opening_balance = Agent::where('id', $agentSupplierId)->value('opening_balance');
                
                // Initialize balance variables
                $opening_balance_debit = 0;
                $opening_balance_credit = 0;
                $final_opening_balance = 0;
                
                if ($startDate != null) {
                    // dd("asdas");
                   // Sum up the relevant amounts until the start date

                   
                    // Query for tickets where the agent is the actual agent
                    $until_start_date_tickets_agent = Ticket::where('agent', $agentSupplierId)
                    ->where('is_delete', 0)
                    ->where('is_active', 1)
                    ->where('user', Auth::id())
                    ->where('date', '<', $startDate) // Use whereDate for date comparison
                    ->sum('agent_price');

                    // Query for tickets where the agent is acting as a supplier (based on 'who' field)
                    $until_start_date_tickets_supplier = Ticket::where('who', 'agent_' . $agentSupplierId)
                    ->where('is_delete', 0)
                    ->where('is_active', 1)
                    ->where('user', Auth::id())
                    ->whereDate('date', '<', $startDate) // Use whereDate for date comparison
                    ->sum('supplier_price');

                    // Query for orders where the agent is the actual agent
                    $until_start_date_orders_agent = Order::where('agent', $agentSupplierId)
                    ->where('is_delete', 0)
                    ->where('is_active', 1)
                    ->where('user', Auth::id())
                    ->whereDate('date', '<', $startDate) // Use whereDate for date comparison
                    ->sum('contact_amount');

                    // Query for orders where the agent is acting as a supplier (based on 'who' field)
                    $until_start_date_orders_supplier = Order::where('who', 'agent_' . $agentSupplierId)
                    ->where('is_delete', 0)
                    ->where('is_active', 1)
                    ->where('user', Auth::id())
                    ->whereDate('date', '<', $startDate) // Use whereDate for date comparison
                    ->sum('payable_amount');

                    // Payments: Subtract amount from the Payment table
                    $until_start_date_payments = Payment::where('receive_from', 'agent')
                    ->where('agent_supplier_id', $agentSupplierId)
                    ->where('user', Auth::id())
                    ->whereDate('date', '<', $startDate) // Use whereDate for date comparison
                    ->sum('amount');

                    // Receives: Subtract amount from the Receive table
                    $until_start_date_receives = Receiver::where('receive_from', 'agent')
                    ->where('agent_supplier_id', $agentSupplierId)
                    ->where('user', Auth::id())
                    ->whereDate('date', '<', $startDate) // Use whereDate for date comparison
                    ->sum('amount');

                    // Reissues: Add now_agent_fere from the ReissueTicket table
                    $until_start_date_reissues = ReissueTicket::where('agent', $agentSupplierId)
                    ->where('user', Auth::id())
                    ->whereDate('date', '<', $startDate) // Use whereDate for date comparison
                    ->sum('now_agent_fere');

                    // Refunds: Subtract now_agent_fere from the Refund table
                    $until_start_date_refunds = Refund::where('agent', $agentSupplierId)
                    ->where('user', Auth::id())
                    ->whereDate('date', '<', $startDate) // Use whereDate for date comparison
                    ->sum('now_agent_fere');

                    // Void Tickets: Add now_agent_fere from the VoidTicket table
                    $until_start_date_void_tickets = VoidTicket::where('agent', $agentSupplierId)
                    ->where('user', Auth::id())
                    ->whereDate('date', '<', $startDate) // Use whereDate for date comparison
                    ->sum('now_agent_fere');


                    // Calculate the opening balance up until the start date
                    $opening_balance_debit = $until_start_date_tickets_agent + $until_start_date_orders_agent + $until_start_date_reissues + $until_start_date_void_tickets + $until_start_date_payments;
                    $opening_balance_credit = $until_start_date_tickets_supplier + $until_start_date_receives + $until_start_date_refunds + $until_start_date_orders_supplier;

                    // Final opening balance calculation: debit balance minus credit balance
                    $final_opening_balance = $opening_balance + $opening_balance_debit - $opening_balance_credit;
                    // dd($until_start_date_tickets_agent);

                    // Now you have the final opening balance
                } else {
                    // If no start date is provided, the balance is simply the agent's opening balance
                    if(is_null($opening_balance)){
                        $final_opening_balance = 0;
                    }
                    else{
                        $final_opening_balance = $opening_balance;
                    }
                }

                // dd($final_opening_balance);
                // Agent-related data retrieval
                $tickets = DB::table('tickets')
                ->where(function ($query) use ($agentSupplierId) {
                    $query->where('agent', $agentSupplierId)
                        ->orWhere('who', "agent_{$agentSupplierId}");
                })
                ->where('is_delete', 0)
                ->where('is_active', 1)
                ->where('user', Auth::id());

                // Orders related to the agent
                $orders = DB::table('order')
                ->where(function ($query) use ($agentSupplierId) {
                    $query->where('agent', $agentSupplierId)
                        ->orWhere('who', "agent_{$agentSupplierId}");
                })
                ->where('is_delete', 0)
                ->where('is_active', 1)
                ->where('user', Auth::id());

                // Receives
                $receive = DB::table('receive')
                ->where('receive_from', 'agent')
                ->where('agent_supplier_id', $agentSupplierId)
                ->where('user', Auth::id());

                // Payments
                $payment = DB::table('payment')
                ->where('receive_from', 'agent')
                ->where('agent_supplier_id', $agentSupplierId)
                ->where('user', Auth::id());

                // Refunds
                $refund = DB::table('refund')
                ->where('agent', $agentSupplierId)
                ->where('user', Auth::id());

                // Void Tickets
                $void_ticket = DB::table('voidticket')
                ->where('user', Auth::id())
                ->where('agent', $agentSupplierId);

                // Reissues
                $reissue = DB::table('reissue')
                ->where('agent', $agentSupplierId)
                ->where('user', Auth::id());

                // Apply date filters if both start and end dates are provided
                if ($startDate && $endDate) {
                $tickets = $tickets->whereBetween('date', [$startDate, $endDate]);
                $orders = $orders->whereBetween('date', [$startDate, $endDate]);
                $receive = $receive->whereBetween('date', [$startDate, $endDate]);
                $payment = $payment->whereBetween('date', [$startDate, $endDate]);
                $refund = $refund->whereBetween('date', [$startDate, $endDate]);
                $void_ticket = $void_ticket->whereBetween('date', [$startDate, $endDate]);
                $reissue = $reissue->whereBetween('date', [$startDate, $endDate]);
                } elseif ($startDate) {
                // Apply filter if only start date is provided
                $tickets = $tickets->where('date', '>=', $startDate);
                $orders = $orders->where('date', '>=', $startDate);
                $receive = $receive->where('date', '>=', $startDate);
                $payment = $payment->where('date', '>=', $startDate);
                $refund = $refund->where('date', '>=', $startDate);
                $void_ticket = $void_ticket->where('date', '>=', $startDate);
                $reissue = $reissue->where('date', '>=', $startDate);
                } elseif ($endDate) {
                // Apply filter if only end date is provided
                $tickets = $tickets->where('date', '<=', $endDate);
                $orders = $orders->where('date', '<=', $endDate);
                $receive = $receive->where('date', '<=', $endDate);
                $payment = $payment->where('date', '<=', $endDate);
                $refund = $refund->where('date', '<=', $endDate);
                $void_ticket = $void_ticket->where('date', '<=', $endDate);
                $reissue = $reissue->where('date', '<=', $endDate);
                }

                // Use get() to fetch the data, and then apply map()
                $tickets = $tickets->get()->map(function ($item) {
                $item->table_name = 'tickets';  // Add a table_name property
                return $item;
                });

                $orders = $orders->get()->map(function ($item) {
                $item->table_name = 'order';  // Add a table_name property
                return $item;
                });

                $receive = $receive->get()->map(function ($item) {
                $item->table_name = 'receive';  // Add a table_name property
                return $item;
                });

                $payment = $payment->get()->map(function ($item) {
                $item->table_name = 'payment';  // Add a table_name property
                return $item;
                });

                $refund = $refund->get()->map(function ($item) {
                $item->table_name = 'refund';  // Add a table_name property
                return $item;
                });

                $void_ticket = $void_ticket->get()->map(function ($item) {
                $item->table_name = 'voidticket';  // Add a table_name property
                return $item;
                });

                $reissue = $reissue->get()->map(function ($item) {
                $item->table_name = 'reissue';  // Add a table_name property
                return $item;
                });

                // Merge all collections into one collection
                $mergedCollection = $tickets->merge($orders)
                            ->merge($receive)
                            ->merge($payment)
                            ->merge($refund)
                            ->merge($void_ticket)
                            ->merge($reissue);

                // Sort the merged collection by date
                $sortedCollection = $mergedCollection->sortBy('date')->values();

                $activeTransactionMethods = Transaction::where([['is_active', 1],['is_delete',0],['user', Auth::id()]])->pluck('name', 'id')->toArray();
                // dd($activeTransactionMethods);
                $debit = 0;
                $balance = $final_opening_balance;
                $credit = 0;
                $total_ticket = 0;
                $html = '';

                foreach ($sortedCollection as $index => $item) {
                    // dd($item);
                    if ($item->table_name == "tickets") {
                        $total_ticket++;
                        if (is_null($item->supplier) && $item->who === 'agent_' . $agentSupplierId) {
                                  // Handle logic specific to Ticket model
                                  $balance -= $item->supplier_price;
                                  $currentAmount = $balance >= 0 ? $balance . ' DR' : $balance . ' CR';
                                  $credit += $item->supplier_price;
                                  $ticket = Ticket::where([['user', Auth::id()], ['ticket_no', $item->ticket_no]])->first();
                                  if($item->reissued_new_ticket == 1){
                                      $html .= <<<HTML
                                          <tr>
                                              <td class="w-[10%]"> $item->invoice_date </td>
                                              <td class="w-[11%]"> $item->invoice </td>
                                              <td class="w-[15%]"> {$ticket->ticket_code}/{$item->ticket_no} </td>
                                              <td class="w-[28%] pr-3">
                                                  PAX NAME: <span class="font-semibold"> $item->passenger </span><br>
                                                  PNR:  $item->pnr ,  $item->sector <br>
                                                  FLIGHT DATE:  $item->flight_date <br>
                                                  $item->airline_code -  $item->airline_name <br>
                                                  Remarks:  $item->remark 
                                              </td>
                                              
                                              <td class="w-[12%] totaldebit"> </td>
                                              <td class="w-[12%] totalcredit"> $item->supplier_price</td>
                                              <td class="w-[12%] totaltotal"> $currentAmount </td>
                                          </tr>
                                      HTML;
                                  }
                                  else{
      
                                      
                                      $html .= <<<HTML
                                                                  <tr>
                                                                      <td class="w-[10%]"> $item->invoice_date </td>
                                                                      <td class="w-[11%]"> $item->invoice </td>
                                                                      <td class="w-[15%]"> {$item->ticket_no} </td>
                                                                      <td class="w-[28%] pr-3">
                                                                          PAX NAME: <span class="font-semibold"> $item->passenger </span><br>
                                                                          PNR:  $item->pnr ,  $item->sector <br>
                                                                          FLIGHT DATE:  $item->flight_date <br>
                                                                          $item->airline_code -  $item->airline_name <br>
                                                                          Remarks:  Reissue
                                                                      </td>
                                                                      
                                                                      <td class="w-[12%] totaldebit"></td>
                                                                      <td class="w-[12%] totalcredit">$item->supplier_price</td>
                                                                      <!-- <td class="w-[12%] text-center"> $item->previous_amount  Dr</td> -->
                                                                      <td class="w-[12%] totaltotal"> $currentAmount </td>
                                                                  </tr>
                                          HTML;
                                      }
                              
                        }
                        else{
                       
                            // Handle logic specific to Ticket model
                            $balance += $item->agent_price;
                            $currentAmount = $balance >= 0 ? $balance . ' DR' : $balance . ' CR';
                            $debit += $item->agent_price;
                            $ticket = Ticket::where([['user', Auth::id()], ['ticket_no', $item->ticket_no]])->first();
                            if($item->reissued_new_ticket == 1){
                                $html .= <<<HTML
                                    <tr>
                                        <td class="w-[10%]"> $item->invoice_date </td>
                                        <td class="w-[11%]"> $item->invoice </td>
                                        <td class="w-[15%]"> {$ticket->ticket_code}/{$item->ticket_no} </td>
                                        <td class="w-[28%] pr-3">
                                            PAX NAME: <span class="font-semibold"> $item->passenger </span><br>
                                            PNR:  $item->pnr ,  $item->sector <br>
                                            FLIGHT DATE:  $item->flight_date <br>
                                            $item->airline_code -  $item->airline_name <br>
                                            Remarks:  $item->remark 
                                        </td>
                                        
                                        <td class="w-[12%] totaldebit"> $item->agent_price </td>
                                        <td class="w-[12%] totalcredit"></td>
                                        <td class="w-[12%] totaltotal"> $currentAmount </td>
                                    </tr>
                                HTML;
                            }
                            else{
                                $html .= <<<HTML
                                                            <tr>
                                                                <td class="w-[10%]"> $item->invoice_date </td>
                                                                <td class="w-[11%]"> $item->invoice </td>
                                                                <td class="w-[15%]"> {$item->ticket_no} </td>
                                                                <td class="w-[28%] pr-3">
                                                                    PAX NAME: <span class="font-semibold"> $item->passenger </span><br>
                                                                    PNR:  $item->pnr ,  $item->sector <br>
                                                                    FLIGHT DATE:  $item->flight_date <br>
                                                                    $item->airline_code -  $item->airline_name <br>
                                                                    Remarks:  Reissue
                                                                </td>
                                                                
                                                                <td class="w-[12%] totaldebit"> $item->agent_price </td>
                                                                <td class="w-[12%] totalcredit"></td>
                                                                <td class="w-[12%] totaltotal"> $currentAmount </td>
                                                            </tr>
                                    HTML;
                                }
                        }
                       
                    } elseif ($item->table_name == "receive") {
                        // dd($item);
                        // $currentAmount = $item->current_amount >= 0 ? $item->current_amount . ' DR' : $item->current_amount . ' CR';
                        $balance -= $item->amount;
                        $currentAmount = $balance >= 0 ? $balance . ' DR' : $balance . ' CR';
                        $credit += $item->amount;
                        $id = $item->id ?? null; // Ensure $id is initialized
                        $methodDisplay = isset($activeTransactionMethods[$item->method]) 
                                        ? $activeTransactionMethods[$item->method] 
                                        : 'Deleted Method';
                        $html .= <<<HTML
                        <tr>
                            <td class="w-[10%]"> {$item->date} </td>
                            <td class="w-[11%]"> {$item->invoice} </td>
                            <td class="w-[15%]"> </td>
                            <td class="w-[28%]">
                                Remarks: {$item->remark} <br>
                               
                                <b>Received by {$methodDisplay}</b>
                            </td>
                            <td class="w-[12%] totaldebit"></td>
                            <td class="w-[12%] totalcredit">{$item->amount}</td>
                            <td class="w-[12%] totaltotal">{$currentAmount}</td>
                        </tr>
                        HTML;

                    } elseif ($item->table_name == "payment") {
                        // $currentAmount = $item->current_amount >= 0 ? $item->current_amount . ' DR' : $item->current_amount . ' CR';
    
                        $balance += $item->amount;
                        $currentAmount = $balance >= 0 ? $balance . ' DR' : $balance . ' CR';
                        $debit += $item->amount;
    
                        $html .= <<<HTML
                                                 <tr>
                                                    <td class="w-[10%]"> {$item->date} </td>
                                                    <td class="w-[11%]"> {$item->invoice} </td>
                                                    <td class="w-[15%]">  </td>
                                                    <td class="w-[28%]">
                                                        Remarks:  {$item->remark} <br>
                                                        <b>Payment by {$activeTransactionMethods[$item->method]}<b>
                                                    </td>
                                                    <td class="w-[12%] totaldebit">{$item->amount}</td>
                                                    <td class="w-[12%] totalcredit"></td>
                                                    <td class="w-[12%] totaltotal">{$currentAmount}</td>
                                                </tr>
                                                HTML;
                    } elseif ($item->table_name == "reissue") {
                        // $currentAmount = $item->now_agent_amount;
                        // $currentAmount = $currentAmount >= 0 ? $currentAmount . ' DR' : $currentAmount . ' CR';
    
                        $balance += $item->now_agent_fere;
                        $currentAmount = $balance >= 0 ? $balance . ' DR' : $balance . ' CR';
                        $debit += $item->now_agent_fere;
    
                        $agentname = Agent::where('id', $agentSupplierId)->value('name');
                        $ticket = Ticket::where([['user', Auth::id()], ['ticket_no', $item->ticket_no]])->first();
                        // dd($ticket);
                      
                        $html .= <<<HTML
                        <tr>
                            <td class="w-[10%]"> {$item->date} </td>
                            <td class="w-[11%]"> {$item->invoice} </td>
                            <td class="w-[15%]"> {$ticket->airline_code}/{$ticket->ticket_no} </td>
                        HTML;
                        
                        if ($ticket) {
                            $html .= <<<HTML
                            <td class="w-[28%]">
                                <b>Reissue</b> to Customer: $agentname,  
                                {$item->invoice}<br> Ticket No: {$ticket->airline_code}/{$ticket->ticket_no}, <br>
                                Sector: {$ticket->sector},<br> on {$item->date} <b> PAX Name: {$ticket->passenger}</b>
                            </td>
                        HTML;
                        } else {
                            $html .= '<td class="w-[28%]"></td>';
                        }
                        
                        $html .= <<<HTML
                            <td class="w-[12%] totaldebit">{$item->now_agent_fere}</td>
                            <td class="w-[12%] totalcredit"></td>
                            <td class="w-[12%] totaltotal">{$currentAmount}</td>
                        </tr>
                        HTML;
                        
                    } elseif ($item->table_name == "refund") {
                        // dd($item);
                        $balance -= $item->now_agent_fere;
                        $currentAmount = $balance >= 0 ? $balance . ' DR' : $balance . ' CR';
                        $credit += $item->now_agent_fere;
    
                        $agentname = Agent::where('id', $agentSupplierId)->value('name');
                        $ticket = Ticket::where([['user', Auth::id()], ['ticket_no', $item->ticket_no]])->first();
                        // dd($ticket, $item);
                        if ($ticket) {
                            $html .= <<<HTML
                                <tr>
                                    <td class="w-[10%]"> {$item->date} </td>
                                    <td class="w-[11%]"> {$ticket->invoice} </td>
                                    <td class="w-[15%]"> {$ticket->airline_code}/{$ticket->ticket_no} </td>
                                    <td class="w-[28%]">
                                        <!-- Remarks:  Refund
                                        Agent New Amount: {$item->now_agent_fere}
                                        Agent Previous Amount: {$item->prev_agent_amount} -->
                                        <b>Refund</b> to Customer : $agentname ,  
                                        {$ticket->invoice}<br> Ticket No : {$ticket->airline_code}/{$ticket->ticket_no}, <br>
                                        Sector : {$ticket->sector} ,<br> on {$item->date} <b> PAX Name : {$ticket->passenger}</b>
                                    </td>
                                    <td class="w-[12%] totaldebit"></td>
                                    <td class="w-[12%] totalcredit">{$item->now_agent_fere}</td>
                                    <td class="w-[12%] totaltotal">{$currentAmount}</td>
                                </tr>
                                HTML;
                        } else {
                            $html .= <<<HTML
                                <tr>
                                    <td class="w-[10%]"> {$item->date} </td>
                                    <td class="w-[11%]"> -- </td>
                                    <td class="w-[15%]"> -- </td>
                                    <td class="w-[28%]">
                                        <!-- Remarks:  Refund
                                        Agent New Amount: {$item->now_agent_fere}
                                        Agent Previous Amount: {$item->prev_agent_amount} -->
                                        <b>Refund</b> to Customer : $agentname <br>
                                        on {$item->date}
                                    </td>
                                    <td class="w-[12%] totaldebit"></td>
                                    <td class="w-[12%] totalcredit">{$item->now_agent_fere}</td>
                                    <td class="w-[12%] totaltotal">{$currentAmount}</td>
                                </tr>
                                HTML;
                        }
                        
                    } elseif ($item->table_name == "order") {
                        // $currentAmount = $item->agent_new_amount;
                        // $currentAmount = $currentAmount >= 0 ? $currentAmount . ' DR' : $currentAmount . ' CR';
                        
                        if (is_null($item->supplier) && $item->who === 'agent_' . $agentSupplierId) {
                            $balance -= $item->payable_amount;
                            $currentAmount = $balance >= 0 ? $balance . ' DR' : $balance . ' CR';
                            $credit += $item->payable_amount;
        
                            $typeneme = Type::where('id', $item->type)->value('name');
                            $html .= <<<HTML
                                                <tr>
                                                    <td class="w-[10%]"> {$item->date} </td>
                                                    <td class="w-[11%]"> {$item->invoice} </td>
                                                    <td class="w-[15%]"> {$typeneme} </td>
                                                    <td class="w-[28%]">
                                                        Passenger: {$item->name} <br>
                                                        Passport: {$item->passport_no}<br>
                                                        Remarks:  {$item->remark}
                                                    </td>
                                                    <td class="w-[12%] totaldebit"></td>
                                                    <td class="w-[12%] totalcredit">{$item->payable_amount}</td>
                                                    <td class="w-[12%] totaltotal">{$currentAmount}</td>
                                                </tr>
                                HTML;


                           
                        }
                        else{
                            $balance += $item->contact_amount;
                            $currentAmount = $balance >= 0 ? $balance . ' DR' : $balance . ' CR';
                            $debit += $item->contact_amount;
        
                            $typeneme = Type::where('id', $item->type)->value('name');
                            $html .= <<<HTML
                                                <tr>
                                                    <td class="w-[10%]"> {$item->date} </td>
                                                    <td class="w-[11%]"> {$item->invoice} </td>
                                                    <td class="w-[15%]"> {$typeneme} </td>
                                                    <td class="w-[28%]">
                                                        Passenger: {$item->name} <br>
                                                        Passport: {$item->passport_no}<br>
                                                        Remarks:  {$item->remark}
                                                    </td>
                                                    <td class="w-[12%] totaldebit">{$item->contact_amount}</td>
                                                    <td class="w-[12%] totalcredit"></td>
                                                    <td class="w-[12%] totaltotal">{$currentAmount}</td>
                                                </tr>
                                                HTML;
                        }
                        
                    } elseif ($item->table_name == "voidTicket") {
                        // $currentAmount = $item->now_agent_amount;
                        // $currentAmount = $currentAmount >= 0 ? $currentAmount . ' DR' : $currentAmount . ' CR';
    
                        $balance += $item->now_agent_fere;
                        $currentAmount = $balance >= 0 ? $balance . ' DR' : $balance . ' CR';
                        $debit += $item->now_agent_fere;
                        // dd($item->date, $currentAmount);
    
                        $agentname = Agent::where('id', $agentSupplierId)->value('name');
                        $ticket = Ticket::where([['user', Auth::id()], ['ticket_no', $item->ticket_no]])->first();
    
                        $html .= <<<HTML
                                                <tr >
                                                    <td class="w-[10%]"> {$item->date} </td>
                                                    <td class="w-[11%]"> {$item->invoice} </td>
                                                    <td class="w-[15%]"> {$item->ticket_code}-{$item->ticket_no} </td>
                                                    <td class="w-[28%]">
                                                        <b>Void</b> to Customer : $agentname ,  
                                                        {$item->invoice}<br> Ticket No : {$item->airline_code}/{$item->ticket_no}, <br>
                                                        Sector :{$ticket->sector} ,<br> on {$item->date} <b> PAX Name : {$ticket->passenger}</b>
                                                        <b>Remarks</b>:  {$item->remark}
                                                    </td>
                                                    <td class="w-[12%] totaldebit">{$item->now_agent_fere}</td>
                                                    <td class="w-[12%] totalcredit"></td>
                                                    <td class="w-[12%] totaltotal">{$currentAmount}</td>
                                                </tr>
                                                HTML;
                    }
    
                    // if($index%2 == 0){
    
                    // }
                }
                
                $balance = $balance >= 0 ? $balance . ' DR' : $balance . ' CR';
                $agentName = Agent::where('id', $agentSupplierId)->value('name');

                $htmlpart = ViewFacade::make('report.general_ledger.GeneralLadger', [
              
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'html'   => $html,
                    'balance' => $balance,
                    'debit' => $debit,
                    'credit' => $credit,
                    'holdername' => $agentName,
                    'opening_balance_debit' => $opening_balance_debit,
                    'opening_balance_credit' => $opening_balance_credit,
                    'opening_balance' => $final_opening_balance,
                    'total_ticket' => $total_ticket,
                    // $opening_balance_debit = $opening_balance_credit = $opening_balance = 0;

                   
                ])->render();

                return response()->json(['html' => $htmlpart]);
            }
            else{
                // Fetch the opening balance for the given agent from the Agent table
                $opening_balance = Supplier::where('id', $agentSupplierId)->value('opening_balance');
        
                // Initialize balance variables
                $opening_balance_debit = 0;
                $opening_balance_credit = 0;
                $final_opening_balance = 0;

                if ($startDate) {
                    // Sum up the relevant amounts until the start date
 
                      // Query for tickets where the agent is the actual agent
                     $until_start_date_tickets_supplier = Ticket::where('supplier', $agentSupplierId)
                     ->where('is_delete', 0)
                     ->where('is_active', 1)
                     ->where('user', Auth::id())
                     ->where('date', '<', $startDate)
                     ->sum('supplier_price');  // Sum of 'agent_price' for the actual supplier
 
                   
                     // Query for orders where the supplier is the actual supplier
                     $until_start_date_orders_supplier = Order::where('supplier', $agentSupplierId)
                         ->where('is_delete', 0)
                         ->where('is_active', 1)
                         ->where('user', Auth::id())
                         ->where('date', '<', $startDate)
                         ->sum('payable_amount');  // Sum of 'contact_amount' for the actual supplier
 
                     // Payments: Subtract amount from the Payment table
                     $until_start_date_payments = Payment::where('receive_from', 'supplier')
                         ->where('agent_supplier_id', $agentSupplierId)
                         ->where('user', Auth::id())
                         ->where('date', '<', $startDate)
                         ->sum('amount'); // Sum of 'amount' in the payments
 
                     // Receives: Subtract amount from the Receive table
                     $until_start_date_receives = Receiver::where('receive_from', 'supplier')
                         ->where('agent_supplier_id', $agentSupplierId)
                         ->where('user', Auth::id())
                         ->where('date', '<', $startDate)
                         ->sum('amount'); // Sum of 'amount' in the receives
 
                     // Reissues: Add now_agent_fere from the ReissueTicket table
                     $until_start_date_reissues = ReissueTicket::where('supplier', $agentSupplierId)
                         ->where('user', Auth::id())
                         ->where('date', '<', $startDate)
                         ->sum('now_supplier_fare'); // Sum of 'now_supplier_fare' in the reissue tickets
 
                     // Refunds: Subtract now_supplier_fare from the Refund table
                     $until_start_date_refunds = Refund::where('supplier', $agentSupplierId)
                         ->where('user', Auth::id())
                         ->where('date', '<', $startDate)
                         ->sum('now_supplier_fare'); // Sum of 'now_supplier_fare' in the refunds
 
                     // Void Tickets: Add now_supplier_fare from the VoidTicket table
                     $until_start_date_void_tickets = VoidTicket::where('user', Auth::id())
                         ->where('supplier', $agentSupplierId)
                         ->where('date', '<', $startDate)
                         ->sum('now_supplier_fare'); // Sum of 'now_supplier_fare' in the void tickets
 
                     // Calculate the opening balance up until the start date
                     $opening_balance_debit = $until_start_date_payments + $until_start_date_refunds;
                     $opening_balance_credit = $until_start_date_orders_supplier + $until_start_date_tickets_supplier + $until_start_date_reissues + $until_start_date_receives + $until_start_date_void_tickets;
 
                     // Final opening balance calculation: debit balance minus credit balance
                     $final_opening_balance = $opening_balance + $opening_balance_credit - $opening_balance_debit;
 
                     // Now you have the final opening balance
                 } else {
                     // If no start date is provided, the balance is simply the agent's opening balance
                     if(is_null($opening_balance)){
                         $final_opening_balance = 0;
                     }
                     else{
                         $final_opening_balance = $opening_balance;
                     }
                 }
                   // Agent-related data retrieval
                   $tickets = DB::table('tickets')
                   ->where('supplier', $agentSupplierId)
                   ->where('is_delete', 0)
                   ->where('is_active', 1)
                   ->where('user', Auth::id());
   
                   // Orders related to the agent
                   $orders = DB::table('order')
                   ->where('supplier', $agentSupplierId)
                   ->where('is_delete', 0)
                   ->where('is_active', 1)
                   ->where('user', Auth::id());
   
                   // Receives
                   $receive = DB::table('receive')
                   ->where('receive_from', 'supplier')
                   ->where('agent_supplier_id', $agentSupplierId)
                   ->where('user', Auth::id());
   
                   // Payments
                   $payment = DB::table('payment')
                   ->where('receive_from', 'supplier')
                   ->where('agent_supplier_id', $agentSupplierId)
                   ->where('user', Auth::id());
   
                   // Refunds
                   $refund = DB::table('refund')
                   ->where('supplier', $agentSupplierId)
                   ->where('user', Auth::id());
   
                   // Void Tickets
                   $void_ticket = DB::table('voidticket')
                   ->where('user', Auth::id())
                   ->where('supplier', $agentSupplierId);
   
                   // Reissues
                   $reissue = DB::table('reissue')
                   ->where('supplier', $agentSupplierId)
                   ->where('user', Auth::id());
   
                   // Apply date filters if both start and end dates are provided
                   if ($startDate && $endDate) {
                   $tickets = $tickets->whereBetween('date', [$startDate, $endDate]);
                   $orders = $orders->whereBetween('date', [$startDate, $endDate]);
                   $receive = $receive->whereBetween('date', [$startDate, $endDate]);
                   $payment = $payment->whereBetween('date', [$startDate, $endDate]);
                   $refund = $refund->whereBetween('date', [$startDate, $endDate]);
                   $void_ticket = $void_ticket->whereBetween('date', [$startDate, $endDate]);
                   $reissue = $reissue->whereBetween('date', [$startDate, $endDate]);
                   } elseif ($startDate) {
                   // Apply filter if only start date is provided
                   $tickets = $tickets->where('date', '>=', $startDate);
                   $orders = $orders->where('date', '>=', $startDate);
                   $receive = $receive->where('date', '>=', $startDate);
                   $payment = $payment->where('date', '>=', $startDate);
                   $refund = $refund->where('date', '>=', $startDate);
                   $void_ticket = $void_ticket->where('date', '>=', $startDate);
                   $reissue = $reissue->where('date', '>=', $startDate);
                   } elseif ($endDate) {
                   // Apply filter if only end date is provided
                   $tickets = $tickets->where('date', '<=', $endDate);
                   $orders = $orders->where('date', '<=', $endDate);
                   $receive = $receive->where('date', '<=', $endDate);
                   $payment = $payment->where('date', '<=', $endDate);
                   $refund = $refund->where('date', '<=', $endDate);
                   $void_ticket = $void_ticket->where('date', '<=', $endDate);
                   $reissue = $reissue->where('date', '<=', $endDate);
                   }
   
                   // Use get() to fetch the data, and then apply map()
                   $tickets = $tickets->get()->map(function ($item) {
                   $item->table_name = 'tickets';  // Add a table_name property
                   return $item;
                   });
   
                   $orders = $orders->get()->map(function ($item) {
                   $item->table_name = 'order';  // Add a table_name property
                   return $item;
                   });
   
                   $receive = $receive->get()->map(function ($item) {
                   $item->table_name = 'receive';  // Add a table_name property
                   return $item;
                   });
   
                   $payment = $payment->get()->map(function ($item) {
                   $item->table_name = 'payment';  // Add a table_name property
                   return $item;
                   });
   
                   $refund = $refund->get()->map(function ($item) {
                   $item->table_name = 'refund';  // Add a table_name property
                   return $item;
                   });
   
                   $void_ticket = $void_ticket->get()->map(function ($item) {
                   $item->table_name = 'voidticket';  // Add a table_name property
                   return $item;
                   });
   
                   $reissue = $reissue->get()->map(function ($item) {
                   $item->table_name = 'reissue';  // Add a table_name property
                   return $item;
                   });
   
                   // Merge all collections into one collection
                   $mergedCollection = $tickets->merge($orders)
                               ->merge($receive)
                               ->merge($payment)
                               ->merge($refund)
                               ->merge($void_ticket)
                               ->merge($reissue);
   
                   // Sort the merged collection by date
                   $sortedCollection = $mergedCollection->sortBy('date')->values();
   
                   $activeTransactionMethods = Transaction::where([['is_active', 1],['is_delete',0],['user', Auth::id()]])->pluck('name', 'id')->toArray();
                   
                $debit = 0;
                $balance = $final_opening_balance;
                $credit = 0;
                $total_ticket = 0;
                $html = '';

                $supplierName = Supplier::where('id', $agentSupplierId)->value('name');

                
                foreach ($sortedCollection as $index => $item) {
                    // dd($item->getTable());
                  
                    if ($item->table_name == "tickets") {
                        // Handle logic specific to Ticket model
                        $credit += $item->supplier_price;
                        $balance += $item->supplier_price;
                        $currentAmount = $balance >= 0 ? $balance . ' CR' : $balance . ' DR';
                        $ticket = Ticket::where([['user', Auth::id()], ['ticket_no', $item->ticket_no]])->first();
                        $total_ticket++;
                        $html .= <<<HTML
                                                    <tr>
                                                        <td class="w-[10%]"> $item->invoice_date </td>
                                                        <td class="w-[11%]"> $item->invoice </td>
                                                        <td class="w-[15%]"> {$item->airline_code}/{$item->ticket_no} </td>
                                                        <td class="w-[28%] pr-3">
                                                            PAX NAME: <span class="font-semibold"> $item->passenger </span><br>
                                                            PNR:  $item->pnr ,  $item->sector <br>
                                                            FLIGHT DATE:  $item->flight_date <br>
                                                            $item->airline_code -  $item->airline_name <br>
                                                            Remarks:  $item->remark 
                                                        </td>
                                                        <td class="w-[12%] totaldebit"> </td>
                                                        <td class="w-[12%] totalcredit">$item->supplier_price </td>
                                                        <td class="w-[12%] totaltotal">$currentAmount</td>
                                                    </tr>
                                                HTML;
                    }
                    elseif ($item->table_name == "refund") {
                        // dd($item);
                        $balance -= $item->now_supplier_fare;
                        $currentAmount = $balance >= 0 ? $balance . ' CR' : $balance . ' DR';
                        $debit += $item->now_supplier_fare;
    
                        $agentname = Agent::where('id', $agentSupplierId)->value('name');
                        $ticket = Ticket::where([['user', Auth::id()], ['ticket_no', $item->ticket_no]])->first();
                        $invoiceshow = isset($item->invoice) && !empty($item->invoice) ? $item->invoice : '';
                        // dd($ticket, $item);
                        $html .= <<<HTML
                        <tr>
                            <td class="w-[10%]"> {$item->date} </td>
                            <td class="w-[11%]"> {$invoiceshow} </td>
                        
                        HTML;
                        
                        if ($ticket) {
                            $html .= <<<HTML
                            <td class="w-[15%]"> {$ticket->airline_code}/{$ticket->ticket_no} </td>
                            <td class="w-[28%]">
                                <b>Refund</b> to Customer: $agentname,  
                                {$invoiceshow}<br> 
                                Ticket No: {$ticket->airline_code}/{$ticket->ticket_no}, <br>
                                Sector: {$ticket->sector}, <br> 
                                on {$item->date} <b>PAX Name: {$ticket->passenger}</b><br>
                            </td>
                        HTML;
                        } else {
                            $html .= <<<HTML
                            <td class="w-[15%]">Deleted Ticket </td>
                            <td class="w-[28%]">
                                <b>Refund</b> to Customer: $agentname,  
                                {$invoiceshow}<br> 
                                Deleted Ticket
                            </td>
                        HTML;
                        }
                        
                        $html .= <<<HTML
                            <td class="w-[12%] totaldebit">{$item->now_supplier_fare}</td>
                            <td class="w-[12%] totalcredit"></td>
                            <td class="w-[12%] totaltotal">{$currentAmount}</td>
                        </tr>
                        HTML;
                        } elseif ($item->table_name == "receive") {
                        // dd($item);
                        $balance += $item->amount;
                        $currentAmount = $balance >= 0 ? $balance . ' CR' : $balance . ' DR';
                        $credit += $item->amount;
                        // $ticket = Ticket::where([['user', Auth::id()], ['ticket_no', $item->ticket_no]])->first();
                        $html .= <<<HTML
                                                <tr>
                                                    <td class="w-[10%]"> {$item->date} </td>
                                                    <td class="w-[11%]"> {$item->invoice} </td>
                                                    <td class="w-[15%]">  </td>
                                                    <td class="w-[28%]">
                                                        Remarks:  {$item->remark} <br>
                                                        <b>Receive from {$activeTransactionMethods[$item->method]}</b>

                                                    </td>
                                                    <td class="w-[12%] totaldebit"></td>
                                                    <td class="w-[12%] totalcredit">{$item->amount}</td>
                                                    <td class="w-[12%] totaltotal">{$currentAmount}</td>
                                                </tr>
                                                HTML;
                    } elseif ($item->table_name == "payment") {
    
                        $balance -= $item->amount;
                        $currentAmount = $balance >= 0 ? $balance . ' CR' : $balance . ' DR';
                        $debit += $item->amount;
    
                        $html .= <<<HTML
                                                <tr>
                                                    <td class="w-[10%]"> {$item->date} </td>
                                                    <td class="w-[11%]"> {$item->invoice} </td>
                                                    <td class="w-[15%]"> 
                                                    
                                                     </td>
                                                    <td class="w-[28%]">
                                                        Remarks:  {$item->remark} <br>
                                                        <b>Payment by {$activeTransactionMethods[$item->method]}</b>

                                                    </td>
                                                    <td class="w-[12%] totaldebit">{$item->amount}</td>
                                                    <td class="w-[12%] totalcredit"></td>
                                                    <td class="w-[12%] totaltotal">{$currentAmount}</td>
                                                </tr>
                                                HTML;
                    } elseif ($item->table_name == "reissue") {
                        // $currentAmount = $item->now_supplier_amount;
                        // $currentAmount = $currentAmount >= 0 ? $currentAmount . ' DR' : $currentAmount . ' CR';
                        // dd($item);
                        $balance += $item->now_supplier_fare;
                        $currentAmount = $balance >= 0 ? $balance . ' CR' : $balance . ' DR';
                        $ticket = Ticket::where([['user', Auth::id()], ['ticket_no', $item->ticket_no]])->first();
                        $credit += $item->now_supplier_fare;


                        $html .= <<<HTML
                                                <tr >
                                                    <td class="w-[10%]"> {$item->date} </td>
                                                    <td class="w-[11%]"> {$item->invoice} </td>
                                                    <td class="w-[15%]"> {$ticket->airline_code}/{$ticket->ticket_no} </td>
                                                    <td class="w-[28%]">
                                                         
                                                        <b>Reissue</b> to Customer : $supplierName ,  
                                                        {$item->invoice}<br> Ticket No : {$ticket->airline_code}/{$ticket->ticket_no}, <br>
                                                        Sector :{$ticket->sector} ,<br> on {$item->date} <b> PAX Name : {$ticket->passenger}</b><br/>
                                                    </td>
                                                    <td class="w-[12%] totaldebit"></td>
                                                    <td class="w-[12%] totalcredit">{$item->now_supplier_fare}</td>
                                                    <td class="w-[12%] totaltotal">{$currentAmount}</td>
                                                </tr>
                                                HTML;
                    } elseif ($item->table_name == "voidTicket") {
                        // dd($item);
                        // $currentAmount = $item->now_supplier_amount;
                        // $currentAmount = $currentAmount >= 0 ? $currentAmount . ' DR' : $currentAmount . ' CR';
                        $balance += $item->now_supplier_fare;
                        $currentAmount = $balance >= 0 ? $balance . ' CR' : $balance . ' DR';
                        $credit += $item->now_supplier_fare;
                        $ticket = Ticket::where([['user', Auth::id()], ['ticket_no', $item->ticket_no]])->first();
    
                        $html .= <<<HTML
                                                <tr >
                                                    <td class="w-[10%]"> {$item->date} </td>
                                                    <td class="w-[11%]"> {$item->invoice} </td>
                                                    <td class="w-[15%]"> {$item->ticket_code}/{$item->ticket_no} </td>
                                                    <td class="w-[28%]">
                                                        <b>Void</b> to Customer : $supplierName ,  
                                                        {$item->invoice}<br> Ticket No : {$item->airline_code}/{$item->ticket_no}, <br>
                                                        Sector :{$ticket->sector} ,<br> on {$item->date} <b> PAX Name : {$ticket->passenger}</b><br>
                                                        Remarks:  {$item->remark}
                                                    </td>
                                                    <td class="w-[12%] totaldebit"></td>
                                                    <td class="w-[12%] totalcredit">{$item->now_supplier_fare}</td>
                                                    <td class="w-[12%] totaltotal">{$currentAmount}</td>
                                                </tr>
                                                HTML;
                    } elseif ($item->table_name == "order") {
                        
                        $balance += $item->payable_amount;
                        $currentAmount = $balance >= 0 ? $balance . ' CR' : $balance . ' DR';
                        $credit += $item->payable_amount;
    
                        $typeneme = Type::where('id', $item->type)->value('name');
                        $html .= <<<HTML
                                                <tr>
                                                    <td class="w-[10%]"> {$item->date} </td>
                                                    <td class="w-[11%]"> {$item->invoice} </td>
                                                    <td class="w-[15%]"> {$typeneme} </td>
                                                    <td class="w-[28%]">
                                                        
                                                        Passenger: {$item->name} <br>
                                                        Passport: {$item->passport_no}<br>
                                                        Remarks:  {$item->remark} <br>
                                                    </td>
                                                    <td class="w-[12%] totaldebit"></td>
                                                    <td class="w-[12%] totalcredit">{$item->payable_amount}</td>
                                                    <td class="w-[12%] totaltotal">{$currentAmount}</td>
                                                </tr>
                                                HTML;
                    }
                }
                $balance = $balance >= 0 ? $balance . ' CR' : $balance . ' DR';
                
                // $balance = $balance >= 0 ? $balance . ' DR' : $balance . ' CR';
                $agentName = Supplier::where('id', $agentSupplierId)->value('name');

                $htmlpart = ViewFacade::make('report.general_ledger.GeneralLadger', [
              
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'html'   => $html,
                    'balance' => $balance,
                    'debit' => $debit,
                    'credit' => $credit,
                    'holdername' => $agentName,
                    'opening_balance_debit' => $opening_balance_debit,
                    'opening_balance_credit' => $opening_balance_credit,
                    'opening_balance' => $final_opening_balance,
                    'total_ticket' => $total_ticket,
                    // $opening_balance_debit = $opening_balance_credit = $opening_balance = 0;

                   
                ])->render();

                return response()->json(['html' => $htmlpart]);
   
            }
        }
            

        
        else{
            return view('welcome');
        }
    }

}
