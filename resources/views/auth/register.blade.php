<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-label for="name" value="{{ __('Name') }}" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            </div>

            <!-- Role Selection -->
            <div class="mt-4">
                <x-label for="role" value="{{ __('Register as') }}" />
                <select id="role" name="role" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required onchange="toggleRoleFields()">
                    <option value="">-- Pilih Role --</option>
                    <option value="konsumen" {{ old('role') == 'konsumen' ? 'selected' : '' }}>Customer</option>
                    <option value="mekanik" {{ old('role') == 'mekanik' ? 'selected' : '' }}>Mechanic</option>
                </select>
            </div>

            <!-- Konsumen Fields -->
            <div id="konsumen-fields" class="mt-4" style="display: none;">
                <x-label for="alamat_konsumen" value="{{ __('Address') }}" />
                <textarea id="alamat_konsumen" name="alamat_konsumen" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" rows="3" placeholder="Enter your full address">{{ old('alamat_konsumen') }}</textarea>
            </div>

            <!-- Mekanik Fields -->
            <div id="mekanik-fields" class="mt-4" style="display: none;">
                <x-label for="kuantitas_hari" value="{{ __('Working Days per Week') }}" />
                <select id="kuantitas_hari" name="kuantitas_hari" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="">-- Select Working Days --</option>
                    <option value="5" {{ old('kuantitas_hari') == '5' ? 'selected' : '' }}>5 Days (Mon-Fri)</option>
                    <option value="6" {{ old('kuantitas_hari') == '6' ? 'selected' : '' }}>6 Days (Mon-Sat)</option>
                    <option value="7" {{ old('kuantitas_hari') == '7' ? 'selected' : '' }}>7 Days (Full Week)</option>
                </select>
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ml-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>

    <script>
        function toggleRoleFields() {
            const role = document.getElementById('role').value;
            const konsumenFields = document.getElementById('konsumen-fields');
            const mekanikFields = document.getElementById('mekanik-fields');
            
            // Hide all fields first
            konsumenFields.style.display = 'none';
            mekanikFields.style.display = 'none';
            
            // Clear required attributes
            document.getElementById('alamat_konsumen').removeAttribute('required');
            document.getElementById('kuantitas_hari').removeAttribute('required');
            
            // Show and set required based on role
            if (role === 'konsumen') {
                konsumenFields.style.display = 'block';
                document.getElementById('alamat_konsumen').setAttribute('required', 'required');
            } else if (role === 'mekanik') {
                mekanikFields.style.display = 'block';
                document.getElementById('kuantitas_hari').setAttribute('required', 'required');
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            toggleRoleFields();
        });
    </script>
</x-guest-layout>