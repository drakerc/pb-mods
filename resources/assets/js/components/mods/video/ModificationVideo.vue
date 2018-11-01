<template>
    <div class="text-center" v-if="video.youtubeId !== undefined">
        <p>Tytuł: {{ video.title }}</p>
        <p>Wrzucił: {{ video.creatorName }}</p>
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