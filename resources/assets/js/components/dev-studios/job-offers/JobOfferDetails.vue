<template>
    <div class="container my-2 col-sm-9 mx-auto">
        <template v-if="loading">
            Wczytywanie...
        </template>
        <template v-if="!loading">
            <b-alert :show="emailSent" variant="success">
                Email został wysłany pomyślnie, dziękujemy za złożenie aplikacji!
            </b-alert>
            <b-alert :show="!!error" variant="danger">
                {{error}}
            </b-alert>
            <b-jumbotron header-level="4" header-tag="h4">
                <template slot="header">
                    {{offer.title}}
                </template>
                <b-row class="ml-0">
                    Umieszczone <div id="date" class="ml-1 mr-1">{{humanReadable(offer.created_at)}}</div> przez studio <b-link class="ml-1" :to="{name: 'dev_studio_details', params:{id: offer.development_studio_id}}"><strong>{{offer.development_studio.name}}</strong></b-link>
                </b-row>
                <b-row class="ml-0">
                    Ważne do dnia {{offer.valid_until}}
                </b-row>
            </b-jumbotron>
            <b-tooltip target="date">
                {{offer.created_at}}
            </b-tooltip>
            <b-card>
                <p v-html="offer.body"></p>
            </b-card>
            <b-row v-if="!isMember && Auth.isLoggedIn()">
                <b-btn :to="{name: 'job_offer_form', params:{id: offer.id}}" class="my-2 mx-auto" variant="info">
                    <font-awesome-icon icon="envelope"/>
                    Zaaplikuj!
                </b-btn>
            </b-row>
            <p v-else-if="!Auth.isLoggedIn()" class="my-2"><b-link :to="{name: 'login', query:{redirectTo: $route.fullPath}}">Zaloguj się</b-link>, by złożyć aplikację!</p>
        </template>
    </div>
</template>

<script>
    import axios from 'axios';
    import moment from 'moment';
    import Auth from "../../../auth";

    const fetch = (id, callback) => {
        axios.get(`/api/job-offer/${id}`).then((response) => {
            callback(null, response.data);
        }).catch(error => callback(error, error.response.data));
    };

    export default {
        name: "JobOfferDetails",
        props: ['emailSent', 'error'],
        data() {
            return {
                offer: {},
                Auth,
                loading: true
            }
        },
        asyncComputed: {
            isMember() {
                return Auth.isMember(this.offer.development_studio_id);
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
                    this.$router.push({
                        name: 'home'
                    });
                } else {
                    this.offer = data;
                    this.loading = false;
                }
            },
            humanReadable(date) {
                return moment(date).locale('pl').fromNow();
            },
        }
    }
</script>

<style scoped>

</style>