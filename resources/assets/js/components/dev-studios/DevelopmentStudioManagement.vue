<template>
    <div class="container my-2 col-sm-9 mx-auto vld-parent">
        <template v-if="studio">
            <b-jumbotron header-level="5" header-tag="h1">
                <template slot="header">
                    <p class="text-center">Zarządzanie studiem {{studio.name}}</p>
                </template>
            </b-jumbotron>
            <b-alert :show="memberDeleted" variant="primary" dismissible @dismissed="memberDeleted = false">
                Usunięto pomyślnie członka grupy.
            </b-alert>
            <b-alert dismissible :show="error" @dismissed="error = false" variant="danger">
                Błąd podczas wykonywania operacji modyfikacji listy członków grupy, spróbuj ponownie później.
            </b-alert>
            <b-alert :show="memberAdded" variant="primary" dismissible @dismissed="memberAdded = false">
                Dodano pomyślnie nowego członka grupy.
            </b-alert>
            <b-alert :show="studioEdited" variant="primary" dismissible @dismissed="studioEdited = false">
                Pomyślnie zmodyfikowano studio.
            </b-alert>

            <b-card class="my-2">
                <p>Członkowie:</p>
                <b-list-group class="col-sm-4">
                    <b-list-group-item v-for="member in studio.users" :key="member.id">
                        <b-row>
                            <span class="lead mx-1">{{member.name}}</span>
                            <b-btn v-if="Auth.getId() !== member.id" class="ml-auto my-1" variant="danger" @click="selectMemberToDelete(member)">
                                Usuń
                            </b-btn>
                            <span v-else class="ml-1 lead">(Ty)</span>
                        </b-row>
                    </b-list-group-item>
                </b-list-group>
                <br>
                <template>
                    <b-alert :show="!!selectedMemberToAdd && Auth.getId() === selectedMemberToAdd.value" variant="warning">
                        Nie możesz dodać samego siebie do zespołu!
                    </b-alert>
                    <b-form-group label="Dodaj nowego członka do zespołu:">
                        <b-row>
                            <b-col sm="5">
                                <vue-select @search="onSearch" :options="memberOptions" v-model="selectedMemberToAdd"></vue-select>
                            </b-col>
                            <b-col>
                                <b-btn variant="success my-1 ml-5" @click="onMemberAdd"
                                       v-if="selectedMemberToAdd !== null && Auth.getId() !== selectedMemberToAdd.value"
                                >
                                    Dodaj
                                </b-btn>
                            </b-col>
                        </b-row>
                    </b-form-group>
                </template>
            </b-card>

            <b-card class="my-2">
                <b-link v-if="!editStudio" @click="editStudio = true">
                    <font-awesome-icon icon="angle-down"/>
                    Edytuj studio
                </b-link>
                <template v-else>
                    <b-link @click="editStudio = false">
                        <font-awesome-icon icon="angle-up"/>
                        Anuluj edycję
                    </b-link>
                    <b-form @submit.prevent="onEditStudioSubmit" class="my-2">
                        <errors-alert v-if="invalid && !! errors.name" :errors="errors.name"></errors-alert>
                        <b-form-group label="Nazwa:" description="Nazwa twojego studia">
                            <b-form-input required v-model="studioFromForm.name" class="col-sm-6"></b-form-input>
                        </b-form-group>

                        <errors-alert v-if="invalid && !! errors.address" :errors="errors.address"></errors-alert>
                        <b-form-group label="Adres:" description="Adres studia">
                            <b-form-input v-model="studioFromForm.address" class="col-sm-6"></b-form-input>
                        </b-form-group>

                        <errors-alert v-if="invalid && !! errors.website" :errors="errors.website"></errors-alert>
                        <b-form-group label="Strona internetowa:" description="Adres strony internetowej twojego studia">
                            <b-form-input type="url" required v-model="studioFromForm.website" class="col-sm-6"></b-form-input>
                        </b-form-group>

                        <errors-alert v-if="invalid && !! errors.email" :errors="errors.email"></errors-alert>
                        <b-form-group label="Adres email:" description="Adres email twojego studia">
                            <b-form-input type="email" required placeholder="gamedev@example.com" v-model="studioFromForm.email" class="col-sm-6"></b-form-input>
                        </b-form-group>

                        <b-form-group label="Studio komercyjne:" description="Czy twoje studio planuje wydawać produkty komercyjne?">
                            <b-form-checkbox v-model="studioFromForm.commercial" :value="true" :unchecked-value="false">{{studioFromForm.commercial ? 'Komercyjne' : 'Niekomercyjne'}}</b-form-checkbox>
                        </b-form-group>

                        <b-form-group label="Specjalizacja:" description="Specjalizacja studia (modyfikacje, gry, bądź brak)">
                            <b-form-select required v-model="studioFromForm.specialization" class="col-sm-6">
                                <option :value="null" disabled>Proszę wybrać jedną z opcji poniżej</option>
                                <option :value="0">Brak specjalizacji</option>
                                <option :value="1">Modyfikacje do gier</option>
                                <option :value="2">Gry</option>
                            </b-form-select>
                        </b-form-group>

                        <errors-alert v-if="invalid && !! errors.description" :errors="errors.description"></errors-alert>
                        <b-form-group label="Opis:" description="Twój opis studia (cel, założenia...)">
                            <vue-editor v-model="studioFromForm.description" required></vue-editor>
                        </b-form-group>
                        <b-button type="submit" variant="primary" :disabled="!isValid">Wyślij</b-button>
                    </b-form>
                </template>
            </b-card>

            <b-card class="my-2">
                <p>Usuń studio:</p>
                <b-btn variant="danger" @click="showModal = true">Usuń</b-btn>
            </b-card>
            <b-modal v-if="selectedMemberToDelete" v-model="showMemberModal" hide-header centered variant="sm">
                <p>Czy na pewno chcesz usunąć członka {{selectedMemberToDelete.name}} z grupy {{studio.name}}? tej
                    operacji nie można cofnąć!</p>
                <template slot="modal-footer">
                    <b-col>
                        <b-row>
                            <b-btn @click="onCancelMemberModal" variant="warning" class="mr-auto">Anuluj</b-btn>
                            <b-btn @click="onMemberDelete()" variant="danger" class="ml-auto">Potwierdź</b-btn>
                        </b-row>
                    </b-col>
                </template>
            </b-modal>

            <b-modal v-model="showModal" hide-header centered variant="sm">
                <p>Czy na pewno chcesz usunąć studio {{studio.name}}? tej operacji nie można cofnąć!</p>
                <template slot="modal-footer">
                    <b-col>
                        <b-row>
                            <b-btn @click="showModal=false" variant="warning" class="mr-auto">Anuluj</b-btn>
                            <b-btn @click="onStudioDelete()" variant="danger" class="ml-auto">Potwierdź</b-btn>
                        </b-row>
                    </b-col>
                </template>
            </b-modal>
        </template>
        <loading :active.sync="submitting" :can-cancel="false" :is-full-page="false"></loading>
    </div>
