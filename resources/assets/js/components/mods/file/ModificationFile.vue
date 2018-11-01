<template>
    <div class="col-md-6">
        <div class="card mb-6 box-shadow">
            <div class="text-center">
                {{ file.pivot.title }}
            </div>

            <div class="card-body">
                <p class="card-text"><span v-html="file.pivot.description"></span></p>
                <div>
                    <div class="row">
                        <div class="col-md-6">
                            Rozmiar:
                        </div>
                        <div class="col-md-6">
                            {{ file.humanReadableFilesize }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            Rozszerzenie:
                        </div>
                        <div class="col-md-6">
                            {{ file.file_type }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            Ilość pobrań:
                        </div>
                        <div class="col-md-6">
                            {{ file.downloads }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            Wrzucił:
                        </div>
                        <div class="col-md-6">
                            {{ file.uploader_id }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10">
                            <router-link :to="{ name: 'modification_create_instruction', params: { mod: $route.params['mod'], file: file.id } }">
                                Dodaj instrukcję do pliku
                            </router-link>
                        </div>
                    </div>

                    <div class="jumbotron">
                        <div class="lead text-center">
                            Dostępne akcje
                        </div>
                        <a :href="$route.params['mod'] + '/files/' + file.id + '/download'" class="btn btn-block btn-primary">
                            Pobierz ten plik
                        </a>
                        <file-instructions :passedFile="file" :passedModId="$route.params['mod']"></file-instructions>

                        <div class="row pt-1 mt-1">
                            <div class="col-md-12">
                                <input class="form-check-input" type="checkbox" :id="'checkbox-' + file.id" v-model="selected" v-on:change="$emit('selectFile', file, selected)">
                                <label for="'checkbox-' + file.id">Zaznacz, by dodać do pobierania masowego</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import FileInstructions from '../instruction/FileInstructions';

    export default {
        props: ['file'],
        components: {
            FileInstructions,
        },
        data() {
            return {
                selected: false
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