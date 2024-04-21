<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Airline;
use Illuminate\Support\Facades\DB;


class AirlineController extends Controller
{
    public function index(){
        $airlines = Airline::get();
        // dd($airlines);
        return view('airlines.index', compact('airlines'));
    }
    public function findAirlineFree(Request $request)
    {
        $airline_code = $request->code;
        $airline_name = '';
        $isFree = !Airline::where('ID', $airline_code)->exists();
        if (!$isFree) {
            $airline_name = Airline::where('ID', $airline_code)->value('Full');
        }
        return response()->json(['is_free' => $isFree, 'airline_name' => $airline_name]);
    }
    public function store(Request $request){
        // dd($request->all());
        $airline = new Airline();
        $airline->ID = $request->code;
        $airline->Short = $request->short_name;
        $airline->Full = $request->full_name;
        $airline->save();
        return redirect()->route('airline.view')->with('success', 'Airline added successfully');
    }
    public function edit($id)
    {
        $id = decrypt($id);
        $airline = Airline::findOrFail($id);
        return view('airlines.edit', compact('airline'));
    }
    public function update($id, Request $request)
    {
        try {
            // Enable query logging
            DB::enableQueryLog();
        
            // Retrieve the airline record to update
            $airline = Airline::findOrFail($id);
        
            // Ensure that the ID attribute is set correctly
            $airline->id = $id;
        
            // Update the attributes of the airline record
            $airline->Short = $request->short_name;
            $airline->Full = $request->full_name;
        
            // Save the updated airline record
            $airline->save();
        
            // Get the executed queries from the query log
            $queries = DB::getQueryLog();
            // dd($queries); // Check the executed queries
        
            return redirect()->route('airline.view')->with('success', 'Airline updated successfully');
        } catch (\Exception $e) {
            // Handle any errors that occur during the update process
            return redirect()->back()->with('error', 'Failed to update airline: ' . $e->getMessage());
        }
        
        
    }
    public function delete($id)
    {
        DB::enableQueryLog();
        
        // Retrieve the airline record to update
        $airline = Airline::findOrFail($id);
    
        // Ensure that the ID attribute is set correctly
        $airline->id = $id;
        $airline->delete();
        $queries = DB::getQueryLog();
        // dd($queries); // Check the executed queries
        
        if ($airline->delete()) {
            return redirect()->route('airline.view')->with('success', 'Airline deleted successfully');
        } else {
            return redirect()->route('airline.view')->with('error', 'Failed to delete airline');
        }
    }

    


}
