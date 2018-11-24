<template>
    <div class="container my-2 col-sm-9 mx-auto">
        <b-alert :show="invalid && !! errors" variant="danger">
            <p>Wystąpiły błędy przy przetwarzaniu żądania, proszę sprawdzić, czy wprowadzono poprawne dane.</p>
        </b-alert>
        <b-row>
            <b-col>
                <h2>Nowe studio deweloperskie</h2>
                <b-form @submit.prevent="onSubmit">
                    <errors-alert v-if="invalid && !! errors.name" :errors="errors.name"></errors-alert>
                    <b-form-group label="Nazwa:" description="Nazwa twojego studia">
                        <b-form-input required v-model="studio.name" class="col-sm-6"></b-form-input>
                    </b-form-group>

                    <errors-alert v-if="invalid && !! errors.address" :errors="errors.address"></errors-alert>
                    <b-form-group label="Adres:" description="Adres studia">
                        <b-form-input v-model="studio.address" class="col-sm-6"></b-form-input>
                    </b-form-group>

                    <errors-alert v-if="invalid && !! errors.website" :errors="errors.website"></errors-alert>
                    <b-form-group label="Strona internetowa:" description="Adres strony internetowej twojego studia">
                        <b-form-input type="url" required v-model="studio.website" class="col-sm-6"></b-form-input>
                    </b-form-group>

                    <errors-alert v-if="invalid && !! errors.email" :errors="errors.email"></errors-alert>
                    <b-form-group label="Adres email:" description="Adres email twojego studia">
                        <b-form-input type="email" required placeholder="gamedev@example.com" v-model="studio.email" class="col-sm-6"></b-form-input>
                    </b-form-group>

                    <b-form-group label="Studio komercyjne:" description="Czy twoje studio planuje wydawać produkty komercyjne?">
                        <b-form-checkbox v-model="studio.commercial" :value="true" :unchecked-value="false">{{studio.commercial ? 'Komercyjne' : 'Niekomercyjne'}}</b-form-checkbox>
                    </b-form-group>

                    <b-form-group label="Specjalizacja:" description="Specjalizacja studia (modyfikacje, gry, bądź brak)">
                        <b-form-select required v-model="studio.specialization" class="col-sm-6">
                            <option :value="null" disabled>Proszę wybrać jedną z opcji poniżej</option>
                            <option :value="0">Brak specjalizacji</option>
                            <option :value="1">Modyfikacje do gier</option>
                            <option :value="2">Gry</option>
                        </b-form-select>
                    </b-form-group>

                    <errors-alert v-if="invalid && !! errors.description" :errors="errors.description"></errors-alert>
                    <b-form-group label="Opis:" description="Twój opis studia (cel, założenia...)">
                        <vue-editor v-model="studio.description" required></vue-editor>
                    </b-form-group>
                    <b-button type="submit" variant="primary" :disabled="!isValid">Submit</b-button>
                </b-form>
            </b-col>
        </b-row>
    </div>
</template>

<script>
    import {VueEditor} from 'vue2-editor';
    import Auth from "../../auth";
    import axios from "axios";
    import ErrorsAlert from '../shared/ErrorsAlert';

    export default {
        name: "DevelopmentStudioCreateForm",
        components: {
            VueEditor,
            ErrorsAlert
        },
        data() {
            return {
                studio: {
                    name: null,
                    address: null,
                    website: null,
                    email: null,
                    commercial: false,
                    specialization: null,
                    description: null,
                },
                invalid: false,
                errors: null
            }
        },
        computed: {
            isValid() {
                return this.studio.name !== null && this.studio.name.length > 0
                        && this.studio.description !== null && this.studio.description.length > 0
                    && this.studio.specialization !== null && this.studio.commercial !== null;
            }
        },
        methods: {
            onSubmit() {
                this.studio.owner_id = Auth.getId();
                axios.post(`/api/devstudios/create`, this.studio).then(response => {
                    this.$router.push({
                        name: 'dev_studio_details',
                        params: {
                            id: response.data.studio.id
                        }
                    });
                }).catch(err => {
                    this.studio = {
                        name: null,
                        address: null,
                        website: null,
                        email: null,
                        commercial: false,
                        specialization: null,
                        description: null,
                    };
                    this.invalid = true;
                    this.errors = err.response.data.errors;

                })
            }
        }
    }
</script>

<style scoped>

</style>