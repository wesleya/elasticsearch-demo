<script>
    export default {

        data(){
            return{
                search_category: 'product',
                search_term: '',
                page: 0,
                limit: 10,
                results: [],
                detail: null
            }
        },

        created() {
            window.eventHub.$on('show-detail', this.showDetail);
        },

        methods: {

            /**
             * load results for a new search
             */
            loadNew: _.throttle(function() {
                this.page = 0;
                this.results = [];

                this.search();
            }, 100),

            /**
             * load more results for an existing search
             */
            loadMore: function() {
                this.page++;

                this.search();
            },

            /**
             * make the actual api call for new and load more searches
             */
            search: function () {
                console.log("searching", this.search_category, this.search_term);

                var options = this.getOptions();

                axios.get("/api/v1/search/", options).then(
                        this.successCallback,
                        this.errorCallback
                );
            },

            /**
             * once we get search results from the api, l
             * oad them up so we can display them to the user
             *
             * @param response
             */
            successCallback: function(response) {
                console.log("api success: " + response.data);

                var results = this.results.concat(response.data);

                Vue.set(this, 'results', results);
            },

            errorCallback: function(response) {
                console.log("error loading activity");
            },

            /**
             * build the GET parameters that we send in the search api call
             *
             * @returns {{params: {search_category: *, search_term: *, page: *}}}
             */
            getOptions: function() {
                return {
                    params: {
                        search_method: this.search_category,
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
            }
        }
    }
</script>
