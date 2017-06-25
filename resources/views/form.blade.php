<form class="form" v-on:submit.prevent="">
    <div class="row">
        <div class="col-sm-12 col-md-4">
            <select class="form-control form-control-lg"
                    style="margin-bottom: 10px;"
            >
                <option>Company</option>
                <option>Product</option>
            </select>
        </div>
        <div class="col-sm-12 col-md-8">
            <div class="input-group">
                <input class="form-control form-control-lg"
                       style="margin-bottom: 10px;"
                       type="search"
                       placeholder="Search e.g. Wells Fargo"
                       v-model="search_term"
                       v-on:keyup="loadNew"
                       v-on:keyup.enter="$event.target.blur()"
                >
            </div>
        </div>
    </div>
</form>