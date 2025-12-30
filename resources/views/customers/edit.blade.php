<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Customer: {{ $customer->name }}</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form action="{{ route('customers.update', $customer->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="block text-sm font-medium">Name</label>
                        <input type="text" name="name" value="{{ $customer->name }}" class="w-full rounded-md border-gray-300" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium">Phone</label>
                        <input type="text" name="phone" value="{{ $customer->phone }}" class="w-full rounded-md border-gray-300" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium">Email</label>
                        <input type="email" name="email" value="{{ $customer->email }}" class="w-full rounded-md border-gray-300">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium">Address</label>
                        <textarea name="address" class="w-full rounded-md border-gray-300">{{ $customer->address }}</textarea>
                    </div>
                    <div class="flex justify-end mt-4">
                        <a href="{{ route('customers.index') }}" class="mr-4 px-4 py-2 bg-gray-500 text-white rounded">Cancel</a>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Update Customer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
