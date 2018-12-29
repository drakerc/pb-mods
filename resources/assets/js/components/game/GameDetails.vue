<template>
    <div :style="backgroundImage" :class="textVariant">
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
                <em>Dodano: {{game.created_at}}</em>
            </b-jumbotron>
            <b-card no-body :bg-variant="game.variant" :text-variant="textVariant">
                <b-tabs pills card :nav-wrapper-class="navWrapperClass">
                    <b-tab title="Info" class="my-2" :title-link-class="titleLinkClass">
                        <b-col>
                            <b-row>
                                <b-col sm="8">
                                    <b-card :bg-variant="game.variant" :text-variant="textVariant" header="Opis:">
                                        <em v-html="game.description"></em>
                                    </b-card>
                                </b-col>

                                <b-col>
                                    <b-card :bg-variant="game.variant" :text-variant="textVariant">
                                        <div slot="header">
                                            Informacje:
                                        </div>
                                        <p>Twórcy:</p>
                                        <p v-for="developmentStudio in game.development_studio" :key="developmentStudio.id">
                                            <b-link :to="{name:'dev_studio_details', params:{id: developmentStudio.id}}" :class="textVariant">{{developmentStudio.name}}</b-link>
                                        </p>
                                        <router-link :to="{name: 'game_mods', params: {game: game.id} }">
                                            <b-btn class="mr-2" size="lg" :variant="buttonVariant">
                                                <font-awesome-icon icon="cogs" />
                                                Modyfikacje
                                            </b-btn>
                                        </router-link>
                                        <br><br><br><br><br><br><br>
                                    </b-card>
                                </b-col>
                            </b-row>
                        </b-col>
                    </b-tab>
                    <b-tab title="Blog" class="my-2" :title-link-class="titleLinkClass">
                        <b-col>
                            <!--TODO: if user is authenticated and is in development team-->
                            <b-btn v-if="Auth.isLoggedIn() && isMember"
                                   class="mb-2"
                                   :to="{name: 'new_post_form', params:{id: game.id}}"
                                   :variant="buttonVariant"
                            >
                                Utwórz nowy post:
                            </b-btn>
                            <div v-if="game.posts !== undefined && game.posts.length > 0">
                                <p>Ostatnie aktualizacje bloga:</p>
                                <b-card v-for="post in game.posts" :key="post.id" class="my-2" :bg-variant="game.variant" :text-variant="textVariant">
                                    <template slot="header">
                                        <b-link :to="{name: 'post_details', params: {id: post.id}}">{{post.title}}</b-link>
                                    </template>
                                    <p slot="header"><em>Dodano: {{post.created_at}}</em></p>
                                    <p class="card-text" v-html="post.body"></p>
                                </b-card>
                            </div>
                            <div v-else>
                                <p>Brak postów.</p>
                            </div>
                        </b-col>
                    </b-tab>
                    <b-tab title="Galeria" :title-link-class="titleLinkClass">
                        <b-col>
                            <b-row class="mb-2" v-if="isMember">
                                <b-col>
                                    <b-button size="sm" :variant="buttonVariant" :to="{name:'game_gallery_manage', params: {id: game.id}}">Edytuj galerię</b-button>
                                </b-col>
                            </b-row>
                            <b-row v-if="game.files !== undefined && game.files.length > 0">
                                <gallery :images="images"
                                         :index="index"
                                         :options="{youTubeVideoIdProperty: 'youtube', youTubePlayerVars: undefined, youTubeClickToPlay: true}"
                                         @close="index = null"></gallery>
                                <div
                                        class="image"
                                        v-for="(image, imageIndex) in images"
                                        :key="imageIndex"
                                        @click="index = imageIndex"
                                        :style="{ backgroundImage: 'url(' + image.poster + ')', width: '300px', height: '200px' }"

                                ></div>
                            </b-row>
                        </b-col>
                    </b-tab>
                </b-tabs>
            </b-card>
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
                isMember: false,
                Auth
            }
        },
        components: {
            'gallery': VueGallery
        },
        watch: {
            game: {
                handler(game) {
                    game.development_studio.forEach(async studio => {
                        let value = await Auth.isMember(studio.id).then(val => val);
                        if (value === true) {
                            this.isMember = true;
                        }
                    });
                }
            }
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
                            return 'text-white';
                        default:
                            return null;
                    }
                }
            },
            buttonVariant() {
              if (this.game.variant) {
                  switch (this.game.variant) {
                      case 'primary':
                          return 'secondary';
                      default:
                          return 'primary';
                  }
              }
              return null;
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
            },
            linkClass() {
                if (this.game.variant === 'primary') {
                    return ['text-light'];
                }
                return null;
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
                    this.images = data.files.map((file, index) => {
                        return {
                            title: `${this.game.title} - Zdjęcie nr ${index}`,
                            type: file.file_type,
                            href: file.downloadLink,
                            poster: file.downloadLink
                        }
                    });
                    this.images.push(...data.videos.map(video => {
                        return {
                            title: video.title,
                            type: 'text/html',
                            href: video.url,
                            poster: video.poster,
                            youtube: video.youtube
                        }
                    }));
                    console.log(this.images);
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