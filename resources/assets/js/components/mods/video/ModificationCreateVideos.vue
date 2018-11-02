<template>
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <form role="form" method="POST" :action="'/mods/modifications/' + mod.id + '/create-videos'">
                    <input type="hidden" name="_token" :value="csrf_token">
                    <h3>Dodajesz pliki wideo do modyfikacji {{ mod.title }}</h3>

                    <modification-create-video v-for="index in files_amount" :key="index" :index="index"></modification-create-video>
                    <b-button block=true size="lg" variant="primary" type="submit">
                        <font-awesome-icon icon="save" />
                        Wyślij
                    </b-button>
                </form>
            </div>
            <div class="col-md-2">
                <b-button size="md" class="m-3" variant="secondary" @click="files_amount++">
                    <font-awesome-icon icon="plus" />
                    Wybierz więcej filmików
                </b-button>
                <b-button size="md" class="m-3" variant="warning" v-if="files_amount > 1" @click="files_amount--">
                    <font-awesome-icon icon="minus" />
                    Usuń ostatni filmik
                </b-button>
            </div>
        </div>
    </div>
</template>
<script>
    import routeMixin from '../../../route-mixin.js';
    import ModificationCreateVideo from './ModificationCreateVideo.vue';

    export default {
        mixins: [ routeMixin ],
        components: {
            ModificationCreateVideo
        },
        data() {
            return {
                mod: '',
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
