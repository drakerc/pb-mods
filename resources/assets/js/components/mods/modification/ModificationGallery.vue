<template>
    <div>
        <div class="text-white" v-if="images.length === 0">
            Przykro nam, ale autor modyfikacji nie stworzył jeszcze galerii zdjęć.
        </div>
        <gallery :images="images" :index="index" @close="index = null"></gallery>
        <img class="m-2 border" v-for="(image, imageIndex) in images" :src="image" width="240px" height="135px" :key="imageIndex" @click="index = imageIndex">
    </div>
</template>
<script>
    import VueGallery from 'vue-gallery';

    export default {
        components: {
            'gallery': VueGallery
        },
        props: ['modification'],

        data() {
            return {
                images: [],
                index: null,
            }
        },
        created() {
            axios.get('/api/mods/modifications/' + this.modification.id + '/images').then(({data}) => {
                this.images = data.map(function (value) {
                    return value.downloadLink;
                });
            });
        },
    }
</script>