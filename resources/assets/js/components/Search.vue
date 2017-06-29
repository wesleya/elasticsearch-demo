<script>
    export default {

        data(){
            return{
                search_term: '',
                page: 0,
                limit: 10,
                results: [],
                detail: null,
                searching: false,
                search_submitted: false
            }
        },

        created() {
            window.eventHub.$on('show-detail', this.showDetail);
        },

        methods: {

            /**
             * load results for a new search
             */
            loadNew: _.debounce(function() {
                this.clearResults();

                if( this.emptySearch() ) {
                    return
                }

                this.searching = true;
                this.search_submitted = true;

                axios.get("/api/v1/search/", this.getOptions()).then(
                    this.loadNewCallback,
                    this.errorCallback
                );
            }, 300),

            /**
             * load more results for an existing search
             */
            loadMore: function() {

                this.searching = true;
                this.page++;

                axios.get("/api/v1/search/", this.getOptions()).then(
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

                if( this.emptySearch() ) {
                    this.clearResults();
                }

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
                        search_term: this.search_term,
                        page: this.page,
                        limit: this.limit
                    }
                };

            },

            /**
             * show complaint details in a modal
             *
             * @param detail
             */
            showDetail: function(detail) {
                console.log(detail);

                this.detail = detail;

                $('#detail-modal').modal('show');
            },

            clearResults: function() {
                this.results = [];
                this.page = 0;
            },

            emptySearch: function() {
                return this.search_term.length == 0;
            },

            emptyResults: function() {
                return this.results.length == 0;
            },

            noResults: function() {
                return !this.emptySearch() && this.emptyResults() && !this.searching && this.search_submitted;
            },

            isSearching: function() {
                return this.searching;
            }
        }
    }
</script>
