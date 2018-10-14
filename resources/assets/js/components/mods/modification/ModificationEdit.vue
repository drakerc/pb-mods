<template>
    <div class="container">
        <b-modal v-model="show" id="delete-mod" title="Usuwanie modyfikacji">
            <p class="my-4">Czy jesteś pewien, że chcesz usunąć modyfikację i wszystkie powiązane z nią pliki oraz obrazki? Jest to proces nieodwracalny!</p>
            <div slot="modal-footer" class="w-100">
                <b-btn size="sm" class="float-right" variant="secondary" @click="show=false">
                    Anuluj
                </b-btn>
                <b-btn size="sm" class="float-right" variant="primary" @click="deleteModification">
                    Usuń
                </b-btn>
            </div>
        </b-modal>

        <form enctype="multipart/form-data" role="form" method="POST" :action="'/mods/modifications/' + mod.id + '/update'">
            <div class="col-md-12">
                <input type="hidden" name="_token" :value="csrf_token">
                <input type="hidden" name="categoryid" :value="category ? category.id : null">
                <input type="hidden" name="gameid" :value="game.id">
                <input name="_method" type="hidden" value="PUT">

                <h3>Zmieniasz modyfikację {{ mod.title }} do gry {{ game.title }}</h3>
                <h4 v-if="category">Kategoria: {{ category.title }}</h4>

                <div class="mb-3">
                    <label for="title">Tytuł</label>
                    <input id="title" type="text" name="title" class="form-control" v-model="title"
                           placeholder="Tytuł" required autofocus>
                </div>

                <div class="mb-3">
                    <input type="hidden" name="size" :value="size.value">
                    <label for="size">Wielkość modyfikacji</label>
                    <multiselect id="size" track-by="value" label="label" v-model="size" :options="size_options"></multiselect>
                </div>

                <div class="mb-3">
                    <input type="hidden" name="development_status" :value="development_status.value">
                    <label for="development_status">Status produkcji</label>
                    <multiselect id="development_status" track-by="value" label="label" v-model="development_status" :options="development_status_options"></multiselect>
                </div>

                <div class="mb-3">
                    <label for="replaces">Zamienia (co podmienia modyfikacja - np. nazwa samochodu, broni; w przypadku większych modyfikacji pozostaw to pole pustym):</label>
                    <input class="form-control" id="replaces" type="text" name="replaces" v-model="replaces">
                </div>

                <div class="mb-3">
                    <label for="version">Wersja modyfikacji (pozostaw puste jeśli niewydane)</label>
                    <input class="form-control" id="version" type="text" name="version" placeholder="Wersja modyfikacji (pozostaw puste jeśli niewydane)" v-model="version">
                </div>

                <div class="mb-3">
                    <label for="release_date">Data wydania (pozostaw puste jeśli niewydane)</label>
                    <datepicker v-model="release_date" format="dd-MM-yyyy" id="release_date" name="release_date"></datepicker>
                </div>

                <div class="mb-3">
                    <label for="font_color">Kolor czcionki (możesz dostosować do swoich potrzeb kolor czcionki używanej w kluczowych miejscach prezentacji modyfikacji, m.in. w nagłówkach):</label>
                    <input class="form-control" type="color" id="font_color" name="font_color"
                           v-model="font_color" />
                </div>

                <div class="mb-3">
                    <input type="hidden" name="description" :value="description">
                    <label for="description">Opis</label>
                    <vue-editor id="description" v-model="description"></vue-editor>
                </div>

                <!--<div class="form-control">-->
                <!--<p>Studio deweloperskie</p>-->
                <!--<input type="hidden" id="development_studio" name="development_studio" :value="development_studio">-->
                <!--<v-select :v-model="development_studio" :options="development_studios"></v-select>-->
                <!--</div>-->
                <!--// TODO: implement dev studios-->

                <b-btn size="sm" variant="warning" v-b-modal.delete-mod>Usuń modyfikację</b-btn>

                <b-button size="lg" variant="primary" block=true type="submit">
                    Zapisz zmiany
                </b-button>
            </div>
        </form>
    </div>
</template>
<script>
    import routeMixin from '../../../route-mixin.js';
    import { VueEditor } from 'vue2-editor'
    import Datepicker from 'vuejs-datepicker';
    import Multiselect from 'vue-multiselect'
    import router from "../../../router";

    export default {
        mixins: [ routeMixin ],
        components: {
            VueEditor,
            Datepicker,
            Multiselect
        },
        data() {
            return {
                title: '',
                show: false,
                replaces: '',
                version: '',
                font_color: '',
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

                this.title = mod.title;
                this.replaces = mod.replaces;
                this.version = mod.version;
                this.font_color = mod.font_color;
                this.size = this.size_options.find(obj => {
                    return obj.value === mod.size;
                });
                this.development_status = this.development_status_options.find(obj => {
                    return obj.value === mod.development_status;
                });
                this.description = mod.description;
                this.release_date = mod.release_date === '' ? new Date() : new Date(mod.release_date);
            },
            deleteModification: function () {
                axios.delete('/api/mods/modifications/' + this.mod.id + '/delete').then(response => {
                    if (response.data.status === true) {
                        router.push({ name: 'mods_category', params: { game: this.game.id, category: this.category.id} })
                    } else {
                        alert('Nie udało się usunąć modyfikacji. Może nie masz uprawnień?')
                    }
                });
            }
        },
    }
</script>
