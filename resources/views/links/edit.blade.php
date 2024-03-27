<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit link') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <section>
                <header>
                </header>

                <form method="post" action="{{ route('link.update', $link->shortened_url) }}" class="mt-6 space-y-6">
                    @csrf
                    @method('patch')
                    <input type="hidden" name="id" value="{{ $link->id }}">
                    <div>
                        <x-input-label for="full_url" :value="__('Full url')" />
                        <x-text-input id="full_url" name="full_url" type="text" class="mt-1 block w-full" :value="old('full_url', $link->full_url)" required />
                        <x-input-error class="mt-2" :messages="$errors->get('full_url')" />
                    </div>

                    {{-- <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div> --}}

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Save') }}</x-primary-button>

                        {{-- @if (session('status') === 'profile-updated')
                            <p
                                x-data="{ show: true }"
                                x-show="show"
                                x-transition
                                x-init="setTimeout(() => show = false, 2000)"
                                class="text-sm text-gray-600 dark:text-gray-400"
                            >{{ __('Saved.') }}</p>
                        @endif --}}
                    </div>
                </form>
            </section>

        </div>
    </div>

</x-app-layout>

