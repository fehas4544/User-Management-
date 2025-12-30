<aside class="w-56 bg-white border-r border-gray-100 min-h-screen fixed top-0 left-0 pt-16 z-0 hidden lg:block">
    <div class="py-4 px-6">
        <ul class="space-y-2">
            <li>
                <a href="{{ route('dashboard') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group {{ request()->routeIs('dashboard') ? 'bg-gray-100' : '' }}">
                    <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                        <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                        <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
                    </svg>
                    <span class="ms-3">{{ __('Dashboard') }}</span>
                </a>
            </li>
            @can('view-users')
            <li>
                <a href="{{ route('users.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group {{ request()->routeIs('users.*') ? 'bg-gray-100' : '' }}">
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                        <path d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z"/>
                    </svg>
                    <span class="ms-3">{{ __('User') }}</span>
                </a>
            </li>
            @endcan
            @can('view-roles')
            <li>
                <a href="{{ route('roles.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group {{ request()->routeIs('roles.*') ? 'bg-gray-100' : '' }}">
                     <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M5 5a5 5 0 0 1 10 0v2A5 5 0 0 1 5 7V5Zm0 2.968c0 1.15.5 2.193 1.285 2.766A5 5 0 0 1 15 13v.81C15 15.424 13.91 16 12 16H8c-1.927 0-3-.585-3-2.19V13c0-1.895 2.083-2.887 2.083-2.887A4.957 4.957 0 0 1 5 7.968Z"/>
                        <path d="M10 17a8 8 0 1 1 0-16 8 8 0 0 1 0 16Zm0-2a6 6 0 1 0 0-12 6 6 0 0 0 0 12Z"/> 
                    </svg>
                    <span class="ms-3">{{ __('Roles') }}</span>
                </a>
            </li>
            @endcan
            @can('view-products')
            <li>
                <a href="{{ route('products.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group {{ request()->routeIs('products.*') ? 'bg-gray-100' : '' }}">
                    <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20"><path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/></svg>
                    <span class="ms-3">{{ __('messages.products') }}</span>
                </a>
            </li>
            @endcan
            @can('view-customers')
            <li>
                <a href="{{ route('customers.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group {{ request()->routeIs('customers.*') ? 'bg-gray-100' : '' }}">
                    <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/></svg>
                    <span class="ms-3">{{ __('messages.customers') }}</span>
                </a>
            </li>
            @endcan
            @can('view-sales')
            <li>
                <a href="{{ route('sales.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group {{ request()->routeIs('sales.*') ? 'bg-gray-100' : '' }}">
                    <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                        <path d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z"/>
                    </svg>
                    <span class="ms-3">{{ __('messages.sales') }}</span>
                </a>
            </li>
            @endcan
        </ul>

        <div class="mt-8 pt-4 border-t border-gray-100">
            <p class="text-xs text-gray-400 uppercase font-bold mb-2">Language</p>
            <div class="flex flex-col space-y-1">
                <a href="{{ route('lang.switch', 'en') }}" class="text-sm px-2 py-1 rounded {{ app()->getLocale() == 'en' ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50' }}">English</a>
                <a href="{{ route('lang.switch', 'ta') }}" class="text-sm px-2 py-1 rounded {{ app()->getLocale() == 'ta' ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50' }}">Tamil (தமிழ்)</a>
                <a href="{{ route('lang.switch', 'si') }}" class="text-sm px-2 py-1 rounded {{ app()->getLocale() == 'si' ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50' }}">Sinhala (සිංහල)</a>
            </div>
        </div>
    </div>
</aside>
