<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Role') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-3xl border border-gray-100">
                <div class="p-8">
                    <div class="flex items-center justify-between mb-8 border-b border-gray-100 pb-6">
                        <div>
                            <h3 class="text-2xl font-black text-gray-900 tracking-tight">Create New Role</h3>
                            <p class="text-sm text-gray-500 mt-1 font-medium">Define access levels and system permissions</p>
                        </div>
                        <a href="{{ route('roles.index') }}" class="p-3 bg-gray-50 text-gray-400 rounded-2xl hover:bg-gray-100 hover:text-gray-600 transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </a>
                    </div>

                    <form action="{{ route('roles.store') }}" method="POST">
                        @csrf
                        <div class="mb-10 lg:w-1/3">
                            <label for="name" class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Role Identity</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-300 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                                <input type="text" name="name" id="name" placeholder="e.g., Inventory Manager" 
                                    class="pl-11 block w-full rounded-2xl border-gray-100 bg-gray-50/50 shadow-inner focus:border-blue-500 focus:ring-blue-500/20 py-4 font-bold text-gray-900 transition-all" required autofocus>
                            </div>
                            @error('name')
                                <p class="mt-2 text-sm text-red-600 font-bold flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="mb-10">
                            <div class="flex items-center justify-between mb-6">
                                <label class="block text-xs font-black text-gray-400 uppercase tracking-widest">Capabilities Matrix</label>
                                <span class="text-[10px] bg-blue-50 text-blue-600 px-3 py-1 rounded-full font-black uppercase">Granular Access Control</span>
                            </div>
                            
                            @include('roles.partials.permission-matrix', ['permissions' => $permissions])
                        </div>

                        <div class="flex items-center justify-between border-t border-gray-100 pt-8">
                            <button type="button" onclick="window.history.back()" class="text-sm font-bold text-gray-400 hover:text-gray-600 transition-colors">discard changes</button>
                            <button type="submit" class="px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-700 text-white rounded-2xl font-black text-sm uppercase tracking-widest shadow-xl shadow-blue-200 hover:shadow-2xl hover:scale-[1.02] active:scale-95 transition-all">
                                finalize & create role
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
