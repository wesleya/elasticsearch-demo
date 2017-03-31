<script>
    export default {

        props: ['detail', 'highlight'],

        data(){
            return{

            }
        },

        computed: {

            displayIssue: function () {
                if(this.highlight.issue) {
                    return this.highlight.issue[0];
                }
                return this.detail.issue;
            },

            displaySubIssue: function () {
                if(this.highlight.sub_issue) {
                    return this.highlight.sub_issue[0];
                }
                return this.detail.sub_issue;
            },

            displaySubProduct: function () {
                if(this.highlight.sub_product) {
                    return this.highlight.sub_product[0];
                }
                return this.detail.sub_product;
            },

            displayCompany: function () {
                if(this.highlight.company) {
                    return this.highlight.company[0];
                }
                return this.detail.company;
            },
        },

        methods: {

            /**
             * dispatch an event to let home view know we want to
             * show the complaint detail view on the page
             */
            detailEvent: function() {
                window.eventHub.$emit('show-detail', this.detail);
            }
        }
    }
</script>
