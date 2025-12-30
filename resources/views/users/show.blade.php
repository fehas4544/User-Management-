<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Show User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <a href="{{ route('users.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm font-medium hover:bg-blue-700">
                            &larr; Back
                        </a>
                    </div>

                    <div class="mb-4">
                        <strong class="block text-gray-700">Name:</strong>
                        <span>{{ $user->name }}</span>
                    </div>

                    <div class="mb-4">
                        <strong class="block text-gray-700">Email:</strong>
                        <span>{{ $user->email }}</span>
                    </div>

                    <div class="mb-4">
                        <strong class="block text-gray-700">Role:</strong>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            {{ $user->role }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
