<div class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] md:row-span-1 md:col-span-2 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800">
    <form class="mx-auto" action="{{ route('link.store') }}" method="POST">
    @csrf
    <div class="space-y-12">
        <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-12">
            <div class="sm:col-span-5">
            <label for="link" class="block text-sm font-medium leading-6 text-gray-900">Long url</label>
            <div class="mt-2">
                <input type="text" name="link" id="link" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                @error('link')
                        <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            </div>

            <div class="sm:col-span-5">
            <label for="short" class="block text-sm font-medium leading-6 text-gray-900">Shortened</label>
            <div class="mt-2">
                <input type="text" name="short" id="short" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                @error('short')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            </div>

            <div class="sm:col-span-5">
                <x-input-label for="link" :value="__('Long url')" />
                <x-text-input id="link" name="link" type="text" class="mt-1 block w-full" />
                <x-input-error class="mt-2" :messages="$errors->get('link')" />
            </div>

            <x-text-input-group name="link" :label="__('Link label')"></x-text-input-group>

            <div class="sm:col-span-2">
                <label for="" class="block">&nbsp;</label>
                <div class="mt-2">
                    <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
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
