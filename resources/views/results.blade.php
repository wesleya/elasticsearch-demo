<div class="list-group">
    <div v-for="result in results">
        @include('complaint')
    </div>

    <br/>

    <button type="button"
            class="btn btn-primary btn-lg btn-block"
            v-if="results.length"
            v-on:click="loadMore"
            v-cloak
    >
        Load More
    </button>

    <br/>
</div>