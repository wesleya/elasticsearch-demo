<complaint inline-template v-bind:detail="result._source" v-bind:highlight="result.highlight">
    <div class="complaint-card">
        <a class="list-group-item list-group-item-action flex-column align-items-start"
           v-on:click="detailEvent"
           v-cloak
        >
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1" v-html="displaySubProduct"></h5>
                <small>@{{ detail.date_received }}</small>
            </div>
            <p class="mb-1" v-html="displayIssue"></p>

            <p class="mb-1">@{{ detail.sub_issue }}</p>
            <small v-html="displayCompany"></small>
        </a>
    </div>
</complaint>
