<template>
    <div class="my-2 col-sm-5 mx-auto">
        <b-form ref="form" @submit.prevent="onSubmit" @reset.prevent="onReset" method="POST" action="/login">
            <input type="hidden" name="_token" :value="csrf_token">

            <b-alert variant="danger" :show="error">
                <p v-if="statusCode === 400 || statusCode === 401">
                    Niepoprawne dane logowania, upewnij się, że adres email oraz hasło są poprawne.
                </p>
                <p v-else-if="statusCode === 500">
                    Nieokreślony błąd po stronie serwera, spróbuj ponownie później
                </p>
            </b-alert>
            <b-form-group
                          label="Email:"
                          label-for="email-input">
                <b-form-input v-model="email"
                              id="email-input"
                              name="email"
                              type="email"
                              required
                              :state="error ? false : null"
                              placeholder="email@example.com">
                </b-form-input>
            </b-form-group>
            <b-form-group label="Hasło:"
                          label-for="password-input">
                <b-form-input id="password-input"
                              name="password"
                              type="password"
                              v-model="password"
                              :state="error ? false: null"
                              required>
                </b-form-input>
            </b-form-group>
            <b-button type="submit" variant="primary">
                <font-awesome-icon icon="key"/>
                Zaloguj się
            </b-button>
            <b-button type="reset" variant="warning">Zresetuj</b-button>
        </b-form>
        <b-col class="my-2">
            <b-row>
                <em>Nie masz konta?</em>
            </b-row>
            <b-row>
                <b-link to="/register"> Kliknij tu</b-link>
                <em>, by się zarejestrować!</em>
            </b-row>
        </b-col>
    </div>
</template>
<script>
    import axios from 'axios';
    import { Auth } from '../auth';

    export default {
        data() {
            return {
                csrf_token: window.window.csrf_token,
                email: '',
                password: '',
                redirect: this.$route.query.redirect? this.$route.query.redirect : null,
                error: false,
                statusCode: 0,
            }
        },
        methods: {
            onSubmit() {
                this.error = false;
                axios.post('/api/auth/login', {
                    email: this.email,
                    password: this.password
                }).then(response => {
                    Auth.login(response.data.access_token, response.data.username, response.data.gravatar);
                    this.$refs.form.submit();
                }).catch(err => {
                    this.error = true;
                    this.statusCode = err.response.status;
                    this.email = '';
                    this.password = '';
                    console.error(err);
                });
            },
            onReset() {
                this.email = '';
                this.password = '';
                this.error = false;
            }
        }
    }
</script>
<style>

</style>