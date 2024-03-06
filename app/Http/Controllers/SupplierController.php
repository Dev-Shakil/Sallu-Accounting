<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Add this line
use App\Models\Supplier;
use Illuminate\View\View;

class SupplierController extends Controller
{
    public function index()
    {
        $user = Auth::id();
        $suppliers = Supplier::where([['is_delete',0],['is_active',1],['user',$user]])->get();
        // dd($suppliers);
        return view('supplier/index', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'company' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'description' => 'string',
        ]);

        if($validatedData){
            $supplier = new Supplier();
            $supplier->name = $validatedData['name'];
            $supplier->phone = $validatedData['phone'];
            $supplier->company = $validatedData['company'];
            $supplier->email = $validatedData['email'];
            $supplier->description = $validatedData['description'];
            $supplier->user = Auth::id();
            $isdone = $supplier->save();

            if($isdone){
                return redirect()->route('supplier.view')->with('success', 'Supplier added successfully');
            }
        }
        // $validatedData['user'] = Auth::id();
        // Supplier::create($validatedData);
        return redirect()->route('supplier.view')->with('error', 'Supplier is not added');
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
                'company' => 'required|string|max:255',
                'email' => 'required|string|max:255',
            ]);

            if($validatedData){
                $supplier = Supplier::find($id);
                $supplier->name = $request->name;
                $supplier->phone = $request->phone;
                $supplier->company = $request->company;
                $supplier->email = $request->email;
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