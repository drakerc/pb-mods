<template>
    <div v-if="video.youtubeId !== undefined">
        <youtube :video-id="video.youtubeId" @playing="true"></youtube>
    </div>
</template>
<script>
    export default {
        props: ['video'],
    }
</script>
<style>
</style>