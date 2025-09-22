@extends('layouts.landing')

@section('title', 'Services')

@section('content')
    <h1>Services</h1>
    <div class="cards">
        @component('_components.card')
            @slot('title', 'service 1')
            @slot('content', 'Lorem ipsum dolor set aimet.')
        @endcomponent
        @component('_components.card')
            @slot('title', 'service 2')
            @slot('content', 'Lorem ipsum.')
        @endcomponent
        @component('_components.card')
            @slot('title', 'service 3')
            @slot('content', 'Lorem ipsum.')
        @endcomponent
    </div>
@endsection
