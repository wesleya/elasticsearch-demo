<form class="form" v-on:submit.prevent="">
    <div class="input-group input-group-lg">
        <span class="input-group-addon">
            <i class="fa fa-search" aria-hidden="true"></i>
        </span>
        <input class="form-control"
               type="text"
               placeholder="Company Name (e.g. JPMorgan)"
               v-model="search_term"
               v-on:keyup="loadNew"
               v-on:keyup.enter="$event.target.blur()"
        >
    </div>
</form>