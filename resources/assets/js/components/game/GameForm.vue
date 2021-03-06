<template>
    <div class="container my-2 col-sm-9 mx-auto">
        <b-alert :show="invalid && !! errors" variant="danger">
            <p>Podczas przetwarzania żądania pojawiły się błędy, upewnij się czy wprowadzono prawidłowe dane.</p>
        </b-alert>
        <b-form @submit.prevent="onSubmit">
            <h3>Utwórz nowy wpis o grze:</h3>
            <errors-alert v-if="invalid && !! errors.title" :errors="errors.title"></errors-alert>
            <b-form-group label="Tytuł:" description="Tytuł twojej gry.">
                <b-form-input v-model="game.title" class="col-sm-6"></b-form-input>
            </b-form-group>

            <errors-alert v-if="invalid && !! errors.game_category_ids" :errors="errors.game_category_ids"></errors-alert>
            <b-form-group label="Gatunek:" description="Gatunki gier, które najdokładniej opisują twój produkt (minimum 1)">
                <b-form-select multiple :options="gameCategories" v-model="game.gameCategoryIds" class="col-sm-6"></b-form-select>
            </b-form-group>

            <errors-alert v-if="invalid && !! errors.development_studios" :errors="errors.development_studios"></errors-alert>
            <b-form-group label="Studia deweloperskie:" description="Grupy, które zajmują się tworzeniem gry (minimum 1)">
                <b-form-select multiple :options="developmentStudios" v-model="game.developmentStudios" class="col-sm-6"></b-form-select>
            </b-form-group>

            <errors-alert v-if="invalid && !! errors.logo_file" :errors="errors.logo_file"></errors-alert>
            <b-form-group label="Logo gry:">
                <b-form-file accept="image/*" v-model="logoFile" placeholder="Wybierz swoje logo gry" class="col-sm-6"></b-form-file>
                <div class="mt-3">Wybrano: {{logoFile && logoFile.name}}</div>
            </b-form-group>

            <errors-alert v-if="invalid && !! errors.background_file" :errors="errors.background_file"></errors-alert>
            <b-form-group label="Tło:" description="Tło, które widoczne będzie w szczegółach gry, oraz na blogu. (Zalecana rozdzielczość: 1920x1080)">
                <b-form-file accept="image/*" v-model="backgroundFile"
                             placeholder="Wybierz swoje tło" class="col-sm-6">
                </b-form-file>
                <div class="mt-3">Wybrano: {{backgroundFile && backgroundFile.name}}</div>
            </b-form-group>

            <errors-alert v-if="invalid && !! errors.variant" :errors="errors.variant"></errors-alert>
            <b-form-group label="Kolor schematu:" description="Predefiniowany kolor komponentów strony">
                <b-row>
                    <b-col>
                        <b-form-select v-model="game.variant" required class="col-sm-4">
                            <option value="default" selected>Default</option>
                            <option value="primary"><div class="text-primary">Primary</div></option>
                            <option value="secondary"><div class="text-secondary">Secondary</div></option>
                            <option value="success"><div class="text-success">Success</div></option>
                            <option value="info"><div class="text-info">Info</div></option>
                            <option value="warning"><div class="text-warning">Warning</div></option>
                            <option value="danger"><div class="text-danger">Danger</div></option>
                            <option value="light"><div class="text-light">Light</div></option>
                            <option value="dark"><div class="text-dark">Dark</div></option>
                        </b-form-select>
                        <b-button :variant="game.variant" class="ml-2">Przykładowy komponent</b-button>
                    </b-col>
                </b-row>
            </b-form-group>

            <errors-alert v-if="invalid && !! errors.description" :errors="errors.description"></errors-alert>
            <b-form-group label="Opis gry:" description="Powiedz światu, dlaczego to właśnie twój tytuł zasługuje na uwagę!">
                <vue-editor v-model="game.description"></vue-editor>
            </b-form-group>
            <b-button type="submit" variant="primary" v-if="isValid">Wyślij</b-button>
        </b-form>
    </div>
</template>

<script>
    import {VueEditor} from 'vue2-editor';
    import ErrorsAlert from '../shared/ErrorsAlert';

    const fetchGameCategories = (callback) => {
        axios.get(`/api/game-categories`).then((response) => {
            axios.get('/api/devstudios/my-studios').then((userStudiosResponse) => {
                callback(null, {
                    categories: response.data,
                    studios: userStudiosResponse.data
                });
            }).catch(err => callback(err, err.response.data));
        }).catch(err => callback(err, err.response.data));
    };

    export default {
        name: "GameForm",
        components: {
            VueEditor,
            ErrorsAlert
        },
        computed: {
            isValid() {
                return this.game.description && this.game.title && this.game.gameCategoryIds.length > 0;
            }
        },
        data() {
            return {
                game: {
                    title: null,
                    description: null,
                    gameCategoryIds: [],
                    variant: null,
                    developmentStudios: []
                },
                logoFile: null,
                backgroundFile: null,
                gameCategories: [],
                invalid: false,
                errors: null,
                developmentStudios: []
            }
        },
        beforeRouteEnter(to, from, next) {
            fetchGameCategories((err, data) => {
                next(vm => vm.setData(err, data));
            });
        },
        methods: {
            setData(err, data) {
                if (err) {
                    console.error(err);
                } else {
                    data.categories.forEach(gameCategory => {
                        this.gameCategories.push({
                            value: gameCategory.id,
                            text: gameCategory.title
                        });
                    });
                    data.studios.forEach(studio => {
                        this.developmentStudios.push({
                            value: studio.id,
                            text: studio.name
                        });
                    });
                }
            },
            onSubmit() {
                this.invalid = false;
                this.errors = null;
                let formData = new FormData();
                formData.append('description', this.game.description);
                formData.append('title', this.game.title);
                formData.append('game_category_ids', this.game.gameCategoryIds);
                formData.append('variant', this.game.variant);
                formData.append('development_studios', this.game.developmentStudios);
                if (this.logoFile) {
                    formData.append('logo_file', this.logoFile);
                }
                if (this.backgroundFile) {
                    formData.append('background_file', this.backgroundFile);
                }
                axios.post(`/api/game`, formData, {
                    headers: {
                        'Content-type': 'multipart/form-data'
                    }
                }).then(response => {
                    this.$router.push({
                        name: 'game_details',
                        params: {
                            id: response.data.id,
                        }
                    });
                }).catch(err => {
                    console.error(err);
                    this.game = {};
                    this.invalid = true;
                    this.errors = err.response.data.errors;
                });
            }
        }
    }
</script>

<style scoped>

</style>