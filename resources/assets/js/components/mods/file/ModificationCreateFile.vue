<template>
    <div>
        <div v-if="!image_gallery" class="form-group">
            <label :for="'files[' + index + '][title]'">Tytuł</label>
            <input :id="'files[' + index + '][title]'" type="text" :name="'files[' + index + '][title]'" class="form-control"
                   placeholder="Tytuł" v-model="title" required autofocus>
        </div>

        <div v-if="!image_gallery" class="form-group">
            <input type="hidden" :name="'files[' + index + '][description]'" :value="description">
            <label :for="'files[' + index + '][description]'">Opis</label>
            <vue-editor :id="'files[' + index + '][description]'" v-model="description"></vue-editor>
        </div>

        <div class="form-group">
            <label :for="'files[' + index + ']'">Plik</label>
            <div v-if="file !== undefined">
                Obecny plik: {{ file.file_path }}.
                By go zmienić, wrzuć inny plik.
            </div>
            <input type="file" :id="'files[' + index + ']'" :name="'files[' + index + ']'" class="form-control-file">
        </div>

        <div v-if="edit === true" class="form-group">
            <input type="hidden" :name="'files[' + index + '][id]'" :value="file.id">
            <!--<label :for="'files[' + index + '][availability]'">Dostępność</label>-->
            <!--<input :id="'files[' + index + '][title]'" type="text" :name="'files[' + index + '][title]'" class="form-control"-->
                   <!--placeholder="Tytuł" v-model="title" required autofocus>-->
            <div class="radio-inline">
                <label><input type="radio" :name="'files[' + index + '][availability]'" value="1" :checked="file.availability === 1">Dostępny</label>
            </div>
            <div class="radio-inline">
                <label><input type="radio" :name="'files[' + index + '][availability]'" value="0" :checked="file.availability === 0">Niedostępny</label>
            </div>
        </div>

    </div>
</template>
<script>
    import { VueEditor } from 'vue2-editor';

    export default {
        components: {
            VueEditor,
        },
        props: ['index', 'image_gallery', 'file', 'edit'],
        beforeMount: function () {
            if (this.file !== undefined) {
                this.description = this.file.pivot.description;
                this.title = this.file.pivot.title;
            }
        },

        data() {
            return {
                title: '',
                description: '',
            };
        },
    }
</script>
