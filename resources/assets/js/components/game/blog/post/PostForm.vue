<template>
    <div class="col-sm-10 offset-sm-1">
        <b-form @submit.prevent="onSubmit">
            <b-form-group label="Title:" description="Your post's title">
                <b-form-input v-model="post.title" class="col-sm-6"/>
            </b-form-group>
            <b-form-group label="Post Category">
                <b-form-select :options="postCategories" v-model="post.postCategoryId" class="col-sm-6"></b-form-select>
            </b-form-group>
            <b-form-group label="Body:">
                <vue-editor v-model="post.body"></vue-editor>
            </b-form-group>
            <b-button type="submit" variant="primary" :disabled="!isValid">Submit</b-button>
        </b-form>
    </div>
</template>

<script>
    import {VueEditor} from 'vue2-editor';

    const fetchPostCategories = (callback) => {
        axios.get(`/api/post-category`).then((response) => {
            callback(null, response.data);
        }).catch(err => callback(err, err.response.data));
    };

    export default {
        name: "PostForm",
        components: {
            VueEditor
        },
        computed: {
            isValid() {
                return this.post.body && this.post.gameId && this.post.postCategoryId;
            }
        },
        data() {
            return {
                post: {
                    title: null,
                    body: null,
                    gameId: null,
                    postCategoryId: null
                },
                postCategories: [
                    {value: null, text: 'Please select from one of the categories below:', disabled: true, selected: true}
                ]
            }
        },
        beforeRouteEnter(to, from, next) {
            fetchPostCategories((err, data) => {
                next(vm => vm.setData(err, data));
            });
        },
        beforeMount() {
            this.post.gameId = this.$route.params.id;
        },

        methods: {
            setData(err, data) {
                if (err) {
                    console.error(err);
                } else {
                    data.forEach(postCategory => {
                        this.postCategories.push({
                            value: postCategory.id,
                            text: postCategory.name
                        });
                    });
                }
            },
            onSubmit() {
                axios.post(`/api/post`, {
                    game_id: this.post.gameId,
                    body: this.post.body,
                    title: this.post.title,
                    post_category_id: this.post.postCategoryId
                }).then(response => {
                    console.log(response);
                    this.$router.push({
                        name: 'post_details',
                        params: {
                            gameId: this.post.gameId,
                            id: response.data.id
                        }
                    });
                });
            }
        }
    }
</script>

<style scoped>

</style>