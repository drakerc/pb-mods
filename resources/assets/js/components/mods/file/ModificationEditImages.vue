<template>
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <form enctype="multipart/form-data" role="form" method="POST"
                      :action="'/mods/modifications/' + mod.id + '/edit-images'">
                    <input type="hidden" name="_token" :value="csrf_token">
                    <input type="hidden" name="type" :value="3">
                    <input name="_method" type="hidden" value="PUT">

                    <h3>Edytujesz obrazki do galerii do modyfikacji {{ mod.title }}</h3>

                    <div v-for="(value, index) in files" class="row">
                        <div class="col-md-10">
                            <modification-delete-file :file="value" :mod="mod" :index="index" v-on:delete-file="deleteFile"></modification-delete-file>
                            <modification-create-file :file="value" :key="index" :index="value.id" :image_gallery="true" :edit="true"></modification-create-file>
                        </div>
                        <div class="col-md-2">
                            <edit-image-file-thumbnail :image="value.downloadLink"></edit-image-file-thumbnail>
                        </div>
                    </div>


                    <b-button block=true size="lg" variant="primary" type="submit">
                        <font-awesome-icon icon="save" />
                        Wyślij
                    </b-button>
                </form>
            </div>
            <!--<div class="col-md-2">-->
                <!--<b-button size="md" variant="secondary" @click="files_amount++">-->
                    <!--Dodaj więcej obrazków-->
                <!--</b-button>-->
                <!--<b-button size="md" variant="warning" v-if="files_amount > 1" @click="files_amount&#45;&#45;">-->
                    <!--Usuń ostatni obrazek-->
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
    import EditImageFileThumbnail from './EditImageFileThumbnail';

    export default {
        mixins: [ routeMixin ],
        components: {
            VueEditor,
            ModificationCreateFile,
            ModificationDeleteFile,
            EditImageFileThumbnail
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
