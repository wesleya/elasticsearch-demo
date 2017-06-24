<script>
    export default {

        props: ['detail'],

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
