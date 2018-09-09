import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import ModsCategory from './components/ModsCategory.vue';
import GameModsCategories from './components/GameModsCategories.vue';


export default new VueRouter({
    mode: 'history',
    routes: [
        { path: '/mods/:game', component: GameModsCategories, name: 'game_mods' },
        { path: '/mods/:game/category/:category', component: ModsCategory, name: 'mods_category' }
    ],
    scrollBehavior (to, from, savedPosition) {
        return { x: 0, y: 0 }
    }
});