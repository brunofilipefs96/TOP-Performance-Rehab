<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center select-none">
        <div class="max-w-4xl w-full bg-white dark:bg-black shadow-lg rounded-lg p-8">
            <a href="{{ url('/') }}">
                <img src="{{ asset('images/atec.png') }}" class="w-24 h-auto mx-auto pb-4">
            </a>
            <h2 class="text-4xl font-bold text-center mb-1 p-2 dark:text-gray-200">Crie a sua conta</h2>
            <h2 class="text-xl text-center mb-6 text-lime-400">Preencha os seus dados</h2>
            <hr>
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <div>
                    <x-input-label for="full_name" :value="__('Nome Completo')" />
                    <x-text-input id="full_name" class="block mt-1 w-full" type="text" name="full_name" :value="old('full_name')" required autofocus autocomplete="full_name" />
                    <x-input-error :messages="$errors->get('full_name')" />
                </div>

                <div>
                    <x-input-label for="birth_date" :value="__('Data de Nascimento')" />
                    <x-text-input id="birth_date" class="block mt-1 w-full" type="date" name="birth_date" :value="old('birth_date')" required autocomplete="birth_date" />
                    <x-input-error :messages="$errors->get('birth_date')" />
                </div>

                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" />
                </div>

                <div>
                    <x-input-label for="phone_number" :value="__('Nº Telemóvel')" />
                    <x-text-input id="phone_number" class="block mt-1 w-full" type="tel" name="phone_number" maxlength="9" pattern="\d{9}" :value="old('phone_number')" required autocomplete="tel" />
                    <x-input-error :messages="$errors->get('phone_number')" />
                </div>

                <!-- Gender -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="gender" :value="__('Género')" class="text-white" />
                        <div class="mt-1">
                            <label for="male" class="inline-flex items-center text-white">
                                <input type="radio" id="male" name="gender" value="male" {{ old('gender') == 'male' ? 'checked' : '' }} class="form-radio dark:text-black bg-gray-700 dark:bg-gray-300">
                                <span class="ml-2">{{ __('Masculino') }}</span>
                            </label>
                            <label for="female" class="inline-flex items-center ml-4 text-white">
                                <input type="radio" id="female" name="gender" value="female" {{ old('gender') == 'female' ? 'checked' : '' }} class="form-radio dark:text-black bg-gray-700 dark:bg-gray-300">
                                <span class="ml-2">{{ __('Feminino') }}</span>
                            </label>
                            <label for="other" class="inline-flex items-center ml-4 text-white">
                                <input type="radio" id="other" name="gender" value="other" {{ old('gender') == 'other' ? 'checked' : '' }} class="form-radio dark:text-black bg-gray-700 dark:bg-gray-300">
                                <span class="ml-2">{{ __('Outro') }}</span>
                            </label>
                        </div>
                    </div>
                    <div id="other_gender_container" class="hidden mt-1">  <x-text-input id="other_gender" class="block mt-1 w-full bg-gray-700 dark:text-black text-white dark:bg-gray-300" type="text" name="other_gender" :value="old('other_gender')" placeholder="{{ __('Específica') }}" />
                        <x-input-error :messages="$errors->get('other_gender')" class="mt-2 text-red-500" />
                    </div>
                </div>

                <div>
                    <x-input-label for="nif" :value="__('NIF')" />
                    <x-text-input id="nif" class="block mt-1 w-full" type="text" name="nif" maxlength="9" pattern="\d{9}" :value="old('nif')" required autocomplete="nif" />
                    <x-input-error :messages="$errors->get('nif')" />
                </div>

                <div>
                    <x-input-label for="cc_number" :value="__('Nº Cartão de Cidadão')" />
                    <x-text-input id="cc_number" class="block mt-1 w-full" type="text" name="cc_number" maxlength="10" :value="old('cc_number')" required autocomplete="cc_number" />
                    <x-input-error :messages="$errors->get('cc_number')" />
                </div>

                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" />
                </div>

                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirmar Password')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                        {{ __('Já estás registado?') }}
                    </a>
                    <x-primary-button class="ms-4 hover:bg-gray-200">
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
