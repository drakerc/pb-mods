<template>
    <div>
        <header>
            <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
                <p class="navbar-brand">{{ current_module_name }}</p>
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
                                <display-subcategories :categoryId="category" :subcatData="subcategoriesData" :subcategory=true v-if="subcategories && subcategories !== []" :categories="subcategories" :gameid="game"></display-subcategories>
                            </div>
                        </li>
                        <li v-if="mod" class="nav-item active">
                            <router-link :to="{name: 'modification_view', params: {mod: mod}}">
                                <a class="nav-link">Modyfikacja: {{ mod_title }}</a>
                            </router-link>
                        </li>
                    </ul>
                    <router-link v-if="userId !== ''" :to="{name: 'user_mods', params: {user: userId} }">
                        <button class="btn btn-success m-3 my-2 my-sm-0">
                            <font-awesome-icon icon="file" />
                            Moje modyfikacje
                        </button>
                    </router-link>
                    <router-link :to="{name: 'login'}">
                        <button class="btn btn-primary m-3 my-2 my-sm-0">
                            <font-awesome-icon icon="user" />
                            Logowanie
                        </button>
                    </router-link>
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
                subcategoriesData: null,
                userId: window.window.user_id,
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
            }
        },
        beforeUpdate () {
            if (this.$route.path.startsWith('/mods')) {
                this.current_module = 'mods';
                this.current_module_name = 'Portal modyfikacji';
            } else if (this.$route.path.startsWith('/devstudios')) {
                this.current_module = 'devstudios';
                this.current_module_name = 'Portal developmentu';
            } else {
                // bairei if needed
            }
        }
    }
</script>
<style>
    body {
        padding-top: 80px;
    }
    @media (max-width: 979px) {
        body {
            padding-top: 0px;
        }
    }
</style>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
