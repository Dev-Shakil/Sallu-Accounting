<x-app-layout>
    <div class="container-fluid">
        {{-- <h3>fsdsdf</h3> --}}
        <form id="reportForm" action="{{ route('seles_executive_report_stuff') }}" method="POST">
          @csrf
          <div class="row">
            
              <div class=" form-group col-md-3">
                  <label for="agent">Agent</label>
                  <select class="form-control select2" name="agent" id="agent" placeholder="Select agent">
                      <option value="">Select Agent</option>
                      @foreach($agents as $agent)
                          <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                      @endforeach
                  </select>
              </div>
              <div class="col-md-3 form-group">
                  <label for="supplier">Supplier</label>
                  <select class="form-control select2" name="supplier" id="supplier">
                      <option value="">Select Supplier</option>
                      @foreach($suppliers as $supplier)
                          <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                      @endforeach
                  </select>
              </div>
              <div class=" form-group col-md-3">
                <label for="agent">Stuffs</label>
                <select class="form-control select2" name="stuff" id="stuff" placeholder="Select stuff">
                    <option value="">Select Stuffs</option>
                    @foreach($stuffs as $stuff)
                        <option value="{{ $stuff }}">{{ $stuff }}</option>
                    @endforeach
                </select>
            </div>
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
              <div class="form-group col-md-4">
                  <div class="form-check form-check-inline">
                      <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="profit" name="show_profit">
                      <label class="form-check-label" for="inlineCheckbox1">Show Profit</label>
                  </div>
                  <div class="form-check form-check-inline">
                      <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="supplier" name="show_supplier">
                      <label class="form-check-label" for="inlineCheckbox2">Show Supplier</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="agent" name="show_agent">
                    <label class="form-check-label" for="inlineCheckbox3">Show Agent</label>
                  </div>
              </div>
              
              <div class="col-md-2">
                  <button type="submit" class="btn btn-primary">Submit</button>
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