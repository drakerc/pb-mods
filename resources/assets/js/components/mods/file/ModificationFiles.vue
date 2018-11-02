<template>
    <div>
        <loading :active.sync="isLoading" is-full-page="true"></loading>
        <div class="text-white" v-if="files.data.length === 0">
            Przykro nam, ale autor modyfikacji nie wrzucił do niej żadnych powiązanych plików. Spróbuj później!
        </div>

        <div v-else class="jumbotron container">
            <div class="row">
                <modification-file :canManageMod="canManageMod" v-if="files.data[0].id !== undefined" v-for="file in files.data" :key="file.id" :file="file" v-on:selectFile="addSelectedFile"></modification-file>
            </div>

            <div class="footer">
                <pagination :data="files" @pagination-change-page="getResults"></pagination>
            </div>
        </div>

        <div v-if="selectedFiles.length !== 0" class="jumbotron bg-light mt-3 pt-3">
            <form ref="massDownloadForm" role="form" method="GET" :action="'/mods/modifications/' + modification.id + '/mass-download'">
                <div class="lead">Wybrałeś poniższe pliki do pobrania:</div>
                <ul class="list-group">
                    <li class="list-group-item" v-for="file in selectedFiles">{{ file.pivot.title }}</li>
                </ul>
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

    // Import component
    import Loading from 'vue-loading-overlay';
    // Import stylesheet
    import 'vue-loading-overlay/dist/vue-loading.css';

    export default {
        props: ['modification', 'canManageMod'],
        data() {
            return {
                files: '',
                selectedFiles: [],
                selectedFilesIds: [],
                isLoading: false,
            }
        },
        components: {
            ModificationFile,
            pagination,
            Loading
        },
        created() {
            axios.get('/api/mods/modifications/' + this.modification.id + '/files').then(({data}) => {
                this.files = data;
                this.$emit('complete-loading');
            });
        },
        methods: {
            addSelectedFile: function (file) {
                var index = this.selectedFiles.findIndex(value => value.id === file.id);
                if (index === -1) {
                    this.selectedFiles.push(file);
                    this.selectedFilesIds.push(file.id);
                } else {
                    this.selectedFiles.splice(index, 1);
                    this.selectedFilesIds.splice(this.selectedFilesIds.indexOf(file.id));
                }
            },
            getResults: function (page) {
                this.isLoading = true;
                axios.get('/api/mods/modifications/' + this.modification.id + '/files' + '?page=' + page).then(({data}) => {
                    this.files = data;
                    this.isLoading = false;
                });
            }
        },
    }
</script>
<style>
    .dark-jumbotron {
        color: #e3e3e3;
        background-color: #464646;
    }
</style>