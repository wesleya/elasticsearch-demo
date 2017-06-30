@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="jumbotron jumbotron-fluid" style="background-color: transparent; margin-bottom: 0px;">
            <p class="display-1">Consumer Finance Complaints</p>
            <p class="lead"><a href="/search" class="text-justify">Search</a> complaints, <a href="/list">view</a> the worst companies, or <a href="#submit">submit</a> a new complaint.</p>
            <br/>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4" style="padding-bottom: 25px;">
                <div class="card text-center">
                    <div class="card-block">
                        <h4 class="card-title">Search Complaints</h4>
                        <p class="card-text">Search through hundreds of thousands of consumer finance complaints by company name.</p>
                        <a href="/search" class="btn btn-primary btn-block btn-lg">Search</a>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4" style="padding-bottom: 25px;">
                <div class="card text-center">
                    <div class="card-block">
                        <h4 class="card-title">List Top Companies</h4>
                        <p class="card-text">View the Top 10 most complained about companies over the last year by product type.</p>
                        <a href="/list" class="btn btn-primary btn-block btn-lg">List</a>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4" style="padding-bottom: 25px;">
                <div class="card text-center">
                    <div class="card-block">
                        <h4 class="card-title">Submit Complaints</h4>
                        <p class="card-text">Submit your own complaint to the Consumer Finance Protection Bureau (CFPB).</p>
                        <a href="https://www.consumerfinance.gov/complaint/getting-started/" class="btn btn-primary btn-block btn-lg">Submit</a>
                    </div>
                </div>
            </div>
        </div>

        <br/>

    </div>
    <div class="container">
        <div class="jumbotron jumbotron-fluid" style="background-color: transparent; margin-bottom: 0px;">
            <p class="display-4">Frequently Asked Questions</p>
        </div>

        <div class="row">
            <div class="col-xs-12 col-md-6" style="padding-bottom: 25px;">
                <h3 style="font-weight:300;">Where is this data from?</h3>
                <p>Consumer complaints are collected by the <a href="https://www.consumerfinance.gov/">Consumer Finance Protection Bureau (CFPB)</a>. This data is shared with the public through an <a href="https://dev.socrata.com/foundry/data.consumerfinance.gov/jhzv-w97w">API</a> after scrubbing personal information.</p>
            </div>
            <div class="col-xs-12 col-md-6" style="padding-bottom: 25px;">
                <h3 style="font-weight:300;">How often is this data updated?</h3>
                <p>CFPB updates their data daily. I try to pull those updates daily as well, but may fall behind by a day or two.</p>
            </div>
            <div class="col-xs-12 col-md-6" style="padding-bottom: 25px;">
                <h3 style="font-weight:300;">What is your relation to CFPB?</h3>
                <p>I'm not connected to CFPB in any way. I just thought this was a cool personal project to build on top of the data they make freely available for anyone to use.
                </p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="jumbotron jumbotron-fluid" style="background-color: transparent; margin-bottom: 0px;">
            <p class="display-4">Contact</p>
        </div>

        <div class="row">
            <div class="col-xs-12 col-md-8" style="padding-bottom: 25px;">
                <p>Have a suggestion? contact me at <a href="mailto:consumerfinancecomplaints@gmail.com">consumerfinancecomplaints@gmail.com</a></p>
            </div>
        </div>
    </div>

@endsection