<template>
    <div>
        <p>json: {{ file }}</p>
        <p>id: {{ file.id }}</p>
        <p>size: {{ file.size }}</p>
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