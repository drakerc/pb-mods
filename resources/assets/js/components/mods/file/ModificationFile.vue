<template>
    <div>
        <p>id: {{ file.id }}</p>
        <p>title: {{ file.pivot.title }}</p>
        <p>description: <span v-html="file.pivot.description"></span></p>
        <p><a :href="file.downloadLink">Pobierz ten plik</a></p>

        <div>
            <input type="checkbox" :id="'checkbox-' + file.id" v-model="selected" v-on:change="$emit('selectFile', file, selected)">
            <label for="'checkbox-' + file.id">Zaznacz, by dodać do pobierania masowego</label>
        </div>
        <hr/>
    </div>
</template>
<script>
    export default {
        props: ['file'],
        data() {
            return {
                selected: false
            }
        },
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