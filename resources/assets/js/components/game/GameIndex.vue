<template>
    <div class="container my-2">
        <b-col sm="10" class="mx-auto">
            <h1>Hello!</h1>
            <div class="row">
                <b-col sm="9">
                    <p>Latest game releases:</p>
                    <b-card v-for="game in games" :key="game.id" class="my-2">
                        <b-link slot="header" :to="`/game/${game.id}`">#{{game.id}} - {{game.title}}</b-link>
                        <!--<b-link class="h3" :to="`/game/${game.id}`"></b-link>-->
                        <p class="card-text small" v-html="game.description">
                            <!--{{game.description | truncate(200)}}-->
                        </p>
                    </b-card>
                </b-col>
                <b-col sm="3">
                    <p>Latest game updates:</p>
                    <b-card v-for="post in posts" :key="post.id" class="my-2 small">
                        <b-link slot="header" :to="`/game/${post.game_id}/post/${post.id}`">{{post.title}}</b-link>
                        <!--<b-link class="h3" :to="`/game/${game.id}`"></b-link>-->
                        <truncate clamp="Show more" :length="90" less="Show Less" type="html" :text="post.body" action-class="text-primary"/>
                    </b-card>
                </b-col>
            </div>
            <b-button v-if="Auth.isLoggedIn()" :to="{name:'new_game_form'}" variant="success">Create a new game entry</b-button>
        </b-col>
    </div>
</template>

<script>
    import axios from 'axios';
    import truncate from 'vue-truncate-collapsed';
    import { Auth } from '../../auth';

    const fetchData = (callback) => {
        axios.get(`/api/game`).then((response) => {
            axios.get('/api/post').then((postResponse => {
                callback(null, {
                    games: response.data,
                    posts: postResponse.data
                });
            }));
        }).catch(err => callback(err, err.response.data));

    };

    export default {
        name: "GameIndex",
        data() {
            return {
                games: [],
                posts: [],
                Auth
            }
        },
        components: {
            truncate
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
                }
            }
        }


    }
</script>

<style scoped>

</style>