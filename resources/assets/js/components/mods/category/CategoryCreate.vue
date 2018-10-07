<template>
    <div class="container">
        <h3>Tworzenie nowej kategorii do gry {{ game.title }}</h3>
        <h4 v-if="category">Kategoria: {{ category.title }}</h4>
        <p>Z pomocą tego formularza możesz zasugerować stworzenie nowej kategorii. Wypełniona przez ciebie propozycja trafi do administracji, która dokona akceptacji Twojej kategorii.</p>
        <form enctype="multipart/form-data" role="form" method="POST" action="/mods/create-category">
            <input type="hidden" name="_token" :value="csrf_token">
            <input type="hidden" name="categoryid" :value="category ? category.id : null">
            <input type="hidden" name="gameid" :value="game.id">
            <div class="col-md-12">
                <div class="mb-3">
                    <label for="title">Tytuł</label>
                    <div class="input-group">
                        <input name="title" type="text" class="form-control" id="title" placeholder="Tytuł" required>
                        <div class="invalid-feedback" style="width: 100%;">
                            Wprowadź poprawny tytuł
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="thumbnail">Miniaturka</label>
                    <div class="input-group">
                        <input type="file" id="thumbnail" name="thumbnail" accept="image/*" class="form-control-file">
                        <div class="invalid-feedback" style="width: 100%;">
                            Wprowadź poprawny plik
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="background">Tło kategorii</label>
                    <div class="input-group">
                        <input type="file" id="background" name="background" accept="image/*" class="form-control-file">
                        <div class="invalid-feedback" style="width: 100%;">
                            Wprowadź poprawny plik
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="description">Opis</label>
                    <div class="input-group">
                        <input type="hidden" id="description" name="description" :value="description">
                        <vue-editor v-model="description"></vue-editor>
                    </div>
                </div>
            </div>
            <br><br>
            <div class="form-control">
                <b-button size="lg" variant="primary" block=true type="submit">
                    Wyślij
                </b-button>
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