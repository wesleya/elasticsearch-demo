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
                results: []
            }
        },

        methods: {
            search: _.throttle(function () {
                console.log("searching", this.search_category, this.search_term);

                var options = this.getOptions();

                axios.get("/api/v1/search/", options).then(
                        this.successCallback,
                        this.errorCallback
                );

            }, 2000),

            successCallback: function(response) {
                console.log("api success: " + response.data);

                Vue.set(this, 'results', response.data);
            },

            errorCallback: function(response) {
                console.log("error loading activity");
            },

            getOptions: function() {
                return {
                    params: {
                        search_category: this.search_category,
                        search_term: this.search_term
                    }
                };

            }
        }
    }
</script>
