<template>
    <div>
        <form enctype="multipart/form-data" role="form" method="POST" :action="'/mods/modifications/' + mod.id + '/create-images'">
            <input type="hidden" name="_token" :value="csrf_token">
            <input type="hidden" name="type" :value="3">

            <h3>Dodajesz obrazki do galerii do modyfikacji {{ mod.title }}</h3>

            <modification-create-file v-for="index in files_amount" :key="index" :index="index" :image_gallery="true"></modification-create-file>
            <!--Add checking if files are img files only-->

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
    import ModificationCreateFile from './ModificationCreateFile.vue';

    export default {
        mixins: [ routeMixin ],
        components: {
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
