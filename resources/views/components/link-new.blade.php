<div class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] md:row-span-1 md:col-span-2 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800">
    <form class="mx-auto" wire:submit="save">
    @csrf
    <div class="space-y-6">
        <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-12">
            <div class="sm:col-span-5">
                <x-input-label for="link" :value="__('Long url')"/>
                <x-text-input id="link" name="link" type="text" class="mt-1 block w-full" wire:model="link"  />
                <x-input-error class="mt-2" :messages="$errors->get('link')" />
            </div>

            <div class="sm:col-span-5">
                <x-input-label for="short" :value="__('Short url')" />
                <x-text-input id="short" name="short" type="text" class="mt-1 block w-full" wire:model="short" />
                <x-input-error class="mt-2" :messages="$errors->get('short')" />
            </div>

            <div class="sm:col-span-2">
                <label for="submit" class="block">&nbsp;</label>
                <div class="mt-2">
                    <x-primary-button>{{ __('Shorten') }}</x-primary-button>
                </div>
            </div>
        </div>
        @session('status')
        <div class="flex flex-col flex-wrap content-center max-w-sm mx-auto space-y-4">
            <p>{{ __('Shortened') }}: <a href="{{ $value->formatShortened() }}">{{ $value->formatShortened() }}</a></p>
            <img class="w-48 h-48" src="{{ Storage::disk('images')->url($value->qrcode->path) }}" alt="" />
            <a href="{{ route('link.qr-download', $value->slug)}}"><x-secondary-button>{{ __('Download') }}</x-secondary-button></a>
        </div>
        @endsession
    </div>
    </form>
</div>
