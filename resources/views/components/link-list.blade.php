<ul role="list" class="divide-y divide-gray-100 grow">
    @foreach ($links as $link)
        <li class="flex justify-between gap-x-1 lg:gap-x-6 py-5">
            <div class="flex min-w-0 gap-x-4">
                <img class="h-12 w-12 flex-none bg-gray-50" src="{{ $link->QRCode() }}" alt="">
                <div class="min-w-0 flex-auto">
                    <p class="text-sm font-semibold leading-6 text-gray-900 max-w-40 lg:max-w-lg truncate">{{ $link->full_url}}</p>
                    <p class="mt-1 truncate text-xs leading-5 text-gray-500">{{ url($link->shortened_url) }}</p>
                </div>
            </div>
            <div class="shrink-0 sm:flex sm:flex-row sm:items-end">
                <div class="sm:flex sm:flex-col content-end">
                    @if(request()->routeIs('dashboard'))
                        <p class="mt-1 text-s leading-5 text-gray-900"><a href="{{ route('link.edit', $link->shortened_url) }}">Rediģēt</a></p>
                    @endif
                    <p class="mt-1 text-xs leading-5 text-gray-500">Clicks: {{ $link->clicks }}</p>
                </div>
                <div class="sm:flex sm:flex-col">
                    <a href="{{ url($link->shortened_url) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="w-7 h-7">
                            <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </li>
    @endforeach
  </ul>
