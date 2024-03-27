<div class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] md:row-span-1 md:col-span-2 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800">
    <form class="mx-auto" action="{{ route('link.store') }}" method="POST">
    @csrf
    <div class="space-y-12">
        <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-12">
            <div class="sm:col-span-5">
                <x-input-label for="link" :value="__('Long url')" />
                <x-text-input id="link" name="link" type="text" class="mt-1 block w-full" />
                <x-input-error class="mt-2" :messages="$errors->get('link')" />
            </div>

            <div class="sm:col-span-5">
                <x-input-label for="short" :value="__('Shortened')" />
                <x-text-input id="short" name="short" type="text" class="mt-1 block w-full" />
                <x-input-error class="mt-2" :messages="$errors->get('short')" />
            </div>

            <div class="sm:col-span-2">
                <label for="submit" class="block">&nbsp;</label>
                <div class="mt-2">
                    <x-primary-button>Saīsināt</x-primary-button>
                </div>
            </div>
        </div>
        @session('status')
        <div>
            Saīsināts: <a href="{{ $value }}">{{ $value }}</a>
        </div>
        @endsession
    </div>
    </form>
</div>
