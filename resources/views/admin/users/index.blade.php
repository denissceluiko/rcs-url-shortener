<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('User management') }}
        </h2>
    </x-slot>


    <div class="max-w-7xl mx-auto">
        <x-admin-user-list :users="$users"></x-admin-user-list>
    </div>
    </div>

</x-app-layout>

