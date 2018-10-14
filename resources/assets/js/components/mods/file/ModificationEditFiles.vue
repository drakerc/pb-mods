<template>
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <form enctype="multipart/form-data" role="form" method="POST" :action="'/mods/modifications/' + mod.id + '/edit-files'">
                    <input type="hidden" name="_token" :value="csrf_token">
                    <input name="_method" type="hidden" value="PUT">

                    <h3>Edytujesz pliki do modyfikacji {{ mod.title }}</h3>

                    <div v-for="(value, index) in files">
                        <modification-delete-file :key="value.id" :file="value" :mod="mod" :index="index" v-on:delete-file="deleteFile"></modification-delete-file>
                        <modification-create-file :key="value.id" :file="value" :index="value.id" :image_gallery="false" :edit="true"></modification-create-file>
                    </div>

                    <b-button block=true size="lg" variant="primary" type="submit">
                        Wyślij
                    </b-button>
                </form>
            </div>
            <!--<div class="col-md-2">-->
                <!--<b-button size="md" variant="secondary" @click="files_amount++">-->
                    <!--Dodaj więcej plików-->
                <!--</b-button>-->
                <!--<b-button size="md" variant="warning" v-if="files_amount > 1" @click="files_amount&#45;&#45;">-->
                    <!--Usuń ostatni plik-->
                <!--</b-button>-->
            <!--</div>-->
        </div>
    </div>
</template>
<script>
    import routeMixin from '../../../route-mixin.js';
    import { VueEditor } from 'vue2-editor';
    import ModificationCreateFile from './ModificationCreateFile.vue';
    import ModificationDeleteFile from './ModificationDeleteFile';

    export default {
        mixins: [ routeMixin ],
        components: {
            VueEditor,
            ModificationCreateFile,
            ModificationDeleteFile
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
            deleteFile: function (id) {
                this.files.splice(id, 1);
            }
        },
    }
</script>
