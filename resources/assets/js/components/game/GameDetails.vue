<template>
    <div>
        Details:
        <p>Title: {{game.title}}</p>
        <p>Posts:</p>
        <ul>
            <li v-for="post in game.posts">
                {{post.title}}
                <ul>
                    <li>{{post.body}}</li>
                </ul>
            </li>
        </ul>
    </div>
</template>

<script>
    import axios from 'axios';
    export default {
        name: "GameDetails",
        data() {
            return {
                game: {}
            }
        },
        created() {
            return this.fetch();
        },
        methods:{
            fetch() {
                const id = this.$route.params['id'];
                axios.get(`/api/game/${id}`).then((response) => {
                    console.log(response.data);
                    this.game = response.data;
                });
            }
        }
    }
</script>

<style scoped>

</style>