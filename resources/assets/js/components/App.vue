<template>
    <div>
        <header>
            <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
                <b-navbar-brand class="navbar-brand" to="/home">{{ current_module_name }}</b-navbar-brand>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Włącz/wyłącz menu">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbar">
                    <ul v-if="current_module === 'mods'" class="navbar-nav mr-auto">
                        <li v-if="game" class="nav-item active">
                            <router-link :to="{name: 'game_mods', params: {game: game}}">
                                <a class="nav-link">Mody do gry {{ game_title }}</a>
                            </router-link>
                        </li>
                        <li v-if="category" class="nav-item">
                            <router-link :to="{name: 'mods_category', params: {game: game, category: category}}">
                                <a class="nav-link">Kategoria: {{ category_title }}</a>
                            </router-link>
                        </li>
                        <li v-if="subcategories && subcategories.length > 0" class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Podkategorie</a>
                            <div v-on:click.stop class="dropdown-menu" aria-labelledby="dropdown01">
                                <display-subcategories :subcategory=true v-if="subcategories && subcategories !== []" :categories="subcategories" :gameid="game"></display-subcategories>
                            </div>
                        </li>
                        <li v-if="mod" class="nav-item">
                            <router-link :to="{name: 'modification_view', params: {mod: mod}}">
                                <a class="nav-link">Modyfikacja: {{ mod_title }}</a>
                            </router-link>
                        </li>
                    </ul>
                    <template v-if="current_module === 'game'">
                        <b-navbar-nav>
                            <b-nav-item to="/game" exact>
                                <font-awesome-icon icon="gamepad"/>
                                Games
                            </b-nav-item>
                        </b-navbar-nav>
                        <b-navbar-nav class="ml-auto">
                            <b-nav-form @submit.prevent="onSearchSubmit">
                                <b-form-input size="sm" class="mr-sm-2" type="text" placeholder="Search" v-model="phrase"></b-form-input>
                                <b-button size="sm" class="mr-sm-2" type="submit"
                                          :disabled="phrase.length===0" @submit.prevent="onSubmit"
                                >
                                    Search
                                </b-button>
                            </b-nav-form>
                        </b-navbar-nav>
                    </template>
                    <template v-else-if="current_module === 'none'">
                        <b-navbar-nav>
                            <b-nav-item to="/game">
                                <font-awesome-icon icon="gamepad"/>
                                Games
                            </b-nav-item>
                            <b-nav-item to="/mods/1"> <!-- TODO -->
                                <font-awesome-icon icon="cogs"/>
                                Mods
                            </b-nav-item>
                            <b-nav-item to="/dev-studios/1/mods"> <!-- TODO -->
                                <font-awesome-icon icon="desktop"/>
                                Development Studios
                            </b-nav-item>
                        </b-navbar-nav>
                    </template>
                    <template v-if="!isLogged">
                        <b-navbar-nav :class="$route.path.startsWith('/game') ? '' : 'ml-auto'">
                            <b-button :to="{name: 'login'}" variant="outline-success" class="my-sm-0 my-2">
                                <font-awesome-icon icon="user" />
                                Logowanie
                            </b-button>
                        </b-navbar-nav>
                    </template>
                    <template v-else>
                        <b-navbar-nav :class="['mr-2', 'ml-2', $route.path.startsWith('/game') ? '' : 'ml-auto']">
                            <router-link v-if="current_module === 'mods'" :to="{name: 'user_mods', params: {user: userId} }">
                                <b-btn class="mr-2" variant="success">
                                    <font-awesome-icon icon="file" />
                                    Moje modyfikacje
                                </b-btn>
                            </router-link>
                            <b-nav-text class="mr-2">Welcome, {{username}}!</b-nav-text>
                            <b-dropdown variant="link" size="sm">
                                <template slot="button-content">
                                    <b-img v-if="gravatar" rounded="circle" :src="`${gravatar}&s=30`" class="mr-1"></b-img>
                                </template>
                                <b-dd-item :to="{name: 'my_profile'}">
                                    <font-awesome-icon icon="user"/>
                                    Mój Profil
                                </b-dd-item>
                                <b-dd-item v-if="userId !== undefined && userId !== null && userId !== ''" :to="{name: 'user_mods', params: {user: userId} }">
                                    <font-awesome-icon icon="file" />
                                    Moje modyfikacje
                                </b-dd-item>
                                <b-dd-divider></b-dd-divider>
                                <b-dropdown-item-button @click="logout" style="cursor: pointer;">
                                    <font-awesome-icon icon="door-closed"/>
                                    Logout
                                </b-dropdown-item-button>
                            </b-dropdown>
                        </b-navbar-nav>
                    </template>
                    <form
                            style="display: none;"
                            action="/logout"
                            method="POST"
                            id="logout"
                    >
                        <input type="hidden" name="_token" :value="csrf_token"/>
                    </form>
                </div>
            </nav>
        </header>

        <router-view v-on:set-mod-link="setModLink" :key="$route.fullPath"></router-view>

        <vue-footer></vue-footer>
    </div>
