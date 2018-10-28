<template>
    <div>
        <b-card class="my-2">
            <div>
                <b-form @submit.prevent="onUploadNewImages">
                    <b-form-group label="Upload new images:">
                        <b-form-file accept="image/*" v-model="newImages" :multiple="true" placeholder="Select multiple images to upload to your gallery..."></b-form-file>
                    </b-form-group>
                    <b-button type="submit" size="sm" variant="primary" :disabled="newImages.length === 0">Upload</b-button>
                </b-form>
            </div>
        </b-card>
        <b-card>
            <p>Delete existing images:</p>
            <b-form @submit.prevent="onDeleteImages">
                <b-form-checkbox-group v-if="game.files !== undefined && game.files.length > 0" v-model="imagesToDelete">
                    <div v-for="file in game.files" :key="file.id">
                        <b-col class="my-2">
                            <img :src="file.downloadLink" class="img-thumbnail" style="height: 150px; width: 225px;">
                            <b-form-checkbox :value="file.id"></b-form-checkbox>
                        </b-col>
                    </div>
                </b-form-checkbox-group>

                <b-button type="submit" size="sm" variant="danger">Delete</b-button>
            </b-form>
        </b-card>
    </div>
</template>

<script>

    import axios from "axios";

    const fetch = (id, callback) => {
        axios.get(`/api/game/${id}`).then((response) => {
            callback(null, response.data);
        }).catch(error => callback(error, error.response.data));
    };

    export default {
        name: "GameGalleryManagement",
        data() {
            return {
                game: {},
                imagesToDelete: [],
                newImages: []
            }
        },
        beforeRouteEnter(to, from, next) {
            fetch(to.params.id, (err, data) => {
                next(vm => vm.setData(err, data));
            });
        },
        methods: {
            setData(err, data) {
                if (err) {
                    console.error(err);
                } else {
                    this.game = data;
                }
            },
            onUploadNewImages() {
                let formData = new FormData();

                this.newImages.forEach((image, index) => {
                    formData.append(`images[${index}]`, image);
                });

                axios.post(`/api/game/${this.game.id}/gallery/upload`, formData, {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                }).then(() => {
                    this.$router.push({
                        name: 'game_details',
                        params: {
                            id: this.game.id
                        }
                    });
                });
            },
            onDeleteImages() {
                axios.post(`/api/game/${this.game.id}/gallery/delete`, {
                    images: this.imagesToDelete
                }).then(() => {
                    this.$router.push({
                        name: 'game_details',
                        params: {
                            id: this.game.id
                        }
                    });
                });
            }
        }
    }
</script>

<style scoped>

</style>