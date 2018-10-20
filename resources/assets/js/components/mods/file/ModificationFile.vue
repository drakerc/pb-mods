<template>
    <div class="col-md-4">
        <div class="card mb-4 box-shadow">
            <div class="text-center">
                {{ file.pivot.title }}
            </div>

            <div class="card-body">
                <p class="card-text"><span v-html="file.pivot.description"></span></p>
                <div>
                    <div>
                        <a :href="$route.params['mod'] + '/files/' + file.id + '/download'" class="btn btn-lg btn-outline-primary">
                           Pobierz ten plik
                        </a>
                        <router-link :to="{ name: 'modification_create_instruction', params: { mod: $route.params['mod'], file: file.id } }">
                            <li>Dodaj instrukcję do pliku</li>
                        </router-link>

                        <file-instructions :passedFile="file" :passedModId="$route.params['mod']"></file-instructions>

                        <div>
                            <input class="form-check-input" type="checkbox" :id="'checkbox-' + file.id" v-model="selected" v-on:change="$emit('selectFile', file, selected)">
                            <label for="'checkbox-' + file.id">Zaznacz, by dodać do pobierania masowego</label>
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