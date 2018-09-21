<template>
    <div>
        <modification-file v-if="files[0].id !== undefined" v-for="file in files" :key="file.id" :file="file"></modification-file>
    </div>
</template>
<script>
    import ModificationFile  from './ModificationFile.vue';

    export default {
        props: ['modification'],
        data() {
            return {
                files: '',
            }
        },
        components: {
            ModificationFile
        },
        created() {
            axios.get('/api/mods/modifications/' + this.modification.id + '/files').then(({data}) => {
                this.files = data;
            });
        },
    }
</script>
<style>
    .about {
        margin: 2em 0;
    }
    .about h3 {
        font-size: 22px;
    }
</style>