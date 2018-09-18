<template>
    <div class="listing-summary">
        <router-link :to="{ name: 'modification_update', params: { mod: mod.id } }">
            Edytuj tą modyfikację
        </router-link>

        <router-link :to="{ name: 'modification_create_files', params: { mod: mod.id } }">
            Dodaj plik/i
        </router-link>

        <div>{{ mod.title }}</div>
        <div>{{ mod.description }}</div>
        <div>{{ mod.development_status }}</div>
        <div>{{ mod.size }}</div>
        <div>{{ mod.replaces }}</div>
        <div>{{ mod.version }}</div>
        <div>{{ mod.release_date }}</div>
        <div>{{ mod.development_studio }}</div>

        <div>
            <h1>Pliki:</h1>
            <modification-files v-if="mod.id !== undefined" :modification="mod"></modification-files>
        </div>
    </div>
</template>
<script>
    import routeMixin from '../route-mixin.js';
    import ModificationFiles from "./ModificationFiles";

    export default {
        components: {ModificationFiles},
        mixins: [ routeMixin ],

        data() {
            return {
                mod: []
            }
        },
        methods: {
            assignData({mod}) {
                this.mod = mod;
            },
        },
    }
</script>
<style>
</style>