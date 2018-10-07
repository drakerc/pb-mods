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
        <b-tabs>
            <b-tab title="Info">
                <p>Description:</p>
                <em>{{game.description}}</em>
            </b-tab>
            <b-tab title="Blog">
                <!--TODO: if user is authenticated and is in development team-->
                <b-link :to="{name: 'post_form', params:{id: game.id}}">Create a new post</b-link>
                <div v-if="game.posts !== undefined && game.posts.length > 0">
                    <p>Posts:</p>
                    <b-card v-for="post in game.posts" :key="post.id" class="my-2">
                        <p slot="header">
                            <b-link :to="{name: 'post_details', params: {gameId: game.id, id: post.id}}">{{post.title}}</b-link>
                        </p>
                        <p slot="header"><em>Posted at: {{post.created_at}}</em></p>
                        <p class="card-text" v-html="post.body"></p>
                    </b-card>
                </div>
                <div v-else>
                    <p>No posts available.</p>
                </div>
            </b-tab>
            <b-tab title="Files">
                <!--TODO-->
            </b-tab>
        </b-tabs>

    </div>
</template>

<script>
    import axios from 'axios';

    const fetch = (id, callback) => {
        axios.get(`/api/game/${id}`).then((response) => {
            // console.log(response.data);
            callback(null, response.data);
        }).catch(error => callback(error, error.response.data));
    };

    export default {
        name: "GameDetails",
        data() {
            return {
                game: {}
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
                } else {
                    this.game = data;
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
</style>