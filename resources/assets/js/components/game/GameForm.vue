<template>
    <div class="container my-2 col-sm-9 mx-auto">
        <b-form @submit.prevent="onSubmit">
            <b-form-group label="Title:" description="Your game's title">
                <b-form-input v-model="game.title" class="col-sm-6"/>
            </b-form-group>
            <b-form-group label="Game Category">
                <b-form-select multiple :options="gameCategories" v-model="game.gameCategoryIds" class="col-sm-6"></b-form-select>
            </b-form-group>
            <b-form-group label="Game logo:">
                <b-form-file accept="image/*" v-model="logoFile" placeholder="Choose an image file" class="col-sm-6"></b-form-file>
                <div class="mt-3">Selected file: {{logoFile && logoFile.name}}</div>
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
                return this.game.description && this.game.title && this.game.gameCategoryIds.length > 0;
            }
        },
        data() {
            return {
                game: {
                    title: null,
                    description: null,
                    gameCategoryIds: []
                },
                logoFile: null,
                gameCategories: [
                    {value: null, text: 'Please select one (or more) categories from below:', disabled: true, selected: true}
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
                let formData = new FormData();
                formData.append('description', this.game.description);
                formData.append('title', this.game.title);
                formData.append('game_category_ids', this.game.gameCategoryIds);
                if (this.logoFile) {
                    formData.append('logoFile', this.logoFile);
                }
                axios.post(`/api/game`, formData, {
                    headers: {
                        'Content-type': 'multipart/form-data'
                    }
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