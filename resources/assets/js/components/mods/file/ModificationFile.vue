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
                        <a :href="file.downloadLink" class="btn btn-lg btn-outline-primary">
                           Pobierz ten plik
                        </a>
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
    export default {
        props: ['file'],
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