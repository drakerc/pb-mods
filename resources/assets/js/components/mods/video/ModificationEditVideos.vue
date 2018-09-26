<template>
    <div>
        <form role="form" method="POST" :action="'/mods/modifications/' + mod.id + '/create-videos'">
            <input type="hidden" name="_token" :value="csrf_token">
            <input name="_method" type="hidden" value="PUT">
            <h3>Edytujesz pliki wideo do modyfikacji {{ mod.title }}</h3>

            <div v-for="(value, index) in videos">
                <modification-create-video :video="value" :key="index" :index="value.id" :edit="true"></modification-create-video>
                <modification-delete-video :video="value" :mod="mod" :index="index" v-on:delete-file="deleteFile"></modification-delete-video>
            </div>

            <div class="form-control">
                <b-button size="lg" variant="primary" type="submit">
                    Wyślij
                </b-button>
            </div>
        </form>
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
