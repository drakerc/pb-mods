<template>
    <div>
        <h1>{{post.title}}</h1>
        <em>Posted at {{post.created_at}}</em>
        <p v-html="post.body"></p>

        <p>Comments:</p>
        <div v-if="post.comments !== undefined && post.comments.length > 0">
            <div v-for="(comment, index) in post.comments" :key="comment.id">
                <b-card>
                    <em>#{{index + 1}} by {{comment.author.name}} on {{comment.created_at}}</em>
                    <p>{{comment.body}}</p>
                </b-card>
            </div>
        </div>
        <div v-else><p>No comments found.</p></div>
        <b-button>Add comment</b-button>

    </div>
</template>

<script>
    import axios from 'axios';

    const fetchGames = (id, callback) => {
        axios.get(`/api/post/${id}`).then((response) => {
            // console.log(response.data);
            callback(null, response.data);
        }).catch(err => callback(err, err.response.data));

    };

    export default {
        name: "PostDetails",
        data() {
            return {
                post: {}
            }
        },
        beforeRouteEnter(to, from, next) {
            fetchGames(to.params.id, (err, data) => {
                next(vm => vm.setData(err, data));
            });
        },
        methods: {
            setData(err, data) {
                if (err) {
                    console.error(err);
                } else {
                    this.post = data;
                }
            }
        }
    }
</script>

<style scoped>

</style>