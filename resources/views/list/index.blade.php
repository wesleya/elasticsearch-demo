@extends('layouts.app')

@section('content')
        <div class="container">

            <div class="jumbotron jumbotron-fluid" style="background-color: transparent; margin-bottom: 0px;">
                <p class="display-1">List</p>
                <p class="lead">List Top 10 most complained about companies over the last year by product.</p>
            </div>

            {{-- list of most complained about companies --}}
            @include('list.top_companies')
        </div>
@endsection