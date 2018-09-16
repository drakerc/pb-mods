<template>
    <div>
        <form enctype="multipart/form-data" role="form" method="POST" :action="'/mods/modifications/' + mod.id + '/create-files'">
            <input type="hidden" name="_token" :value="csrf_token">
            <h3>Dodajesz pliki do modyfikacji {{ mod.title }}</h3>

            <modification-create-file v-for="index in files_amount" :key="index" :index="index"></modification-create-file>

            <!--<div v-for="index in files_amount">-->
                <!--<div class="form-group">-->
                    <!--<label :for="'title-' + index">Tytuł</label>-->
                    <!--<input :id="'title-' + index" type="text" :name="'title-' + index" class="form-control"-->
                           <!--placeholder="Tytuł" required autofocus>-->
                <!--</div>-->

                <!--<div class="form-group">-->
                    <!--<input type="hidden" name="description" :value="description">-->
                    <!--<label :for="'description-' + index">Opis</label>-->
                    <!--<vue-editor :id="'description-' + index" v-model="description"></vue-editor>-->
                <!--</div>-->

                <!--<div class="form-group">-->
                    <!--<label :for="'file-' + index">Opis</label>-->
                    <!--<input type="file" :id="'file-' + index" :name="'file-' + index" class="form-control-file">-->
                <!--</div>-->
            <!--</div>-->

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
                console.log(mod)
                this.auth = auth;
                this.mod = mod;
            },
        },
    }
</script>
