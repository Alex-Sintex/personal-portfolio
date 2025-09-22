@extends('layouts.app')

@section('content')
    <a href="{{ route('note.index') }}">Back</a>
    <form method="POST" action="{{ route('note.store') }}">
        @csrf
        <label for="title">Title:</label>
        <input type="text" name="title"> <br>
        @error('title')
            <p style="color:red;">{{ $message }}</p>
        @enderror

        <label for="description">Description:</label>
        <input type="text" name="description"> <br>
        @error('description')
            <p style="color:red;">{{ $message }}</p>
        @enderror

        <input type="submit" value="Create">
    </form>
@endsection
