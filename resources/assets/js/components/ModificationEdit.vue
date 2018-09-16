<template>
    <div>
        <form enctype="multipart/form-data" role="form" method="POST" :action="'/mods/modifications/' + mod.id + '/update'">
            <input type="hidden" name="_token" :value="csrf_token">
            <input type="hidden" name="categoryid" :value="category ? category.id : null">
            <input type="hidden" name="gameid" :value="game.id">
            <input name="_method" type="hidden" value="PUT">

            <h3>Zmieniasz modyfikację {{ mod.title }} do gry {{ game.title }}</h3>
            <h4 v-if="category">Kategoria: {{ category.title }}</h4>

            <div class="form-control">
                <input id="title" type="text" name="title" :value="mod.title"
                       placeholder="Tytuł" required autofocus>
            </div>

            <div class="form-control">
                <p>Wielkość modyfikacji</p>
                <input type="hidden" id="size" name="size" :value="size.value">
                <multiselect track-by="value" label="label" v-model="size" :options="size_options"></multiselect>
            </div>

            <div class="form-control">
                <p>Status produkcji</p>
                <input type="hidden" id="development_status" name="development_status" :value="development_status.value">
                <multiselect track-by="value" label="label" v-model="development_status" :options="development_status_options"></multiselect>
            </div>

            <div class="form-control">
                <p>Zamienia (co podmienia modyfikacja - np. nazwa samochodu, broni; w przypadku większych modyfikacji pozostaw to pole pustym):</p>
                <input id="replaces" type="text" name="replaces" :value="mod.replaces">
            </div>

            <div class="form-control">
                <input id="version" type="number" name="version" placeholder="Wersja modyfikacji (pozostaw puste jeśli niewydane)" :value="mod.version">
            </div>

            <div class="form-control">
                <p>Data wydania (pozostaw puste jeśli niewydane)</p>
                <datepicker :value="release_date" name="release_date"></datepicker>
            </div>

            <div class="form-control">
                <p>Kolor czcionki (możesz dostosować do swoich potrzeb kolor czcionki używanej w kluczowych miejscach prezentacji modyfikacji, m.in. w nagłówkach):</p>
                <input type="color" id="font_color" name="font_color" :value="mod.font_color"/>
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
            Datepicker,
            Multiselect
        },
        data() {
            return {
                category: [],
                game: '',
                mod: '',
                auth: '',
                description: '',
                size: '',
                size_options: [{label: 'Niewielka, pojedyńcza modyfikacja', value: 0}, {label: 'Średniej wielkości modyfikacja', value: 1}, {label: 'Duża, kompletna modyfikacja', value: 2}],
                development_status: '',
                development_status_options: [{label: 'Nierozpoczęty', value: 0}, {label: 'W trakcie tworzenia', value: 1}, {label: 'W trakcie testów', value: 2}, {label: 'Wydany', value: 3}, {label: 'Wstrzymany', value: 4}],
                csrf_token: window.window.csrf_token,
                release_date: ''
            };
        },
        methods: {
            assignData({category, game, auth, mod}) {
                this.category = category;
                this.game = game;
                this.auth = auth;
                this.mod = mod;

                this.size = this.size_options.find(obj => {
                    return obj.value === mod.size;
                });
                this.development_status = this.development_status_options.find(obj => {
                    return obj.value === mod.development_status;
                });
                this.description = mod.description;
                this.release_date = mod.release_date === '' ? new Date() : new Date(mod.release_date) // TODO: make sure it works
            },
        },
    }
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
