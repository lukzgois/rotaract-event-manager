<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
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

        <!-- Birth Date -->
        <div class="mt-4">
            <x-input-label for="birth_date" :value="__('Birth Date')" />

            <x-text-input id="birth_date" class="block mt-1 w-full"
                            type="date"
                            :value="old('birth_date')"
                            name="birth_date" required />

            <x-input-error :messages="$errors->get('birth_date')" class="mt-2" />
        </div>

        <!-- Birth Date -->
        <div class="mt-4">
            <x-input-label for="nickname" :value="__('Nickname')" />

            <x-text-input id="nickname" class="block mt-1 w-full"
                            type="text"
                            :value="old('nickname')"
                            name="nickname" required />

            <x-input-error :messages="$errors->get('nickname')" class="mt-2" />
        </div>

        <!-- Phone -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Phone') . ' ' . __('(only numbers)')" />

            <x-text-input id="phone" class="block mt-1 w-full"
                            type="text"
                            :value="old('phone')"
                            name="phone" required />

            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Club -->
        <div class="mt-4">
            <x-input-label for="club_id" :value="__('Club')" />

            <x-select-input id="club_id" class="block mt-1 w-full"
                            :options="$clubs"
                            :selected="old('club_id')"
                            name="club_id" required />

            <x-input-error :messages="$errors->get('club_id')" class="mt-2" />
        </div>

        <!-- Address -->
        <div class="mt-4">
            <x-input-label for="address" :value="__('Address')" />

            <x-text-input id="address" class="block mt-1 w-full"
                            type="text"
                            :value="old('address')"
                            name="address" required />

            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>

        <!-- City -->
        <div class="mt-4">
            <x-input-label for="city" :value="__('City')" />

            <x-text-input id="city" class="block mt-1 w-full"
                            type="text"
                            :value="old('city')"
                            name="city" required />

            <x-input-error :messages="$errors->get('city')" class="mt-2" />
        </div>

        <!-- State -->
        <div class="mt-4">
            <x-input-label for="state" :value="__('State')" />

            <x-select-input id="state" class="block mt-1 w-full"
                            :options="$states"
                            :selected="old('state')"
                            name="state" required />

            <x-input-error :messages="$errors->get('state')" class="mt-2" />
        </div>

        <!-- Zip Code -->
        <div class="mt-4">
            <x-input-label for="zip_code" :value="__('Zip Code') . ' ' . __('(only numbers)')" />

            <x-text-input id="zip_code" class="block mt-1 w-full"
                            type="text"
                            :value="old('zip_code')"
                            name="zip_code" required />

            <x-input-error :messages="$errors->get('zip_code')" class="mt-2" />
        </div>

        <!-- Is Guest -->
        <div class="block mt-4">
            <label for="is_guest" class="inline-flex items-center">
                <input id="is_guest" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="is_guest" @checked(old('is_guest')) />
                <span class="ml-2 text-gray-600 dark:text-gray-400">{{ __('I am a guest') }}</span>
            </label>
        </div>

        <!-- Blood Type -->
        <div class="mt-4">
            <x-input-label for="blood_type" :value="__('Blood type')" />

            <x-select-input id="blood_type" class="block mt-1 w-full"
                            :options="$blood_types"
                            :selected="old('blood_type')"
                            name="blood_type" required />

            <x-input-error :messages="$errors->get('blood_type')" class="mt-2" />
        </div>

        <!-- Emergency Contact Name -->
        <div class="mt-4">
            <x-input-label for="emergency_contact_name" :value="__('Emergency contact name')" />

            <x-text-input id="emergency_contact_name" class="block mt-1 w-full"
                            type="text"
                            :value="old('emergency_contact_name')"
                            name="emergency_contact_name" required />

            <x-input-error :messages="$errors->get('emergency_contact_name')" class="mt-2" />
        </div>

        <!-- Emergency Contact Phone -->
        <div class="mt-4">
            <x-input-label for="emergency_contact_phone" :value="__('Emergency contact phone') . ' ' . __('(only numbers)')" />

            <x-text-input id="emergency_contact_phone" class="block mt-1 w-full"
                            type="text"
                            :value="old('emergency_contact_phone')"
                            name="emergency_contact_phone" required />

            <x-input-error :messages="$errors->get('emergency_contact_phone')" class="mt-2" />
        </div>

        <!-- Allergies -->
        <div class="mt-4">
            <x-input-label for="allergies" :value="__('Have allergies?')" />

            <x-text-input id="allergies" class="block mt-1 w-full"
                            type="text"
                            :value="old('allergies')"
                            name="allergies" />

            <x-input-error :messages="$errors->get('allergies')" class="mt-2" />
        </div>

        <!-- Food Restrictions -->
        <div class="mt-4">
            <x-input-label for="food_restrictions" :value="__('Have some food restriction?')" />

            <x-text-input id="food_restrictions" class="block mt-1 w-full"
                            type="text"
                            :value="old('food_restrictions')"
                            name="food_restrictions" />

            <x-input-error :messages="$errors->get('food_restrictions')" class="mt-2" />
        </div>

        <!-- RG -->
        <div class="mt-4">
            <x-input-label for="rg" :value="__('RG')" />

            <x-text-input id="rg" class="block mt-1 w-full"
                            type="text"
                            :value="old('rg')"
                            name="rg" required />

            <x-input-error :messages="$errors->get('rg')" class="mt-2" />
        </div>

        <!-- CPF -->
        <div class="mt-4">
            <x-input-label for="cpf" :value="__('CPF') . ' ' . __('(only numbers)')" />

            <x-text-input id="cpf" class="block mt-1 w-full"
                            type="text"
                            :value="old('cpf')"
                            name="cpf" required />

            <x-input-error :messages="$errors->get('cpf')" class="mt-2" />
        </div>

        <!-- Agreed -->
        <div class="block mt-4">
            <label for="agreed" class="inline-flex items-center">
                <input id="agreed" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="agreed" />
                <span class="ml-2 text-gray-600 dark:text-gray-400">{{ __('Agreed') }}</span>
            </label>

            <x-input-error :messages="$errors->get('agreed')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
