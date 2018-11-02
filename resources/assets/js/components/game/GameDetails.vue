<template>
    <div>
        <div v-if="game.logo">
            <b-img :src="game.logo.downloadLink" id="game-logo"></b-img>
        </div>
        <h2>{{game.title}}</h2>
        <div v-if="game.categories">
            <strong v-for="category in game.categories" :key="category.id">{{category.title}} </strong>
        </div>
        <em>Added on {{game.created_at}}</em>
        <b-card no-body>
            <b-tabs card>
                <b-tab title="Info" class="my-2">
                    <b-row>
                        <b-col sm="8">
                            <p>Description:</p>
                            <em v-html="game.description"></em>
                        </b-col>

                        <b-col>
                            <b-card>
                                <div slot="header">
                                    Info:
                                </div>
                                <br><br><br><br><br><br><br>
                            </b-card>
                        </b-col>
                    </b-row>
                </b-tab>
                <b-tab title="Blog" class="my-2">
                    <!--TODO: if user is authenticated and is in development team-->
                    <b-link v-if="Auth.isLoggedIn()" :to="{name: 'post_form', params:{id: game.id}}">Create a new post</b-link>
                    <div v-if="game.posts !== undefined && game.posts.length > 0">
                        <p>Posts:</p>
                        <b-card v-for="post in game.posts" :key="post.id" class="my-2">
                            <template slot="header">
                                <b-link :to="{name: 'post_details', params: {gameId: game.id, id: post.id}}">{{post.title}}</b-link>
                            </template>
                            <p slot="header"><em>Posted at: {{post.created_at}}</em></p>
                            <p class="card-text" v-html="post.body"></p>
                        </b-card>
                    </div>
                    <div v-else>
                        <p>No posts available.</p>
                    </div>
                </b-tab>
                <b-tab title="Gallery" v-if="game.files !== undefined && game.files.length > 0">
                        <gallery :images="images" :index="index" @close="index = null"></gallery>
                        <div
                                class="image"
                                v-for="(image, imageIndex) in images"
                                :key="imageIndex"
                                @click="index = imageIndex"
                                :style="{ backgroundImage: 'url(' + image + ')', width: '300px', height: '200px' }"
                        ></div>
                </b-tab>
            </b-tabs>
        </b-card>
        <b-row class="my-2" v-if="Auth.isLoggedIn()">
            <b-col>
                <b-button size="sm" variant="primary" :to="{name:'game_gallery_manage', params: {id: game.id}}">Edit gallery</b-button>
            </b-col>
        </b-row>
    </div>
</template>

<script>
    import axios from 'axios';
    import VueGallery from 'vue-gallery';
    import { Auth } from "../../auth";

    const fetch = (id, callback) => {
        axios.get(`/api/game/${id}`).then((response) => {
            callback(null, response.data);
        }).catch(error => callback(error, error.response.data));
    };

    export default {
        name: "GameDetails",
        data() {
            return {
                game: {},
                images: [],
                index: null,
                Auth
            }
        },
        components: {
            'gallery': VueGallery
        },
        beforeRouteEnter(to, from, next) {
            fetch(to.params.id, (err, data) => {
                next(vm => vm.setData(err, data));
            });
        },
        beforeMount(){
            this.game.id = this.$route.params.id;
        },
        methods: {
            setData(err, data) {
                if (err) {
                    console.error(err);
                } else {
                    this.game = data;
                    this.images = data.files.map(file => {
                        return file.downloadLink;
                    });
                }
            }
        }
    }
</script>

<style scoped>
    img#game-logo {
        max-height: 100px;
        max-width: 150px;
    }
    .image {
        float: left;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center center;
        border: 1px solid #ebebeb;
        margin: 5px;
    }
    .close {
        color: #ffffff;
    }
    img.slide-content {
        max-height: 800px;
        max-width: 600px;
    }
</style>