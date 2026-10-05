@extends('layouts.base')

@section('title', 'Home Feed')

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ul>
            <li>ホーム</li>
        </ul>
    </nav>
@endsection

@section('content')
    <div>
        <h1>Latest Chirps</h1>

        <!-- Chirp Form -->
        <article style="margin-top: 2rem;">
            <form method="POST" action="/chirps">
                @csrf
                <fieldset>
                    <label>
                        What's on your mind?
                        <textarea name="message" rows="3" maxlength="255" required>{{ old('message') }}</textarea>
                    </label>
                    @error('message')
                        <small style="color: red;">{{ $message }}</small>
                    @enderror
                </fieldset>
                <button type="submit">Chirp</button>
            </form>
        </article>

        <!-- Feed -->
        <div style="margin-top: 2rem;">
            @forelse ($chirps as $chirp)
                <article>
                    <p>{{ $chirp->message }}</p>
                    <small>{{ $chirp->created_at->diffForHumans() }}</small>
                </article>
            @empty
                <p style="text-align: center; color: gray;">No chirps yet. Be the first to chirp!</p>
            @endforelse
        </div>
    </div>
@endsection
