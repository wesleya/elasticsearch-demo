@extends('layouts.app')

@section('content')
    <home inline-template v-cloak>
        <div class="container">

            <div class="jumbotron jumbotron-fluid" style="background-color: transparent; margin-bottom: 0px;">
                <h2 class="display-4">Consumer Finance Complaints</h2>
                <p class="lead">some kind of description.</p>
            </div>

            {{-- form for searching through resluts --}}
            @include('form')

            {{-- list of results from the search --}}
            @include('results')

            {{-- modal to show details of a complaint when you click on a complaint from the results list --}}
            @include('details')

        </div>
    </home>
@endsection