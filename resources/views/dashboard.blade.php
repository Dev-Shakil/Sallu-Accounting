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
                    <a href="{{ route('agent.view') }}" class="bg-blue-500 hover:bg-blue-700 text-gray-800 font-bold py-5 px-4 rounded">
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
    <div class="grid grid-cols-5 gap-5">
        <button class="text-white bg-orange-600  font-bold py-5 px-4 rounded">
          New Ticket Invoice
        </button>
        <button class="text-white bg-[#a06c65] hover:bg-blue-700 font-bold py-5 px-4 rounded">
          New Income Type
        </button>
        <button class="text-white bg-[#4d1c31] hover:bg-blue-700 font-bold py-5 px-4 rounded">
          Receipt Payment
        </button>
        <button class="text-white bg-[#bfa17b] hover:bg-blue-700 font-bold py-5 px-4 rounded">
          Sales Report
        </button>
        <button class="text-white bg-[#415841] hover:bg-blue-700 font-bold py-5 px-4 rounded">
          Profit & Loss
        </button>
        <button class="text-white bg-[#487c90] hover:bg-blue-700 font-bold py-5 px-4 rounded">
          Refund
        </button>
        <button class="text-white bg-[#0e5850] hover:bg-blue-700 font-bold py-5 px-4 rounded">
          Payables
        </button>
        <button class="text-white bg-[#283c44] hover:bg-blue-700 font-bold py-5 px-4 rounded">
          Cash Book Report
        </button>
        <button class="text-white bg-[#40c0f3] hover:bg-blue-700 font-bold py-5 px-4 rounded">
          Flight Alert
        </button>
        <button class="text-white bg-[#d1584c] hover:bg-blue-700 font-bold py-5 px-4 rounded">
          DSR
        </button>
        <button class="text-white bg-[#344d0e] hover:bg-blue-700 font-bold py-5 px-4 rounded">
          E-Services
        </button>
        <button class="text-white bg-[#574816] hover:bg-blue-700 font-bold py-5 px-4 rounded">
          DU Reminder
        </button>
        <button class="text-white bg-[#4f595d] hover:bg-blue-700 font-bold py-5 px-4 rounded">
          MT Receive
        </button>
        <button class="text-white bg-[#7a4b2b] hover:bg-blue-700 font-bold py-5 px-4 rounded">
          Day Book
        </button>
        <button class="text-white bg-[#5c6e70] hover:bg-blue-700 font-bold py-5 px-4 rounded">
          Report
        </button>
      </div>
      <


</x-app-layout>
