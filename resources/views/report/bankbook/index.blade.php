<x-app-layout>
    <div class="container-fluid bg-white shadow-lg p-4 rounded-lg">
        {{-- <h3>fsdsdf</h3> --}}
        <form id="reportForm" action="{{ route('bank_book_report') }}" method="POST">
          @csrf
          <div class="flex items-center">
            
            
       
            <div class="form-group col-md-2">
                <label for="start_date">Start Date</label>
                <div class="input-group date" style="width: 100%">
                    <input type="text" class="form-control datepicker" name="start_date" id="start_date" placeholder="Start Date" />
                </div>      
            </div>
            <div class="form-group col-md-2">
                <label for="end_date">End Date</label>
                <div class="input-group date" style="width: 100%">
                    <input type="text" class="form-control datepicker" name="end_date" id="end_date" placeholder="End Date" />
                </div>      
            </div>
            <div class="form-group col-md-2">
                <label for="end_date">Method</label>
                <div class="input-group date" style="width: 100%">
                    <select class="form-control select2" name="method" id="method">
                        <option value="">Select Bank</option>

                        @foreach ($methods as $method)
                            <option value="{{$method->id}}">{{$method->name}}</option>

                        @endforeach
                    </select>
                </div>      
            </div>
            
            
            <div class="flex items-center">
                <button type="submit" class="bg-black border-blue-500 text-white py-2 px-5 rounded-lg ">Submit</button>
            </div>
          </div>
      </form>
    </div>

    <div class="reportdiv mt-5" id="reportdiv">

    </div>


    {{-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> --}}
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
                        // console.log(response);
                        $('#reportdiv').html(response.html);
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            });
        });

        
    </script>
</x-app-layout>