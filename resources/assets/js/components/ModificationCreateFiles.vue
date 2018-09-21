<template>
    <div>
        <form enctype="multipart/form-data" role="form" method="POST" :action="'/mods/modifications/' + mod.id + '/create-files'">
            <input type="hidden" name="_token" :value="csrf_token">
            <h3>Dodajesz pliki do modyfikacji {{ mod.title }}</h3>

            <modification-create-file v-for="index in files_amount" :key="index" :index="index" :image_gallery="false"></modification-create-file>

            <div class="form-control">
                <b-button size="md" variant="warning" v-if="files_amount > 1" @click="files_amount--">
                    Usuń ostatni plik
                </b-button>
                <b-button size="md" variant="secondary" @click="files_amount++">
                    Wybierz więcej plików
                </b-button>
                <b-button size="lg" variant="primary" type="submit">
                    Wyślij
                </b-button>
            </div>
        </form>
    </div>
</template>
<script>
    import routeMixin from '../route-mixin.js';
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
