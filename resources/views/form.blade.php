<form class="form" v-on:submit.prevent="">
    <div class="row">
        <div class="col-xl-12">
            <div class="input-group">
                <input class="form-control form-control-lg"
                       style="margin-bottom: 10px;"
                       type="search"
                       placeholder="Search Term e.g. loan, credit"
                       v-model="search_term"
                       v-on:keyup="loadNew"
                       v-on:keyup.enter="$event.target.blur()"
                >
            </div>
        </div>
    </div>
</form>