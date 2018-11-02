<template>
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <form enctype="multipart/form-data" role="form" method="POST"
                      :action="'/mods/modifications/' + $route.params.mod + '/edit-news/' + id !== undefined ? id : ''">
                    <input type="hidden" name="_token" :value="csrf_token">
                    <input v-if="id !== undefined" type="hidden" name="id" :value="id">

                    <div class="form-group">
                        <label :for="'title'">Tytuł</label>
                        <input :id="'title'" type="text" :name="'title'" class="form-control"
                               placeholder="Tytuł" v-model="title" required autofocus>
                    </div>

                    <div class="form-group">
                        <input type="hidden" :name="'description'" :value="description">
                        <label :for="'description'">Opis</label>
                        <vue-editor :id="'description'" v-model="description"></vue-editor>
                    </div>

                    <hr class="mb-4">
                    <b-button block=true size="lg" variant="primary" type="submit">
                        <font-awesome-icon icon="save" />
                        Wyślij
                    </b-button>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
    import {VueEditor} from 'vue2-editor';
    import routeMixin from '../../../route-mixin.js';

    export default {
        components: {
            VueEditor,
        },
        mixins: [ routeMixin ],
        data() {
            return {
                id: '',
                title: '',
                description: '',
                csrf_token: window.window.csrf_token,
            };
        },
        methods: {
            assignData({auth, news}) {
                this.auth = auth;
                if (news !== undefined) {
                    this.title = news.title;
                    this.description = news.description;
                    this.id = news.id
                }
            },
        },
    }
</script>
