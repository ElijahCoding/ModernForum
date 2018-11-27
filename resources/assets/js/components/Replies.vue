<template>
    <div>
        <div v-for="(reply, index) in items">
            <reply :data="reply" @deleted="remove(index)" :key="reply.id"></reply>
        </div>

        <paginator :dataSet="dataSet"></paginator>

        <new-reply :endpoint="endpoint" @created="add"></new-reply>
    </div>
</template>

<script>
    import Reply from './Reply'
    import NewReply from './NewReply'
    import Collection from '../mixins/Collection'

    export default {

        components: {
            Reply, NewReply
        },

        mixins: [Collection],

        data () {
            return {
                dataSet: false,
                endpoint: location.pathname + '/replies'
            }
        },

        created () {
            this.fetch()
        },

        methods: {
            fetch () {
                axios.get(this.url())
                     .then(this.refresh)
            },

            url () {
                return `${location.pathname}/replies`
            },

            refresh ({data}) {
                this.dataSet = data
                this.items = data.data
            },

            add (reply) {
                this.items.push(reply)

                this.$emit('added')
            },

            remove (index) {
                this.$emit('removed')

                this.items.splice(index, 1)
            },
        }
    }
</script>
