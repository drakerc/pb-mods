<template>
    <div>
        <b-form @submit.prevent="onSubmit">
            <b-form-group label="Title:" description="Your game's title">
                <b-form-input v-model="game.title" class="col-sm-6"/>
            </b-form-group>
            <b-form-group label="Game Category">
                <b-form-select :options="gameCategories" v-model="game.gameCategoryId" class="col-sm-6"></b-form-select>
            </b-form-group>
            <b-form-group label="Description:">
                <vue-editor v-model="game.description"></vue-editor>
            </b-form-group>
            <b-button type="submit" variant="primary" :disabled="!isValid">Submit</b-button>
        </b-form>
    </div>
</template>

<script>
    import {VueEditor} from 'vue2-editor';

    const fetchGameCategories = (callback) => {
        axios.get(`/api/game-categories`).then((response) => {
            callback(null, response.data);
        }).catch(err => callback(err, err.response.data));
    };

    export default {
        name: "GameForm",
        components: {
            VueEditor
        },
        computed: {
            isValid() {
                return this.game.description && this.game.title && this.game.gameCategoryId;
            }
        },
        data() {
            return {
                game: {
                    title: null,
                    description: null,
                    gameCategoryId: null
                },
                gameCategories: [
                    {value: null, text: 'Please select from one of the categories below:', disabled: true, selected: true}
                ]
            }
        },
        beforeRouteEnter(to, from, next) {
            fetchGameCategories((err, data) => {
                next(vm => vm.setData(err, data));
            });
        },
        methods: {
            setData(err, data) {
                if (err) {
                    console.error(err);
                } else {
                    data.forEach(gameCategory => {
                        this.gameCategories.push({
                            value: gameCategory.id,
                            text: gameCategory.title
                        });
                    });
                }
            },
            onSubmit() {
                axios.post(`/api/game`, {
                    description: this.game.description,
                    title: this.game.title,
                    game_category_id: this.game.gameCategoryId
                }).then(response => {
                    this.$router.push({
                        name: 'game_details',
                        params: {
                            id: response.data.id,
                        }
                    });
                });
            }
        }
    }
</script>

<style scoped>

</style>