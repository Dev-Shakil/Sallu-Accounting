<x-app-layout>
    <div class="container mx-auto mt-5">
        @if(session('success'))
            <div class="bg-green-200 text-green-800 p-4 mb-4">
                {{ session('success') }}
            </div>
        @endif
        <h1 class="mb-4 text-3xl font-bold w-[100%] lg:w-[60%] mx-auto">Add Supplier</h1>
    
        <div class="bg-white shadow-md rounded-lg w-[100%] lg:w-[60%] mx-auto p-6 mb-8">
            <form action="/addsupplier" method="post">
                @csrf <!-- Add this line to include CSRF protection in Laravel -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-semibold text-gray-600">Name:</label>
                        <input type="text" class="form-input mt-1 block w-full border p-2" id="name" name="name" placeholder="Enter your name" required>
                    </div>
                    <div class="mb-4">
                        <label for="phone" class="block text-sm font-semibold text-gray-600">Phone:</label>
                        <input type="tel" class="form-input mt-1 block w-full border p-2" id="phone" name="phone" placeholder="Enter your phone number" required>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-semibold text-gray-600">Email:</label>
                        <input type="text" class="form-input mt-1 block w-full border p-2" id="email" name="email" placeholder="Enter an Email" required>
                    </div>
                    <div class="mb-4">
                        <label for="company" class="block text-sm font-semibold text-gray-600">Company:</label>
                        <input type="text" class="form-input mt-1 block w-full border p-2" id="company" name="company" placeholder="Enter a company" required>
                    </div>
                </div>
                <div class="mb-4 w-[49%]">
                    <label for="description" class="block text-sm font-semibold text-gray-600">Description:</label>
                    <textarea class="form-input mt-1 block w-full border p-2" id="description" name="description" placeholder="Enter a description" required></textarea>
                </div>
    
                <button type="submit" class="bg-black text-white px-4 py-2 rounded hover:bg-blue-600">Submit</button>
            </form>
        </div>
    
        <div class="bg-white shadow-md p-6 w-[100%] mx-auto">
            <table class="table divide-y divide-gray-200 table-hover table-striped" id="suppliertable">
                <thead class="bg-[#7CB0B2]">
                    <tr>
                        <th class="px-4 py-2 ">SL</th>
                        <th class="px-4 py-2 ">Name</th>
                        <th class="px-4 py-2 ">Phone</th>
                        <th class="px-4 py-2 ">Email</th>
                        <th class="px-4 py-2 ">Company</th>
                        <th class="px-4 py-2 ">Description</th>
                        <th class="px-4 py-2 ">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($suppliers as $index => $supplier)
                        <tr>
                            <td class="px-4 py-2  w-[30px]">{{ $index + 1 }}</td>
                            <td class="px-4 py-2 ">{{ $supplier->name }}</td>
                            <td class="px-4 py-2 ">{{ $supplier->phone }}</td>
                            <td class="px-4 py-2 ">{{ $supplier->email }}</td>
                            <td class="px-4 py-2 ">{{ $supplier->company }}</td>
                            <td class="px-4 py-2 ">{{ $supplier->description }}</td>
                            <td class="px-4 py-2  w-[75px]">
                                <a href="{{ route('supplier.edit', ['id' => encrypt($supplier->id)]) }}" class="text-blue-500 hover:underline"><i class="text-xl fa fa-pencil fa-fw"></i></a>
                                <a href="{{ route('supplier.delete', ['id' => $supplier->id]) }}" class="text-red-500 hover:underline ml-2"><i class="text-xl fa fa-trash-o fa-fw"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.datepicker').datepicker({
                autoclose: true
            });
    
            $('.select2').select2({
                theme:'classic',
            });

            // $('#suppliertable').DataTable();
            new DataTable('#suppliertable', {
            responsive: true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            }
        });
        });

        
    </script>
    
</x-app-layout>