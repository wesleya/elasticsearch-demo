<complaint inline-template v-bind:detail="result._source">
    <div>
        <a class="list-group-item list-group-item-action flex-column align-items-start"
           v-on:click="detailEvent"
           v-cloak
        >
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">@{{ detail.sub_product }}</h5>
                <small>@{{ detail.date_received }}</small>
            </div>
            <p class="mb-1">@{{ detail.issue }}</p>
            <p class="mb-1">@{{ detail.sub_issue }}</p>
            <small>@{{ detail.company }}</small>
        </a>
    </div>
</complaint>
