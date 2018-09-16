<template>
    <div>
        <div class="form-group">
            <label :for="'title-file-' + index">Tytuł</label>
            <input :id="'title-file-' + index" type="text" :name="'title-file-' + index" class="form-control"
                   placeholder="Tytuł" required autofocus>
        </div>

        <div class="form-group">
            <input type="hidden" :name="'description-file-' + index" :value="description">
            <label :for="'description-file-' + index">Opis</label>
            <vue-editor :id="'description-file-' + index" v-model="description"></vue-editor>
        </div>

        <div class="form-group">
            <label :for="'file' + index">Opis</label>
            <input type="file" :id="'file-' + index" :name="'file-' + index" class="form-control-file">
        </div>
    </div>
</template>
<script>
    import { VueEditor } from 'vue2-editor';

    export default {
        components: {
            VueEditor,
        },
        props: [ 'index' ],

        data() {
            return {
                description: '',
            };
        },
    }
</script>
