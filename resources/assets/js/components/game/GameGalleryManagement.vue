<template>
    <div class="container my-2 col-sm-9 mx-auto">
        <b-alert :show="error" variant="danger">
            Wystąpił błąd podczas obsługi żądania, upewnij się, że wprowadzono prawidłowe dane, i spróbuj ponownie później.
        </b-alert>
        <b-card class="my-2">
            <div>
                <b-form @submit.prevent="onUploadNewImages">
                    <b-form-group label="Wczytaj nowe zdjęcia:">
                        <b-form-file accept="image/*" v-model="newImages" :multiple="true" placeholder="Wybierz kilka zdjęć w celu wypełnienia galerii..."></b-form-file>
                    </b-form-group>
                    <b-button type="submit" size="sm" variant="primary" :disabled="newImages.length === 0">Wyślij</b-button>
                </b-form>
            </div>
        </b-card>
        <b-card class="my-2">
            <p>Dodaj wideo do galerii:</p>
            <div>
                <b-form @submit.prevent="onAddNewVideo">
                    <b-form-group label="Tytuł filmu:">
                        <b-form-input v-model="newVideo.title" class="col-sm-6"></b-form-input>
                    </b-form-group>
                    <b-form-group label="Link do wideo (youtube):" description="Podaj link do strony youtube'owej, gdzie znajduje się wybrany film (np. youtube.com/watch?v=xxxxx)">
                        <b-form-input type="url" v-model="newVideo.url" class="col-sm-7"></b-form-input>
                    </b-form-group>
                    <b-button type="submit" size="sm" variant="primary" :disabled="!isNewVideoValid">Wyślij</b-button>
                </b-form>
            </div>
        </b-card>
        <b-card v-if="game.files !== undefined && game.files.length > 0" class="my-2">
            <p>Usuń zdjęcia z galerii:</p>
            <b-row>
                <b-col offset-sm="1">
                    <b-form @submit.prevent="onDeleteImages">
                        <b-form-checkbox-group v-model="imagesToDelete" class="mb-2">
                            <b-row>
                                <div v-for="file in game.files" :key="file.id">
                                    <b-col class="my-2">
                                        <b-form-checkbox :value="file.id">
                                            <img :src="file.downloadLink" class="img-thumbnail" style="height: 150px; width: 225px;">
                                        </b-form-checkbox>
                                    </b-col>
                                </div>
                            </b-row>
                        </b-form-checkbox-group>
                        <b-button type="submit" size="sm" variant="danger" :disabled="imagesToDelete.length === 0">Usuń</b-button>
                    </b-form>
                </b-col>
            </b-row>
        </b-card>
        <b-card v-if="game.videos !== undefined && game.videos !== null && game.videos.length > 0" class="my-2">
            <p>Usuń wideo z galerii:</p>
            <b-row>
                <b-col offset-sm="1">
                    <b-form @submit.prevent="onDeleteVideos">
                        <b-form-checkbox-group v-model="videosToDelete" class="mb-2">
                            <b-row>
                                <div v-for="video in game.videos" :key="video.id">
                                    <b-form-checkbox :value="video.id">
                                        <img :src="video.poster" class="img-thumbnail" style="height: 150px; width: 225px;">
                                    </b-form-checkbox>
                                </div>
                            </b-row>
                        </b-form-checkbox-group>
                        <b-button type="submit" size="sm" variant="danger" :disabled="!(videosToDelete.length > 0)">Usuń</b-button>
                    </b-form>
                </b-col>
            </b-row>
        </b-card>
    </div>
</template>

<script>

    import axios from "axios";
    import isUrl from 'is-url';

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
                newImages: [],
                newVideo: {
                    title: null,
                    url: null
                },
                error: false,
                videosToDelete: [],
                asd: []
            }
        },
        watch: {
            game: (game) => {
                console.log(game.videos);
            }
        },
        computed: {
          isNewVideoValid() {
              return this.newVideo.url !== null && isUrl(this.newVideo.url) &&
                      this.newVideo.title !== null && this.newVideo.title.length > 3;
          }
        },
        beforeRouteEnter(to, from, next) {
            fetch(to.params.id, (err, data) => {
                next(vm => vm.setData(err, data));
            });
        },
        methods: {
            cleanErrors() {
                this.error = false;
            },
            setData(err, data) {
                if (err) {
                    console.error(err);
                } else {
                    this.game = data;
                }
            },
            onUploadNewImages() {
                this.cleanErrors();
                let formData = new FormData();

                this.newImages.forEach((image, index) => {
                    formData.append(`images[${index}]`, image);
                });

                axios.post(`/api/game/${this.game.id}/gallery/upload`, formData, {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                }).then(response => {
                    this.game.files.push(...response.data);
                }).catch(err => {
                    console.error(err);
                    this.error = true;
                });
            },
            onDeleteImages() {
                this.cleanErrors();
                axios.post(`/api/game/${this.game.id}/gallery/delete`, {
                    images: this.imagesToDelete
                }).then(() => {
                    this.game.files = this.game.files.filter(image => {
                       return !this.imagesToDelete.includes(image.id);
                    });
                    this.imagesToDelete = [];
                }).catch(err => {
                    console.error(err);
                    this.error = true;
                });
            },
            onAddNewVideo() {
                this.cleanErrors();
                axios.post(`/api/game/${this.game.id}/gallery/video/upload`, this.newVideo).then((response) => {
                    console.log(response);
                    this.game.videos.push(response.data);
                    this.newVideo = {
                        title: null,
                        url: null
                    };
                }).catch(err => {
                    console.error(err);
                    this.error = true;
                })
            },
            onDeleteVideos() {
                this.cleanErrors();
                console.log(this.videosToDelete);
                axios.post(`/api/game/${this.game.id}/gallery/video/delete`, {
                    videos: this.videosToDelete
                }).then(() => {
                    this.game.videos = this.game.videos.filter(video => {
                        return !this.videosToDelete.includes(video.id);
                    });
                    this.videosToDelete = [];
                }).catch(err => {
                    console.error(err);
                    this.error = true;
                });
            }
        }
    }
</script>

<style scoped>

</style>