<template>
    <div class="container my-2 col-sm-9 mx-auto">
        <div v-if="loading">Loading...</div>
        <div v-else class="col-sm-10 offset-sm-1">
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
    </div>
</template>

<script>
    import axios from 'axios'
    import {VueEditor} from 'vue2-editor';

    const fetchPostCategories = (postId, callback) => {
        axios.get(`/api/post-category`).then((response) => {
            if (postId) {
                axios.get(`/api/post/${postId}`).then(postResponse => {
                    callback(null, {
                        categories: response.data,
                        post: postResponse.data
                    });
                });
            } else {
                callback(null, {
                    categories: response.data
                });
            }
        }).catch(err => callback(err, err.response.data));
    };

    export default {
        name: "NewPostForm",
        components: {
            VueEditor
        },
        props: ['editMode'],
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
                    {
                        value: null,
                        text: 'Please select from one of the categories below:',
                        disabled: true,
                        selected: true
                    }
                ],
                loading: true
            }
        },
        beforeRouteEnter(to, from, next) {
            fetchPostCategories(to.params.postId, (err, data) => {
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
                    data.categories.forEach(postCategory => {
                        this.postCategories.push({
                            value: postCategory.id,
                            text: postCategory.name
                        });
                    });
                    if (data.post) {
                        this.post.title = data.post.title;
                        this.post.body = data.post.body;
                        this.post.postCategoryId = data.post.post_category_id;
                    }
                    this.loading = false;
                }
            },
            onSubmit() {
                let method = 'POST';
                let url = '/api/post';
                if (this.editMode) {
                    method = 'PUT';
                    const postId = this.$route.params.postId;
                    url = `/api/post/${postId}`;
                }
                axios({
                    method,
                    url,
                    data: {
                        game_id: this.post.gameId,
                        body: this.post.body,
                        title: this.post.title,
                        post_category_id: this.post.postCategoryId
                    }
                }).then(response => {
                    console.log(response);
                    this.$router.push({
                        name: 'post_details',
                        params: {
                            gameId: this.post.gameId,
                            id: response.data.id
                        }
                    });
                }).catch(err => console.error(err));
            }
        }
    }
</script>

<style scoped>

</style>