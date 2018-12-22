<template>
    <div class="my-2 col-sm-5 mx-auto">
        <b-alert :show="invalid && !! errors" variant="danger">
            <p>Wystąpił błąd przy rejestracji, upewnij się, że wszystkie dane zostały wprowadzone prawidłowo.</p>
        </b-alert>
        <b-form @submit.prevent="onSubmit" @reset.prevent="onReset">
            <errors-alert v-if="invalid && !! errors.email" :errors="errors.email"></errors-alert>
            <b-form-group
                    label="Email:"
                    description="Twój adres email (musi być unikalny)"
                    label-for="email-input">
                <b-form-input v-model="email"
                              id="email-input"
                              type="email"
                              required
                              placeholder="email@example.com">
                </b-form-input>
            </b-form-group>
            <errors-alert v-if="invalid && !! errors.name" :errors="errors.name"></errors-alert>
            <b-form-group
                    label="Nazwa użytkownika:"
                    description="Twoja nazwa użytkownika"
                    label-for="username-input">
                <b-form-input v-model="username"
                              id="username-input"
                              required
                              placeholder="Nickname">
                </b-form-input>
            </b-form-group>

            <errors-alert v-if="invalid && !! errors.password" :errors="errors.password"></errors-alert>
            <b-form-group label="Hasło:"
                          description="Twoje hasło"
                          label-for="password-input">
                <b-form-input id="password-input"
                              type="password"
                              v-model="password"
                              required>
                </b-form-input>
            </b-form-group>
            <errors-alert v-if="invalid && !! errors.password_confirmation" :errors="errors.password_confirmation"></errors-alert>
            <b-form-group label="Potwierdź hasło:"
                          description="Potwierdź wpisane wyżej hasło"
                          :state="passwordConfirmValid"
                          invalid-feedback="Hasła nie zgadzają się"
                          label-for="confirm-password-input">
                <b-form-input id="confirmpassword-input"
                              type="password"
                              :state="passwordConfirmValid ? null : false"
                              v-model="passwordConfirm"
                              required>
                </b-form-input>
            </b-form-group>
            <b-button type="submit" variant="primary"
                      :disabled="!emailValid || !usernameValid || !passwordValid || !passwordConfirmValid"
                     >Submit</b-button>
            <b-button type="reset" variant="warning">Reset</b-button>
        </b-form>
    </div>
</template>

<script>
    import axios from 'axios';
    import ErrorsAlert from './shared/ErrorsAlert';

    export default {
        name: "Register",
        data() {
            return {
                email: null,
                username: null,
                password: null,
                passwordConfirm: null,
                invalid: false,
                errors: null
            }
        },
        components: {
          ErrorsAlert
        },
        computed: {
            emailValid() {
                return this.email && this.email.length > 4;
            },
            usernameValid() {
                return this.username && this.username.length > 5;
            },
            passwordValid() {
                return this.password && this.password.length > 5;
            },
            passwordConfirmValid() {
                return this.passwordConfirm && this.passwordConfirm === this.password;
            }
        },
        methods: {
            onSubmit() {
                axios.post('/api/auth/signup', {
                    email: this.email,
                    password: this.password,
                    name: this.username,
                    password_confirmation: this.passwordConfirm
                }).then(() => {
                    this.$router.push({name: 'login'});
                }).catch(err => {
                    console.error(err);
                    this.invalid = true;
                    this.errors = err.response.data.errors;
                    console.log(this.errors);
                });
            },
            onReset() {
                this.email = '';
                this.password = '';
                this.username = '';
                this.passwordConfirm = '';
            }
        }
    }
</script>

<style scoped>

</style>