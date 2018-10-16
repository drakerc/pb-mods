<template>
    <div>
        <category-mod v-for="mod in mods" :key="mod.id" :mod="mod"></category-mod>
    </div>
</template>
<script>
    import CategoryMod from './CategoryMod';

    export default {
        props: ['category'],
        data() {
            return {
                mods: [],
            }
        },
        components: {
            CategoryMod,
        },
        watch: {
            category: function (value) {
                if (value !== undefined) {
                    axios.get('/api/mods/category/' + this.category + '/modifications').then(({data}) => {
                        this.mods = data;
                    });
                }
            }
        }
    }
</script>
<style>
</style>