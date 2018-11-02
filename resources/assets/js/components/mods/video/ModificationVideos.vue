<template>
    <div>
        <modification-video v-for="video in videos" :key="video.id" :video="video"></modification-video>
    </div>
</template>
<script>
    import ModificationVideo from './ModificationVideo.vue';

    export default {
        props: ['modification'],
        data() {
            return {
                videos: '',
            }
        },
        components: {
            ModificationVideo
        },
        created() {
            axios.get('/api/mods/modifications/' + this.modification.id + '/videos').then(({data}) => {
                this.videos = data;
            });
        },
    }
</script>
<style>
</style>