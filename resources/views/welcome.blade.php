@extends('layouts.app')

@section('content')
    <home inline-template>
        <div class="container">
            <form class="form">
                <div class="row">
                    <div class="col-xs-12 col-sm-4">
                        <select class="form-control"
                                v-model="search_category"
                                v-on:change="search"
                        >
                            <option value="product">Product</option>
                            <option value="company">Company</option>
                            <option value="issue">Issue</option>
                        </select>
                    </div>
                    <div class="col-xs-12 col-sm-8">
                        <input class="form-control"
                               type="search"
                               placeholder="Search Term"
                               v-model="search_term"
                               v-on:keyup="search"
                        >
                    </div>
                </div>
            </form>

            <div class="row">
                <div class="col-xs-12" v-for="result in results">
                    <p>@{{result}}</p>
                </div>
            </div>

        </div>
    </home>
@endsection