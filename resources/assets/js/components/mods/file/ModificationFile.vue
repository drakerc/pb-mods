<template>
    <div class="col-md-6">
        <div class="card mb-6 box-shadow">
            <div class="text-center">
                <h3 class="mod-info-value">{{ file.pivot.title }}</h3>
            </div>

            <div class="card-body">
                <p class="card-text"><span v-html="file.pivot.description"></span></p>
                <div>
                    <div class="row">
                        <div class="col-md-6">
                            Rozmiar:
                        </div>
                        <div class="col-md-6 mod-info-value">
                            {{ file.humanReadableFilesize }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            Rozszerzenie:
                        </div>
                        <div class="col-md-6 mod-info-value">
                            {{ file.file_type }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            Ilość pobrań:
                        </div>
                        <div class="col-md-6 mod-info-value">
                            {{ file.downloads }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            Wrzucił:
                        </div>
                        <div class="col-md-6 mod-info-value">
                            {{ file.creatorName }}
                        </div>
                    </div>
                    <div class="row" v-if="canManageMod">
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
                            <font-awesome-icon icon="download" />
                            Pobierz ten plik
                        </a>
                        <file-instructions :canManageMod="canManageMod" :passedFile="file" :passedModId="$route.params['mod']"></file-instructions>

                        <div class="row pt-1 mt-1">
                            <div class="col-md-12">
                                <b-btn block="true" variant="success" :id="'checkbox-' + file.id" v-model="selected" v-on:click="$emit('selectFile', file)">
                                    <font-awesome-icon icon="plus" />
                                    Dodaj/usuń do pobierania masowego
                                </b-btn>
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
        props: ['file', 'canManageMod'],
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
    .mod-info-value {
        font-weight: bold;
    }
</style>