</template>

<script>
    import axios from 'axios';
    import Auth from '../../auth';
    import Loading from 'vue-loading-overlay';
    import VueSelect from 'vue-select';
    import ErrorsAlert from '../shared/ErrorsAlert';
    import {VueEditor} from 'vue2-editor';
    import 'vue-loading-overlay/dist/vue-loading.css';

    const fetch = (id, callback) => {
        axios.get(`/api/devstudios/find/${id}`).then((response) => {
            callback(null, response.data);
        }).catch(error => callback(error, error.response.data));
    };

    export default {
        name: "DevelopmentStudioManagement",
        data() {
            return {
                studio: null,
                showModal: false,
                submitting: false,
                Auth,
                selectedMemberToDelete: null,
                showMemberModal: false,
                memberDeleted: false,
                error: false,
                memberOptions: [],
                selectedMemberToAdd: null,
                memberAdded: false,
                studioFromForm: {},
                invalid: false,
                errors: null,
                editStudio: false,
                studioEdited: false
            }
        },
        components: {
            Loading,
            VueSelect,
            ErrorsAlert,
            VueEditor
        },
        watch: {
            editStudio(value) {
                if (value === true) {
                    this.studioFromForm = {...this.studio};
                } else {
                    this.studioFromForm = {};
                }
            }
        },
        computed: {
            isValid() {
                return this.studioFromForm.name !== null && this.studioFromForm.name.length > 0
                    && this.studioFromForm.description !== null && this.studioFromForm.description.length > 0
                    && this.studioFromForm.specialization !== null && this.studioFromForm.commercial !== null;
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
                    this.studio = data;
                }
            },
            onStudioDelete() {
                this.showModal = false;
                this.submitting = true;
                axios.delete(`/api/devstudios/${this.studio.id}/delete`).then(() => {
                    this.$router.push({
                        name: 'dev_studios_index',
                        params: {
                            deleted: true
                        }
                    });
                }).catch(err => {
                    console.error(err);
                    this.submitting = false;
                });
            },
            selectMemberToDelete(member) {
                this.selectedMemberToDelete = member;
                this.showMemberModal = true;
            },
            onCancelMemberModal() {
                this.selectedMemberToDelete = null;
                this.showMemberModal = false;
            },
            onMemberDelete() {
                if (this.selectedMemberToDelete !== null) {
                    this.showMemberModal = false;
                    this.submitting = true;
                    axios.delete(`/api/devstudios/${this.studio.id}/members/delete`, {
                        params: {
                            user_id: this.selectedMemberToDelete.id
                        }
                    }).then(response => {
                        this.studio.users = response.data;
                        this.memberDeleted = true;
                        this.submitting = false;
                    }).catch(err => {
                        this.error = true;
                        this.memberDeleted = false;
                        this.submitting = false;
                        console.error(err);
                    });
                    this.selectedMemberToDelete = null;
                }
            },
            onSearch(search, loading) {
                loading(true);
                axios.get(`/api/users/find`, {
                    params: {
                        name: search
                    }
                }).then(response => {
                    this.memberOptions = response.data.map(user => {
                        return {
                            label: user.name,
                            value: user.id
                        }
                    });
                    loading(false);
                }).catch(err => {
                    console.error(err);
                    loading(false);
                });
            },
            onMemberAdd() {
                if (this.selectedMemberToAdd) {
                    this.submitting = true;
                    this.memberAdded = false;
                    axios.post(`/api/devstudios/${this.studio.id}/members/add`, {
                        user: this.selectedMemberToAdd.value
                    }).then(response => {
                        this.submitting = false;
                        this.studio.users = response.data;
                        this.memberAdded = true;
                    }).catch(err => {
                        this.submitting = false;
                        console.error(err);
                        this.error = true;
                    });
                    this.selectedMemberToAdd = null;
                }
            },
            onEditStudioSubmit() {
                this.submitting = true;
                axios.put(`/api/devstudios/${this.studio.id}/edit`, this.studioFromForm).then(() => {
                    this.studio = {... this.studioFromForm};

                    this.studioEdited = true;
                    this.submitting = false;
                    this.editStudio = false;
                }).catch(err => {
                    this.invalid = true;
                    this.errors = err.response.data.errors;
                    console.error(err);
                    this.submitting = false;
                });
            }
        }
    }
</script>

<style scoped>
    .vld-overlay.is-full-page {
        z-index: 1051 !important;
    }
</style>