<template>
    <div class="my-2 col-sm-5 mx-auto">
        <b-form ref="form" @submit.prevent="onSubmit" @reset.prevent="onReset" method="POST" action="/login">
            <input type="hidden" name="_token" :value="csrf_token">

            <b-form-group
                          label="Email:"
                          label-for="email-input">
                <b-form-input v-model="email"
                              id="email-input"
                              name="email"
                              type="email"
                              required
                              placeholder="email@example.com">
                </b-form-input>
            </b-form-group>
            <b-form-group label="Password:"
                          label-for="password-input">
                <b-form-input id="password-input"
                              name="password"
                              type="password"
                              v-model="password"
                              required>
                </b-form-input>
            </b-form-group>
            <b-button type="submit" variant="primary">Submit</b-button>
            <b-button type="reset" variant="warning">Reset</b-button>
        </b-form>
        <div class="my-1">
            <b-row>
                <em>Nie masz konta?</em>
            </b-row>
            <b-row>
                <b-link to="/register"> Kliknij tu</b-link>
                <em>, by się zarejstrować!</em>
            </b-row>
        </div>
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
                redirect: this.$route.query.redirect? this.$route.query.redirect : null
            }
        },
        methods: {
            onSubmit() {
                axios.post('/api/auth/login', {
                    email: this.email,
                    password: this.password
                }).then(response => {
                    Auth.login(response.data.access_token, response.data.username, response.data.gravatar);
                    this.$refs.form.submit();
                }).catch(err => {
                    console.error(err)
                });
            },
            onReset() {
                this.email = '';
                this.password = '';
            }
        }
    }
</script>
<style>
    #login form {
        padding-top: 40px;
    }

    @media (min-width: 744px) {
        #login form {
            padding-top: 80px;
        }
    }

    #login .form-control {
        margin-bottom: 1em;
    }

    #login input[type=email],
    #login input[type=password],
    #login button,
    #login label {
        width: 100%;
        font-size: 19px !important;
        line-height: 24px;
        color: #484848;
        font-weight: 300;
        -webkit-appearance: none;
    }

    #login input {
        background-color: transparent;
        padding: 11px;
        border: 1px solid #dbdbdb;
        border-radius: 2px;
        box-sizing:border-box
    }

    #login button {
        background-color: #4fc08d;
        color: #ffffff;
        cursor: pointer;
        border: #4fc08d;
        border-radius: 4px;
        padding-top: 12px;
        padding-bottom: 12px;
    }
</style>