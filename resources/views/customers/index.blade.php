<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('messages.customers') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">{{ __('messages.customers') }}</h3>
                        @can('create-customers')
                        <a href="{{ route('customers.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-blue-500">
                            {{ __('messages.add_customer') }}
                        </a>
                        @endcan
                    </div>
                    
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th class="px-6 py-3">{{ __('messages.name') }}</th>
                                <th class="px-6 py-3">{{ __('messages.phone') }}</th>
                                <th class="px-6 py-3">{{ __('messages.email') }}</th>
                                <th class="px-6 py-3">{{ __('messages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customers as $customer)
                            <tr class="bg-white border-b">
                                <td class="px-6 py-4">{{ $customer->name }}</td>
                                <td class="px-6 py-4">{{ $customer->phone }}</td>
                                <td class="px-6 py-4">{{ $customer->email }}</td>
                                <td class="px-6 py-4 flex space-x-2">
                                    @can('edit-customers')
                                    <a href="{{ route('customers.edit', $customer->id) }}" class="text-blue-600 hover:text-blue-900">{{ __('messages.edit') }}</a>
                                    @endcan
                                    @can('delete-customers')
                                    <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" onsubmit="return confirm('{{ __('messages.are_you_sure_delete') }}')">
                                        @csrf @method('DELETE')
                                        <button class="text-red-600 hover:text-red-900">{{ __('messages.delete') }}</button>
                                    </form>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">{{ $customers->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
