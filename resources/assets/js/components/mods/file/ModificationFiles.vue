<template>
    <div>
        <div class="row">
            <modification-file :canManageMod="canManageMod" v-if="files.data[0].id !== undefined" v-for="file in files.data" :key="file.id" :file="file" v-on:selectFile="addSelectedFile"></modification-file>
        </div>

        <div class="footer">
            <pagination :data="files" @pagination-change-page="getResults"></pagination>
        </div>

        <div v-if="selectedFiles.length !== 0" class="jumbotron bg-light mt-3 pt-3">
            <form ref="massDownloadForm" role="form" method="GET" :action="'/mods/modifications/' + modification.id + '/mass-download'">
                <div class="lead">Wybrałeś poniższe pliki do pobrania:</div>
                <p v-for="file in selectedFiles">{{ file.pivot.title }}</p>
                <input type="hidden" name="files" :value="selectedFilesIds">
                <input type="hidden" name="withInstructions" :value="withInstructions">

                <div class="form-check">
                    <input class="form-check-input" value="true" name="withInstructions" type="checkbox" id="withInstructions">
                    <label class="form-check-label" for="withInstructions">
                        Dodaj instrukcje do archiwum z plikami
                    </label>
                </div>

                <b-button size="lg" variant="primary" block="true" type="submit">
                    Pobierz paczkę
                </b-button>
            </form>
        </div>
    </div>
</template>
<script>
    import ModificationFile  from './ModificationFile.vue';
    import pagination from 'laravel-vue-pagination';

    export default {
        props: ['modification', 'canManageMod'],
        data() {
            return {
                files: '',
                selectedFiles: [],
                selectedFilesIds: [],
            }
        },
        components: {
            ModificationFile,
            pagination
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
            },
            getResults: function (page) {
                axios.get('/api/mods/modifications/' + this.modification.id + '/files' + '?page=' + page).then(({data}) => {
                    this.files = data;
                });
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