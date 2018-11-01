<template>
    <div class="text-center" v-if="video.youtubeId !== undefined">
        Tytuł: {{ video.title }}
        <youtube :video-id="video.youtubeId" @playing="true"></youtube>
        <hr class="mb-4">
    </div>
</template>
<script>
    export default {
        props: ['video'],
    }
</script>
<style>
</style>