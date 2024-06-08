<x-guest-layout>
    {{-- <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form> --}}
    <main class="w-[95%] md:w-[80%] lg:w-[40%] mx-auto mt-4 ">
        <div class="bg-[#01919A] py-7 text-black px-7 flex justify-center items-center flex-col">
            <h3 class="text-4xl tracking-wide">ACOUNTING MADE EASIER FOR</h3>
            <h4 class="text-6xl tracking-wider font-semibold -mt-3">TRAVEL AGENCIES</h4>
        </div>
        <div class="flex flex-col mx-auto w-full shadow-md p-4 justify-center items-center">

            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class=" w-[85%]">
                @csrf
                <div class="mb-4 flex items-center gap-8">
                    <label for="name" class="text-gray-700 text-lg flex font-medium mb-2 w-[40%]">Company Name <p
                            class="text-red-700 text-xl font-bold">*</p></label>
                    <input type="text" id="name"
                        class="requried:border-red-700 px-4 py-2 rounded-lg border focus:outline-none w-full focus:shadow-outline"
                        name="name" placeholder="Company Name" required autofocus autocomplete="name">
                </div>
                <div class="mb-4 flex items-center gap-8">
                    <label for="tel_no" class="text-gray-700 text-lg font-medium mb-2 block w-[40%]">Tel
                        Number</label>
                    <input type="text" id="tel_no" name="tel_no"
                        class="px-4 py-2 rounded-lg border focus:outline-none w-full focus:shadow-outline"
                        placeholder="Tel Number">
                </div>
                <div class="mb-4 flex items-center gap-8">
                    <label for="mobile_no" class="flex text-gray-700 text-lg font-medium mb-2 w-[40%]">Mobile Number <p
                            class="text-red-700 text-xl font-bold">*</p></label>
                    <input type="text" id="mobile_no" name="mobile_no"
                        class="px-4 py-2 rounded-lg border focus:outline-none w-full focus:shadow-outline"
                        placeholder="Mobile" required>
                </div>
                <div class="mb-4 flex items-center gap-8">
                    <label for="email" class="text-gray-700 text-lg font-medium mb-2 w-[40%] flex">Email <p
                            class="text-red-700 text-xl font-bold">*</p></label>
                    <input type="email" id="email" name="email"
                        class="px-4 py-2 rounded-lg border focus:outline-none w-full focus:shadow-outline"
                        placeholder="Email" required>
                    
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                <div class="mb-4 flex items-center gap-8">
                    <label for="password" class="flex text-gray-700 text-lg font-medium mb-2 w-[40%]">Password <p
                            class="text-red-700 text-xl font-bold">*</p></label>
                    <input type="password" id="password" name="password"
                        class="px-4 py-2 rounded-lg border focus:outline-none w-full focus:shadow-outline"
                        placeholder="Password" required>
                    
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                <div class="mb-4 flex items-center gap-8">
                    <label for="password_confirmation"
                        class="text-gray-700 text-lg font-medium mb-2 w-[40%] flex">Confirm Password <p
                            class="text-red-700 text-xl font-bold">*</p></label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="px-4 py-2 rounded-lg border focus:outline-none w-full focus:shadow-outline"
                        placeholder="Confirm Password" required>
                   
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                <div class="mb-4 flex items-center gap-8">
                    <label for="company_address" class="text-gray-700 text-lg font-medium mb-2 w-[40%] flex">Company
                        Address<p class="text-red-700 text-xl font-bold">*</p></label>
                    <textarea id="company_address" name="company_address" class="px-4 py-2 rounded-lg border focus:outline-none w-full focus:shadow-outline"
                        placeholder="Company Address" required></textarea>
                </div>
                <div class="mb-4 flex items-center gap-8">
                    <label for="company_logo" class="text-gray-700 text-lg font-medium mb-2 block w-[40%]">Company
                        Logo</label>
                    <input type="file" id="company_logo" name="company_logo"
                        class="px-4 py-2 rounded-lg border focus:outline-none w-full focus:shadow-outline">
                        
                </div>
                <p class="text-red-600">The company logo field must not be greater than 2048 kilobytes.</p>
                <x-input-error :messages="$errors->get('company_logo')" class="mt-2" />
                <div class="flex justify-between items-center">
                    <button type="submit"
                        class="px-6 py-2 rounded-lg bg-blue-500 text-white hover:bg-blue-600">Register</button><a
                        class="underline text-md font-medium text-blue-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                        href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>
                </div>
            </form>
        </div>


    </main>
</x-guest-layout>
