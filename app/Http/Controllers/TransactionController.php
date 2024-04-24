<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth; // Add this line


class TransactionController extends Controller
{
    public function index()
    {
        $user = Auth::id();
        $transactions = Transaction::where([['is_delete',0],['is_active',1],['user',$user]])->get();
        return view('transaction/index', compact('transactions'));
    }

    public function store(Request $request)
    {
        // dd('s');
       
        $transaction = new Transaction();
        $transaction->name = strtoupper($request->name);
        $transaction->description = $request->description;
        
        $transaction->user = Auth::id();
        $transaction->save();
        return redirect()->route('transaction.view')->with('success', 'Transaction added successfully');
    }

    public function edit($id)
    {
        $id = decrypt($id);
        $transaction = Transaction::findOrFail($id);
        return view('transaction.edit', compact('transaction'));
    }
        public function update(Request $request, $id)
        {
            // dd($request->all(), $id);
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                
            ]);

            if($validatedData){
                $transaction = Transaction::find($id);
                $transaction->name = $request->name;
                $transaction->description = $request->description;

                if($transaction->save()){
                    return redirect()->route('transaction.view')->with('success', 'Transaction updated successfully');
                }
                else{
                    return redirect()->route('transaction.view')->with('error', 'Transaction updated failed');
                }
            }         

            return redirect()->route('transaction.view')->with('error', 'Transaction updated failed');
        }

    public function delete($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->is_delete = 1;
        if($transaction->save()){
            return redirect()->route('transaction.view')->with('success', 'Transaction deleted successfully');
        }
        else{
            return redirect()->route('transaction.view')->with('error', 'Transaction deleted failed');
        }
        return redirect()->route('transaction.view')->with('error', 'Transaction deleted failed');
        
    }
}

?>