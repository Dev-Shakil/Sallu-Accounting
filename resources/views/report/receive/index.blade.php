<x-app-layout>
    <div class="container-fluid">
        <form id="reportForm" action="{{ route('receive_report_info') }}" method="POST">
            @csrf
            <div class="row">
                
                <div class="form-group col-md-3">
                    <label for="start_date">Start Date</label>
                    <div class="input-group date" style="width: 100%">
                        <input type="text" class="form-control datepicker" name="start_date" id="start_date" placeholder="Start Date" />
                    </div>      
                </div>
                <div class="form-group col-md-3">
                    <label for="end_date">End Date</label>
                    <div class="input-group date" style="width: 100%">
                        <input type="text" class="form-control datepicker" name="end_date" id="end_date" placeholder="End Date" />
                    </div>      
                </div>
                <div class="form-group col-md-3">
                    <label for="method">Transaction Method</label><br>
                    <select id="method" name="method" class="lg:w-[60%] w-[80%] border rounded-md p-2 h-9 text-black bg-gray-200">
                        <option value="">Select Payment Method</option>
                        @foreach($methods as $method)
                            <option value="{{ $method->id }}">{{ $method->name }}</option>
                        @endforeach
                    </select>     
                </div>
                <div class="form-group col-md-3">
                    <label for="method">Customer Name</label><br>
                    <select id="customer" name="customer" class="lg:w-[60%] w-[80%] border rounded-md p-2 h-9 text-black bg-gray-200">
                        <option value="">Select Customer</option>
                        @foreach($agents as $agent)
                            <option value="{{ $agent->getTable() }}_{{ $agent->id }}">{{ $agent->name }}</option>
                        @endforeach
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->getTable() }}_{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>     
                </div>
                
                <div class="col-md-2 mt-5">
                    <button type="submit" class="btn btn-outline-primary btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>

    <div class="reportdiv mt-5" id="reportdiv">

    </div>


    <script>
        $(document).ready(function() {
           
            $('.datepicker').datepicker({
                autoclose: true
            });
    
            $('.select2').select2();

            // $('#ordertable').DataTable();

            $('#reportForm').submit(function (e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    success: function (response) {
                        // Update the reportdiv with the response
                        $('#reportdiv').html(response);
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            });
        });

        
    </script>
</x-app-layout>