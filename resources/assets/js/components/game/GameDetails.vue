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
                <div v-if="game.posts !== undefined && game.posts.length > 0">
                    <p>Posts:</p>
                    <b-card v-for="post in game.posts" :key="post.id">
                        <b-link slot="header" :to="`/post/${post.id}`">{{post.title}}</b-link>
                        <p class="card-text">{{post.body}}</p>
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
        methods:{
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