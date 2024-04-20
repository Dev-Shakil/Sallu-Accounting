<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}

    {{-- <div class="py-12 bg-green-500">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <a href="{{ route('agent.view') }}" class="bg-blue-500 hover:bg-blue-700 text-gray-800 font-bold py-3 px-4 rounded">
                        Agent
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <button type="button" class="btn btn-info">
                        <a href="{{ route('supplier.view') }}" class="text-gray-800">Supplier</a>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <button type="button" class="btn btn-info">
                        <a href="{{ route('order.view') }}" class="text-gray-800">Place Order</a>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <button type="button" class="btn btn-info">
                        <a href="{{ route('type.view') }}" class="text-gray-800">Types</a>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <button type="button" class="btn btn-info">
                        <a href="{{ route('report.view') }}" class="text-gray-800">Report</a>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <button type="button" class="btn btn-info">
                        <a href="{{ route('ticket.view') }}" class="text-gray-800">Ticket</a>
                    </button>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="grid grid-cols-3 md:grid-cols-5  gap-5">
        <button class="text-white bg-[#84857C]  font-bold py-3 px-4 rounded">
          New Ticket Invoice
        </button>
        <button class="text-white bg-[#4E4E4E] hover:bg-blue-700 font-bold py-3 px-4 rounded">
          New Income Type
        </button>
        <button class="text-white bg-[#6A764D] hover:bg-blue-700 font-bold py-3 px-4 rounded">
          Receipt Payment
        </button>
        <button class="text-white bg-[#A58A4C] hover:bg-blue-700 font-bold py-3 px-4 rounded">
          Sales Report
        </button>
        <button class="text-white bg-[#6A764D] hover:bg-blue-700 font-bold py-3 px-4 rounded">
          Profit & Loss
        </button>
        <button class="text-white bg-[#84857C] hover:bg-blue-700 font-bold py-3 px-4 rounded">
          Refund
        </button>
        <button class="text-white bg-[#4E4E4E] hover:bg-blue-700 font-bold py-3 px-4 rounded">
          Payables
        </button>
        <button class="text-white bg-[#A58A4C] hover:bg-blue-700 font-bold py-3 px-4 rounded">
          Cash Book Report
        </button>
        <button class="text-white bg-[#84857C] hover:bg-blue-700 font-bold py-3 px-4 rounded">
          Flight Alert
        </button>
        <button class="text-white bg-[#A58A4C] hover:bg-blue-700 font-bold py-3 px-4 rounded">
          DSR
        </button>
        <button class="text-white bg-[#344d0e] hover:bg-blue-700 font-bold py-3 px-4 rounded">
          E-Services
        </button>
        <button class="text-white bg-[#574816] hover:bg-blue-700 font-bold py-3 px-4 rounded">
          Deu Reminder
        </button>
        <button class="text-white bg-[#4f595d] hover:bg-blue-700 font-bold py-3 px-4 rounded">
          Stuff Productivity Report
        </button>
        <button class="text-white bg-[#7a4b2b] hover:bg-blue-700 font-bold py-3 px-4 rounded">
          Day Book
        </button>
        <button class="text-white bg-[#5c6e70] hover:bg-blue-700 font-bold py-3 px-4 rounded">
          Report
        </button>
      </div>
      <div class="grid grid-cols-2">
        <div class="">
          <table class="bg-gray-400 my-5 text-sm text-black border  overflow-hidden table table-striped table-hover" id="ticket_table">
            <thead>
              <tr class="border-b bg-gray-100">
                <th class="w-1/6 px-4 py-1 text-left text-gray-700 font-medium">Invoice Date</th>
                <th class="w-1/6 px-4 py-1 text-left text-gray-700 font-medium">Ticket No</th>
                <th class="w-1/6 px-4 py-1 text-left text-gray-700 font-medium">Airline</th>
                <th class="w-1/6 px-4 py-1 text-left text-gray-700 font-medium">Passenger</th>
                <th class="w-1/6 px-4 py-1 text-left text-gray-700 font-medium">Flight Date</th>
                <th class="w-1/6 px-4 py-1 text-left text-gray-700 font-medium">Agent</th>

                {{-- <th class="w-1/6 px-4 py-2 text-left text-gray-700 font-medium">Supplier</th> --}}
                <th class="w-1/6 px-4 py-1 text-left text-gray-700 font-medium">Price</th>

                {{-- <th class="w-1/6 px-4 py-2 text-left text-gray-700 font-medium">Supplier Price</th> --}}
              
              </tr>
            </thead>
            <tbody>

              @foreach($closetickets as $ticket)
              <tr class="border-b hover:bg-gray-50">
                <td class="px-4 py-2 text-gray-700">{{ (new DateTime($ticket->invoice_date))->format('d/m/Y') }}</td>
                <td class="px-4 py-2 text-gray-700">{{$ticket->ticket_code}}/{{$ticket->ticket_no}}</td>
                <td class="px-4 py-2 text-gray-700">{{$ticket->airline_name}}/{{$ticket->airline_code}}</td>

                <td class="px-4 py-2 text-gray-700">{{$ticket->passenger}}</td>

                <td class="px-4 py-2 text-gray-700">{{ (new DateTime($ticket->flight_date))->format('d/m/Y') }}</td>
                <td class="px-4 py-2 text-gray-700">{{$ticket->agent}}</td>

                {{-- <td class="px-4 py-2 text-gray-700">{{$ticket->supplier}}</td> --}}
                <td class="px-4 py-2 text-gray-700">{{$ticket->agent_price}}</td>
                {{-- <td class="px-4 py-2 text-gray-700">{{$ticket->supplier_price}}</td> --}}

              
              
              </tr>
              @endforeach
            
            </tbody>
          </table>
        </div>
      </div>
      

</x-app-layout>
