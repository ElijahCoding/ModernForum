<script>
    import Favorite from './Favorite'
    export default {
        props: ['attributes'],

        data () {
            return {
                editing: false,
                body: this.attributes.body
            }
        },

        components: {
            Favorite
        },

        mounted () {

        },

        methods: {
            update () {
                axios.patch(`/replies/${this.attributes.id}`, {
                    body: this.body
                })
                this.editing = false
            },

            destroy () {
                axios.delete(`/replies/${this.attributes.id}`)

                $(this.$el).fadeOut(300, () => {

                })
            }
        }
    }
</script>
