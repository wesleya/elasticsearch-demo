<div class="list-group">

    <div v-for="result in results">
        @include('search.complaint')
    </div>

    <div v-if="noResults()">
        <div class="jumbotron jumbotron-fluid" style="background-color: transparent; margin-bottom: 0px;">
            <h2 class="display-4">No Results!</h2>
            <p class="lead">Start by entering a search term in the text box above.</p>
        </div>
    </div>

    <div v-if="isSearching()">
        <div class="jumbotron jumbotron-fluid" style="background-color: transparent; margin-bottom: 0px;">
            <p class="text-center">Searching...</p>
        </div>
    </div>

    <div  v-if="results.length && !isSearching()" v-cloak>
        <br/>
        <button type="button"
                class="btn btn-primary btn-lg btn-block"
                v-on:click="loadMore"
        >
            Load More
        </button>

        <br/>
    </div>
</div>