<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center select-none my-10">
        <div class="max-w-4xl w-full bg-white dark:bg-gray-900 shadow-lg rounded-lg p-8">
            <div class="flex justify-left text-center">
                <button id="theme-toggle" type="button"
                        class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm">
                    <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>
                    <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                         xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                            fill-rule="evenodd" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <h2 class="text-4xl font-bold text-gray-800 text-center mb-1 p-2 dark:text-white">Crie a sua conta</h2>
            <h2 class="text-xl text-gray-600 dark:text-lime-300 text-center mb-6">Preencha os seus dados</h2>
            <hr>
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Full Name -->
                    <div>
                        <x-input-label for="full_name" :value="__('Nome Completo')" />
                        <x-text-input id="full_name" class="block mt-1 w-full text-gray-800 dark:text-black dark:bg-gray-300 " type="text" name="full_name" :value="old('full_name')" required autofocus autocomplete="full_name" />
                        <x-input-error :messages="$errors->get('full_name')" class="mt-2 text-red-500" />
                    </div>

                    <!-- Birth Date -->
                    <div>
                        <x-input-label for="birth_date" :value="__('Data de Nascimento')" />
                        <x-text-input id="birth_date" class="block mt-1 w-full text-gray-800 dark:text-black dark:bg-gray-300" type="date" name="birth_date" :value="old('birth_date')" required autocomplete="birth_date" />
                        <x-input-error :messages="$errors->get('birth_date')" class="mt-2 text-red-500" />
                    </div>


                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')"/>
                        <x-text-input id="email" class="block mt-1 w-full text-gray-800 dark:text-black dark:bg-gray-300" type="email" name="email" :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
                    </div>

                    <!-- Phone Number -->
                    <div>
                        <x-input-label for="phone_number" :value="__('Nº Telemóvel')"/>
                        <x-text-input id="phone_number" class="block mt-1 w-full text-gray-800 dark:bg-gray-300 dark:text-black" type="tel" name="phone_number" maxlength="9" pattern="\d{9}" :value="old('phone_number')" required autocomplete="tel" />
                        <x-input-error :messages="$errors->get('phone_number')" class="mt-2 text-red-500" />
                    </div>
                </div>

                <!-- Gender -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="gender" :value="__('Género')" />
                        <div class="mt-1">
                            <label for="male" class="inline-flex items-center">
                                <input type="radio" id="male" name="gender" value="male" {{ old('gender') == 'male' ? 'checked' : '' }} class="form-radio text-blue-400 dark:text-lime-400">
                                <span class="ml-2 dark:text-gray-100">{{ __('Masculino') }}</span>
                            </label>
                            <label for="female" class="inline-flex items-center ml-4">
                                <input type="radio" id="female" name="gender" value="female" {{ old('gender') == 'female' ? 'checked' : '' }} class="form-radio text-blue-400 dark:text-lime-400">
                                <span class="ml-2 dark:text-gray-100">{{ __('Feminino') }}</span>
                            </label>
                            <label for="other" class="inline-flex items-center ml-4">
                                <input type="radio" id="other" name="gender" value="other" {{ old('gender') == 'other' ? 'checked' : '' }} class="form-radio text-blue-400 dark:text-lime-400">
                                <span class="ml-2 dark:text-gray-100">{{ __('Outro') }}</span>
                            </label>
                        </div>
                    </div>
                    <div id="other_gender_container" class="hidden mt-1">  <x-text-input id="other_gender" class="block mt-1 w-full dark:text-black dark:bg-gray-300" type="text" name="other_gender" :value="old('other_gender')" placeholder="{{ __('Específica') }}" />
                        <x-input-error :messages="$errors->get('other_gender')" class="mt-2 text-red-500" />
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- NIF -->
                    <div>
                        <x-input-label for="nif" :value="__('NIF')"/>
                        <x-text-input id="nif" class="block mt-1 w-full text-gray-800 dark:text-black dark:bg-gray-300" type="text" name="nif" maxlength="9" pattern="\d{9}" :value="old('nif')" required autocomplete="nif" />
                        <x-input-error :messages="$errors->get('nif')" class="mt-2 text-red-500" />
                    </div>

                    <!-- CC Number -->
                    <div>
                        <x-input-label for="cc_number" :value="__('Nº Cartão de Cidadão')"/>
                        <x-text-input id="cc_number" class="block mt-1 w-full text-gray-800 dark:text-black dark:bg-gray-300" type="text" name="cc_number" maxlength="9" pattern="\d{9}" :value="old('cc_number')" required autocomplete="cc_number" />
                        <x-input-error :messages="$errors->get('cc_number')" class="mt-2 text-red-500" />
                    </div>
                </div>


                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')"/>
                        <x-text-input id="password" class="block mt-1 w-full text-gray-800 dark:text-black dark:bg-gray-300" type="password" name="password" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <x-input-label for="password_confirmation" :value="__('Confirmar Password')"/>
                        <x-text-input id="password_confirmation" class="block mt-1 w-full text-gray-800 dark:text-black dark:bg-gray-300" type="password" name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500" />
                    </div>
                </div>

                <!-- Address -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="name" :value="__('Nome da Morada')"/>
                        <x-text-input id="name" class="block mt-1 w-full text-gray-800 dark:text-black dark:bg-gray-300" type="text" name="name" :value="old('name')" required autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-500" />
                    </div>
                    <div>
                        <x-input-label for="street" : :value="__('Morada')"/>
                        <x-text-input id="street" class="block mt-1 w-full text-gray-800 dark:text-black dark:bg-gray-300" type="text" name="street" :value="old('street')" required autocomplete="street" />
                        <x-input-error :messages="$errors->get('street')" class="mt-2 text-red-500" />
                    </div>
                </div>
                <!-- Postal Code -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="postal_code" :value="__('Código Postal')"/>
                        <x-text-input id="postal_code" class="block mt-1 w-full text-gray-800 dark:text-black dark:bg-gray-300" type="text" name="postal_code" maxlength="8" pattern="\d{4}-\d{3}" :value="old('postal_code')" required autocomplete="postal_code" />
                        <x-input-error :messages="$errors->get('postal_code')" class="mt-2 text-red-500" />
                    </div>
                    <div>
                        <x-input-label for="city" :value="__('Localidade')"/>
                        <x-text-input id="city" class="block mt-1 w-full text-gray-800 dark:text-black dark:bg-gray-300" type="text" name="city" :value="old('city')" required autocomplete="city" />
                        <x-input-error :messages="$errors->get('city')" class="mt-2 text-red-500" />
                    </div>
                </div>



                <div class="flex items-center justify-end mt-4">
                    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:ring-blue-500 dark:focus:ring-lime-500 focus:ring-2 focus:ring-offset-2" href="{{ route('login') }}">
                        {{ __('Já estás registado?') }}
                    </a>
                    <x-primary-button class="ms-4 dark:bg-lime-400 hover:dark:bg-lime-200 focus:ring-blue-500 dark:focus:ring-lime-500 focus:ring-2 focus:ring-offset-2">
                        {{ __('Registar') }}
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
                    const postalCodeInput = document.getElementById('postal_code');

                    postalCodeInput.addEventListener('input', function () {
                        let value = this.value.replace(/\D/g, '');
                        const regex = /^(\d{0,4})(\d{0,3})$/;

                        value = value.replace(regex, function (match, group1, group2) {
                            if (group2) {
                                return group1 + '-' + group2;
                            } else {
                                return group1;
                            }
                        });

                        this.value = value;
                    });

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
