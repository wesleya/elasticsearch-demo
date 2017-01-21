<div class="list-group" v-cloak>
    <a href="#"
       class="list-group-item list-group-item-action flex-column align-items-start"
       v-for="result in results"
       v-cloak
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
            v-cloak
    >
        Load More
    </button>

    <br/>
</div>