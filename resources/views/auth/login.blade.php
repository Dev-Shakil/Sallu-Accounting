<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

   
    <main class="flex flex-col md:flex-row mx-auto w-full md:w-[90%] lg:w-[80%] xl:w-[70%] shadow-2xl bg-white rounded-lg border border-gray-300">
        <div class="w-full md:w-[35%] flex flex-col bg-gray-100 px-5 py-10 md:rounded-l-lg">
            <div class="flex justify-center flex-col items-center">
                <img src={{url('/image/ban1.jpeg')}} alt="logo" class="flex justify-center items-center " height="80px"
                    width="100px" />
                <h3 class=" text-gray-900 font-bold text-2xl my-4">Login</h3>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="flex items-cener flex-col gap-2 mb-4 ">
                    <label for="email" class="text-gray-800 font-semibold w-[40%]">Email</label>
                    <input type="text" id="email" placeholder="example@mail.com" name="email" required
                        class="border rounded-md p-2 h-10 text-black bg-white" />
                </div>
                <div class="flex items-cener flex-col gap-2 mb-4 ">
                    <label for="paymentMethod" class="text-gray-800 font-semibold w-[40%]">Password</label>
                    <input type="password" id="password" name="password" placeholder="Password"
                        class=" border rounded-md p-2 h-10 text-black bg-white" />
                </div>
                <div class="flex flex-col gap-3">
                    <button class="bg-cyan-700 px-7 py-2 rounded-lg text-lg font-medium text-white"
                        type="submit">Submit</button>
                    @if (Route::has('password.request'))
                        <a class="font-medium text-md text-blue-800" href="{{ route('password.request') }}">forgot password?</a>
                    @endif
                </div>
            </form>
        </div>
        <div class="w-full md:w-[65%] ">

            <div id="default-carousel" class="relative " data-carousel="slide">
                <!-- Carousel wrapper -->
                <div class="overflow-hidden relative min-h-[485px] rounded-r-lg ">
                    <!-- Item 1 -->
                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                        <span
                            class="absolute top-1/2 left-1/2 text-2xl font-semibold text-white -translate-x-1/2 -translate-y-1/2 sm:text-3xl dark:text-gray-800">First
                            Slide</span>
                        <img src={{url('/image/ban4.jpeg')}} title="source: imgur.com"
                            class="block absolute top-1/2 left-1/2 w-full -translate-x-1/2 -translate-y-1/2"
                            alt="Banner">
                    </div>

                    <!-- <a href="https://imgur.com/02qczMI"><img src="https://i.imgur.com/02qczMI.jpg" title="source: imgur.com" /></a> -->
                    <!-- Item 2 -->
                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                        <img src={{url('/image/ban1.jpeg')}}
                            class="block absolute top-1/2 left-1/2 w-full -translate-x-1/2 -translate-y-1/2"
                            alt="Banner">
                    </div>
                    <!-- Item 3 -->
                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                        <img src={{url('/image/ban2.jpeg')}}
                            class="block absolute top-1/2 left-1/2 w-full -translate-x-1/2 -translate-y-1/2"
                            alt="Banner">
                    </div>
                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                        <img src={{url('/image/ban3.jpeg')}}
                            class="block absolute top-1/2 left-1/2 w-full -translate-x-1/2 -translate-y-1/2"
                            alt="Banner">
                    </div>
                </div>
                <!-- Slider indicators -->
                <div class="flex absolute bottom-5 left-1/2 z-30 space-x-3 -translate-x-1/2">
                    <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 1"
                        data-carousel-slide-to="0"></button>
                    <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 2"
                        data-carousel-slide-to="1"></button>
                    <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 3"
                        data-carousel-slide-to="2"></button>
                    <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 4"
                        data-carousel-slide-to="3"></button>
                </div>
                <!-- Slider controls -->
                <button type="button"
                    class="flex absolute top-0 left-0 z-30 justify-center items-center px-4 h-full cursor-pointer group focus:outline-none"
                    data-carousel-prev>
                    <span
                        class="inline-flex justify-center items-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                        <svg class="w-5 h-5 text-white sm:w-6 sm:h-6 dark:text-gray-800" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                            </path>
                        </svg>
                        <span class="hidden">Previous</span>
                    </span>
                </button>
                <button type="button"
                    class="flex absolute top-0 right-0 z-30 justify-center items-center px-4 h-full cursor-pointer group focus:outline-none"
                    data-carousel-next>
                    <span
                        class="inline-flex justify-center items-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                        <svg class="w-5 h-5 text-white sm:w-6 sm:h-6 dark:text-gray-800" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                        <span class="hidden">Next</span>
                    </span>
                </button>
            </div>


        </div>

    </main>
    
</x-guest-layout>
