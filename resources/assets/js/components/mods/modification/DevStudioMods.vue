<template>
    <div class="">
        <h3>Przeglądasz modyfikacje autorstwa studia {{ studio.name }}.</h3>
        <div class="row">
            <category-mod v-for="mod in mods" :key="mod.id" :mod="mod"></category-mod>
        </div>
    </div>
</template>
<script>
    import CategoryMod from '../category/CategoryMod';

    export default {
        data() {
            return {
                mods: [],
                studio: '',
            }
        },
        components: {
            CategoryMod,
        },
        created() {
            axios.get('/api/devstudios/' + this.$route.params['studio'] + '/mods').then(({data}) => {
                this.mods = data.mods.data;
                this.studio = data.studio;
            });
        },
    }
</script>
<style>
</style>