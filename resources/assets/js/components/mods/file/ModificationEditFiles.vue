<template>
    <div>
        <form enctype="multipart/form-data" role="form" method="POST" :action="'/mods/modifications/' + mod.id + '/edit-files'">
            <input type="hidden" name="_token" :value="csrf_token">
            <input name="_method" type="hidden" value="PUT">

            <h3>Edytujesz pliki do modyfikacji {{ mod.title }}</h3>

            <modification-create-file v-for="(value, index) in files" :file="value" :key="index" :index="value.id" :image_gallery="false" :edit="true"></modification-create-file>

            <b-button size="lg" variant="primary" type="submit">
                Wyślij
            </b-button>
        </form>
    </div>
</template>
<script>
    import routeMixin from '../../../route-mixin.js';
    import { VueEditor } from 'vue2-editor';
    import ModificationCreateFile from './ModificationCreateFile.vue';

    export default {
        mixins: [ routeMixin ],
        components: {
            VueEditor,
            ModificationCreateFile
        },
        data() {
            return {
                mod: '',
                files: '',
                auth: '',
                csrf_token: window.window.csrf_token,
            };
        },
        methods: {
            assignData({auth, mod, files}) {
                this.auth = auth;
                this.files = files;
                this.mod = mod;
            },
        },
    }
</script>
