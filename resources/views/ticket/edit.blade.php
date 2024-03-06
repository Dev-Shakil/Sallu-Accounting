<x-app-layout>
<h2
class="text-4xl py-4 flex justify-center font-extrabold bg-[#01919A] text-white"
>
Ticket Invoicing
</h2>
<div class="flex flex-col justify-center items-center p-6 rounded-lg shadow-md lg:w-3/4 w-full mx-auto my-2">

<form class="w-full" id="ticket_form" action="{{ route('ticket.update') }}" method="POST">

      @csrf

      <input type="hidden" name="ticket_id" value="{{$ticket->id}}">
    <div class="flex flex-wrap gap-x-6 -mx-4 mb-4">
      <div class="w-full md:w-[48%] px-4 mb-2 flex items-center">
        <label for="invoice_no" class="block w-full md:w-[40%] text-gray-700 text-sm mb-2">Invoice No.</label>
        <input type="text" id="invoice_no" class="text-center text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" name="invoice_no" value="{{$ticket->invoice}}" readonly>
      </div>
      <div class="w-full md:w-[48%] px-4 mb-2 flex items-center">
        <label for="agent_name" class="block w-full md:w-[40%]  text-gray-700 text-sm mb-2">Agent Name</label>
      
        <select name="agent" id="agent" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block max-w-[60%] p-1 select2" required>
            <option value="">Select Agent</option>
            @foreach($agents as $agent)
                <option value="{{ $agent->id }}" @if($ticket->agent == $agent->id) selected @endif>
                    {{ $agent->name }}
                </option>
            @endforeach
        </select>
        

      </div>
    </div>

    <div class="flex flex-wrap gap-x-6 -mx-4 mb-4">
      <div class="w-full md:w-[48%] px-4 mb-2 flex items-center">
          <label for="invoice_date" class="block w-full md:w-[40%]  text-gray-700 text-sm mb-2">Invoice Date</label>
          <input type="date" id="invoice_date" class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block w-full p-1" name="invoice_date" value="{{$ticket->invoice_date}}" required>
        </div>
        <div class="w-full md:w-[48%] px-4 mb-2 flex items-center">
          <label for="flight_date" class="block w-full md:w-[40%]  text-gray-700 text-sm mb-2">Flight Date</label>
          <input type="date" id="flight_date" class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block w-full p-1" name="flight_date" value="{{$ticket->flight_date}}" required>
        </div>
    </div>
    <div class="flex flex-wrap gap-x-6 -mx-4 mb-4">
      <div class="w-full md:w-[48%] px-4 mb-2 flex items-center">
          <label for="sector" class="block w-full md:w-[40%]  text-gray-700 text-sm mb-2">Sector</label>
          <input type="text" id="sector" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block w-full p-1" name="sector" value={{$ticket->sector}}>
        </div>
        <div class="w-full md:w-[48%] px-4 mb-2 flex items-center">
          <label for="flight_no" class="block w-full md:w-[40%]  text-gray-700 text-sm mb-2">Flight No</label>
          <input type="text" id="flight_no" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block w-full p-1" name="flight_no" value="{{$ticket->flight_no}}" required>
        </div>
    </div>
    <div class="flex flex-wrap gap-x-6 -mx-4 mb-4">
      <div class="w-full md:w-[48%] px-4 mb-2 flex items-center">
          <label for="ticket_no" class="block w-full md:w-[40%]  text-gray-700 text-sm mb-2">Ticket No / PNR</label>
          <div class="flex w-full gap-x-3">
              <input type="text" id="ticket_code" class="bg-gray-50 w-[23%] border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block p-1" name="ticket_code" value="{{$ticket->ticket_code}}">
              <input type="text" id="ticket_no" maxlength="10" class="bg-gray-50 w-[73%] border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block p-1" name="ticket_no" value="{{$ticket->ticket_no}}">
          </div>
        </div>
       
    </div>
    <div class="flex flex-wrap gap-x-6 -mx-4 mb-4">
      <div class="w-full md:w-[48%] px-4 mb-2 flex items-center">
          <label for="passenger_name" class="block w-full md:w-[40%]  text-gray-700 text-sm mb-2">Passenger Name</label>
          <input type="text" id="passenger_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block w-full p-1" name="passenger_name" value="{{$ticket->passenger}}">
        </div>
        <div class="w-full md:w-[48%] px-4 mb-2 flex items-center">
          <label for="airline" class="block w-full md:w-[40%]  text-gray-700 text-sm mb-2">Airline</label>
          <div class="flex w-full gap-x-3">
              <input type="text" id="airlines_name" class="bg-gray-50 w-[73%] border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block p-1" name="airlines_name" value="{{$ticket->airline_name}}">
              <input type="text" id="airlines_code" class="bg-gray-50 w-[23%] border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block p-1" name="airlines_code" value="{{$ticket->airline_code}}">
          </div>
        </div>
    </div>
    <div class="flex flex-wrap gap-x-6 -mx-4 mb-4">
      <div class="w-full md:w-[48%] px-4 mb-2 flex items-center">
          <label for="stuff" class="block w-full md:w-[40%]  text-gray-700 text-sm mb-2">Stuff</label>
          <input type="text" id="stuff" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block w-full p-1" name="stuff" value="{{$ticket->stuff}}">
        </div>
        <div class="w-full md:w-[48%] px-4 mb-2 flex items-center">
          <label for="supplier" class="block w-full md:w-[40%]  text-gray-700 text-sm mb-2">Supplier</label>
          
          <select name="supplier" id="supplier" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block max-w-[60%]  p-1 select2" required>
            <option value="">Select Supplier</option>
            @foreach($suppliers as $supplier)
                <option value="{{ $supplier->id }}" @if($ticket->supplier == $supplier->id) selected @endif>
                    {{ $supplier->name }}
                </option>
            @endforeach
         </select>
        
      </div>
    </div>
    <div class="flex flex-wrap gap-x-6 -mx-4 mb-4">
      <div class="w-full md:w-[48%] px-4 mb-2 flex items-center">
          <label for="agent_price" class="block w-full md:w-[40%]  text-gray-700 text-sm mb-2">Agent Price</label>
          <input type="text" id="agent_price_1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block w-full p-1" name="agent_price" value="{{$ticket->agent_price}}" required>
        </div>
        <div class="w-full md:w-[48%] px-4 mb-2 flex items-center">
          <label for="supplier_price" class="block w-full md:w-[40%]  text-gray-700 text-sm mb-2">Supplier Price</label>
          <input type="text" id="supplier_price" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block w-full p-1" name="supplier_price" value="{{$ticket->supplier_price}}" required>
        </div>
    </div>
    <div class="flex flex-wrap gap-x-6 -mx-4 mb-4">
      <div class="w-full md:w-[48%] px-4 mb-2 flex items-center">
          <label for="discount" class="block w-full md:w-[40%]  text-gray-700 text-sm mb-2">Discount</label>
          <input type="text" id="discount" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block w-full p-1" name="discount" value="{{$ticket->discount}}">
        </div>
      <div class="w-full md:w-[48%] px-4 mb-2 flex items-center">
          <label for="remark" class="block w-full md:w-[40%]  text-gray-700 text-sm mb-2">Remark</label>
          <textarea id="remark" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full p-1" name="remark">{!! $ticket->remark !!}</textarea>
        </div>
        
    </div>
    <div class="col-span-2 flex justify-end">
      <button type="submit" id="add_ticket" class="bg-[#922724] text-xl hover:bg-blue-700 text-white font-bold py-2 px-16 rounded">Update</button>
    </div>
    
  </form>

 
</div>
<script>
    $(document).ready(function() {
      $('.select2').select2();
      $('#ticket_code').on('change', function(){
              var ticketCodeValue = $(this).val();

              // Make an AJAX call
              $.ajax({
                  url: '/search_airline', // Replace with the actual endpoint URL
                  method: 'POST', // Specify the HTTP method (POST, GET, etc.)
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                  data: { ticketCode: ticketCodeValue }, // Data to be sent to the server
                  dataType: 'json', // Expected data type of the response
                  success: function(response) {
                      if(response.message == 'Success'){
                        $('#airlines_name').val(response.airline.Full);
                        $('#airlines_code').val(response.airline.Short);
                      }
                      else{
                        alert(response.message);
                      }
                  },
                  error: function(error) {
                      // Handle errors during the AJAX call
                      console.error('Error:', error);
                  }
              });
            });
    });	
  </script>
</x-app-layout>