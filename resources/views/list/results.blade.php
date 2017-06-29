<div class="list-group">
    <div v-for="(result, index) in results">
        <div class="complaint-card">
            <a class="list-group-item flex-column align-items-start">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1 font-weight-normal">@{{index + 1}}. @{{result.company}}</h5>
                </div>
                <small>@{{result.count}} complaints</small>
            </a>
        </div>
    </div>

    <div  v-if="results.length" v-cloak>
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