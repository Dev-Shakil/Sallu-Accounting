<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autofocus autocomplete="email" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>
        <div>
            <x-input-label for="mobile_no" :value="__('Mobile No')" />
            <x-text-input id="mobile_no" name="mobile_no" type="text" class="mt-1 block w-full" :value="old('mobile_no', $user->mobile_no)" required autofocus autocomplete="mobile_no" />
            <x-input-error class="mt-2" :messages="$errors->get('mobile_no')" />
        </div>

        <div>
            <x-input-label for="company_address" :value="__('Company Address')" />
            <x-text-input id="company_address" name="company_address" type="company_address" class="mt-1 block w-full" :value="old('company_address', $user->company_address)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('company_address')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>
        <div>
          
            <x-input-label for="company_logo" :value="__('Company Logo')" />
            <input type="file" id="company_logo" name="company_logo" class="mt-1 w-full hidden">
            <x-input-error class="mt-2" :messages="$errors->get('company_logo')" />
            
                @if($user->company_logo)
                <img src="{{ url($user->company_logo) }}" alt="{{ $user->company_logo }}" id="profilePicturePreview" class="mt-2 object-cover cursor-pointer" width="200px" height="220px" />
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
    <script>
        document.getElementById('profilePicturePreview').addEventListener('click', function() {
            document.getElementById('company_logo').click();
        });
    
        document.getElementById('company_logo').addEventListener('change', function(event) {
            if (event.target.files && event.target.files[0]) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profilePicturePreview').src = e.target.result;
                }
                reader.readAsDataURL(event.target.files[0]);
            }
        });
    </script>
</section>
