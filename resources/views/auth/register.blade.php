<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <x-jet-validation-errors class="mb-4" />
        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ __('Registration Successfull, Please verify the email sent on your email address.') }}
            </div>
        @endif
        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf

            <div>
                <x-jet-label value="{{ __('First Name *') }}" />
                <x-jet-input class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')" required autofocus autocomplete="first_name" />
            </div>
            
            <div class="mt-4">
                <x-jet-label value="{{ __('Last Name') }}" />
                <x-jet-input class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" autocomplete="last_name" />
            </div>

            <div class="mt-4">
                <x-jet-label value="{{ __('User Name *') }}" />
                <x-jet-input class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-jet-label value="{{ __('Email *') }}" />
                <x-jet-input class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <div class="mt-4">
                <x-jet-label value="{{ __('Phone') }}" />
                <x-jet-input class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" autocomplete="phone" />
            </div>

            <div class="mt-4">
                <x-jet-label value="{{ __('Facebook Profile Link') }}" />
                <x-jet-input class="block mt-1 w-full" type="text" name="facebook" :value="old('facebook')" autocomplete="facebook" />
            </div>


            <div class="mt-4">
                <x-jet-label value="{{ __('Instagram Profile Link') }}" />
                <x-jet-input class="block mt-1 w-full" type="text" name="instagram" :value="old('instagram')" autocomplete="instagram" />
            </div>

            <div class="mt-4">
                <x-jet-label value="{{ __('Preferred Language *') }}" />
                <select class="block mt-1 w-full" name="language">
                    <option value="">--Select--</option> 
                    <option value="es">English</option>
                    <option value="es">Spanish</option>
                <select> 
            </div>

            <div class="mt-4">
                <x-jet-label value="{{ __('Account Type *') }}" />
                <select class="block mt-1 w-full" name="account_type" required>
                    <option value="">--Select--</option> 
                    <option value="PUBLIC">Public</option>
                    <option value="PRIVATE">Private</option>
                <select>            
            </div>
            
            <div class="mt-4">
                <x-jet-label value="{{ __('Profile Photo') }}" />
                <x-jet-input class="block mt-1 w-full" type="file" name="profile_photo_name" :value="old('profile_photo_name')" />
            </div>

            <div class="mt-4">
                <x-jet-label value="{{ __('Password *') }}" />
                <x-jet-input class="block mt-1 w-full" type="password" value="admin@123" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-jet-label value="{{ __('Confirm Password *') }}" />
                <x-jet-input class="block mt-1 w-full" type="password" value="admin@123" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-jet-button class="ml-4">
                    {{ __('Register') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
