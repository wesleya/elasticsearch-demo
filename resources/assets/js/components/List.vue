<script>
    export default {

        props: [
            'init'
        ],

        data(){
            return{
                product_type: 0,
                page: 0,
                limit: 10,
                searching: false,
                results: []
            }
        },

        created: function () {
            this.results = this.init;
        },

        methods: {

            /**
             * load results for a new search
             */
            loadNew: function() {
                this.clearResults();

                this.searching = true;
                this.search_submitted = true;

                axios.get("/api/v1/list/", this.getOptions()).then(
                    this.loadNewCallback,
                    this.errorCallback
                );
            },

            /**
             * load more results for an existing search
             */
            loadMore: function() {

                this.searching = true;
                this.page++;

                axios.get("/api/v1/list/", this.getOptions()).then(
                    this.loadMoreCallback,
                    this.errorCallback
                );
            },

            /**
             * once we get search results from the api, l
             * oad them up so we can display them to the user
             *
             * @param response
             */
            loadMoreCallback: function(response) {

                let results = this.results.concat(response.data);

                Vue.set(this, 'results', results);

                this.searching = false;
            },

            /**
             * once we get search results from the api, l
             * oad them up so we can display them to the user
             *
             * @param response
             */
            loadNewCallback: function(response) {
                Vue.set(this, 'results', response.data);

                this.searching = false;
            },

            errorCallback: function(response) {
                console.log("error loading activity");
                this.searching = false;
            },

            /**
             * build the GET parameters that we send in the search api call
             *
             * @returns {{params: {search_category: *, search_term: *, page: *}}}
             */
            getOptions: function() {
                return {
                    params: {
                        product_type: this.product_type,
                        page: this.page,
                        limit: this.limit
                    }
                };

            },

            clearResults: function() {
                this.results = [];
                this.page = 0;
            },

            isSearching: function() {
                return this.searching;
            }
        }
    }
</script>
