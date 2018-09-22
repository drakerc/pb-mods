<template>
    <div>
        <p>id: {{ file.id }}</p>
        <p>title: {{ file.pivot.title }}</p>
        <p>description: <span v-html="file.pivot.description"></span></p>
        <p><a :href="file.downloadLink">Pobierz ten plik</a></p>
        <hr/>
    </div>
</template>
<script>
    export default {
        props: ['file'],
    }
</script>
<style>
    .about {
        margin: 2em 0;
    }
    .about h3 {
        font-size: 22px;
    }
</style>