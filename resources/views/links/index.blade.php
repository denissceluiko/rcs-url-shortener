<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <section>
                <h2>Linki</h2>
                <table>
                    <thead>
                        <th>ID</th>
                        <th>Link</th>
                        <th>Short</th>
                        <th>Clicks</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @foreach ($links as $link)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $link->full_url }}</td>
                                <td>{{ url($link->shortened_url) }}</td>
                                <td>{{ $link->clicks }}</td>
                                <td>
                                    <a href="{{ url($link->shortened_url) }}">Links</a>
                                    <a href="{{ route('link.edit', $link->shortened_url) }}">Rediģēt</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </section>
        </div>
    </div>

</x-app-layout>

