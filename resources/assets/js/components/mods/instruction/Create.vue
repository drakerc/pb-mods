<template>
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <form enctype="multipart/form-data" role="form" method="POST"
                      :action="'/mods/modifications/' + $route.params.mod + '/files/' + fileId + '/edit-instruction/' + id !== undefined ? id : ''">
                    <input type="hidden" name="_token" :value="csrf_token">

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
                    <delete v-if="instruction !== ''" :instruction="instruction" :modId="$route.params.mod" :fileId="fileId"></delete>
                    <b-button block=true size="lg" variant="primary" type="submit">
                        Wyślij
                    </b-button>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
    import {VueEditor} from 'vue2-editor';
    import Delete from './Delete';
    import routeMixin from '../../../route-mixin.js';

    export default {
        components: {
            VueEditor,
            Delete,
        },
        mixins: [ routeMixin ],
        data() {
            return {
                instruction: '',
                id: '',
                fileId: '',
                title: '',
                description: '',
                csrf_token: window.window.csrf_token,
            };
        },
        methods: {
            assignData({auth, file, instruction}) {
                this.auth = auth;
                this.fileId = file.id;
                if (instruction !== undefined) {
                    this.instruction = instruction;
                    this.title = instruction.title;
                    this.description = instruction.description;
                    this.id = instruction.id
                }
            },
        },
    }
</script>
