<template>
    <div>
        <div class="text-white" v-if="videos.length === 0">
            <p>Przykro nam, ale zespół deweloperski modyfikacji nie udostępnił żadnych filmów wideo.</p>
        </div>
        <modification-video v-else v-for="video in videos" :key="video.id" :video="video"></modification-video>
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
                this.$emit('complete-loading');
            });
        },
    }
</script>
<style>
</style>