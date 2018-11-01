<template>
    <div class="row">
        <category-mod v-for="mod in mods.data" :key="mod.id" :mod="mod"></category-mod>
        <!--<pagination :data="mods" @pagination-change-page="getResults"></pagination>-->
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
        },
        // methods: {
        //     getResults: function () {
        //         axios.get('/api/mods/category/' + this.category + '/modifications').then(({data}) => {
        //             this.mods = data;
        //         });
        //     }
        // }
    }
</script>
<style>
</style>