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
            <b-card class="my-2">
                <p>Członkowie:</p>
                <b-list-group class="col-sm-4">
                    <b-list-group-item v-for="member in studio.users" :key="member.id">
                        <b-row>
                            <span class="lead mx-1">{{member.name}}</span>
                            <b-btn v-if="Auth.getId() !== member.id" class="ml-auto my-1" variant="danger" @click="selectMemberToDelete(member)">
                                Usuń
                            </b-btn>
                            <span v-else class="ml-1 lead">(you)</span>
                        </b-row>
                    </b-list-group-item>
                </b-list-group>
            </b-card>
            <b-card class="my-2">
                <p>Usuń studio:</p>
                <b-btn variant="danger" @click="showModal = true">Usuń</b-btn>
            </b-card>
            <b-modal v-if="selectedMember" v-model="showMemberModal" hide-header centered variant="sm">
                <p>Czy na pewno chcesz usunąć członka {{selectedMember.name}} z grupy {{studio.name}}? tej operacji nie można cofnąć!</p>
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
                selectedMember: null,
                showMemberModal: false,
                memberDeleted: false,
                error: false
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
                this.selectedMember = member;
                this.showMemberModal = true;
            },
            onCancelMemberModal() {
                this.selectedMember = null;
                this.showMemberModal = false;
            },
            onMemberDelete() {
                if (this.selectedMember !== null) {
                    this.showModal = false;
                    this.submitting = false;
                    axios.delete(`/api/devstudios/${this.studio.id}/members/delete`, {
                        params: {
                            user_id: this.selectedMember.id
                        }
                    }).then(response => {
                        this.selectedMember = null;
                        this.studio.users = response.data;
                        this.memberDeleted = true;
                    }).catch(err => {
                        this.selectedMember = null;
                        this.error = true;
                        this.memberDeleted = false;
                        console.error(err);
                    })
                }
            }
        }
    }
</script>

<style scoped>
    .vld-overlay.is-full-page {
        z-index: 1051 !important;
    }
</style>