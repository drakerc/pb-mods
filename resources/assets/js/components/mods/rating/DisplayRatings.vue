<template>
    <div class="row">
        <display-rating v-for="rating in ratings" :key="rating.id" :rating="rating" :mod="mod"></display-rating>
    </div>
</template>
<script>
    import routeMixin from '../../../route-mixin.js';
    import DisplayRating from "./DisplayRating";

    export default {
        mixins: [ routeMixin ],
        props: ['passedMod'],
        data() {
            return {
                mod: '',
                ratings: '',
                auth: '',
            }
        },
        mounted() {
            if (this.ratings.length === 0) {
                axios.get('/api/mods/modifications/' + this.passedMod.id + '/ratings').then(({data}) => {
                    this.ratings = data['ratings'];
                });
            }
        },

        components: {
            DisplayRating,
        },
        methods: {
            assignData({mod, ratings, auth}) {
                this.mod = mod;
                this.ratings = ratings;
                this.auth = auth;
            },
        },
    }
</script>
<style>
</style>