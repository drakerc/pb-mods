<template>
    <div class="container my-2 col-sm-7 mx-auto">
        <template v-if="!loading">
            <b-alert :show="deleted" varianrouter.params.t="warning">
                <p>Pomyślnie usunięto studio.</p>
            </b-alert>
            <b-card v-if="filtersDisplayed" class="mb-2">
                <b-form @submit.prevent="executeFilters">
                    <b-form-group label="Specjalizacja:">
                        <b-form-select v-model="filters.specialization" class="col-sm-6">
                            <option :value="null">(brak filtrowania)</option>
                            <option :value="0">Brak specjalizacji</option>
                            <option :value="1">Modyfikacje</option>
                            <option :value="2">Produkcja gier</option>
                        </b-form-select>
                    </b-form-group>
                    <b-form-group>
                        <b-form-checkbox v-model="filters.commercial" :value="true" :unchecked-value="false">Komercyjne</b-form-checkbox>
                    </b-form-group>
                    <b-col>
                        <b-row>
                            <b-btn variant="success" class="mr-auto" type="submit">Szukaj</b-btn>
                            <b-btn variant="warning" class="ml-auto" @click="filtersDisplayed=false">
                                Ukryj filtry
                                <font-awesome-icon icon="angle-up" />
                            </b-btn>
                        </b-row>
                    </b-col>
                </b-form>

            </b-card>
            <b-col v-if="!filtersDisplayed">
                <b-row>
                    <b-btn class="ml-auto my-2" @click="filtersDisplayed=true">
                        Pokaż filtry
                        <font-awesome-icon icon="angle-down" />
                    </b-btn>
                </b-row>
            </b-col>
            <p>Studia deweloperskie:</p>
            <template v-if="studios && studios.data.length > 0">
                <p>Znaleziono {{studios.total}} rekordów:</p>
                <b-card v-for="studio in studios.data" :key="studio.id" class="my-2">
                    <b-link slot="header" :to="{name: 'dev_studio_details', params:{id: studio.id}}">{{studio.name}}</b-link>
                    <p v-html="studio.description"></p>
                </b-card>
                <b-row>
                    <div class="mx-auto">
                        <paginate :data="studios" @pagination-change-page="getResults"></paginate>
                    </div>
                </b-row>
            </template>
            <template v-else>
                <h2>Brak studiów deweloperskich w bazie.</h2>
            </template>
        </template>
        <div v-else>
            <loading :active.sync="loading" :can-cancel="false" :is-full-page="true" loader="dots"></loading>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import paginate from 'laravel-vue-pagination';
    import truncate from 'vue-truncate-collapsed';
    import Loading from 'vue-loading-overlay';
    import 'vue-loading-overlay/dist/vue-loading.css';

    const fetch = (callback) => {
        axios.get(`/api/devstudios`).then((response) => {
            callback(null, response.data);
        }).catch(error => callback(error, error.response.data));
    };

    export default {
        name: "DevelopmentStudiosIndex",
        props: ['deleted'],
        data() {
            return {
                studios: null,
                filtersDisplayed: false,
                loading: true,
                filters: {}
            }
        },
        components: {
            paginate,
            truncate,
            Loading
        },
        beforeRouteEnter(to, from, next) {
            fetch((err, data) => {
                next(vm => vm.setData(err, data));
            });
        },
        methods: {
            setData(err, data) {
                if (err) {
                    console.error(err);
                    this.$router.push({
                        name: 'game_index'
                    });
                } else {
                    console.log(data);
                    this.studios = data.studios;
                    this.loading = false;
                }
            },

            getResults(page) {
                this.loading = true;
                axios.get(`/api/devstudios`, {
                    params: {
                        page,
                        filters: this.filters
                    }
                })
                    .then(response => {
                        this.studios = response.data.studios;
                        this.loading = false;
                    })
                    .catch(err => console.error(err));
            },
            executeFilters() {
                this.loading = true;
                axios.get(`/api/devstudios`, {
                    params: {
                        filters: this.filters
                    }
                }).then(response => {
                    this.studios = response.data.studios;
                    console.log(this.studios);
                    this.loading = false;
                });
            }
        },
    }
</script>

<style scoped>

</style>