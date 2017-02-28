<form class="form" v-on:submit.prevent>
    <div class="row">
        <div class="col-xs-12 col-sm-4 col-md-3">
            <div class="input-group">
                <select class="form-control form-control-lg"
                        style="margin-bottom: 10px;"
                        v-model="search_category"
                        v-on:change="loadNew"
                >
                    <option value="product">Product</option>
                    <option value="company">Company</option>
                    <option value="issue">Issue</option>
                </select>
            </div>
        </div>
        <div class="col-xs-12 col-sm-8 col-md-9">
            <div class="input-group">
                <input class="form-control form-control-lg"
                       style="margin-bottom: 10px;"
                       type="search"
                       placeholder="Search Term e.g. loan, credit"
                       v-model="search_term"
                       v-on:keyup="loadNew"
                >
            </div>
        </div>
    </div>
</form>