<x-app-layout>
    <div class="bg-white shadow-lg py-3 px-3 rounded-lg">
        <form id="reportForm" action="{{ route('general_ledger_report') }}" method="POST">
            @csrf
            <div class="flex gap-x-4 items-center">
                <div class="flex gap-x-5 items-center py-2">

                    <div class="w-[350px] flex gap-4 ">
                        <label for="agent" class='font-semibold text-[14px] text-[#22262e]'>Agent/Supplier</label>
                        <select id="agent_supplier" name="agent_supplier"
                            class="text-gray-900 text-sm bg-gray-50 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 w-[600px] p-1 "
                            required>
                            <option value="">Select One</option>
                            <option value="agent">Agent</option>
                            <option value="supplier">Supplier</option>
                        </select>
                    </div>
                    <div class="w-[350px] flex gap-4  ">
                        <label for="supplier" class='font-semibold text-[14px] text-[#22262e]'>Candidate</label>
                        <select id="agent_supplier_id" name="agent_supplier_id"
                            class="text-gray-900 text-sm bg-gray-50 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 p-1 select2"
                            required>
                            <option value="">Select One</option>
                        </select>
                    </div>
                    <div class="w-[220px] flex gap-4">
                        <label for="start_date" class='font-semibold text-[14px] text-[#22262e]'>From</label>
                        <div class="w-[100%] date">
                            <input type="text" class="form-control datepicker" name="start_date" id="start_date"
                                placeholder="Start Date" />
                        </div>
                    </div>
                    <div class="w-[220px] flex gap-4">
                        <label for="end_date" class='font-semibold text-[14px] text-[#22262e]'>To</label>
                        <div class="w-[100%] date" >
                            <input type="text" class="form-control datepicker" name="end_date" id="end_date"
                                placeholder="End Date" />
                        </div>
                    </div>
                </div>
                <div>
                    <div class="">
                        <button type="submit"
                            class="bg-black  text-md px-6 py-2 justify-end rounded-sm text-white font-bold">Submit</button>
                    </div>
                </div>
            </div>
        </form>
        
    </div>

    <div class="buttons justify-end flex gap-3 p-5">
        
        <button id="printButton" class="text-white bg-red-600 font-bold text-md py-2 px-4">Print</button>
        
        <button class="text-white bg-black font-bold text-md py-2 px-4" onclick='goBack()'>GO BACK</button>
    </div> 
    
    <div class="reportdiv " id="reportdiv">

    </div>
    </div>

    {{-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> --}}
    <script>
        $(document).ready(function() {
            $("#agent_supplier").change(function() {
                var selectedValue = $(this).val();
                if (selectedValue) {
                    $.ajax({
                        url: "/get_agent_supplier",
                        method: "GET",
                        data: {
                            who: selectedValue
                        },
                        success: function(response) {
                            updateOptions(response);
                        },
                        error: function(error) {
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

            $('#reportForm').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    success: function(response) {
                        // Update the reportdiv with the response
                        $('#reportdiv').html('');
                        $('#reportdiv').html(response.html);
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        });
    </script>
    <script>
        // Function to print the content of the reportdiv
        function printReport() {
            var printContents = document.getElementById("reportdiv").innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    
        // Add event listener to the "Print" button
        document.querySelector("#printButton").addEventListener("click", function() {
            printReport();
        });
    </script>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            #printSection,
            #printSection * {
                visibility: visible;
            }

            #printSection {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                max-width: 100%;
                box-sizing: border-box;
                padding: 10px;
                /* Adjust padding as needed */
            }
        }
    </style>
</x-app-layout>
