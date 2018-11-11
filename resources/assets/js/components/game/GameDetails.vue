<template>
    <div :style="backgroundImage">
        <div class="container my-2 col-sm-9 mx-auto">
            <b-jumbotron :bg-variant="game.variant" :text-variant="textVariant">
                <div v-if="game.logo">
                    <b-img :src="game.logo.downloadLink" id="game-logo"></b-img>
                </div>

                <div class="row">
                    <div class="col-md-10">
                        <h2>{{game.title}}</h2>
                    </div>
                    <div class="col-md-2">
                    </div>
                </div>

                <div v-if="game.categories">
                    <strong v-for="category in game.categories" :key="category.id">{{category.title}} </strong>
                </div>
                <em>Added on {{game.created_at}}</em>
            </b-jumbotron>
            <b-card no-body :bg-variant="game.variant" :text-variant="textVariant">
                <b-tabs pills card :nav-wrapper-class="navWrapperClass">
                    <b-tab title="Info" class="my-2" :title-link-class="titleLinkClass">
                        <b-row>
                            <b-col sm="8">
                                <b-card :bg-variant="game.variant" :text-variant="textVariant" header="Description:">
                                    <em v-html="game.description"></em>
                                </b-card>
                            </b-col>

                            <b-col>
                                <b-card :bg-variant="game.variant" :text-variant="textVariant">
                                    <div slot="header">
                                        Info:
                                    </div>
                                    <router-link :to="{name: 'game_mods', params: {game: game.id} }">
                                        <b-btn class="mr-2" size="lg" variant="success">
                                            <font-awesome-icon icon="cogs" />
                                            Modifications
                                        </b-btn>
                                    </router-link>
                                    <br><br><br><br><br><br><br>
                                </b-card>
                            </b-col>
                        </b-row>
                    </b-tab>
                    <b-tab title="Blog" class="my-2" :title-link-class="titleLinkClass">
                        <!--TODO: if user is authenticated and is in development team-->
                        <b-btn v-if="Auth.isLoggedIn()" :to="{name: 'new_post_form', params:{id: game.id}}">Create a new post</b-btn>
                        <div v-if="game.posts !== undefined && game.posts.length > 0">
                            <p>Posts:</p>
                            <b-card v-for="post in game.posts" :key="post.id" class="my-2" :bg-variant="game.variant" :text-variant="textVariant">
                                <template slot="header">
                                    <b-link :to="{name: 'post_details', params: {id: post.id}}">{{post.title}}</b-link>
                                </template>
                                <p slot="header"><em>Posted at: {{post.created_at}}</em></p>
                                <p class="card-text" v-html="post.body"></p>
                            </b-card>
                        </div>
                        <div v-else>
                            <p>No posts available.</p>
                        </div>
                    </b-tab>
                    <b-tab title="Gallery" v-if="game.files !== undefined && game.files.length > 0" :title-link-class="titleLinkClass">
                        <b-col>
                            <b-row>
                                <gallery :images="images" :index="index" @close="index = null"></gallery>
                                <div
                                        class="image"
                                        v-for="(image, imageIndex) in images"
                                        :key="imageIndex"
                                        @click="index = imageIndex"
                                        :style="{ backgroundImage: 'url(' + image + ')', width: '300px', height: '200px' }"
                                ></div>
                            </b-row>
                        </b-col>
                    </b-tab>
                </b-tabs>
            </b-card>
            <b-row class="my-2" v-if="Auth.isLoggedIn()">
                <b-col>
                    <b-button size="sm" variant="primary" :to="{name:'game_gallery_manage', params: {id: game.id}}">Edit gallery</b-button>
                </b-col>
            </b-row>
        </div>
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
        computed: {
            backgroundImage() {
                if (this.game.background) {
                    return {
                        'background-image': `url("${this.game.background.downloadLink}")`,
                        'background-repeat': 'no-repeat',
                        'background-attachment': 'fixed',
                        'height': '100%',
                        'background-size': 'cover',
                    };
                }
            },
            textVariant() {
                if (this.game.variant) {
                    switch(this.game.variant) {
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
            navWrapperClass() {
                if (!! this.game.variant && this.game.variant === 'primary') {
                    return ['reversed'];
                }
            },
            titleLinkClass() {
                if (!! this.game.variant && this.game.variant !== 'default' && this.game.variant !== 'light'){
                    return ['link-text-light'];
                }
            }

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
                    this.$router.push({
                        'name': 'game_index'
                    })
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

<style>
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
    .jumbotron {

    }
    .reversed {
        /*color: #007bff;*/
        background-color: rgba(0, 0, 0, 0.125);
    }
    .link-text-muted {
        color: #6c757d;
    }
    .link-text-light {
        color: #fff;
    }
</style>