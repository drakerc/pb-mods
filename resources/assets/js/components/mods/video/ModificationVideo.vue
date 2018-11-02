<template>
    <div class="jumbotron container dark-jumbotron" v-if="video.youtubeId !== undefined">
        <h3>{{ video.title }}</h3>
        <p>Wrzucił: {{ video.creatorName }}</p>
        <youtube class="text-center" :video-id="video.youtubeId" @playing="true"></youtube>
        <hr class="mb-4">
    </div>
</template>
<script>
    export default {
        props: ['video'],
    }
</script>
<style>
    .dark-jumbotron {
        color: #e3e3e3;
        background-color: #464646;
    }
</style>