<template>
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <form enctype="multipart/form-data" role="form" method="POST"
                      :action="'/mods/modifications/' + mod.id + '/edit-background-images'">
                    <input type="hidden" name="_token" :value="csrf_token">
                    <input type="hidden" name="type" :value="0">

                    <h3>Edytujesz tło główne do modyfikacji {{ mod.title }}</h3>
                    <p>Pamiętaj, twoja modyfikacja może mieć wybrane tylko jedno aktywne tło!</p>

                    <div v-for="(value, index) in files" class="row">
                        <div class="col-md-10">
                            <modification-delete-file :file="value" :mod="mod" :index="index" v-on:delete-file="deleteFile"></modification-delete-file>
                            <modification-create-file :file="value" :key="index" :index="value.id" :image_gallery="true" :edit="true"></modification-create-file>
                        </div>
                        <div class="col-md-2">
                            <edit-image-file-thumbnail :image="value.downloadLink"></edit-image-file-thumbnail>
                        </div>
                    </div>

                    <modification-create-file v-for="index in files_amount" :key="index" :index="index" :show_availability="true" :image_gallery="true"></modification-create-file>

                    <b-button block=true size="lg" variant="primary" type="submit">
                        <font-awesome-icon icon="save" />
                        Wyślij
                    </b-button>
                </form>
            </div>
            <div class="col-md-2">
                <b-button size="md" class="m-3" variant="secondary" @click="files_amount++">
                    <font-awesome-icon icon="plus" />
                    Dodaj więcej obrazków
                </b-button>
                <b-button size="md" class="m-3" variant="warning" v-if="files_amount > 0" @click="files_amount--">
                    <font-awesome-icon icon="minus" />
                    Usuń ostatni obrazek
                </b-button>
            </div>
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
                files_amount: 0,
            };
        },
        methods: {
            assignData({auth, mod, files}) {
                this.auth = auth;
                this.files = files;
                this.mod = mod;
                this.files_amount = this.files.length > 0 ? 0 : 1;
            },
            deleteFile: function (id) {
                this.files.splice(id, 1);
            }
        },
    }
</script>
