<template>
    <div>
        Details:
        <p>Title: {{game.title}}</p>
        <p>Description:</p>
        <em>{{game.description}}</em>
        <p>Posts:</p>
        <div v-if="game.posts.length > 0">
            <b-card v-for="post in game.posts" :key="post.id">
                <b-link slot="header" :to="`/post/${post.id}`">{{post.title}}</b-link>
                <p class="card-text">{{post.body}}</p>
            </b-card>
        </div>
        <div v-else>
            <p class="lead">No posts available.</p>
        </div>
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

</style>