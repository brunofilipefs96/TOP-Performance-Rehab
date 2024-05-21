<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-4xl w-full bg-gray-400 shadow-lg rounded-lg p-8">
            <h2 class="text-2xl font-bold text-white text-center mb-6">Register</h2>
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf


                <div class="grid grid-cols-2 gap-10">
                    <!-- Full Name -->
                    <div>
                        <x-input-label for="full_name" :value="__('Full Name')" class="text-white" />
                        <x-text-input id="full_name" class="block mt-1 w-full bg-gray-700 text-white" type="text" name="full_name" :value="old('full_name')" required autofocus autocomplete="full_name" />
                        <x-input-error :messages="$errors->get('full_name')" class="mt-2 text-red-500" />
                    </div>

                    <!-- Birth Date -->
                    <div>
                        <x-input-label for="birth_date" :value="__('Birth Date')" class="text-white" />
                        <x-text-input id="birth_date" class="block mt-1 w-full bg-gray-700 text-white" type="date" name="birth_date" :value="old('birth_date')" required autocomplete="birth_date" />
                        <x-input-error :messages="$errors->get('birth_date')" class="mt-2 text-red-500" />
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-10">
                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" class="text-white" />
                        <x-text-input id="email" class="block mt-1 w-full bg-gray-700 text-white" type="email" name="email" :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
                    </div>

                    <!-- Phone Number -->
                    <div>
                        <x-input-label for="phone_number" :value="__('Phone Number')" class="text-white" />
                        <x-text-input id="phone_number" class="block mt-1 w-full bg-gray-700 text-white" type="tel" name="phone_number" :value="old('phone_number')" required autocomplete="tel" />
                        <x-input-error :messages="$errors->get('phone_number')" class="mt-2 text-red-500" />
                    </div>
                </div>

                <!-- Gender -->
                <div>
                    <x-input-label for="gender" :value="__('Gender')" class="text-white" />
                    <div class="mt-1">
                        <label for="male" class="inline-flex items-center text-white">
                            <input type="radio" id="male" name="gender" value="male" {{ old('gender') == 'male' ? 'checked' : '' }} class="form-radio bg-gray-700">
                            <span class="ml-2">{{ __('Male') }}</span>
                        </label>
                        <label for="female" class="inline-flex items-center ml-4 text-white">
                            <input type="radio" id="female" name="gender" value="female" {{ old('gender') == 'female' ? 'checked' : '' }} class="form-radio bg-gray-700">
                            <span class="ml-2">{{ __('Female') }}</span>
                        </label>
                        <label for="other" class="inline-flex items-center ml-4 text-white">
                            <input type="radio" id="other" name="gender" value="other" {{ old('gender') == 'other' ? 'checked' : '' }} class="form-radio bg-gray-700">
                            <span class="ml-2">{{ __('Other') }}</span>
                        </label>
                    </div>
                    <div id="other_gender_container" class="mt-1 w-full" style="{{ old('gender') == 'other' ? 'display: block;' : 'display: none;' }}">
                        <x-text-input id="other_gender" class="block mt-1 w-full bg-gray-700 text-white" type="text" name="other_gender" :value="old('other_gender')" placeholder="{{ __('Specify') }}" />
                        <x-input-error :messages="$errors->get('other_gender')" class="mt-2 text-red-500" />
                    </div>
                    <x-input-error :messages="$errors->get('gender')" class="mt-2 text-red-500" />
                </div>

                <div class="grid grid-cols-2 gap-10">
                    <!-- NIF -->
                    <div>
                        <x-input-label for="nif" :value="__('NIF')" class="text-white" />
                        <x-text-input id="nif" class="block mt-1 w-full bg-gray-700 text-white" type="text" name="nif" :value="old('nif')" required autocomplete="nif" />
                        <x-input-error :messages="$errors->get('nif')" class="mt-2 text-red-500" />
                    </div>

                    <!-- CC Number -->
                    <div>
                        <x-input-label for="cc_number" :value="__('CC Number')" class="text-white" />
                        <x-text-input id="cc_number" class="block mt-1 w-full bg-gray-700 text-white" type="text" name="cc_number" :value="old('cc_number')" required autocomplete="cc_number" />
                        <x-input-error :messages="$errors->get('cc_number')" class="mt-2 text-red-500" />
                    </div>
                </div>


                <div class="grid grid-cols-2 gap-10">
                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" class="text-white" />
                        <x-text-input id="password" class="block mt-1 w-full bg-gray-700 text-white" type="password" name="password" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-white" />
                        <x-text-input id="password_confirmation" class="block mt-1 w-full bg-gray-700 text-white" type="password" name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500" />
                    </div>
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
        </div>
    </div>
</x-guest-layout>
