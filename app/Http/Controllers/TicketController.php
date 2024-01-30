<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Add this line
use App\Models\Supplier;
use App\Models\Agent;
use App\Models\Type;
use App\Models\Order;
use Illuminate\View\View;
use DateTime;

class TicketController extends Controller
{
    public function index()
    {
        $user = Auth::id();
        $suppliers = Supplier::where([['is_delete',0],['is_active',1],['user',$user]])->get();
        $agents = Agent::where([['is_delete',0],['is_active',1],['user',$user]])->get();
        $types = Type::where([['is_delete',0],['is_active',1],['user',$user]])->get();
        $orders = Order::where([['is_delete',0],['is_active',1],['user', $user]])->get();
        foreach($orders as $order){
            $order->type = Type::find($order->type)->value('name');
            $order->agent = Agent::find($order->agent)->value('name');
            $order->supplier = Supplier::find($order->supplier)->value('name');
        }
        // dd($orders);
        // dd($suppliers);
        return view('ticket/index', compact('suppliers', 'agents', 'types', 'orders'));
    }
    public function deportee()
    {
        $user = Auth::id();
        $suppliers = Supplier::where([['is_delete',0],['is_active',1],['user',$user]])->get();
        $agents = Agent::where([['is_delete',0],['is_active',1],['user',$user]])->get();
        $types = Type::where([['is_delete',0],['is_active',1],['user',$user]])->get();
        $orders = Order::where([['is_delete',0],['is_active',1],['user', $user]])->get();
        foreach($orders as $order){
            $order->type = Type::find($order->type)->value('name');
            $order->agent = Agent::find($order->agent)->value('name');
            $order->supplier = Supplier::find($order->supplier)->value('name');
        }
        // dd($orders);
        // dd($suppliers);
        return view('deportee/index', compact('suppliers', 'agents', 'types', 'orders'));
    }

    public function store(Request $request)
    {
        dd($request->all());
       $validatedData = $request->validate([
            'date' => 'required|date',
            'type' => 'required|integer|exists:type,id',
            'agent' => 'required|integer|exists:agent,id',
            'seller' => 'nullable|string|max:255',
            'phone' => 'required|string|max:15',
            'name' => 'required|string|max:255',
            'passport_no' => 'required|string|max:255',
            'contact_amount' => 'required|numeric',
            'payable_amount' => 'required|numeric',
            'other_expense' => 'nullable|numeric',
            'country' => 'required|string',
            'supplier' => 'required|exists:supplier,id',
            'remark' => 'nullable|string',
            'invoice' => 'required|string|max:255',
        ]);
        

        if($validatedData){
            // dd($request->all());
            $supplier = new Order();
            $supplier->name = $validatedData['name'];
            $supplier->date = (new DateTime($validatedData['date']))->format('Y-m-d');
            $supplier->type = $validatedData['type'];
            $supplier->agent = $validatedData['agent'];
            $supplier->seller = $validatedData['seller'];
            $supplier->phone = $validatedData['phone'];
            $supplier->passport_no = $validatedData['passport_no'];
            $supplier->contact_amount = $validatedData['contact_amount'];
            $supplier->payable_amount = $validatedData['payable_amount'];
            $supplier->other_expense = $validatedData['other_expense'];
            $supplier->country = $validatedData['country'];
            $supplier->supplier = $validatedData['supplier'];
            $supplier->remark = $validatedData['remark'];
            $supplier->invoice = $validatedData['invoice'];

            if (isset($validatedData['other_expense'])) {
                $profit = $validatedData['contact_amount'] - ($validatedData['payable_amount'] + $validatedData['other_expense']);
            } else {
                $profit = $validatedData['contact_amount'] - $validatedData['payable_amount'];
            }
            
            // Now $profit contains the calculated profit based on the conditions
            $supplier->profit = $profit;
            $supplier->user = Auth::id();
            $isdone = $supplier->save();

            if($isdone){
                return redirect()->route('order.view')->with('success', 'Order added successfully');
            }
        }
        // $validatedData['user'] = Auth::id();
        // Order::create($validatedData);
        return redirect()->route('order.view')->with('error', 'Order is not added');
    }

    public function edit($id)
    {
        $id = decrypt($id);
        $supplier = Supplier::findOrFail($id);
        return view('supplier.edit', compact('supplier'));
    }
        public function update(Request $request, $id)
        {
            // dd($request->all(), $id);
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'description' => 'required|string',
            ]);

            if($validatedData){
                $supplier = Supplier::find($id);
                $supplier->name = $request->name;
                $supplier->phone = $request->phone;
                $supplier->description = $request->description;
                

                if($supplier->save()){
                    return redirect()->route('supplier.view')->with('success', 'Supplier updated successfully');
                }
                else{
                    return redirect()->route('supplier.view')->with('error', 'Supplier updated failed');
                }
            }         

            return redirect()->route('supplier.view')->with('error', 'Supplier updated failed');
        }

    public function delete($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->is_delete = 1;
        if($supplier->save()){
            return redirect()->route('supplier.view')->with('success', 'Supplier deleted successfully');
        }
        else{
            return redirect()->route('supplier.view')->with('error', 'Supplier deleted failed');
        }
        return redirect()->route('supplier.view')->with('error', 'Supplier deleted failed');
        
    }
}

?>