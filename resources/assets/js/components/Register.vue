<template>
    <div class="my-2 col-sm-5 mx-auto">
        <b-form @submit.prevent="onSubmit" @reset.prevent="onReset">
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
            <b-form-group label="Hasło:"
                          description="Twoje hasło"
                          label-for="password-input">
                <b-form-input id="password-input"
                              type="password"
                              v-model="password"
                              required>
                </b-form-input>
            </b-form-group>
            <b-form-group label="Potwierdź hasło:"
                          description="Potwierdź wpisane wyżej hasło"
                          label-for="confirm-password-input">
                <b-form-input id="confirmpassword-input"
                              type="password"
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
    export default {
        name: "Register",
        data() {
            return {
                email: null,
                username: null,
                password: null,
                passwordConfirm: null
            }
        },
        computed: {
            emailValid() {
                return this.email && this.email.length > 3;
            },
            usernameValid() {
                return this.username && this.username.length > 3;
            },
            passwordValid() {
                return this.password && this.password.length > 3;
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