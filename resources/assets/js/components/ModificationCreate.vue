<template>
    <div>
        <form enctype="multipart/form-data" role="form" method="POST" action="/mods/create-modification">
            <input type="hidden" name="_token" :value="csrf_token">
            <input type="hidden" name="categoryid" :value="category ? category.id : null">
            <input type="hidden" name="gameid" :value="game.id">

            <h3>Tworzenie nowej modyfikacji do gry {{ game.title }}</h3>
            <h4 v-if="category">Kategoria: {{ category.title }}</h4>
            <p>Z pomocą tego formularza stworzyć nową modyfikację w naszym serwisie. Twoja modyfikacja może być już wydana, bądź też być dopiero w trakcie produkcji.</p>
            <p>W pierwszym kroku wypełnij podstawowy formularz o modyfikacji. Po jego wysłaniu będziesz mógł dodać pliki do pobrania, uzupełnić galerię obrazków, nowości, czy też filmiki.</p>


            <div class="form-control">
                <input id="title" type="text" name="title"
                       placeholder="Tytuł" required autofocus>
            </div>

            <div class="form-control">
                <p>Wielkość modyfikacji</p>
                <input type="hidden" id="size" name="size" :value="size.value">
                <multiselect track-by="value" label="label" v-model="size" :options="[{label: 'Niewielka, pojedyńcza modyfikacja', value: 0}, {label: 'Średniej wielkości modyfikacja', value: 1}, {label: 'Duża, kompletna modyfikacja', value: 2}]"></multiselect>
            </div>

            <div class="form-control">
                <p>Status produkcji</p>
                <input type="hidden" id="development_status" name="development_status" :value="development_status.value">
                <multiselect track-by="value" label="label" v-model="development_status" :options="[{label: 'Nierozpoczęty', value: 0}, {label: 'W trakcie tworzenia', value: 1}, {label: 'W trakcie testów', value: 2}, {label: 'Wydany', value: 3}, {label: 'Wstrzymany', value: 4}]"></multiselect>
            </div>

            <div class="form-control">
                <p>Zamienia (co podmienia modyfikacja - np. nazwa samochodu, broni; w przypadku większych modyfikacji pozostaw to pole pustym):</p>
                <input id="replaces" type="text" name="replaces">
            </div>

            <div class="form-control">
                <input id="version" type="number" name="version" placeholder="Wersja modyfikacji (pozostaw puste jeśli niewydane)">
            </div>

            <div class="form-control">
                <p>Data wydania (pozostaw puste jeśli niewydane)</p>
                <datepicker name="version"></datepicker>
            </div>

            <div class="form-control">
                <p>Kolor czcionki (możesz dostosować do swoich potrzeb kolor czcionki używanej w kluczowych miejscach prezentacji modyfikacji, m.in. w nagłówkach):</p>
                <input type="color" id="font_color" name="font_color"
                       value="#000000" />
            </div>

            <!--<div class="form-control">-->
                <!--<p>Studio deweloperskie</p>-->
                <!--<input type="hidden" id="development_studio" name="development_studio" :value="development_studio">-->
                <!--<v-select :v-model="development_studio" :options="development_studios"></v-select>-->
            <!--</div>-->
            <!--// TODO: implement dev studios-->

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
    import routeMixin from '../route-mixin.js';
    import { VueEditor } from 'vue2-editor'
    import Datepicker from 'vuejs-datepicker';
    import Multiselect from 'vue-multiselect'

    export default {
        mixins: [ routeMixin ],
        components: {
            VueEditor,
            vSelect,
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