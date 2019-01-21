<template>
    <div class="container my-2 col-sm-9 mx-auto">
        <div class="col-sm-7 mx-auto">
            <em v-if="loading" class="lead">Proszę czekać...</em>
            <div v-else>
                <p>Wyniki dla frazy <em>"{{phrase}}"</em>:</p>
                <div v-if="games.length > 0">
                    <p>Gry:</p>
                    <b-list-group>
                        <b-list-group-item v-for="game in games" :key="game.id" :to="{name: 'game_details', params: {id: game.id}}">
                            <b-row>
                                <div v-if="game.logo">
                                    <b-img :src="game.logo.downloadLink" id="game-logo"></b-img>
                                </div>
                                <h2 class="mx-auto mt-4">{{game.title}}</h2>
                            </b-row>
                        </b-list-group-item>
                    </b-list-group>
                    <br><br><br>
                </div>
                <div v-if="posts.length > 0">
                    <p>Posty:</p>
                    <b-card v-for="post in posts" :key="post.id">
                        <template slot="header">
                            <b-link :to="{name: 'post_details', params:{id: post.id}}">{{post.title}}</b-link>
                        </template>
                        <p v-html="post.body"/>
                    </b-card>
                </div>
                <div v-if="games.length === 0 && posts.length === 0">
                    <h5>Brak rezultatów.</h5>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    const search = (phrase, callback) => {
        axios.get(`/api/game/search`, {
            params: {
                phrase
            }
        }).then((response) => {
            callback(null, response.data);
        }).catch(err => callback(err, err.response.data));

    };

    export default {
        name: "GameIndex",
        data() {
            return {
                games: [],
                posts: [],
                phrase: this.$route.query.phrase,
                loading: true
            }
        },
        watch: {
            '$route': 'search'
        },
        created() {
            this.search();
        },
        methods: {
            search() {
                this.games = [];
                this.loading = true;
                search(this.$route.query.phrase, (err, data) => {
                    this.loading = false;
                    if (err) {
                        console.error(err);
                    } else {
                        this.games = data.games;
                        this.posts = data.posts;
                    }
                });
            }
        }
    }
</script>

<style scoped>
    img#game-logo {
        max-height: 100px;
        max-width: 150px;
    }
</style>