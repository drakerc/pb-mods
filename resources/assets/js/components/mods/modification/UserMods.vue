<template>
    <div class="">
        <h3>Przeglądasz modyfikacje autorstwa użytkownika {{ user.name }}.</h3>
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
                user: '',
            }
        },
        components: {
            CategoryMod,
        },
        created() {
            axios.get('/api/mods/modifications/user-mods/' + this.$route.params['user']).then(({data}) => {
                this.mods = data.mods;
                this.user = data.user;
            });
        },
    }
</script>
<style>
</style>