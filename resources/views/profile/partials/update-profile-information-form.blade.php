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

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Profile Photo -->
        <div class="flex flex-col md:flex-row items-center gap-4 relative">
            <div class="relative">
                <label for="image" class="cursor-pointer">
                    @if ($user->image)
                        <img id="profile-image-preview" src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->name }}" class="w-20 h-20 rounded-full object-cover border-2 border-gray-300 dark:border-gray-600 shadow-sm">
                        <button type="button" id="remove-profile-image-button" class="absolute bottom-0 right-0 bg-red-500 text-white rounded-full p-1" title="Remover Imagem">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    @else
                        <i id="profile-image-icon" class="fa-solid fa-user w-20 h-20 rounded-full border-2 border-gray-300 dark:border-gray-600 shadow-sm flex items-center justify-center text-gray-800 dark:text-white"></i>
                    @endif
                </label>
                <input type="file" name="image" id="image" class="hidden" accept="image/*" onchange="previewImage(event)">
            </div>
            <div>
                <x-input-label class="dark:text-white text-gray-800" for="image" :value="__('Foto de Perfil')" />
                <x-input-error class="mt-2" :messages="$errors->get('image')" />
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Clique na imagem para alterar sua foto de perfil.') }}</p>
            </div>
        </div>

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
                    <input type="radio" id="male" name="gender" value="male" {{ old('gender', $user->gender) == 'male' ? 'checked' : '' }} class="form-radio text-blue-500 dark:text-lime-400">
                    <x-input-label :value="__('Masculino')" class="ml-2 dark:text-white text-gray-800" />
                </label>
                <label for="female" class="inline-flex items-center ml-4">
                    <input type="radio" id="female" name="gender" value="female" {{ old('gender', $user->gender) == 'female' ? 'checked' : '' }} class="form-radio text-blue-500 dark:text-lime-400">
                    <x-input-label :value="__('Feminino')" class="ml-2 dark:text-white text-gray-800" />
                </label>
                <label for="other" class="inline-flex items-center ml-4">
                    <input type="radio" id="other" name="gender" value="other" {{ old('gender', $user->gender) != 'male' && old('gender', $user->gender) != 'female' ? 'checked' : '' }} class="form-radio text-blue-500 dark:text-lime-400">
                    <x-input-label :value="__('Outro')" class="ml-2 dark:text-white text-gray-800" />
                </label>
            </div>
            <div id="other_gender_container" class="block mt-1 w-full" style="{{ old('gender', $user->gender) != 'male' && old('gender', $user->gender) != 'female' ? 'display: block;' : 'display: none;' }}">
                <x-text-input id="other_gender" class="block mt-1 w-full dark:text-gray-800 text-gray-800" type="text" name="other_gender" :value="old('other_gender', old('gender', $user->gender) != 'male' && old('gender', $user->gender) != 'female' ? $user->gender : '')" placeholder="{{ __('Especificar') }}" />
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

    <!-- Confirmation Modal -->
    <div id="confirmation-modal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden z-50">
        <div class="bg-gray-300 dark:bg-gray-900 p-6 rounded-md shadow-md w-96">
            <h2 class="text-xl font-bold mb-4 dark:text-white text-gray-800" id="confirmation-title">Pretende eliminar?</h2>
            <p class="mb-4 text-red-500 dark:text-red-300" id="confirmation-message">Não poderá reverter isso!</p>
            <div class="flex justify-end gap-4">
                <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-400" onclick="cancelAction()">Cancelar</button>
                <button type="button" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-500" onclick="confirmAction()">Confirmar</button>
            </div>
        </div>
    </div>

    <form id="remove-image-form" method="post" action="{{ route('profile.removeImage') }}" class="hidden">
        @csrf
        @method('delete')
    </form>

    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('profile-image-preview');
                    const icon = document.getElementById('profile-image-icon');
                    if (preview) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                        if (icon) icon.style.display = 'none';
                    } else if (icon) {
                        icon.classList.add('hidden');
                        const img = document.createElement('img');
                        img.id = 'profile-image-preview';
                        img.src = e.target.result;
                        img.alt = 'Profile Image Preview';
                        img.className = 'w-20 h-20 rounded-full object-cover border-2 border-gray-300 dark:border-gray-600 shadow-sm';
                        icon.parentNode.insertBefore(img, icon);
                    }
                }
                reader.readAsDataURL(file);
            }
        }

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

            // Modal logic
            const removeButton = document.getElementById('remove-profile-image-button');
            const modal = document.getElementById('confirmation-modal');
            const removeImageForm = document.getElementById('remove-image-form');

            if (removeButton) {
                removeButton.addEventListener('click', function() {
                    modal.classList.remove('hidden');
                });
            }

            window.cancelAction = function() {
                modal.classList.add('hidden');
            }

            window.confirmAction = function() {
                removeImageForm.submit();
            }
        });
    </script>
</section>
