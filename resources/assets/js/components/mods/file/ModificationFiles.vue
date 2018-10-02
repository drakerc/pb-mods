<template>
    <div>
        <modification-file v-if="files[0].id !== undefined" v-for="file in files" :key="file.id" :file="file" v-on:selectFile="addSelectedFile"></modification-file>

        <div v-if="selectedFiles.length !== 0">
            <form role="form" method="GET" :action="'/mods/modifications/' + modification.id + '/mass-download'">
                Wybrałeś poniższe pliki do pobrania:
                <div v-for="file in selectedFiles">{{ file.pivot.title }}</div>
                <input type="hidden" name="files" :value="selectedFilesIds">

                <b-button size="lg" variant="primary" type="submit">
                    Pobierz
                </b-button>
            </form>

        </div>
    </div>
</template>
<script>
    import ModificationFile  from './ModificationFile.vue';

    export default {
        props: ['modification'],
        data() {
            return {
                files: '',
                selectedFiles: [],
                selectedFilesIds: []
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
        methods: {
            addSelectedFile: function (file, value) {
                if (value === true) {
                    this.selectedFiles.push(file);
                    this.selectedFilesIds.push(file.id);
                } else {
                    var index = this.selectedFiles.findIndex(value => value.id === file.id);
                    this.selectedFiles.splice(index, 1);
                    this.selectedFilesIds.splice(this.selectedFilesIds.indexOf(file.id));
                }
            }
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