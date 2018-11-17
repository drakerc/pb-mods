<template>
    <div class="container my-2 col-sm-9 mx-auto">
        <!--<b-alert :show="invalid && !! errors" variant="danger">-->
            <!--<p>There are errors, please make sure to review them all.</p>-->
        <!--</b-alert>-->
        <b-col sm="12" class="mx-auto">
            <b-form @submit.prevent="onSubmit">
                <p>Zgłaszasz chęć współpracy ze studiem {{offer.development_studio.name}}</p>

                <!--<errors-alert v-if="invalid && !! errors.logo_file" :errors="errors.logo_file"></errors-alert>-->
                <b-form-group label="Twoja aplikacja:">
                    <b-form-file accept="application/pdf" v-model="file" placeholder="Wybierz plik ze swoją aplikacją (np. CV) w formacie PDF" class="col-sm-6"></b-form-file>
                    <div class="mt-3">Wybrano: {{file && file.name}}</div>
                </b-form-group>

                <b-form-group>
                    <b-form-checkbox id="checkbox"
                                     v-model="agreement">
                        (*) Wyrażam zgodę na przetwarzanie moich danych w celu rekrutacyjnych.
                    </b-form-checkbox>
                </b-form-group>

                <b-button type="submit" variant="primary" :disabled="!file || !agreement">Wyślij</b-button>
            </b-form>
        </b-col>
        <b-modal v-model="submitting" hide-footer hide-header-close centered variant="sm">
            <b-col>
                <p>Please wait...</p>
                <b-progress :value="progressValue" :max="100" animated></b-progress>
            </b-col>
        </b-modal>
    </div>
</template>

<script>
    import axios from 'axios';

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
                progressValue: 0
            }
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
                    this.offer = data;
                    // this.loading = false;
                }
            },
            onSubmit() {
                this.progressValue = 0;
                this.submitting = true;
                const formData = new FormData();
                formData.append('file', this.file);
                this.progressValue = 50;
                axios.post(`/api/job-offer/${this.offer.id}/apply`, formData, {
                    headers: {
                        'Content-type': 'multipart/form-data'
                    }
                }).then(response => {
                    this.progressValue = 100;
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
                this.progressValue = 75;
            }
        }
    }
</script>

<style scoped>

</style>