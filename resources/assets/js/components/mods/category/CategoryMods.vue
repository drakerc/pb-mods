<template>
    <div>
        <div class="row">
            <category-mod v-for="mod in mods.data" :key="mod.id" :mod="mod"></category-mod>
        </div>
        <div class="footer">
            <pagination :data="mods" @pagination-change-page="getResults"></pagination>
        </div>
    </div>
</template>
<script>
    import CategoryMod from './CategoryMod';
    import pagination from 'laravel-vue-pagination';

    export default {
        props: ['category'],
        data() {
            return {
                mods: [],
            }
        },
        components: {
            CategoryMod,
            pagination,
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
        methods: {
            getResults: function (page = 1) {
                axios.get('/api/mods/category/' + this.category + '/modifications' + '?page=' + page).then(({data}) => {
                    this.mods = data;
                });
            }
        }
    }
</script>
<style>
</style>