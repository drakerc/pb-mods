<template>
    <div class="listing-summary">
        <modification-author-menu :mod="mod"></modification-author-menu>

        <div>{{ mod.title }}</div>
        <div v-html="mod.description"></div>
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

        Galeria screenów:
        <modification-gallery v-if="mod.id !== undefined" :modification="mod"></modification-gallery>

        Filmiki:

    </div>
</template>
<script>
    import routeMixin from '../../../route-mixin.js';
    import ModificationFiles from "../file/ModificationFiles";
    import ModificationGallery from "./ModificationGallery";
    import ModificationAuthorMenu from './ModificationAuthorMenu';

    export default {
        components: {ModificationFiles, ModificationGallery, ModificationAuthorMenu},
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