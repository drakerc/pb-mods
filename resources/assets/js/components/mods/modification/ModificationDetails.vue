<template>
    <div class="cover-container" :style="backgroundImageStyle">
        <loading :active.sync="isLoading" is-full-page="true"></loading>

        <div class="container jumbotron text-white rounded" :style="splashImageStyle">
            <div class="row">
                <div class="col-md-10 bg-semi-transparent" :style="splashDetailsStyle">
                    <div class="row">
                        <div class="col-md-12">
                            <display-total-rating class="float-right" :rating="mod.averageRating"></display-total-rating>
                            <h1 class="display-4 font-italic text-center" :style="fontTitle">{{ mod.title }}</h1>
                            <div class="row">
                                <div class="col-md-4">
                                    Status produkcji:
                                </div>
                                <div class="col-md-8 mod-info-value">
                                    {{ mod.development_status }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    Wielkość:
                                </div>
                                <div class="col-md-8 mod-info-value">
                                    {{ mod.size }}
                                </div>
                            </div>

                            <div v-if="mod.replaces !== null" class="row">
                                <div class="col-md-4">
                                    Zamienia:
                                </div>
                                <div class="col-md-8 mod-info-value">
                                    {{ mod.replaces }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    Wersja:
                                </div>
                                <div class="col-md-8 mod-info-value">
                                    {{ mod.version }}
                                </div>
                            </div>

                            <div v-if="mod.devStudio !== null" class="row">
                                <div class="col-md-4">
                                    Studio developerskie:
                                </div>
                                <div class="col-md-8 mod-info-value">
                                    <router-link :to="{ name: 'dev_studio_mods', params: { studio: mod.devStudio.id } }">
                                        {{ mod.devStudio.name}}
                                    </router-link>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    Data wydania:
                                </div>
                                <div class="col-md-8 mod-info-value">
                                    {{ mod.release_date }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    Autor:
                                </div>
                                <div class="col-md-8 mod-info-value">
                                    <router-link :to="{ name: 'user_mods', params: { user: mod.creator } }">
                                        {{ mod.creatorName }}
                                    </router-link>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    Ilość pobrań:
                                </div>
                                <div class="col-md-8 mod-info-value">
                                    {{ mod.downloadsCount }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <display-timestamps :created_at="mod.created_at" :updated_at="mod.updated_at"></display-timestamps>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container jumbotron rounded text-white bg-semi-transparent-details" :style="descriptionStyle">
            <b-nav justified tabs class="bg-dark navigation-buttons" style="opacity: 0.85">
                <b-nav-item :active="active === 'description'" @click="setActiveTab('description')">
                    <font-awesome-icon icon="font" />
                    Opis
                </b-nav-item>
                <b-nav-item :active="active === 'pictures'" @click="setActiveTab('pictures')">
                    <font-awesome-icon icon="camera" />
                    Galeria zdjęć
                </b-nav-item>
                <b-nav-item :active="active === 'videos'" @click="setActiveTab('videos')">
                    <font-awesome-icon icon="video" />
                    Filmy
                </b-nav-item>
                <b-nav-item :active="active === 'news'" @click="setActiveTab('news')">
                    <font-awesome-icon icon="newspaper" />
                    Wiadomości
                </b-nav-item>
                <b-nav-item :active="active === 'reviews'" @click="setActiveTab('reviews')">
                    <font-awesome-icon icon="star" />
                    Opinie
                </b-nav-item>
                <b-nav-item :active="active === 'files'" @click="setActiveTab('files')" >
                    <font-awesome-icon icon="file" />
                    Pliki
                </b-nav-item>
                <b-nav-item v-if="canManageMod" :active="active === 'authorsMenu'" @click="setActiveTab('authorsMenu')">
                    <font-awesome-icon icon="cogs" />
                    Dla autora
                </b-nav-item>
            </b-nav>

            <div class="container mod-item">
                <div v-if="active === 'description'">
                    <div v-html="mod.description"></div>
                </div>

                <div v-if="active === 'pictures'">
                    <modification-gallery v-on:complete-loading="loadingComplete" v-if="mod.id !== undefined" :modification="mod"></modification-gallery>
                </div>

                <div v-if="active === 'videos'">
                    <modification-videos v-on:complete-loading="loadingComplete" v-if="mod.id !== undefined" :modification="mod"></modification-videos>
                </div>

                <div v-if="active === 'news'">
                    <display-multiple-news v-on:complete-loading="loadingComplete" :canManageMod="canManageMod" :passedMod="mod"></display-multiple-news>
                </div>

                <div class="text-dark" v-if="active === 'reviews'">
                    <router-link :to="{ name: 'modification_create_rating', params: { mod: mod.id } }">
                        <b-button block="true" class="p-3 mb-3 add-review-button" size="md" variant="success">
                            <font-awesome-icon icon="plus" />
                            Dodaj swoją opinię
                        </b-button>
                    </router-link>

                    <display-ratings v-on:complete-loading="loadingComplete" :passedMod="mod"></display-ratings>
                </div>

                <div class="text-dark" v-if="active === 'files'">
                    <modification-files v-on:complete-loading="loadingComplete" :canManageMod="canManageMod" v-if="mod.id !== undefined" :modification="mod"></modification-files>
                </div>

                <div v-if="active === 'authorsMenu'">
                    <div class="container jumbotron dark-jumbotron">
                        <h3>To menu widoczne jest wyłącznie dla autorów modyfikacji. Z jego poziomu możesz zarządzać wszystkimi elementami swojego moda.</h3>
                        <modification-author-menu v-on:complete-loading="loadingComplete" :mod="mod"></modification-author-menu>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import routeMixin from '../../../route-mixin.js';
    import ModificationFiles from "../file/ModificationFiles";
    import ModificationGallery from "./ModificationGallery";
    import ModificationAuthorMenu from './ModificationAuthorMenu';
    import ModificationVideos from '../video/ModificationVideos';
    import DisplayTotalRating from '../rating/DisplayTotalRating';
    import DisplayRatings from "../rating/DisplayRatings";
    import DisplayMultipleNews from '../news/DisplayMultipleNews';
    import DisplayTimestamps from '../../DisplayTimestamps';

    // Import component
    import Loading from 'vue-loading-overlay';
    // Import stylesheet
    import 'vue-loading-overlay/dist/vue-loading.css';

    export default {
        components: {
            DisplayRatings, DisplayTimestamps,
            ModificationFiles, ModificationGallery, ModificationAuthorMenu, ModificationVideos, DisplayTotalRating, DisplayMultipleNews,
            Loading
        },
        mixins: [ routeMixin ],
        props: ['modPassed'],

        data() {
            return {
                mod: [],
                active: 'description',
                userId: window.window.user_id,
                canManageMod: false,
                isLoading: false,
            }
        },
        computed: {
            splashImageStyle() {
                return {
                    'background-image': `url("${this.mod.splash}")`,
                    'background-repeat': 'no-repeat',
                    'background-color': 'black',
                    'background-size': 'cover',
                    'margin': 'auto',
                    'opacity': '0.95',
                }
            },
            splashDetailsStyle() {
                return {
                    'background-color': this.mod.color_splash_background + ' !important',
                    'opacity': this.mod.transparency_splash_background + ' !important',
                    'color': this.mod.font_color_splash_text,
                    'padding': '15px',
                }
            },
            descriptionStyle() {
                return {
                    'background-color': this.mod.color_description_background + ' !important',
                    'opacity': this.mod.transparency_description_background + ' !important',
                    'color': this.mod.font_color_description + ' !important',
                }
            },
            backgroundImageStyle() {
                return {
                    'background-image': `url("${this.mod.background}")`,
                    'background-repeat': 'no-repeat',
                    'height': '100%',
                    'background-size': 'cover',
                    'background-color': '#464646' // if no image is specified
                }
            },
            fontTitle() {
                return {
                    'color': this.mod.font_color === null ? '#FFFFFF' : this.mod.font_color + ' !important',
                }
            },
        },
        methods: {
            assignData({mod, canManageMod}) {
                this.mod = mod;
                this.canManageMod = canManageMod;
                this.$emit('set-mod-link', this.mod.game_id, this.mod.category_id, this.mod.id);
            },
            loadingComplete() {
                this.isLoading = false;
            },
            setActiveTab(value) {
                this.active = value;
                if (value === 'description') {
                    return;
                }
                this.isLoading = true;
            }
        },
        mounted: function() {
            if (this.modPassed !== undefined) {
                this.mod = this.modPassed;
            }
        }
    }
</script>
<style>
    .bg-semi-transparent {
        background-color: rgba(124, 124, 124, 0.84);
    }
    .bg-semi-transparent-details {
        background-color: rgba(0, 0, 0, 0.8);
    }
    .mod-item {
        padding-top: 1rem;
    }
    .add-review-button > a {
        color: white;
    }
    .navigation-buttons > .nav-item > a {
        color: white;
    }
    .dark-jumbotron {
        color: #e3e3e3;
        background-color: #464646;
    }
    .mod-info-value {
        font-weight: bold;
    }
</style>