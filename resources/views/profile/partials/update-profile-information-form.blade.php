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
            <x-input-label for="full_name" :value="__('Full Name')" />
            <x-text-input id="full_name" name="full_name" type="text" class="mt-1 block w-full" :value="old('full_name', $user->full_name)" required autofocus autocomplete="full_name" />
            <x-input-error class="mt-2" :messages="$errors->get('full_name')" />
        </div>

        <div>
            <x-input-label for="birth_date" :value="__('Birth Date')" />
            <x-text-input id="birth_date" name="birth_date" class="mt-1 block w-full" type="date" :value="old('birth_date', $user->birth_date)" required />
            <x-input-error class="mt-2" :messages="$errors->get('birth_date')" />
        </div>

        <!-- Phone Number -->
        <div>
            <x-input-label for="phone_number" :value="__('Phone Number')" />
            <x-text-input id="phone_number" name="phone_number" class="mt-1 block w-full" :value="old('phone_number', $user->phone_number)" required autocomplete="phone_number" />
            <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
        </div>

        <!-- Gender -->
        <div>
            <x-input-label for="gender" :value="__('Gender')" />
            <div class="block mt-1 w-full">
                <label for="male" class="inline-flex items-center">
                    <input type="radio" id="male" name="gender" value="male" {{ old('gender', $user->gender) == 'male' ? 'checked' : '' }} class="form-radio">
                    <x-input-label :value="__('Male')" class="ml-2" />
                </label>
                <label for="female" class="inline-flex items-center ml-4">
                    <input type="radio" id="female" name="gender" value="female" {{ old('gender', $user->gender) == 'female' ? 'checked' : '' }} class="form-radio">
                    <x-input-label :value="__('Female')" class="ml-2" />
                </label>
                <label for="other" class="inline-flex items-center ml-4">
                    <input type="radio" id="other" name="gender" value="other" {{ old('gender', $user->gender) != 'male' && old('gender', $user->gender) != 'female' ? 'checked' : '' }} class="form-radio">
                    <x-input-label :value="__('Other')" class="ml-2" />
                </label>
            </div>
            <div id="other_gender_container" class="block mt-1 w-full" style="{{ old('gender', $user->gender) != 'male' && old('gender', $user->gender) != 'female' ? 'display: block;' : 'display: none;' }}">
                <x-text-input id="other_gender" class="block mt-1 w-full" type="text" name="other_gender" :value="old('other_gender', old('gender', $user->gender) != 'male' && old('gender', $user->gender) != 'female' ? $user->gender : '')" placeholder="{{ __('Specify') }}" />
                <x-input-error :messages="$errors->get('other_gender')" class="mt-2" />
            </div>
            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
        </div>

        <!-- NIF -->
        <div>
            <x-input-label for="nif" :value="__('NIF')" />
            <x-text-input id="nif" name="nif" type="text" class="mt-1 block w-full" :value="old('nif', $user->nif)" required autocomplete="nif" />
            <x-input-error class="mt-2" :messages="$errors->get('nif')" />
        </div>

        <!-- CC Number -->
        <div>
            <x-input-label for="cc_number" :value="__('CC Number')" />
            <x-text-input id="cc_number" name="cc_number" type="text" class="mt-1 block w-full" :value="old('cc_number', $user->cc_number)" required autocomplete="cc_number" />
            <x-input-error class="mt-2" :messages="$errors->get('cc_number')" />
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
