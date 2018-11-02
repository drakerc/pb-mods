<template>
    <div class="container">
        <loading :active.sync="isLoading" is-full-page="true"></loading>

        <h3>Przeglądasz modyfikacje autorstwa studia {{ studio.name }}.</h3>
        <div class="row">
            <category-mod v-for="mod in mods" :key="mod.id" :mod="mod"></category-mod>
        </div>
    </div>
</template>
<script>
    import CategoryMod from '../category/CategoryMod';
    // Import component
    import Loading from 'vue-loading-overlay';
    // Import stylesheet
    import 'vue-loading-overlay/dist/vue-loading.css';

    export default {
        data() {
            return {
                mods: [],
                studio: '',
                isLoading: true,
            }
        },
        components: {
            CategoryMod,
            Loading
        },
        created() {
            axios.get('/api/devstudios/' + this.$route.params['studio'] + '/mods').then(({data}) => {
                this.mods = data.mods.data;
                this.studio = data.studio;
                this.isLoading = false;
            });
        },
    }
</script>
<style>
</style>