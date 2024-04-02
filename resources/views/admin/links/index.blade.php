<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Links') }}
        </h2>
    </x-slot>


    <div class="max-w-7xl mx-auto">
        <x-admin-link-list :links="$links"></x-admin-link-list>
    </div>
    </div>

</x-app-layout>

