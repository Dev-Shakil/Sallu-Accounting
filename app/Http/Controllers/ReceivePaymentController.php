<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agent; // Assuming Agent model is in the App\Models namespace
use App\Models\Payment; // Assuming Agent model is in the App\Models namespace
use App\Models\Receiver;
use App\Models\Transaction;  // Assuming Agent model is in the App\Models namespace
use App\Models\Supplier; // Assuming Agent model is in the App\Models namespace
use Illuminate\Support\Facades\Auth;
use DateTime;

class ReceivePaymentController extends Controller
{
    public function index()
    {
        // Assuming 'is_deleted' is the correct column name in the Agent model
        $agents = Agent::where('is_delete', 0)->where('user', Auth::id())->get();
        $suppliers = Supplier::where('is_delete', 0)->where('user', Auth::id())->get();
        $methods = Transaction::where('is_delete', 0)->where('user', Auth::id())->get();
        return view('receive_payment.index', compact('agents', 'suppliers', 'methods'));
    }

    

    public function payment(Request $request){
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
        // return view('receive_payment.index', compact('agents', 'suppliers', 'methods'))->with('success', 'Payment successfully submitted.');
        return response()->json(['message' => 'Payment successfully submitted', 'success' => true]);
    }


    
    public function receive(Request $request){
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
        return response()->json(['message' => 'Receive successfully submitted', 'success' => true]);
        // return view('receive_payment.index', compact('agents', 'suppliers','methods'))->with('success', 'Receive successfully submitted.');
    }
}
