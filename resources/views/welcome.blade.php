@extends('layouts.app')

@section('content')
    <home inline-template>
        <div class="container">

            <div class="jumbotron jumbotron-fluid" style="background-color: transparent; margin-bottom: 0px;">
                <div class="container">
                    <h1 class="display-4">Elasticsearch Demo</h1>
                    <p class="lead">Just a simple demo to intro to Elasticsearch.</p>
                </div>
            </div>

            @include('form')

            <br/>

            @include('results')

            @include('details')

        </div>
    </home>
@endsection