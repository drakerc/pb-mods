<template>
    <div>
        Ocena:
        <star-rating :read-only="true" v-model="rating"></star-rating>
    </div>
</template>

<script>
    import StarRating from 'vue-star-rating'

    export default {
        props: ['rating'],
        components: {
            StarRating,
        },
        methods: {
        },
    }
</script>