<template>
    <div>
        <h1>Hello!</h1>

        <p>Latest game releases:</p>
        <b-card v-for="game in games" :key="game.id" class="my-2">
            <b-link slot="header" :to="`/game/${game.id}`">#{{game.id}} - {{game.title}}</b-link>
            <!--<b-link class="h3" :to="`/game/${game.id}`"></b-link>-->
            <p class="card-text" v-html="game.description">
                <!--{{game.description | truncate(200)}}-->
            </p>
        </b-card>
    </div>
</template>

<script>
    import axios from 'axios';

    const fetchGames = (callback) => {
        axios.get(`/api/game`).then((response) => {
            // console.log(response.data);
            callback(null, response.data);
        }).catch(err => callback(err, err.response.data));

    };

    export default {
        name: "GameIndex",
        data() {
            return {
                games: []
            }
        },
        beforeRouteEnter(to, from, next) {
            fetchGames((err, data) => {
               next(vm => vm.setData(err, data));
            });
        },
        methods: {
            setData(err, data) {
                if (err) {
                    console.error(err);
                } else {
                    // console.log(data);
                    this.games = data;
                }
            }
        }


    }
</script>

<style scoped>

</style>