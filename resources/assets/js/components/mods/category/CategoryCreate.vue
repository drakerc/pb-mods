<template>
    <div>
        <form enctype="multipart/form-data" role="form" method="POST" action="/mods/create-category">
            <input type="hidden" name="_token" :value="csrf_token">
            <input type="hidden" name="categoryid" :value="category ? category.id : null">
            <input type="hidden" name="gameid" :value="game.id">

            <h3>Tworzenie nowej kategorii do gry {{ game.title }}</h3>
            <h4 v-if="category">Kategoria: {{ category.title }}</h4>
            <p>Z pomocą tego formularza możesz zasugerować stworzenie nowej kategorii. Wypełniona przez ciebie propozycja trafi do administracji, która dokona akceptacji Twojej kategorii.</p>
            <div class="form-control">
                <input id="title" type="text" name="title"
                       placeholder="Tytuł" required autofocus>
            </div>
            <div class="form-control">
                <input type="file" id="thumbnail" name="thumbnail" accept="image/*" class="input-file">
                <p>Obrazek kategorii (miniaturka)</p>
            </div>
            <div class="form-control">
                <input type="file" id="background" name="background" accept="image/*" class="input-file">
                <p>Tło kategorii</p>
            </div>
            <div class="form-control">
                <input type="hidden" id="description" name="description" :value="description">
                <p>Opis</p>
                <vue-editor v-model="description"></vue-editor>
            </div>
            <div class="form-control">
                <button type="submit">Wyślij</button>
            </div>
        </form>
    </div>
</template>
<script>
    import routeMixin from '../../../route-mixin.js';
    import { VueEditor } from 'vue2-editor'

    export default {
        mixins: [ routeMixin ],
        components: {
            VueEditor
        },
        data() {
            return {
                category: [],
                game: '',
                auth: '',
                description: '',
                csrf_token: window.window.csrf_token
            };
        },
        methods: {
            assignData({category, game, auth}) {
                this.category = category;
                this.game = game;
                this.auth = auth;
            },
        },
    }
</script>