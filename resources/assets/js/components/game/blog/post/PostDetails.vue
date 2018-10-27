<template>
    <div class="my-2" v-if="post.title">
        <b-jumbotron bg-variant="dark" text-variant="white" header-level="4">
            <template slot="header">
                {{post.title}}
            </template>
            <b-link :to="{name: 'game_details', params: {id: post.game_id}}" class="mr-1">{{post.game.title}} </b-link>
            <br>
            <em>Posted at {{post.created_at}}</em>
        </b-jumbotron>
        <p v-html="post.body" class="col-sm-10 my-2"></p>

        <p>Comments:</p>
        <div v-if="post.comments !== undefined && post.comments.length > 0">
            <div v-for="(comment, index) in post.comments" :key="comment.id" class="my-2">
                <b-card :id="index">
                    <b-row class="col-sm-12">
                        <em>#{{index + 1}} by {{comment.author.name}} on {{comment.created_at}}</em>
                        <b-link v-if="isAuthor(comment.author.id)" class="ml-auto text-danger" @click="onDelete(comment)">Delete</b-link>
                    </b-row>
                    <p v-html="comment.body"></p>
                </b-card>
            </div>
        </div>
        <div v-else><p>No comments found.</p></div>
        <template v-if="!isLoggedIn">
            <p>Please log in to add comments.</p>
        </template>
        <template v-else>
            <b-button @click="showForm" v-if="!formVisible" >Add comment</b-button>
            <div v-if="formVisible" class="my-2">
                <b-form @submit="onSubmit" class="col-sm-10">
                    <b-form-group label="Comment:">
                        <vue-editor v-model="comment.body"></vue-editor>
                    </b-form-group>
                    <b-button type="submit" variant="primary" :disabled="!comment.body">Submit</b-button>
                    <b-button @click="hideForm" variant="default">Cancel</b-button>
                </b-form>
            </div>
        </template>

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
                    gameId: null,
                    postId: null,
                    body: null,
                }
            }
        },
        components: {
            VueEditor
        },
        beforeMount() {
            this.comment.gameId = this.$route.params.gameId;
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
                    game_id: this.comment.gameId,
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
            onDelete(comment) {
                if (this.isAuthor(comment.author.id)){
                    let confirm = window.confirm("Are you sure you want to delete this comment? This cannot be undone!"); // TODO
                    if (confirm) {
                        axios.delete(`/api/comment/${comment.id}`).then(() => {
                            fetchPost(this.post.id, (err, data) => {
                                this.setData(err, data);
                            });
                        });
                    }
                } else {
                    console.log("You're not allowed to delete this message");
                }
            },
            isAuthor(authorId) {
                if (this.isLoggedIn) {
                    const id = parseInt(Auth.getId());
                    return authorId === id;
                }
                return false;
            },
            isLoggedIn() {
                return Auth.isLoggedIn();
            }
        }
    }
</script>

<style scoped>

</style>