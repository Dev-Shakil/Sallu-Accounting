<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Salary;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class HrController extends Controller
{
    public function index(){
        $employees = Employee::where([
            ['user', Auth::id()], // Filter by the 'user' column matching the authenticated user's ID
            ['is_delete', 0]      // Filter by the 'is_delete' column being 0 (assuming 0 means not deleted)
        ])->get();
                // dd($employees);
        return view('hr.stuff_details', compact('employees'));
    }

    public function getStaffDetails(Request $request)
    {
        // Retrieve staff details based on the provided staff_id
        $staffId = $request->input('staff_id');
        $staff = Employee::find($staffId);

        if ($staff) {
            // Return staff details as JSON response
            return response()->json($staff);
        } else {
            // Staff not found
            return response()->json(['error' => 'Staff not found'], 404);
        }
    }
    
    public function salary_index(){

        $employees = Employee::where([
            ['user', Auth::id()], // Filter by the 'user' column matching the authenticated user's ID
            ['is_delete', 0]      // Filter by the 'is_delete' column being 0 (assuming 0 means not deleted)
        ])->get();

        $methods = Transaction::where('user', Auth::id())->get();

        $salaries = Salary::where([
            ['user', Auth::id()], // Filter by the 'user' column matching the authenticated user's ID
        ])->paginate(10);

        $lastSalary = Salary::orderBy('id', 'desc')->first();
        $lastSalaryId = $lastSalary ? $lastSalary->id : null;
        $nextID = $lastSalaryId +1;
        // dd($nextID);
        return view('hr.paysalary', compact('salaries', 'methods', 'employees', 'nextID'));
    }
    public function payslip($id){
        // dd($id);

        $employees = Employee::where([
            ['user', Auth::id()], // Filter by the 'user' column matching the authenticated user's ID
            ['is_delete', 0]      // Filter by the 'is_delete' column being 0 (assuming 0 means not deleted)
        ])->get();
        // $employee = Employee::findOrFail($id);
        $methods = Transaction::where('user', Auth::id())->get();

        $salary = Salary::where([
            ['user', Auth::id()],['id',$id] // Filter by the 'user' column matching the authenticated user's ID
        ])->get()->first();
        $employee = Employee::findOrFail($salary->employee);
        
        // dd($nextID);
        return view('hr.voucher', compact('salary', 'methods', 'employee', ));
    }

    

    public function store(Request $request){
        if(Auth::user()){
            $employee = new Employee();
      
            $employee->name = $request->employeeName;
            $employee->designation = $request->designation;
            $employee->phone = $request->mobileNumber;
            $employee->email = $request->email;
            $employee->address = $request->address;
            $employee->salary = $request->salary;
            $employee->user = Auth::id();
            
            $permissionsString = implode(',', $request->permissions);
            // dd($permissionsString);
            $employee->permission = $permissionsString;
            $employee->password = md5($request->password);
            $employee->save();
    
            return redirect()->route('stuff_details.view')->with('success', 'Employee added successfully');
        }
        else{
            return view('welcome');
        }
       
    }

    public function salary_store(Request $request){
        // dd($request->all());
        $salary = new Salary();
      
        $salary->date = $request->payment_date;
        $salary->ref_id = $request->ref_no;
        $salary->amount = $request->salary_amount;
        $salary->month = $request->month;
        $salary->year = $request->year;
        $salary->employee = $request->staff;
        $salary->method = $request->mode_of_payment;
        $salary->remarks = $request->remarks;
        $salary->user = Auth::id();

        $transaction = Transaction::where('id', $request->mode_of_payment)->first();

        if ($transaction) {
            $transaction->amount = max(0, $transaction->amount - $request->salary_amount);
            $transaction->save();
        } else {
           
            return redirect()->route('pay_salary.view')->with('error', 'Error Occured');
        }
        
        $salary->save();
        return redirect()->route('pay_salary.view')->with('success', 'Salary added successfully');
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        return response()->json($employee);
    }
    

    public function salary_edit($id)
    {
        $employee = Employee::findOrFail($id);
        return response()->json($employee);
    }
    
    public function update(Request $request)
    {
        // dd($request->all());
        try {
            // Enable query logging
            DB::enableQueryLog();
        
            // Retrieve the airline record to update
            $employee = Employee::findOrFail($request->empid);
        
           
            // Update the attributes of the e$employee record
            $employee->name = $request->employeeName;
            $employee->designation = $request->designation;
            $employee->phone = $request->mobileNumber;
            $employee->email = $request->email;
            $employee->address = $request->address;
            $employee->salary = $request->salary;
        
            $permissionsString = implode(',', $request->permissions);
            // dd($permissionsString);
            $employee->permission = $permissionsString;
            // Save the updated airline record
            $employee->save();
        
            // Get the executed queries from the query log
            $queries = DB::getQueryLog();
            // dd($queries); // Check the executed queries
        
            return redirect()->route('stuff_details.view')->with('success', 'Employee updated successfully');
        } catch (\Exception $e) {
            // Handle any errors that occur during the update process
            return redirect()->back()->with('error', 'Failed to update Employee: ' . $e->getMessage());
        }
        
        
    }
    public function salary_update(Request $request)
    {
        // dd($request->all());
        try {
            // Enable query logging
            DB::enableQueryLog();
        
            // Retrieve the airline record to update
            $employee = Employee::findOrFail($request->empid);
        
           
            // Update the attributes of the e$employee record
            $employee->name = $request->employeeName;
            $employee->designation = $request->designation;
            $employee->phone = $request->mobileNumber;
            $employee->email = $request->email;
            $employee->address = $request->address;
            $employee->salary = $request->salary;
        
            // Save the updated airline record
            $employee->save();
        
            // Get the executed queries from the query log
            $queries = DB::getQueryLog();
            // dd($queries); // Check the executed queries
        
            return redirect()->route('stuff_details.view')->with('success', 'Employee updated successfully');
        } catch (\Exception $e) {
            // Handle any errors that occur during the update process
            return redirect()->back()->with('error', 'Failed to update Employee: ' . $e->getMessage());
        }
        
        
    }

    public function delete($id)
    {
        DB::enableQueryLog();
        
        // Retrieve the airline record to update
        $employee = Employee::findOrFail($id);
    
        // Ensure that the ID attribute is set correctly
        $employee->is_delete = 1;
        
        $queries = DB::getQueryLog();
        // dd($queries); // Check the executed queries
        
        if ($employee->save()) {
            return redirect()->route('stuff_details.view')->with('success', 'Employee deleted successfully');
        } else {
            return redirect()->route('stuff_details.view')->with('error', 'Failed to delete Employee');
        }
    }

    public function salary_delete($id)
    {
        DB::enableQueryLog();
        
        // Retrieve the airline record to update
        $employee = Employee::findOrFail($id);
    
        // Ensure that the ID attribute is set correctly
        $employee->is_delete = 1;
        
        $queries = DB::getQueryLog();
        // dd($queries); // Check the executed queries
        
        if ($employee->save()) {
            return redirect()->route('stuff_details.view')->with('success', 'Employee deleted successfully');
        } else {
            return redirect()->route('stuff_details.view')->with('error', 'Failed to delete Employee');
        }
    }

    


}
