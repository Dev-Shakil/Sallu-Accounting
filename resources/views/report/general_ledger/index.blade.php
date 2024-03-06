<x-app-layout>
    <div class="">
        <form id="reportForm" action="{{ route('general_ledger_report') }}" method="POST">
            @csrf
            <div class="row">
                
                <div class=" form-group col-md-3">
                    <label for="agent">Agent/Supplier</label>
                    <select id="agent_supplier" name="agent_supplier" class=" text-gray-900 text-sm bg-gray-50 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 block w-full p-1" required>
                        <option value="">Select One</option>
                        <option value="agent">Agent</option>
                        <option value="supplier">Supplier</option>
                    </select>
                </div>
                <div class="col-md-3 form-group">
                    <label for="supplier">Candidate</label>
                    <select id="agent_supplier_id" name="agent_supplier_id" class=" text-gray-900 text-sm bg-gray-50 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 block w-full p-1 select2" required>
                        <option value="">Select One</option>
                        
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
                {{-- <div class="form-group col-md-4">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="profit" name="show_profit">
                        <label class="form-check-label" for="inlineCheckbox1">Show Profit</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="supplier" name="show_supplier">
                        <label class="form-check-label" for="inlineCheckbox2">Show Supplier</label>
                    </div>
                </div> --}}
                
                <div class="col-md-2">
                    <button type="submit" class="bg-blue-600 text-md px-4 py-2 rounded-lg text-white font-bold">Submit</button>
                </div>
            </div>
        </form>

    <div class="reportdiv " id="reportdiv">

    </div>
</div>

    {{-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> --}}
    <script>
        $(document).ready(function() {
            $("#agent_supplier").change(function () {
                var selectedValue = $(this).val();
                if (selectedValue) {
                    $.ajax({
                        url: "/get_agent_supplier",
                        method: "GET",
                        data: { who: selectedValue },
                        success: function (response) {
                            updateOptions(response);
                        },
                        error: function (error) {
                            alert(error);
                        }
                    });
                }
            });

            function updateOptions(options) {
                var selectElement = $("#agent_supplier_id");
                selectElement.empty();
                selectElement.append("<option value=''>Select One</option>");
                options.forEach(function(option) {
                    selectElement.append("<option value='" + option.id + "'>" + option.name + "</option>");
                });
            }
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Get the "Print" button
            const printButton = document.getElementById('printBtn');
            const printSection = document.getElementById('printSection');
    
            // Attach a click event listener to the "Print" button
            printButton.addEventListener('click', function () {
                // Open the print dialog for the printSection
                window.print();
            });
        });
    </script>
    
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
    
            #printSection, #printSection * {
                visibility: visible;
            }
    
            #printSection {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                max-width: 100%;
                box-sizing: border-box;
                padding: 10px; /* Adjust padding as needed */
            }
        }
    </style>
</x-app-layout>