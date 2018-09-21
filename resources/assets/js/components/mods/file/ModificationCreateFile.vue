<template>
    <div>
        <div v-if="!image_gallery" class="form-group">
            <label :for="'files[' + index + '][title]'">Tytuł</label>
            <input :id="'files[' + index + '][title]'" type="text" :name="'files[' + index + '][title]'" class="form-control"
                   placeholder="Tytuł" required autofocus>
        </div>

        <div v-if="!image_gallery" class="form-group">
            <input type="hidden" :name="'files[' + index + '][description]'" :value="description">
            <label :for="'files[' + index + '][description]'">Opis</label>
            <vue-editor :id="'files[' + index + '][description]'" v-model="description"></vue-editor>
        </div>

        <div class="form-group">
            <label :for="'files[' + index + ']'">Plik</label>
            <input type="file" :id="'files[' + index + ']'" :name="'files[' + index + ']'" class="form-control-file">
        </div>
    </div>
</template>
<script>
    import { VueEditor } from 'vue2-editor';

    export default {
        components: {
            VueEditor,
        },
        props: ['index', 'image_gallery'],

        data() {
            return {
                description: '',
            };
        },
    }
</script>
