<template>
    <ul class="pagination">
        <li>
            <a href="#" aria-label="Previous">
                <span aria-hidden="true">&laquo; Previous</span>
            </a>
        </li>

        <li>
            <a href="#" aria-label="Next" rel="next">
                <span aria-hidden="true">Next &raquo;</span>
            </a>
        </li>
    </ul>
</template>

<script>
    export default {
        props: ['dataSet'],

        data () {
            return {
                page: 1,
                prevUrl: false,
                nextUrl: false
            }
        }
    }
</script>
