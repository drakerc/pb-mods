<template>
    <div class="container my-2">
        <b-col sm="11" class="mx-auto">
            <h1>Witaj!</h1>
            <b-button v-if="Auth.isLoggedIn()" :to="{name:'new_game_form'}" variant="success" class="mb-2">
                <font-awesome-icon icon="plus"/>
                Utwórz nową grę
            </b-button>
            <b-row>
                <b-col sm="8">
                    <p>Najnowsze wpisy o grach:</p>
                    <template v-if="games">
                        <b-card v-for="game in games.data" :key="game.id" class="my-2">
                            <b-link slot="header" :to="`/game/${game.id}`">#{{game.id}} - {{game.title}}</b-link>
                            <p class="card-text small" v-html="game.description"></p>
                        </b-card>
                        <b-row>
                            <paginate class="mx-auto" :data="games" @pagination-change-page="getResults"></paginate>
                        </b-row>
                    </template>
                </b-col>
                <b-col sm="4">
                    <div>
                        <p>Ostatnie wpisy na blogach:</p>
                        <b-card v-for="post in posts" :key="post.id" class="my-2 small">
                            <b-link slot="header" :to="`/game/post/${post.id}`">{{post.title}}</b-link>
                            <truncate clamp="Show more" :length="50" less="Show Less" type="html" :text="post.body" action-class="text-primary"/>
                        </b-card>
                    </div>
                    <br><br>
                    <p>Najnowsze oferty współpracy:</p>
                    <b-card v-for="offer in offers" :key="offer.id" class="my-2 small" no-body>
                        <template slot="header">
                            <b-row>
                                <b-link :to="{name: 'job_offer_details', params:{id: offer.id}}" class="mr-1">{{offer.title}} w {{offer.development_studio.name}}</b-link>
                            </b-row>
                        </template>
                    </b-card>
                </b-col>
            </b-row>
        </b-col>
    </div>
</template>

<script>
    import axios from 'axios';
    import truncate from 'vue-truncate-collapsed';
    import { Auth } from '../../auth';
    import paginate from 'laravel-vue-pagination';

    const fetchData = (callback) => {
        axios.get(`/api/game`).then((response) => {
            axios.get('/api/post').then((postResponse => {
                axios.get('/api/job-offer').then(jobOffersResponse => {
                    callback(null, {
                        games: response.data,
                        posts: postResponse.data,
                        offers: jobOffersResponse.data
                    });
                });
            }));
        }).catch(err => callback(err, err.response.data));

    };

    export default {
        name: "GameIndex",
        data() {
            return {
                games: null,
                posts: [],
                offers: [],
                Auth
            }
        },
        components: {
            truncate,
            paginate
        },
        beforeRouteEnter(to, from, next) {
            fetchData((err, data) => {
               next(vm => vm.setData(err, data));
            });
        },
        methods: {
            setData(err, data) {
                if (err) {
                    console.error(err);
                } else {
                    this.games = data.games;
                    this.posts = data.posts;
                    this.offers = data.offers;
                }
            },
            getResults(page) {
                axios.get(`/api/game`, {
                    params: {
                        page
                    }
                })
                    .then(response => this.games = response.data)
                    .catch(err => console.error(err));
            }
        }
    }
</script>

<style scoped>

</style>