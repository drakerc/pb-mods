<template>
    <div>
        <div>Hello!</div>
        <p>Latest game releases:</p>
        <div>
            <div v-for="game in games">
                <h3 class="h3">{{game.id}} - {{game.title}}</h3>
                <div>
                    <router-link :to="`/game/${game.id}`">Details</router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    export default {
        name: "GameIndex",
        data() {
            return {
                games: []
            }
        },
        created() {
            return this.fetchGames();
        },
        methods: {
            fetchGames() {
                axios.get(`/api/game`).then((response) => {
                    console.log(response.data);
                    this.games = response.data;
                })
            }
        }


    }
</script>

<style scoped>

</style>