<template>
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <form enctype="multipart/form-data" role="form" method="POST" :action="'/mods/modifications/' + mod.id + '/create-files'">
                    <input type="hidden" name="_token" :value="csrf_token">
                    <h3>Dodajesz pliki do modyfikacji {{ mod.title }}</h3>
                    <modification-create-file v-for="index in files_amount" :key="index" :index="index" :image_gallery="false"></modification-create-file>
                    <b-button block=true size="lg" variant="primary" type="submit">
                        <font-awesome-icon icon="save" />
                        Wyślij
                    </b-button>
                </form>
            </div>
            <div class="col-md-2">
                <b-button size="md" variant="secondary" @click="files_amount++">
                    <font-awesome-icon icon="plus" />
                    Dodaj więcej plików
                </b-button>
                <b-button size="md" variant="warning" v-if="files_amount > 1" @click="files_amount--">
                    <font-awesome-icon icon="minus" />
                    Usuń ostatni plik
                </b-button>
            </div>
        </div>
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
                description: '',
                auth: '',
                files_amount: 1,
                csrf_token: window.window.csrf_token,
            };
        },
        methods: {
            assignData({auth, mod}) {
                this.auth = auth;
                this.mod = mod;
            },
        },
    }
</script>
