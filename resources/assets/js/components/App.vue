<template>
    <div>
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <b-navbar-brand class="navbar-brand" to="/home">{{ current_module_name }}</b-navbar-brand>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Włącz/wyłącz menu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbar">
                <ul v-if="current_module === 'mods'" class="navbar-nav mr-auto">
                    <li v-if="game" class="nav-item active">
                        <router-link :to="{name: 'game_mods', params: {game: game}}">
                            <a class="nav-link">Mody do gry {{ game_title }} > </a>
                        </router-link>
                    </li>
                    <li v-if="category" class="nav-item">
                        <router-link :to="{name: 'mods_category', params: {game: game, category: category}}">
                            <a class="nav-link">Kategoria: {{ category_title }} > </a>
                        </router-link>
                    </li>
                    <li v-if="mod" class="nav-item">
                        <router-link :to="{name: 'modification_view', params: {mod: mod}}">
                            <a class="nav-link">Modyfikacja: {{ mod_title }}</a>
                        </router-link>
                    </li>
                    <li v-if="subcategories && subcategories.length > 0" class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Podkategorie</a>
                        <div v-on:click.stop class="dropdown-menu" aria-labelledby="dropdown01">
                            <display-subcategories :subcategory=true v-if="subcategories && subcategories !== []" :categories="subcategories" :gameid="game"></display-subcategories>
                        </div>
                    </li>
                </ul>
                <template v-if="current_module === 'game'">
                    <b-navbar-nav>
                        <b-nav-item to="/game" exact>Games</b-nav-item>
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
                        <b-nav-item to="/game">Games</b-nav-item>
                        <!--<b-nav-item to="/mods/1">Mods</b-nav-item>-->
                    </b-navbar-nav>
                </template>
                <template v-if="!isLogged">
                    <b-button :to="{name: 'login'}" variant="outline-success" :class="['my-2','my-sm-0', $route.path.startsWith('/login') ? 'ml-auto': '']">Logowanie</b-button>
                </template>
                <template v-else>
                    <b-navbar-nav :class="$route.path.startsWith('/home') ? 'ml-auto' : ''">
                        <b-nav-text class="mr-1">Welcome, {{username}}!</b-nav-text>
                        <b-btn variant="outline-warning" @click="logout">Logout</b-btn>
                    </b-navbar-nav>
                </template>
            </div>
        </nav>
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
                username: Auth.getUser()
            }
        },
        methods: {
            setModLink: function(game, category = null, mod = null) {
                console.log('xx')
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
                            this.subcategories = data;
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
                this.$router.push({'name': 'login', query: {redirect: this.$route.fullPath}});
            },
            setCurrentModule() {
                if (this.$route.path.startsWith('/mods')) {
                    this.current_module = 'mods';
                    this.current_module_name = 'Portal modyfikacji';
                } else if (this.$route.path.startsWith('/teams')) {
                    this.current_module = 'teams';
                    this.current_module_name = 'Portal developmentu';
                } else if (this.$route.path.startsWith('/game')) {
                    this.current_module = 'game';
                    this.current_module_name = 'Portal gier';
                } else {
                    this.current_module = 'none';
                    this.current_module_name = null;
                }
            }
        },
        beforeUpdate () {
            this.setCurrentModule();
        },
        beforeMount() {
            this.setCurrentModule();
        },
        beforeRouteUpdate() {
            console.log('update');
            this.setCurrentModule();
        },
        mounted() {
            EventBus.$on('logged-out', () => {
               this.isLogged = false;
               this.username = null;
            });
            EventBus.$on('logged-in', (user) => {
                this.isLogged = true;
                this.username = user;
            })
        }
    }
</script>
<style>
    body {
        padding-top: 60px;
    }
    @media (max-width: 979px) {
        body {
            padding-top: 0px;
        }
    }
</style>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
