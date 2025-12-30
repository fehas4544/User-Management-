@php
    $permissionGroups = [
        'User Management' => ['view-users', 'create-users', 'edit-users', 'delete-users'],
        'Role Management' => ['view-roles', 'create-roles', 'edit-roles', 'delete-roles'],
        'Product Management' => ['view-products', 'create-products', 'edit-products', 'delete-products'],
        'Customer Management' => ['view-customers', 'create-customers', 'edit-customers', 'delete-customers'],
        'Sales Management' => ['view-sales', 'create-sales', 'edit-sales', 'delete-sales', 'view-invoices'],
        'Dashboard & Reports' => ['view-dashboard', 'view-reports'],
    ];
@endphp

<div class="space-y-6">
    @foreach($permissionGroups as $group => $perms)
    <div class="bg-gray-50 rounded-xl border border-gray-200 overflow-hidden shadow-sm">
        <div class="bg-gray-100 px-4 py-3 border-b border-gray-200 flex justify-between items-center">
            <h4 class="text-xs font-black text-gray-500 uppercase tracking-widest">{{ $group }}</h4>
            <div class="flex items-center space-x-2">
                <span class="text-[10px] text-gray-400 font-bold uppercase">Select All</span>
                <input type="checkbox" class="group-select h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded cursor-pointer" onclick="toggleGroup(this)">
            </div>
        </div>
        <div class="p-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($perms as $permName)
                @php
                    $permission = $permissions->where('name', $permName)->first();
                    $hasPermission = isset($role) && $role->hasPermissionTo($permName);
                @endphp
                @if($permission)
                <label class="relative flex items-center p-3 rounded-lg border border-gray-100 bg-white hover:border-blue-200 hover:bg-blue-50/30 transition-all cursor-pointer group shadow-sm">
                    <input type="checkbox" name="permissions[]" value="{{ $permName }}" 
                        {{ $hasPermission ? 'checked' : '' }}
                        class="perm-check h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded-md transition-all cursor-pointer">
                    <div class="ml-3">
                        <span class="block text-xs font-bold text-gray-700 group-hover:text-blue-700 transition-colors">
                            {{ ucwords(str_replace('-', ' ', $permName)) }}
                        </span>
                    </div>
                </label>
                @endif
            @endforeach
        </div>
    </div>
    @endforeach
</div>

<script>
    function toggleGroup(checkbox) {
        const container = checkbox.closest('.bg-gray-50');
        const checks = container.querySelectorAll('.perm-check');
        checks.forEach(c => c.checked = checkbox.checked);
    }
    
    // Auto-update group header checkbox based on children
    document.querySelectorAll('.perm-check').forEach(check => {
        check.addEventListener('change', function() {
            const container = this.closest('.bg-gray-50');
            const checks = container.querySelectorAll('.perm-check');
            const groupSelect = container.querySelector('.group-select');
            const allChecked = Array.from(checks).every(c => c.checked);
            groupSelect.checked = allChecked;
        });
    });
</script>

<style>
    /* Custom switch styling if needed */
</style>
