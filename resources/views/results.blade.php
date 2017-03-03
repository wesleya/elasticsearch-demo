<div class="list-group">
    <div v-for="result in results">
        @include('complaint')
    </div>

    <div v-if="emptySearch()">
        <div class="jumbotron jumbotron-fluid" style="background-color: transparent; margin-bottom: 0px;">
            <div class="container">
                <h2 class="display-4">Ready Start!</h2>
                <p class="lead">Start by entering a search term in the text box above.</p>
            </div>
        </div>
    </div>

    <div v-if="noResults()">
        <div class="jumbotron jumbotron-fluid" style="background-color: transparent; margin-bottom: 0px;">
            <div class="container">
                <h2 class="display-4">No Results!</h2>
                <p class="lead">Start by entering a search term in the text box above.</p>
            </div>
        </div>
    </div>

    <div v-if="isSearching()">
        <div class="jumbotron jumbotron-fluid" style="background-color: transparent; margin-bottom: 0px;">
            <div class="container">
                <p class="text-center">Searching...</p>
            </div>
        </div>
    </div>

    <br/>

    <button type="button"
            class="btn btn-primary btn-lg btn-block"
            v-if="results.length && !isSearching()"
            v-on:click="loadMore"
            v-cloak
    >
        Load More
    </button>

    <br/>
</div>