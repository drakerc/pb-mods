import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import ModsCategory from './components/ModsCategory.vue';
import GameModsCategories from './components/GameModsCategories.vue';
import ModificationDetails from './components/ModificationDetails';

export default new VueRouter({
    mode: 'history',
    routes: [
        {path: '/mods/:game', component: GameModsCategories, name: 'game_mods'},
        {path: '/mods/:game/category/:category', component: ModsCategory, name: 'mods_category'},
        {path: '/mods/modifications/:mod', component: ModificationDetails, name: 'modification_view'}
    ],
    scrollBehavior (to, from, savedPosition) {
        return { x: 0, y: 0 }
    }
});