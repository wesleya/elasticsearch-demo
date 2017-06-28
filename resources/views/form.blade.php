<form class="form" v-on:submit.prevent="loadNew">
    <div class="form-group">
        <div class="input-group input-group-lg">
            <span class="input-group-addon">
                <i class="fa fa-search" aria-hidden="true"></i>
            </span>
            <input class="form-control"
                   type="text"
                   placeholder="Company"
                   v-model="search_term"
                   v-on:keyup.enter="$event.target.blur()"
            >
        </div>
        <small id="emailHelp" class="form-text text-muted">Search for a company (e.g. JPMorgan, Wells Fargo, Equifax)</small>
    </div>
</form>