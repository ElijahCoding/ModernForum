<template>
    <button :class="classes" @click="subscribe">Subscribe</button>
</template>

<script>
    export default {
        props: ['active'],

        methods: {
            subscribe () {
                axios[this.active ? 'delete' : 'post'](`${location.pathname}/subscriptions`)
                this.active = !this.active
            }
        },

        computed: {
            classes () {
                return ['btn', this.active ? 'btn-primary' : 'btn-default']
            }
        }
    }
</script>
