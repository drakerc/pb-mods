<template>
    <div class="container my-2 col-sm-9 mx-auto">
        <div class="col-sm-7 mx-auto">
            <em v-if="loading" class="lead">Please wait...</em>
            <div v-else>
                <p>Results for <em>"{{phrase}}"</em>:</p>
                <div v-if="games.length > 0">
                    <b-list-group>
                        <b-list-group-item v-for="game in games" :key="game.id" :to="{name: 'game_details', params: {id: game.id}}">{{game.title}}</b-list-group-item>
                    </b-list-group>
                </div>
                <div v-else>
                    <p class="lead">No results found.</p>
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
                        this.games = data;
                    }
                });
            }
        }
    }
</script>

<style scoped>

</style>