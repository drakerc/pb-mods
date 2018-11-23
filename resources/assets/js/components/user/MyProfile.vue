<template>
    <div class="container col-sm-9 mx-auto">
        <b-alert show v-if="updated" variant="success">
            Profil zmodyfikowano pomyślnie!
        </b-alert>
        <b-jumbotron class="col-sm-6 mx-auto" header-level="5">
            <template slot="header">
                <b-row>
                    <div class="mx-auto">
                        <b-img :src="`${user.gravatar}&s=100`"></b-img>
                    </div>
                </b-row>
                <b-row>
                    <div class="mx-auto">
                        {{user.name}}
                    </div>
                </b-row>
            </template>
        </b-jumbotron>
        <b-card class="col-sm-9 mx-auto">
            <b-col offset-sm="1">
                <b-col>
                    Informacje o twoim koncie:
                </b-col>
                <div class="my-2 col-sm-11">
                    <b-button @click="switchEditMode" :disabled="editPasswordMode">{{!editMode ? 'Edytuj profil' : 'Anuluj'}}</b-button>
                    <b-button @click="switchEditPasswordMode" :disabled="editMode">{{!editPasswordMode ? 'Zmień hasło' : 'Anuluj'}}</b-button>
                    <b-alert show v-if="!!errors" variant="danger" class="my-2">
                        Niepoprawnie wprowadzone dane, upewnij się, że są one prawidłowe.
                    </b-alert>
                    <b-form @submit.prevent="onSubmit" @reset.prevent="onReset">
                        <b-form-group
                                label="Email:"
                                description="Twój adres email"
                                label-for="email-input">
                            <b-form-input v-model="user.email"
                                          id="email-input"
                                          type="email"
                                          disabled
                                          placeholder="email@example.com">
                            </b-form-input>
                        </b-form-group>
                        <errors-alert v-if="!!errors && errors.name" :errors="errors.name"></errors-alert>
                        <b-form-group
                                label="Nazwa użytkownika:"
                                description="Twoja nazwa użytkownika"
                                label-for="username-input">
                            <b-form-input v-model="form.name"
                                          id="username-input"
                                          required
                                          :disabled="!editMode"
                                          placeholder="Nickname">
                            </b-form-input>
                        </b-form-group>
                        <errors-alert v-if="!!errors && errors.password" :errors="errors.password"></errors-alert>
                        <b-form-group
                                      v-if="editMode"
                                      label="Hasło:"
                                      description="Potwierdź zmianę nazwy użytkownika swoim hasłem:"
                                      label-for="password-input">
                            <b-form-input id="password-input"
                                          type="password"
                                          :disabled="!editMode"
                                          v-model="form.password"
                                          required>
                            </b-form-input>
                        </b-form-group>
                        <b-button type="submit" variant="primary"
                                  v-if="editMode"
                                  :disabled="!usernameValid || !passwordValid"
                        >Submit</b-button>
                        <b-button type="reset" v-if="editMode" :disabled="!editMode" variant="warning">Reset</b-button>
                    </b-form>
                    <b-form @submit.prevent="onChangePasswordSubmit" @reset.prevent="onReset" v-if="editPasswordMode">
                        <errors-alert v-if="!! errors && errors.old_password" :errors="errors.old_password"></errors-alert>
                        <b-form-group
                                label="Stare hasło:"
                                description="Twoje dotychczasowe hasło:"
                                label-for="old-password-input">
                            <b-form-input id="old-password-input"
                                          type="password"
                                          v-model="passwordForm.oldPassword"
                                          required>
                            </b-form-input>
                        </b-form-group>
                        <errors-alert v-if="!! errors && errors.password" :errors="errors.password"></errors-alert>
                        <b-form-group
                                label="Nowe hasło:"
                                description="Twoje nowe hasło:"
                                label-for="edit-password-input">
                            <b-form-input id="edit-password-input"
                                          type="password"
                                          v-model="passwordForm.password"
                                          required>
                            </b-form-input>
                        </b-form-group>
                        <errors-alert v-if="!! errors && errors.password_confirmation" :errors="errors.password_confirmation"></errors-alert>
                        <b-form-group label="Potwierdź hasło:"
                                      description="Potwierdź wpisane wyżej hasło"
                                      label-for="edit-password-confirm-input">
                            <b-form-input id="edit-password-confirm-input"
                                          type="password"
                                          v-model="passwordForm.passwordConfirmation"
                                          required>
                            </b-form-input>
                        </b-form-group>
                        <b-button type="submit" variant="primary"
                                  :disabled="!changePasswordFormValid"
                        >Submit</b-button>
                        <b-button type="reset" variant="warning">Reset</b-button>
                    </b-form>
                </div>
            </b-col>
        </b-card>
    </div>
