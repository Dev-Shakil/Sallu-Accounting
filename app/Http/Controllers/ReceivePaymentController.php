<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agent; // Assuming Agent model is in the App\Models namespace
use App\Models\Payment; // Assuming Agent model is in the App\Models namespace
use App\Models\Receiver;
use App\Models\Transaction;  // Assuming Agent model is in the App\Models namespace
use App\Models\Supplier; // Assuming Agent model is in the App\Models namespace
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use DateTime;

class ReceivePaymentController extends Controller
{
    public function index()
    {
        if(Auth::user()){
             // Assuming 'is_deleted' is the correct column name in the Agent model
            $agents = Agent::where('is_delete', 0)->where('user', Auth::id())->get();
            $suppliers = Supplier::where('is_delete', 0)->where('user', Auth::id())->get();
            $methods = Transaction::where('is_delete', 0)->where('user', Auth::id())->get();
            return view('receive_payment.index', compact('agents', 'suppliers', 'methods'));
        }
        else{
            return view('welcome');
        }
       
    }
    public function payment_index()
    {
        if(Auth::user()){
             // Assuming 'is_deleted' is the correct column name in the Agent model
            $agents = Agent::where('is_delete', 0)->where('user', Auth::id())->get();
            $suppliers = Supplier::where('is_delete', 0)->where('user', Auth::id())->get();
            $methods = Transaction::where('is_delete', 0)->where('user', Auth::id())->get();
            return view('receive_payment.payment', compact('agents', 'suppliers', 'methods'));
        }
        else{
            return view('welcome');
        }
       
    }
    public function receive_index()
    {
        if(Auth::user()){
                // Assuming 'is_deleted' is the correct column name in the Agent model
            $agents = Agent::where('is_delete', 0)->where('user', Auth::id())->get();
            $suppliers = Supplier::where('is_delete', 0)->where('user', Auth::id())->get();
            $methods = Transaction::where('is_delete', 0)->where('user', Auth::id())->get();
            return view('receive_payment.receive', compact('agents', 'suppliers', 'methods'));
        }
        else{
            return view('welcome');
        }
       
    }

    

