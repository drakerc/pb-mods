<template>
    <div class="container my-2 col-sm-9 mx-auto">
        <div v-if="loading">
            <p>Wczytywanie...</p>
        </div>
        <div v-else class="col-sm-10 offset-sm-1">
            <b-alert :show="invalid && !! errors" variant="danger">
                <p>Wystąpiły błędy przy przetwarzaniu żądania, proszę sprawdzić, czy wprowadzono poprawne dane.</p>
            </b-alert>
            <b-form @submit.prevent="onSubmit">
                <errors-alert v-if="invalid && !! errors.title" :errors="errors.name"></errors-alert>
                <b-form-group label="Tytuł:" description="Tytuł oferty (kogo poszukujesz?)">
                    <b-form-input v-model="offer.title" class="col-sm-6"></b-form-input>
                </b-form-group>

                <errors-alert v-if="invalid && !! errors.development_studio_id" :errors="errors.development_studio_id"></errors-alert>
                <b-form-group label="Studio:" description="Studio deweloperskie oferujące współpracę">
                    <b-form-select :options="developmentStudios" v-model="offer.developmentStudioId" class="col-sm-6"></b-form-select>
                </b-form-group>

                <errors-alert v-if="invalid && !! errors.email" :errors="errors.email"></errors-alert>
                <b-form-group label="Adres e-mail:" description="Adres, na który mają być przesyłane oferty">
                    <b-form-input type="email" v-model="offer.email" class="col-sm-6"></b-form-input>
                </b-form-group>

                <errors-alert v-if="invalid && !! errors.valid_until" :errors="errors.valid_until"></errors-alert>
                <b-form-group label="Ważne do:" description="Do kiedy dana oferta współpracy jest aktualna">
                    <b-form-input type="date" v-model="offer.validUntil" class="col-sm-6"></b-form-input>
                </b-form-group>

                <errors-alert v-if="invalid && !! errors.body" :errors="errors.body"></errors-alert>
                <b-form-group label="Zawartość:">
                    <vue-editor v-model="offer.body"></vue-editor>
                </b-form-group>
                <b-button type="submit" variant="primary" :disabled="!isValid">Wyślij</b-button>
            </b-form>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import Auth from "../../../auth";
    import {VueEditor} from 'vue2-editor';
    import ErrorsAlert from '../../shared/ErrorsAlert';


    const fetch = (callback) => {
        const id = Auth.getId();
        axios.get(`/api/devstudios/user-studios/${id}`).then((response) => {
            callback(null, response.data.studios)
        }).catch(err => callback(err, err.response.data));
    };


    export default {
        name: "NewJobOfferForm",
        components: {
            VueEditor,
            ErrorsAlert
        },
        props: ['selectedStudio'],
        data() {
            return {
                offer: {
                    title: null,
                    developmentStudioId: null,
                    email: null,
                    body: null,
                    validUntil: null
                },
                developmentStudios: [],
                loading: true,
                invalid: false,
                errors: null
            }
        },
        computed: {
            isValid() {
                return this.offer.title !== null && this.offer.title.length > 3 &&
                    this.offer.developmentStudioId !== null &&
                    this.offer.email !== null && this.offer.email.length > 4 &&
                    this.offer.body !== null && this.offer.body.length > 3 &&
                    this.offer.validUntil !== null;
            }
        },
        beforeRouteEnter(to, from, next) {
            fetch((err, data) => {
                next(vm => vm.setData(err, data));
            });
        },
        methods: {
            setData(err, data) {
                if (err) {
                    console.error(err);
                    this.$router.push({
                        name: 'home'
                    });
                } else {
                    data.forEach(studio => {
                        this.developmentStudios.push({
                            text: studio.name,
                            value: studio.id,
                        });
                    });
                    this.loading = false;
                }
            },
            onSubmit() {
                this.invalid = false;
                this.errors = null;
                this.offer = {};
                axios.post(`/api/job-offer`, {
                    title: this.offer.title,
                    development_studio_id: this.offer.developmentStudioId,
                    email: this.offer.email,
                    body: this.offer.body,
                    valid_until: this.offer.validUntil
                }).then(response => {
                   this.$router.push({
                       name: 'job_offer_details',
                       params: {
                           id: response.data.id
                       }
                   });
                }).catch(err => {
                    console.error(err);
                    this.invalid = true;
                    this.errors = err.response.data.errors;
                });
            }
        }
    }
</script>

<style scoped>

</style>