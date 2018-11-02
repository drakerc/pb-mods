<template>
    <div>
        <gallery :images="[image]" :index="index" @close="index = null"></gallery>
        <img :src="image" width="150px" height="150px" :key="0" @click="index = 0">
    </div>
</template>
<script>
    import VueGallery from 'vue-gallery';

    export default {
        components: {
            'gallery': VueGallery
        },
        props: ['image'],

        data() {
            return {
                images: [],
                index: null,
            }
        },
    }
</script>