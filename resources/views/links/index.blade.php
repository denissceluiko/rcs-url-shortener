@extends('layouts.app')

@section('content')
<section>
    <h2>Jauns links</h2>
    <form action="{{ route('link.store') }}" method="POST">
        @csrf
        <input type="text" name="link" placeholder="Long url" required />
        @error('link')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <input type="text" name="short" placeholder="Short url" />
        @error('short')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <input type="submit" value="Saīsināt" />
    </form>
    @session('status')
    <div>
        Saīsināts: <a href="{{ $value }}">{{ $value }}</a>
    </div>
@endsession
</section>
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
                        <form action="{{ route('link.destroy') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $link->id }}"/>
                            <input type="submit" value="Dzēst" />
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</section>
@endsection
