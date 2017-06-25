<complaint inline-template v-bind:detail="result">
    <div class="complaint-card">
        <a class="list-group-item list-group-item-action flex-column align-items-start"
           v-on:click="detailEvent"
           v-cloak
        >
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1" v-html="detail.company"></h5>
                <small>@{{ detail.date_received }}</small>
            </div>
            <p class="mb-1" v-html="detail.issue"></p>

            <p class="mb-1">@{{ detail.sub_issue }}</p>
            <small v-html="detail.product"></small>
        </a>
    </div>
</complaint>
