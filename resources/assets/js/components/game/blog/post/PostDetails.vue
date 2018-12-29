<template>
    <div :style="backgroundImage">
        <div class="container col-sm-9 mx-auto" v-if="post.title">
            <b-jumbotron :bg-variant="post.game.variant" :text-variant="textVariant" header-level="5" class="mb-4">
                <template slot="header">
                    {{post.title}}
                </template>
                <b-link :to="{name: 'game_details', params: {id: post.game_id}}" class="mr-1">{{post.game.title}} </b-link>
                <br>
                <em>Dodano: {{post.created_at}}</em>
                <br>
                <b-button v-if="Auth.isLoggedIn()" :to="{name: 'edit_post_form', params: {id: post.game_id, postId: post.id}}" class="mt-4" variant="success">Edytuj post</b-button>
            </b-jumbotron>
            <b-card :bg-variant="post.game.variant" :text-variant="textVariant" class="my-4">
                <b-col>
                    <p v-html="post.body" class="my-2"></p>
                </b-col>
            </b-card>
            <b-card class="my-2":bg-variant="post.game.variant" :text-variant="textVariant">
                <b-col>
                    <p>Komentarze:</p>
                    <template v-if="post.comments !== undefined && post.comments.length > 0">
                        <div v-for="(comment, index) in post.comments" :key="comment.id" class="my-2">
                            <b-card :id="index" :bg-variant="post.game.variant" >
                                <template slot="header">
                                    <b-row class="col-sm-12">
                                        <b-col sm="0" class="mr-1 mb-1">
                                            <b-img :src="`${comment.author.gravatar}&s=50`" thumbnail rounded></b-img>
                                        </b-col>
                                        <b-col>
                                            <b-row class="my-3">
                                                <em>#{{index + 1}} {{comment.author.name}} - {{comment.created_at}}</em>
                                                <b-link v-if="isAuthor(comment.author.id) || isMember" class="ml-auto" :class="deleteVariant" @click="selectComment(comment)">
                                                    Usuń
                                                </b-link>
                                            </b-row>
                                            <!--<b-row></b-row>-->
                                        </b-col>
                                    </b-row>
                                </template>
                                <p v-html="comment.body"></p>
                            </b-card>
                        </div>
                    </template>
                    <template v-else><p>Brak komentarzy.</p></template>
                    <template v-if="!isLoggedIn">
                        <p>Proszę <b-link :to="{name: 'login', query:{redirect: $route.fullPath}}">zalogować się</b-link>, aby móc zakomentować post.</p>
                    </template>
                    <template v-else>
                        <b-button @click="showForm" v-if="!formVisible" class="my-1" :variant="post.game.variant === 'secondary' ? 'light' : 'secondary'">Dodaj komentarz</b-button>
                        <template v-if="formVisible">
                            <b-card no-body :bg-variant="post.game.variant" :text-variant="textVariant" class="my-2 col-sm-10 mx-auto">
                                <b-form @submit="onSubmit" class="my-2">
                                    <b-form-group label="Comment:">
                                        <vue-editor v-model="comment.body" class="bg-white text-dark"></vue-editor>
                                    </b-form-group>
                                    <b-button type="submit" variant="primary" :disabled="!comment.body">Wyślij</b-button>
                                    <b-button @click="hideForm" variant="warning">Anuluj</b-button>
                                </b-form>
                            </b-card>
                        </template>
                    </template>
                </b-col>
            </b-card>
            <b-modal v-if="selectedCommentToDelete !== null" v-model="showModal" hide-header centered variant="sm">
                <p>Czy na pewno chcesz usunąć komentarz autorstwa {{selectedCommentToDelete.author.name}}? tej
                    operacji nie można cofnąć!</p>
                <p>Treść komentarza:</p>
                <p v-html="selectedCommentToDelete.body"></p>
                <template slot="modal-footer">
                    <b-col>
                        <b-row>
                            <b-btn @click="onCancelModal" variant="warning" class="mr-auto">Anuluj</b-btn>
                            <b-btn @click="onCommentDelete" variant="danger" class="ml-auto">Potwierdź</b-btn>
                        </b-row>
                    </b-col>
                </template>
            </b-modal>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import { VueEditor } from 'vue2-editor';
    import { Auth } from "../../../../auth";

    const fetchPost = (id, callback) => {
        axios.get(`/api/post/${id}`).then((response) => {
            callback(null, response.data);
        }).catch(err => callback(err, err.response.data));
    };

    export default {
        name: "PostDetails",
        data() {
            return {
                post: {},
                formVisible: false,
                comment: {
                    postId: null,
                    body: null,
                },
                Auth,
                showModal: false,
                selectedCommentToDelete: null,
                isMember: false,
            }
        },
        components: {
            VueEditor
        },
        watch: {
            post(post) {
                post.game.development_studio.forEach(async studio => {
                    let value = await Auth.isMember(studio.id).then(val => val);
                    if (value === true) {
                        this.isMember = true;
                    }
                });
            }
        },
        computed: {
            isLoggedIn() {
                return Auth.isLoggedIn();
            },
            backgroundImage() {
                if (this.post.game && this.post.game.background) {
                    return {
                        'background-image': `url("${this.post.game.background.downloadLink}")`,
                        'background-repeat': 'no-repeat',
                        'background-attachment': 'fixed',
                        'height': '100%',
                        'background-size': 'cover',
                    };
                }
            },
            textVariant() {
                if (this.post.game.variant) {
                    switch(this.post.game.variant) {
                        case 'primary':
                        case 'secondary':
                        case 'success':
                        case 'info':
                        case 'warning':
                        case 'danger':
                        case 'dark':
                            return 'white';
                        default:
                            return null;
                    }
                }
            },
            deleteVariant() {
                if (this.post.game.variant) {
                    switch (this.post.game.variant) {
                        case 'danger':
                            return 'text-warning';
                        default:
                            return 'text-danger';
                    }
                }
            }
        },
        beforeMount() {
            this.comment.postId = this.$route.params.id;
        },
        beforeRouteEnter(to, from, next) {
            fetchPost(to.params.id, (err, data) => {
                next(vm => vm.setData(err, data));
            });
        },
        methods: {
            setData(err, data) {
                if (err) {
                    console.error(err);
                    this.$router.push({
                        name: 'game_details',
                        params: {
                            id: this.$route.params.gameId
                        }
                    })
                } else {
                    this.post = data;
                }
            },
            showForm() {
                this.formVisible = true;
            },
            hideForm() {
                this.formVisible = false;
                this.comment.body = '';
            },
            onSubmit() {
                axios.post(`/api/comment`, {
                    post_id: this.comment.postId,
                    body: this.comment.body,
                }).then(() => {
                    this.$router.push({
                        name: 'post_details',
                        params: {
                            gameId: this.$route.params.gameId,
                            id: this.$route.params.id
                        }
                    });
                });
            },
            selectComment(comment) {
                this.selectedCommentToDelete = comment;
                this.showModal = true;
            },
            onCancelModal() {
              this.selectedCommentToDelete = null;
              this.showModal = false;
            },
            onCommentDelete() {
                if (this.isAuthor(this.selectedCommentToDelete.author.id) || this.isMember){
                    axios.delete(`/api/comment/${this.selectedCommentToDelete.id}`).then(() => {
                        fetchPost(this.post.id, (err, data) => {
                            this.setData(err, data);
                            this.onCancelModal();
                        });
                    });
                } else {
                    console.log("You're not allowed to delete this message");
                }
            },
            isAuthor(authorId) {
                if (this.isLoggedIn) {
                    const id = parseInt(Auth.getId());
                    return authorId === id;
                }
                return this.isMember;

            }
        }
    }
</script>

<style scoped>

</style>