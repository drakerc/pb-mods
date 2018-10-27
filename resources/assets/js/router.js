import Vue from 'vue';
import VueRouter from 'vue-router';
import { Auth } from "./auth";

import ModsCategory from './components/mods/category/ModsCategory.vue';
import GameModsCategories from './components/GameModsCategories.vue';
import ModificationDetails from './components/mods/modification/ModificationDetails';
import Login from './components/Login';
import GameDetails from './components/game/GameDetails';
import GameIndex from './components/game/GameIndex';
import Header from './components/game/Header';
import PostDetails from './components/game/blog/post/PostDetails';
import CategoryCreate from './components/mods/category/CategoryCreate';
import ModificationCreate from './components/mods/modification/ModificationCreate';
import ModificationUpdate from './components/mods/modification/ModificationEdit';
import ModificationCreateFiles from './components/mods/file/ModificationCreateFiles';
import ModificationCreateImages from './components/mods/file/ModificationCreateImages';
import ModificationEditFiles from './components/mods/file/ModificationEditFiles';
import ModificationEditImages from './components/mods/file/ModificationEditImages';
import SearchResults from './components/game/SearchResults';
import ModificationCreateVideos from './components/mods/video/ModificationCreateVideos';
import ModificationEditVideos from './components/mods/video/ModificationEditVideos';
import ModificationCreateRating from './components/mods/rating/CreateRating';
import ModificationDisplayRatings from './components/mods/rating/DisplayRatings';
import ModificationEditRating from './components/mods/rating/EditRating';
import PostForm from './components/game/blog/post/PostForm';
import GameForm from './components/game/GameForm';
import ModificationEditSplashImages from './components/mods/file/ModificationEditSplashImages';
import ModificationEditBackgroundImages from './components/mods/file/ModificationEditBackgroundImages';
import ModificationCreateNews from './components/mods/news/CreateNews';
import ModificationCreateInstruction from './components/mods/instruction/Create';

Vue.use(VueRouter);

export const router = new VueRouter({
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
        {path: '/mods/modifications/:mod/edit-splash-images', component: ModificationEditSplashImages, name: 'modification_edit_splash_images'},
        {path: '/mods/modifications/:mod/edit-background-images', component: ModificationEditBackgroundImages, name: 'modification_edit_background_images'},
        {path: '/mods/modifications/:mod/edit-news', component: ModificationCreateNews, name: 'modification_create_news'},
        {path: '/mods/modifications/:mod/edit-news/:news', component: ModificationCreateNews, name: 'modification_edit_news'},
        {path: '/mods/modifications/:mod/files/:file/edit-instruction', component: ModificationCreateInstruction, name: 'modification_create_instruction'},
        {path: '/mods/modifications/:mod/files/:file/edit-instruction/:instruction', component: ModificationCreateInstruction, name: 'modification_edit_instruction'},
        {path: '/mods/modifications/:mod/create-videos', component: ModificationCreateVideos, name: 'modification_create_videos'},
        {path: '/mods/modifications/:mod/edit-videos', component: ModificationEditVideos, name: 'modification_edit_videos'},
        {path: '/mods/modifications/:mod/create-rating', component: ModificationCreateRating, name: 'modification_create_rating'},
        {path: '/mods/modifications/:mod/ratings', component: ModificationDisplayRatings, name: 'modification_ratings'},
        {path: '/mods/modifications/:mod/ratings/:rating/edit', component: ModificationEditRating, name: 'modification_edit_rating'},
        {path: '/login', component: Login, name: 'login'},
        {path: '/mods/:game/create-category/:category?', component: CategoryCreate, name: 'category_create'},
        {
            path: '/game',
            component: Header,
            children: [
                {
                    path: '',
                    component: GameIndex,
                    name: 'game_index'
                },
                {
                    path: 'new',
                    component: GameForm,
                    name: 'new_game_form',
                    meta: {
                        requiresAuth: true
                    }
                },
                {
                    path: 'search/results',
                    component: SearchResults,
                    name: 'search_results',
                },
                {
                    path: ':id',
                    component: GameDetails,
                    name: 'game_details'
                },
                {
                    path: ':id/post/new',
                    component: PostForm,
                    name: 'post_form',
                    meta: {
                        requiresAuth: true
                    }
                },
                {
                    path: ':gameId/post/:id',
                    component: PostDetails,
                    name: 'post_details'
                },
            ]
        },

    ],
    scrollBehavior (to, from, savedPosition) {
        return { x: 0, y: 0 }
    }
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (!Auth.isLoggedIn()) {
            next({
                path: '/login',
                query: { redirect: to.fullPath }
            });
            return;
        }
    }
    next();
});