@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="jumbotron jumbotron-fluid" style="background-color: transparent; margin-bottom: 0px;">
            <p class="display-1">Consumer Finance Complaints</p>
            <p class="lead"><a href="/search" class="text-justify">Search</a> complaints, <a href="/list">view</a> the worst companies, or <a href="#submit">submit</a> a new complaint.</p>
            <br/>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4" style="padding-bottom: 20px;">
                <div class="card text-center">
                    <div class="card-block">
                        <h4 class="card-title">Search Complaints</h4>
                        <p class="card-text">Search through hundreds of thousands of consumer finance complaints by company name.</p>
                        <a href="/search" class="btn btn-primary">Start</a>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4" style="padding-bottom: 20px;">
                <div class="card text-center">
                    <div class="card-block">
                        <h4 class="card-title">List Top Companies</h4>
                        <p class="card-text">View the Top 10 most complained about companies over the last year by product type.</p>
                        <a href="/list" class="btn btn-primary">Start</a>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4" style="padding-bottom: 20px;">
                <div class="card text-center">
                    <div class="card-block">
                        <h4 class="card-title">Submit Complaints</h4>
                        <p class="card-text">Submit your own complaint to the Consumer Finance Protection Bureau (CFPB).</p>
                        <a href="https://www.consumerfinance.gov/complaint/getting-started/" class="btn btn-primary">Start</a>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection