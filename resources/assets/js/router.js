import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import ModsCategory from './components/mods/category/ModsCategory.vue';
import GameModsCategories from './components/GameModsCategories.vue';
import ModificationDetails from './components/mods/modification/ModificationDetails';
import Login from './components/Login';
import GameDetails from './components/game/GameDetails';
import GameIndex from './components/game/GameIndex';
import Header from './components/game/Header';
import PostDetails from './components/game/blog/PostDetails';
import CategoryCreate from './components/mods/category/CategoryCreate';
import ModificationCreate from './components/mods/modification/ModificationCreate';
import ModificationUpdate from './components/mods/modification/ModificationEdit';
import ModificationCreateFiles from './components/mods/file/ModificationCreateFiles';
import ModificationCreateImages from './components/mods/file/ModificationCreateImages';
import ModificationEditFiles from './components/mods/file/ModificationEditFiles';
import ModificationEditImages from './components/mods/file/ModificationEditImages';

export default new VueRouter({
    mode: 'history',
    routes: [
        {path: '/mods/:game', component: GameModsCategories, name: 'game_mods'},
        {path: '/mods/:game/category/:category', component: ModsCategory, name: 'mods_category'},
        {path: '/mods/:game/category/:category/create-modification', component: ModificationCreate, name: 'modification_create'},
        {path: '/mods/modifications/:mod', component: ModificationDetails, name: 'modification_view'},
        {path: '/mods/modifications/:mod/update', component: ModificationUpdate, name: 'modification_update'},
        {path: '/mods/modifications/:mod/create-files', component: ModificationCreateFiles, name: 'modification_create_files'},
        {path: '/mods/modifications/:mod/edit-files', component: ModificationEditFiles, name: 'modification_edit_files'},
        {path: '/mods/modifications/:mod/create-images', component: ModificationCreateImages, name: 'modification_create_images'},
        {path: '/mods/modifications/:mod/edit-images', component: ModificationEditImages, name: 'modification_edit_images'},
        {path: '/login', component: Login, name: 'login'},
        {path: '/mods/:game/create-category/:category?', component: CategoryCreate, name: 'category_create'},
        {
            path: '/game',
            component: Header,
            children: [
                { path: '', component: GameIndex, name: 'game_index' },
                { path: ':id', component: GameDetails, name: 'game_details' },
                { path: ':game_id/post/:id', component: PostDetails, name: 'post_details'}
            ]
        },
    ],
    scrollBehavior (to, from, savedPosition) {
        return { x: 0, y: 0 }
    }
});