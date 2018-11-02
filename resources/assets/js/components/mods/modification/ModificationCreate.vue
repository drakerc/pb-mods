<template>
    <div class="container">

    <form enctype="multipart/form-data" role="form" method="POST" action="/mods/create-modification">
            <input type="hidden" name="_token" :value="csrf_token">
            <input type="hidden" name="categoryid" :value="category ? category.id : null">
            <input type="hidden" name="gameid" :value="game.id">

            <h3>Tworzenie nowej modyfikacji do gry {{ game.title }}</h3>
            <h4 v-if="category">Kategoria: {{ category.title }}</h4>
            <p>Z pomocą tego formularza stworzyć nową modyfikację w naszym serwisie. Twoja modyfikacja może być już wydana, bądź też być dopiero w trakcie produkcji.</p>
            <p>W pierwszym kroku wypełnij podstawowy formularz o modyfikacji. Po jego wysłaniu będziesz mógł dodać pliki do pobrania, uzupełnić galerię obrazków, nowości, czy też filmiki.</p>

        <div class="col-md-12">
            <div class="mb-3">
                <label for="title">Tytuł</label>
                <input id="title" type="text" name="title" class="form-control"
                       placeholder="Tytuł" required autofocus>
            </div>

            <div class="mb-3">
                <input type="hidden" name="size" :value="size.value">
                <label for="size">Wielkość modyfikacji</label>
                <multiselect id="size" track-by="value" label="label" v-model="size" :options="[{label: 'Niewielka, pojedyńcza modyfikacja', value: 0}, {label: 'Średniej wielkości modyfikacja', value: 1}, {label: 'Duża, kompletna modyfikacja', value: 2}]"></multiselect>
            </div>

            <div class="mb-3">
                <input type="hidden" name="development_status" :value="development_status.value">
                <label for="development_status">Status produkcji</label>
                <multiselect id="development_status" track-by="value" label="label" v-model="development_status" :options="[{label: 'Nierozpoczęty', value: 0}, {label: 'W trakcie tworzenia', value: 1}, {label: 'W trakcie testów', value: 2}, {label: 'Wydany', value: 3}, {label: 'Wstrzymany', value: 4}]"></multiselect>
            </div>

            <div class="mb-3">
                <label for="replaces">Zamienia (co podmienia modyfikacja - np. nazwa samochodu, broni; w przypadku większych modyfikacji pozostaw to pole pustym):</label>
                <input class="form-control" id="replaces" type="text" name="replaces">
            </div>

            <div class="mb-3">
                <label for="version">Wersja modyfikacji (pozostaw puste jeśli niewydane)</label>
                <input class="form-control" id="version" type="text" name="version">
            </div>

            <div class="mb-3">
                <label for="release_date">Data wydania (pozostaw puste jeśli niewydane)</label>
                <datepicker format="dd-MM-yyyy" id="release_date" name="release_date"></datepicker>
            </div>

            <div class="mb-3">
                <label for="font_color">Kolor czcionki (możesz dostosować do swoich potrzeb kolor czcionki używanej w kluczowych miejscach prezentacji modyfikacji, m.in. w nagłówkach):</label>
                <input class="form-control" type="color" id="font_color" name="font_color"
                       value="#000000" />
            </div>

            <div class="mb-3">
                <input type="hidden" name="description" :value="description">
                <label for="description">Opis</label>
                <vue-editor id="description" v-model="description"></vue-editor>
            </div>
        </div>
        <hr class="mb-4">


        <!--<div class="form-control">-->
                <!--<p>Studio deweloperskie</p>-->
                <!--<input type="hidden" id="development_studio" name="development_studio" :value="development_studio">-->
                <!--<v-select :v-model="development_studio" :options="development_studios"></v-select>-->
            <!--</div>-->
            <!--// TODO: implement dev studios-->
        <b-button size="lg" variant="primary" block=true type="submit">
            Wyślij
        </b-button>
        </form>
    </div>
</template>
<script>
    import routeMixin from '../../../route-mixin.js';
    import { VueEditor } from 'vue2-editor'
    import Datepicker from 'vuejs-datepicker';
    import Multiselect from 'vue-multiselect'

    export default {
        mixins: [ routeMixin ],
        components: {
            VueEditor,
            Datepicker,
            Multiselect
        },
        data() {
            return {
                category: [],
                game: '',
                auth: '',
                description: '',
                size: '',
                development_status: '',
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
<style>
</style>