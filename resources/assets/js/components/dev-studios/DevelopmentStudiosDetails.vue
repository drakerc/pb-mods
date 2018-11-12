<template>
    <div class="container my-2 col-sm-9 mx-auto">
        <b-jumbotron header-level="4" header-tag="h4">
            <template slot="header">
                <p class="text-center">{{studio.name}}</p>
            </template>
        </b-jumbotron>
        <b-card no-body>
            <b-tabs card>
                <b-tab title="Informacje">
                    <b-row>
                        <b-col sm="7">
                            <p>Opis studia:</p>
                            <p v-html="studio.description"></p>
                        </b-col>
                        <b-col sm="1"></b-col>
                        <b-col sm="4">
                            <b-card header="Kontakt:">
                                <b-link :href="studio.website">Strona internetowa studia</b-link>
                                <br>
                                <b-link :href="`email-to:${studio.email}`">Email</b-link>
                            </b-card>
                        </b-col>
                    </b-row>
                </b-tab>
                <b-tab title="Gry">
                    <div v-for="game in studio.games" :key="game.id" class="my-2" style="cursor: pointer">
                        <b-card>
                            <div @click="showGameDetailsPage(game.id)" class="my-0">
                                <b-row>
                                    <div v-if="game.logo">
                                        <b-img :src="game.logo.downloadLink" id="game-logo"></b-img>
                                    </div>
                                    <h3 class="mt-4 ml-4 game-title">{{game.title}}</h3>
                                </b-row>
                            </div>
                        </b-card>
                    </div>
                </b-tab>
                <b-tab title="Modyfikacje">
                    <div v-for="mod in studio.modifications" :key="mod.id" class="my-2">
                        <b-card>
                            <template slot="header">
                                <b-link :to="{name: 'modification_view', params:{mod: mod.id}}">{{mod.title}}</b-link>
                            </template>
                            <p v-html="mod.description"></p>
                        </b-card>
                    </div>
                </b-tab>
                <b-tab title="Ogłoszenia">
                    <div v-for="offer in studio.job_offers" :key="offer.id" class="my-2">
                        <b-card>
                            <template slot="header">
                                <b-link :to="{name: 'job_offer_details', params:{id: offer.id}}">{{offer.title}}</b-link>
                            </template>
                            <truncate clamp="Show more" :length="100" less="Show Less" type="html" :text="offer.body" action-class="text-primary"/>
                        </b-card>
                    </div>
                </b-tab>
            </b-tabs>
        </b-card>
    </div>
</template>

<script>
    import axios from 'axios';
    import truncate from 'vue-truncate-collapsed';

    const fetch = (id, callback) => {
        axios.get(`/api/devstudios/find/${id}`).then((response) => {
            callback(null, response.data);
        }).catch(error => callback(error, error.response.data));
    };

    export default {
        name: "DevelopmentStudiosDetails",
        data() {
            return {
                studio: {},
            }
        },
        components: {
            truncate
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
                    this.$router.push({
                        name: 'home'
                    });
                } else {
                    this.studio = data;
                }
            },
            showGameDetailsPage(id) {
                this.$router.push({
                    name: 'game_details',
                    params: {
                        id
                    }
                })
            }
        }
    }
</script>

<style scoped>
    img#game-logo {
        max-height: 100px;
        max-width: 150px;
    }
    .game-title {
        /*font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;*/
    }
</style>