<script>
    export default {

        props: ['detail'],

        data(){
            return{

            }
        },

        methods: {
            detailEvent: function() {
                window.eventHub.$emit('show-detail', this.detail);
            }
        }
    }
</script>
