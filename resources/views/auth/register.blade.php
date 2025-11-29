@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf

            <!-- Full Name -->
            <div>
                <x-input-label for="name" :value="__('Full Name')" />
                <x-text-input id="name" class="block mt-1 w-full" 
                             type="text" 
                             name="name" 
                             :value="old('name')" 
                             required 
                             autofocus 
                             autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" 
                             type="email" 
                             name="email" 
                             :value="old('email')" 
                             required 
                             autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Profile Picture -->
            <div class="mt-4">
                <x-input-label for="avatar" :value="__('Profile Picture (Optional)')" />
                <input id="avatar" class="block mt-1 w-full" 
                       type="file" 
                       name="avatar" 
                       accept="image/*" 
                       onchange="previewImage(this)">
                <x-input-error :messages="$errors->get('avatar')" class="mt-2" />
                <div class="mt-2" id="imagePreview" style="display: none;">
                    <img id="preview" class="h-20 w-20 rounded-full object-cover" src="#" alt="Preview" />
                </div>
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full"
                             type="password"
                             name="password"
                             required 
                             autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                             type="password"
                             name="password_confirmation" 
                             required 
                             autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" 
                   href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-primary-button class="ms-4">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function previewImage(input) {
        const preview = document.getElementById('preview');
        const previewDiv = document.getElementById('imagePreview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewDiv.style.display = 'block';
            }
            
            reader.readAsDataURL(input.files[0]);
        } else {
            previewDiv.style.display = 'none';
        }
    }
</script>
@endpush
@endsection
