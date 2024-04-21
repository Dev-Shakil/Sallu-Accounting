<x-app-layout>

    <div
        class="buttons justify-end flex gap-3 shadow-2xl py-2 border-2 border-stale-300 px-4 max-w-[1060px] mt-5 mx-auto">
        <button class="text-white bg-amber-800 font-bold text-md py-1 px-4">Send</button>
        <button id="printBtn" class="text-white bg-stone-700 font-bold text-md py-1 px-4">Print</button>
        <button class="text-white bg-sky-900 font-bold text-md py-1 px-4 ">Download</button>
    </div>
    <main id="printSection" class="flex-1 m-4 mx-auto max-w-[1060px] shadow-2xl border-t border-gray-200 px-10 py-5">

        <div class="flex justify-between items-center pb-2">
            <img class="" src="logo.jpeg" alt="Company Logo" height="150px" width="180px" />
            <div>
                <h3 class="company-name font-bold text-2xl ">Sallu Air Service</h3>
                <p class="company-address font-medium">291, Fakirapool, Motijheel, Dhaka</p>
                <p class="company-phone font-medium">Tel : 39420394023</p>
                <p class="company-email font-medium">Email : salluairservice@gmail.com</p>
            </div>
        </div>
        <hr class="h-[2px] bg-gray-600" />
        <h1 class="text-2xl font-bold text-center my-7">Payment Voucher</h1>
        <div class="flex justify-between items-center">
            <div>
                <div><span class="font-semibold">Date</span> : <?php echo date('d-m-Y', strtotime($payment_voucher->created_at)); ?></div>
                <div><span class="font-semibold">Service Type</span> : Ticket Booking</div>
            </div>
            <div class="flex flex-col gap-y-2">
                <h3 class="font-bold text-xl">Client Details</h3>
                <p>Client Name : {{ $supplier->name }}</p>
                <p>Email : {{ $supplier->email }}</p>
                <p>Mob : {{ $supplier->phone }}</p>
            </div>
        </div>
        <table class=" w-full my-3 border-y border-black">
            <thead class="border-y border-black bg-amber-300">
                <tr>
                    <th>Service Details</th>
                    <th>Payment Mode</th>
                    <th>Remark</th>
                    <th>Payment Amount</th>
                </tr>
            </thead>
            <tbody class="h-[60px]">
                <tr class=" py-5">
                    <td>Ticket Booking</td>
                    <td>{{ $payment_voucher->method }}</td>
                    <td>{{ $payment_voucher->remark }}</td>
                    <td>{{ number_format($payment_voucher->amount, 0, '.', ',') }}</td>
                </tr>
            </tbody>
        </table>

    </main>
    <script type="text/javascript">
        const originalDate = new Date("2024-01-30 11:37:18");
        const day = originalDate.getDate().toString().padStart(2, '0');
        const month = (originalDate.getMonth() + 1).toString().padStart(2, '0'); // Note: Months are zero-based
        const year = originalDate.getFullYear();

        const formattedDate = `${day}-${month}-${year}`;
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get the "Print" button
            const printButton = document.getElementById('printBtn');
            const printSection = document.getElementById('printSection');

            // Attach a click event listener to the "Print" button
            printButton.addEventListener('click', function() {
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
