<x-app-layout>
  
  <main class=" mx-auto w-[95%] ">
   
    <div class=" px-7 py-3 flex flex-col gap-y-4 mb-3 shadow-2xl">
        <h2 class="font-bold text-2xl ">Due Reminder</h2>
        
        <div class="flex items-center gap-4">
          <p class="text-black text-xl font-semibold">Type</p>
            <div class="flex items-center">
                <input checked id="all" type="radio" value="" name="default-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" onclick="toggleSearchbar('searchbar', false)" />
                <label for="default-radio-1" class="ms-2 text-md font-medium text-green-700 dark:text-gray-300">All Customers</label>
            </div>
            <div class="flex items-center">
                <input id="selected" type="radio" value="" name="default-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" onclick="toggleSearchbar('searchbar', true)">
                <label for="default-radio-2" class="ms-2 text-md font-medium text-red-700 dark:text-gray-300">Specific Customer</label>
            </div>
        </div>
        <div class="" id="searchbar">
            <label for="customer" class="text-black font-semibold text-xl">Customer Name</label>
            <form action="{{ route('due_reminder_specific') }}" method="GET">
              <div class="flex gap-4 mt-2">
                  <select id="supplierSelect" name="supplierName" id="agent_supplier_id" class="lg:w-[60%] w-[80%] border rounded-md p-2 h-9 text-black bg-gray-200">
                      <option value="" selected disabled>Select Customer</option>
                      @foreach($suppliers as $supplier)
                          <option value="supplier_{{ $supplier->id }}">{{ $supplier->name }}</option>
                      @endforeach
                      @foreach($agents as $agent)
                          <option value="agent_{{ $agent->id }}">{{ $agent->name }}</option>
                      @endforeach
                  </select>
                  <button type="submit" class="bg-blue-800 p-2 text-white font-semibold rounded-sm">Search</button>
              </div>
          </form>
               
        </div>
    </div>
    <table class="table-auto w-full shadow-2xl">
        <thead>
          <tr class="bg-[#0E7490] text-white">
            <th class="px-4 py-2 text-left">SN</th>
            <th class="px-4 py-2 text-left">Customer</th>
            <th class="px-4 py-2 text-left">Office Name</th>
            <th class="px-4 py-2 text-left">Email</th>
            <th class="px-4 py-2 text-left">Mobile</th>
            <th class="px-4 py-2 text-left">Last Date</th>
            <th class="px-4 py-2 text-center">Last Payment</th>
        
            <th class="px-4 py-2 text-center">Total Due</th>
          </tr>
        </thead>
        <tbody id="data">
          @foreach($filteredTransactions as $index => $data)
          <tr>
            <td class="px-4 py-2">{{$index++}}</td>
            <td class="px-4 py-2">{{$data->agent_supplier_name}}</td>
            <td class="px-4 py-2">{{$data->agent_supplier_company}}</td>
            <td class="px-4 py-2">{{$data->agent_supplier_email}}</td>
            <td class="px-4 py-2">{{$data->agent_supplier_phone}}</td>
            <td class="px-4 py-2">{{$data->date}}</td>
            <td class="px-4 py-2 text-center">{{$data->amount}}</td>
            
            <td class="px-4 py-2 text-center">{{$data->current_amount}}</td>
          </tr>
          
          @endforeach
        </tbody>
      </table>
  </main>
  <script type="text/javascript">
    var searchbar = document.getElementById("searchbar");
    searchbar.style.display = "none";
    function toggleSearchbar(elementId, show) {
        var searchbar = document.getElementById(elementId);
        if (show) {
            searchbar.style.display = "block";
        } else {
            searchbar.style.display = "none";
        }
    }
    const rows = document.querySelectorAll('#data tr');
    for (let i = 0; i < rows.length; i += 2) {
      rows[i].classList.add('bg-gray-200');
    }
  </script>
  <script src="https://unpkg.com/flowbite@1.4.0/dist/flowbite.js"></script>
</x-app-layout>