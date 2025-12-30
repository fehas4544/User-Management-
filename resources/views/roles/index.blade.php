<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('messages.role_management') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-3xl border border-gray-100">
                <div class="p-8">
                    @if (session('success'))
                    <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-xl mb-8 flex items-center shadow-sm" role="alert">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span class="font-bold">{{ session('success') }}</span>
                    </div>
                    @endif

                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
                        <div>
                            <h3 class="text-3xl font-black text-gray-900 tracking-tight">{{ __('messages.access_control') }}</h3>
                            <p class="text-sm text-gray-500 mt-1 font-medium italic">{{ __('messages.manage_system_roles') }}</p>
                        </div>
                        @can('create-roles')
                        <a href="{{ route('roles.create') }}" class="inline-flex items-center px-6 py-4 bg-gray-900 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-blue-600 hover:shadow-xl hover:shadow-blue-200 hover:-translate-y-1 transition-all">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                            {{ __('messages.create_new_role') }}
                        </a>
                        @endcan
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($roles as $role)
                        <div class="bg-white rounded-3xl border border-gray-100 shadow-xl overflow-hidden group hover:border-blue-200 transition-all duration-300 flex flex-col">
                            <div class="p-6 bg-gray-50/50 border-b border-gray-100 flex justify-between items-center">
                                <div>
                                    <h4 class="text-xl font-black text-gray-900">{{ $role->name }}</h4>
                                    <span class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">{{ __('messages.id') }}: #{{ $role->id }}</span>
                                </div>
                                <div class="bg-white p-2 rounded-xl shadow-sm">
                                    <span class="text-blue-600 font-black text-xs px-2">{{ $role->permissions->count() }} {{ __('messages.perms') }}</span>
                                </div>
                            </div>
                            
                            <div class="p-6 flex-grow">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-4">{{ __('messages.core_privileges') }}</label>
                                <div class="flex flex-wrap gap-2">
                                    @forelse($role->permissions->take(8) as $permission)
                                        <span class="inline-flex items-center px-2 py-1 bg-blue-50 text-[10px] font-black text-blue-700 rounded-lg border border-blue-100 uppercase tabular-nums">
                                            {{ str_replace('-', ' ', $permission->name) }}
                                        </span>
                                    @empty
                                        <span class="text-xs text-gray-400 italic font-medium">{{ __('messages.no_permissions') }}</span>
                                    @endforelse
                                    @if($role->permissions->count() > 8)
                                        <span class="inline-flex items-center px-2 py-1 bg-gray-100 text-[10px] font-black text-gray-500 rounded-lg border border-gray-200 uppercase tabular-nums">
                                            +{{ $role->permissions->count() - 8 }} {{ __('messages.more') }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="p-6 bg-gray-50/30 border-t border-gray-100 flex items-center justify-between">
                                <div class="text-[10px] text-gray-400 font-bold">
                                    {{ __('messages.created_at') }} {{ $role->created_at->diffForHumans() }}
                                </div>
                                <div class="flex space-x-2">
                                    @can('edit-roles')
                                    <a href="{{ route('roles.edit', $role->id) }}" class="p-2 bg-white text-gray-400 rounded-xl border border-gray-100 shadow-sm hover:text-blue-600 hover:border-blue-200 transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 00-2 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    @endcan
                                    @can('delete-roles')
                                    <form action="{{ route('roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('{{ __('messages.confirm_delete_role') }}');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 bg-white text-gray-400 rounded-xl border border-gray-100 shadow-sm hover:text-red-600 hover:border-red-200 transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                    @endcan
                                </div>

                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
