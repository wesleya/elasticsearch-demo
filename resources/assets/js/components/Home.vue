<script>
    export default {
        mounted() {
            console.log('component mounted.');
        },

        created() {
            console.log('component created.')
        },

        data(){
            return{
                search_category: 'product',
                search_term: '',
                page: 0,
                results: []
            }
        },

        methods: {
            loadNew: _.throttle(function() {
                this.page = 0;
                this.results = [];

                this.search();
            }, 100),

            loadMore: function() {
                this.page++;

                this.search();
            },

            search: function () {
                console.log("searching", this.search_category, this.search_term);

                var options = this.getOptions();

                axios.get("/api/v1/search/", options).then(
                        this.successCallback,
                        this.errorCallback
                );
            },

            successCallback: function(response) {
                console.log("api success: " + response.data);

                var results = this.results.concat(response.data);

                Vue.set(this, 'results', results);
            },

            errorCallback: function(response) {
                console.log("error loading activity");
            },

            getOptions: function() {
                return {
                    params: {
                        search_category: this.search_category,
                        search_term: this.search_term,
                        page: this.page
                    }
                };

            }
        }
    }
</script>