</template>
<script>
    import VueFooter from './VueFooter.vue';
    import DisplaySubcategories from './mods/category/DisplaySubcategories';
    import { Auth } from "../auth";
    import { EventBus } from '../event-bus';

    export default {
        components: {
            DisplaySubcategories,
            VueFooter
        },
        data() {
            return {
                auth: null,
                current_module: '',
                current_module_name: '',
                game: null,
                game_title: '',
                category: null,
                category_title: '',
                mod: null,
                mod_title: '',
                subcategories: null,
                phrase: '',
                isLogged: Auth.isLoggedIn(),
                username: Auth.getUser(),
                gravatar: null,
                subcategoriesData: null,
                userId: Auth.getId(),
                csrf_token: window.window.csrf_token
            };
        },
        methods: {
            setModLink: function(game, category = null, mod = null) {
                if (this.game !== game) {
                    axios.get('/api/mods/' + game + '/get-title').then(({data}) => {
                        this.game_title = data;
                    });
                    this.game = game;
                }
                if (this.category !== category) {
                    if (category !== null) {
                        axios.get('/api/mods/category/' + category + '/get-title').then(({data}) => {
                            this.category_title = data;
                        });
                        axios.get('/api/mods/category/' + category + '/subcategories').then(({data}) => {
                            this.subcategoriesData = data;
                            this.subcategories = data.data;
                        });
                    }
                    this.category = category;
                }
                if (mod && this.mod !== mod) {
                    if (mod !== null) {
                        axios.get('/api/mods/modifications/' + mod + '/get-title').then(({data}) => {
                            this.mod_title = data;
                        });
                    }
                    this.mod = mod;
                }
            },
            onSearchSubmit() {
                this.$router.push({
                    name: 'search_results',
                    query: {
                        phrase: this.phrase
                    }
                });
                this.phrase = '';
            },
            logout() {
                Auth.logout();
                document.getElementById('logout').submit();
                // this.$router.push({'name': 'login', query: {redirect: this.$route.fullPath}});
            },
            setCurrentModule() {
                if (this.$route.path.startsWith('/mods')) {
                    this.current_module = 'mods';
                    this.current_module_name = 'Portal modyfikacji';
                } else if (this.$route.path.startsWith('/dev-studios') || this.$route.path.startsWith('/devstudios')) {
                    this.current_module = 'teams';
                    this.current_module_name = 'Portal developmentu';
                } else if (this.$route.path.startsWith('/game')) {
                    this.current_module = 'game';
                    this.current_module_name = 'Portal gier';
                } else {
                    this.current_module = 'none';
                    this.current_module_name = 'Portal gier i modyfikacji';
                }
            }
        },
        beforeUpdate () {
            this.setCurrentModule();
        },
        beforeMount() {
            this.setCurrentModule();
            if (Auth.isLoggedIn()) {
                this.username = Auth.getUser();
                this.gravatar = Auth.getUserGravatar();
                this.userId = Auth.getId(); // TODO ???
            }
        },
        beforeRouteUpdate() {
            this.setCurrentModule();
        },
        mounted() {
            EventBus.$on('logged-out', () => {
               this.isLogged = false;
               this.username = null;
               this.gravatar = null;
            });
            EventBus.$on('logged-in', (user, gravatar) => {
                this.isLogged = true;
                this.username = user;
                this.gravatar = gravatar;
            });
            EventBus.$on('gravatar-received', gravatar => {
                console.log(`gravatar: ${gravatar}`);
                this.gravatar = gravatar;
            });
            EventBus.$on('user-updated', (user) => {
                this.username = user;
            });
        }
    }
</script>
<style>
    body {
        padding-top: 70px;
    }
    @media (max-width: 979px) {
        body {
            padding-top: 0px;
        }
    }
</style>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
