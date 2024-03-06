<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Type;
use Illuminate\Support\Facades\Auth; // Add this line


class TypeController extends Controller
{
    // public function index()
    // {
    //     $user = Auth::id();
    //     $types = Type::where([['is_delete',0],['is_active',1],['user',$user]])->paginate(2);
    //     return view('type/index', compact('types'));
    // }
    public function index(Request $request)
    {
        $user = Auth::id();
        $query = Type::where([['is_delete',0],['is_active',1],['user',$user]]);

        // Add search functionality
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        $types = $query->paginate(10); // Change 10 to the number of items you want per page

        return view('type.index', compact('types'));
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',

        ]);
        $validatedData['user'] = Auth::id();
        Type::create($validatedData);
        return redirect()->route('type.index')->with('success', 'Type added successfully');
    }

    public function edit($id)
    {
        $id = decrypt($id);
        $type = Type::findOrFail($id);
        return view('type.edit', compact('type'));
    }
    public function update(Request $request, $id)
    {
        // dd($request->all(), $id);
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        if ($validatedData) {
            $type = Type::find($id);
            $type->name = $request->name;
            if ($type->save()) {
                return redirect()->route('type.index')->with('success', 'Type updated successfully');
            } else {
                return redirect()->route('type.index')->with('error', 'Type updated failed');
            }
        }

        return redirect()->route('type.index')->with('error', 'Type updated failed');
    }

    public function delete($id)
    {
        $type = Type::findOrFail($id);
        $type->is_delete = 1;
        if ($type->save()) {
            return redirect()->route('type.index')->with('success', 'Type deleted successfully');
        } else {
            return redirect()->route('type.index')->with('error', 'Type deleted failed');
        }
        return redirect()->route('type.index')->with('error', 'Type deleted failed');
    }
}
