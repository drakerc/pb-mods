<template>
    <div class="container my-2 col-sm-9 mx-auto">

        <b-col sm="12" class="mx-auto">
            <b-form @submit.prevent="onSubmit">
                <p>Zgłaszasz chęć współpracy ze studiem {{offer.development_studio.name}}</p>

                <!--<errors-alert v-if="invalid && !! errors.logo_file" :errors="errors.logo_file"></errors-alert>-->
                <b-form-group label="Twoja aplikacja:" description="Wybierz plik ze swoją aplikacją (np. CV) w formacie PDF">
                    <b-form-file accept="application/pdf" v-model="file" class="col-sm-7"></b-form-file>
                    <div class="mt-3" v-if="file">Wybrano: {{file && file.name}}</div>

                </b-form-group>


                <b-form-group>
                    <b-form-checkbox id="checkbox"
                                     v-model="agreement">
                        (*) Wyrażam zgodę na przetwarzanie moich danych w celach rekrutacyjnych.
                    </b-form-checkbox>
                </b-form-group>

                <b-button type="submit" variant="primary" :disabled="!file || !agreement">Wyślij</b-button>
            </b-form>
        </b-col>
        <b-modal v-model="submitting" hide-footer hide-header centered variant="sm">
            <div class="loading-bar">
                <loading :active.sync="submitting" :can-cancel="false" :is-full-page="false" loader="dots"></loading>
            </div>
        </b-modal>
    </div>
</template>

<script>
    import axios from 'axios';
    import Auth from '../../../auth';
    import Loading from 'vue-loading-overlay';
    import 'vue-loading-overlay/dist/vue-loading.css';

    const fetch = (id, callback) => {
        axios.get(`/api/job-offer/${id}`).then((response) => {
            callback(null, response.data);
        }).catch(error => callback(error, error.response.data));
    };
    export default {
        name: "JobOfferForm",
        data() {
            return {
                offer: {
                    development_studio:{}
                },
                file: null,
                agreement: false,
                submitting: false,
            }
        },
        components: {
            Loading
        },
        beforeRouteEnter(to, from, next) {
            fetch(to.params.id, (err, data) => {
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
                    Auth.isMember(data.development_studio.id).then(isMember => {
                        if (isMember) {
                            this.$router.push({
                                name: 'job_offer_details',
                                params: {
                                    id: this.$route.params.id,
                                    error: 'Nie możesz złożyć prośby, jeśli już jesteś członkiem tego zespołu!'
                                }
                            });
                        } else {
                            this.offer = data;
                        }
                    });

                }
            },
            onSubmit() {
                this.submitting = true;
                const formData = new FormData();
                formData.append('file', this.file);
                axios.post(`/api/job-offer/${this.offer.id}/apply`, formData, {
                    headers: {
                        'Content-type': 'multipart/form-data'
                    }
                }).then(response => {
                    this.$router.push({
                        name: 'job_offer_details',
                        params: {
                            id: this.offer.id,
                            emailSent: true
                        }
                    })
                }).catch(err => {
                    console.error(err);
                    this.submitting = false;
                });
            }
        }
    }
</script>

<style scoped>
    .loading-bar {
        display: block;
        height: 80px;
    }
</style>