    public function payment(Request $request){

        if(Auth::user()){
            
        // dd($request->all())
        $supplierName = $request->supplierName;

        // Split the string at the underscore character
        list($tableName, $clientID) = explode('_', $supplierName);
        // dd($tableName, $supplierId);
        $payment = new Payment;
        $payment->invoice = $request->paymentRef;
        $payment->date = (new DateTime($request->paymentDate))->format('Y-m-d');
        $payment->agent_supplier_id = $clientID;
        $payment->receive_from = $tableName;
        $payment->amount = $request->paymentAmount;
        $payment->method = $request->paymentMethod;

        $transaction = Transaction::where('id', $request->paymentMethod)->first();
        $newAmount = $transaction->amount - $request->paymentAmount;
        $transaction->amount = $newAmount;
        $transaction->save();

        // Build the model class name dynamically
        $modelClassName = ucfirst($tableName);

        // Create an instance of the model
        $model = app("App\\Models\\$modelClassName");

        $supplier = $model->where('id', $clientID)->first();

        // dd($supplier->getTable());

        if($supplier){

            if($supplier->getTable() == 'agent'){
                $previous_amount = $supplier->amount;
                $current_amount = floatval($previous_amount) + floatval($request->paymentAmount);
                $supplier->amount = $current_amount;
                $supplier->save();
            }  
            else{
                $previous_amount = $supplier->amount;
                $current_amount = floatval($previous_amount) - floatval($request->paymentAmount);
                $supplier->amount = $current_amount;
                $supplier->save();
            }
            
        }
        else{
            $agents = Agent::where('is_delete', 0)->where('user', Auth::id())->get();
            $suppliers = Supplier::where('is_delete', 0)->where('user', Auth::id())->get();
            $methods = Transaction::where('is_delete', 0)->where('user', Auth::id())->get();
            // return view('receive_payment.index', compact('agents', 'suppliers', 'methods'))->with('error', 'Error Occurred.');
            return response()->json(['message' => 'Error Occurred', 'success' => false]);

        }
       
        
        $payment->previous_amount = $previous_amount;
        $payment->current_amount = $current_amount;
        $payment->user = Auth::id();
        $payment->remark = $request->remarks;

        $payment->save();


        $agents = Agent::where('is_delete', 0)->where('user', Auth::id())->get();
        $suppliers = Supplier::where('is_delete', 0)->where('user', Auth::id())->get();
        $methods = Transaction::where('is_delete', 0)->where('user', Auth::id())->get();
        $fullEntry = [
            'payment' => $payment,
            // 'receiver' => $receiver,
            // Add other data you want to include in the full entry here
        ];
        // return view('receive_payment.index', compact('agents', 'suppliers', 'methods'))->with('success', 'Payment successfully submitted.');
        return response()->json(['fullEntry' => $fullEntry,'message' => 'Payment successfully submitted', 'success' => true]);
    
        }
        else{
            return view('welcome');
        }
    }


    
    public function receive(Request $request){
        if(Auth::user()){
            
        // dd($request->all());
        $clientName = $request->clientName;

        // Split the string at the underscore character
        list($tableName, $clientID) = explode('_', $clientName);

        $payment = new Receiver;
        $payment->invoice = $request->receiveRef;
        $payment->date = (new DateTime($request->receiveDate))->format('Y-m-d');
        $payment->agent_supplier_id = $clientID;
        $payment->receive_from = $tableName;
        $payment->amount = $request->receiveAmount;
        $payment->method = $request->receiveMethod;

        
        $transaction = Transaction::where('id', $request->receiveMethod)->first();
        $newAmount = $transaction->amount + $request->receiveAmount;
        $transaction->amount = $newAmount;
        $transaction->save();


         // Build the model class name dynamically
         $modelClassName = ucfirst($tableName);

         // Create an instance of the model
         $model = app("App\\Models\\$modelClassName");

        $receiver = $model->where('id', $clientID)->first();

        if($receiver){
            if($receiver->getTable() == 'agent'){
                $previous_amount = $receiver->amount;
                $current_amount = floatval($previous_amount) - floatval($request->receiveAmount);
                $receiver->amount = $current_amount;
                $receiver->save();
            }  
            else{
                $previous_amount = $receiver->amount;
                $current_amount = floatval($previous_amount) + floatval($request->receiveAmount);
                $receiver->amount = $current_amount;
                $receiver->save();
            }
        }
      
        else{
            $agents = Agent::where('is_delete', 0)->where('user', Auth::id())->get();
            $suppliers = Supplier::where('is_delete', 0)->where('user', Auth::id())->get();
            $methods = Transaction::where('is_delete', 0)->where('user', Auth::id())->get();
            return response()->json(['message' => 'Error Occurred', 'success' => false]);

            // return view('receive_payment.index', compact('agents', 'suppliers', 'methods'))->with('error', 'Error Occurred.');
        }
        
        $payment->previous_amount = $previous_amount;
        $payment->current_amount = $current_amount;
        $payment->user = Auth::id();
        $payment->remark = $request->remarks;

        $payment->save();


        $agents = Agent::where('is_delete', 0)->where('user', Auth::id())->get();
        $suppliers = Supplier::where('is_delete', 0)->where('user', Auth::id())->get();
        $methods = Transaction::where('is_delete', 0)->where('user', Auth::id())->get();
        $fullEntry = [
            'payment' => $payment,
            'receiver' => $receiver,
            // Add other data you want to include in the full entry here
        ];
        return response()->json(['fullEntry' => $fullEntry, 'message' => 'Receive successfully submitted', 'success' => true]);
        // return view('receive_payment.index', compact('agents', 'suppliers','methods'))->with('success', 'Receive successfully submitted.');
        }  
        else{
            return view('welcome');
        } 
    }

