<x-app-layout>
    <div class="container mt-5">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="mb-2 flex items-center gap-6">
            <p class="font-bold text-2xl">List of Stuff</p>
            <button
                class="py-2 px-4 border-green-700 hover:bg-green-700 hover:text-white duration-300 border-2 text-green-700  rounded-2xl font-bold "
                onchange="toggleVisibility()" id="addnewbtn">Add
                New Stuff</button>
        </div>
        <div id="stuff-form">

            <div class="addagent w-[100%] lg:w-[50%] bg-white p-5 shadow-lg rounded-lg">
                {{-- <form action="/addtype" method="post">
                    @csrf <!-- Add this line to include CSRF protection in Laravel -->
                    <div class="row">
                        <div class="form-group col">
                            <label for="name">Type Name:</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Enter your name" required>
                        </div>
                    </div>

                    <button type="submit" class="px-8 py-2 bg-black rounded-xl text-white">Submit</button>
                </form> --}}
                <div class="text-center font-bold text-xl mb-8">Add New Employee</div>
            <form class="grid grid-cols-1 gap-4" action="submit_employee_data.php" method="post">
                <div class="flex items-center">
                    <label for="employeeName" class="w-1/2  mr-4">Employee Name <stong class="text-red-600 text-2xl">*</strong></label>
                    <input type="text" id="employeeName" name="employeeName"
                        class="rounded-md border border-gray-400 px-4 py-1 w-full focus:outline-none focus:ring-1 focus:ring-blue-500">
                </div>
                <div class="flex items-center">
                    <label for="designation" class="w-1/2  mr-4">Employee Designation <stong class="text-red-600 text-2xl">*</strong></label>
                    <input type="text" id="designation" name="designation"
                        class="rounded-md border border-gray-400 px-4 py-1 w-full focus:outline-none focus:ring-1 focus:ring-blue-500">
                </div>
                <div class="flex items-center">
                    <label for="mobileNumber" class="w-1/2  mr-4">Mobile Number <stong class="text-red-600 text-2xl">*</strong></label>
                    <input type="tel" id="mobileNumber" name="mobileNumber"
                        class="rounded-md border border-gray-400 px-4 py-1 w-full focus:outline-none focus:ring-1 focus:ring-blue-500">
                </div>
                <div class="flex items-center">
                    <label for="email" class="w-1/2  mr-4">E-mail ID <stong class="text-red-600 text-2xl">*</strong></label>
                    <input type="email" id="email" name="email"
                        class="rounded-md border border-gray-400 px-4 py-1 w-full focus:outline-none focus:ring-1 focus:ring-blue-500">
                </div>
                <div class="flex items-center">
                    <label for="address" class="w-1/2  mr-4">Address</label>
                    <textarea id="address" name="address" rows="2"
                        class="rounded-md border border-gray-400 px-4 py-1 w-full focus:outline-none focus:ring-1 focus:ring-blue-500"></textarea>
                </div>
                <div class="flex items-center">
                    <label for="salary" class="w-1/2  mr-4">Salary</label>
                    <input type="number" id="salary" name="salary"
                        class="rounded-md border border-gray-400 px-4 py-1 w-full focus:outline-none focus:ring-1 focus:ring-blue-500">
                </div>
               
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md focus:outline-none">Submit</button>
            </form>
            </div>
        </div>
        <div class="bg-white shadow-md p-6 my-3 w-full md:w-[60%]">
            
        <form method="GET" action="{{ route('type.index') }}" class=" flex justify-end mb-3">
                <div class="flex items-center gap-3">
                    <input type="text" class="form-control" name="search" placeholder="Search" value="{{ request('search') }}">
                    <button type="submit" class="bg-black px-5 py-1.5 rounded text-white">Search</button>
                </div>
            </form>



        {{-- <table class="table table-striped table-hover no-wrap " id="typetable">
                <thead class="bg-[#5dc8cc]">
                    <tr>
                        <th scope="col" class="px-4 py-2 ">Serial</th>
                        <th scope="col" class="px-4 py-2 ">Name</th>
                        
                        <th scope="col" class="px-4 py-2 flex justify-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($types as $index => $type)
                        <tr>
                            <th scope="row" class="px-4 py-2">{{ $type->id}}</th>
                            <td class="px-4 py-2 ">{{ $type->name }}</td>
                            <td class="px-4 py-2 flex justify-center">
                                <a href="{{ route('type.edit', ['id' => encrypt($type->id)]) }}" class=""><i class="text-xl fa fa-pencil fa-fw"></i></a>
                                <a href="{{ route('type.delete', ['id' => $type->id]) }}" class=""><i class="text-xl fa fa-trash-o fa-fw"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table> --}}
        {{-- {{ $types->links() }} --}}
    </div>

    </div>
    <script>
        $(document).ready(function() {
            $('.datepicker').datepicker({
                autoclose: true
            });

            $('.select2').select2({
                theme: 'classic',
            });

            // $('#typetable').DataTable();


        });
        var addnewBtn = document.getElementById('addnewbtn');
        var addStuff = document.getElementById('stuff-form');
        addStuff.style.display = 'none';

        addnewBtn.addEventListener('click', function() {
            toggleVisibility();
        });

        function toggleVisibility() {
            if (addStuff.style.display === 'none') {
                addStuff.style.display = 'block';
            } else {
                addStuff.style.display = 'none';
            }
        }
    </script>
</x-app-layout>
