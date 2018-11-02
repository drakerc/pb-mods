<template>
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <form role="form" method="POST" :action="'/mods/modifications/' + mod.id + '/edit-videos'">
                    <input type="hidden" name="_token" :value="csrf_token">
                    <input name="_method" type="hidden" value="PUT">
                    <h3>Edytujesz pliki wideo do modyfikacji {{ mod.title }}</h3>

                    <div v-for="(value, index) in videos">
                        <modification-delete-video :key="value.id" :video="value" :mod="mod" :index="index" v-on:delete-file="deleteFile"></modification-delete-video>
                        <modification-create-video :key="value.id" :video="value" :index="index" :edit="true"></modification-create-video>
                    </div>

                    <b-button block=true size="lg" variant="primary" type="submit">
                        <font-awesome-icon icon="save" />
                        Wyślij
                    </b-button>
                </form>
            </div>
            <!--<div class="col-md-2">-->
                <!--<b-button size="md" variant="secondary" @click="files_amount++">-->
                    <!--Wybierz więcej filmików-->
                <!--</b-button>-->
                <!--<b-button size="md" variant="warning" v-if="files_amount > 1" @click="files_amount&#45;&#45;">-->
                    <!--Usuń ostatni filmik-->
                <!--</b-button>-->
            <!--</div>-->
        </div>
    </div>
</template>
<script>
    import routeMixin from '../../../route-mixin.js';
    import ModificationCreateVideo from './ModificationCreateVideo.vue';
    import ModificationDeleteVideo from './ModificationDeleteVideo';

    export default {
        mixins: [ routeMixin ],
        components: {
            ModificationCreateVideo,
            ModificationDeleteVideo
        },
        data() {
            return {
                mod: '',
                auth: '',
                videos: '',
                files_amount: 1,
                csrf_token: window.window.csrf_token,
            };
        },
        methods: {
            assignData({auth, mod, videos}) {
                this.auth = auth;
                this.mod = mod;
                this.videos = videos;
            },
            deleteFile: function (id) {
                this.videos.splice(id, 1);
            }
        },
    }
</script>