    public function getlastid_receive(){
        if(Auth::user()){
            try {
                $lastId = Receiver::latest('id')->value('id');
                $newInvoice = 0;
    
                if ($lastId) {
                    $receive = Receiver::find($lastId);
                    if ($receive) {
                        $invoice = $receive->invoice;
                        $parts = explode("-", $invoice);
                        $partAfterHyphen = end($parts); // Extract part after hyphen
                        $newPartAfterHyphen = floatval($partAfterHyphen) + 1; // Increment invoice number
                        $newInvoice = $parts[0] . "-" . str_pad($newPartAfterHyphen, strlen($partAfterHyphen), '0', STR_PAD_LEFT); // Concatenate back to original format
                        
                    } else {
                       
                    }
                }
                else{
                    $lastId = 0;
                    $newInvoice = "RV-0001";
                }
           
                return response()->json(['lastId' => $lastId, 'invoice' => $newInvoice]);
    
            } catch (\Exception $e) {
                // Handle any exceptions that might occur during the process
                return response()->json(['error' => 'Error fetching last ID'], 500);
            }    
        }
        else{
            return view('welcome');
        }
       
    }

    public function getlastid_payment(){
        if(Auth::user()){
            try {
                $lastId = Payment::latest('id')->value('id');
                $newInvoice = 0;
    
                if ($lastId) {
                    $payment = Payment::find($lastId);
                    if ($payment) {
                        $invoice = $payment->invoice;
                        $parts = explode("-", $invoice);
                        $partAfterHyphen = end($parts); // Extract part after hyphen
                        $newPartAfterHyphen = floatval($partAfterHyphen) + 1; // Increment invoice number
                        $newInvoice = $parts[0] . "-" . str_pad($newPartAfterHyphen, strlen($partAfterHyphen), '0', STR_PAD_LEFT); // Concatenate back to original format
                        
                    } else {
                       
                    }
                }
                else{
                    $lastId = 0;
                    $newInvoice = "PV-0001";
                }
          
                return response()->json(['lastId' => $lastId, 'invoice' => $newInvoice]);
    
            } catch (\Exception $e) {
                // Handle any exceptions that might occur during the process
                return response()->json(['error' => 'Error fetching last ID'], 500);
            } 
        }
        else{
            return view('welcome');
        }
    }

    public function delete_receive($id) {
        if(Auth::user()){
            DB::beginTransaction();
    
            try {
                $receive = Receiver::find($id);
                $transaction = Transaction::where('id', $receive->method)->first();
        
                // Update transaction amount
                $transaction->amount -= $receive->amount;
                $transaction->save();
        
                // Update agent's or supplier's amount based on receive_from
                if($receive->receive_from == 'agent') {
                    $agent = Agent::find($receive->agent_supplier_id);
                    $agent->amount += $receive->amount;
                    $agent->save();
                } else {
                    $supplier = Supplier::find($receive->agent_supplier_id);
                    $supplier->amount -= $receive->amount;
                    $supplier->save();
                }
        
             
                $receive->delete();
        
                DB::commit();
        
                return redirect()->route('receive_report_index');
            } catch (\Exception $e) {
                DB::rollback();
          
                return redirect()->back()->with('error', 'An error occurred while deleting the receive record.');
            }
        }
        else{
            return view('welcome');
        }
      
    }

    
    public function delete_payment($id) {
        if(Auth::user()){
            DB::beginTransaction();
    
            try {
                $payment = Payment::find($id);
                $transaction = Transaction::where('id', $payment->method)->first();
        
                // Update transaction amount
                $transaction->amount += $payment->amount;
                $transaction->save();
        
                // Update agent's or supplier's amount based on receive_from
                if($payment->receive_from == 'agent') {
                    $agent = Agent::find($payment->agent_supplier_id);
                    $agent->amount -= $payment->amount;
                    $agent->save();
                } else {
                    $supplier = Supplier::find($payment->agent_supplier_id);
                    $supplier->amount += $payment->amount;
                    $supplier->save();
                }
        
             
                $payment->delete();
        
                DB::commit();
        
                return redirect()->route('payment_report_index');
            } catch (\Exception $e) {
                DB::rollback();
          
                return redirect()->back()->with('error', 'An error occurred while deleting the payment record.');
            }
        }
        else{
            return view('welcome');
        }
      
    }
}
