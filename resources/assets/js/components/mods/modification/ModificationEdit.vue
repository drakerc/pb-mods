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

                <div class="mb-3" v-if="studios !== '' && studios.length > 0">
                    <label for="development_studio">Studio deweloperskie</label>
                    <input type="hidden" name="development_studio" :value="development_studio.value">
                    <multiselect id="development_studio" track-by="value" label="label" v-model="development_studio" :options="studios"></multiselect>
                </div>

                <div class="mb-3">
                    <label for="font_color">Kolor czcionki tytułu:</label>
                    <input class="form-control" type="color" id="font_color" name="font_color"
                           v-model="font_color" />
                </div>

                <div class="mb-3">
                    <label for="font_color_splash_text">Kolor czcionki w splashu:</label>
                    <input class="form-control" type="color" id="font_color_splash_text" name="font_color_splash_text"
                           v-model="font_color_splash_text" />
                </div>

                <div class="mb-3">
                    <label for="color_splash_background">Kolor tła splasha:</label>
                    <input class="form-control" type="color" id="color_splash_background" name="color_splash_background"
                           v-model="color_splash_background" />
                </div>

                <div class="mb-3">
                    <label for="transparency_splash_background">Przezroczystość tła splasha:</label>
                    <input class="form-control-range" type="range" min="0.1" max="1.0" step="0.1"
                           id="transparency_splash_background" name="transparency_splash_background"
                           v-model="transparency_splash_background"/>
                </div>

                <div class="mb-3">
                    <label for="font_color_description">Kolor czcionki opisu:</label>
                    <input class="form-control" type="color" id="font_color_description" name="font_color_description"
                           v-model="font_color_description" />
                </div>

                <div class="mb-3">
                    <label for="color_description_background">Kolor tła opisu:</label>
                    <input class="form-control" type="color" id="color_description_background" name="color_description_background"
                           v-model="color_description_background" />
                </div>

                <div class="mb-3">
                    <label for="transparency_description_background">Przezroczystość tła opisu:</label>
                    <input class="form-control-range" type="range" min="0.1" max="1.0" step="0.1"
                           id="transparency_description_background" name="transparency_description_background"
                           v-model="transparency_description_background"/>
                </div>

                <div class="mb-3">
                    <input type="hidden" name="description" :value="description">
                    <label for="description">Opis</label>
                    <vue-editor id="description" v-model="description"></vue-editor>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <b-btn size="lg" variant="warning" v-b-modal.delete-mod>Usuń modyfikację</b-btn>
                    </div>
                    <div class="col-md-4">
                        <ModificationPreviewChanges
                                :mod="mod"
                                :font_color="font_color"
                                :font_color_splash_text="font_color_splash_text"
                                :color_splash_background="color_splash_background"
                                :transparency_splash_background="transparency_splash_background"
                                :font_color_description="font_color_description"
                                :color_description_background="color_description_background"
                                :transparency_description_background="transparency_description_background"
                        ></ModificationPreviewChanges>
                    </div>
                </div>

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
    import ModificationPreviewChanges from './ModificationPreviewChanges';
    import router from "../../../router";

    export default {
        mixins: [ routeMixin ],
        components: {
            VueEditor,
            Datepicker,
            Multiselect,
            ModificationPreviewChanges
        },
        data() {
            return {
                title: '',
                show: false,
                replaces: '',
                version: '',
                font_color: '',
                font_color_splash_text: '',
                color_splash_background: '',
                transparency_splash_background: '',
                font_color_description: '',
                color_description_background: '',
                transparency_description_background: '',
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
                release_date: '',
                development_studio: '',
                studios: '',
            };
        },
        methods: {
            assignData({category, game, auth, mod, studios}) {
                this.category = category;
                this.game = game;
                this.auth = auth;
                this.mod = mod;

                this.studios = studios.map(function (value) {
                    return {
                        label: value.name,
                        value: value.id
                    };
                });

                this.title = mod.title;
                this.replaces = mod.replaces;
                this.version = mod.version;
                this.font_color = mod.font_color;
                this.font_color_splash_text = mod.font_color_splash_text;
                this.color_splash_background = mod.color_splash_background;
                this.transparency_splash_background = mod.transparency_splash_background;
                this.font_color_description = mod.font_color_description;
                this.color_description_background = mod.color_description_background;
                this.transparency_description_background = mod.transparency_description_background;
                this.size = this.size_options.find(obj => {
                    return obj.value === mod.size;
                });
                this.development_status = this.development_status_options.find(obj => {
                    return obj.value === mod.development_status;
                });

                if (mod.devStudio !== null) {
                    this.development_studio = {
                        label: mod.devStudio.name,
                        value: mod.devStudio.id,
                    };
                }

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
