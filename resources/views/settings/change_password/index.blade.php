<x-app-layout>
    <div class="container mt-5">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <h1 class="mb-4 w-[100%] lg:w-[100%] font-bold text-2xl">Change Password</h1>

        <div class="change_password w-[100%] lg:w-[100%] bg-white p-5 shadow-lg rounded-lg">
            <form action="/change_password" method="post" class="flex gap-14 flex-col">
                @csrf <!-- Add this line to include CSRF protection in Laravel -->
                <div class="flex flex-col w-[80%] gap-y-2">
                    <div class="flex gap-3 items-center">
                        <label for="name" class="w-[40%] font-semibold">Current Password <span class="text-red-500 font-bold text-xl">*</span></label>
                        <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Current Password" required>
                    </div>
                    <div class="flex gap-3 items-center">
                        <label for="name" class="w-[40%] font-semibold">New Password <span class="text-red-500 font-bold text-xl">*</span></label>
                        <input type="password" class="form-control" id="new_password" name="new_password" placeholder="New Password" required>
                    </div>
                    <div class="flex gap-3 items-center">
                        <label for="name" class="w-[40%] font-semibold">Confirm Password <span class="text-red-500 font-bold text-xl">*</span></label>
                        <input type="password" class="form-control" id="c_password" name="c_password" placeholder="Confirm Password" required>
                    </div>
                </div>
                <div class="flex justify-end">
                <button type="submit" class="px-8 py-2 bg-black rounded-xl text-white h-[40px]">Submit</button>
                </dvi>
            </form>
        </div>

        {{-- <div class="bg-white shadow-md p-6 my-3 w-full md:w-[60%] mx-auto">
            <form method="GET" action="{{ route('type.index') }}" class=" flex justify-end mb-3">
                <div class="flex items-center gap-3">
                    <input type="text" class="form-control" name="search" placeholder="Search" value="{{ request('search') }}">
                    <button type="submit" class="bg-black px-5 py-1.5 rounded text-white">Search</button>
                </div>
            </form>
            <table class="table table-striped table-hover no-wrap " id="typetable">
                <thead class="bg-[#5dc8cc]">
                    <tr>
                        <th scope="col" class="px-4 py-2 ">Serial</th>
                        <th scope="col" class="px-4 py-2 ">Name</th>
                        
                        <th scope="col" class="px-4 py-2 flex justify-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($types as $index => $type)
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
            </table>
            {{ $types->links() }}
        </div> --}}

    </div>
    <script>
        $(document).ready(function() {
            $('.datepicker').datepicker({
                autoclose: true
            });
    
            $('.select2').select2({
                theme:'classic',
            });

            // $('#typetable').DataTable();

        
        });

        
    </script>
</x-app-layout>