import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import ModsCategory from './components/ModsCategory.vue';
import GameModsCategories from './components/GameModsCategories.vue';
import ModificationDetails from './components/ModificationDetails';
import Login from './components/Login';
import CategoryCreate from './components/CategoryCreate';
import ModificationCreate from './components/ModificationCreate';
import ModificationUpdate from './components/ModificationEdit';
import ModificationCreateFiles from './components/ModificationCreateFiles';

export default new VueRouter({
    mode: 'history',
    routes: [
        {path: '/mods/:game', component: GameModsCategories, name: 'game_mods'},
        {path: '/mods/:game/category/:category', component: ModsCategory, name: 'mods_category'},
        {path: '/mods/:game/category/:category/create-modification', component: ModificationCreate, name: 'modification_create'},
        {path: '/mods/modifications/:mod', component: ModificationDetails, name: 'modification_view'},
        {path: '/mods/modifications/:mod/update', component: ModificationUpdate, name: 'modification_update'},
        {path: '/mods/modifications/:mod/create-files', component: ModificationCreateFiles, name: 'modification_create_files'},
        {path: '/login', component: Login, name: 'login'},
        {path: '/mods/:game/create-category/:category?', component: CategoryCreate, name: 'category_create'}
    ],
    scrollBehavior (to, from, savedPosition) {
        return { x: 0, y: 0 }
    }
});