</template>

<script>
    import axios from 'axios';
    import Auth from '../../auth';
    import ErrorsAlert from '../shared/ErrorsAlert';

    const fetch = (callback) => {
        axios.get(`/api/auth/user/`).then((response) => {
            callback(null, response.data);
        }).catch(error => callback(error, error.response.data));
    };

    export default {
        name: "MyProfile",
        data() {
            return {
                user: {},
                form: {},
                passwordForm: {},
                editMode: false,
                updated: false,
                editPasswordMode: false,
                errors: null
            }
        },
        components: {
            ErrorsAlert
        },
        beforeRouteEnter(to, from, next) {
            fetch((err, data) => {
                next(vm => vm.setData(err, data));
            });
        },
        computed: {
            usernameValid() {
                return this.form.name && this.form.name.length > 5;
            },
            passwordValid() {
                return this.form.password && this.form.password.length > 5;
            },
            changePasswordFormValid() {
                return this.editOldPasswordValid && this.editPasswordValid && this.editPasswordConfirmationValid;
            },
            editOldPasswordValid() {
                return this.passwordForm.oldPassword && this.passwordForm.oldPassword.length > 3;
            },
            editPasswordValid() {
                return this.passwordForm.password && this.passwordForm.password.length > 5;
            },
            editPasswordConfirmationValid() {
                return this.passwordForm.passwordConfirmation && this.passwordForm.passwordConfirmation === this.passwordForm.password;
            }
        },
        methods: {
            setData(err, data) {
                if (err) {
                    console.error(err);
                } else {
                    this.user = data;
                    this.form = {
                        name: data.name
                    };
                }
            },
            switchEditMode() {
                this.editPasswordMode = false;
                if (this.editMode) {
                    this.form = {
                        name: this.user.name
                    }
                }
                this.editMode = !this.editMode;
            },
            switchEditPasswordMode() {
                this.editMode = false;
                if (this.editPasswordMode) {
                    this.passwordForm = {};
                }
                this.editPasswordMode = !this.editPasswordMode;
            },
            onSubmit() {
                this.errors = null;
                this.updated = false;
                axios.post('/api/auth/update-user-data', {
                    name: this.form.name,
                    password: this.form.password
                }).then(response => {
                    this.editMode = false;
                    Auth.updateUser(this.form.name);
                    this.user.name = Auth.getUser();
                    this.form = {
                        name: this.user.name
                    };
                    this.updated = true;
                    window.scrollTo(0,0);
                }).catch(err => {
                    console.error(err);
                    this.form = {
                        name: this.user.name
                    };
                    this.errors = err.response.data.errors ? err.response.data.errors : true;
                });
            },
            onChangePasswordSubmit() {
                this.errors = null;
                this.updated = false;
                axios.post('/api/auth/update-user-password', {
                    old_password: this.passwordForm.oldPassword,
                    password: this.passwordForm.password,
                    password_confirmation: this.passwordForm.passwordConfirmation,
                }).then(response => {
                    this.editPasswordMode = false;
                    this.passwordForm = {};
                    this.updated = true;
                    window.scrollTo(0,0);
                }).catch(err => {
                    console.error(err);
                    this.passwordForm = {};
                    this.errors = err.response.data.errors ? err.response.data.errors : true;
                });
            },
            onReset() {
                this.updated = false;
                this.form = {
                    name: this.user.name
                };
                this.passwordForm = {};
            }
        }
    }
</script>

<style scoped>

</style>