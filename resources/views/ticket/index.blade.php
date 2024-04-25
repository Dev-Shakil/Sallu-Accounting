<x-app-layout>
    <style type="text/css">
        .select2-selection--single{
            height:32px !important;
        }
    </style>
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h2 class="text-2xl py-4 flex xl:w-3/4 lg:w-4/4 w-full mx-auto font-bold
    px-2  text-gray-900">
        Ticket Invoicing
    </h2>
    <div class="border-t bg-white border-gray-2 flex flex-col justify-center items-center p-6 rounded-lg shadow-md xl:w-3/4 lg:w-4/4 w-full mx-auto my-2">

        <form class="w-full " id="ticket_form">
            @csrf
            <div class="grid grid-cols-2 w-full gap-3">
            
                <div class="w-full px-4 mb-2 flex items-center">
                    <label for="invoice_no" class="block w-[50%]">Invoice No.</label>
                    <input type="text" id="invoice_no"
                        class="text-center text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        name="invoice_no" readonly>
                </div>
                <div class="w-full px-4 mb-2 flex items-center">
                    <label for="agent_name" class="block w-[50%]">Agent
                        Name</label>

                    <select name="agent" id="agent"
                        class="bg-gray-50 border select2 border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block max-w-[60%] p-1">
                        <option value="">Select Agent</option>
                        @foreach ($agents as $agent)
                            <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                        @endforeach
                    </select>

                </div>

            
                <div class="w-full px-4 mb-2 flex items-center">
                    <label for="invoice_date" class="block w-[50%]">Invoice
                        Date</label>
                    <input type="date" id="invoice_date"
                        class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block w-full p-1"
                        name="invoice_date" value="<?php echo date('Y-m-d'); ?>">
                </div>
                <div class="w-full px-4 mb-2 flex items-center">
                    <label for="flight_date" class="w-[50%]">Flight Date</label>
                    <div class="w-full flex gap-x-2">
                        <input type="date" id="flight_date" class="bg-gray-50 md:w-[90%] border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block w-full p-1" name="flight_date">
                        <button id="toggle_return_section" class="bg-[#00959E] font-bold w-[8%] text-white text-xl rounded-xl flex justify-center items-center p-1">+</button>
                    </div>
                </div>
                
            
            
                <div class="w-full px-4 mb-2 flex items-center">
                    <label for="airline" class="w-[50%]">Airline</label>
                    <div class="flex w-full gap-x-3">
                        {{-- <input type="text" id="airlines_name"
                            class="bg-gray-50 w-[73%] border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block p-1"
                            name="airlines_name"> --}}
                            <select id="airlines_name" class="select2 bg-gray-50 w-[73%] border border-gray-300 text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block p-1" name="airlines_name">
                                <option>Select Airline</option>
                                @foreach ($airlines as $airline)
                                    <option value="{{ $airline->Full}}">{{ $airline->Full }}</option>
                                @endforeach
                            </select>
                            
                        <input type="text" id="airlines_code"
                            class="bg-gray-50 w-[23%] border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block p-1"
                            name="airlines_code">
                    </div>
                </div>
                <div id="return_section" class="w-full px-4 mb-2 items-center flex hidden">
                    <label for="return_date" class="w-[50%]">Return Date</label>
                    <input type="date" id="return_date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block w-full p-1" name="return_date">
                </div>
                
                <div class="w-full px-4 mb-2 flex items-center">
                    <label for="ticket_no" class="w-[50%]">Ticket No /
                        PNR</label>
                    <div class="flex w-full gap-x-4">
                        <input type="text" id="ticket_code"
                            class="bg-gray-50 w-[23%] border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block p-1"
                            name="ticket_code">
                        <input type="text" id="ticket_no" maxlength="10" minlength="10"
                            class="bg-gray-50 w-[73%] border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block p-1"
                            name="ticket_no">
                    </div>
                </div>
            
            
                
                <div class="w-full px-4 mb-2 flex items-center">
                    <label for="number_of_tickets" class="w-[50%]">Number of
                        Tickets</label>
                    <input type="number" id="number_of_tickets"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block w-full p-1"
                        name="number_of_tickets">
                </div>
                <div class="w-full px-4 mb-2 flex items-center">
                    <label for="pnr" class="w-[50%]">PNR</label>
                    <input type="text" id="pnr"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block w-full p-1"
                        name="pnr">
                </div>
                
            
            
            
                <div class="w-full px-4 mb-2 flex items-center">
                    <label for="passenger_name" class="w-[50%]">Passenger
                        Name</label>
                    <input type="text" id="passenger_name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block w-full p-1"
                        name="passenger_name">
                </div>
                <div class="w-full px-4 mb-2 flex items-center">
                    <label for="person" class="w-[50%]">Person</label>
                    <select id="person" class=" bg-gray-50 w-full border border-gray-300 text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block p-1" name="person">
                            <option value="adult">Adult</option>
                            <option value="child">Child</option>
                            <option value="infant">Infant</option>
                            
                    </select>
                </div>
                
                
            
            
                <div class="w-full px-4 mb-2 flex items-center">
                    <label for="class" class="w-[50%]">Class</label>
                    <div class="flex w-full gap-x-4">
                        <input type="text" id="class_code"
                                class="bg-gray-50 w-[23%] border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block p-1"
                                name="class_code">
                        <select id="class" class=" bg-gray-50 w-[73%] border border-gray-300 text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block p-1" name="class">
                                <option value="economy">Economy</option>
                                <option value="business">Business</option>
                                
                        </select>
                    </div>
                </div>
                <div class="w-full px-4 mb-2 flex items-center">
                    <label for="sector" class="w-[50%]">Sector</label>
                    <input type="text" id="sector"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block w-full p-1"
                        name="sector">
                </div>
                
                
                
                
            
            
                <div class="w-full px-4 mb-2 flex items-center">
                    <label for="flight_no" class="w-[50%]">Flight No</label>
                    <input type="text" id="flight_no"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block w-full p-1"
                        name="flight_no">
                </div>
                <div class="w-full px-4 mb-2 flex items-center">
                    <label for="supplier" class="w-[50%]">Supplier</label>

                    <select name="supplier" id="supplier"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block max-w-full select2 p-1">
                        <option value="">Select Supplier</option>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }} {{$supplier->company}}</option>
                        @endforeach
                    </select>
                </div>
            
            
                <div class="w-full px-4 mb-2 flex items-center">
                    <label for="agent_price" class="w-[50%]">Agent
                        Price</label>
                    <input type="text" id="agent_price_1"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block w-full p-1"
                        name="agent_price">
                </div>
                <div class="w-full px-4 mb-2 flex items-center">
                    <label for="supplier_price" class="w-[50%]">Supplier
                        Price</label>
                    <input type="text" id="supplier_price"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block w-full p-1"
                        name="supplier_price">
                </div>
            
            
                <div class="w-full px-4 mb-2 flex items-center">
                    <label for="stuff" class="w-[50%]">Stuff</label>
                    <input type="text" id="stuff"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block w-full p-1"
                        name="stuff">
                </div>
                
                <div class="w-full px-4 mb-2 flex items-center">
                    <label for="remark" class="w-[50%]">Remark</label>
                    <textarea id="remark"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block w-full p-1"
                        name="remark"></textarea>
                </div>

            
            </div>
            <div class=" flex-wrap gap-x-10 -mx-4 mb-4 hidden">
                <div class="w-full md:w-[48%] px-4 mb-2 flex items-center">
                    <label for="discount" class="block w-full md:w-[40%]  text-gray-700 text-sm mb-2">AIT</label>
                    <input type="text" id="aitticket"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block w-full p-1"
                        name="ait">
                </div>
                <div class="w-full md:w-[48%] px-4 mb-2 flex items-center">
                    <label for="remark" class="block w-full md:w-[40%]  text-gray-700 text-sm mb-2">AIT
                        Amount</label>
                    <input type="text" id="aitticket_amount"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block w-full p-1"
                        name="ait_amount">
                </div>

            </div>
            

        <div class="bg-[#F4A460D1] w-full my-2 rounded-lg p-2" id="profit_show">
            Net Profit - 00
        </div>
        <div class="flex justify-center my-4 gap-x-8">
            <div class="font-semibold">
                <input type="checkbox" id="addGDS" name="addGDS" onchange="toggleGdsVisibility()" />
                <label for="addGDS">Add GDS</label>
            </div>

            
        </div>

        <div class="w-full my-4" id="receive_payment">
            
            <div class="flex flex-wrap gap-x-6 mb-4">
                <div class="w-full md:w-[48%] px-4 mb-2 flex items-center">
                    <label for="reff_no" class="block w-full md:w-[40%] text-gray-700 text-sm mb-2">Ref No</label>
                    <input type="text" id="reff_no"
                        class=" text-gray-900 text-sm bg-gray-50 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 block w-full p-1"
                        name="reff_no">
                </div>
                <div class="w-full md:w-[48%] px-4 mb-2 flex items-center">
                    <label for="amount" class="block w-full md:w-[40%]  text-gray-700 text-sm mb-2">Amount</label>
                    <input type="text" id="amount"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block w-full p-1"
                        name="amount">
                </div>
            </div>

            <div class="flex flex-wrap gap-x-6 mb-4">
                <div class="w-full md:w-[48%] px-4 mb-2 flex items-center">
                    <label for="agent_supplier"
                        class="block w-full md:w-[40%] text-gray-700 text-sm mb-2">Agent/Supplier</label>
                    
                    <select id="agent_supplier" name="agent_supplier"
                        class=" text-gray-900 text-sm bg-gray-50 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 block w-full p-1"
                        required>
                        <option value="">Select One</option>
                        <option value="agent">Agent</option>
                        <option value="supplier">Supplier</option>
                    </select>
                </div>
                <div class="w-full md:w-[48%] px-4 mb-2 flex items-center">
                    <label for="amount" class="block w-full md:w-[40%]  text-gray-700 text-sm mb-2">Select
                        Candidate</label>
                    
                    <select id="agent_supplier_id" name="agent_supplier_id"
                        class=" text-gray-900 text-sm bg-gray-50 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 block w-full p-1"
                        required>
                        <option value="">Select One</option>

                    </select>
                </div>
            </div>

            <div class="flex flex-wrap gap-x-6 -mx-4 mb-4">
                <div class="w-full md:w-[48%] px-4 mb-2 flex items-center">
                    <label for="payment_mode" class="block w-full md:w-[40%]  text-gray-700 text-sm mb-2">Mode Of
                        Payment</label>
                    <input type="text" id="payment_mode"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block w-full p-1"
                        name="payment_mode">
                </div>
                <div class="w-full md:w-[48%] px-4 mb-2 flex items-center">
                    <label for="remark" class="block w-full md:w-[40%]  text-gray-700 text-sm mb-2">Remark</label>
                    <textarea id="remark"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block w-full p-1"
                        name="remark"></textarea>
                </div>
            </div>
           
        </div>


        <div class="my-4 w-full" id="gds">
            <div class="flex flex-wrap gap-x-2 md:gap-x-6 mb-4">
                <div class="w-full md:w-[48%] px-4 mb-2 flex items-center">
                    <label for="fare" class="block w-full md:w-[40%] text-gray-700 text-sm mb-2">Fare</label>
                    <input type="text" id="fare"
                        class=" text-gray-900 text-sm bg-gray-50 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 block w-full p-1"
                        name="fare">
                </div>
                <div class="w-full md:w-[48%] px-4 mb-2 flex items-center">
                    <label for="commission"
                        class="block w-full md:w-[40%]  text-gray-700 text-sm mb-2">Commission</label>
                    <input type="text" id="commission"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block w-full p-1"
                        name="commission">
                </div>
            </div>

            <div class="flex flex-wrap gap-x-6 mb-4">
                <div class="w-full md:w-[48%] px-4 mb-2 flex items-center">
                    <label for="tax" class="block w-full md:w-[40%]  text-gray-700 text-sm mb-2">TAX</label>
                    <input type="text" id="tax"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block w-full p-1"
                        name="tax">
                </div>
                <div class="w-full md:w-[48%] px-4 mb-2 flex items-center">
                    <label for="ait_amount" class="block w-full md:w-[40%]  text-gray-700 text-sm mb-2">AIT
                        Amount</label>
                    <input type="text" id="ait_amount"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block w-full p-1"
                        name="ait_amount">
                </div>
            </div>
            <div class="flex flex-wrap gap-x-6 mb-4">
                <div class="w-full md:w-[48%] px-4 mb-2 flex items-center">
                    <label for="ait" class="block w-full md:w-[40%]  text-gray-700 text-sm mb-2">AIT</label>
                    <input type="text" id="ait"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block w-full p-1"
                        name="ait">
                </div>
                <div class="w-full md:w-[48%] px-4 mb-2 flex items-center">
                    <label for="service_charge" class="block w-full md:w-[40%]  text-gray-700 text-sm mb-2">Service
                        Charge</label>
                    <input type="text" id="service_charge"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block w-full p-1"
                        name="service_charge">
                </div>
            </div>
            <div class="flex flex-wrap gap-x-6 mb-4">
                <div class="w-full md:w-[48%] px-4 mb-2 flex items-center">
                    <label for="agent_price" class="block w-full md:w-[40%]  text-gray-700 text-sm mb-2">Agent
                        Price</label>
                    <input type="text" id="agent_price"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block w-full p-1"
                        name="agent_price">
                </div>
                <div class="w-full md:w-[48%] px-4 mb-2 flex items-center">
                    <label for="gds_payment" class="block w-full md:w-[40%]  text-gray-700 text-sm mb-2">GDS
                        Payment</label>
                    <input type="text" id="gds_payment"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block w-full p-1"
                        name="gds_payment">
                </div>
            </div>
        </div>


        <div id="refundForm" method="post" style="display: none;">
            
        </div>

        <div class="col-span-2 flex justify-end">
            <button type="submit" id="add_ticket"
                class="bg-black text-xl hover:bg-blue-700 mr-5 text-white font-bold py-2 px-16 rounded">Submit</button>
        </div>

    </form>
    </div>


    
    <table class="table-fixed mx-4 border rounded-lg overflow-hidden table table-striped table-hover"
        id="ticket_table">
        <thead class="">
            <tr class="border-b bg-[#7CB0B2]">
                <th class="w-1/6 px-4 py-2 text-left text-gray-900 font-medium">Invoice Date</th>
                <th class="w-1/6 px-4 py-2 text-left text-gray-900 font-medium">Invoice</th>
                <th class="w-1/6 px-4 py-2 text-left text-gray-900 font-medium">Ticket No</th>
                <th class="w-1/6 px-4 py-2 text-left text-gray-900 font-medium">Passenger</th>
                <th class="w-1/6 px-4 py-2 text-left text-gray-900 font-medium">Flight Date</th>

                <th class="w-1/6 px-4 py-2 text-left text-gray-900 font-medium">Airline</th>
                <th class="w-1/6 px-4 py-2 text-left text-gray-900 font-medium">Agent</th>

                <th class="w-1/6 px-4 py-2 text-left text-gray-900 font-medium">Supplier</th>
                <th class="w-1/6 px-4 py-2 text-left text-gray-900 font-medium">Agent Price</th>

                <th class="w-1/6 px-4 py-2 text-left text-gray-900 font-medium">Supplier Price</th>
                <th class="w-1/6 px-4 py-2 text-left text-gray-900 font-medium">Remark</th>
                <th class="w-1/6 px-4 py-2 text-left text-gray-900 font-medium">Action</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($tickets as $ticket)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-2 py-2 text-gray-700">{{ (new DateTime($ticket->invoice_date))->format('d/m/Y') }}
                    </td>
                    <td class="px-2 py-2 text-gray-700">{{ $ticket->invoice }}</td>
                    
                    <td class="px-2 py-2 text-gray-700">{{ $ticket->ticket_code }}-{{ $ticket->ticket_no }}</td>
                    <td class="px-2 py-2 text-gray-700">{{ $ticket->passenger }}</td>

                    <td class="px-2 py-2 text-gray-700">{{ (new DateTime($ticket->flight_date))->format('d/m/Y') }}
                    </td>
                    <td class="px-2 py-2 text-gray-700">{{ $ticket->airline_code }}-{{ $ticket->airline_name }}</td>
                    <td class="px-2 py-2 text-gray-700">{{ $ticket->agent }}</td>

                    <td class="px-2 py-2 text-gray-700">{{ $ticket->supplier }}<br></td>
                    <td class="px-2 py-2 text-center text-gray-700">{{ $ticket->agent_price }}</td>
                    <td class="px-2 py-2 text-center text-gray-700">{{ $ticket->supplier_price }}</td>


                    <td class="px-2 py-2 text-gray-700">{{ $ticket->remark }}</td>
                    <td class="px-2 py-2 text-gray-700 flex items-center justify-around">
                        <a href="{{ route('ticket_edit', ['id' => $ticket->id]) }}"
                            class=" mr-1">
                            <i class="fa fa-pencil fa-fw text-xl"></i>
                        </a>
                        <a href="{{ route('ticket_view', ['id' => $ticket->id]) }}"
                            class=" mr-1">
                            <i class="fa fa-eye fa-fw text-xl"></i>
                        </a>
                        <a href="#" onclick="confirmDelete('{{ route('ticket.delete', ['id' => $ticket->id]) }}')"
                          class=" mr-1">
                          <i class="fa fa-trash fa-fw text-xl"></i>
                       </a>
                        {{-- <a href="{{ route('ticket_print', ['id' => $ticket->id]) }}" class="text-red-500 hover:text-red-700">
                    <i class="fas fa-print"></i> Print
                </a> --}}
                    </td>

                </tr>
            @endforeach

        </tbody>
    </table>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog " role="document" style="max-width: 1200px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal Title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="tableContainer"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
      function confirmDelete(deleteUrl) {
        // Display a confirmation dialog
        const isConfirmed = window.confirm("Are you sure you want to delete?");

        // If the user confirms, proceed with the delete action
        if (isConfirmed) {
            window.location.href = deleteUrl;
        }
    }
        

        // function generateRandomInvoiceNumberReceivePayment() {
        //     const prefix = 'RP-';
        //     const length = 8;

        //     // Generate a random alphanumeric string of the specified length
        //     const randomString = Math.random().toString(36).substr(2, length).toUpperCase();

        //     return `${prefix}${randomString}`;
        // }
        // $('#reff_no').val(generateRandomInvoiceNumberReceivePayment());

        var received_payment = document.getElementById('receive_payment');
        var gds = document.getElementById('gds');
        // var refunddiv = document.getElementById('refunddiv');
        //   refunddiv.style.display = 'none';
        received_payment.style.display = 'none';
        gds.style.display = 'none';
        // Function to toggle the visibility of the received_payment
        // function toggleFormVisibility() {
        //     var received_payment = document.getElementById('receive_payment');
        //     var checkbox = document.getElementById('receivePayment');
        //     received_payment.style.display = 'none';
        //     // Toggle the visibility of the received_payment based on checkbox state
        //     if (checkbox.checked) {
        //         received_payment.style.display = 'block';
        //     } else {
        //         received_payment.style.display = 'none';
        //     }
        // }

        function toggleGdsVisibility() {
            var gds = document.getElementById('gds');
            var gds_checkbox = document.getElementById('addGDS');
            gds.style.display = 'none';
            // Toggle the visibility of the received_payment based on checkbox state
            if (gds_checkbox.checked) {
                gds.style.display = 'block';
            } else {
                gds.style.display = 'none';
            }
        }

        // document.addEventListener("DOMContentLoaded", function() {
        //     toggleRefundVisibility();
        // });

        // function toggleRefundVisibility() {
        //     var refunddiv = document.getElementById('refunddiv');
        //     var refundCheckbox = document.getElementById('refundCheckbox');
        //     var refundForm = document.getElementById('refundForm');
        //     if (refundCheckbox.checked) {
        //         refundForm.submit();
        //     }
        // }
    </script>



    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            $('.select2').select2();
            $('.datepicker').datepicker({
                // autoclose: true
            });
            $('#ticket_table').DataTable();

            // function generateRandomString() {
            //     return new Promise((resolve, reject) => {
            //         $.ajax({
            //             url: '/get-last-id', // Replace with the actual URL to fetch the last ID
            //             method: 'GET',
            //             success: function(response) {
            //                 let lastId = response.lastId;
            //                 lastId = parseInt(lastId) + 1;

            //                 // Format the lastId with leading zeros to make it 6 digits
            //                 const formattedLastId = lastId.toString().padStart(6, '0');

            //                 const randomString = `INVT-${formattedLastId}`;

            //                 // Resolve the promise with the generated random string
            //                 resolve(randomString);
            //             },
            //             error: function(error) {
            //                 console.error('Error fetching last ID:', error);
            //                 // Reject the promise with the error
            //                 reject(error);
            //             }
            //         });
            //     });
            // }

            // // Example usage:
            // generateRandomString()
            //     .then(randomString => {
            //         $('#invoice_no').val(randomString);
            //         // Do something with the random string here
            //     })
            //     .catch(error => {
            //         console.error('Failed to generate random string:', error);
            //     });

            function generateRandomString() {
                return new Promise((resolve, reject) => {
                    $.ajax({
                        url: '/get-last-id', // Replace with the actual URL to fetch the last ID
                        method: 'GET',
                        success: function(response) {
                            let invoice = response.invoice;
                            
                            resolve(invoice);
                        },
                        error: function(error) {
                            console.error('Error fetching last ID:', error);
                            // Reject the promise with the error
                            reject(error);
                        }
                    });
                });
            }

            // Example usage:
            generateRandomString()
                .then(randomString => {
                    $('#invoice_no').val(randomString);
                    // Do something with the random string here
                })
                .catch(error => {
                    console.error('Failed to generate random string:', error);
                });


            $('#ticket_code').on('change', function() {
                var ticketCodeValue = $(this).val();

                // Make an AJAX call
                $.ajax({
                    url: '/search_airline', // Replace with the actual endpoint URL
                    method: 'POST', // Specify the HTTP method (POST, GET, etc.)
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        ticketCode: ticketCodeValue
                    }, // Data to be sent to the server
                    dataType: 'json', // Expected data type of the response
                    success: function(response) {
                        if (response.message == 'Success') {
                            $('#airlines_name').val(response.airline.Full).trigger('change');

                            $('#airlines_code').val(response.airline.Short);
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(error) {
                        // Handle errors during the AJAX call
                        console.error('Error:', error);
                    }
                });
            });

            $('#airlines_name').on('change', function() {
                var airlinesname = $(this).val();
                
                $.ajax({
                    url: '/search_airline', // Replace with the actual endpoint URL
                    method: 'POST', // Specify the HTTP method (POST, GET, etc.)
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        ticketCode: airlinesname
                    }, // Data to be sent to the server
                    dataType: 'json', // Expected data type of the response
                    success: function(response) {
                        if (response.message == 'Success') {
                            $('#airlines_name').val(response.airline.Full);
                            $('#airlines_code').val(response.airline.Short);
                            $('#ticket_code').val(response.airline.ID);
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(error) {
                        // Handle errors during the AJAX call
                        console.error('Error:', error);
                    }
                });
            });


            var fare, commission, tax, ait, gds, service_charge;
            var ait_amount = 3830;
            $('#fare').on('change', function() {
                fare = parseFloat(this.value);

                if (!isNaN(fare)) {
                    var commissionPercentage = 7;
                    commission = (fare * commissionPercentage) / 100;
                    commission = Math.floor(commission);
                    // var afterCommission = fare - commission;
                    $('#commission').val(commission);

                }
            });

            $('#tax').on('change', function() {
                tax = this.value;
                $('#ait_amount').val(ait_amount);
                fare = parseFloat(fare);
                tax = parseFloat(tax); // replace with the actual source of tax value
                ait_amount = parseFloat(ait_amount); // replace with the actual source of ait_amount value

                var total = fare + tax - ait_amount;
                ait = parseFloat((total * 0.3) / 100);
                ait = Math.floor(ait);
                total = parseFloat(total);
                var gds_payment = fare + tax + ait - commission;
                gds = gds_payment;
                $('#ait').val(ait);
                $('#aitticket').val(ait);
                $('#aitticket_amount').val(ait_amount);
                $('#gds_payment').val(gds_payment);
                $('#supplier_price').val(gds_payment);

            });

            $('#service_charge').on('change', function() {
                service_charge = this.value;
                service_charge = parseFloat(service_charge);
                // console.log(service_charge);
                if (!isNaN(service_charge)) {
                    var gds_payment = gds + service_charge;
                    $('#gds_payment').val(gds_payment);
                    $('#supplier_price').val(gds_payment);
                } else {
                    service_charge = 0;
                    var gds_payment = gds + service_charge;
                    $('#gds_payment').val(gds_payment);
                    $('#supplier_price').val(gds_payment);
                }

            });
            // var today = new Date();

            // // Format the date as "day/month/year"
            // var formattedDate = today.getDate() + '/' + (today.getMonth() + 1) + '/' + today.getFullYear();

            // // Set the value of the input field
            // document.getElementById('invoice_date').value = formattedDate;

            $('#agent_price').on('change', function() {
                $('#agent_price_1').val(this.value);
            });

            function manipulateString(inputString, variable) {
                if (variable >= 0 && variable <= 9) {
                    var lastTwoChars = inputString.slice(-2);
                    var result = inputString.slice(0, -2) + (parseInt(lastTwoChars) + variable);
                    return result;
                } else {
                    console.error('Invalid variable. It should be between 0 and 9.');
                    return null;
                }
            }
            
            $('#number_of_tickets').on('change', function(event) {
                var number_of_tickets = parseInt($('#number_of_tickets').val());
                if (number_of_tickets > 1) {
                    $('#passenger_name').prop('disabled', true);
                    $('#passenger_name').addClass('bg-gray-300');// Change background color
                } else {
                    $('#passenger_name').prop('disabled', false);
                    $('#passenger_name').removeClass('bg-gray-300'); // Reset background color
                }
            });

            $('#add_ticket').on('click', function(event) {
                event.preventDefault();
                var agent = $('#agent').val();
                var passenger_name = $('#passenger_name').val();
                var supplier = $('#supplier').val();
                var invoice_date = $('#invoice_date').val();
                var flight_date = $('#flight_date').val();
                var return_date = $('#return_date').val();
                var person = $('#person').val();
                var classOpt = $('#class').val();
                var class_code = $('#class_code').val();
                var sector = $('#sector').val();
                var flight_no = $('#flight_no').val();
                var ticket_code = $('#ticket_code').val();
                var pnr = $('#pnr').val();
                var ticket_no = $('#ticket_no').val();
                var airlines_name = $('#airlines_name').val();
                var airlines_code = $('#airlines_code').val();
                var stuff = $('#stuff').val();
                var agent_price_1 = $('#agent_price_1').val();
                var supplier_price = $('#supplier_price').val();
                var discount = $('#discount').val();
                var remark = $('#remark').val();
                var number_of_tickets = $('#number_of_tickets').val();
                var invoice_no = $('#invoice_no').val();
                var aitticket = $('#aitticket').val();

                // console.log(invoice_Date)
                var agent_price_1 = parseFloat($('#agent_price_1').val());
                var supplier_price = parseFloat($('#supplier_price').val());
                
                if (!isNaN(agent_price_1) && !isNaN(supplier_price)) {
                    var profit = agent_price_1 - supplier_price;
                    var tkno = parseInt(number_of_tickets);
                    var total_profit = profit * tkno;
                    console.log(agent_price_1, supplier_price, profit, total_profit, tkno);

                    // Update the content of the div with the calculated total_profit
                    $('#profit_show').html('Net Profit - ' + total_profit);
                } else {
                    alert('Invalid input. Please enter valid numeric values.');
                }


                if (
                    agent &&
                    supplier &&
                    invoice_date &&
                    flight_date &&
                    flight_no &&
                    (ticket_code || ticket_no) && // either ticket code or ticket no should be available
                    (airlines_name || airlines_code) && // either airlines name or code should be available
                    number_of_tickets>1 &&
                    agent_price_1 && sector && stuff &&
                    supplier_price && invoice_no && pnr && person && classOpt && class_code && return_date
                ) {
                    var csrfToken = "{{ csrf_token() }}";
                    var tableHtml =
                        '<form id="tickets_form" method="post" action="{{ route('addticket.store') }}">';
                    tableHtml += '<input type="hidden" name="_token" value="' + csrfToken + '">';
                    tableHtml += '<table class="table">';
                    tableHtml += '<thead>';
                    tableHtml += '<tr>';
                    tableHtml += '<th>Ticket No</th>';
                    tableHtml += '<th>Invoice Date</th>';
                    tableHtml += '<th>Flight Date</th>';
                    tableHtml += '<th>Flight No</th>';
                    tableHtml += '<th>Ticket Code/No</th>';
                    tableHtml += '<th>Airlines Name/Code</th>';
                    tableHtml += '<th>Pessanger</th>';
                    tableHtml += '<th>Agent Price</th>';
                    tableHtml += '<th>Supplier Price</th>';
                    tableHtml += '<th>Invoice No</th>';
                    // Add more headers as needed
                    tableHtml += '</tr>';
                    tableHtml += '</thead>';
                    tableHtml += '<tbody>';

                    // Populate table rows with data
                    for (var i = 0; i < parseInt(number_of_tickets); i++) {
                        tableHtml += '<tr>';
                        tableHtml += '<td>' + '<input type="text" name="ticket_no[]" id="ticket_no_' + i +
                            '" value="' + manipulateString(ticket_no, i) + '"></td>';
                        tableHtml += '<td>' + invoice_date + '</td>';
                        tableHtml += '<td>' + flight_date + '</td>';
                        tableHtml += '<td>' + flight_no + '</td>';
                        tableHtml += '<td>' + (ticket_code || ticket_no) + '</td>';
                        tableHtml += '<td>' + (airlines_name || airlines_code) + '</td>';
                        tableHtml += '<td>' +
                            '<input type="text" class="form-control" name="passenger_name[]" id="passenger_name_' +
                            i + '"></td>';
                        tableHtml += '<td>' + agent_price_1 + '</td>';
                        tableHtml += '<td>' + supplier_price + '</td>';
                        tableHtml += '<td>' + invoice_no + '</td>';
                        // Add more cells as needed
                        tableHtml += '</tr>';
                    }
                    tableHtml += '<input type="hidden" name="agent" value="' + agent + '">';
                    tableHtml += '<input type="hidden" name="pnr" value="' + pnr + '">';
                    tableHtml += '<input type="hidden" name="supplier" value="' + supplier + '">';
                    tableHtml += '<input type="hidden" name="agent_price" value="' + agent_price_1 + '">';
                    tableHtml += '<input type="hidden" name="supplier_price" value="' + supplier_price +
                        '">';
                    tableHtml += '<input type="hidden" name="invoice_date" value="' + invoice_date + '">';
                    tableHtml += '<input type="hidden" name="flight_date" value="' + flight_date + '">';
                    tableHtml += '<input type="hidden" name="invoice_no" value="' + invoice_no + '">';
                    tableHtml += '<input type="hidden" name="flight_no" value="' + flight_no + '">';
                    tableHtml += '<input type="hidden" name="return_date" value="' + return_date + '">';
                    tableHtml += '<input type="hidden" name="class" value="' + classOpt + '">';
                    tableHtml += '<input type="hidden" name="class_code" value="' + class_code + '">';
                    tableHtml += '<input type="hidden" name="person" value="' + person + '">';
                    tableHtml += '<input type="hidden" name="sector" value="' + sector + '">';
                    tableHtml += '<input type="hidden" name="ticket_code" value="' + ticket_code + '">';
                    // tableHtml += '<input type="hidden" name="ticket_no" value="'+ ticket_no +'">';
                    tableHtml += '<input type="hidden" name="airlines_name" value="' + airlines_name + '">';
                    tableHtml += '<input type="hidden" name="airlines_code" value="' + airlines_code + '">';
                    tableHtml += '<input type="hidden" name="remark" value="' + remark + '">';
                    tableHtml += '<input type="hidden" name="stuff" value="' + stuff + '">';
                    tableHtml += '<input type="hidden" name="ait" value="' + aitticket + '">';
                    tableHtml += '<input type="hidden" name="ait_amount" value="' + aitticket + '">';
                    tableHtml += '</tbody>';
                    tableHtml += '</table>';
                    tableHtml += '<td colspan="10" class="text-center">';
                    tableHtml +=
                        '<button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">';
                    tableHtml += 'Submit';
                    tableHtml += '</button>';
                    tableHtml += '</td>';
                    tableHtml += '</form>';
                    // Append the table to the modal or wherever you want to display it
                    $('#tableContainer').html(tableHtml);

                    $('#myModal').modal('show');
                } 
                else if(
                agent && stuff &&
                supplier &&
                invoice_date &&
                flight_date &&
                flight_no &&
                (ticket_code || ticket_no) && // either ticket code or ticket no should be available
                (airlines_name || airlines_code) && // either airlines name or code should be available
                number_of_tickets == 1 &&
                agent_price_1 && sector &&
                supplier_price && invoice_no && pnr && person && classOpt && class_code && return_date)
                {
                  var csrfToken = "{{ csrf_token() }}";
                  var dataToSend = {
                            passenger_name,
                            agent,
                            supplier,
                            invoice_no,
                            pnr,
                            invoice_date,
                            flight_date,
                            flight_no,
                            airlines_name,
                            ticket_code,
                            ticket_no,
                            airlines_code,
                            number_of_tickets,
                            agent_price_1,
                            supplier_price,
                            sector,
                            stuff,
                            discount,
                            csrfToken,
                            remark,
                            person,
                            classOpt ,
                            class_code ,
                            return_date
                        };
                    // console.log(dataToSend);
                    $.ajax({
                            url: '/addsingleticket', // Use the correct route name
                            type: 'POST',
                            contentType: 'application/json',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: JSON.stringify(dataToSend),
                            success: function(data) {
                                // Handle the success response data as needed
                                alert('Ticket added successfully');
                                window.location.reload();
                            },

                            error: function(jqXHR, textStatus, errorThrown) {
                                // Handle errors here
                                console.error('Error:', errorThrown);
                            }
                    });

                }
                else {
                    alert('Some required variables are missing.');
                }




            });


        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('toggle_return_section').addEventListener('click', function() {
                var returnSection = document.getElementById('return_section');
                if (returnSection.classList.contains('hidden')) {
                    returnSection.classList.remove('hidden');
                } else {
                    returnSection.classList.add('hidden');
                }
            });
            var sectorInput = document.getElementById('sector');
    
            sectorInput.addEventListener('input', function() {
                var inputValue = this.value.toUpperCase();
                var formattedValue = inputValue.replace(/-/g, ''); // Remove existing hyphens
                var newValue = '';
                for (var i = 0; i < formattedValue.length; i++) {
                    newValue += formattedValue[i];
                    if ((i + 1) % 3 === 0 && i + 1 !== formattedValue.length) {
                        newValue += '-';
                    }
                }
                this.value = newValue;
            });

            sectorInput.addEventListener('keydown', function(event) {
                if (event.key === 'Backspace') {
                    var currentValue = this.value;
                    if (currentValue.slice(-1) === '-') {
                        this.value = currentValue.slice(0, -2); // Remove the character before the hyphen
                        event.preventDefault();
                    }
                }
            });
        });
        var flightInput = document.getElementById('flight_no');

        flightInput.addEventListener('input', function() {
            var inputValue = this.value;
            if (inputValue.length === 2) {
                this.value = inputValue + '-';
            }
        });

        flightInput.addEventListener('keydown', function(event) {
            if (event.key === 'Backspace' && this.value.length > 2) {
                this.value = this.value.slice(0, -1);
                event.preventDefault();
            }
        });
    </script>
</x-app-layout>
