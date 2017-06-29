@extends('layouts.app')

@section('content')
    <list inline-template v-cloak :init="{{$companies}}">
        <div class="container">

            <div class="jumbotron jumbotron-fluid" style="background-color: transparent; margin-bottom: 0px;">
                <p class="display-1">List</p>
                <p class="lead">List Top 10 most complained about companies over the last year by product.</p>
            </div>

            {{-- form for searching through resluts --}}
            @include('list.form')

            {{-- list of results from the search --}}
            @include('list.results')
        </div>
    </list>
@endsection