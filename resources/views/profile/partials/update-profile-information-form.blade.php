<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Informação do Perfil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Atualize as informações do seu perfil.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label class="dark:text-white text-gray-800" for="full_name" :value="__('Nome Completo')" />
            <x-text-input id="full_name" name="full_name" type="text" class="mt-1 block w-full dark:text-black text-gray-800" :value="old('full_name', $user->full_name)" required autofocus autocomplete="full_name" />
            <x-input-error class="mt-2" :messages="$errors->get('full_name')" />
        </div>

        <!-- Phone Number -->
        <div>
            <x-input-label class="dark:text-white text-gray-800" for="phone_number" :value="__('Nº Telemóvel')" />
            <x-text-input id="phone_number" name="phone_number" class="mt-1 block w-full dark:text-black text-gray-800" maxlength="9" pattern="\d{9}" :value="old('phone_number', $user->phone_number)" required autocomplete="phone_number" />
            <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
        </div>

        <!-- Gender -->
        <div>
            <x-input-label class="dark:text-white text-gray-800" for="gender" :value="__('Género')" />
            <div class="block mt-1 w-full">
                <label for="male" class="inline-flex items-center">
                    <input type="radio" id="male" name="gender" value="male" {{ old('gender', $user->gender) == 'male' ? 'checked' : '' }} class="form-radio form-radio text-blue-500 dark:text-lime-400">
                    <x-input-label :value="__('Masculino')" class="ml-2 dark:text-white text-gray-800" />
                </label>
                <label for="female" class="inline-flex items-center ml-4">
                    <input type="radio" id="female" name="gender" value="female" {{ old('gender', $user->gender) == 'female' ? 'checked' : '' }} class="form-radio form-radio text-blue-500 dark:text-lime-400">
                    <x-input-label :value="__('Feminino')" class="ml-2 dark:text-white text-gray-800" />
                </label>
                <label for="other" class="inline-flex items-center ml-4">
                    <input type="radio" id="other" name="gender" value="other" {{ old('gender', $user->gender) != 'male' && old('gender', $user->gender) != 'female' ? 'checked' : '' }} class="form-radio form-radio text-blue-500 dark:text-lime-400">
                    <x-input-label :value="__('Outro')" class="ml-2 dark:text-white text-gray-800" />
                </label>
            </div>
            <div id="other_gender_container" class="block mt-1 w-full" style="{{ old('gender', $user->gender) != 'male' && old('gender', $user->gender) != 'female' ? 'display: block;' : 'display: none;' }}">
                <x-text-input id="other_gender" class="block mt-1 w-full dark:text-gray-800 text-gray-800" type="text" name="other_gender" :value="old('other_gender', old('gender', $user->gender) != 'male' && old('gender', $user->gender) != 'female' ? $user->gender : '')" placeholder="{{ __('Specify') }}" />
                <x-input-error :messages="$errors->get('other_gender')" class="mt-2" />
            </div>
            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Guardar') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Guardado.') }}</p>
            @endif
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const otherRadio = document.getElementById('other');
            const otherGenderContainer = document.getElementById('other_gender_container');
            const otherGenderInput = document.getElementById('other_gender');
            const maleRadio = document.getElementById('male');
            const femaleRadio = document.getElementById('female');

            const handleOtherGenderInput = () => {
                if (otherRadio.checked) {
                    otherGenderContainer.style.display = 'block';
                    otherGenderInput.focus();
                    otherGenderInput.required = true;
                } else {
                    otherGenderContainer.style.display = 'none';
                    otherGenderInput.value = '';
                    otherGenderInput.required = false;
                }
            };

            const handleMaleFemaleChange = () => {
                if (!otherRadio.checked) {
                    otherGenderContainer.style.display = 'none';
                    otherGenderInput.value = '';
                }
            };

            otherRadio.addEventListener('change', handleOtherGenderInput);
            maleRadio.addEventListener('change', handleMaleFemaleChange);
            femaleRadio.addEventListener('change', handleMaleFemaleChange);

            handleOtherGenderInput();
        });
    </script>
</section>
