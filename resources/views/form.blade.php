<form class="form" v-on:submit.prevent="">
    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-9">
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