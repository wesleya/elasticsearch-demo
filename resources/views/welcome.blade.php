@extends('layouts.app')

@section('content')
    <home inline-template v-cloak>
        <div class="container">

            <div class="jumbotron jumbotron-fluid text-center"
                 style="background-color: transparent; margin-bottom: 0px;"
            >
                <h1 class="display-3">Consumer Finance Complaints</h1>
                <p class="lead"
                   style="font-size: 2em; line-height: 120%;"
                >
                    <a href="#search" class="text-justify">Search</a> complaints, <a href="#view">view</a> the worst companies, or <a href="#submit">submit</a> a new complaint.
                </p>
            </div>

            <div class="jumbotron jumbotron-fluid text-center"
                 style="background-color: transparent; margin-bottom: 0px;"
            >
                <h2 class="display-4">Search</h2>
                <p class="lead text-center">Search through hundreds of thousands of consumer finance complaints.</p>
            </div>

            {{-- form for searching through resluts --}}
            @include('form')

            {{-- list of results from the search --}}
            @include('results')

            <br/>

            <div class="jumbotron jumbotron-fluid text-center"
                 style="background-color: transparent; margin-bottom: 0px;"
            >
                <h2 class="display-4">List</h2>
                <p class="lead text-center">Top 5 most complained about companies over the last year.</p>
            </div>

            {{-- list of most complained about companies --}}
            @include('top_companies')

            <br/>

            <div class="jumbotron jumbotron-fluid text-center"
                 style="background-color: transparent; margin-bottom: 0px;"
            >
                <h2 class="display-4">Submit</h2>
                <p class="lead text-center">Top 5 most complained about companies over the last year.</p>
            </div>


            {{-- modal to show details of a complaint when you click on a complaint from the results list --}}
            @include('details')

        </div>
    </home>
@endsection