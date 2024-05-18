<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Full Name -->
        <div>
            <x-input-label for="full_name" :value="__('Full Name')" />
            <x-text-input id="full_name" class="block mt-1 w-full" type="text" name="full_name" :value="old('full_name')" required autofocus autocomplete="full_name" />
            <x-input-error :messages="$errors->get('full_name')" class="mt-2" />
        </div>

        <!-- Birth Date -->
        <div class="mt-4">
            <x-input-label for="birth_date" :value="__('Birth Date')" />
            <x-text-input id="birth_date" class="block mt-1 w-full" type="date" name="birth_date" :value="old('birth_date')" required autocomplete="birth_date" />
            <x-input-error :messages="$errors->get('birth_date')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone Number -->
        <div class="mt-4">
            <x-input-label for="phone_number" :value="__('Phone Number')" />
            <x-text-input id="phone_number" class="block mt-1 w-full" name="phone_number" :value="old('phone_number')" required autocomplete="tel" />
            <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
        </div>

        <!-- Gender -->
        <div class="mt-4">
            <x-input-label for="gender" :value="__('Gender')" />
            <div class="block mt-1 w-full">
                <label for="male" class="inline-flex items-center">
                    <input type="radio" id="male" name="gender" value="male" {{ old('gender') == 'male' ? 'checked' : '' }} class="form-radio">
                    <x-input-label :value="__('Male')" class="ml-2" />
                </label>
                <label for="female" class="inline-flex items-center ml-4">
                    <input type="radio" id="female" name="gender" value="female" {{ old('gender') == 'female' ? 'checked' : '' }} class="form-radio">
                    <x-input-label :value="__('Female')" class="ml-2" />
                </label>
                <label for="other" class="inline-flex items-center ml-4">
                    <input type="radio" id="other" name="gender" value="other" {{ old('gender') == 'other' ? 'checked' : '' }} class="form-radio">
                    <x-input-label :value="__('Other')" class="ml-2" />
                </label>
            </div>
            <div id="other_gender_container" class="block mt-1 w-full" style="{{ old('gender') == 'other' ? 'display: block;' : 'display: none;' }}">
                <x-text-input id="other_gender" class="block mt-1 w-full" type="text" name="other_gender" :value="old('other_gender')" placeholder="{{ __('Specify') }}" />
                <x-input-error :messages="$errors->get('other_gender')" class="mt-2" />
            </div>
            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
        </div>

        <!-- NIF -->
        <div class="mt-4">
            <x-input-label for="nif" :value="__('NIF')" />
            <x-text-input id="nif" class="block mt-1 w-full" type="text" name="nif" :value="old('nif')" required autocomplete="nif" />
            <x-input-error :messages="$errors->get('nif')" class="mt-2" />
        </div>

        <!-- CC Number -->
        <div class="mt-4">
            <x-input-label for="cc_number" :value="__('CC Number')" />
            <x-text-input id="cc_number" class="block mt-1 w-full" type="text" name="cc_number" :value="old('cc_number')" required autocomplete="cc_number" />
            <x-input-error :messages="$errors->get('cc_number')" class="mt-2" />
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
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const otherRadio = document.getElementById('other');
            const otherGenderContainer = document.getElementById('other_gender_container');
            const maleRadio = document.getElementById('male');
            const femaleRadio = document.getElementById('female');
            const otherGenderInput = document.getElementById('other_gender');

            const handleOtherGenderInput = () => {
                if (otherRadio.checked) {
                    otherGenderContainer.style.display = 'block';
                    otherGenderInput.focus();
                } else {
                    otherGenderContainer.style.display = 'none';
                    otherGenderInput.value = '';
                }
            };

            if (otherRadio.checked) {
                handleOtherGenderInput();
            }

            otherRadio.addEventListener('change', handleOtherGenderInput);
            maleRadio.addEventListener('change', () => {
                if (!otherRadio.checked) {
                    otherGenderContainer.style.display = 'none';
                    otherGenderInput.value = '';
                }
            });
            femaleRadio.addEventListener('change', () => {
                if (!otherRadio.checked) {
                    otherGenderContainer.style.display = 'none';
                    otherGenderInput.value = '';
                }
            });

        });
    </script>

</x-guest-layout>
