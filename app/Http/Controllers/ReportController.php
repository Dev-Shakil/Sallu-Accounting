<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Supplier;
use App\Models\Agent;
use App\Models\Type;
use App\Models\Order;
use Illuminate\Support\Facades\Auth; // Add this line
use DateTime;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(){
        $user = Auth::id();
        $suppliers = Supplier::where([['is_delete',0],['is_active',1],['user',$user]])->get();
        $agents = Agent::where([['is_delete',0],['is_active',1],['user',$user]])->get();
        $types = Type::where([['is_delete',0],['is_active',1],['user',$user]])->get();
        $orders = Order::where([['is_delete',0],['is_active',1],['user', $user]])->get();
        // dd($suppliers);
        return view('report.index', compact('suppliers', 'agents', 'types'));
    }

    public function generate(Request $request)
    {
        // dd($request->all());
        $type = $request->input('type') ?? null;
        $agent = $request->input('agent') ?? null;
        $supplier = $request->input('supplier') ?? null;
        $start_date = $request->input('start_date') ?? null;
        $end_date = $request->input('end_date') ?? null;

        $show_profit = $request->input('show_profit') ?? null;
        $show_supplier = $request->input('show_supplier') ?? null;

        // dd($type, $agent, $supplier, $start_date, $end_date, $show_profit, $show_supplier);

        if($start_date){
            $start_date = (new DateTime($start_date))->format('Y-m-d');
        }
        if($end_date){
            $end_date = (new DateTime($end_date))->format('Y-m-d');
        }
        $user = Auth::id();

        $query = DB::table('order')
            ->where([
                ['is_active', 1],
                ['is_delete', 0],
                ['user', $user],
            ]);
            if ($type !== null) {
                $query->where('type', $type);
            }

            if ($agent !== null) {
                $query->where('agent', $agent);
            }

            if ($supplier !== null) {
                $query->where('supplier', $supplier);
            }

            if ($start_date !== null && $end_date !== null) {
                $query->whereBetween('date', [$start_date, $end_date]);
            }
            $alldata = $query->get();

        // dd($alldata, $supplier, $agent);
        $htmlTable = '';
        if($show_profit != null || $show_supplier != null) {


            if($show_profit != null && $show_supplier == null){
                $htmlTable = '<table border="1">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Type</th>
                        <th>Agent</th>
                        <th>Date</th>
                        <th>Seller</th>
                        <th>Passport</th>
                        <th>Country</th>
                        <th>Remark</th>
                        <th>Profit</th>
                        <!-- Add more columns as needed -->
                    </tr>
                </thead>
                <tbody>';

                // Loop through each record in $alldata and add a row to the table
                foreach ($alldata as $data) {
                    $htmlTable .= '<tr>
                        <td>' . $data->invoice . '</td>
                        <td>' . Type::where('id',$data->type)->value('name') . '</td>
                        <td>' . Agent::where('id',$data->agent)->value('name') . '</td>
                        <td>' . (new DateTime($data->date))->format('d-m-Y') . '</td>
                        <td>' . $data->seller . '</td>
                        <td>' . $data->passport_no . '</td>
                        <td>' . $data->country . '</td>
                        <td>' . $data->remark . '</td>
                        <td>' . $data->profit . '</td>
                        <!-- Add more cells as needed -->
                    </tr>';
                }

                // Close the HTML table
                $htmlTable .= '</tbody></table>';
            }

            elseif($show_supplier != null && $show_profit == null){
                $htmlTable = '<table border="1">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Type</th>
                        <th>Agent</th>
                        <th>Supplier</th>
                        <th>Date</th>
                        <th>Seller</th>
                        <th>Passport</th>
                        <th>Country</th>
                        <th>Remark</th>
                        <!-- Add more columns as needed -->
                    </tr>
                </thead>
                <tbody>';

                // Loop through each record in $alldata and add a row to the table
                foreach ($alldata as $data) {
                    $htmlTable .= '<tr>
                        <td>' . $data->invoice . '</td>
                        <td>' . Type::where('id',$data->type)->value('name') . '</td>
                        <td>' . Agent::where('id',$data->agent)->value('name') . '</td>
                        <td>' . Supplier::where('id',$data->supplier)->value('name') . '</td>
                        <td>' . (new DateTime($data->date))->format('d-m-Y') . '</td>
                        <td>' . $data->seller . '</td>
                        <td>' . $data->passport_no . '</td>
                        <td>' . $data->country . '</td>
                        <td>' . $data->remark . '</td>
                        <!-- Add more cells as needed -->
                    </tr>';
                }

                // Close the HTML table
                $htmlTable .= '</tbody></table>';
            }

            elseif($show_supplier != null && $show_profit != null){
                $htmlTable = '<table border="1">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Type</th>
                        <th>Agent</th>
                        <th>Supplier</th>
                        <th>Date</th>
                        <th>Seller</th>
                        <th>Passport</th>
                        <th>Country</th>
                        <th>Remark</th>
                        <th>Profit</th>
                        <!-- Add more columns as needed -->
                    </tr>
                </thead>
                <tbody>';

                // Loop through each record in $alldata and add a row to the table
                foreach ($alldata as $data) {
                    $htmlTable .= '<tr>
                        <td>' . $data->invoice . '</td>
                        <td>' . Type::where('id',$data->type)->value('name') . '</td>
                        <td>' . Agent::where('id',$data->agent)->value('name') . '</td>
                        <td>' . Supplier::where('id',$data->supplier)->value('name') . '</td>
                        <td>' . (new DateTime($data->date))->format('d-m-Y') . '</td>
                        <td>' . $data->seller . '</td>
                        <td>' . $data->passport_no . '</td>
                        <td>' . $data->country . '</td>
                        <td>' . $data->remark . '</td>
                        <td>' . $data->profit . '</td>
                        <!-- Add more cells as needed -->
                    </tr>';
                }

                // Close the HTML table
                $htmlTable .= '</tbody></table>';
            }
          
        }
        else{
            $htmlTable = '<table border="1">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Type</th>
                    <th>Agent</th>
                    <th>Date</th>
                    <th>Seller</th>
                    <th>Passport</th>
                    <th>Country</th>
                    <th>Remark</th>
                    <!-- Add more columns as needed -->
                </tr>
            </thead>
            <tbody>';

            // Loop through each record in $alldata and add a row to the table
            foreach ($alldata as $data) {
                $htmlTable .= '<tr>
                    <td>' . $data->invoice . '</td>
                    <td>' . Type::where('id',$data->type)->value('name') . '</td>
                    <td>' . Agent::where('id',$data->agent)->value('name') . '</td>
                    <td>' . (new DateTime($data->date))->format('d-m-Y') . '</td>
                    <td>' . $data->seller . '</td>
                    <td>' . $data->passport_no . '</td>
                    <td>' . $data->country . '</td>
                    <td>' . $data->remark . '</td>
                    <!-- Add more cells as needed -->
                </tr>';
            }

            // Close the HTML table
            $htmlTable .= '</tbody></table>';
        }

        return $htmlTable;
    }
}
?>