<template>
    <div>
        <p>Results for "{{phrase}}"</p>
        <div v-for="game in games" :key="game.id">
            <router-link :to="`/game/${game.id}`">{{game.title}}</router-link>
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
            // console.log(response.data);
            callback(null, response.data);
        }).catch(err => callback(err, err.response.data));

    };

    export default {
        name: "GameIndex",
        data() {
            return {
                games: [],
                phrase: ""
            }
        },
        beforeRouteEnter(to, from, next) {
            search(to.query.phrase, (err, data) => {
                next(vm => vm.setData(err, data));
            });
        },
        beforeMount() {
            this.phrase = this.$route.query.phrase;
        },
        methods: {
            setData(err, data) {

                if (err) {
                    console.error(err);
                } else {
                    console.log(data);
                    this.games = data;
                }
            }
        }
    }
</script>

<style scoped>

</style>