<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 grid grid-cols-6 gap-4 max-w-7xl mx-auto content-start">
        <x-card name="Links" :value="$stats['links']"></x-card>
        <x-card name="Users" :value="$stats['users']"></x-card>
    </div>
</x-app-layout>
