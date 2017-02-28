@extends('layouts.app')

@section('content')
    <home inline-template v-cloak>
        <div class="container">

            <div class="jumbotron jumbotron-fluid" style="background-color: transparent; margin-bottom: 0px;">
                <div class="container">
                    <h2 class="display-5">Elasticsearch Demo</h2>
                    <p class="lead">Just a simple demo to intro to Elasticsearch.</p>
                </div>
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