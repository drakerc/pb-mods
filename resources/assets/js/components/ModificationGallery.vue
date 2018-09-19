<template>
    <div class="images" v-viewer>
        <img v-for="src in images" :src="src" :key="src">
    </div>
</template>
<script>
    import 'viewerjs/dist/viewer.css'
    import Viewer from 'v-viewer'

    export default {
        components: {Viewer},
        mixins: [ routeMixin ],

        props: ['modification'],

        data() {
            return {
                images: []
            }
        },
        created() {
            axios.get('/api/mods/modifications/' + this.modification.id + '/images').then(({data}) => {
                this.images = data;
            });
        },
    }
</script>
<style>
</style>