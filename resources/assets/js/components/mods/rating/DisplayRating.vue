<template>
    <div v-if="rating.id !== undefined">
        Ocena ogólna: {{ rating.rating }}
        Ocena użyteczności: {{ rating.rating_usability }}
        Ocena rozrywki: {{ rating.rating_fun }}
        Ocena jakości: {{ rating.quality }}
        Autor: {{ rating.author_id }}

        <router-link :to="{ name: 'modification_edit_rating', params: { mod: mod.id, rating: rating.id } }">
            Edytuj
        </router-link>
    </div>
</template>
<script>
    export default {
        props: ['rating', 'mod'],
    }
</script>
<style>
</style>