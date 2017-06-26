<form class="form" v-on:submit.prevent="">
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
                <input class="form-control form-control-lg"
                       style="margin-bottom: 10px;"
                       type="search"
                       placeholder="Company Name (e.g. JPMorgan)"
                       v-model="search_term"
                       v-on:keyup="loadNew"
                       v-on:keyup.enter="$event.target.blur()"
                >
            </div>
        </div>
    </div>
</form>