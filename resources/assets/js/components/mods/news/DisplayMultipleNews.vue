<template>
    <div class="row text-dark">
        <display-news v-for="singleNews in news" :key="singleNews.id" :canManageMod="canManageMod" :news="singleNews" :mod="mod" ></display-news>
    </div>
</template>
<script>
    import routeMixin from '../../../route-mixin.js';
    import DisplayNews from "./DisplayNews";

    export default {
        mixins: [ routeMixin ],
        props: ['passedMod', 'canManageMod'],
        data() {
            return {
                news: '',
                mod: '',
                auth: '',
            }
        },
        mounted() {
            if (this.news.length === 0) {
                this.mod = this.passedMod;
                axios.get('/api/mods/modifications/' + this.passedMod.id + '/news').then(({data}) => {
                    this.news = data['news'];
                });
            }
        },
        components: {
            DisplayNews,
        },
        methods: {
            assignData({news, auth, mod}) {
                this.news = news;
                this.auth = auth;
                this.mod = mod;
            },
        },
    }
</script>
<style>
</style>