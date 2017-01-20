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

            <form class="form">
                <div class="row">
                    <div class="col-xs-12 col-sm-4">
                        <div class="input-group">
                            <select class="form-control form-control-lg"
                                    style="margin-bottom: 10px;"
                                    v-model="search_category"
                                    v-on:change="loadNew"
                            >
                                <option value="product">Product</option>
                                <option value="company">Company</option>
                                <option value="issue">Issue</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-8">
                        <div class="input-group">
                            <input class="form-control form-control-lg"
                                   style="margin-bottom: 10px;"
                                   type="search"
                                   placeholder="Search Term e.g. loan, credit"
                                   v-model="search_term"
                                   v-on:keyup="loadNew"
                            >
                        </div>
                    </div>
                </div>
            </form>

            <br/>

            <div class="list-group" v-cloak>
                <a href="#"
                   class="list-group-item list-group-item-action flex-column align-items-start"
                   v-for="result in results"
                >
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">@{{ result._source.sub_product }}</h5>
                        <small>@{{ result._source.date_received }}</small>
                    </div>
                    <p class="mb-1">@{{ result._source.issue }}</p>
                    <p class="mb-1">@{{ result._source.sub_issue }}</p>
                    <small>@{{ result._source.company }}</small>
                </a>

                <br/>

                <button type="button"
                        class="btn btn-primary btn-lg btn-block"
                        v-if="results.length"
                        v-on:click="loadMore"
                >
                    Load More
                </button>
            </div>

        </div>
    </home>
@endsection