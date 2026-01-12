@extends('layouts.app')

@section('title', 'Edit Profile - Zeniro Store')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Page Header -->
        <div class="mb-8">
            <a href="{{ route('user.profile') }}" 
               class="inline-flex items-center gap-2 text-accent-blue hover:text-primary-primaryBlue transition font-sans font-bold mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Profile
            </a>
            <h1 class="text-4xl font-bold font-heading" style="color: #305C8E;">
                Edit Profile
            </h1>
            <p class="text-gray-600 mt-2 font-sans">Update your account information</p>
        </div>

        <!-- Error Messages -->
        @if($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-md">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-red-500 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <p class="font-bold text-red-700 font-sans mb-2">Please fix the following errors:</p>
                        <ul class="list-disc list-inside space-y-1 text-sm text-red-600">
                            @foreach($errors->all() as $error)
                                <li class="font-sans">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('user.profile.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Basic Information -->
            <div class="bg-blue-100 rounded-3xl p-6 shadow-md">
                <h2 class="text-xl font-heading font-bold text-primary-primaryBlue mb-6">Basic Information</h2>

                <div class="space-y-4">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-sans font-bold text-gray-700 mb-2">
                            Full Name <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            value="{{ old('name', $user->name) }}"
                            required
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:border-accent-blue transition font-sans"
                            placeholder="Enter your full name"
                        >
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-sans font-bold text-gray-700 mb-2">
                            Email Address
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            readonly
                            value="{{ old('email', $user->email) }}"
                            required
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:border-accent-blue transition font-sans"
                            placeholder="your.email@example.com"
                        >
                        <p class="text-xs font-sans text-gray mt-1">Email cannot be changed</p>
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-sans font-bold text-gray-700 mb-2">
                            Phone Number
                        </label>
                        <input 
                            type="text" 
                            id="phone" 
                            name="phone" 
                            value="{{ old('phone', $user->phone) }}"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:border-accent-blue transition font-sans"
                            placeholder="+62 812 3456 7890"
                        >
                    </div>
                </div>
            </div>

            <!-- Change Password (Optional) -->
            <div class="bg-blue-100 rounded-3xl p-6 shadow-md">
                <h2 class="text-xl font-heading font-bold text-primary-primaryBlue mb-2">Change Password</h2>
                <p class="text-sm text-gray-600 font-sans mb-6">Leave blank if you don't want to change your password</p>

                <div class="space-y-4">
                    <!-- Current Password -->
                    <div>
                        <label for="current_password" class="block text-sm font-sans font-bold text-gray-700 mb-2">
                            Current Password
                        </label>
                        <input 
                            type="password" 
                            id="current_password" 
                            name="current_password" 
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:border-accent-blue transition font-sans"
                            placeholder="Enter current password"
                        >
                    </div>

                    <!-- New Password -->
                    <div>
                        <label for="new_password" class="block text-sm font-sans font-bold text-gray-700 mb-2">
                            New Password
                        </label>
                        <input 
                            type="password" 
                            id="new_password" 
                            name="new_password" 
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:border-accent-blue transition font-sans"
                            placeholder="Enter new password (min. 8 characters)"
                        >
                    </div>

                    <!-- Confirm New Password -->
                    <div>
                        <label for="new_password_confirmation" class="block text-sm font-sans font-bold text-gray-700 mb-2">
                            Confirm New Password
                        </label>
                        <input 
                            type="password" 
                            id="new_password_confirmation" 
                            name="new_password_confirmation" 
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:border-accent-blue transition font-sans"
                            placeholder="Confirm new password"
                        >
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4">
                <button 
                    type="submit"
                    class="flex-1 bg-accent-blue text-white px-6 py-4 rounded-xl font-sans font-bold hover:bg-accent-blue/90 transition text-lg">
                    Save Changes
                </button>
                <a 
                    href="{{ route('user.profile') }}"
                    class="flex-1 bg-gray-300 text-gray-700 px-6 py-4 rounded-xl font-sans font-bold hover:bg-gray-400 transition text-center text-lg">
                    Cancel
                </a>
            </div>
        </form>

    </div>
</div>
@endsection