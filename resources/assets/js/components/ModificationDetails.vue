<template>
    <div class="listing-summary">
        <div>{{ mod.title }}</div>
        <div>{{ mod.description }}</div>
        <div>{{ mod.development_status }}</div>
        <div>{{ mod.size }}</div>
        <div>{{ mod.replaces }}</div>
        <div>{{ mod.version }}</div>
        <div>{{ mod.release_date }}</div>
        <div>{{ mod.development_studio }}</div>
    </div>
</template>
<script>
    import routeMixin from '../route-mixin.js';

    export default {
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