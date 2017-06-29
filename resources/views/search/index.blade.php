@extends('layouts.app')

@section('content')
    <search inline-template v-cloak>
        <div class="container">

            <div class="jumbotron jumbotron-fluid" style="background-color: transparent; margin-bottom: 0px;">
                <p class="display-1">Search</p>
                <p class="lead">Search through hundreds of thousands of consumer finance complaints.</p>
            </div>

            {{-- form for searching through resluts --}}
            @include('search.form')

            {{-- list of results from the search --}}
            @include('search.results')

            {{-- modal to show details of a complaint when you click on a complaint from the results list --}}
            @include('search.details')

        </div>
    </search>
@endsection